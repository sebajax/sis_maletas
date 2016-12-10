<?php
/**
 * Description of menu_bdo
 *
 * @author Sebas
 */
class menu_bdo extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->load->view('menu_bdo_view');
    }
}