<?php
session_start();
if (!isset($_SESSION['access'])) header('Location: login.php');
print_r($_SESSION);
session_destroy();
?>