<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaGastoSimulado
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaGastoSimulado extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('AltaGastoSimulado_model'));
        $this->load->library(array('validation', 'perms', 'session'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('AltaGastoSimulado_view');
    }
    
    public function altaGastoSimulado() {
                 
    }
}
