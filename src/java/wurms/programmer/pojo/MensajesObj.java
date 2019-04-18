/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package wurms.programmer.pojo;

/**
 *
 * @author Rodrigo Ortiz
 */
public class MensajesObj {
    private int m_iId;
    private String m_strNombre;
    private String m_strTelefono;
    private String m_strMensaje;

    public MensajesObj(int m_iId, String m_strNombre, String m_strTelefono, String m_strMensaje) {
        setId(m_iId);
        setNombre(m_strNombre);
        setTelefono(m_strTelefono);
        setMensaje(m_strMensaje);
    }

    public int getId() {
        return m_iId;
    }

    private void setId(int m_iId) {
        this.m_iId = m_iId;
    }
    
    
    
    public String getNombre() {
        return m_strNombre;
    }

    private void setNombre(String m_strNombre) {
        this.m_strNombre = m_strNombre;
    }

    public String getTelefono() {
        return m_strTelefono;
    }

    private void setTelefono(String m_strTelefono) {
        this.m_strTelefono = m_strTelefono;
    }

    public String getMensaje() {
        return m_strMensaje;
    }

    private void setMensaje(String m_strMensaje) {
        this.m_strMensaje = m_strMensaje;
    }
    
    
}
