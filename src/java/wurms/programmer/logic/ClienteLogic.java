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
                    
                    CTemp = new ClienteObj(id, dui, nombre, apellido, direccion, ocupacion, telefono, celular, nit, fechanac, correo, password);
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
}
