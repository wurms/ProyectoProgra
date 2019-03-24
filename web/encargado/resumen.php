<?php
date_default_timezone_set('America/Dawson');
session_start();
include("../conexion.php");
if ($_SESSION['nivel']!=3) {
	session_destroy();
	header("location: ../loginusuario.php?msg=3");
	exit();
} elseif ($_SESSION['habilitado']!=1) {
	session_destroy();
	header("location: ../loginusuario.php?msg=4");
	exit();
}
if (isset($_POST['fechaini'])) {
	$sid = $_SESSION['sucursal'];
	$csucursal = "SELECT * FROM tbsucursal WHERE sid='$sid'";
	$vsucursal = $con->query($csucursal)->fetch_all();
	$pids = array();
	$cprenda = "SELECT * FROM tbprenda WHERE sid='$sid'";
	foreach ($con->query($cprenda) as $key) {
		array_push($pids, $key['pid']);
	}

	$acontratos = 0;
	$amontodelmutuo = 0;

	$bcontratos = 0;
	$bmontodelmutuo = 0;
	$bintereses = 0;
	$biva = 0;

	$ccontratos = 0;
	$cmontodelmutuo = 0;
	$cintereses = 0;
	$civa = 0;

	$dcontratos = 0;
	$dmontodelmutuo = 0;
	$dintereses = 0;
	$diva = 0;
	$dmora = 0;

	$hoy = date('m/d/o');
	$weekago = date($_POST['fechaini']);
	$weeklater = date($_POST['fechafin']);

	if ($weekago > $weeklater) {
		header("location: sresumen.php");
		exit();
	}

	$coperacionactuales = "SELECT * FROM tboperacion WHERE estado='1' AND fecha BETWEEN '$weekago' AND '$weeklater'";
	foreach ($con->query($coperacionactuales) as $key) {
		if (in_array($key['pid'], $pids)) {
			$acontratos+=1;
			$amontodelmutuo += $key['montodelmutuo'];
		}
	}

	$coperacionfinali = "SELECT * FROM tboperacion WHERE estado='2' AND fecha BETWEEN '$weekago' AND '$weeklater'";
	foreach ($con->query($coperacionfinali) as $key) {
		if (in_array($key['pid'], $pids)) {
			$bcontratos+=1;
			$bmontodelmutuo += $key['montodelmutuo'];
			$bintereses += $key['intereses']*3;
			$biva += $key['iva'];
		}
	}

	$coperacionvenci = "SELECT * FROM tboperacion WHERE estado='3' AND fecha BETWEEN '$weekago' AND '$weeklater'";
	foreach ($con->query($coperacionvenci) as $key) {
		if (in_array($key['pid'], $pids)) {
			$ccontratos+=1;
			$cmontodelmutuo += $key['montodelmutuo'];
			$cintereses += $key['intereses']*3;
			$civa += $key['iva'];
		}
	}

	$coperacionvendi = "SELECT * FROM tboperacion WHERE estado='4' AND fecha BETWEEN '$weekago' AND '$weeklater'";
	foreach ($con->query($coperacionvendi) as $key) {
		if (in_array($key['pid'], $pids)) {
			$dcontratos+=1;
			$dmontodelmutuo += $key['montodelmutuo'];
			$dintereses += $key['intereses']*3;
			$diva += $key['iva'];
			$dmora += $key['mora'];
		}
	}

	require('../fpdf/fpdf.php');

	$pdf = new FPDF('P','mm','Letter');
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->Image('../img/ps.jpg',20,2.5,30);
	$pdf->Cell(200,10,utf8_decode('Fecha: '.$hoy),0,1,'R');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(200,8,utf8_decode($vsucursal[0][1]),0,1,'C');
	$pdf->Cell(200,4,utf8_decode('RESUMEN DE OPERACIONES'),0,1,'C');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(200,3,utf8_decode('(Cantidad en dolares)'),0,1,'C');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(200,8,utf8_decode('RESUMEN DE OPERACIONES DEL '.$weekago.' AL '.$weeklater),0,1,'C');

	$pdf->SetFont('Arial','B',12);

	$pdf->Ln();
	$pdf->Cell(66,10,utf8_decode('CONTRATOS ACTUALES'),1,0,'C');
	$pdf->Cell(66,10,utf8_decode('CONTRATOS LIQUIDADOS'),1,0,'C');
	$pdf->Cell(66,10,utf8_decode('PASES A VENTAS'),1,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(33,5,utf8_decode('Total Contratos:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($acontratos),0,0,'R');
	$pdf->Cell(33,5,utf8_decode('Total Contratos:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($bcontratos),0,0,'R');
	$pdf->Cell(33,5,utf8_decode('Total Contratos:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($ccontratos),0,1,'R');

	$pdf->Cell(33,5,utf8_decode('Total Prendas:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($acontratos),0,0,'R');
	$pdf->Cell(33,5,utf8_decode('Total Prendas:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($bcontratos),0,0,'R');
	$pdf->Cell(33,5,utf8_decode('Total Prendas:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($ccontratos),0,1,'R');

	$pdf->Cell(33,5,utf8_decode('Monto Total:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($amontodelmutuo),0,0,'R');
	$pdf->Cell(33,5,utf8_decode('Monto Total:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($bmontodelmutuo),0,0,'R');
	$pdf->Cell(33,5,utf8_decode('Monto Total:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($cmontodelmutuo),0,1,'R');

	$pdf->Cell(66,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(33,5,utf8_decode('Intereses cobrados:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($bintereses),0,0,'R');
	$pdf->Cell(33,5,utf8_decode('Total Cobrado:'),0,0,'L');
	$ctotalcobrado = $cintereses + $civa;
	$pdf->Cell(33,5,utf8_decode($ctotalcobrado),0,1,'R');

	$pdf->Cell(66,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(33,5,utf8_decode('I.V.A:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($biva),0,0,'R');
	$pdf->Cell(66,5,utf8_decode(''),0,1,'L');

	$pdf->Cell(66,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(33,5,utf8_decode('Total Cobrado:'),0,0,'L');
	$btotalcobrado = $bintereses + $biva + $bmontodelmutuo;
	$pdf->Cell(33,5,utf8_decode($btotalcobrado),0,0,'R');
	$pdf->Cell(66,5,utf8_decode(''),0,1,'L');

	$pdf->SetFont('Arial','B',12);

	$pdf->Ln();
	$pdf->Cell(66,10,utf8_decode('CONTRATOS VENDIDOS'),1,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(33,5,utf8_decode('Total Contratos:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($dcontratos),0,1,'R');
	$pdf->Cell(33,5,utf8_decode('Monto Total:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($dmontodelmutuo),0,1,'R');
	$pdf->Cell(33,5,utf8_decode('Intereses cobrados:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($dintereses),0,1,'R');
	$pdf->Cell(33,5,utf8_decode('Mora:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($diva),0,1,'R');
	$pdf->Cell(33,5,utf8_decode('I.V.A:'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($diva),0,1,'R');
	$pdf->Cell(33,5,utf8_decode('Total Cobrado:'),0,0,'L');
	$dtotalcobrado = $dintereses + $diva + $dmontodelmutuo;
	$pdf->Cell(33,5,utf8_decode($dtotalcobrado),0,0,'R');

	$pdf->Ln(50);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(66,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(99,10,utf8_decode('INGRESOS / EGRESOS'),1,1,'C');

	$ingresos = $btotalcobrado + $dtotalcobrado;
	$egresos = $amontodelmutuo;
	$iva = $biva + $civa + $diva;

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(66,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(33,5,utf8_decode('TOTAL INGRESOS'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode(':'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($ingresos),0,1,'R');

	$pdf->Cell(66,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(33,5,utf8_decode('TOTAL EGRESOS'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode(':'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($egresos),0,1,'R');

	$pdf->Cell(66,5,utf8_decode(''),0,0,'L');
	$pdf->Cell(33,5,utf8_decode('TOTAL IVA'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode(':'),0,0,'L');
	$pdf->Cell(33,5,utf8_decode($iva),0,1,'R');
	$pdf->Ln(25);

	$eid = $_SESSION['eid'];
	$varempleado = $con->query("SELECT * FROM tbempleado WHERE eid='$eid'")->fetch_array();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(200,5,utf8_decode('_________________________________________'),0,1,'R');
	$pdf->Cell(180,5,utf8_decode('Firma y Sello del Encargado'),0,1,'R');
	$pdf->Cell(160,5,utf8_decode($varempleado['nombre'].' '.$varempleado['apellido']),0,1,'R');

	$pdf->Output();
} else {
	header("location: sresumen.php");
	exit();
}
?>
