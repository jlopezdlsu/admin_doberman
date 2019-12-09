<?php session_start(); /* Starts the session */
session_destroy(); /* Destroy started session */
$_SESSION = array();
header("location:login.php");
exit;
?>
