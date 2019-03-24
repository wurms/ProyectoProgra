<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=3){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
} elseif ($_SESSION['habilitado']!=1) {
  session_destroy();
  header("location: ../loginusuario.php?msg=4");
  exit();
}
$eid = $_SESSION['eid'];
$sid = $_SESSION['sucursal'];
$consulta = "SELECT * FROM tbempleado WHERE eid='$eid'";
$var = $con->query($consulta)->fetch_array();
$sconsulta = "SELECT * FROM tbsucursal WHERE sid='$sid'";
$svar = $con->query($sconsulta)->fetch_array();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pawnshop</title>
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
                                <a href="index.php">ESPAÑOL</a>
                                <ul>
                                    <li>
                                        <a href="indexen.php">ENGLISH</a>
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
        <section class="cover fullscreen image-slider slider-all-controls controls-inside parallax">
            <ul class="slides">
             <li class="overlay image-bg bg-light">
                <div class="background-image-holder">
                    <img alt="image" class="background-image" src="../img/jewelry.jpg" />
                </div>
                <div class="container v-align-transform">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 text-center">
                            <h1 class="mb40 mb-xs-16 large">¡Bienvenido!</h1>
                            <h6 class="uppercase mb16">Encargado.</h6>
                            <p class="lead mb40">
                                <?=$var['nombre']?> <?=$var['apellido']?>
                            </p>
                            <p>
                              <?=$svar['nombre']?>
                            </p>
                        </div>
                    </div>
                    <!--columna-->
                </div>
                <!--Contenedor 1-->
            </li>
            <li class="overlay image-bg">
                <div class="background-image-holder">
                    <img alt="image" class="background-image" src="../img/jewelry.jpg" />
                </div>
                <div class="container v-align-transform">
                    <div class="row">
                        <div class="col-sm-offset-1 text-center col-sm-10">
                            <h1 class="mb40 mb-xs-16 large">¡Bienvenido!</h1>
                            <h6 class="uppercase mb16">Encargado.</h6>
                            <p class="lead mb40">
                                <?=$var['nombre']?> <?=$var['apellido']?>
                            </p>
                            <p>
                              <?=$svar['nombre']?>
                            </p>
                        </div>
                    </div>
                    <!--columna-->
                </div>
                <!--Contenedor 1-->
            </li>
        </ul>
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
