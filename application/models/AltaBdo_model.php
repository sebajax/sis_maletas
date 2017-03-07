<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaBdo_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaBdo_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        $this->db->insert("bdo", $data);
    }
    
    public function validatePK($pk) {
        $this->db->select('*');
        $where = array('numero' => $pk['numero'], 'id_aerolinea' => $pk['id_aerolinea']);
        $this->db->where($where);
        $this->db->from('bdo');
        return $this->db->count_all_results();
    } 
}