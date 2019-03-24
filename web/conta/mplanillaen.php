<?php
session_start();
include("../conexion.php");
if ($_SESSION['nivel']!=2) {
  session_destroy();
  header("location: ../loginusuarioen.php?msg=3");
  exit();
} elseif ($_SESSION['habilitado']!=1) {
  session_destroy();
  header("location: ../loginusuarioen.php?msg=4");
  exit();
}
date_default_timezone_set('America/Dawson');
$sid = $_SESSION['sucursal'];

if (isset($_GET['planilla']) && isset($_GET['mes']) && isset($_GET['ano'])) {
  $planilla = $_GET['planilla'];
  $ano = $_GET['ano'];
  $mes = $_GET['mes'];

  $consulta = $con->query("SELECT * FROM tbplanilla WHERE planilla='$planilla' AND ano='$ano' AND mes='$mes' AND sid='$sid'")->fetch_all();

  if (!$consulta) {
    header("location: planillaen.php");
    exit();
  }
} else {
  header("location: planillaen.php");
  exit();
}

if (isset($_POST['planilla'])) {
  $planilla = $_POST['planilla'];
  $mes = $_POST['mes'];
  $ano = $_POST['ano'];

  $consulta = "SELECT * FROM tbempleado WHERE sid='$sid'";
  foreach ($con->query($consulta) as $key) {
    $eid = $_POST['eid'.$key['eid']];
    $dias = $_POST['dias'.$key['eid']];
    $extras = $_POST['extras'.$key['eid']];

    $modificar = "UPDATE tbplanilla SET dias='$dias', extras='$extras' WHERE eid='$eid' AND planilla='$planilla' AND mes='$mes' AND ano='$ano' AND sid='$sid'";
    $var = $con->query($modificar);
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
                        <a href="splanillaen.php">Payroll</a>
                      </li>
                      <li>
                        <a href="oficinaen.php">Office</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <ul>
                      <li>
                        <span class="title">Pledges</span>
                      </li>
                      <li>
                        <a href="sreporteen.php">Operations Report</a>
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
                <a href="mplanillaen.php">ENGLISH</a>
                <ul>
                  <li>
                    <a href="mplanilla.php">ESPAÑOL</a>
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
  if(isset($_POST['planilla'])){
    if(@$var){
      ?>
      <script type="text/javascript">
      swal("Great!", "Payroll Completed", "success")
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
          <form method="post" class="text-center form-envio" data-error="Complete all the fields correctly" data-success="Payroll!">
            <h4 class="uppercase mt48 mt-xs-0">Payroll Update</h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                All the fields are required.
              </h6>
              <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                <span>Payroll:</span>
                <input type="text" value="<?=$planilla?>" disabled/>
                <input type="hidden" name="planilla" value="<?=$planilla?>" />
              </div>
              <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                <span>Month:</span>
                <?php
                if ($mes == 1) {
                  ?>
                  <input type="text" value="January" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 2) {
                  ?>
                  <input type="text" value="February" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 3) {
                  ?>
                  <input type="text" value="March" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 4) {
                  ?>
                  <input type="text" value="April" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 5) {
                  ?>
                  <input type="text" value="May" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 6) {
                  ?>
                  <input type="text" value="June" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 7) {
                  ?>
                  <input type="text" value="July" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 8) {
                  ?>
                  <input type="text" value="Agost" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 9) {
                  ?>
                  <input type="text" value="September" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 10) {
                  ?>
                  <input type="text" value="October" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 11) {
                  ?>
                  <input type="text" value="November" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                } elseif ($mes == 12) {
                  ?>
                  <input type="text" value="Dicember" disabled/>
                  <input type="hidden" name="mes" value="<?=$mes?>" />
                  <?php
                }
                ?>
              </div>
              <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                <span>Year:</span>
                <input type="text" value="<?=$ano?>" disabled/>
                <input type="hidden" name="ano" value="<?=$ano?>" />
              </div>
              <center>
                <table>
                  <tr>
                    <td style="width: 50px;">
                      <strong>
                        <center>
                          ID:
                        </center>
                      </strong>
                    </td>
                    <td style="width: 100px;">
                      <strong>
                        <center>
                          DUI:
                        </center>
                      </strong>
                    </td>
                    <td style="width: 200px;">
                      <strong>
                        <center>
                          Name:
                        </center>
                      </strong>
                    </td>
                    <td style="width: 100px;">
                      <strong>
                        <center>
                          Workdays:
                        </center>
                      </strong>
                    </td>
                    <td style="width: 150px;">
                      <strong>
                        <center>
                          Overtime:
                        </center>
                      </strong>
                    </td>
                  </tr>
                  <?php
                  $consulta = "SELECT * FROM tbempleado WHERE sid='$sid'";
                  foreach ($con->query($consulta) as $key) {
                    $eid = $key['eid'];
                    $cempleado = $con->query("SELECT * FROM tbplanilla WHERE planilla='$planilla' AND ano='$ano' AND mes='$mes' AND sid='$sid' AND eid='$eid'")->fetch_array();
                    ?>
                    <tr>
                      <td>
                        <center>
                          <?=$key['eid']?>
                        </center>
                      </td>
                      <td>
                        <center>
                          <?=$key['dui']?>
                        </center>
                      </td>
                      <td>
                        <center>
                          <?=$key['nombre']?> <?=$key['apellido']?>
                        </center>
                      </td>
                      <td>
                        <center>
                          <input type="hidden" name="eid<?=$key['eid']?>" value="<?=$key['eid']?>" />
                          <input type="hidden" name="sueldo<?=$key['eid']?>" value="<?=$key['sueldo']?>" />
                          <select style="width: 50px;" name="dias<?=$key['eid']?>" required>
                            <option><?=$cempleado['dias']?></option>
                            <option>15</option>
                            <option>14</option>
                            <option>13</option>
                            <option>12</option>
                            <option>11</option>
                            <option>10</option>
                            <option>9</option>
                            <option>8</option>
                            <option>7</option>
                            <option>6</option>
                            <option>5</option>
                            <option>4</option>
                            <option>3</option>
                            <option>2</option>
                            <option>1</option>
                            <option>0</option>
                          </select>
                        </center>
                      </td>
                      <td style="width: 150px;">
                        <center>
                          <input type="number" name="extras<?=$key['eid']?>" value="<?=$cempleado['extras']?>" />
                        </center>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                </table>
              </center>
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
