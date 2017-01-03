<?php
/**
 * Description of eliminar_modificar_valor_model
 *
 * @author Sebas
 */
class eliminar_modificar_valor_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarValor($id_aerolinea, $grupo_sector, $lugar) {
        $where = array();
        
        if(!empty($id_aerolinea)) {
            $where['valores.id_aerolinea'] = $id_aerolinea;
        }
        if(!empty($lugar)) {
            $this->db->like('sectores.lugar', $lugar);
        }
        if(!empty($grupo_sector)) {
            $where['sectores.grupo_sector'] = $grupo_sector;
        }
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('valores');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = valores.id_aerolinea');
        $this->db->join('sectores', 'sectores.id_sector = valores.id_sector');
        $query = $this->db->get();   
        return $query->result();
    }
}
