<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=1){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
}
date_default_timezone_set('America/Dawson');

$hoy = date('m/d/o');

require('../fpdf/fpdf.php');

$pdf = new FPDF('P','mm','Legal');
$pdf->AddPage();

$pdf->SetFont('Arial','B',9);
$pdf->Cell(196,5,utf8_decode("Pawnshop S.A de C.V"),0,1,'R',0);
$pdf->Cell(196,5,utf8_decode("Branches Report of the Company"),0,1,'R',0);
$pdf->Cell(196,5,utf8_decode("Date: ".$hoy),0,1,'R',0);
$pdf->Image('../img/ps.jpg',20,2.5,35);

$pdf->Ln(5);
$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(255,255,204);
$pdf->Cell(196,15,utf8_decode("Branches Report"),0,0,'C',1);
$pdf->Ln(20);


$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(192,192,192);
$pdf->Cell(39.2,10,utf8_decode('Branch ID'),0,0,'C',1);
$pdf->Cell(39.2,10,utf8_decode('Name'),0,0,'C',1);
$pdf->Cell(39.2,10,utf8_decode('Address'),0,0,'C',1);
$pdf->Cell(39.2,10,utf8_decode('Manager'),0,0,'C',1);
$pdf->Cell(39.2,10,utf8_decode('Phone Number'),0,1,'C',1);
$pdf->Ln(2);

$consulta = "SELECT * FROM tbsucursal WHERE sid!='1'";

foreach ($con->query($consulta) as $key) {
  $sid = $key['sid'];
  $econsulta = "SELECT * FROM tbempleado WHERE sid='$sid' AND nivel='3'";
  $evar = $con->query($econsulta)->fetch_array();

  $pdf->SetFont('Arial','',9);
  $pdf->SetFillColor(224,224,224);
  $pdf->Cell(39.2,7,utf8_decode($sid),0,0,'C',1);
  $pdf->Cell(39.2,7,utf8_decode($key['nombre']),0,0,'C',1);
  $pdf->Cell(39.2,7,utf8_decode($key['direccion']),0,0,'C',1);
  $pdf->Cell(39.2,7,utf8_decode($evar['nombre'].' '.$evar['apellido']),0,0,'C',1);
  $pdf->Cell(39.2,7,utf8_decode($key['telefono']),0,1,'C',1);
  $pdf->Ln(1);
}

 $pdf->Output();
?>
