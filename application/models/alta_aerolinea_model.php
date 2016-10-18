<?php
/**
 * Description of alta_aerolinea_model
 *
 * @author Sebas
 */
class alta_aerolinea_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }  
    
    public function insert($data) {
        $this->db->insert("aerolineas", $data);
    }    
    
}
