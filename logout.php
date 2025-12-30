<?php
session_start();
include 'dbConfig.php';
unset($_SESSION['is_logged_in']);
session_destroy();
header("Location: ".BASE_URL . "login.php");
?>