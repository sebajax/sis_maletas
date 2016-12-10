<?php
/**
 * Description of menu_sector
 *
 * @author Sebas
 */
class menu_sector extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->load->view('menu_sector_view');
    }
}