<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of MenuPrincipal
 *
 * @author sebastian.ituarte@gmail.com
 */
class MenuPrincipal extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library(array('perms', 'session'));
        $this->load->model('EliminarModificarUsuario_model');
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(3)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function cambiarClave() {
        $clave  = $this->input->post('clave');
        $clave2 = $this->input->post('clave2');
        
        if($clave != $clave2) {
            echo json_encode(0);
            return false;            
        }
        
        if(strlen($clave) < 6) {
            echo json_encode(0);
            return false;             
        }
        
        $this->EliminarModificarUsuario_model->cambiarClave($clave);
        echo json_encode(1);
        return true;              
    }
    
    function index() {
        $this->load->view('MenuPrincipal_view');
    }
    
    function cerrar() {
        $this->session->sess_destroy();
    }
}
