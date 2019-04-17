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
        <!--Final idioma-->
      </div>
    </nav>
  </div>
    <%
                  String mensaje = (String) request.getSession().getAttribute("mensaje");
                  
                  if (mensaje != null) {
                          
                      
                  if(mensaje.equals("0")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡BIENVENIDO!", "¡Sus datos han sido ingresados!", "success");
                    </script>
                    <%
                  } else if (mensaje.equals("2")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "¡Compruebe que no tengo una cuenta existente!", "error");
                    </script>
                    <%
                  }
}
              %>
  <div class="main-container">
    <section class="cover fullscreen image-bg overlay">
      <div class="background-image-holder">
        <img alt="image" class="background-image" src="img/login.jpg" />
      </div>
      <div class="container v-align-transform">
        <div class="row">
          <div class="col-md-12 col-md-offset-0 col-sm-1 col-sm-offset-1">
            <div class="feature boxed bg-secondary">
              <form method="post" action="ClienteServlet" class="text-center form-envio" data-success="¡Nuevo miembro ingresado!" enctype="multipart/form-data">
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
                  <input type="hidden" name="formid" value="1"/>
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
