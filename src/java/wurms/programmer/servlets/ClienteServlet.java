package wurms.programmer.servlets;

import wurms.programmer.logic.ClienteLogic;
import wurms.programmer.pojo.ClienteObj;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet(name = "ClienteServlet", urlPatterns = {"/ClienteServlet"})
public class ClienteServlet extends HttpServlet 
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
                String dui = request.getParameter("dui");
                String nombre = request.getParameter("nombre");
                String apellido = request.getParameter("apellido");
                String direccion = request.getParameter("direccion");
                String ocupacion = request.getParameter("ocupacion");
                String telefono = request.getParameter("telefono");
                String celular = request.getParameter("celular");
                String nit = request.getParameter("nit");
                String fechanac = request.getParameter("fechanac");
                String correo = request.getParameter("email");
                String password = request.getParameter("password1");
                    System.out.println(dui);
                    //access logic
                    ClienteLogic CLogic = new ClienteLogic();
                    int iRows = CLogic.insertClienteRows(dui, nombre, apellido, direccion, ocupacion, telefono, celular, nit, fechanac, correo, password);
                    System.out.println("inser client rows: " + iRows);

                    if (iRows == 1) {
                        request.getSession().setAttribute("mensaje", "1");
                        response.sendRedirect("register.jsp");
                    } else {
                        request.getSession().setAttribute("mensaje", "2");
                        response.sendRedirect("register.jsp");
                    }
            }
            if(strFormId.equals("2"))
                {
                    //access logic
                    ClienteLogic CLogic = new ClienteLogic();
                    ArrayList<ClienteObj> CArray = CLogic.getAllClientes();

                    //send to frontend
                    request.getSession().setAttribute("clientes", CArray);
                    response.sendRedirect("admin/vclientes.jsp");
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
