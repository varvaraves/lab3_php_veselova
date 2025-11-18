 <?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

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

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bg_color = $_POST['bg_color'];
    $text_color = $_POST['text_color'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("UPDATE users SET bg_color = ?, text_color = ? WHERE id = ?");
    if ($stmt->execute([$bg_color, $text_color, $user_id])) {
        $_SESSION['bg_color'] = $bg_color;
        $_SESSION['text_color'] = $text_color;

        setcookie('bg_color', $bg_color, time() + (86400 * 30), "/");
        setcookie('text_color', $text_color, time() + (86400 * 30), "/");

        $message = "Settings updated successfully!";
    } else {
        $message = "Failed to update settings.";
    }
}

$bg_color = $_SESSION['bg_color'] ?? '#ffffff';
$text_color = $_SESSION['text_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
     <style>
        body {
            background-color: <?php echo htmlspecialchars($bg_color); ?>;
            color: <?php echo htmlspecialchars($text_color); ?>;
        }
    </style>
</head>
<body>
    <h2>User Settings</h2>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="bg_color">Background Color:</label><br>
        <input type="color" id="bg_color" name="bg_color" value="<?php echo $bg_color; ?>"><br><br>
        <label for="text_color">Text Color:</label><br>
        <input type="color" id="text_color" name="text_color" value="<?php echo $text_color; ?>"><br><br>
        <input type="submit" value="Update Settings">
    </form>
    <br>
    <a href="index.php">Go to Home</a> | <a href="logout.php">Logout</a>
</body>
</html>