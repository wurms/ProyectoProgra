package wurms.programmer.logic;

import wurms.programmer.database.DatabaseX;
import wurms.programmer.pojo.MensajesObj;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class MensajeLogic extends Logic
{
    public int insertMensajeRows(String nombre, String telefono, String mensaje)
    {
        //INSERT INTO travelsys.client(id,name,age) VALUES(0,'pepito',24);
        DatabaseX database = getDatabase();
        String strSql = "INSERT INTO tbmensajes "
                + "VALUES(0,'"+nombre+"','"+telefono+"','"+mensaje+"')";
        System.out.println(strSql);
        int iRows = database.executeNonQueryRows(strSql);
        return iRows;
    }
    public ArrayList<MensajesObj> getAllMensajes() 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "select * from tbmensajes ";
        System.out.println(strSql);
        ResultSet CResult = database.executeQuery(strSql);
        ArrayList<MensajesObj> CArray = null;
        
        if(CResult!=null)
        {
            int id;
            String nombre;
            String telefono;
            String mensaje;
            
            MensajesObj CTemp;
            CArray = new ArrayList<>();
            
            try 
            {
                while(CResult.next())
                {
                    id = CResult.getInt("mid");
                    nombre = CResult.getString("nombre");
                    telefono = CResult.getString("telefono");
                    mensaje = CResult.getString("mensaje");
                    
                    CTemp = new MensajesObj(id, nombre, telefono, mensaje);
                    CArray.add(CTemp);
                }
            } 
            catch (SQLException ex) 
            {
                Logger.getLogger(EmpleadoLogic.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        
        return CArray;
        
    }
    public int deleteMensajeRows(int p_iId) 
    {
        //delete from travelsys.client where id=0;
        DatabaseX database = getDatabase();
        String strSql = "delete from tbmensajes "
                + "where mid="+p_iId+" ";
        System.out.println(strSql);
        int iRows = database.executeNonQueryRows(strSql);
        return iRows;
    }
}
