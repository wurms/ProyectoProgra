<?php
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

if (isset($_POST['fecha'])) {
  $fecha = $_POST['fecha'];

  list($mes, $dia, $ano) = explode('/', $fecha);

  $csucursales = "SELECT * FROM tbsucursal WHERE sid!=1";

  $creporte = "SELECT * FROM tbreporte WHERE dia='$dia' AND mes='$mes' AND ano='$ano'";
  $vreporte = $con->query($creporte)->fetch_array();

  if ($vreporte) {
    header("location: reporte.php?mes=$mes&dia=$dia&ano=$ano");
    exit();
  } else {
    foreach ($con->query($csucursales) as $key) {
      $pids = array();
      $sid = $key['sid'];
      $presupuestoc = $key['presupuesto'];
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

      $coperacionactuales = "SELECT * FROM tboperacion WHERE estado='1' AND fecha='$fecha'";
      foreach ($con->query($coperacionactuales) as $key) {
        if (in_array($key['pid'], $pids)) {
          $acontratos+=1;
          $amontodelmutuo += $key['montodelmutuo'];
        }
      }

      $coperacionfinali = "SELECT * FROM tboperacion WHERE estado='2' AND fecha='$fecha'";
      foreach ($con->query($coperacionfinali) as $key) {
        if (in_array($key['pid'], $pids)) {
          $bcontratos+=1;
          $bmontodelmutuo += $key['montodelmutuo'];
          $bintereses += $key['intereses']*3;
          $biva += $key['iva'];
        }
      }

      $coperacionvenci = "SELECT * FROM tboperacion WHERE estado='3' AND fecha='$fecha'";
      foreach ($con->query($coperacionvenci) as $key) {
        if (in_array($key['pid'], $pids)) {
          $ccontratos+=1;
          $cmontodelmutuo += $key['montodelmutuo'];
          $cintereses += $key['intereses']*3;
          $civa += $key['iva'];
        }
      }

      $coperacionvendi = "SELECT * FROM tboperacion WHERE estado='4' AND fecha='$fecha'";
      foreach ($con->query($coperacionvendi) as $key) {
        if (in_array($key['pid'], $pids)) {
          $dcontratos+=1;
          $dmontodelmutuo += $key['montodelmutuo'];
          $dintereses += $key['intereses']*3;
          $diva += $key['iva'];
          $dmora += $key['mora'];
        }
      }

      $btotalcobrado = $bintereses + $biva + $bmontodelmutuo;
      $dtotalcobrado = $dintereses + $diva + $dmontodelmutuo;

      $ingresos = $btotalcobrado + $dtotalcobrado;
      $egresos = $amontodelmutuo;
      $iva = $biva + $civa + $diva;

      $acumulado = $presupuestoc;
      $finalmes = $acumulado+($ingresos-$egresos);

      if ($dia == 01) {
        $insertar = "INSERT INTO tbreporte VALUES('','$sid','$dia','$mes','$ano','$acumulado','$acumulado','$acumulado','$finalmes','$acumulado','$acumulado','$finalmes')";
        $var = $con->query($insertar);
      } else {
        $anterior = $dia -1;
        $antes = '0'.$anterior;

        $creport = "SELECT * FROM tbreporte WHERE dia='$antes' AND mes='$mes' AND ano='$ano' AND sid='$sid'";
        $vreport = $con->query($creport)->fetch_array();

        if ($vreport) {
          $acumuladob = $vreport['acumulado'];
          $finalmb = $vreport['finalm'];
          $finalab = $vreport['finala'];
          $presupuestob = $vreport['presupuesto'];
          $iniciomb = $vreport['iniciom'];
          $inicioab = $vreport['inicioa'];
          $presupuestodemesb = $vreport['presupuestodemes'];

          $acumulado = $acumuladob+($ingresos-$egresos);
          $finalm = $finalmb+($ingresos-$egresos);
          $finala = $finalab+($ingresos-$egresos);

          $insertar = "INSERT INTO tbreporte VALUES('','$sid','$dia','$mes','$ano','$presupuestob','$acumulado','$iniciomb','$finalm','$presupuestodemesb','$inicioab','$finala')";
          $var = $con->query($insertar);
        }
      }
    }
    if ($var) {
      header("location: reporte.php?mes=$mes&dia=$dia&ano=$ano");
      exit();
    } else {
      header("location: sreporte.php?msg=1");
      exit();
    }
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
                <a href="index.php">
                  Inicio
                </a>
              </li>
              <li class="has-dropdown">
                <a href="#">
                  Ver listado
                </a>
                <ul class="mega-menu">
                  <li>
                    <ul>
                      <li>
                        <span class="title">Trabajadores</span>
                      </li>
                      <li>
                        <a href="splanilla.php">Planilla</a>
                      </li>
                      <li>
                        <a href="oficina.php">Oficina</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Contratos</span>
                      </li>
                      <li>
                        <a href="sreporte.php">Reporte de operaciones</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li>
                <a href="../cerrar.php">
                  Salir
                </a>
              </li>
            </ul>
          </div>
          <!--Final del menu-->
          <div class="module widget-handle language left">
            <ul class="menu">
              <li class="has-dropdown">
                <a href="sreporte.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="sreporteen.php">ENGLISH</a>
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
  if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 1 ) {
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "Verifique la fecha que ingresó. No tiene registro previo.", "error");
      </script>
      <?php
    }
  }
  ?>
  <div class="main-container">
    <br>
    <section class="fullscreen">
      <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="feature boxed bg-secondary">
          <form method="post" target="_blank" class="text-center form-envio" data-error="Fecha ingresada incorrectamente" data-success="¡Completado!">
            <h4 class="uppercase mt48 mt-xs-0">Visualizar Resumen de Operaciones</h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                Todos los campos son obligatorios.
              </h6>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <input type="text" name="fecha" minlength="10" maxlength="10" class="validate-required validate-fecha2" onpaste="return false" onkeypress="return solonumeros(this, '##/##/####',event)" placeholder="Fecha (MM/DD/AAAA)" required/>
              </div>
            </div>
            <div class="overflow-hidden">
              <div class="col-sm-6 col-sm-offset-3">
                <button type="submit">Continuar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer-1 bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <span class="sub">CSSC 2016 - Pawnshop System | <a target="_blank" href="../usuario.pdf">Ayuda</a></span>
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
