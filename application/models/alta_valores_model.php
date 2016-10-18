<?php
/**
 * Description of alta_valores_model
 *
 * @author Sebas
 */
class alta_valores_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }    
    
    public function insert($data) {
        $this->db->insert("valores", $data);
    }    
    
    public function getAerolineas() {
        $aerolineas = array();
        $aerolineas[0] = '-SELECCIONE-';
        $query = $this->db->get('aerolineas');
        foreach($query->result() as $row) {
            $aerolineas[$row->id_aerolinea] = $row->nombre_aerolinea;
        }
        return $aerolineas;
    }   
    
    public function getLugares($grupo_sectores) {
        $lugares = array();
        $this->db->distinct();
        $this->db->select('lugar');
        $this->db->from('sectores');
        $this->db->where('grupo_sector', $grupo_sectores);
        $this->db->order_by('lugar', 'ASC');
        $query = $this->db->get();
        
        foreach($query->result() as $row) {
            $lugares[] = $row->lugar;
        }
        return $lugares;
    }     
    
    public function validatePK($pk) {
        $this->db->select('*');
        $where = array('id_aerolinea' => $pk['id_aerolinea'], 'id_sector' => $pk['id_sector']);
        $this->db->where($where);
        $this->db->from('valores');
        return $this->db->count_all_results();
    }    
    
    public function getSector($grupo_sector, $lugar) {
        $this->db->select('id_sector');
        $where = array('grupo_sector' => $grupo_sector, 'lugar' => $lugar);
        $this->db->where($where);
        $this->db->from('sectores');
        $query = $this->db->get();
        $row = $query->row();
        return $row->id_sector;
    }
    
    public function getValor($id_aerolinea, $id_sector) {
        $this->db->select('valor');
        $where = array("id_aerolinea" => $id_aerolinea, "id_sector" => $id_sector);
        $this->db->where($where);
        $this->db->from('valores');
        $query = $this->db->get();
        $row = $query->row();
        if(empty($row)) {
            return "No hay valores cargados";
        }
        return $row->valor;
    }
}
