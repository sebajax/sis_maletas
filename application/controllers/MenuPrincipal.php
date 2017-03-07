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
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('MenuPrincipal_view');
    }
    
    function cerrar() {
        $this->session->sess_destroy();
    }
}
