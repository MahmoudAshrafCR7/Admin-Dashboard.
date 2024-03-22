<?php
session_start();
unset($_SESSION['mans']);
header("Location:login.php");
?>

