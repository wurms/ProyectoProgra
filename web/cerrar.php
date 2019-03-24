<?php
	session_start();
	session_destroy();
	header("location: loginusuario.php");
	exit();
?>