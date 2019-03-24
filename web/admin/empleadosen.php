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
  if ($filtro != 0) {
    $sconsulta = "SELECT * FROM tbsucursal WHERE sid='$filtro'";
  } else {
    $sconsulta = "SELECT * FROM tbsucursal";
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
$pdf->Cell(335,5,utf8_decode("Employees Report order by Branch"),0,1,'R',0);
$pdf->Cell(335,5,utf8_decode("Date: ".$hoy),0,1,'R',0);
$pdf->Image('../img/ps.jpg',20,2.5,35);

$pdf->Ln(5);
$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(255,255,204);
$pdf->Cell(335,15,utf8_decode("Employees Report"),0,0,'C',1);
$pdf->Ln(20);


$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(192,192,192);
$pdf->Cell(37.22,10,utf8_decode('Name'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Lastname'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Phone Numnber'),0,0,'C',1);
$pdf->Cell(36,10,utf8_decode('DUI'),0,0,'C',1);
$pdf->Cell(39.66,10,utf8_decode('Email'),0,0,'C',1);
$pdf->Cell(36,10,utf8_decode('Status'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Salary'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Username'),0,0,'C',1);
$pdf->Cell(37.22,10,utf8_decode('Charge'),0,1,'C',1);
$pdf->Ln(2);

foreach ($con->query($sconsulta) as $key) {
  $pdf->SetFont('Arial','B',8);
  $pdf->SetFillColor(192,192,192);
  $pdf->Cell(335,10,utf8_decode('Employees from: '.$key['nombre']),0,1,'L',1);
  $pdf->Ln(1);
  $sid = $key['sid'];
  $econsulta = "SELECT * FROM tbempleado WHERE sid='$sid'";
  foreach ($con->query($econsulta) as $key) {
    if ($key['habilitado'] == 1) {
      $estado = 'Enable';
    } else {
      $estado = 'Disable';
    }
    if ($key['nivel'] == 2) {
      $cargo = "Accountant";
    } elseif ($key['nivel'] == 3) {
      $cargo = "Manager";
    } elseif ($key['nivel'] == 4) {
      $cargo = "Teller";
    } else {
      $cargo = "Employee";
    }
    $pdf->SetFont('Arial','',9);
    $pdf->SetFillColor(224,224,224);
    $pdf->Cell(37.22,7,utf8_decode($key['nombre']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['apellido']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['telefono']),0,0,'C',1);
    $pdf->Cell(33,7,utf8_decode($key['dui']),0,0,'C',1);
    $pdf->Cell(45.66,7,utf8_decode($key['correo']),0,0,'C',1);
    $pdf->Cell(33,7,utf8_decode($estado),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode('$'.$key['sueldo']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($key['usuario']),0,0,'C',1);
    $pdf->Cell(37.22,7,utf8_decode($cargo),0,1,'C',1);
    $pdf->Ln(1);
  }
}

 $pdf->Output();
?>
