<?php
/**
 * Description of alta_sector
 *
 * @author Sebas
 */
class alta_sector extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('alta_sector_model');
        $this->load->library('validation');
        $this->load->helper('sectores_helper');
    }
    
    function index() {
        $data = array();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('alta_sector_view', $data);        
    }
    
    function altaSector() {
        $data = array(
            "grupo_sector" => $this->input->post('grupo_sector'),
            "lugar"        => $this->input->post('lugar'),
        );

        $errorPk    = false;
        $errorEmpty = false;
        
        if(!$this->validatePK($data)) { $errorPk = true; }
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if($errorPk) { echo "PK"; return false; }
        
        if(!$errorEmpty ) {
            $this->alta_sector_model->insert($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }        
    }
    
    private function validatePK($pk) {
        if($this->alta_sector_model->validatePK($pk) > 0) { return false; } else { return true; }
    }    
}
