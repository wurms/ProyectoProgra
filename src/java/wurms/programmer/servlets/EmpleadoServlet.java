package wurms.programmer.servlets;

import wurms.programmer.logic.EmpleadoLogic;
import wurms.programmer.pojo.EmpleadoObj;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet(name = "EmpleadoServlet", urlPatterns = {"/EmpleadoServlet"})
public class EmpleadoServlet extends HttpServlet 
{

    protected void processRequest(HttpServletRequest request, 
            HttpServletResponse response)
            throws ServletException, IOException 
    {
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) 
        {
            String strFormId = request.getParameter("formid");
            
            if(strFormId.equals("1"))
            {
                //get parameters
                String nombre = request.getParameter("nombre");
                String apellido = request.getParameter("apellido");
                String dui = request.getParameter("dui");
                String telefono = request.getParameter("telefono");
                String correo = request.getParameter("email");
                String usuario = request.getParameter("usuario");
                String password = request.getParameter("password1");
                    //access logic
                    EmpleadoLogic CLogic = new EmpleadoLogic();
                    int iRows = CLogic.insertEmpleadoRows(nombre, apellido, dui, telefono, correo, usuario, password);
                    System.out.println("inser client rows: " + iRows);

                    if (iRows == 1) {
                        response.sendRedirect("admin/aempleado.jsp?mensaje=1");
                    } else {
                        request.getSession().setAttribute("mensaje", "2");
                        response.sendRedirect("admin/aempleado.jsp");
                    }
            }
            if(strFormId.equals("2"))
                {
                    //access logic
                    EmpleadoLogic CLogic = new EmpleadoLogic();
                    ArrayList<EmpleadoObj> CArray = CLogic.getAllEmpleados();

                    //send to frontend
                    request.getSession().setAttribute("empleados", CArray);
                    response.sendRedirect("admin/vempleados.jsp");
                }
            if(strFormId.equals("3"))
                {
                    String busqueda = request.getParameter("busqueda");
                    //access logic
                    EmpleadoLogic CLogic = new EmpleadoLogic();
                    ArrayList<EmpleadoObj> CArray = CLogic.getTheseEmpleados(busqueda);

                    //send to frontend
                    request.getSession().setAttribute("empleados", CArray);
                    response.sendRedirect("admin/vempleados.jsp");
                }
            if(strFormId.equals("4"))
            {
                //get parameters
                String strId = request.getParameter("id");
                int iId = Integer.parseInt(strId);
                
                //access logic
                EmpleadoLogic CLogic = new EmpleadoLogic();
                EmpleadoObj CEmpleado = CLogic.getEmpleadoById(iId);
                
                //send to frontend
                request.getSession().setAttribute("empleado", CEmpleado);
                response.sendRedirect("admin/mempleado.jsp");
            }
            if(strFormId.equals("5"))
            {
                //get parameters
                String strId = request.getParameter("id");
                int id = Integer.parseInt(strId);
                String nombre = request.getParameter("nombre");
                String apellido = request.getParameter("apellido");
                String dui = request.getParameter("dui");
                String telefono = request.getParameter("telefono");
                String correo = request.getParameter("email");
                String usuario = request.getParameter("usuario");
                    //access logic
                    EmpleadoLogic CLogic = new EmpleadoLogic();
                    int iRows = CLogic.updateEmpleadoRows(id, nombre, apellido, dui, telefono, correo, usuario);
                    System.out.println("inser client rows: " + iRows);

                    if (iRows == 1) {
                        EmpleadoObj CEmpleado = CLogic.getEmpleadoById(id);

                        //send to frontend
                        request.getSession().setAttribute("empleado", CEmpleado);
                        response.sendRedirect("admin/mempleado.jsp");
                    } else {
                        response.sendRedirect("admin/mempleado.jsp?mensaje=2");
                    }
            }
            
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
