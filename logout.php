<?php
	session_start();
	header('location:index.php');
	unset($_SESSION['logged_in']);
	session_destroy();
?>