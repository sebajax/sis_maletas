<?php
/**
 * Description of menu_valor
 *
 * @author Sebas
 */
class menu_valor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->load->view('menu_valor_view');
    }
}