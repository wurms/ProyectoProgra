<?php
	$server = "localhost";
	$user = "root";
	$password = "";
	$db = "dbpawnshop";

	$con = new mysqli($server,$user,$password,$db);

	if($con){
		//echo "¡Conexión exitosa!";
	}else{
		echo "¡Conexión fallida!";
	}
?>