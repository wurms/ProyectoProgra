<?php
date_default_timezone_set('America/Dawson');
session_start();
include("../conexion.php");
if ($_SESSION['nivel']!=2) {
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
} elseif ($_SESSION['habilitado']!=1) {
  session_destroy();
  header("location: ../loginusuario.php?msg=4");
  exit();
}

if (isset($_GET['p'])) {
  $planilla = $_GET['p'];
  $mes = $_GET['m'];
  $ano = $_GET['a'];
  $sid = $_GET['s'];

  if ($sid != 0) {
    $consulta = "SELECT * FROM tbplanilla WHERE planilla='$planilla' AND mes='$mes' AND ano='$ano' AND sid='$sid'";
    $var = $con->query($consulta)->fetch_all();
  } else {
    $consulta = "SELECT * FROM tbplanilla WHERE planilla='$planilla' AND mes='$mes' AND ano='$ano'";
    $var = $con->query($consulta)->fetch_all();
  }

  if (!$var) {
    header("location: splanillaen.php");
    exit();
  }
} else {
  header("location: splanillaen.php");
  exit();
}

if (isset($_POST['eid'])) {
  $eid = $_POST['eid'];
  $bonificacion = $_POST['bonificacion'.$eid];
  $vacaciones = $_POST['vacaciones'.$eid];
  $instfin = $_POST['instfin'.$eid];
  $odescuento = $_POST['odescuento'.$eid];

  $modificar = $con->query("UPDATE tbplanilla SET bonificacion='$bonificacion', vacaciones='$vacaciones', instfin='$instfin', odescuento='$odescuento' WHERE eid='$eid'");
}

require_once("../zebra/zebra.php");
$total_regitros = $con->query($consulta);
$resultados = 4;
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
                  View List
                </a>
                <ul class="mega-menu">
                  <li>
                    <ul>
                      <li>
                        <span class="title">Employees</span>
                      </li>
                      <li>
                        <a href="splanillaen.php">Payroll</a>
                      </li>
                      <li>
                        <a href="oficinaen.php">Office</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Pledges</span>
                      </li>
                      <li>
                        <a href="sreporteen.php">Operations Report</a>
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
                <a href="vplanillaen.php">ENGLISH</a>
                <ul>
                  <li>
                    <a href="vplanilla.php">ESPAÑOL</a>
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
  <?php if (@$modificar): ?>
    <script type="text/javascript">
    sweetAlert("GREAT!", "Payroll Saved!", "success");
    </script>
  <?php endif; ?>
  <div class="main-container">
    <?php
    if ($sid != 0) {
      $cplanilla = "SELECT * FROM tbplanilla WHERE planilla='$planilla' AND mes='$mes' AND ano='$ano' AND sid='$sid' LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
    } else {
      $cplanilla = "SELECT * FROM tbplanilla WHERE planilla='$planilla' AND mes='$mes' AND ano='$ano' LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
    }
    if (!($con->query($cplanilla)->fetch_array())) {
      ?>
      <section class="fullscreen">
        <div class="container">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4 class="uppercase mb16">Step to Payroll</h4>
              <p class="lead mb64">
                These are all the employees from the selected branch.
              </p>
            </div>
          </div>
          <!--end of row-->
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="alert alert-danger alert-dismissible" role="alert">
                <span aria-hidden="true">&times;</span>
                <strong>According to the platform!</strong> No clients registered
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
      <section class="fullscreen">
        <div class="container">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4 class="uppercase mb16">Step to Payroll</h4>
              <p class="lead mb64">
                These are all the employees from the selected branch.
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-9 col-md-offset-0 col-sm-10 col-sm-offset-1">
              <table class="table cart mb48">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Name</th>
                    <th>Salary</th>
                    <th>Workdays</th>
                    <th>Overtime</th>
                    <th>Bonds</th>
                    <th>Vacations</th>
                    <th>Fin. Inst.</th>
                    <th>Discount</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($con->query($cplanilla) as $key) {
                    $eid = $key['eid'];
                    $cempleado = $con->query("SELECT * FROM tbempleado WHERE eid='$eid'")->fetch_array();
                    ?>
                    <tr>
                      <td>
                        <span><?=$cempleado['eid']?></span>
                      </td>
                      <td>
                        <span><?=$cempleado['nombre']?> <?=$cempleado['apellido']?></span>
                      </td>
                      <td>
                        <span>$<?=$key['sueldo']?></span>
                      </td>
                      <td>
                        <span><?=$key['dias']?></span>
                      </td>
                      <td>
                        <span><?=$key['extras']?></span>
                      </td>
                      <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Guardado!">
                        <td>
                          <input style="margin-bottom: 0px; width: 75px; background: whitesmoke;" type="number" step="any" min="0" name="bonificacion<?=$key['eid']?>" value="<?=$key['bonificacion']?>" class="validate-required" />
                        </td>
                        <td>
                          <input style="margin-bottom: 0px; width: 75px; background: whitesmoke;" type="number" step="any" min="0" name="vacaciones<?=$key['eid']?>" value="<?=$key['vacaciones']?>" class="validate-required" />
                        </td>
                        <td>
                          <input style="margin-bottom: 0px; width: 75px; background: whitesmoke;" type="number" step="any" min="0" name="instfin<?=$key['eid']?>" value="<?=$key['instfin']?>" class="validate-required" />
                        </td>
                        <td>
                          <input style="margin-bottom: 0px; width: 75px; background: whitesmoke;" type="number" step="any" min="0" name="odescuento<?=$key['eid']?>" value="<?=$key['odescuento']?>" class="validate-required" />
                        </td>
                        <td>
                          <input type="hidden" name="eid" value="<?=$key['eid']?>">
                          <button style="margin-bottom: 0px; width: 50px; height: 50px; background: #6cbcd5; border-color: #6cbcd5;" type="submit"><i class="ti-pencil-alt"></i></button>
                        </td>
                      </form>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!--end of items-->
            <div class="col-md-3 col-md-offset-0 col-sm-10 col-sm-offset-1">
              <div class="mb24">
                <?php
                if ($planilla == 1) {
                  ?>
                  <h5 class="uppercase">Firs Half</h5>
                  <?php
                } else {
                  ?>
                  <h5 class="uppercase">Second Half</h5>
                  <?php
                }
                ?>
                <table class="table">
                  <tbody>
                    <tr>
                      <th scope="row">Year</th>
                      <td><?=$ano?></td>
                    </tr>
                    <tr>
                      <th scope="row">Month</th>
                      <td>
                        <?php
                        if ($mes == 1) {
                          ?>
                          January
                          <?php
                        } elseif ($mes == 2) {
                          ?>
                          February
                          <?php
                        } elseif ($mes == 3) {
                          ?>
                          March
                          <?php
                        } elseif ($mes == 4) {
                          ?>
                          April
                          <?php
                        } elseif ($mes == 5) {
                          ?>
                          May
                          <?php
                        } elseif ($mes == 6) {
                          ?>
                          June
                          <?php
                        } elseif ($mes == 7) {
                          ?>
                          July
                          <?php
                        } elseif ($mes == 8) {
                          ?>
                          Agost
                          <?php
                        } elseif ($mes == 9) {
                          ?>
                          September
                          <?php
                        } elseif ($mes == 10) {
                          ?>
                          October
                          <?php
                        } elseif ($mes == 11) {
                          ?>
                          November
                          <?php
                        } elseif ($mes == 12) {
                          ?>
                          Dicember
                          <?php
                        }
                        ?>
                      </td>
                    </tr>
                    <?php if ($sid != 0): ?>
                      <tr>
                        <?php $csucursal = $con->query("SELECT * FROM tbsucursal WHERE sid='$sid'")->fetch_array(); ?>
                        <th scope="row">
                          Branch
                        </th>
                        <td>
                          <?=$csucursal['nombre']?>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                <form method="post" target="_blank" action="planillaen.php" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Archivo Abierto!">
                  <input type="hidden" name="ano" value="<?=$ano?>">
                  <input type="hidden" name="mes" value="<?=$mes?>">
                  <input type="hidden" name="planilla" value="<?=$planilla?>">
                  <input type="hidden" name="sid" value="<?=$sid?>">
                  <button type="submit" style="margin-bottom: 5px; background-color: #63dd8d; border-color: #63dd8d">View PDF</button>
                </form>
              </div>
            </div>
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
