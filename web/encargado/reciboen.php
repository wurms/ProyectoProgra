<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=3){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
} elseif ($_SESSION['habilitado']!=1) {
  session_destroy();
  header("location: ../loginusuario.php?msg=4");
  exit();
}
date_default_timezone_set('America/Dawson');
if (isset($_POST['pid'])) {
	$pid = $_POST['pid'];
	$cprenda = "SELECT * FROM tbprenda WHERE pid='$pid'";
	$vprenda = $con->query($cprenda)->fetch_all();
	$sid = $vprenda[0][9];
	$eid = $vprenda[0][10];
	$cid = $vprenda[0][11];
	$csucursal = "SELECT * FROM tbsucursal WHERE sid='$sid'";
	$cempleado = "SELECT * FROM tbempleado WHERE eid='$eid'";
	$ccliente = "SELECT * FROM tbcliente WHERE cid='$cid'";
	$coperacion = "SELECT * FROM tboperacion WHERE oid='$pid'";
	$vsucursal = $con->query($csucursal)->fetch_all();
	$vempleado = $con->query($cempleado)->fetch_all();
	$vcliente = $con->query($ccliente)->fetch_all();
	$voperacion = $con->query($coperacion)->fetch_all();
}else{
	header("location: contratopen.php");
	exit();
}

if (!$voperacion) {
	header("location: contratopen.php");
	exit();
}

require('../fpdf/fpdf.php');

$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Image('../img/ps.jpg',20,2.5,25);

$pdf->Cell(125,10,'RECEIPT OF INCOME',0,0,'R');

$pdf->SetFont('Arial','',12);

$pdf->Cell(50,10,date('m/d/o'),0,1,'R');
$pdf->Ln();
$pdf->Cell(100,5,utf8_decode('Company: PAWNSHOP'),0,0,'L');
$pdf->Cell(100,5,utf8_decode('Branch: '.$vsucursal[0][1]),0,1,'L');
$pdf->Cell(100,5,utf8_decode('No. Piece: '.$pid),0,0,'L');
$pdf->Cell(100,5,utf8_decode('No. Pledge: '.$pid),0,1,'L');
$pdf->Cell(200,5,utf8_decode('Client: '.$vcliente[0][1].' '.$vcliente[0][2].' '.$vcliente[0][3].'.'),0,1,'L');
$pdf->Ln(20);
$pdf->Cell(50,5,utf8_decode('Amount: $'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][3]),0,0,'C');
$pdf->Cell(50,5,utf8_decode('Number of pieces:'),0,0,'R');
$pdf->Cell(50,5,utf8_decode('1'),0,1,'L');

$pdf->Cell(50,5,utf8_decode('Interest: $'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][4]),0,0,'C');
$pdf->Cell(50,5,utf8_decode('Starting Date:'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][2]),0,1,'L');

$pdf->Cell(50,5,utf8_decode('Storage: $'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][4]),0,0,'C');
$pdf->Cell(50,5,utf8_decode('Expiration Date:'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][5]),0,1,'L');

$pdf->Cell(50,5,utf8_decode('Insurance: $'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][4]),0,0,'C');
$pdf->Cell(50,5,utf8_decode('Period:'),0,0,'R');
$pdf->Cell(50,5,utf8_decode('1 Month'),0,1,'L');

$pdf->Cell(50,5,utf8_decode('Arrears: $'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][11]),0,1,'C');

$pdf->Cell(50,5,utf8_decode('VAT: $'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($voperacion[0][7]),0,1,'C');

$cancelado = ($voperacion[0][4]*3)+$voperacion[0][7]+$voperacion[0][11];
$pdf->Cell(50,5,utf8_decode('Amount Canceled: $'),0,0,'R');
$pdf->Cell(50,5,utf8_decode($cancelado),0,1,'C');
$pdf->Ln(20);

$eid = $_SESSION['eid'];
$varempleado = $con->query("SELECT * FROM tbempleado WHERE eid='$eid'")->fetch_array();

$pdf->Cell(200,5,utf8_decode('_________________________________________'),0,1,'R');
$pdf->Cell(180,5,utf8_decode('Signature and Stamp of the Manager'),0,1,'R');
$pdf->Cell(160,5,utf8_decode($varempleado['nombre'].' '.$varempleado['apellido']),0,1,'R');

$pdf->Output();
?>
