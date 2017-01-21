<?php
/**
 * Description of menu_sector
 *
 * @author Sebas
 */
class menu_sector extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library(array('perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('menu_sector_view');
    }
}