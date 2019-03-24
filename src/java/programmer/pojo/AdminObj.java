/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package programmer.pojo;

/**
 *
 * @author Rodrigo Ortiz
 */
public class AdminObj {
    private int m_iId;
    private String m_sNombre;
    private String m_sApellido;
    private String m_sUsuario;
    private String m_sPassword;

    public AdminObj(int m_iId, String m_sNombre, String m_sApellido, String m_sUsuario, String m_sPassword) {
        setId(this.m_iId);
        setNombre(m_sNombre);
        setApellido(m_sApellido);
        setUsuario(m_sUsuario);
        setPassword(m_sPassword);
    }
    
    

    public int getId() {
        return m_iId;
    }

    private void setId(int p_iId) {
        m_iId = p_iId;
    }

    public String getNombre() {
        return m_sNombre;
    }

    private void setNombre(String m_sNombre) {
        this.m_sNombre = m_sNombre;
    }

    public String getApellido() {
        return m_sApellido;
    }

    private void setApellido(String m_sApellido) {
        this.m_sApellido = m_sApellido;
    }

    public String getUsuario() {
        return m_sUsuario;
    }

    private void setUsuario(String m_sUsuario) {
        this.m_sUsuario = m_sUsuario;
    }

    public String getPassword() {
        return m_sPassword;
    }

    private void setPassword(String m_sPassword) {
        this.m_sPassword = m_sPassword;
    }
    
    
    
}
