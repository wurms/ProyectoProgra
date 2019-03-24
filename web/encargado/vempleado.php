<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=3){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
}
if (isset($_GET['n'])) {
  if ($_GET['n'] == 4) {
    $nivel = $_GET['n'];
  }else{
    $nivel = 0;
  }
} else {
  $nivel = 0;
}

$sid = $_SESSION['sucursal'];

if ($nivel == 2) {
  $cargo = "Contadores";
} elseif ($nivel == 3) {
  $cargo = "Encargados";
} elseif ($nivel == 4) {
  $cargo = "Cajeros";
} elseif ($nivel == 5) {
  $cargo = "Ingresadores";
} else {
  $cargo = "Empleados";
}

require_once("../zebra/zebra.php");
$contar = "SELECT * FROM tbempleado WHERE nivel='$nivel' AND sid='$sid'";
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
        <div class="module widget-handle search-widget-handle left">
          <div class="search">
            <i class="ti-search"></i>
            <span class="title">Buscador</span>
          </div>
          <div class="function">
            <form class="search-form" method="post" action="vempleado.php?n=0">
              <input type="text" name="busqueda" maxlength="30" placeholder="Buscar" />
            </form>
          </div>
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
                <a href="vempleado.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="vempleadoen.php">ENGLISH</a>
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
    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center">
            <h4 class="uppercase mb16">Listado de <?=$cargo?></h4>
            <p class="lead mb64">
              Esto son todos los <?=$cargo?> de la plataforma.
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-100 col-md-offset-0 col-sm-100 col-sm-offset-0">
            <table class="table cart mb48">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>DUI</th>
                  <th>Correo</th>
                  <?php if ($cargo != "Empleados") {
                    ?> <th>Usuario</th> <?php
                  } ?>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_POST['busqueda'])) {
                  $busqueda = $_POST['busqueda'];
                  $consulta = "SELECT * FROM tbempleado WHERE nombre LIKE '$busqueda%' OR apellido LIKE '$busqueda%' OR dui LIKE '$busqueda%' AND sid='$sid' LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
                  if (count($con->query($consulta)->fetch_array()) == 0) {
                    $consulta = "SELECT * FROM tbempleado WHERE nivel=$nivel AND sid='$sid' LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
                    ?>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "Ningun cliente encontrado", "error");
                    </script>
                    <?php
                  }
                } else {
                  $consulta = "SELECT * FROM tbempleado WHERE nivel=$nivel AND sid='$sid' LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
                }
                foreach ($con->query($consulta) as $key) {
                  ?>
                  <tr>
                    <td>
                      <span><?=$key['eid']?></span>
                    </td>
                    <td>
                      <span><?=$key['nombre']?> <?=$key['apellido']?></span>
                    </td>
                    <td>
                      <span><?=$key['telefono']?></span>
                    </td>
                    <td>
                      <span><?=$key['dui']?></span>
                    </td>
                    <td>
                      <span><?=$key['correo']?></span>
                    </td>
                    <?php if ($cargo != "Empleados") {
                      ?> <td>
                        <span><?=$key['usuario']?></span>
                      </td> <?php
                    } ?>
                    <td>
                      <a href="mempleado.php?eid=<?=$key['eid']?>" class="remove-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modificar Empleado">
                        <i class="ti-pencil-alt"></i>
                      </a>
                    </td>
                  </tr>
                  <?php } ?>


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
