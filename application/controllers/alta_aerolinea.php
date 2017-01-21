<?php
/**
 * Description of alta_aerolinea
 *
 * @author Sebas
 */
class alta_aerolinea extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('alta_aerolinea_model');
        $this->load->library(array('validation', 'perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('alta_aerolinea_view');
    }
    
    function altaAerolinea() {
        $data = array(
            "nombre_aerolinea" => $this->input->post('aerolinea'),
        );
        
        $errorEmpty = false;
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if(!$errorEmpty ) {
            $this->alta_aerolinea_model->insert($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
}
