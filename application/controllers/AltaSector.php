<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaSector
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaSector extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('AltaSector_model');
        $this->load->library(array('validation', 'perms'));
        $this->load->helper('sectores_helper');
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('AltaSector_view', $data);        
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
            $this->AltaSector_model->insert($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }        
    }
    
    private function validatePK($pk) {
        if($this->AltaSector_model->validatePK($pk) > 0) { return false; } else { return true; }
    }    
}
