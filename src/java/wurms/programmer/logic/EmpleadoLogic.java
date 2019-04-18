package wurms.programmer.logic;

import wurms.programmer.database.DatabaseX;
import wurms.programmer.pojo.EmpleadoObj;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class EmpleadoLogic extends Logic
{
    public int insertEmpleadoRows(String nombre, String apellido, String dui, String telefono, String correo, String usuario, String password)
    {
        //INSERT INTO travelsys.client(id,name,age) VALUES(0,'pepito',24);
        DatabaseX database = getDatabase();
        String strSql = "INSERT INTO tbempleado "
                + "VALUES(0,'"+nombre+"','"+apellido+"','"+dui+"','"+telefono+"','"+correo+"',1,'"+usuario+"',md5('"+password+"'))";
        System.out.println(strSql);
        int iRows = database.executeNonQueryRows(strSql);
        return iRows;
    }
    
    public ArrayList<EmpleadoObj> getAllEmpleados() 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "select * from tbempleado ";
        System.out.println(strSql);
        ResultSet CResult = database.executeQuery(strSql);
        ArrayList<EmpleadoObj> CArray = null;
        
        if(CResult!=null)
        {
            int id;
            String nombre;
            String apellido;
            String dui;
            String telefono;
            String correo;
            int habilitado;
            String usuario;
            String password;
            
            EmpleadoObj CTemp;
            CArray = new ArrayList<>();
            
            try 
            {
                while(CResult.next())
                {
                    id = CResult.getInt("eid");
                    dui = CResult.getString("dui");
                    nombre = CResult.getString("nombre");
                    apellido = CResult.getString("apellido");
                    telefono = CResult.getString("telefono");
                    correo = CResult.getString("correo");
                    password = CResult.getString("password");
                    habilitado = CResult.getInt("habilitado");
                    usuario = CResult.getString("usuario");
                    
                    CTemp = new EmpleadoObj(id, nombre, apellido, dui, telefono, correo, habilitado, usuario, password);
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
    
     public ArrayList<EmpleadoObj> getTheseEmpleados(String busqueda) 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "select * from tbempleado where nombre like '"+ busqueda +"%' or apellido like '"+ busqueda +"%' or dui like '"+ busqueda +"%' ";
        System.out.println(strSql);
        ResultSet CResult = database.executeQuery(strSql);
        ArrayList<EmpleadoObj> CArray = null;
        
        if(CResult!=null)
        {
            int id;
            String nombre;
            String apellido;
            String dui;
            String telefono;
            String correo;
            int habilitado;
            String usuario;
            String password;
            
            EmpleadoObj CTemp;
            CArray = new ArrayList<>();
            
            try 
            {
                while(CResult.next())
                {
                    id = CResult.getInt("eid");
                    dui = CResult.getString("dui");
                    nombre = CResult.getString("nombre");
                    apellido = CResult.getString("apellido");
                    telefono = CResult.getString("telefono");
                    correo = CResult.getString("correo");
                    password = CResult.getString("password");
                    habilitado = CResult.getInt("habilitado");
                    usuario = CResult.getString("usuario");
                    
                    CTemp = new EmpleadoObj(id, nombre, apellido, dui, telefono, correo, habilitado, usuario, password);
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
     
    public ArrayList<EmpleadoObj> login(String strUsername, String strContra) 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "SELECT * FROM tbempleado WHERE usuario='"+strUsername+"' AND password = md5('"+strContra+"');";
        System.out.println(strSql);
        ResultSet p_CResult = database.executeQuery(strSql);
        ArrayList<EmpleadoObj> arreglo = null;
        
        EmpleadoObj CTemp;
        
        int id;
        String nombre;
        String apellido;
        String dui;
        String telefono;
        String correo;
        int habilitado;
        String usuario;
        String password;
        
        if (p_CResult!=null) {
            try {
                arreglo = new ArrayList<>();
                while(p_CResult.next()){
                    id = p_CResult.getInt("eid");
                    dui = p_CResult.getString("dui");
                    nombre = p_CResult.getString("nombre");
                    apellido = p_CResult.getString("apellido");
                    telefono = p_CResult.getString("telefono");
                    correo = p_CResult.getString("correo");
                    password = p_CResult.getString("password");
                    habilitado = p_CResult.getInt("habilitado");
                    usuario = p_CResult.getString("usuario");
                    
                    CTemp = new EmpleadoObj(id, nombre, apellido, dui, telefono, correo, habilitado, usuario, password);
                    arreglo.add(CTemp);
                }
            } catch (SQLException ex) {
                Logger.getLogger(AdminLogic.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return arreglo;
        
    }
}
