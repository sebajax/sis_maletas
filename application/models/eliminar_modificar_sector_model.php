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
    
    public function verificarSectorBdo($id_sector) {
        $where = array(
            "sectores.id_sector" => $id_sector
        );
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('sectores');
        $this->db->join('bdo', 'sectores.id_sector = bdo.id_sector');
        $query = $this->db->get(); 
        if($query->num_rows() > 0) {
            return true;
        }else { 
            return false;
        }
    }    
    
    public function eliminarSector($id_sector) {
        $this->db->delete('sectores', array('id_sector' => $id_sector));
    }    
    
    public function obtengoInformacionSector($id_sector) {
        $where = array(
            'id_sector' => $id_sector
        );
        
        $this->db->select('*');
        $this->db->from('sectores');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function modificarSector($id_sector, $grupo_sector_new, $lugar_new) {
        $data = array(
            'grupo_sector' => $grupo_sector_new,
            'lugar' => $lugar_new
        );
        $where = array(
            'id_sector' => $id_sector
        );
        $this->db->where($where);
        $this->db->update('sectores', $data);        
    }
}
