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
    $sconsulta = "SELECT * FROM tbsucursal WHERE sid!=1";
  }
} else {
  header("location: reporte.php");
  exit();
}

$hoy = date('m/d/o');

require('../fpdf/fpdf.php');

$pdf = new FPDF('L','mm','Legal');
$pdf->AddPage();

$pdf->SetFont('Arial','B',9);
$pdf->Cell(335,5,utf8_decode("Pawnshop S.A de C.V"),0,1,'R',0);
$pdf->Cell(335,5,utf8_decode("Clients Report order by Branch"),0,1,'R',0);
$pdf->Cell(335,5,utf8_decode("Date: ".$hoy),0,1,'R',0);
$pdf->Image('../img/ps.jpg',20,2.5,35);

$pdf->Ln(5);
$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(255,255,204);
$pdf->Cell(335,15,utf8_decode("Clients Report"),0,0,'C',1);
$pdf->Ln(20);


$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(192,192,192);
$pdf->Cell(37.22,10,utf8_decode('DUI'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Name'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Lastname'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Address'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Phone Number'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('NIT'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Email'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Status'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Birthdate'),0,1,'C',1);
$pdf->Ln(2);


foreach ($con->query($sconsulta) as $key) {
  $pdf->SetFont('Arial','B',8);
  $pdf->SetFillColor(192,192,192);
  $pdf->Cell(335,10,utf8_decode('Clients from: '.$key['nombre']),0,1,'L',1);
  $pdf->Ln(1);
  $sid = $key['sid'];
  $cconsulta = "SELECT * FROM tbcliente WHERE sid='$sid'";
  foreach ($con->query($cconsulta) as $key) {
    if ($key['habilitado'] == 1) {
      $estado = 'Enable';
    } else {
      $estado = 'Disable';
    }
    $pdf->SetFont('Arial','',9);
    $pdf->SetFillColor(224,224,224);
    $pdf->Cell(37.22,7,utf8_decode($key['dui']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['nombre']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['apellido']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['direccion']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['telefono']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['nit']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['correo']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($estado),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['fechanac']),0,1,'C',1);
    $pdf->Ln(1);
  }
}

$pdf->Output();
?>
