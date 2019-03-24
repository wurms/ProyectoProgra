<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=1){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
}

if (isset($_GET['sid'])) {
  $sid = $_GET['sid'];
  $show = "SELECT * FROM tbsucursal WHERE sid='$sid'";
  $var = $con->query($show)->fetch_array();
  if (!$var) {
    header(("location: vsucursal.php"));
    exit();
  }
} else {
  header("location: vsucursal.php");
  exit();
}

if(isset($_POST['nombre'])){
  $nombre = $_POST['nombre'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];
  $presupuesto = $_POST['presupuesto'];

  $modi = "UPDATE tbsucursal SET nombre='$nombre', direccion='$direccion', telefono='$telefono', presupuesto='$presupuesto' WHERE sid='$sid'";
  $vari = $con->query($modi);
}
if (isset($_POST['eliminar'])) {
  $eliminar = "DELETE FROM tbsucursal WHERE sid='$sid'";
  $vareliminar = $con->query($eliminar);
  header("location: vsucursal.php");
  exit();
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
                        <a href="vempleado.php?n=2">Contadores</a>
                      </li>
                      <li>
                        <a href="vempleado.php?n=3">Encargados</a>
                      </li>
                      <li>
                        <a href="vempleado.php?n=4">Cajeros</a>
                      </li>
                      <li>
                        <a href="vempleado.php?n=0">Empleados</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Sucursales</span>
                      </li>
                      <li>
                        <a href="vsucursal.php">Sucursales</a>
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
                        <span class="title">Mensajes</span>
                      </li>
                      <li>
                        <a href="mensajes.php">Mensajes</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Reportes</span>
                      </li>
                      <li>
                        <a href="reporte.php">Ver Reporte</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="has-dropdown">
                <a href="#">
                  Agregar nuevo
                </a>
                <ul class="mega-menu">
                  <li>
                    <ul>
                      <li>
                        <span class="title">Trabajador</span>
                      </li>
                      <li>
                        <a href="aempleado.php?n=2">Contador</a>
                      </li>
                      <li>
                        <a href="aempleado.php?n=3">Encargado</a>
                      </li>
                      <li>
                        <a href="aempleado.php?n=4">Cajero</a>
                      </li>
                      <li>
                        <a href="aempleado.php?n=0">Empleado</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Sucursal</span>
                      </li>
                      <li>
                        <a href="asucursal.php">Sucursal</a>
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
                <a href="msucursal.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="msucursalen.php">ENGLISH</a>
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
  if(isset($_POST['nombre'])){
    if(@$var){
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "¡Sucursal modificada!", "success")
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
            <h4 class="uppercase mt48 mt-xs-0">Modificar Sucursal</h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                Todos los campos son obligatorios.
              </h6>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Nombre:</span>
                <input type="text" name="nombre" value="<?=$var['nombre']?>" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Nombre" />
                <span>Dirección:</span>
                <input type="text" name="direccion" value="<?=$var['direccion']?>" class="validate-required" onpaste="return false" maxlength="50" placeholder="Dirección" />
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Teléfono:</span>
                <input type="text" name="telefono" value="<?=$var['telefono']?>" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Teléfono" />
                <span>Presupuesto $</span>
                <input type="number" step="any" min="0" name="presupuesto" value="<?=$var['presupuesto']?>" class="validate-required" placeholder="Presupuesto" />
              </div>
              <hr>
            </div>
            <div class="overflow-hidden">
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <button type="submit">Ingresar</button>
              </div>
            </form>
            <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="Sucursal eliminada">
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <input type="hidden" name="eliminar">
                <button style="background: red; border-color: red;" type="submit">Eliminar</button>
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
