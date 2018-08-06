<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of MenuGasto
 *
 * @author sebastian.ituarte@gmail.com
 */
class MenuGasto extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library(array('perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('MenuGasto_view');
    }
}