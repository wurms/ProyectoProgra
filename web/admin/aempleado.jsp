<%@page import="wurms.programmer.pojo.AdminObj"%>
<%@page import="java.util.ArrayList"%>
<%
    String nivel = (String) request.getSession().getAttribute("nivel");
    if(nivel==null){
        request.getSession().setAttribute("mensaje", "3");
            response.sendRedirect("../loginusuario.jsp");
    } else {
        if (!nivel.equals("0")) {
            request.getSession().setAttribute("mensaje", "3");
            response.sendRedirect("../loginusuario.jsp");    
        }
    }
    ArrayList<AdminObj> admin = (ArrayList<AdminObj>) request.getSession().getAttribute("admin");
%>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Seguros El Salvador</title>
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
              <li class="has-dropdown">
                <a href="#">
                  Ver listado
                </a>
                <ul class="mega-menu">
                  <li>
                    <ul>
                      <li>
                        <span class="title">Trabajadores</span>
                      </li>
                      <li>
                        <a href="../EmpleadoServlet?formid=2">Empleados</a>
                      </li>
                      <li>
                        <a href="../ClienteServlet?formid=2">Clientes</a>
                      </li>
                      <li>
                        <a href="../VehiculosServlet?formid=2">Vehículos</a>
                      </li>
                      <li>
                        <a href="../MensajeServlet?formid=2">Mensajes</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="has-dropdown">
                <a href="#">
                  Agregar nuevo
                </a>
                <ul class="mega-menu">
                  <li>
                    <ul>
                      <li>
                        <a href="aempleado.php?n=2">Empleado</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li>
                <a href="../AdminServlet?formid=2">
                  Salir
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
  <!--Final barra-->
      <%
                  String mensaje = (String) request.getParameter("mensaje");
                  HttpSession sesion = request.getSession(true);
                  
                  if (mensaje != null) {
                          
                      
                  if(mensaje.equals("1")){
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
    <section>
      <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="feature boxed bg-secondary">
          <form method="post" action="../EmpleadoServlet" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="Â¡Nuevo miembro ingresado!">
            <h4 class="uppercase mt48 mt-xs-0">Agregar empleado</h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                Todos los campos son obligatorios.
              </h6>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Nombre:</span>
                <input type="text" name="nombre" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Nombre" />
                <span>Apellido:</span>
                <input type="text" name="apellido" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Apellido" />
                <span>DUI:</span>
                <input type="text" name="dui" maxlength="10" class="validate-required validate-dui" onpaste="return false" onkeypress="return solonumeros(this, '########-#',event)" placeholder="DUI" />
                <span>Teléfono</span>
                <input type="text" name="telefono" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Teléfono" />                 
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                
                <span>Correo:</span>
                <input type="email" name="email" class="validate-required validate-email" placeholder="Correo" />
              </div>
                <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                  <span>Usuario:</span>
                  <input type="text" name="usuario" class="validate-required" maxlength="30" placeholder="Usuario"/>
                  <span>Contraseña:</span>
                  <input type="password" name="password1" class="validate-required validate-igual1" maxlength="32" onkeyup="muestra_seguridad_clave(this.value, this.form)" placeholder="Contraseña" />
                  <span>Confirmar contraseña:</span>
                  <input type="password" name="password2" class="validate-required validate-igual2" maxlength="32" placeholder="Confirmar Contraseña" />
                  <span>Seguridad de la contraseña:</span>
                  <input type="text" name="seguridad" class="validate-required validate-seguridad" onfocus="blur()" placeholder="Seguridad de la contraseña" />
                  <input type="hidden" name="formid" value="1"/>
                </div>
              <hr>
            </div>
            <div class="overflow-hidden">
              <div class="col-sm-6 col-sm-offset-3">
                <button type="submit">Ingresar</button>
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
