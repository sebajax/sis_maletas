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
    
    public function countUnited($id_sector, $fecha_llegada) {
        $this->db->select('*');
        $where = array('id_aerolinea' => 3, 'id_sector' => $id_sector);
        $where['fecha_llegada >='] = $fecha_llegada;
        $where['fecha_llegada <='] = $fecha_llegada.' 23:59:59';
        $this->db->where($where);
        $this->db->from('bdo');
        return $this->db->count_all_results();    
    }
}
