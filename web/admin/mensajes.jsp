<%@page import="java.util.Iterator"%>
<%@page import="wurms.programmer.pojo.MensajesObj"%>
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
    
ArrayList<MensajesObj> CArray = 
                (ArrayList<MensajesObj>)request.getSession().getAttribute("mensajes");
        Iterator<MensajesObj> iteArray = CArray.iterator();
%>
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
                        <a href="../VehiculosServlet?formid=2">Veh�culos</a>
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
    <%
                  String mensaje = (String) request.getParameter("mensaje");
                  HttpSession sesion = request.getSession(true);
                  
                  if (mensaje != null) {
                          
                  if (mensaje.equals("9")){
                    %>
                    <script type="text/javascript">
                    sweetAlert("�ERROR!", "�Intente nuevamente!", "error");
                    </script>
                    <%
                  }
}
              %>
  <!--Final barra-->
  <div class="main-container">
    <section class="fullscreen">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center">
            <h4 class="uppercase mb16">Listado de Mensajes</h4>
            <p class="lead mb64">
              Estos son todos los mensajes en la plataforma.
            </p>
          </div>
        </div>
        <!--final columna-->
        <div class="row">
          <div class="col-md-100 col-md-offset-0 col-sm-100 col-sm-offset-0">
            <table class="table cart mb48">
              <thead>
                <tr>
                  <th>N�</th>
                  <th>Nombre</th>
                  <th>Tel�fono</th>
                  <th>Mensaje</th>
                </tr>
              </thead>
              <tbody>
                                            <%
            if(iteArray!=null)
            {
                MensajesObj CTemp;
                while(iteArray.hasNext())
                {
                    CTemp = iteArray.next();
        %>
                  <tr>
                    <td>
                      <span><%= CTemp.getId() %></span>
                    </td>
                    <td>
                      <span><%= CTemp.getNombre() %></span>
                    </td>
                    <td>
                      <span><%= CTemp.getTelefono() %></span>
                    </td>
                    <td>
                      <span><%= CTemp.getMensaje() %></span>
                    </td>
                    <td>
                      <form method="post" action="../MensajeServlet" class="text-center form-envio" data-error="Completa todos los campos correctamente" data-success="�Mensaje eliminado!">
                        <input type="hidden" name="formid" value="3">
                        <input type="hidden" name="mid" value="<%= CTemp.getId() %>">
                        <div class="overflow-hidden">
                            <button style="background: red; border-color: red;" type="submit" name="eliminar">ELIMINAR</button>
                        </div>
                      </form>
                    </td>
                  </tr>
                           <%
                }
            }
        %>
        
                </tbody>
              </table>
            </div>
            <!--end of items-->
          </div>
        </div>
        <!--final contenedor-->
      </section>
      <br><br><br><br>
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
