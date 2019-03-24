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
if (isset($_GET['cid'])) {
  $cid = $_GET['cid'];
  $consulta = "SELECT * FROM tbcliente WHERE cid=$cid";
  $var = $con->query($consulta)->fetch_array();
  if (!$var) {
    header("location: scontratoen.php?msg=1");
    exit();
  }
} else {
  header("location: scontratoen.php");
  exit();
}
if (isset($_POST['estado'])) {
  $pid = $_POST['pid'];
  $estado = $_POST['estado'];
  $cop = "SELECT * FROM tboperacion WHERE oid=$pid";
  $vop = $con->query($cop)->fetch_all();
  $plazomaximo = $vop[0][5];
  $monto = $vop[0][3];
  $datetime1 = new DateTime("now");
  $datetime2 = new DateTime($plazomaximo);
  $interval = $datetime1->diff($datetime2);
  $fechapago = date('m-d-o');
  $pon = $interval->format('%R%a');
  if ($pon>0) {
    $dias = "0";
  }else{
    $dias = $interval->format('%a');
  }
  $mora = $monto*($dias*0.02);
  $modi = "UPDATE tboperacion SET estado='$estado', fechapago='$fechapago', mora='$mora' WHERE oid='$pid'";
  $modifi = "UPDATE tbprenda SET estado='$estado' WHERE pid='$pid'";
  $varmodi = $con->query($modi);
  $varmodifi = $con->query($modifi);
}
if ($var['estado'] =! 4) {
  $hoy = date("m/d/o");
  $vencidos = "SELECT * FROM tboperacion WHERE plazomaximo < '$hoy'";
  foreach ($con->query($vencidos) as $key) {
    $oid = $key['oid'];
    $mvencidos = "UPDATE tboperacion SET estado=3 WHERE oid=$oid";
    $mvencidosprenda = "UPDATE tbprenda SET estado=3 WHERE pid=$oid";
    $varvencidos = $con->query($mvencidos);
    $varvencidosprenda = $con->query($mvencidosprenda);
  }
}

$hoy = date("m/d/o");
$vencidos = "SELECT * FROM tboperacion WHERE fechacomercializacion < '$hoy' AND estado!='2' AND estado!='4'";
foreach ($con->query($vencidos) as $key) {
  $oid = $key['oid'];
  $mvencidos = "UPDATE tboperacion SET estado='3' WHERE oid='$oid'";
  $mvencidosprenda = "UPDATE tbprenda SET estado='3' WHERE pid='$oid'";
  $varvencidos = $con->query($mvencidos);
  $varvencidosprenda = $con->query($mvencidosprenda);
}

require_once("../zebra/zebra.php");
$contar = "SELECT * FROM tbprenda WHERE cid=$cid";
$total_regitros = $con->query($contar);
$resultados = 5;
$registros = mysqli_num_rows($total_regitros);

$paginacion = new Zebra_Pagination();
$paginacion->records($registros);
$paginacion->records_per_page($resultados);
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
                <a href="indexen.php">ENGLISH</a>
                <ul>
                    <li>
                        <a href="index.php">ESPAÑOL</a>
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
  <div class="main-container">
    <?php
    $cprenda = "SELECT * FROM tbprenda WHERE cid=$cid LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
    if (!($con->query($cprenda)->fetch_array())) {
      ?>
      <section>
        <div class="container">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4 class="uppercase mb16">List of Pledges</h4>
              <p class="lead mb64">
                Client: <?=$var['nombre']?> <?=$var['apellido']?>. DUI: <?=$var['dui']?>.
              </p>
            </div>
          </div>
          <!--end of row-->
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="alert alert-danger alert-dismissible" role="alert">
                <span aria-hidden="true">&times;</span>
                <strong>According to the platform!</strong> No pieces registered.
              </div>
            </div>
          </div>
          <!--end of row-->
        </div>
        <!--end of container-->
      </section>
      <?php
    } else {
      ?>
        <section>
          <div class="container">
            <div class="row">
              <div class="col-sm-12 text-center">
                <h4 class="uppercase mb16">List of Pledges</h4>
                <p class="lead mb64">
                  Client: <?=$var['nombre']?> <?=$var['apellido']?>. DUI: <?=$var['dui']?>.
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-100 col-md-offset-0 col-sm-100 col-sm-offset-0">
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
                    <?php
                    foreach ($con->query($cprenda) as $key) {
                      ?>
                      <tr>
                        <td>
                          <span><?=$key['pid']?></span>
                        </td>
                        <td>
                          <span><?=$key['caracteristicas']?></span>
                        </td>
                        <td>
                          <span><?=$key['peso']?></span>
                        </td>
                        <td>
                          <span><?=$key['kilataje']?></span>
                        </td>
                        <td>
                          <span>$<?=$key['avaluo']?></span>
                        </td>
                        <td>
                          <span>$<?=$key['prestamo']?></span>
                        </td>
                        <td>
                          <a href="mprendaen.php?pid=<?=$key['pid']?>" class="remove-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update Piece">
                            <i class="ti-pencil-alt"></i>
                          </a>
                        </td>
                        <td style="text-align: center;">
                          <?php
                          if ($key['estado']==4) {
                            echo "Sold!";
                          }else{
                            ?>
                            <a href="ncontratoen.php?pid=<?=$key['pid']?>" class="remove-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="New Pledge">
                              <i class="ti-write"></i>
                            </a>
                            <?php
                          }
                          ?>
                        </td>
                        <td style="text-align: center;">
                          <?php
                          if($key['estado']==1 || $key['estado']==3){
                            ?>
                            <form method="post" target="_blank" action="vpdfen.php" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Archivo Abierto!">
                              <input type="hidden" value="<?=$key['pid']?>" name="pid" />
                              <button type="submit" style="margin-bottom: 5px; background-color: #63dd8d; border-color: #63dd8d">View Pledge</button>
                            </form>
                            <?php
                          }elseif($key['estado']==0){
                            echo "No pledge!<br>";
                          }elseif ($key['estado']==2) {
                            echo "Canceled!";
                          }elseif ($key['estado']==4) {
                            echo "Sold!";
                          }
                          ?>
                        </td>
                        <td style="text-align: center;">
                          <?php
                          if ($key['estado']==1 || $key['estado']==3) {
                            ?>
                            <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Mensaje eliminado!">
                              <input type="hidden" value="<?=$key['pid']?>" name="pid">
                              <input type="hidden" value="2" name="estado">
                              <button onclick="swal({   title: 'Cancel Pledge!',   text: 'Are you sure you want to finish the pledge?',   type: 'warning',   showCancelButton: true,   confirmButtonColor: '#DD6B55',   confirmButtonText: 'Pay!',   closeOnConfirm: false }, function(){ form.submit(); });" type="button" style="margin-bottom: 5px; background-color: #ff7673; border-color: #ff7673">Finish Pledge</button>
                            </form>
                            <?php
                          }elseif($key['estado']==0){
                            echo "No pledge!";
                          }elseif ($key['estado']==2) {
                            echo "Canceled!";
                          }elseif ($key['estado']==4) {
                            echo "Sold!";
                          }
                          ?>
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!--end of items-->
            </div>

            <!--end of row-->
          </div>
          <center>
            <?php $paginacion->render(); ?>
          </center>
          <!--end of container-->
        </section>
        <?php
      }
      ?>

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
