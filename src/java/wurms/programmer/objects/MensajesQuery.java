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
import wurms.programmer.pojo.MensajesObj;

/**
 *
 * @author Rodrigo Ortiz
 */
public class MensajesQuery extends Query<MensajesObj> {

    public MensajesQuery(String p_strSql) {
        super(p_strSql);
    }
    
    @Override
    public ArrayList<MensajesObj> createArrayList(ResultSet p_CResult) {
        ArrayList<MensajesObj> arreglo = null;
        
        MensajesObj CTemp;
        
        String strNombre;
        String strTelefono;
        String strMensaje;
        
        if (p_CResult!=null) {
            try {
                arreglo = new ArrayList<>();
                while(p_CResult.next()){
                    strNombre = p_CResult.getString("nombre");
                    strTelefono = p_CResult.getString("telefono");
                    strMensaje = p_CResult.getString("mensaje");
                    
                    CTemp = new MensajesObj(strNombre, strTelefono, strMensaje);
                    arreglo.add(CTemp);
                }
            } catch (SQLException ex) {
                Logger.getLogger(MensajesQuery.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return arreglo;
    }
    
}
