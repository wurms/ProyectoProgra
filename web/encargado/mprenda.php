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

if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
  $show = "SELECT * FROM tbprenda WHERE pid='$pid'";
  $var = $con->query($show)->fetch_array();
  if (!$var) {
    header("location: scontrato.php");
    exit();
  }
} else {
  header("location: scontrato.php");
  exit();
}
if (isset($_POST['caracteristicas'])) {
  $caracteristicas = $_POST['caracteristicas'];
  $peso = $_POST['peso'];
  $kilatage = $_POST['kilatage'];
  $calidad = $_POST['calidad'];
  $piedra = $_POST['piedra'];
  $c = $kilatage/24;
  $avaluo = round(((1367.55/31.1034768)*$c)*$peso, 2);
  $prestamo = round((90*$avaluo)/100, 2);

  $modi = "UPDATE tbprenda SET caracteristicas='$caracteristicas', peso='$peso', kilataje='$kilatage', calidad='$calidad', piedra='$piedra', avaluo='$avaluo', prestamo='$prestamo' WHERE pid='$pid'";
  $vari = $con->query($modi);
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
          <li>
            <a href="planilla.php">
              Planilla
            </a>
          </li>
          <li class="has-dropdown">
              <a href="#">
                  Agregar nuevo
              </a>
              <ul class="mega-menu">
                  <li>
                      <ul>
                          <li>
                              <span class="title">Clientes</span>
                          </li>
                          <li>
                              <a href="ncliente.php">Cliente</a>
                          </li>
                      </ul>
                  </li>
                  <li>
                      <ul>
                          <li>
                              <span class="title">Empleados</span>
                          </li>
                          <li>
                              <a href="aempleado.php?n=4">Cajero</a>
                          </li>
                          <li>
                              <a href="aempleado.php?n=0">Empleado</a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </li>
          <li class="has-dropdown">
              <a href="#">
                  Ver listado
              </a>
              <ul class="mega-menu">
                  <li>
                      <ul>
                          <li>
                              <span class="title">Contratos</span>
                          </li>
                          <li>
                              <a href="vtcontrato.php">Contratos</a>
                          </li>
                          <li>
                              <a href="scontrato.php">Contratos por Busqueda</a>
                          </li>
                          <li>
                              <a href="contratop.php">Contratos pagados</a>
                          </li>
                          <li>
                              <a href="contratonp.php">Contratos no pagados</a>
                          </li>
                          <li>
                              <a href="sresumen.php">Resumen de operaciones</a>
                          </li>
                      </ul>
                  </li>
                  <li>
                      <ul>
                          <li>
                              <span class="title">Clientes</span>
                          </li>
                          <li>
                              <a href="vcliente.php">Clientes</a>
                          </li>
                      </ul>
                  </li>
                  <li>
                      <ul>
                          <li>
                              <span class="title">Empleados</span>
                          </li>
                          <li>
                              <a href="vempleado.php?n=4">Cajeros</a>
                          </li>
                          <li>
                              <a href="vempleado.php?n=0">Empleados</a>
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
                <a href="mprenda.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="mprendaen.php">ENGLISH</a>
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
  if(isset($_POST['caracteristicas'])){
    if(@$vari){
      ?>
      <script type="text/javascript">
        swal("¡BUEN TRABAJO!", "¡Prenda Modificada!", "success")
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
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
      <div class="feature boxed bg-secondary">
        <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
         <h4 class="uppercase mt48 mt-xs-0">Modificar Prenda</h4>
         <div class="overflow-hidden">
          <hr>
          <h6 class="uppercase">
            Todos los campos son obligatorios.
          </h6>
          <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
            <span>Características:</span>
            <input type="text" name="caracteristicas" value="<?=$var['caracteristicas']?>" maxlength="30" class="validate-required" onpaste="return false" placeholder="Características" />
            <span>Peso (g):</span>
            <input type="number" step="any" min="0" name="peso" value="<?=$var['peso']?>" class="validate-required" placeholder="Peso (kg)" />
            <span>Kilatage:</span>
            <select name="kilatage">
              <option><?=$var['kilataje']?></option>
              <option>8</option>
              <option>10</option>
              <option>12</option>
              <option>14</option>
              <option>18</option>
              <option>21</option>
            </select>
          </div>
          <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
            <span>Calidad:</span>
            <select name="calidad">
              <option><?=$var['calidad']?></option>
              <option>Mala</option>
              <option>Usado</option>
              <option>Bueno</option>
              <option>Excelente</option>
            </select>
            <span>Piedra:</span>
            <select name="piedra">
              <option><?=$var['piedra']?></option>
              <option>Ninguna</option>
              <option>Diamante</option>
              <option>Esmeralda</option>
            </select>
          </div>
        </div>
      <div class="overflow-hidden">
        <div class="col-sm-6 col-sm-offset-3">
          <button type="submit">Guardar</button>
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
