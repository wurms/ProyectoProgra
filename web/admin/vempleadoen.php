<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=1){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
}
if (isset($_GET['n'])) {
  if ($_GET['n'] == 2 || $_GET['n'] == 3 || $_GET['n'] == 4 || $_GET['n'] == 0) {
    $nivel = $_GET['n'];
  }else{
    $nivel = 0;
  }
} else {
  $nivel = 0;
}

if ($nivel == 2) {
  $cargo = "Accountants";
} elseif ($nivel == 3) {
  $cargo = "Managers";
} elseif ($nivel == 4) {
  $cargo = "Tellers";
} else {
  $cargo = "Employess";
}

require_once("../zebra/zebra.php");
$contar = "SELECT * FROM tbempleado WHERE nivel='$nivel'";
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
                        <a href="vempleadoen.php?n=2">Accountants</a>
                      </li>
                      <li>
                        <a href="vempleadoen.php?n=3">Managers</a>
                      </li>
                      <li>
                        <a href="vempleadoen.php?n=4">Tellers</a>
                      </li>
                      <li>
                        <a href="vempleadoen.php?n=0">Employees</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Branches</span>
                      </li>
                      <li>
                        <a href="vsucursalen.php">Branches</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Clients</span>
                      </li>
                      <li>
                        <a href="vclienteen.php">Clients</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Messages</span>
                      </li>
                      <li>
                        <a href="mensajesen.php">Messages</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Reports</span>
                      </li>
                      <li>
                        <a href="reporteen.php">View Report</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="has-dropdown">
                <a href="#">
                  Add new
                </a>
                <ul class="mega-menu">
                  <li>
                    <ul>
                      <li>
                        <span class="title">Employee</span>
                      </li>
                      <li>
                        <a href="aempleadoen.php?n=2">Accountant</a>
                      </li>
                      <li>
                        <a href="aempleadoen.php?n=3">Manager</a>
                      </li>
                      <li>
                        <a href="aempleadoen.php?n=4">Teller</a>
                      </li>
                      <li>
                        <a href="aempleadoen.php?n=0">Employee</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Branches</span>
                      </li>
                      <li>
                        <a href="asucursalen.php">Branches</a>
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
                <a href="vempleadoen.php">ENGLISH</a>
                <ul>
                  <li>
                    <a href="vempleado.php">ESPAÑOL</a>
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
    <section class="fullscreen">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center">
            <h4 class="uppercase mb16"><?=$cargo?> List</h4>
            <p class="lead mb64">
              These are all the <?=$cargo?> in the platform.
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-100 col-md-offset-0 col-sm-100 col-sm-offset-0">
            <table class="table cart mb48">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Phone Number</th>
                  <th>DUI</th>
                  <th>Email</th>
                  <th>Branches</th>
                  <?php if ($cargo != "Empleados") {
                    ?> <th>Username</th> <?php
                  } ?>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_POST['busqueda'])) {
                  $busqueda = $_POST['busqueda'];
                  $consulta = "SELECT * FROM tbempleado WHERE nombre LIKE '$busqueda%' OR apellido LIKE '$busqueda%' OR dui LIKE '$busqueda%' LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
                  if (count($con->query($consulta)->fetch_array()) == 0) {
                    $consulta = "SELECT * FROM tbempleado WHERE nivel=$nivel LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
                    ?>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "No employee matched", "error");
                    </script>
                    <?php
                  }
                } else {
                  $consulta = "SELECT * FROM tbempleado WHERE nivel=$nivel LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
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
                    <td>
                      <?php $sid=$key['sid']; $csucursal = $con->query("SELECT * FROM tbsucursal WHERE sid='$sid'")->fetch_array(); ?>
                      <span><?=$csucursal['nombre']?></span>
                    </td>
                    <?php if ($cargo != "Empleados") {
                      ?> <td>
                        <span><?=$key['usuario']?></span>
                      </td> <?php
                    } ?>
                    <td>
                      <a href="mempleadoen.php?eid=<?=$key['eid']?>" class="remove-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update Employee">
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
