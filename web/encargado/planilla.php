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
date_default_timezone_set('America/Dawson');
$sid = $_SESSION['sucursal'];

if (isset($_POST['planilla'])) {
  $planilla = $_POST['planilla'];
  $mes = $_POST['mes'];
  $ano = $_POST['ano'];

  $consulta = "SELECT * FROM tbempleado WHERE sid='$sid'";
  foreach ($con->query($consulta) as $key) {
    $eid = $_POST['eid'.$key['eid']];
    $sueldo = $_POST['sueldo'.$key['eid']];
    $dias = $_POST['dias'.$key['eid']];
    $extras = $_POST['extras'.$key['eid']];

    $cplanilla = "SELECT * FROM tbplanilla WHERE eid='$eid' AND planilla='$planilla ' AND mes='$mes' AND ano='$ano'";
    $vplanilla = $con->query($cplanilla)->fetch_all();
    if (!$vplanilla) {
      $insertar = "INSERT INTO tbplanilla VALUES('','$eid','$planilla','$mes','$ano','$sueldo','$dias','$extras','','','','','$sid')";
      $var = $con->query($insertar);
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
                  <a href="planilla.php">ESPAÑOL</a>
                <ul>
                  <li>
                      <a href="planillaen.php">ENGLISH</a>
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
  if(isset($_POST['planilla']) && !$vplanilla){
    if(@$var){
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "Planilla Completada", "success")
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
  if (isset($_POST['planilla'])) {
    if ($vplanilla) {
    ?>
    <script type="text/javascript">
      swal({
           title: 'ALERTA',
           text: 'El período que ha ingresado ya tiene registro',
           type: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#DD6B55',
           confirmButtonText: 'Modificar',
           cancelButtonText: "No, Cancelar.",
           closeOnConfirm: false,
           closeOnCancel: false
        },
           function(isConfirm){
             if (isConfirm) {
               window.location="mplanilla.php?planilla=<?=$planilla?>&mes=<?=$mes?>&ano=<?=$ano?>";
            }else{
              swal("CANCELADO", "Su planilla no ha cambiado", "error");
            }
          });
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
            <h4 class="uppercase mt48 mt-xs-0">Paso de Planilla</h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                Complete los campos necesarios.
              </h6>
              <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                <span>Planilla:</span>
                <select name="planilla" required>
                  <option>1</option>
                  <option>2</option>
                </select>
              </div>
              <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                <span>Mes:</span>
                <select name="mes" required>
                  <option value="1">Enero</option>
                  <option value="2">Febrero</option>
                  <option value="3">Marzo</option>
                  <option value="4">Abril</option>
                  <option value="5">Mayo</option>
                  <option value="6">Junio</option>
                  <option value="7">Julio</option>
                  <option value="8">Agosto</option>
                  <option value="9">Septiembre</option>
                  <option value="10">Octubre</option>
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option>
                </select>
              </div>
              <div class="col-sm-4 col-md-4 col-md-offset-0.5 input-with-label text-left">
                <span>Año:</span>
                <?php
                $ano = date('o');
                ?>
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
                          Nombre:
                        </center>
                      </strong>
                    </td>
                    <td style="width: 100px;">
                      <strong>
                        <center>
                          Dias Laborales:
                        </center>
                      </strong>
                    </td>
                    <td style="width: 150px;">
                      <strong>
                        <center>
                          Cantidad Horas Extras:
                        </center>
                      </strong>
                    </td>
                  </tr>
                  <?php
                  $consulta = "SELECT * FROM tbempleado WHERE sid='$sid'";
                  foreach ($con->query($consulta) as $key) {
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
                          <input type="number" name="extras<?=$key['eid']?>" />
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
                <button type="submit">Enviar</button>
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
