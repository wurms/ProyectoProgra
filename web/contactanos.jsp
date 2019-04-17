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
          <a href="index.jsp">
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
                <a href="index.jsp">
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
  <!--Final barra-->
  <div class="main-container">
    <section>
      <br /><br />
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-md-5">
            <h4 class="uppercase">Contáctanos</h4>
            <p>
              Por que queremos saber lo que piensan nuestros clientes, mantente en contacto con nosotros, tus comentarios seran de mucha ayuda para tu satisfacción.
            </p>
            <hr>
            <p>
              Res. Pinares de Suiza
              <br /> Santa Tecla, El Salvador
            </p>
            <hr>
            <p>
              <strong>Correo:</strong> pawnshopsystem@gmail.com
              <br />
              <strong>Teléfono:</strong> 2222-2222
              <br />
            </p>
          </div>
          <div class="col-sm-6 col-md-5 col-md-offset-1 input-with-label text-left">
              <form method="post" action="MensajeServlet" class="form-envio" data-success="¡Espere un momento!" data-error="Complete todos los campos correctamente.">
              <span>Nombre:</span>
              <input type="text" style="background: whitesmoke;" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" class="validate-required" name="nombre" placeholder="Nombre" required/>
              <span>Número:</span>
              <input type="text" style="background: whitesmoke;" onpaste="return false" minlength="9" maxlength="9" onkeypress="return solonumeros(this, '####-####',event)" class="validate-required validate-cellphone" name="telefono" placeholder="Teléfono" required/>
              <span>Mensaje</span>
              <textarea class="validate-required" maxlength="150" name="mensaje" rows="6" placeholder="Mensaje" required></textarea>
              <input type="hidden" name="formid" value="1" />
              <button type="submit">Enviar Mensaje</button>${mensaje}
            </form>
            <%
            String mensaje = (String) request.getSession().getAttribute("mensaje");
                  HttpSession sesion = request.getSession(true);
            if (mensaje != null) {
              if(mensaje.equals("1")){
                %>
                <script type="text/javascript">
                swal("¡BUEN TRABAJO!", "¡Gracias por su comentario!", "success")
                </script>
                <%
              } else {
                %>
                <script type="text/javascript">
                sweetAlert("¡ERROR!", "¡Intenta en otro momento!", "error");
                </script>
                <%
              }
sesion.invalidate();
            }
            %>
          </div>
        </div>
        <!--final columna-->
      </div>
      <!--final contenedor-->
      <br />
              <br />
              <br />
              <br />
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
