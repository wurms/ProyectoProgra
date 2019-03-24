<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=2){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
} elseif ($_SESSION['habilitado']!=1) {
    session_destroy();
    header("location: ../loginusuario.php?msg=4");
    exit();
}
if (isset($_GET['dia']) && isset($_GET['mes']) && isset($_GET['ano'])) {
  $dia = $_GET['dia'];
  $mes = $_GET['mes'];
  $ano = $_GET['ano'];

  $consulta = "SELECT * FROM tbreporte WHERE dia='$dia' AND mes='$mes' AND ano='$ano'";
  $var = $con->query($consulta)->fetch_array();

  if (!$var) {
    header("location: sreporte.php?msg=1");
    exit();
  }
} else {
  header("location: sreporte.php");
  exit();
}
require('../fpdf/fpdf.php');

$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Image('../img/ps.jpg',20,2.5,35);

$pdf->Ln(15);
$pdf->Cell(200,15,utf8_decode("Reporte de Operación"),0,1,'C');
$pdf->SetFont('Arial','B','10');
$pdf->Cell(50,15,utf8_decode("Correspondiente al"),0,0,'C');
$pdf->Cell(50,15,utf8_decode($mes."/".$dia."/".$ano),0,1,'C');

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B','10');
$pdf->SetFillColor(192,192,192);
$pdf->Cell(200,5,utf8_decode("Ingresos"),0,1,'L',1);

$pdf->Cell(28.50,5,utf8_decode('Sucursal'),0,0,'L');
$pdf->Cell(42.8,5,utf8_decode('Presupuesto Acum'),0,0,'C');
$pdf->Cell(42.8,5,utf8_decode('Real Acum'),0,0,'C');
$pdf->Cell(42.8,5,utf8_decode('Variación'),0,0,'C');
$pdf->Cell(42.8,5,utf8_decode('% Cumplimiento'),0,1,'C');

$pdf->SetFont('Arial','','10');
$presupuesto = 0;
$acumulado = 0;

foreach ($con->query($consulta) as $key) {
  $sid = $key['sid'];
  $csucursal = "SELECT * FROM tbsucursal WHERE sid='$sid'";
  $vsucursal = $con->query($csucursal)->fetch_array();

  $pdf->Cell(28.50,5,utf8_decode($vsucursal['nombre']),0,0,'L');
  $pdf->Cell(42.8,5,utf8_decode("$".$key['presupuesto']),1,0,'C');
  $pdf->Cell(42.8,5,utf8_decode("$".$key['acumulado']),1,0,'C');
  $pdf->Cell(42.8,5,utf8_decode("$".round(($key['presupuesto']-$key['acumulado']), 2)),1,0,'C');
  $pdf->Cell(42.8,5,utf8_decode(round((($key['acumulado']/$key['presupuesto'])*100), 2)."%"),1,1,'C');

  $presupuesto += $key['presupuesto'];
  $acumulado += $key['acumulado'];
}

$pdf->SetTextColor(255,0,0);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(28.50,5,utf8_decode('Total'),0,0,'L');
$pdf->Cell(42.8,5,utf8_decode("$".$presupuesto),1,0,'C');
$pdf->Cell(42.8,5,utf8_decode("$".$acumulado),1,0,'C');
$pdf->Cell(42.8,5,utf8_decode("$".round(($presupuesto-$acumulado), 2)),1,0,'C');
$pdf->Cell(42.8,5,utf8_decode(round((($acumulado/$presupuesto)*100), 2)."%"),1,1,'C');


$pdf->Ln(15);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B','10');
$pdf->SetFillColor(192,192,192);
$pdf->Cell(200,5,utf8_decode("Cartera"),0,1,'L',1);


$pdf->SetFont('Arial','B','10');
$pdf->Cell(28.50,5,utf8_decode('Sucursal'),0,0,'L');
$pdf->Cell(28.50,5,utf8_decode('Inicial del mes'),0,0,'C');
$pdf->Cell(28.50,5,utf8_decode('Final reporte'),0,0,'C');
$pdf->Cell(28.50,5,utf8_decode('Presupuesto mes'),0,0,'C');
$pdf->Cell(28.50,5,utf8_decode('Cumplimiento'),0,0,'C');
$pdf->Cell(28.50,5,utf8_decode('Inicial del año'),0,0,'C');
$pdf->Cell(28.50,5,utf8_decode('Final reporte'),0,1,'C');

$pdf->SetFont('Arial','','10');
$iniciom = 0;
$finalm = 0;
$presupuestodemes = 0;
$inicioa = 0;
$finala = 0;

foreach ($con->query($consulta) as $key) {
  $sid = $key['sid'];
  $csucursal = "SELECT * FROM tbsucursal WHERE sid='$sid'";
  $vsucursal = $con->query($csucursal)->fetch_array();

  $pdf->Cell(28.50,5,utf8_decode($vsucursal['nombre']),0,0,'L');
  $pdf->Cell(28.50,5,utf8_decode("$".round($key['iniciom'], 2)),1,0,'C');
  $pdf->Cell(28.50,5,utf8_decode("$".round($key['finalm'], 2)),1,0,'C');
  $pdf->Cell(28.50,5,utf8_decode("$".round($key['presupuestodemes'], 2)),1,0,'C');
  $pdf->Cell(28.50,5,utf8_decode(round((($key['finalm']/$key['presupuestodemes'])*100), 2)."%"),1,0,'C');
  $pdf->Cell(28.50,5,utf8_decode("$".round($key['inicioa'], 2)),1,0,'C');
  $pdf->Cell(28.50,5,utf8_decode("$".round($key['finala'], 2)),1,1,'C');

  $iniciom += $key['iniciom'];
  $finalm += $key['finalm'];
  $presupuestodemes += $key['presupuestodemes'];
  $inicioa += $key['inicioa'];
  $finala += $key['finala'];
}

$pdf->SetTextColor(255,0,0);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(28.50,5,utf8_decode('Total'),0,0,'L');
$pdf->Cell(28.50,5,utf8_decode("$".round($iniciom, 2)),1,0,'C');
$pdf->Cell(28.50,5,utf8_decode("$".round($finalm, 2)),1,0,'C');
$pdf->Cell(28.50,5,utf8_decode("$".round($presupuestodemes, 2)),1,0,'C');
$pdf->Cell(28.50,5,utf8_decode(round((($finalm/$presupuestodemes)*100), 2)."%"),1,0,'C');
$pdf->Cell(28.50,5,utf8_decode("$".round($inicioa, 2)),1,0,'C');
$pdf->Cell(28.50,5,utf8_decode("$".round($finala, 2)),1,1,'C');

$pdf->Output();
?>
