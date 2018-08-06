<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaTipoGasto
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaTipoGasto extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('AltaTipoGasto_model');
        $this->load->library(array('validation', 'perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('AltaTipoGasto_view');
    }
    
    function altaTipoGasto() {
        $data = array(
            "tipo_gasto" => $this->input->post('tipo_gasto'),
        );
        
        $errorEmpty = false;
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if(!$errorEmpty ) {
            $this->AltaTipoGasto_model->insert($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
}
