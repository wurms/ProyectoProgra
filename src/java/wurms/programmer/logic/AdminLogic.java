package wurms.programmer.logic;

import wurms.programmer.database.DatabaseX;
import wurms.programmer.pojo.AdminObj;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class AdminLogic extends Logic
{
    
    public ArrayList<AdminObj> login(String strUsername, String strContra) 
    {
        //select * from travelsys.client;
        DatabaseX database = getDatabase();
        String strSql = "SELECT * FROM tbadmin WHERE usuario='"+strUsername+"' AND password = md5('"+strContra+"');";
        System.out.println(strSql);
        ResultSet p_CResult = database.executeQuery(strSql);
        ArrayList<AdminObj> arreglo = null;
        
        AdminObj CTemp;
        
        int iId;
        String strNombre;
        String strApellido;
        String strUsuario;
        String strPassword;
        
        if (p_CResult!=null) {
            try {
                arreglo = new ArrayList<>();
                while(p_CResult.next()){
                    iId = p_CResult.getInt("aid");
                    strNombre = p_CResult.getString("nombre");
                    strApellido = p_CResult.getString("apellido");
                    strUsuario = p_CResult.getString("usuario");
                    strPassword = p_CResult.getString("password");
                    
                    CTemp = new AdminObj(iId, strNombre, strApellido, strUsuario, strPassword);
                    arreglo.add(CTemp);
                }
            } catch (SQLException ex) {
                Logger.getLogger(AdminLogic.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return arreglo;
        
    }
}
