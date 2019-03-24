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
$sid = $_SESSION['sucursal'];

if (isset($_POST['piddelete'])) {
  $pid = $_POST['piddelete'];

  $eliminar = $con->query("DELETE FROM tbprenda WHERE pid='$pid'");
}

require_once("../zebra/zebra.php");
$contar = "SELECT * FROM tbprenda WHERE sid='$sid'";
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
                <a href="contratop.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="contratopen.php">ENGLISH</a>
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
    <?php
    $cprenda = "SELECT * FROM tbprenda WHERE sid='$sid' LIMIT " .(($paginacion->get_page() - 1) * $resultados). "," . $resultados;
    $varprenda = $con->query($cprenda)->fetch_array();
    if (!$varprenda) {
      ?>
      <section>
        <div class="container">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4 class="uppercase mb16">Listado de Prendas</h4>
              <p class="lead mb64">
                Estas son todas las prendas en la platforma.
              </p>
            </div>
          </div>
          <!--end of row-->
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="alert alert-danger alert-dismissible" role="alert">
                <span aria-hidden="true">&times;</span>
                <strong>¡Según la plataforma!</strong> No hay prendas registradas.
              </div>
            </div>
          </div>
          <!--end of row-->
        </div>
        <!--end of container-->
      </section>
      <?php
    } else {
      ?>
      <section>
        <div class="container">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4 class="uppercase mb16">Listado de Prendas</h4>
              <p class="lead mb64">
                Estas son todas las prendas en la plataforma.
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-100 col-md-offset-0 col-sm-100 col-sm-offset-0">
              <table class="table cart mb48">
                <thead>
                  <tr>
                    <th>Prenda N°</th>
                    <th>Características</th>
                    <th>Peso (kg)</th>
                    <th>Kilataje</th>
                    <th>Avalúo</th>
                    <th>Préstamo</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($con->query($cprenda) as $key) {
                    ?>
                    <tr>
                      <td>
                        <span><?=$key['pid']?></span>
                      </td>
                      <td>
                        <span><?=$key['caracteristicas']?></span>
                      </td>
                      <td>
                        <span><?=$key['peso']?></span>
                      </td>
                      <td>
                        <span><?=$key['kilataje']?></span>
                      </td>
                      <td>
                        <span>$<?=$key['avaluo']?></span>
                      </td>
                      <td>
                        <span>$<?=$key['prestamo']?></span>
                      </td>
                      <td>
                        <?php
                        if($key['estado']==1){
                          echo "¡Prenda con contrato!";
                        }elseif($key['estado']==0){
                          echo "¡Prenda sin contrato!<br>";
                        }elseif ($key['estado']==2) {
                          echo "¡Cancelado!";
                        }elseif ($key['estado']==4) {
                          echo "¡Pieza vendida!";
                        } elseif ($key['estado']==3) {
                          echo "¡Contrato vencido!";
                        }
                        ?>
                      </td>
                      <?php
                      if($key['estado']!=0){
                        ?>
                        <td>
                          <form method="post" target="_blank" action="vpdf.php" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Archivo Abierto!">
                            <input type="hidden" value="<?=$key['pid']?>" name="pid" />
                            <button type="submit" style="margin-bottom: 5px; background-color: #63dd8d; border-color: #63dd8d">Ver Contrato</button>
                          </form>
                        </td>
                        <td>
                          <form method="post" target="_blank" action="recibo.php" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Mensaje eliminado!">
                            <input type="hidden" value="<?=$key['pid']?>" name="pid" />
                            <button type="submit" style="margin-bottom: 5px; background-color: #6cbcd5; border-color: #6cbcd5">Resumen</button>
                          </form>
                        </td>
                        <?php
                      } else {
                        ?>
                        <td>
                          <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Mensaje eliminado!">
                            <input type="hidden" value="<?=$key['pid']?>" name="piddelete">
                            <button onclick="swal({   title: '¡ELIMINAR PRENDA!',   text: '¿Esta seguro de eliminar esta prenda del sistema?',   type: 'warning',   showCancelButton: true,   confirmButtonColor: '#DD6B55',   confirmButtonText: '¡Eliminar!',   closeOnConfirm: false }, function(){ form.submit(); });" type="button" style="margin-bottom: 5px; background-color: #ff7673; border-color: #ff7673">Eliminar Prenda</button>
                          </form>
                        </td>
                        <?php
                      }
                      ?>
                    </tr>
                    <?php
                  }
                  ?>
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
      <?php
    }
    ?>
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
