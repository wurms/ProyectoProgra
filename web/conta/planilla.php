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

if (isset($_POST['ano'])) {
  $planilla = $_POST['planilla'];
  $mes = $_POST['mes'];
  $ano = $_POST['ano'];
  $sid = $_POST['sid'];

  if ($sid != 0) {
    $consulta = "SELECT * FROM tbplanilla WHERE planilla='$planilla' AND mes='$mes' AND ano='$ano' AND sid='$sid'";
    $var = $con->query($consulta)->fetch_all();

    $csucursal = $con->query("SELECT * FROM tbsucursal WHERE sid='$sid'")->fetch_array();
  } else {
    $consulta = "SELECT * FROM tbplanilla WHERE planilla='$planilla' AND mes='$mes' AND ano='$ano'";
    $var = $con->query($consulta)->fetch_all();
  }

  if (!$var) {
    header("location: splanilla.php");
    exit();
  }
} else {
  header("location: splanilla.php");
  exit();
}

$hoy = date('m/d/o');

require('../fpdf/fpdf.php');

$pdf = new FPDF('L','mm','Legal');
$pdf->AddPage();

$pdf->SetFont('Arial','B',9);
$pdf->Cell(340,5,utf8_decode("Pawnshop S.A de C.V"),0,1,'R',0);
$pdf->Cell(340,5,utf8_decode("Generada: ".$hoy),0,1,'R',0);
if (@$csucursal) {
  $pdf->Cell(340,5,utf8_decode("Sucursal: ".$csucursal['nombre']),0,1,'R',0);
}
$pdf->Image('../img/ps.jpg',20,2.5,35);

$pdf->Ln(5);
$pdf->SetFont('Arial','B','16');
$pdf->SetFillColor(255,255,204);
$pdf->Cell(340,15,utf8_decode("Reporte de Planilla: Planilla General"),0,0,'C',1);
$pdf->Ln(20);

$pdf->SetFont('Arial','B','8');
$pdf->SetFillColor(192,192,192);
$pdf->Cell(214.78,7,utf8_decode("Tipo:  Planilla General"),0,0,'L',1);
$pdf->Cell(41.74,7,utf8_decode("Planilla: ".$planilla),0,0,'C',1);
$pdf->Cell(41.74,7,utf8_decode("Año: ".$ano),0,0,'C',1);
$pdf->Cell(41.74,7,utf8_decode("Mes: ".$mes),0,0,'C',1);
$pdf->Ln(9);

$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(192,192,192);
$pdf->Cell(7,10,utf8_decode('N°'),0,0,'C',1);
$pdf->Cell(28,10,utf8_decode('Nombre'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Sueldo'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Suel. Dia.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Dias Lab.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Suel. Dev.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Bonif.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('C. Horas'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Horas Ext.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Vac.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Total Dev.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('ISSS'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('AFP'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Ingre. grav.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('ISR'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('O. Desc.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('Inst. Fin.'),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode('To. Desc.'),0,0,'C',1);
$pdf->Cell(18.6,10,utf8_decode('To. a pagar'),0,1,'C',1);
$pdf->Ln(2);

$a = 0;
$b = 0;
$c = 0;
$d = 0;
$e = 0;
$f = 0;
$g = 0;
$h = 0;
$i = 0;
$j = 0;
$k = 0;
$l = 0;
$m = 0;

foreach ($con->query($consulta) as $key) {
  $eid = $key['eid'];
  $cempleado = "SELECT * FROM tbempleado WHERE eid='$eid'";
  $vempleado = $con->query($cempleado)->fetch_array();

  $sueldo = $key['sueldo'];
  $diario = round($key['sueldo']/30, 2);
  $dias = $key['dias'];
  $extras = $key['extras'];
  $cextras = round((($diario/8)*2)*$extras);
  $devengado = $diario*$dias;
  $bonificacion = $key['bonificacion'];
  $vacaciones = $key['vacaciones'];
  $isss = round(($devengado*3)/100, 2);
  $afp = round(($devengado*6.75)/100, 2);
  $gravado = round($devengado-$isss-$afp, 2);
  if ($gravado >= 0.01 && $gravado <= 236) {
    $isr = '0.00';
  } elseif ($gravado >= 236.01 && $gravado <= 447.62) {
    $isr = round(((($gravado-236)*10)/100)+8.83, 2);
  } elseif ($gravado >= 447.63 && $gravado <= 1019.05) {
    $isr = round(((($gravado-447.62)*20)/100)+30, 2);
  } elseif ($gravado >= 1019.06) {
    $isr = round(((($gravado-1019.05)*30)/100)+144.28, 2);
  }
  $odescuento = $key['odescuento'];
  $instfin = $key['instfin'];
  $totaldescuento = round($isss+$afp+$instfin, 2);
  $total = round($devengado-$totaldescuento, 2);

  $a+=$bonificacion;
  $b+=$extras;
  $c+=$cextras;
  $d+=$vacaciones;
  $e+=$devengado;
  $f+=$isss;
  $g+=$afp;
  $h+=$gravado;
  $i+=$isr;
  $j+=$odescuento;
  $k+=$instfin;
  $l+=$totaldescuento;
  $m+=$total;

  $pdf->SetFont('Arial','',7);
  $pdf->SetFillColor(224,224,224);
  $pdf->Cell(7,7,utf8_decode($eid),0,0,'C',1);
  $pdf->Cell(28,7,utf8_decode($vempleado['nombre'].' '.$vempleado['apellido']),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($sueldo),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($diario),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($dias),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($devengado),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($bonificacion),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($extras),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($cextras),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($vacaciones),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($devengado),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($isss),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($afp),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($gravado),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($isr),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($odescuento),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($instfin),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($totaldescuento),0,0,'C',1);
  $pdf->Cell(17.89,7,utf8_decode($total),0,1,'C',1);
  $pdf->Ln(1);
}

$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(192,192,192);
$pdf->Cell(106.56,10,utf8_decode('Total general:'),0,0,'L',1);
$pdf->Cell(17.89,10,utf8_decode($a),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($b),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($c),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($d),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($e),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($f),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($g),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($h),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($i),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($j),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($k),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($l),0,0,'C',1);
$pdf->Cell(17.89,10,utf8_decode($m),0,1,'C',1);
$pdf->Ln(5);

$pdf->SetFont('Arial','',8);
if ($planilla == 1) {
  $pdf->Cell(50,10,utf8_decode('COMENTARIO: Primera Quincena'),0,1,'C');
} else {
  $pdf->Cell(50,10,utf8_decode('COMENTARIO: Segunda Quincena'),0,1,'C');
}

$pdf->Ln(15);

$pdf->Cell(90,10,utf8_decode('________________________________________________'),0,0,'C');
$pdf->Cell(25,10,utf8_decode(''),0,0,'C');
$pdf->Cell(90,10,utf8_decode('________________________________________________'),0,0,'C');
$pdf->Cell(25,10,utf8_decode(''),0,0,'C');
$pdf->Cell(90,10,utf8_decode('________________________________________________'),0,1,'C');

$eid = $_SESSION['eid'];
$consulta = "SELECT * FROM tbempleado WHERE eid='$eid'";
$var = $con->query($consulta)->fetch_array();

$pdf->Cell(90,5,utf8_decode($var['apellido'].', '.$var['nombre']),0,0,'C');
$pdf->Cell(25,5,utf8_decode(''),0,0,'C');
$pdf->Cell(90,5,utf8_decode(''),0,0,'C');
$pdf->Cell(25,5,utf8_decode(''),0,0,'C');
$pdf->Cell(90,5,utf8_decode(''),0,1,'C');

$pdf->Cell(90,5,utf8_decode('Elaborada por'),0,0,'C');
$pdf->Cell(25,5,utf8_decode(''),0,0,'C');
$pdf->Cell(90,5,utf8_decode('Revisada por'),0,0,'C');
$pdf->Cell(25,5,utf8_decode(''),0,0,'C');
$pdf->Cell(90,5,utf8_decode('Autorizada por'),0,1,'C');

$pdf->Output();
?>
