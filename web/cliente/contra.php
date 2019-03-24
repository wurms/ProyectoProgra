<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=6){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
} elseif ($_SESSION['estado']!=1) {
  session_destroy();
  header("location: ../loginusuario.php?msg=5");
  exit();
}
$cid = $_SESSION['cid'];
if (isset($_POST['password1'])) {
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];

  if ($password1 == $password2) {
    $modi = "UPDATE tbcliente SET password='$password1' WHERE cid='$cid'";
    $vari = $con->query($modi);
  } else {
    header("location: conta.php?msg=1");
    exit();
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
                        <span class="title">Contratos</span>
                      </li>
                      <li>
                        <a href="contratos.php">Mis Prendas</a>
                        <?php
                        $hoy = date("m/d/o");
                        $cid = $_SESSION['cid'];
                        $vencidos = "SELECT * FROM tbprenda WHERE estado='3' AND cid='$cid' AND renovacion!='1'";
                        $plazo = date('m/d/o', strtotime('+6 day')) ;
                        $porvencer = "SELECT * FROM tbprenda WHERE estado='1' AND cid='$cid'";
                        $oids = array();
                        foreach ($con->query($porvencer) as $key) {
                          array_push($oids, $key['pid']);
                        }
                        $cporvencer = "SELECT * FROM tboperacion WHERE plazomaximo < '$plazo' AND plazomaximo > '$hoy' AND estado='1'";
                        $n = 0;
                        $m = 0;
                        $correo = $_SESSION['email'];
                        foreach ($con->query($cporvencer) as $key) {
                          if (in_array($key['pid'], $oids)) {
                            $m+=1;
                          }
                        }
                        foreach ($con->query($vencidos) as $key) {
                          $n+=1;
                        }
                        if ($n > 0) {
                          ?>
                          <span class="label2"><?=$n?></span>
                          <?php
                        }
                        if ($m > 0) {
                          ?>
                          <span class="label1"><?=$m?></span>
                          <?php
                        }
                        ?>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li>
                <a href="contra.php">Cambiar Contraseña</a>
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
                <a href="contra.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="contraen.php">ENGLISH</a>
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
  if (isset($_POST['password1'])) {
    if(@$vari){
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "¡Contraseña cambiada!", "success")
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
  if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 1) {
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "¡Nuevas contraseñas no coinciden!", "error");
      </script>
      <?php
    } elseif ($_GET['msg'] == 2) {
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "¡Cambios hechos!", "success")
      </script>
      <?php
    }
  }
  ?>
  <div class="main-container">
    <section>
      <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="feature boxed bg-secondary">
          <center>
          <h4 class="uppercase mt48 mt-xs-0">Modificar Contraseña</h4>
        </center>
          <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
            <div class="overflow-hidden">
              <hr>
              <div class="col-sm-6 col-sm-offset-3">
                <h6 class="uppercase">
                  Todos los campos son obligatorios.
                </h6>
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Contraseña:</span>
                <input type="password" name="password1" class="validate-required" maxlength="32" onkeyup="muestra_seguridad_clave(this.value, this.form)" placeholder="Contraseña" />
                <span>Confirmar Contraseña:</span>
                <input type="password" name="password2" class="validate-required" maxlength="32" placeholder="Confirmar Contraseña" />
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Seguridad de la Contraseña:</span>
                <input type="text" name="seguridad" class="validate-required validate-seguridad" onfocus="blur()" placeholder="Seguridad de la Contraseña" />
              </div>
            </div>
            <div class="overflow-hidden">
              <div class="col-sm-6 col-sm-offset-3">
                <button type="submit">Cambiar</button>
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
