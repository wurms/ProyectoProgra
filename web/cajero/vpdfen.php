<?php
session_start();
include("../conexion.php");
if ($_SESSION['nivel']!=4) {
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

$pdf->Cell(200,10,'PLEDGE',0,1,'C');

$pdf->SetFont('Arial','',14);
$pdf->Cell(150,12,utf8_decode('Number: '.$pid),0,0,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,4,utf8_decode('Branch'.$vsucursal[0][1]),0,0,'R');
$pdf->Ln();
$pdf->Cell(200,4,utf8_decode($vsucursal[0][2]),0,0,'R');
$pdf->Ln();
$pdf->Cell(200,4,utf8_decode($vsucursal[0][3]),0,1,'R');
$pdf->Cell(20,15,utf8_decode('Front of the contract of the common consent of pledge by celebrating PAWNSHOP.'),'C');
$pdf->Ln(4);
$pdf->Cell(20,15,utf8_decode('and: '.$vcliente[0][2].' '.$vcliente[0][3].', DUI: '.$vcliente[0][1].', Address '.$vcliente[0][4]),'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(20,20,utf8_decode("DESCRIPTION OF PIECE"));
$pdf->Ln(15);

$pdf->SetFont('Arial','',8);
$pdf->Cell(25,10,utf8_decode('Quantity'),1,0,'C');
$pdf->Cell(40,10,utf8_decode('Characteristics'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('Weight'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('Caratage'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('Status'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Gemstone'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Appraisal $'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Loan $'),1,1,'C');

$pdf->Cell(25,10,utf8_decode($vprenda[0][1]),1,0,'C');
$pdf->Cell(40,10,utf8_decode($vprenda[0][2]),1,0,'C');
$pdf->Cell(20,10,utf8_decode($vprenda[0][3]),1,0,'C');
$pdf->Cell(20,10,utf8_decode($vprenda[0][4]),1,0,'C');
$pdf->Cell(20,10,utf8_decode($vprenda[0][5]),1,0,'C');
$pdf->Cell(25,10,utf8_decode($vprenda[0][6]),1,0,'C');
$pdf->Cell(25,10,utf8_decode($vprenda[0][7]),1,0,'C');
$pdf->Cell(25,10,utf8_decode($vprenda[0][8]),1,1,'C');

$pdf->Cell(20,15,utf8_decode('IMPORTANT: Your pieces are protected with insurance policy #TR-00644.'),'C');
$pdf->Ln();

$pdf->Cell(15,10,utf8_decode('AMOUNT'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('INTEREST'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('STORAGE'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('INSURANCE'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('EXPENSES'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('SERV. CHAN.'),1,0,'C');
$pdf->Cell(17,10,utf8_decode('PERIOD'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('MAX PERIOD'),1,0,'C');
$pdf->Cell(33,10,utf8_decode('COMMERCIALIZATION'),1,1,'C');

$pdf->Cell(15,10,utf8_decode($vprenda[0][8]),1,0,'C');
$pdf->Cell(25,10,utf8_decode('4.00 %'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('4.00 %'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('4.00 %'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('0.19'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('25.00 %'),1,0,'C');
$pdf->Cell(20,10,utf8_decode('1 Month'),1,0,'C');
$pdf->Cell(25,10,utf8_decode($voperacion[0][5]),1,0,'C');
$pdf->Cell(30,10,utf8_decode($voperacion[0][6]),1,1,'C');

$pdf->SetFont('Arial','B','10');
$pdf->Cell(20,20,utf8_decode("PAYMENT OPTIONS"));
$pdf->Ln(15);

$pdf->SetFont('Arial','',8);
$pdf->Cell(30,10,utf8_decode('Expiration date'),1,0,'C');
$pdf->Cell(30,10,utf8_decode('Performance'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Interests'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Storage'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('Insurance'),1,0,'C');
$pdf->Cell(25,10,utf8_decode('VAT'),1,0,'C');
$pdf->Cell(40,10,utf8_decode('Amount canceled'),1,1,'C');

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
$pdf->Cell(150,7,utf8_decode('SETTLEMENT DATE'),1,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(150,5,utf8_decode('THE PLEDGOR collects in the act and your satisfaction the items decribed above, by this giving PAWNSHOP the most comprenhensive setlement in law applicable freeing of any liability legal which has emerged or may emerge in relation to the contract and the piece.                                                                                                                                                                                                                                                                                                                             The pledgor: ___________________________________________.                                                                                                                                                                                                                                                                                 '),1,'J');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(150,7,utf8_decode('Pledge Signatures'),1,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(150,10,utf8_decode('San Salvador, '.date('d').' de '.date('M').' del '.date('Y').'                                                                                           _____________________________________________________________________________________________ Pledgor: '   .$vcliente[0][2].' '.$vcliente[0][3].'.                                                                                                                                        The company                                                                                                                                                                    ________________________________         ________________________________                                     	                   The appraiser  '.$vempleado[0][1].' '.$vempleado[0][2].'                                          The legal representative'),1,'J');

$pdf->Output();
?>
