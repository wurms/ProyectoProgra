package wurms.programmer.servlets;

import wurms.programmer.logic.MensajeLogic;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import wurms.programmer.pojo.MensajesObj;

@WebServlet(name = "MensajeServlet", urlPatterns = {"/MensajeServlet"})
public class MensajeServlet extends HttpServlet 
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
                String nombre = request.getParameter("nombre");
                String telefono = request.getParameter("telefono");
                String mensaje = request.getParameter("mensaje");
                
                //access logic
                MensajeLogic CLogic = new MensajeLogic();
                int iRows = CLogic.insertMensajeRows(nombre, telefono, mensaje);
                System.out.println("inser client rows: " + iRows);

                if (iRows == 1) {
                    request.getSession().setAttribute("mensaje", "1");
                    response.sendRedirect("contactanos.jsp");
                } else {
                    request.getSession().setAttribute("mensaje", "");
                    response.sendRedirect("contactanos.jsp");
                }
            }
            if(strFormId.equals("2"))
            {
                //access logic
                MensajeLogic CLogic = new MensajeLogic();
                ArrayList<MensajesObj> CArray = CLogic.getAllMensajes();

                //send to frontend
                request.getSession().setAttribute("mensajes", CArray);
                response.sendRedirect("admin/mensajes.jsp");
            }
            if(strFormId.equals("3"))
            {
                //get parameters
                String strId = request.getParameter("mid");
                int iId = Integer.parseInt(strId);
                
                //access logic
                MensajeLogic CLogic = new MensajeLogic();
                int iRows = CLogic.deleteMensajeRows(iId);
                
                //send to frontend
                if (iRows == 1) {
                    ArrayList<MensajesObj> CArray = CLogic.getAllMensajes();

                    //send to frontend
                    request.getSession().setAttribute("mensajes", CArray);
                    response.sendRedirect("admin/mensajes.jsp");
                } else {
                    request.getSession().setAttribute("mensaje", "9");
                    response.sendRedirect("admin/mensajes.jsp");
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
