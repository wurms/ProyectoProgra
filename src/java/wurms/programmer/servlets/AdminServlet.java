package wurms.programmer.servlets;

import wurms.programmer.logic.AdminLogic;
import wurms.programmer.pojo.AdminObj;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import wurms.programmer.logic.ClienteLogic;
import wurms.programmer.logic.EmpleadoLogic;
import wurms.programmer.pojo.ClienteObj;
import wurms.programmer.pojo.EmpleadoObj;

@WebServlet(name = "AdminServlet", urlPatterns = {"/AdminServlet"})
public class AdminServlet extends HttpServlet 
{

    protected void processRequest(HttpServletRequest request, 
            HttpServletResponse response)
            throws ServletException, IOException 
    {
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) 
        {
            /* your code */
            String strFormId = request.getParameter("formid");
            
            if(strFormId.equals("1"))
            {
                String strUsuario = request.getParameter("usuario");
                String strPassword = request.getParameter("password");
                
                //access logica
                AdminLogic ALogic = new AdminLogic();
                ArrayList<AdminObj> AAdmin = ALogic.login(strUsuario, strPassword);
                
                //send to frontend
                if(AAdmin.size() == 1){
                    request.getSession().setAttribute("nivel", "0");
                    request.getSession().setAttribute("admin", AAdmin);
                    response.sendRedirect("admin/index.jsp");
                } else {
                    ClienteLogic CLogic = new ClienteLogic();
                    ArrayList<ClienteObj> ACliente = CLogic.login(strUsuario, strPassword);
                    
                    if(ACliente.size() == 1){
                        request.getSession().setAttribute("nivel", "1");
                        request.getSession().setAttribute("admin", ACliente);
                        response.sendRedirect("cliente/index.jsp");
                    } else {
                        EmpleadoLogic ELogic = new EmpleadoLogic();
                        ArrayList<EmpleadoObj> AEmpleado = ELogic.login(strUsuario, strPassword);

                        if(ACliente.size() == 1){
                            request.getSession().setAttribute("nivel", "2");
                            request.getSession().setAttribute("admin", AEmpleado);
                            response.sendRedirect("empleado/index.jsp");
                        } else {
                            String mensaje = "0";
                            request.getSession().setAttribute("mensaje", mensaje);
                            response.sendRedirect("loginusuario.jsp");
                        }
                    }
                }
            }
            
            if(strFormId.equals("2"))
            {
                //access logic
                response.setContentType("text/html;charset=UTF-8");
                HttpSession sesion = request.getSession(true);

                //Cerrar sesion
                sesion.invalidate();

                //Redirecciono a index.jsp
                response.sendRedirect("loginusuario.jsp");
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
