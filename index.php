<?php
session_start();

$bg_color = $_SESSION['bg_color'] ?? $_COOKIE['bg_color'] ?? '#ffffff';
$text_color = $_SESSION['text_color'] ?? $_COOKIE['text_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
     <style>
        body {
            background-color: <?php echo htmlspecialchars($bg_color); ?>;
            color: <?php echo htmlspecialchars($text_color); ?>;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_SESSION['user_id'])) {
        echo "<p>Hi, user! You are logged in.</p>";
        echo "<a href='settings.php'>Settings</a> | <a href='logout.php'>Logout</a>";
    } else {
        echo "<p>You are not logged in.</p>";
        echo "<a href='login.html'>Login</a> | <a href='register.html'>Register</a>";
    }
    ?>
</body>
</html>