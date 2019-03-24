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
if (isset($_POST['cid'])) {
  $sid = $_SESSION['sucursal'];
  $eid = $_SESSION['eid'];
  $cid = $_POST['cid'];
  for ($j=1; $j <= $_POST['mat']; $j++) {
    $caracteristicas = $_POST['caracteristicas'.$j];
    $peso = $_POST['peso'.$j];
    $kilatage = $_POST['kilatage'.$j];
    $calidad = $_POST['calidad'.$j];
    $piedra = $_POST['piedra'.$j];
    $c = $kilatage/24;
    $avaluo = round(((1342.60/31.1034768)*$c)*$peso, 2);
    $prestamo = round((90*$avaluo)/100, 2);

    $insertar = "INSERT INTO tbprenda VALUES('','1','$caracteristicas','$peso','$kilatage','$calidad','$piedra','$avaluo','$prestamo','$sid','$eid','$cid','0','')";
    $var = $con->query($insertar);
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
                  Agregar nuevo
              </a>
              <ul class="mega-menu">
                  <li>
                      <ul>
                          <li>
                              <span class="title">Prestamos</span>
                          </li>
                          <li>
                              <a href="cprenda.php">Prenda</a>
                          </li>
                      </ul>
                  </li>
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
                              <a href="scontrato.php">Ver contratos</a>
                          </li>
                      </ul>
                  </li>
                  <li>
                      <ul>
                          <li>
                              <span class="title">Clientes</span>
                          </li>
                          <li>
                              <a href="vcliente.php">Cliente</a>
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
                <a href="cprenda.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="cprendaen.php">ENGLISH</a>
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
    if ($_GET['msg']==3) {
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "¡DUI no existe!", "error");
      </script>
      <?php
    }
  }
  if (isset($_POST['cid'])) {
    if ($var) {
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "¡Prenda ingresada!", "success");
      </script>
      <?php
    } else {
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
          <form method="post" action="nprenda.php" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!" enctype="multipart/form-data">
            <h4 class="uppercase mt48 mt-xs-0">Nueva Prenda</h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                Todos los campos son obligatorios.
              </h6>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>DUI:</span>
                <input type="text" minlength="10" name="dui" maxlength="10" class="validate-required validate-dui" onpaste="return false" onkeypress="return solonumeros(this, '########-#',event)" placeholder="DUI" required/>
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Cantidad de Prendas:</span>
                <input type="number" name="matriz" max="5" min="1" class="validate-required validate-dies" onpaste="return false" placeholder="Cantidad de Prendas" required/>
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
