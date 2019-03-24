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
$sid = $_SESSION['sucursal'];
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
      $rutad = "../fotos/" . $nombred;
      $rutap = "../fotos/" . $nombrep;
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
        header("location: nclienteen.php?msg=2");
        exit();
      }
    }else {
      header("location: nclienteen.php?msg=1");
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
  <style>
    #c{display: none;}
  </style>
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
            <i class="ti-camera"></i>
            <span class="title">Picture</span>
          </div>
          <div class="function">
            <img src="" id="img">
            <video id="v"></video>
            <canvas id="c"></canvas>
            <button id="t" type="button">Capture</button>
            <script>
              window.addEventListener('load',init);
              function init() {
                var video = document.querySelector('#v'), canvas = document.querySelector('#c'), btn = document.querySelector('#t'), img = document.querySelector('#img');

                navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
                if (navigator.getUserMedia) {
                  navigator.getUserMedia({video:true},function(stream){
                    video.src = window.URL.createObjectURL(stream);
                    video.play();
                  },function(e){console.log(e);})
                }
                else alert('Intente con otro navegador');
                video.addEventListener('loadedmetadata', function() {
                  canvas.width = video.videoWidth; canvas.height = video.videoHeight;
                },false);

                btn.addEventListener('click',function() {
                  canvas.getContext('2d').drawImage(video,0,0);
                  var imgData = canvas.toDataURL('image/png');
                  img.setAttribute('src',imgData);
                });
              }
            </script>
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
                    Add new
                </a>
                <ul class="mega-menu">
                    <li>
                        <ul>
                            <li>
                                <span class="title">Loans</span>
                            </li>
                            <li>
                                <a href="cprendaen.php">Piece</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>
                                <span class="title">Clients</span>
                            </li>
                            <li>
                                <a href="nclienteen.php">Client</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="has-dropdown">
                <a href="#">
                    View List
                </a>
                <ul class="mega-menu">
                    <li>
                        <ul>
                            <li>
                                <span class="title">Pledges</span>
                            </li>
                            <li>
                                <a href="scontratoen.php">View Pledges</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>
                                <span class="title">Clients</span>
                            </li>
                            <li>
                                <a href="vclienteen.php">Client</a>
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
                <a href="nclienteen.php">ENGLISH</a>
                <ul>
                    <li>
                        <a href="ncliente.php">ESPAÑOL</a>
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
    if($var){
      ?>
      <script type="text/javascript">
        swal("¡BUEN TRABAJO!", "Client Added!", "success")
      </script>
      <?php
    }else{
      ?>
      <script type="text/javascript">
        sweetAlert("¡ERROR!", "Try Again!", "error");
      </script>
      <?php
    }
  }
  if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 1 ) {
      ?>
      <script type="text/javascript">
        sweetAlert("¡ERROR!", "Field not available!", "error");
      </script>
      <?php
    }elseif ($_GET['msg'] == 2) {
      ?>
      <script type="text/javascript">
        sweetAlert("¡ERROR!", "DUI Already exists!", "error");
      </script>
      <?php
    }
  }
  ?>
  <div class="main-container">
    <section>
     <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
      <div class="feature boxed bg-secondary">
        <form method="post" class="text-center form-envio" data-error="Complete all fields correctly" data-success="New Client Added!" enctype="multipart/form-data">
         <h4 class="uppercase mt48 mt-xs-0">Add New Client</h4>
         <div class="overflow-hidden">
          <hr>
          <h6 class="uppercase">
            All fields are required.
          </h6>
          <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
            <span>DUI:</span>
            <input type="text" name="dui" minlength="10" maxlength="10" class="validate-required validate-dui" onpaste="return false" onkeypress="return solonumeros(this, '########-#',event)" placeholder="DUI" required/>
            <span>Name:</span>
            <input type="text" name="nombre" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Name" required/>
            <span>Lastname:</span>
            <input type="text" name="apellido" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Lastname" required/>
            <span>Address:</span>
            <input type="text" name="direccion" maxlength="100" class="validate-required" placeholder="Address" required/>
            <span>Phone Number:</span>
            <input type="text" name="telefono" minlength="9" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Phone Number" required/>
          </div>
          <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
            <span>NIT:</span>
            <input type="text" name="nit" minlength="17" maxlength="17" class="validate-required validate-nit" onpaste="return false" onkeypress="return solonumeros(this, '####-######-###-#',event)" placeholder="NIT" required/>
            <span>DUI Picture:</span>
            <input type="file" name="foto_dui" class="validate-required" required/>
            <span>Profile Picture:</span>
            <input type="file" name="foto_perfil" class="validate-required" required/>
            <span>Birthdate (Month-Day-Year)</span>
            <input type="text" name="fechanac" minlength="10" maxlength="10" class="validate-required validate-fecha" onpaste="return false" onkeypress="return solonumeros(this, '##-##-####',event)" placeholder="Birthdate (Month-Day-Year)" required/>
            <span>Email:</span>
            <input type="email" name="email" class="validate-required validate-email" placeholder="Email" required/>
            <input type="hidden" name="sucursal" value="<?=$sid?>" />
          </div>
        </div>
        <div class="overflow-hidden">
          <div class="col-sm-6 col-sm-offset-3">
            <button type="submit">Save</button>
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
