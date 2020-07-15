<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of IngresoCajaSimulado
 *
 * @author sebastian.ituarte@gmail.com
 */
class IngresoCajaSimulado extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('IngresoCajaSimulado_model'));
        $this->load->library(array('validation', 'perms', 'session'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('IngresoCajaSimulado_view');
    }
    
    public function ingresoCajaSimulado() {
                 
    }
}
