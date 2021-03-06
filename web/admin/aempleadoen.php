<?php
session_start();
include("../conexion.php");
if($_SESSION['nivel']!=1){
  session_destroy();
  header("location: ../loginusuario.php?msg=3");
  exit();
}
if (isset($_GET['n'])) {
  if ($_GET['n'] == 2 || $_GET['n'] == 3 || $_GET['n'] == 4 || $_GET['n'] == 5 || $_GET['n'] == 0) {
    $nivel = $_GET['n'];
  }else{
    $nivel = 0;
  }
} else {
  $nivel = 0;
}

if ($nivel == 2) {
  $cargo = "Accountant";
} elseif ($nivel == 3) {
  $cargo = "Manager";
} elseif ($nivel == 4) {
  $cargo = "Teller";
} elseif ($nivel == 5) {
  $cargo = "Clients Adder";
} else {
  $cargo = "Employee";
}
if ($nivel == 0) {
  if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $dui = $_POST['dui'];
    $email = $_POST['email'];
    $habilitado = 0;
    $sucursal = $_POST['sucursal'];
    $sueldo = $_POST['sueldo'];

    $consulta = "SELECT * FROM tbempleado";
    $consul = $con->query($consulta)->fetch_array();
    if ($consul['dui'] == $dui) {
      header("location: aempleado.php?msg=1");
      exit();
    }else{
      $insertar = "INSERT INTO tbempleado VALUES('','$nombre','$apellido','$telefono','$dui','$email','$habilitado','$sucursal','','','$nivel','$sueldo')";
      $var = $con->query($insertar);
    }
  }
} elseif (isset($_POST['usuario'])) {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $telefono = $_POST['telefono'];
  $dui = $_POST['dui'];
  $email = $_POST['email'];
  $habilitado = 1;
  $sucursal = $_POST['sucursal'];
  $usuario = $_POST['usuario'];
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];
  $sueldo = $_POST['sueldo'];

  $consulta = "SELECT * FROM tbempleado";
  $consul = $con->query($consulta)->fetch_array();

  if ($password1 == $password2) {
    if ($consul['dui'] == $dui || $consul['usuario'] == $usuario) {
      header("location: aempleado.php?msg=1");
      exit();
    }else{
      $password = md5($password1);
      $insertar = "INSERT INTO tbempleado VALUES('','$nombre','$apellido','$telefono','$dui','$email','$habilitado','$sucursal','$usuario','$password','$nivel','$sueldo')";
      $var = $con->query($insertar);
    }
  }else{
    header("location: aempleadoen.php?msg=2");
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
                <a href="aempleadoen.php">ENGLISH</a>
                <ul>
                  <li>
                    <a href="aempleado.php">ESPAÑOL</a>
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
    if ($_GET['msg'] == 1 ) {
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "Employee already exists!", "error");
      </script>
      <?php
    } elseif ($_GET['msg'] == 2) {
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "Wrong passwords!", "error");
      </script>
      <?php
    }
  }
  if(isset($_POST['nombre'])){
    if(@$var){
      ?>
      <script type="text/javascript">
      swal("Good Job!", "Employee registered!", "success")
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
  ?>
  <div class="main-container">
    <section>
      <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="feature boxed bg-secondary">
          <form method="post" class="text-center form-envio" data-error="Complete all the fields correctly" data-success="¡Nuevo miembro ingresado!">
            <h4 class="uppercase mt48 mt-xs-0">Add New <?=$cargo?></h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                All the fields are required.
              </h6>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Name:</span>
                <input type="text" name="nombre" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Name" required/>
                <span>Lastname:</span>
                <input type="text" name="apellido" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Lastname" required/>
                <span>DUI:</span>
                <input type="text" name="dui" minlength="10" maxlength="10" class="validate-required validate-dui" onpaste="return false" onkeypress="return solonumeros(this, '########-#',event)" placeholder="DUI" required/>
                <span>Salary:</span>
                <input type="number" step="any" min="0" name="sueldo" class="validate-required" placeholder="Salary" required/>
                <?php
                if ($nivel != 0) {
                  ?>
                  <span>Password Security:</span>
                  <input type="text" name="seguridad" class="validate-required validate-seguridad" onfocus="blur()" placeholder="Password Security" />
                  <?php
                }
                ?>
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Phone Number:</span>
                <input type="text" name="telefono" minlength="9" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Phone Number" required/>
                <span>Email:</span>
                <input type="email" name="email" class="validate-required validate-email" placeholder="Email" required/>
                <span>Branch:</span>
                <div class="select-option">
                  <i class="ti-angle-down"></i>
                  <select name="sucursal" required>
                    <option value="" disabled selected>Branch</option>
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
              <?php
              if ($nivel != 0) {
                ?>
                <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                  <span>Username:</span>
                  <input type="text" name="usuario" class="validate-required" maxlength="30" placeholder="Username" required/>
                  <span>Password:</span>
                  <input type="password" name="password1" class="validate-required" maxlength="32" onkeyup="muestra_seguridad_clave(this.value, this.form)" placeholder="Password" required/>
                  <span>Password Confirmation:</span>
                  <input type="password" name="password2" class="validate-required" maxlength="32" placeholder="Password Confirmation" required/>
                </div>
                <?php
              }
              ?>
              <hr>
            </div>
            <div class="overflow-hidden">
              <div class="col-sm-6 col-sm-offset-3">
                <button type="submit">Save</button>
              </div>
            </div>
          </form>
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
