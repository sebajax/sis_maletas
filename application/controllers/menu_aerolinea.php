<?php
/**
 * Description of menu_aerolinea
 *
 * @author Sebas
 */
class menu_aerolinea extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->load->view('menu_aerolinea_view');
    }
}