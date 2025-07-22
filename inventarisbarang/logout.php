<?php
session_start();
session_destroy();
header('location:login.php'); // Redirect ke halaman login
exit();
?>