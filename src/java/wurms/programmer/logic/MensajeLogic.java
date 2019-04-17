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
    public int insertMensajeRows(String p_strName, String p_strLastName, String p_iAge)
    {
        //INSERT INTO travelsys.client(id,name,age) VALUES(0,'pepito',24);
        DatabaseX database = getDatabase();
        String strSql = "INSERT INTO tbmensajes(id,name,age) "
                + "VALUES(0,'"+p_strName+"',"+p_iAge+")";
        System.out.println(strSql);
        int iRows = database.executeNonQueryRows(strSql);
        return iRows;
    }
}
