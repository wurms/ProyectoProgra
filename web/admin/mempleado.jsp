<%@page import="java.util.Iterator"%>
<%@page import="wurms.programmer.pojo.EmpleadoObj"%>
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
        
EmpleadoObj CEmpleado = 
                (EmpleadoObj)request.getSession().getAttribute("empleado");
%>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pawnshop</title>
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
                        <a href="aempleado.jsp">Empleado</a>
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
                    swal("¡BUEN TRABAJO!", "Empleado Modificado!", "success")
                    </script>
                    <%
                  } else if (mensaje.equals("2")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("¡ERROR!", "¡Intente nuevamente!", "error");
                    </script>
                    <%
                  }
}
              %>
  <%--
  <?php
  if(isset($_POST['nombre'])){
    if(@$vari){
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "Empleado Modificado!", "success")
      </script>
      <?php
    }else{
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "¡Intente nuevamente!", "error");
      </script>
      <?php
    }
  } elseif (isset($_POST['password1'])) {
    if(@$vari){
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "¡Contraseña cambiada!", "success")
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
  if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 1) {
      ?>
      <script type="text/javascript">
      sweetAlert("¡ERROR!", "¡Nuevas contraseñas no coinciden!", "error");
      </script>
      <?php
    } elseif ($_GET['msg'] == 2) {
      ?>
      <script type="text/javascript">
      swal("¡BUEN TRABAJO!", "¡Cambios hechos!", "success")
      </script>
      <?php
    }
  }
  ?>
  --%>
  <div class="main-container">
    <section>
      <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="feature boxed bg-secondary">
          <form method="post" action="../EmpleadoServlet" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
            <h4 class="uppercase mt48 mt-xs-0">Modificar <?=$cargo?></h4>
            <div class="overflow-hidden">
              <hr>
              <h6 class="uppercase">
                Todos los campos son obligatorios.
              </h6>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                  <input type="hidden" name="formid" value="5" />
                  <input type="hidden" name="id" value="<%=CEmpleado.getId()%>" />
                <span>Nombre:</span>
                <input type="text" name="nombre" value="<%=CEmpleado.getNombre()%>" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Nombre" />
                <span>Apellido:</span>
                <input type="text" name="apellido" value="<%=CEmpleado.getApellido()%>" class="validate-required" onpaste="return false" maxlength="30" onkeypress="return sololetras(event)" placeholder="Apellido" />
                <span>DUI:</span>
                <input type="text" name="dui" value="<%=CEmpleado.getDui()%>" maxlength="10" class="validate-required validate-dui" onpaste="return false" onkeypress="return solonumeros(this, '########-#',event)" placeholder="DUI" />
              </div>
              <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                <span>Teléfono</span>
                <input type="text" value="<%=CEmpleado.getTelefono()%>" name="telefono" maxlength="9" class="validate-required validate-cellphone" onpaste="return false" onkeypress="return solonumeros(this, '####-####',event)" placeholder="Teléfono" />
                <span>Correo:</span>
                <input type="email" value="<%=CEmpleado.getCorreo()%>" name="email" class="validate-required validate-email" placeholder="Correo" />
                <span>Usuario:</span>
                <input type="text" value="<%=CEmpleado.getUsuario()%>" name="usuario" class="validate-required" maxlength="30" placeholder="Usuario"/>
              </div>
            </div>
            <div class="overflow-hidden">
              <div class="col-sm-12 col-md-12 col-md-offset-0.5 input-with-label text-left">
                <button type="submit">Guardar</button>
              </div>
            </form>
          </div>
            <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
              <div class="overflow-hidden">
                <hr>
                <div class="col-sm-6 col-sm-offset-3">
                  <h6 class="uppercase">
                    Cambio de contraseña.
                  </h6>
                </div>
                <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                  <span>Contraseña:</span>
                  <input type="password" name="password1" class="validate-required" maxlength="32" onkeyup="muestra_seguridad_clave(this.value, this.form)" placeholder="Contraseña" />
                  <span>Confirmar Contraseña:</span>
                  <input type="password" name="password2" class="validate-required" maxlength="32" placeholder="Confirmar Contraseña" />
                  <span>Seguridad de la Contraseña:</span>
                  <input type="text" name="seguridad" class="validate-required validate-seguridad" onfocus="blur()" placeholder="Seguridad de la Contraseña" />
                </div>
                <div class="col-sm-6 col-md-6 col-md-offset-0.5 input-with-label text-left">
                  <br>
                  <button type="submit">Cambiar</button>
                </form>
                <%
                if (CEmpleado.getHabilitado() == 0) {
                  %>
                  <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
                    <input type="hidden" value="1" name="habilitado">
                    <button type="submit">Habilitar</button>
                  </form>
                  <%
                } else if (CEmpleado.getHabilitado() == 1) {
                  %>
                  <form method="post" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="¡Nuevo miembro ingresado!">
                    <input type="hidden" value="0" name="habilitado">
                    <button type="submit">Deshabilitar</button>
                  </form>
                  <%
                }
                %>
              </div>
            </div>
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
