package wurms.programmer.logic;

import wurms.programmer.database.DatabaseX;
import wurms.programmer.pojo.ClienteObj;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class ClienteLogic extends Logic
{
    public int insertClienteRows(String dui, String nombre, String apellido, String direccion, String ocupacion, String telefono, String celular, String nit, String fechanac, String correo, String password)
    {
        //INSERT INTO travelsys.client(id,name,age) VALUES(0,'pepito',24);
        DatabaseX database = getDatabase();
        String strSql = "INSERT INTO tbcliente "
                + "VALUES(0,'"+dui+"','"+nombre+"','"+apellido+"','"+direccion+"','"+ocupacion+"','"+telefono+"','"+celular+"','"+nit+"','"+fechanac+"','"+correo+"',md5('"+password+"'),0)";
        System.out.println(strSql);
        int iRows = database.executeNonQueryRows(strSql);
        return iRows;
    }
    
    public ArrayList<ClienteObj> getAllClientes() 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "select * from tbcliente ";
        System.out.println(strSql);
        ResultSet CResult = database.executeQuery(strSql);
        ArrayList<ClienteObj> CArray = null;
        
        if(CResult!=null)
        {
            int id;
            String dui;
            String nombre;
            String apellido;
            String direccion;
            String ocupacion;
            String telefono;
            String celular;
            String nit;
            String fechanac;
            String correo;
            String password;
            int habilitado;
            
            ClienteObj CTemp;
            CArray = new ArrayList<>();
            
            try 
            {
                while(CResult.next())
                {
                    id = CResult.getInt("cid");
                    dui = CResult.getString("dui");
                    nombre = CResult.getString("nombre");
                    apellido = CResult.getString("apellido");
                    direccion = CResult.getString("direccion");
                    ocupacion = CResult.getString("ocupacion");
                    telefono = CResult.getString("telefono");
                    celular = CResult.getString("celular");
                    nit = CResult.getString("nit");
                    fechanac = CResult.getString("fechanac");
                    correo = CResult.getString("correo");
                    password = CResult.getString("password");
                    habilitado = CResult.getInt("habilitado");
                    
                    CTemp = new ClienteObj(id, dui, nombre, apellido, direccion, ocupacion, telefono, celular, nit, fechanac, correo, password, habilitado);
                    CArray.add(CTemp);
                }
            } 
            catch (SQLException ex) 
            {
                Logger.getLogger(ClienteLogic.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        
        return CArray;
        
    }
    
     public ArrayList<ClienteObj> getTheseClientes(String busqueda) 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "select * from tbcliente where nombre like '"+ busqueda +"%' or apellido like '"+ busqueda +"%' or dui like '"+ busqueda +"%' ";
        System.out.println(strSql);
        ResultSet CResult = database.executeQuery(strSql);
        ArrayList<ClienteObj> CArray = null;
        
        if(CResult!=null)
        {
            int id;
            String dui;
            String nombre;
            String apellido;
            String direccion;
            String ocupacion;
            String telefono;
            String celular;
            String nit;
            String fechanac;
            String correo;
            String password;
            int habilitado;
            
            ClienteObj CTemp;
            CArray = new ArrayList<>();
            
            try 
            {
                while(CResult.next())
                {
                    id = CResult.getInt("cid");
                    dui = CResult.getString("dui");
                    nombre = CResult.getString("nombre");
                    apellido = CResult.getString("apellido");
                    direccion = CResult.getString("direccion");
                    ocupacion = CResult.getString("ocupacion");
                    telefono = CResult.getString("telefono");
                    celular = CResult.getString("celular");
                    nit = CResult.getString("nit");
                    fechanac = CResult.getString("fechanac");
                    correo = CResult.getString("correo");
                    password = CResult.getString("password");
                    habilitado = CResult.getInt("habilitado");
                    
                    CTemp = new ClienteObj(id, dui, nombre, apellido, direccion, ocupacion, telefono, celular, nit, fechanac, correo, password, habilitado);
                    CArray.add(CTemp);
                }
            } 
            catch (SQLException ex) 
            {
                Logger.getLogger(ClienteLogic.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        
        return CArray;
        
    }
     public ArrayList<ClienteObj> login(String strUsername, String strContra) 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "SELECT * FROM tbcliente WHERE dui='"+strUsername+"' AND password = md5('"+strContra+"');";
        System.out.println(strSql);
        ResultSet p_CResult = database.executeQuery(strSql);
        ArrayList<ClienteObj> arreglo = null;
        
        ClienteObj CTemp;
        
        int id;
        String dui;
        String nombre;
        String apellido;
        String direccion;
        String ocupacion;
        String telefono;
        String celular;
        String nit;
        String correo;
        String fechanac;
        String password;
        int habilitado;
        
        if (p_CResult!=null) {
            try {
                arreglo = new ArrayList<>();
                while(p_CResult.next()){
                    id = p_CResult.getInt("cid");
                    dui = p_CResult.getString("dui");
                    nombre = p_CResult.getString("nombre");
                    apellido = p_CResult.getString("apellido");
                    direccion = p_CResult.getString("direccion");
                    ocupacion = p_CResult.getString("ocupacion");
                    telefono = p_CResult.getString("telefono");
                    celular = p_CResult.getString("celular");
                    nit = p_CResult.getString("nit");
                    fechanac = p_CResult.getString("fechanac");
                    correo = p_CResult.getString("correo");
                    password = p_CResult.getString("password");
                    habilitado = p_CResult.getInt("habilitado");
                    
                    CTemp = new ClienteObj(id, dui, nombre, apellido, direccion, ocupacion, telefono, celular, nit, fechanac, correo, password, habilitado);
                    arreglo.add(CTemp);
                }
            } catch (SQLException ex) {
                Logger.getLogger(AdminLogic.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return arreglo;
        
    }
}
