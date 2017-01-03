<?php
/**
 * Description of eliminar_modificar_sector_model
 *
 * @author Sebas
 */
class eliminar_modificar_sector_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarSector($grupo_sector, $lugar) {
        $where = array();

        if(!empty($grupo_sector)) {
            $where['grupo_sector'] = $grupo_sector;
        }
        if(!empty($lugar)) {
            $this->db->like('lugar', $lugar);
        }
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('sectores');
        $query = $this->db->get();   
        return $query->result();
    }
}
