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

if (isset($_GET['cid'])) {
  $cid = $_GET['cid'];
  $show = "SELECT * FROM tbcliente WHERE cid='$cid'";
  $var = $con->query($show)->fetch_array();
  if (!$var) {
    header("location: vcliente.php");
    exit();
  }
} else {
  header("location: vcliente.php");
  exit();
}
if (isset($_POST['nombre'])) {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $telefono = $_POST['telefono'];
  $dui = $_POST['dui'];
  $email = $_POST['email'];
  $direccion = $_POST['direccion'];
  $sucursal = $_POST['sucursal'];
  $nit = $_POST['nit'];
  $fechanac = $_POST['fechanac'];

  $modi = "UPDATE tbcliente SET nombre='$nombre', apellido='$apellido', telefono='$telefono', dui='$dui', correo='$email', direccion='$direccion', nit='$nit', fechanac='$fechanac', sid='$sucursal' WHERE cid='$cid'";
  $vari = $con->query($modi);
}

if (isset($_POST['password1'])) {
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];

  if ($password1 == $password2) {
    $modi = "UPDATE tbcliente SET password='$password1' WHERE cid='$cid'";
    $vari = $con->query($modi);
  } else {
    header("location: mcliente.php?cid=$cid&msg=1");
    exit();
  }
}

if (isset($_POST['habilitado'])) {
  $habilitado = $_POST['habilitado'];
  $modi = "UPDATE tbcliente SET habilitado='$habilitado' WHERE cid='$cid'";
  $vari = $con->query($modi);
  header("location: mcliente.php?cid=$cid&msg=2");
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
                <a href="mcliente.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="mclienteen.php">ENGLISH</a>
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
    if(@$vari){
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "Empleado Modificado!", "success")
      </script>
      <?php
    }else{
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "¡Intente nuevamente!", "error");
      </script>
      <?php
    }
  } elseif (isset($_POST['password1'])) {
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
          <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
            <h4 class="uppercase mt48 mt-xs-0">Modificar Cliente</h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                Todos los campos son obligatorios.
              </h6>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Nombre:</span>
                <input type="text" name="nombre" value="<?=$var['nombre']?>" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Nombre" />
                <span>Apellido:</span>
                <input type="text" name="apellido" value="<?=$var['apellido']?>" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Apellido" />
                <span>DUI:</span>
                <input type="text" name="dui" value="<?=$var['dui']?>" maxlength="10" class="validate-required validate-dui" onpaste="return false" onkeypress="return solonumeros(this, '########-#',event)" placeholder="DUI" />
                <span>Dirección:</span>
                <input type="text" name="direccion" value="<?=$var['direccion']?>" maxlength="100" class="validate-required" placeholder="Dirección" />
                <span>Teléfono:</span>
                <input type="text" name="telefono" value="<?=$var['telefono']?>" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Teléfono" />
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>NIT:</span>
                <input type="text" name="nit" value="<?=$var['nit']?>" maxlength="17" class="validate-required validate-nit" onpaste="return false" onkeypress="return solonumeros(this, '####-######-###-#',event)" placeholder="NIT" />
                <span>Fecha de Nacimiento: Formato(Mes-Día-Año)</span>
                <input type="text" name="fechanac" value="<?=$var['fechanac']?>" maxlength="10" class="validate-required validate-fecha" onpaste="return false" onkeypress="return solonumeros(this, '##-##-####',event)" placeholder="Fecha de nacimiento" />
                <span>Correo:</span>
                <input type="text" name="email" value="<?=$var['correo']?>" class="validate-required validate-email" placeholder="Correo" />
                <span>Sucursal:</span>
                <?php
                $sidd = $var['sid'];
                $consultasucursal = "SELECT * FROM tbsucursal WHERE sid='$sidd'";
                $varsucursal = $con->query($consultasucursal)->fetch_array();
                $nombre = $varsucursal['nombre'];
                ?>
                <div class="select-option">
                  <i class="ti-angle-down"></i>
                  <select name="sucursal" required>
                    <option value="<?=$var['sid']?>" selected><?=$nombre?></option>
                    <?php
                    $consulta = "SELECT * FROM tbsucursal";
                    foreach ($con->query($consulta) as $key) {
                      ?>
                      <option value="<?=$key['sid']?>"><?=$key['nombre']?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="overflow-hidden">
              <div class="col-sm-6 col-sm-offset-3">
                <button type="submit">Guardar</button>
              </div>
            </div>
          </form>
          <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
            <div class="overflow-hidden">
              <hr>
              <div class="col-sm-6 col-sm-offset-3">
                <h6 class="uppercase">
                  Cambio de contraseña.
                </h6>
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Contraseña:</span>
                <input type="password" name="password1" class="validate-required" maxlength="32" onkeyup="muestra_seguridad_clave(this.value, this.form)" placeholder="Contraseña" />
                <span>Confirmar Contraseña:</span>
                <input type="password" name="password2" class="validate-required" maxlength="32" placeholder="Confirmar Contraseña" />
                <span>Seguridad de la Contraseña:</span>
                <input type="text" name="seguridad" class="validate-required validate-seguridad" onfocus="blur()" placeholder="Seguridad de la Contraseña" />
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <br>
                <button type="submit">Cambiar</button>
              </form>
              <?php
              if ($var['habilitado'] == 0) {
                ?>
                <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
                  <input type="hidden" value="1" name="habilitado">
                  <button type="submit">Habilitar</button>
                </form>
                <?php
              } else if ($var['habilitado'] == 1) {
                ?>
                <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
                  <input type="hidden" value="0" name="habilitado">
                  <button type="submit">Deshabilitar</button>
                </form>
                <?php
              }
              ?>
            </div>
          </div>
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
