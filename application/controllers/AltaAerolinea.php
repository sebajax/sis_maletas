<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaAerolinea
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaAerolinea extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('AltaAerolinea_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('AltaAerolinea_view');
    }
    
    function altaAerolinea() {
        $data = array(
            "nombre_aerolinea" => $this->input->post('aerolinea'),
        );
        
        $errorEmpty = false;
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if(!$errorEmpty ) {
            $this->AltaAerolinea_model->insert($data);
            $this->Auditoria_model->insert($data, "insert", "aerolineas", $this->db->last_query());
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
}
