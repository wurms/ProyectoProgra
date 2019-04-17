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
        String strSql = "INSERT INTO tbclientes"
                + "VALUES(0,'"+dui+"',"+nombre+"',"+apellido+"',"+direccion+"',"+ocupacion+"',"+telefono+"',"+celular+"',"+nit+"',"+fechanac+"',"+correo+"',md5("+password+")',0)";
        System.out.println(strSql);
        int iRows = database.executeNonQueryRows(strSql);
        return iRows;
    }
}
