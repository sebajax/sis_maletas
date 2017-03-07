<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaValores
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaValores extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('AltaValores_model');
        $this->load->library(array('validation', 'perms'));
        $this->load->helper(array('sectores_helper', 'aerolineas_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    } 
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('AltaValores_view', $data);         
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
            $this->AltaValores_model->insert($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }        
    }
    
    private function validatePK($pk) {
        if($this->AltaValores_model->validatePK($pk) > 0) { return false; } else { return true; }
    }    
}
