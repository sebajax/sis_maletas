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
    
    private function buscarUltimoValor($id_aerolinea, $id_sector) {
        $where = array(
            'id_aerolinea' => $id_aerolinea,
            'id_sector'    => $id_sector
        );
        
        $this->db->select('valor');
        $this->db->where($where);
        $this->db->from('valores');
        $query = $this->db->get();   
        return $query->row();        
        
    }
    
    public function eliminarValor($id_aerolinea, $id_sector) {
        $row = $this->buscarUltimoValor($id_aerolinea, $id_sector);
        $data = array(
            'id_aerolinea'   => $id_aerolinea,
            'id_sector'      => $id_sector,
            'valor_anterior' => $row->valor,
            'valor_nuevo'    => 0,
            'tipo'           => 'DELETE'
        );
        
        $this->db->trans_start();
        $this->db->insert('historico_valores', $data);
        $this->db->delete('valores', array('id_aerolinea' => $id_aerolinea, 'id_sector' => $id_sector));
        $this->db->trans_complete();
    }  
    
    public function obtengoInformacionValor($id_aerolinea, $id_sector) {
        $where = array(
            'valores.id_aerolinea' => $id_aerolinea,
            'valores.id_sector'    => $id_sector
        );
        
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('valores');
        $this->db->join('sectores', 'sectores.id_sector = valores.id_sector');
        $query = $this->db->get();   
        return $query->row();
    }
    
    public function modificarValor($id_aerolinea, $id_sector, $valor_new) {
        $this->db->trans_start();
        $row = $this->buscarUltimoValor($id_aerolinea, $id_sector);
        $data_insert = array(
            'id_aerolinea'   => $id_aerolinea,
            'id_sector'      => $id_sector,
            'valor_anterior' => $row->valor,
            'valor_nuevo'    => $valor_new,
            'tipo'           => 'UPDATE'
        );
        
        $this->db->insert('historico_valores', $data_insert);
        
        $data_update = array(
            'valor' => $valor_new
        );
        $where = array(
            'id_aerolinea' => $id_aerolinea,
            'id_sector' => $id_sector,
        );
        $this->db->where($where);
        $this->db->update('valores', $data_update);         
        $this->db->trans_complete();
    }    
}
