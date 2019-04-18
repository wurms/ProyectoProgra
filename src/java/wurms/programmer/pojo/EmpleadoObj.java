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
public class EmpleadoObj {
    private int id;
    private String nombre;
    private String apellido;
    private String dui;
    private String telefono;
    private String correo;
    private int habilitado;
    private String usuario;
    private String password;

    public EmpleadoObj(int id, String nombre, String apellido, String dui, String telefono, String correo, int habilitado, String usuario, String password) {
        setId(id);
        setNombre(nombre);
        setApellido(apellido);
        setDui(dui);
        setTelefono(telefono);
        setCorreo(correo);
        setHabilitado(habilitado);
        setUsuario(usuario);
        setPassword(password);
    }
    
    

    public int getId() {
        return id;
    }

    private void setId(int id) {
        this.id = id;
    }

    public String getNombre() {
        return nombre;
    }

    private void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public String getApellido() {
        return apellido;
    }

    private void setApellido(String apellido) {
        this.apellido = apellido;
    }

    public String getDui() {
        return dui;
    }

    private void setDui(String dui) {
        this.dui = dui;
    }

    public String getTelefono() {
        return telefono;
    }

    private void setTelefono(String telefono) {
        this.telefono = telefono;
    }

    public String getCorreo() {
        return correo;
    }

    private void setCorreo(String correo) {
        this.correo = correo;
    }

    public int getHabilitado() {
        return habilitado;
    }

    private void setHabilitado(int habilitado) {
        this.habilitado = habilitado;
    }

    public String getUsuario() {
        return usuario;
    }

    private void setUsuario(String usuario) {
        this.usuario = usuario;
    }

    public String getPassword() {
        return password;
    }

    private void setPassword(String password) {
        this.password = password;
    }
    
    
}
