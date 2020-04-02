<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaUsuario_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaUsuario_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }    
    
    public function insert($data) {
        $this->db->insert("usuarios", $data);
    }   
    
    public function validatePK($pk) {
        $this->db->select('*');
        $where = array('usuario' => $pk);
        $this->db->where($where);
        $this->db->from('usuarios');
        return $this->db->count_all_results();
    }    
}
