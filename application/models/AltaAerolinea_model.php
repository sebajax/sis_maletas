<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaAerolinea_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaAerolinea_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }  
    
    public function insert($data) {
        $this->db->insert("aerolineas", $data);
    }    
    
}
