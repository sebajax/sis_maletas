<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarUsuario_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarUsuario_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function loadUsuarios() {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->order_by('usuario', 'ASC');
        $query = $this->db->get();   
        return $query->result();
    }
    
    public function eliminarUsuario($usuario) {
        $data = array(
            'usuario' => $usuario
        );
        $this->db->delete('usuarios', $data);
    }  
    
    public function modificarUsuario($data) {
        $where = array(
            'usuario' => $data['usuario']
        );
       
        $data_update = array(
            "nombre"        => $data["nombre"],
            "apellido"      => $data["apellido"],
            "id_perfil"     => $data["id_perfil"],
            "nombre_perfil" => $data["nombre_perfil"]
        );
        
        $this->db->where($where);
        $this->db->update('usuarios', $data_update);
    } 
    
    public function cambiarClave($clave) {
        $where = array(
            'usuario' => $this->session->usuario
        );
       
        $data_update = array(
            "clave" => sha1($clave)
        );
        
        $this->db->where($where);
        $this->db->update('usuarios', $data_update);
        log_message("debug", $this->db->last_query());
    }     
    
    public function limpiarClave($usuario) {
        $where = array(
            'usuario' => $usuario
        );
       
        $data_update = array(
            "clave" => sha1($usuario)
        );
        
        $this->db->where($where);
        $this->db->update('usuarios', $data_update);
    }
   
    public function cargoDatosUsuario($usuario) {
        $this->db->select('*');
        $this->db->from('usuarios');  
        $this->db->where(array('usuario' => $usuario));
        $query = $this->db->get();
        return $query->row();        
    }
}
