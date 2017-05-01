<?php
require_once('functions/generics.php');
require_once('functions/validations.php');
require_once('functions/users.php');
require_once('html.php');
echo htmlHeader('Logout', 'Chau!');
echo navBar('CookIt');
unset($_SESSION['user']);
setcookie(REMEMBER_COOKIE_NAME, 0, time() -1000);
session_destroy();
header('location: login.php');
exit;


?>
