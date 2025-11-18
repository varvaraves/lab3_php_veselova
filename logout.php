<?php
session_start();
session_unset(); 
session_destroy();
setcookie('bg_color', '', time() - 3600, '/');
setcookie('text_color', '', time() - 3600, '/');
header("Location: index.php");
exit;
?>