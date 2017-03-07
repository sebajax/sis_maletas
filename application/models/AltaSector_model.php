<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaSector_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaSector_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }    
    
    public function insert($data) {
        $this->db->insert("sectores", $data);
    }   
    
    public function validatePK($pk) {
        $this->db->select('*');
        $where = array('grupo_sector' => $pk['grupo_sector'], 'lugar' => $pk['lugar']);
        $this->db->where($where);
        $this->db->from('sectores');
        return $this->db->count_all_results();
    }    
}
