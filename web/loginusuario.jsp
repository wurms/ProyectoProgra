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
      </div>
    </nav>
  </div>
  <div class="main-container">
    <section class="cover fullscreen image-bg overlay">
      <div class="background-image-holder">
        <img alt="image" class="background-image" src="img/login.jpg" />
      </div>
      <div class="container v-align-transform">
        <div class="row">
          <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
            <div class="feature bordered input-with-label text-left">
              <center><h4 class="uppercase">Iniciar Sesión</h4></center>
              <form method="post" action="AdminServlet" class="form-envio" data-success="¡Espere un momento!" data-error="Complete todos los campos correctamente.">
                <span>Usuario:</span>
                <input name="usuario" class="validate-required" type="text" placeholder="Usuario" />
                <span>Contraseña:</span>
                <input name="password" class="validate-required" type="password" placeholder="Contraseña" />
                <input type="hidden" name="formid" value="1"/>
                <button type="submit">Entrar</button>
              </form>
              <center><span>¿No tienes cuenta? <a href="register.jsp">Click Aquí</a></span></center><br>
              <div class="modal-container text-center">
                <a class="btn btn-lg btn-modal" href="#"><i class="ti-email"></i> Restaurar Contraseña</a>
                <div class="foundry_modal text-center image-bg overlay">
                  <div class="background-image-holder">
                    <img alt="Background" class="background-image" src="img/modal2.jpg" />
                  </div>
                  <h3 class="uppercase">Restaurar Contraseña</h3>
                  <p class="lead mb48">
                    Si no recuerdas tu contraseña nosotros la reestablecemos a tu correo electronico.
                  </p>
                  <form class="form-envio halves" method="post" data-success="Revisa tu correo electronico para continuar." data-error="Completa correctamente los campos.">
                    <input type="text" name="email" class="validate-email validate-required signup-email-field halves" placeholder="Correo Electronico" />
                    <button type="submit" class="btn-white mb0">Enviar</button>
                    </iframe>
                  </form>
                </div>
              </div>
              <%
                  String mensaje = (String) request.getSession().getAttribute("mensaje");
                  HttpSession sesion = request.getSession(true);
                  if (mensaje != null) {
                          
                      
                  if(mensaje.equals("0")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "¡Usuario incorrecto!", "error");
                    </script>
                    <%
                  } else if (mensaje.equals("2")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "¡Contraseña incorrecta!", "error");
                    </script>
                    <%
                  }else if(mensaje.equals("3")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "¡No tiene acceso a esta área!", "error");
                    </script>
                    <%
                  }else if(mensaje.equals("4")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "¡Usuario deshabilitado!", "error");
                    </script>
                    <%
                  }else if (mensaje.equals("5")) {
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "¡Cliente no habilitado!", "error");
                    </script>
                    <%
                  }
sesion.invalidate();
}
              %>
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
