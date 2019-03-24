<?php
date_default_timezone_set('America/Dawson');
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
if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
  $cprenda = "SELECT * FROM tbprenda WHERE pid='$pid'";
  $vprenda = $con->query($cprenda)->fetch_array();
  $sid = $vprenda['sid'];
  $eid = $vprenda['eid'];
  $cid = $vprenda['cid'];
  $csucursal = "SELECT * FROM tbsucursal WHERE sid='$sid'";
  $cempleado = "SELECT * FROM tbempleado WHERE eid='$eid'";
  $ccliente = "SELECT * FROM tbcliente WHERE cid='$cid'";
  $vsucursal = $con->query($csucursal)->fetch_array();
  $vempleado = $con->query($cempleado)->fetch_array();
  $vcliente = $con->query($ccliente)->fetch_array();
  if (!$vprenda) {
    header("location: vcontratoen.php");
    exit();
  }
}else{
  header("location: vcontratoen.php");
  exit();
}

if (isset($_POST['pid'])) {
  $monto = $vprenda['prestamo'];
  $consulta = "SELECT * FROM tboperacion WHERE oid='$pid'";
  $varcon = $con->query($consulta)->fetch_all();
  $hoy = date('m/d/o');
  $plazo = date('m/d/o', strtotime('+1 month')) ;
  $comerci = date('m/d/o', strtotime('+5 day, +1 month'));
  $intereses = round(($vprenda['prestamo'])*0.04, 2);
  $iva = round(($intereses*3)*0.13, 2);
  $total = round(($vprenda['prestamo'])+($intereses*3)+$iva, 2);

  if ($varcon) {
  	$modi = "UPDATE tboperacion SET fecha='$hoy', plazomaximo='$plazo', fechacomercializacion='$comerci', estado='1', fechapago='NULL', mora='0' WHERE oid='$pid'";
  	$modifi = "UPDATE tbprenda SET estado='1' WHERE pid='$pid'";
  	$varmod = $con->query($modi);
  	$varmodifi = $con->query($modifi);
  }else{
  	$insertar = "INSERT INTO tboperacion VALUES('$pid','$pid','$hoy','$monto','$intereses','$plazo','$comerci','$iva','$total','1','NULL','NULL','0')";
    $modifi = "UPDATE tbprenda SET estado='1' WHERE pid='$pid'";
  	$varin = $con->query($insertar);
    $varmodifi = $con->query($modifi);
  }
}

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pawnshop</title>
  <script src="../sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../sweetalert/dist/sweetalert.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  <link href="../css/themify-icons.css" rel="stylesheet" type="text/css" media="all" />
  <link href="../css/flexslider.css" rel="stylesheet" type="text/css" media="all" />
  <link href="../css/lightbox.min.css" rel="stylesheet" type="text/css" media="all" />
  <link href="../css/ytplayer.css" rel="stylesheet" type="text/css" media="all" />
  <link href="../css/theme.css" rel="stylesheet" type="text/css" media="all" />
  <link href="../css/custom.css" rel="stylesheet" type="text/css" media="all" />
  <link href='http://fonts.googleapis.com/css?family=Lato:300,400%7CRaleway:100,400,300,500,600,700%7COpen+Sans:400,500,600' rel='stylesheet' type='text/css'>
</head>
<body class="scroll-assist">
  <div class="nav-container">
    <a id="top"></a>
    <nav class="bg-dark">
      <div class="nav-bar">
        <div class="module left">
          <a href="index.php">
            <h5>Pawnshop System</h5>
          </a>
        </div>
        <div class="module widget-handle mobile-toggle right visible-sm visible-xs">
          <i class="ti-menu"></i>
        </div>
        <div class="module-group right">
          <div class="module left">
            <ul class="menu">
              <li>
                <a href="indexen.php">
                    Home
                </a>
            </li>
            <li class="has-dropdown">
                <a href="#">
                    Add new
                </a>
                <ul class="mega-menu">
                    <li>
                        <ul>
                            <li>
                                <span class="title">Loans</span>
                            </li>
                            <li>
                                <a href="cprendaen.php">Piece</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>
                                <span class="title">Clients</span>
                            </li>
                            <li>
                                <a href="nclienteen.php">Client</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="has-dropdown">
                <a href="#">
                    View List
                </a>
                <ul class="mega-menu">
                    <li>
                        <ul>
                            <li>
                                <span class="title">Pledges</span>
                            </li>
                            <li>
                                <a href="scontratoen.php">View Pledges</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>
                                <span class="title">Clients</span>
                            </li>
                            <li>
                                <a href="vclienteen.php">Client</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="../cerraren.php">
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!--Final del menu-->
    <div class="module widget-handle language left">
        <ul class="menu">
            <li class="has-dropdown">
                <a href="ncontratoen.php">ENGLISH</a>
                <ul>
                    <li>
                        <a href="ncontrato.php">ESPAÑOL</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <!--Final idioma-->
      </div>
    </nav>
  </div>
  <!--Final barra-->
  <?php
  if (isset($_POST['pid'])) {
    if (@$varcon) {
      if (@$varmod && @$varmodifi) {
        ?>
        <script type="text/javascript">
        swal("¡BUEN TRABAJO!", "¡Contrato Actualizado!", "success")
        </script>
        <?php
      } else {
        echo "Se encontro pero no se guardo";
      }
    } elseif(@$varin && @$varmodifi){
        ?>
        <script type="text/javascript">
        swal("¡BUEN TRABAJO!", "¡Contrato Guardado!", "success")
        </script>
        <?php
    }else{
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "¡Intente nuevamente!", "error");
      </script>
      <?php
    }
  }
  ?>
  <div class="main-container">
    <section>
        <div class="container">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4 class="uppercase mb16">Pledge Agreement</h4>
              <p class="lead mb64">
                Client: <?=$vcliente['nombre']?> <?=$vcliente['apellido']?>. DUI: <?=$vcliente['dui']?>.
              </p>
            </div>
          </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-0 col-sm-10 col-sm-offset-1"><br><br>
                    <table class="table cart mb48">
                        <thead>
                            <tr>
                              <th>N°</th>
                              <th>Characteristics</th>
                              <th>Weight (kg)</th>
                              <th>Caratage</th>
                              <th>Value</th>
                              <th>Loan</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <span><?=$vprenda['pid']?></span>
                            </td>
                            <td>
                              <span><?=$vprenda['caracteristicas']?></span>
                            </td>
                            <td>
                              <span><?=$vprenda['peso']?></span>
                            </td>
                            <td>
                              <span><?=$vprenda['kilataje']?></span>
                            </td>
                            <td>
                              <span>$<?=$vprenda['avaluo']?></span>
                            </td>
                            <td>
                              <span>$<?=$vprenda['prestamo']?></span>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                    <table class="table cart mb48">
                        <thead>
                            <tr>
                              <th>AMOUNT</th>
                              <th>INTEREST</th>
                              <th>STORAGE</th>
                              <th>INSURANCE</th>
                              <th>EXPENSES</th>
                              <th>SERV. CHAN.</th>
                              <th>PERIOD</th>
                              <th>MAX PERIOD</th>
                              <th>COMMERCIALIZATION</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <?php
                            $hoy = date('m/d/o');
                            $plazo = date('m/d/o', strtotime('+1 month')) ;
                            $comerci = date('m/d/o', strtotime('+5 day, +1 month'));
                            ?>
                            <td>
                              <span>$<?= $vprenda['prestamo'] ?></span>
                            </td>
                            <td>
                              <span>4.00 %</span>
                            </td>
                            <td>
                              <span>4.00 %</span>
                            </td>
                            <td>
                              <span>4.00 %</span>
                            </td>
                            <td>
                              <span>0.19</span>
                            </td>
                            <td>
                              <span>25.00 %</span>
                            </td>
                            <td>
                              <span>1 Month</span>
                            </td>
                            <td>
                              <span><?= $plazo ?></span>
                            </td>
                            <td>
                              <span><?= $comerci ?></span>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                    <?php
                    if($vprenda['estado']==1 || $vprenda['estado']==3){
                      ?>
                      <form method="post" target="_blank" action="vpdfen.php" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Archivo Abierto!">
                        <input type="hidden" value="<?=$vprenda['pid']?>" name="pid" />
                        <button type="submit" style="margin-bottom: 5px; background-color: #63dd8d; border-color: #63dd8d">View Pledge</button>
                      </form>
                      <?php
                    }
                    ?>
                </div>
                <!--end of items-->
                <div class="col-md-3 col-md-offset-0 col-sm-10 col-sm-offset-1">
                    <div class="mb24">
                        <h5 class="uppercase">Payment Options</h5>
                        <table class="table">
                            <tbody>
                              <?php
                              $intereses = round(($vprenda['prestamo'])*0.04, 2);
                              $iva = round(($intereses*3)*0.13, 2);
                              $total = round(($vprenda['prestamo'])+($intereses*3)+$iva, 2);
                              ?>
                                <tr>
                                    <th scope="row">Performance</th>
                                    <td>$<?= $vprenda['prestamo'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Interests</th>
                                    <td>$<?=$intereses?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Storage</th>
                                    <td>
                                        $<?=$intereses?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Insurance</th>
                                    <td>$<?=$intereses?></td>
                                </tr>
                                <tr>
                                    <th scope="row">VAT</th>
                                    <td>$<?=$iva?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Amount canceled</th>
                                    <td>$<?=$total?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Guardado!">
                          <input type="hidden" value="<?=$key['pid']?>" name="pid">
                          <button onclick="swal({   title: 'NEW PLEDGE!',   text: 'Are you sure?',   type: 'warning',   showCancelButton: true,   confirmButtonColor: '#DD6B55',   confirmButtonText: 'New Pledge!',   closeOnConfirm: false }, function(){ form.submit(); });" type="button" style="margin-bottom: 5px; background-color: #6cbcd5; border-color: #6cbcd5">New Pledge</button>
                        </form>
                    </div>
                </div>
                <!--end of totals-->
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>

    <footer class="footer-1 bg-dark">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <span class="sub">CSSC 2016 - Pawnshop System | <a target="_blank" href="../user.pdf">Help</a></span>
          </div>
          <div class="col-sm-6 text-right">
            <ul class="list-inline social-list">
              <li>
                <a href="#">
                  <i class="ti-twitter-alt"></i>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="ti-facebook"></i>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="ti-instagram"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--final contenedor-->
    </footer>
  </div>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/flickr.js"></script>
  <script src="../js/flexslider.min.js"></script>
  <script src="../js/lightbox.min.js"></script>
  <script src="../js/masonry.min.js"></script>
  <script src="../js/twitterfetcher.min.js"></script>
  <script src="../js/spectragram.min.js"></script>
  <script src="../js/ytplayer.min.js"></script>
  <script src="../js/countdown.min.js"></script>
  <script src="../js/smooth-scroll.min.js"></script>
  <script src="../js/parallax.js"></script>
  <script src="../js/scripts.js"></script>
</body>
</html>
