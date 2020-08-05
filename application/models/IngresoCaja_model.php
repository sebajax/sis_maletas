<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of IngresoCaja_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class IngresoCaja_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function nextBdoNumber($id_aerolinea) {
        $this->db->select_max('CAST(numero AS SIGNED)', 'numero');
        $where['id_aerolinea'] = $id_aerolinea;
        $this->db->where($where);
        $query = $this->db->get('bdo');
        if($query->num_rows() == 0) 
            return null;
        $row = $query->row();
        return $row->numero + 1;
    }
    
    public function firstIdSector() {
        $this->db->select_min('id_sector');
        $query = $this->db->get('sectores');
        $row = $query->row(); 
        return $row->id_sector;
    }
}
