<?php
/**
 * Description of alta_valores
 *
 * @author Carolina
 */
class alta_valores extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('alta_valores_model');
        $this->load->library('validation');
        $this->load->helper(array('sectores_helper', 'aerolineas_helper'));
    } 
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('alta_valores_view', $data);         
    }

    function altaValores() {
        $data = array(
            "aerolinea"    => $this->input->post('aerolinea'),
            "grupo_sector" => $this->input->post('grupo_sector'),
            "valor"        => $this->input->post('valor'),
        );
        
        $errorPk    = false;
        $errorEmpty = false;       
        
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }    
        
        unset($data);
        $data = array(
            "id_aerolinea" => $this->input->post('aerolinea'),
            "grupo_sector" => $this->input->post('grupo_sector'),
            "valor"        => $this->input->post('valor'),
        );
        
        if(!$this->validatePK($data)) { $errorPk = true; }
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }    
         
        if($errorPk) { echo "PK"; return false; }
        
        if(!$errorEmpty) {
            $this->alta_valores_model->insert($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }        
    }
    
    private function validatePK($pk) {
        if($this->alta_valores_model->validatePK($pk) > 0) { return false; } else { return true; }
    }    
}
