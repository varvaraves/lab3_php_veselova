<?php
// Подключение к БД MAMP (обычно по умолчанию localhost:8889 для MySQL, root без пароля)
$host = 'localhost';
$dbname = 'lab3_db'; // Имя вашей базы данных
$username = 'root'; // Имя пользователя по умолчанию в MAMP
$password = '';     // Пароль по умолчанию в MAMP пустой

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $bg_color = $_POST['bg_color'];
    $text_color = $_POST['text_color'];

    if (!empty($username) && !empty($password)) {
        // Проверка уникальности имени пользователя (желательно)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
             echo "<p>Username already exists!</p>";
             exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, bg_color, text_color) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $hashed_password, $bg_color, $text_color])) {
            echo "<p>Registration successful!</p>";
            echo "<a href='login.html'>Go to Login</a>";
        } else {
            echo "<p>Registration failed!</p>";
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}
?>