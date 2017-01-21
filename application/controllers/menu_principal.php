<?php
/**
 * Description of menu_principal
 *
 * @author Sebas
 */
class menu_principal extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library(array('perms', 'session'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('menu_principal_view');
    }
    
    function cerrar() {
        $this->session->sess_destroy();
    }
}
