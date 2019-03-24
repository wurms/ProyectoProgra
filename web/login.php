<?php
include("conexion.php");
$usuario = $_POST['usuario'];
$password = $_POST['password'];

$consulclienteusuario = "SELECT * FROM tbcliente WHERE dui='$usuario'";
$varclienteusuario = $con->query($consulclienteusuario)->fetch_all();

$consulempleadousuario = "SELECT * FROM tbempleado WHERE usuario='$usuario'";
$varempleadousuario = $con->query($consulempleadousuario)->fetch_all();

$consuladminusuario = "SELECT * FROM tbadmin WHERE usuario='$usuario'";
$varadminusuario = $con->query($consuladminusuario)->fetch_all();

if ($varadminusuario) {
	$password = md5($password);
	$consuladminpassword = "SELECT * FROM tbadmin WHERE usuario='$usuario' AND password='$password'";
	$varadminpassword = $con->query($consuladminpassword)->fetch_all();
	if ($varadminpassword) {
		session_start();
		$_SESSION['aid'] = $varadminpassword[0][0];
		$_SESSION['nivel'] = 1;
		header("location: admin/index.php");
		exit();
	}else{
		header("location: loginusuario.php?msg=2");
		exit();
	}
}elseif($varclienteusuario){
	$consulclientepassword = "SELECT * FROM tbcliente WHERE dui='$usuario' AND password='$password'";
	$varclientepassword = $con->query($consulclientepassword)->fetch_all();
	if($varclientepassword){
		session_start();
		$_SESSION['cid'] = $varclientepassword[0][0];
		$_SESSION['estado'] = $varclientepassword[0][13];
		$_SESSION['nivel'] = 6;
		$_SESSION['email'] = $varclientepassword[0][10];
		header("location: cliente/index.php");
		exit();
	}else{
		header("location: loginusuario.php?msg=2");
		exit();
	}
}elseif ($varempleadousuario) {
	$password = md5($password);
	$consulpasswordempleado = "SELECT * FROM tbempleado WHERE usuario='$usuario' AND password='$password'";
	$varpasswordempleado = $con->query($consulpasswordempleado)->fetch_all();
	if ($varpasswordempleado) {
		if ($varpasswordempleado[0][10]==2) {
			session_start();
			$_SESSION['eid'] = $varpasswordempleado[0][0];
			$_SESSION['habilitado'] = $varpasswordempleado[0][6];
			$_SESSION['nivel'] = 2;
			$_SESSION['sucursal'] = $varpasswordempleado[0][7];
			header("location: conta/index.php");
			exit();
		} elseif ($varpasswordempleado[0][10]==3) {
			session_start();
			$_SESSION['eid'] = $varpasswordempleado[0][0];
			$_SESSION['habilitado'] = $varpasswordempleado[0][6];
			$_SESSION['nivel'] = 3;
			$_SESSION['sucursal'] = $varpasswordempleado[0][7];
			header("location: encargado/index.php");
			exit();
		} elseif ($varpasswordempleado[0][10]==4) {
			session_start();
			$_SESSION['eid'] = $varpasswordempleado[0][0];
			$_SESSION['habilitado'] = $varpasswordempleado[0][6];
			$_SESSION['nivel'] = 4;
			$_SESSION['sucursal'] = $varpasswordempleado[0][7];
			header("location: cajero/index.php");
			exit();
		}
	}else{
		header("location: loginusuario.php?msg=2");
		exit();
	}
}else{
	header("location: loginusuario.php?msg=1");
	exit();
}
?>
