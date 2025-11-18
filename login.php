<?php
session_start();

$host = 'localhost';
$dbname = 'lab3_db';
$username_db = 'root';
$password_db = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, password_hash, bg_color, text_color FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['bg_color'] = $user['bg_color'];
            $_SESSION['text_color'] = $user['text_color'];

            setcookie('bg_color', $user['bg_color'], time() + (86400 * 30), "/");
            setcookie('text_color', $user['text_color'], time() + (86400 * 30), "/");

            echo "<p>Login successful!</p>";
            echo "<a href='index.php'>Go to Home</a>";
        } else {
            echo "<p>Invalid username or password!</p>";
            echo "<a href='login.html'>Try again</a>";
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
         echo "<a href='login.html'>Go back</a>";
    }
}
?>