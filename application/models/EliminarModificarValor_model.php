<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarValor_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarValor_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarValor($id_aerolinea, $grupo_sector) {
        $where = array();
        
        if(!empty($id_aerolinea)) {
            $where['valores.id_aerolinea'] = $id_aerolinea;
        }
        if(!empty($grupo_sector)) {
            $where['valores.grupo_sector'] = $grupo_sector;
        }
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('valores');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = valores.id_aerolinea');
        $query = $this->db->get();   
        return $query->result();
    }
    
    private function buscarUltimoValor($id_aerolinea, $grupo_sector) {
        $where = array(
            'id_aerolinea' => $id_aerolinea,
            'grupo_sector' => $grupo_sector
        );
        
        $this->db->select('valor');
        $this->db->where($where);
        $this->db->from('valores');
        $query = $this->db->get();   
        return $query->row();        
        
    }
    
    public function eliminarValor($id_aerolinea, $grupo_sector) {
        $row = $this->buscarUltimoValor($id_aerolinea, $grupo_sector);
        $data = array(
            'id_aerolinea'   => $id_aerolinea,
            'grupo_sector'      => $grupo_sector,
            'valor_anterior' => $row->valor,
            'valor_nuevo'    => 0,
            'tipo'           => 'DELETE',
            "usuario"        => $this->session->userdata('usuario')
        );
        
        $this->db->trans_start();
        $this->db->insert('historico_valores', $data);
        $this->db->delete('valores', array('id_aerolinea' => $id_aerolinea, 'grupo_sector' => $grupo_sector));
        $this->db->trans_complete();
    }  
    
    public function obtengoInformacionValor($id_aerolinea, $grupo_sector) {
        $where = array(
            'valores.id_aerolinea' => $id_aerolinea,
            'valores.grupo_sector' => $grupo_sector
        );
        
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('valores');
        $query = $this->db->get();   
        return $query->row();
    }
    
    public function modificarValor($id_aerolinea, $grupo_sector, $valor_new) {
        $this->db->trans_start();
        $row = $this->buscarUltimoValor($id_aerolinea, $grupo_sector);
        $data_insert = array(
            'id_aerolinea'   => $id_aerolinea,
            'grupo_sector'   => $grupo_sector,
            'valor_anterior' => $row->valor,
            'valor_nuevo'    => $valor_new,
            'tipo'           => 'UPDATE',
            "usuario"        => $this->session->userdata('usuario')
        );
        
        $this->db->insert('historico_valores', $data_insert);
        
        $data_update = array(
            'valor' => $valor_new
        );
        $where = array(
            'id_aerolinea' => $id_aerolinea,
            'grupo_sector' => $grupo_sector,
        );
        $this->db->where($where);
        $this->db->update('valores', $data_update);         
        $this->db->trans_complete();
    }    
}
