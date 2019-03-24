<?php
date_default_timezone_set('America/Dawson');
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
if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
  $cprenda = "SELECT * FROM tbprenda WHERE pid='$pid'";
  $vprenda = $con->query($cprenda)->fetch_array();
  $sid = $vprenda['sid'];
  $eid = $vprenda['eid'];
  $cid = $vprenda['cid'];
  $csucursal = "SELECT * FROM tbsucursal WHERE sid='$sid'";
  $cempleado = "SELECT * FROM tbempleado WHERE eid='$eid'";
  $ccliente = "SELECT * FROM tbcliente WHERE cid='$cid'";
  $vsucursal = $con->query($csucursal)->fetch_array();
  $vempleado = $con->query($cempleado)->fetch_array();
  $vcliente = $con->query($ccliente)->fetch_array();
  if (!$vprenda) {
    header("location: vcontrato.php");
    exit();
  }
}else{
  header("location: vcontrato.php");
  exit();
}

if (isset($_POST['pid'])) {
  $monto = $vprenda['prestamo'];
  $consulta = "SELECT * FROM tboperacion WHERE oid='$pid'";
  $varcon = $con->query($consulta)->fetch_all();
  $hoy = date('m/d/o');
  $plazo = date('m/d/o', strtotime('+1 month')) ;
  $comerci = date('m/d/o', strtotime('+5 day, +1 month'));
  $intereses = round(($vprenda['prestamo'])*0.04, 2);
  $iva = round(($intereses*3)*0.13, 2);
  $total = round(($vprenda['prestamo'])+($intereses*3)+$iva, 2);

  if ($varcon) {
  	$modi = "UPDATE tboperacion SET fecha='$hoy', plazomaximo='$plazo', fechacomercializacion='$comerci', estado='1', fechapago='NULL', mora='0' WHERE oid='$pid'";
  	$modifi = "UPDATE tbprenda SET estado='1' WHERE pid='$pid'";
  	$varmod = $con->query($modi);
  	$varmodifi = $con->query($modifi);
  }else{
  	$insertar = "INSERT INTO tboperacion VALUES('$pid','$pid','$hoy','$monto','$intereses','$plazo','$comerci','$iva','$total','1','NULL','NULL','0')";
    $modifi = "UPDATE tbprenda SET estado='1' WHERE pid='$pid'";
  	$varin = $con->query($insertar);
    $varmodifi = $con->query($modifi);
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
                <a href="vcontrato.php">ESPAÑOL</a>
                <ul>
                  <li>
                    <a href="vcontratoen.php">ENGLISH</a>
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
  if (isset($_POST['pid'])) {
    if (@$varcon) {
      if (@$varmod && @$varmodifi) {
        ?>
        <script type="text/javascript">
        swal("¡BUEN TRABAJO!", "¡Contrato Actualizado!", "success")
        </script>
        <?php
      } else {
        echo "Se encontro pero no se guardo";
      }
    } elseif(@$varin && @$varmodifi){
        ?>
        <script type="text/javascript">
        swal("¡BUEN TRABAJO!", "¡Contrato Guardado!", "success")
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
  ?>
  <div class="main-container">
    <section>
        <div class="container">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4 class="uppercase mb16">Contrato Prendario</h4>
              <p class="lead mb64">
                Cliente: <?=$vcliente['nombre']?> <?=$vcliente['apellido']?>. DUI: <?=$vcliente['dui']?>.
              </p>
            </div>
          </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-0 col-sm-10 col-sm-offset-1"><br><br>
                    <table class="table cart mb48">
                        <thead>
                            <tr>
                              <th>Prenda N°</th>
                              <th>Características</th>
                              <th>Peso (kg)</th>
                              <th>Kilataje</th>
                              <th>Avalúo</th>
                              <th>Préstamo</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <span><?=$vprenda['pid']?></span>
                            </td>
                            <td>
                              <span><?=$vprenda['caracteristicas']?></span>
                            </td>
                            <td>
                              <span><?=$vprenda['peso']?></span>
                            </td>
                            <td>
                              <span><?=$vprenda['kilataje']?></span>
                            </td>
                            <td>
                              <span>$<?=$vprenda['avaluo']?></span>
                            </td>
                            <td>
                              <span>$<?=$vprenda['prestamo']?></span>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                    <table class="table cart mb48">
                        <thead>
                            <tr>
                              <th>MONTO</th>
                              <th>INTERESES</th>
                              <th>ALMACENAJE</th>
                              <th>SEGURO</th>
                              <th>GASTOS</th>
                              <th>COMISIÓN</th>
                              <th>PLAZO</th>
                              <th>PLAZO MAXIMO</th>
                              <th>COMERCIALIZACIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <?php
                            $hoy = date('m/d/o');
                            $plazo = date('m/d/o', strtotime('+1 month')) ;
                            $comerci = date('m/d/o', strtotime('+5 day, +1 month'));
                            ?>
                            <td>
                              <span>$<?= $vprenda['prestamo'] ?></span>
                            </td>
                            <td>
                              <span>4.00 %</span>
                            </td>
                            <td>
                              <span>4.00 %</span>
                            </td>
                            <td>
                              <span>4.00 %</span>
                            </td>
                            <td>
                              <span>0.19</span>
                            </td>
                            <td>
                              <span>25.00 %</span>
                            </td>
                            <td>
                              <span>1 Mes</span>
                            </td>
                            <td>
                              <span><?= $plazo ?></span>
                            </td>
                            <td>
                              <span><?= $comerci ?></span>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                    <?php
                    if($vprenda['estado']==1 || $vprenda['estado']==3){
                      ?>
                      <form method="post" target="_blank" action="vpdf.php" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Archivo Abierto!">
                        <input type="hidden" value="<?=$vprenda['pid']?>" name="pid" />
                        <button type="submit" style="margin-bottom: 5px; background-color: #63dd8d; border-color: #63dd8d">Ver Contrato Actual</button>
                      </form>
                      <?php
                    }
                    ?>
                </div>
                <!--end of items-->
                <div class="col-md-3 col-md-offset-0 col-sm-10 col-sm-offset-1">
                    <div class="mb24">
                        <h5 class="uppercase">Opciones de Pago</h5>
                        <table class="table">
                            <tbody>
                              <?php
                              $intereses = round(($vprenda['prestamo'])*0.04, 2);
                              $iva = round(($intereses*3)*0.13, 2);
                              $total = round(($vprenda['prestamo'])+($intereses*3)+$iva, 2);
                              ?>
                                <tr>
                                    <th scope="row">Importe</th>
                                    <td>$<?= $vprenda['prestamo'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Intereses</th>
                                    <td>$<?=$intereses?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Almacenaje</th>
                                    <td>
                                        $<?=$intereses?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Seguro</th>
                                    <td>$<?=$intereses?></td>
                                </tr>
                                <tr>
                                    <th scope="row">IVA</th>
                                    <td>$<?=$iva?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Total a Pagar</th>
                                    <td>$<?=$total?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Guardado!">
                          <input type="hidden" value="<?=$key['pid']?>" name="pid">
                          <button onclick="swal({   title: '¡Nuevo Contrato!',   text: '¿Esta seguro de generar un nuevo contrato para esta prenda?',   type: 'warning',   showCancelButton: true,   confirmButtonColor: '#DD6B55',   confirmButtonText: '¡Crear Contrato!',   closeOnConfirm: false }, function(){ form.submit(); });" type="button" style="margin-bottom: 5px; background-color: #6cbcd5; border-color: #6cbcd5">Nuevo Contrato</button>
                        </form>
                    </div>
                </div>
                <!--end of totals-->
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
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
