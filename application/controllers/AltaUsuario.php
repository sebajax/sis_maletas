<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaUsuario
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaUsuario extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('AltaUsuario_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(1)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('AltaUsuario_view');
    }
    
    function altaUsuario() {
        $data = array(
            "usuario"       => $this->input->post('usuario'),
            "clave"         => sha1($this->input->post('usuario')),
            "nombre"        => $this->input->post('nombre'),
            "apellido"      => $this->input->post('apellido'),
            "id_perfil"     => $this->input->post('privilegios'),
            "nombre_perfil" => $this->input->post('nombre_perfil')
        );

        $errorPk    = false;
        $errorEmpty = false;
        
        if(!$this->validatePK($data['usuario'])) { $errorPk = true; }
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if($errorPk) { echo "PK"; return false; }
        
        if(!$errorEmpty ) {
            $this->AltaUsuario_model->insert($data);
            $this->Auditoria_model->insert($data, "insert", "usuarios", $this->db->last_query());
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }        
    }
    
    private function validatePK($pk) {
        if($this->AltaUsuario_model->validatePK($pk) > 0) { return false; } else { return true; }
    }    
}
