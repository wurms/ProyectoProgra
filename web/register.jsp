<%--
<?php
include("conexion.php");

function generarCodigo($longitud) {
 $key = '';
 $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
 $max = strlen($pattern)-1;
 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
   return $key;
}

if(isset($_POST['nombre'])){
  if ($_FILES["foto_dui"]["error"] > 0 || $_FILES["foto_perfil"]["error"] > 0){
    echo "Problemas al subir las fotografías";
  } else {
    $jpg = array("image/jpg", "jpg");
    $jpeg = array("image/jpeg", "jpeg");
    $png = array("image/png", "png");
    $limite_kb = 600;
    $dui = $_POST['dui'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nit = $_POST['nit'];
    $fechanac = $_POST['fechanac'];
    $correo = $_POST['email'];
    $password1 = generarCodigo(6);
    $sucursal = $_POST['sucursal'];
    $habilitado = 1;

    if (in_array($_FILES['foto_dui']['type'], $jpg)) {
      $nombred = $dui."d.jpg";
    }elseif (in_array($_FILES['foto_dui']['type'], $jpeg)) {
      $nombred = $dui."d.jpeg";
    }elseif (in_array($_FILES['foto_dui']['type'], $png)) {
      $nombred = $dui."d.png";
    }

    if (in_array($_FILES['foto_perfil']['type'], $jpg)) {
      $nombrep = $dui."p.jpg";
    }elseif (in_array($_FILES['foto_perfil']['type'], $jpeg)) {
      $nombrep = $dui."p.jpeg";
    }elseif (in_array($_FILES['foto_perfil']['type'], $png)) {
      $nombrep = $dui."p.png";
    }

    $show = "SELECT * FROM tbcliente";
    $vars = $con->query($show)->fetch_all();

    if ($_FILES['foto_dui']['size'] <= $limite_kb * 1024 || $_FILES['foto_perfil']['size'] <= $limite_kb * 1024){
      $rutad = "fotos/" . $nombred;
      $rutap = "fotos/" . $nombrep;
      if ($vars[0][1] != $dui){
        $resultadod = @move_uploaded_file($_FILES["foto_dui"]["tmp_name"], $rutad);
        $resultadop = @move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $rutap);
        if ($resultadod && $resultadop){

          $insertar = "INSERT INTO tbcliente VALUES('','$dui','$nombre','$apellido','$direccion','$telefono','$nit','$nombred','$nombrep','$fechanac','$correo','$password1','$sucursal','$habilitado')";
          $var = $con->query($insertar);

          $subject = "Inicio de Sesión";
          $txt = "¡Bienvenid@ a nuestra comunidad!\r\nPara veríficar este correo y que puedas entrar a nuestra plataforma dirigete a iniciar sesión. \r\nTu contraseña: ".$password1."\r\nInicia sesión en: http://www.learntodrivecssc.com/loginusuario.php";

          $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
          $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

          $cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
          $cabeceras .= 'From: PawnshopSystem <pawnshop@example.com>' . "\r\n";
          $cabeceras .= 'Cc: pawnshop@example.com' . "\r\n";
          $cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";

          mail($correo,$subject,$txt,$cabeceras);
        }
      }else {
        header("location: ncliente.php?msg=2");
        exit();
      }
    }else {
      header("location: ncliente.php?msg=1");
      exit();
    }
  }
}
?>
--%>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Seguros El Salvador</title>
  <script src="sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="sweetalert/dist/sweetalert.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  <link href="css/themify-icons.css" rel="stylesheet" type="text/css" media="all" />
  <link href="css/flexslider.css" rel="stylesheet" type="text/css" media="all" />
  <link href="css/lightbox.min.css" rel="stylesheet" type="text/css" media="all" />
  <link href="css/ytplayer.css" rel="stylesheet" type="text/css" media="all" />
  <link href="css/theme.css" rel="stylesheet" type="text/css" media="all" />
  <link href="css/custom.css" rel="stylesheet" type="text/css" media="all" />
  <link href='http://fonts.googleapis.com/css?family=Lato:300,400%7CRaleway:100,400,300,500,600,700%7COpen+Sans:400,500,600' rel='stylesheet' type='text/css'>
</head>
<body class="scroll-assist">
  <div class="nav-container">
    <a id="top"></a>
    <nav class="bg-dark">
      <div class="nav-bar">
        <div class="module left">
          <a href="index.html">
            <h5>Seguros El Salvador</h5>
          </a>
        </div>
        <div class="module widget-handle mobile-toggle right visible-sm visible-xs">
          <i class="ti-menu"></i>
        </div>
        <div class="module-group right">
          <div class="module left">
            <ul class="menu">
              <li>
                <a href="index.html">
                  Inicio
                </a>
              </li>
              <li>
                <a href="contactanos.jsp">
                  Contáctanos
                </a>
              </li>
              <li>
                <a href="loginusuario.jsp">
                  Iniciar Sesión
                </a>
              </li>
            </ul>
          </div>
          <!--Final del menu-->
        </div>
        <!--Final idioma-->
      </div>
    </nav>
  </div>
  <%--
  <?php
  if(isset($_POST['nombre'])){
    if($var){
      ?>
      <script type="text/javascript">
        swal("¡BUEN TRABAJO!", "¡Cliente ingresado!", "success")
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
    if ($_GET['msg'] == 1 ) {
      ?>
      <script type="text/javascript">
        sweetAlert("¡ERROR!", "¡Archivo no permitido!", "error");
      </script>
      <?php
    }elseif ($_GET['msg'] == 2) {
      ?>
      <script type="text/javascript">
        sweetAlert("¡ERROR!", "¡DUI actualmente existente!", "error");
      </script>
      <?php
    }
  }
  ?>
  --%>
  <div class="main-container">
    <section class="cover fullscreen image-bg overlay">
      <div class="background-image-holder">
        <img alt="image" class="background-image" src="img/login.jpg" />
      </div>
      <div class="container v-align-transform">
        <div class="row">
          <div class="col-md-12 col-md-offset-0 col-sm-1 col-sm-offset-1">
            <div class="feature boxed bg-secondary">
              <form method="post" class="text-center form-envio" data-success="¡Nuevo miembro ingresado!" enctype="multipart/form-data">
               <center><h4 class="uppercase">Registrarse</h4></center>
               <div class="overflow-hidden">
                <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                  <span>DUI:</span>
                  <input type="text" name="dui" maxlength="10" class="validate-required validate-dui" onpaste="return false" onkeypress="return solonumeros(this, '########-#',event)" placeholder="DUI" />
                  <span>Nombre:</span>
                  <input type="text" name="nombre" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Nombre" />
                  <span>Apellido:</span>
                  <input type="text" name="apellido" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Apellido" />
                  <span>Dirección:</span>
                  <input type="text" name="direccion" maxlength="100" class="validate-required" placeholder="Dirección" />
                </div>
                <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                  <span>Ocupación:</span>
                  <input type="text" name="ocupacion" maxlength="100" class="validate-required" placeholder="Ocupación" />
                  <span>Teléfono:</span>
                  <input type="text" name="telefono" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Teléfono" />
                  <span>Celular:</span>
                  <input type="text" name="celular" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Celular" />
                  <span>NIT:</span>
                  <input type="text" name="nit" maxlength="17" class="validate-required validate-nit" onpaste="return false" onkeypress="return solonumeros(this, '####-######-###-#',event)" placeholder="NIT" />
                </div>
                <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                  <span>Fecha de Nacimiento (Mes-Día-Año)</span>
                  <input type="text" name="fechanac" maxlength="10" class="validate-required validate-fecha" onpaste="return false" onkeypress="return solonumeros(this, '##-##-####',event)" placeholder="Fecha de nacimiento (Mes-Día-Año)" />
                  <span>Correo:</span>
                  <input type="email" name="email" class="validate-required validate-email" placeholder="Correo" />
                  <span>Contraseña:</span>
                  <input type="password" name="password1" class="validate-required validate-igual1" maxlength="32" onkeyup="muestra_seguridad_clave(this.value, this.form)" placeholder="Contraseña" />
                  <span>Confirmar Contraseña:</span>
                  <input type="password" name="password2" class="validate-required validate-igual2" maxlength="32" placeholder="Confirmar Contraseña" />
                  <span>Seguridad de la Contraseña:</span>
                  <input type="text" name="seguridad" class="validate-required validate-seguridad" onfocus="blur()" placeholder="Seguridad de la Contraseña" />
                  <button type="submit">Listo</button>
                </div>
              </div>
            </form>
          </div>
          </div>
        </div>
        <!--end of row-->
      </div>
      <!--end of container-->
    </section>
    <footer class="footer-1 bg-dark">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <span class="sub">CSSC 2016 - Pawnshop System | <a target="_blank" href="usuario.pdf">Ayuda</a></span>
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
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/flickr.js"></script>
  <script src="js/flexslider.min.js"></script>
  <script src="js/lightbox.min.js"></script>
  <script src="js/masonry.min.js"></script>
  <script src="js/twitterfetcher.min.js"></script>
  <script src="js/spectragram.min.js"></script>
  <script src="js/ytplayer.min.js"></script>
  <script src="js/countdown.min.js"></script>
  <script src="js/smooth-scroll.min.js"></script>
  <script src="js/parallax.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>
