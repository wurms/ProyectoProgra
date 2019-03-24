<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=1){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
}
date_default_timezone_set('America/Dawson');

if (isset($_GET['filtro'])) {
  $filtro = $_GET['filtro'];
  if ($filtro != 0 && $filtro != 1) {
    $sconsulta = "SELECT * FROM tbsucursal WHERE sid='$filtro'";
  } else {
    $sconsulta = "SELECT * FROM tbsucursal WHERE sid!='1'";
  }
} else {
  header("location: reporteen.php");
  exit();
}

$hoy = date('m/d/o');

require('../fpdf/fpdf.php');

$pdf = new FPDF('L','mm','Legal');
$pdf->AddPage();

$pdf->SetFont('Arial','B',9);
$pdf->Cell(335,5,utf8_decode("Pawnshop S.A de C.V"),0,1,'R',0);
$pdf->Cell(335,5,utf8_decode("Pieces Report order by Branch"),0,1,'R',0);
$pdf->Cell(335,5,utf8_decode("Date: ".$hoy),0,1,'R',0);
$pdf->Image('../img/ps.jpg',20,2.5,35);



$pdf->Ln(5);
$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(255,255,204);
$pdf->Cell(335,15,utf8_decode("Pieces Report"),0,0,'C',1);
$pdf->Ln(20);


$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(192,192,192);
$pdf->Cell(41.87,10,utf8_decode('Amount'),0,0,'C',1);
$pdf->Cell(41.87,10,utf8_decode('Characteristics'),0,0,'C',1);
$pdf->Cell(41.87,10,utf8_decode('Weight'),0,0,'C',1);
$pdf->Cell(41.87,10,utf8_decode('Caratage'),0,0,'C',1);
$pdf->Cell(41.87,10,utf8_decode('Quality'),0,0,'C',1);
$pdf->Cell(41.87,10,utf8_decode('Gemstone'),0,0,'C',1);
$pdf->Cell(41.87,10,utf8_decode('Value'),0,0,'C',1);
$pdf->Cell(41.87,10,utf8_decode('Loan'),0,1,'C',1);
$pdf->Ln(2);

foreach ($con->query($sconsulta) as $key) {
  $pdf->SetFont('Arial','B',8);
  $pdf->SetFillColor(192,192,192);
  $pdf->Cell(335,10,utf8_decode('Pieces from: '.$key['nombre']),0,1,'L',1);
  $pdf->Ln(1);
  $sid = $key['sid'];
  $cconsulta = "SELECT * FROM tbprenda WHERE sid='$sid'";
  foreach ($con->query($cconsulta) as $key) {
    $pdf->SetFont('Arial','',9);
    $pdf->SetFillColor(224,224,224);
    $pdf->Cell(41.87,10,utf8_decode($key['cantidad']),0,0,'C',1);
    $pdf->Cell(41.87,10,utf8_decode($key['caracteristicas']),0,0,'C',1);
    $pdf->Cell(41.87,10,utf8_decode($key['peso'].'kg'),0,0,'C',1);
    $pdf->Cell(41.87,10,utf8_decode($key['kilataje']),0,0,'C',1);
    $pdf->Cell(41.87,10,utf8_decode($key['calidad']),0,0,'C',1);
    $pdf->Cell(41.87,10,utf8_decode($key['piedra']),0,0,'C',1);
    $pdf->Cell(41.87,10,utf8_decode('$'.$key['avaluo']),0,0,'C',1);
    $pdf->Cell(41.87,10,utf8_decode('$'.$key['prestamo']),0,1,'C',1);
    $pdf->Ln(1);
  }
}

 $pdf->Output();
?>
