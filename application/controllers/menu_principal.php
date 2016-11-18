<?php
/**
 * Description of menu_principal
 *
 * @author Sebas
 */
class menu_principal extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->load->view('menu_principal_view');
    }
}
