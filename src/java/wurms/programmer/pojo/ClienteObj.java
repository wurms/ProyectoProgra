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
public class ClienteObj {
    private String m_strDui;
    private String m_strNombre;
    private String m_strApellido;
    private String m_strDireccion;
    private String m_strOcupacion;
    private String m_strTelefono;
    private String m_strCelular;
    private String m_strNit;
    private String m_strFechanac;
    private String m_strCorreo;
    private String m_strPassword;

    public ClienteObj(String m_strDui, String m_strNombre, String m_strApellido, String m_strDireccion, String m_strOcupacion, String m_strTelefono, String m_strCelular, String m_strNit, String m_strFechanac, String m_strCorreo, String m_strPassword) {
        setDui(m_strDui);
        setNombre(m_strNombre);
        setApellido(m_strApellido);
        setDireccion(m_strDireccion);
        setOcupacion(m_strOcupacion);
        setTelefono(m_strTelefono);
        setCelular(m_strCelular);
        setNit(m_strNit);
        setFechanac(m_strFechanac);
        setCorreo(m_strCorreo);
        setPassword(m_strPassword);
    }

    
    
    public String getDui() {
        return m_strDui;
    }

    private void setDui(String m_strDui) {
        this.m_strDui = m_strDui;
    }

    public String getNombre() {
        return m_strNombre;
    }

    private void setNombre(String m_strNombre) {
        this.m_strNombre = m_strNombre;
    }

    public String getApellido() {
        return m_strApellido;
    }

    private void setApellido(String m_strApellido) {
        this.m_strApellido = m_strApellido;
    }

    public String getDireccion() {
        return m_strDireccion;
    }

    private void setDireccion(String m_strDireccion) {
        this.m_strDireccion = m_strDireccion;
    }

    public String getOcupacion() {
        return m_strOcupacion;
    }

    private void setOcupacion(String m_strOcupacion) {
        this.m_strOcupacion = m_strOcupacion;
    }

    public String getTelefono() {
        return m_strTelefono;
    }

    private void setTelefono(String m_strTelefono) {
        this.m_strTelefono = m_strTelefono;
    }

    public String getCelular() {
        return m_strCelular;
    }

    private void setCelular(String m_strCelular) {
        this.m_strCelular = m_strCelular;
    }

    public String getNit() {
        return m_strNit;
    }

    private void setNit(String m_strNit) {
        this.m_strNit = m_strNit;
    }

    public String getFechanac() {
        return m_strFechanac;
    }

    private void setFechanac(String m_strFechanac) {
        this.m_strFechanac = m_strFechanac;
    }

    public String getCorreo() {
        return m_strCorreo;
    }

    private void setCorreo(String m_strCorreo) {
        this.m_strCorreo = m_strCorreo;
    }

    public String getPassword() {
        return m_strPassword;
    }

    private void setPassword(String m_strPassword) {
        this.m_strPassword = m_strPassword;
    }
    
    
}
