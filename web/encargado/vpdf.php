<?php
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
	header("location: scontrato.php");
	exit();
}

if (!$voperacion) {
	header("location: scontrato.php");
	exit();
}

require('../fpdf/fpdf.php');

$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Image('../img/ps.jpg',20,2.5,35);

$pdf->Cell(200,10,'CONTRATO PRENDARIO',0,1,'C');

$pdf->SetFont('Arial','',14);
$pdf->Cell(150,12,utf8_decode('Número: '.$pid),0,0,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,4,utf8_decode('Sucursal '.$vsucursal[0][1]),0,0,'R');
$pdf->Ln();
$pdf->Cell(200,4,utf8_decode($vsucursal[0][2]),0,0,'R');
$pdf->Ln();
$pdf->Cell(200,4,utf8_decode($vsucursal[0][3]),0,1,'R');
$pdf->Cell(20,15,utf8_decode('Anverso del contrato de mutuo garantía prendatia que celebra PAWNSHOP.'),'C');
$pdf->Ln(4);
$pdf->Cell(20,15,utf8_decode('y: '.$vcliente[0][2].' '.$vcliente[0][3].', DUI: '.$vcliente[0][1].', Con domicilio en: '.$vcliente[0][4]),'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(20,20,utf8_decode("DESCRIPCIÓN DE PRENDAS"));
$pdf->Ln(15);

$pdf->SetFont('Arial','',8);
$pdf->Cell(25,10,utf8_decode('Cantidad'),1,0,'C');
$pdf->Cell(40,10,utf8_decode('Características'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('Peso'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('Kilates'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('Estado'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Piedra'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Avaluo $'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Prestamo $'),1,1,'C');

$pdf->Cell(25,10,utf8_decode($vprenda[0][1]),1,0,'C');
$pdf->Cell(40,10,utf8_decode($vprenda[0][2]),1,0,'C');
$pdf->Cell(20,10,utf8_decode($vprenda[0][3]),1,0,'C');
$pdf->Cell(20,10,utf8_decode($vprenda[0][4]),1,0,'C');
$pdf->Cell(20,10,utf8_decode($vprenda[0][5]),1,0,'C');
$pdf->Cell(25,10,utf8_decode($vprenda[0][6]),1,0,'C');
$pdf->Cell(25,10,utf8_decode($vprenda[0][7]),1,0,'C');
$pdf->Cell(25,10,utf8_decode($vprenda[0][8]),1,1,'C');

$pdf->Cell(20,15,utf8_decode('IMPORTANTE: Sus prendas quedan protegidas con la poliza de seguro #TR-00644 Expedida por: ACSA.'),'C');
$pdf->Ln();

$pdf->Cell(15,10,utf8_decode('MONTO'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('INTERESES'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('ALMACENAJE'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('SEGURO'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('GASTOS'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('COMISIÓN'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('PLAZO'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('PLAZO MAXIMO'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('COMERCIALIZACIÓN'),1,1,'C');

$pdf->Cell(15,10,utf8_decode($vprenda[0][8]),1,0,'C');
$pdf->Cell(25,10,utf8_decode('4.00 %'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('4.00 %'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('4.00 %'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('0.19'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('25.00 %'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('1 Mes'),1,0,'C');
$pdf->Cell(25,10,utf8_decode($voperacion[0][5]),1,0,'C');
$pdf->Cell(30,10,utf8_decode($voperacion[0][6]),1,1,'C');

$pdf->SetFont('Arial','B','10');
$pdf->Cell(20,20,utf8_decode("OPCIONES DE PAGO"));
$pdf->Ln(15);

$pdf->SetFont('Arial','',8);
$pdf->Cell(30,10,utf8_decode('Vencimiento'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('Importe'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Intereses'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Almacenaje'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Seguro'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('IVA'),1,0,'C');
$pdf->Cell(40,10,utf8_decode('Total a Pagar'),1,1,'C');

$pdf->Cell(30,10,utf8_decode($voperacion[0][5]),1,0,'C');
$pdf->Cell(30,10,utf8_decode($vprenda[0][8]),1,0,'C');
$intereses = ($vprenda[0][8])*0.04;
$iva = ($intereses*3)*0.13;
$total = (($vprenda[0][8])+($intereses*3)+$iva);
$pdf->Cell(25,10,round($intereses, 2),1,0,'C');
$pdf->Cell(25,10,round($intereses, 2),1,0,'C');
$pdf->Cell(25,10,round($intereses, 2),1,0,'C');
$pdf->Cell(25,10,round($iva, 2),1,0,'C');
$pdf->Cell(40,10,round($total, 2),1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(150,7,utf8_decode('FINIQUITO'),1,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(150,5,utf8_decode('DEDUDOR PRENDARIO recoge en el acto y a su entera satisfacción la(s) prenda(s) arriba descrita(s) por lo que otorga a PAWNSHOP el mas amplio finiquito que en derecho corresponda liberando de cualquier responsabilidad juridica que hubiere surgido o pudiere surgir en relación al contrato y a la prenda.                                                                                                                                                                                                                                                                        Deudor Prendario: ___________________________________________.                                                                                                                                                                                                                                                                                 '),1,'J');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(150,7,utf8_decode('FIRMAS DEL CONTRATO'),1,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(150,10,utf8_decode('San Salvador, '.date('d').' de '.date('M').' del '.date('Y').'                                                                                           _____________________________________________________________________________________________ Deudor Prendario: '.$vcliente[0][2].' '.$vcliente[0][3].'.                                                                                                                                        La Empresa                                                                                                                                                                      ________________________________         ________________________________                                     	                   El Valuador '.$vempleado[0][1].' '.$vempleado[0][2].'                                          El Apoderado Legal'),1,'J');

$pdf->Output();
?>
