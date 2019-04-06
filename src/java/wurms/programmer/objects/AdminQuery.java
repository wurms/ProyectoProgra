/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package wurms.programmer.objects;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import wurms.programmer.pojo.AdminObj;

/**
 *
 * @author Rodrigo Ortiz
 */
public class AdminQuery extends Query<AdminObj> {

    public AdminQuery(String p_strSql) {
        super(p_strSql);
    }

    @Override
    public ArrayList<AdminObj> createArrayList(ResultSet p_CResult) {
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
                Logger.getLogger(AdminQuery.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return arreglo;
    }
    
}
