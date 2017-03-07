<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of ConsultaBdo_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class ConsultaBdo_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarBdo($numero, $id_aerolinea, $nombre_pasajero, $fecha_desde, $fecha_hasta, $grupo_sector, $estado) {
        $where = array();
        
        if(!empty($numero)) {
            $where['bdo.numero'] = $numero;
        }
        if(!empty($id_aerolinea)) {
            $where['bdo.id_aerolinea'] = $id_aerolinea;
        }
        if(!empty($nombre_pasajero)) {
            $this->db->like('bdo.nombre_pasajero', $nombre_pasajero);
        }
        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $where['bdo.fecha_llegada >='] = $fecha_desde;
            $where['bdo.fecha_llegada <='] = $fecha_hasta;
        }
        if(!empty($grupo_sector)) {
            $where['sectores.grupo_sector'] = $grupo_sector;
        }
        if($estado != "") {
            $where['estado'] = $estado;
        }
        $this->db->select('*');
        $this->db->from('bdo');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = bdo.id_aerolinea');
        $this->db->join('sectores', 'sectores.id_sector = bdo.id_sector');
        $this->db->where($where);
        $query = $this->db->get(); 
        return $query->result();
    }
    
    public function cargoInformacionExtra($numero, $id_aerolinea) {
        $where = array();
        
        if(empty($numero)) {
           return false; 
        }
        if(empty($id_aerolinea)) {
            return false;
        }
        
        $where['bdo.id_aerolinea'] = $id_aerolinea;
        $where['bdo.numero'] = $numero;
        
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('bdo');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = bdo.id_aerolinea');
        $this->db->join('sectores', 'sectores.id_sector = bdo.id_sector');
        $query = $this->db->get();   
        return $query->row();
    }
    
    public function cargoComentarios($numero, $id_aerolinea) {
        $where = array();
        
        if(empty($numero)) {
           return false; 
        }
        if(empty($id_aerolinea)) {
            return false;
        }
        
        $where['id_aerolinea'] = $id_aerolinea;
        $where['numero'] = $numero;
        
        $this->db->select('*');
        $this->db->from('comentarios_bdo');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();     
    }
    
    public function countComentarios($numero, $id_aerolinea) {
        $where = array();
        
        if(empty($numero)) {
           return false; 
        }
        if(empty($id_aerolinea)) {
            return false;
        }
        
        $where['cbdo.id_aerolinea'] = $id_aerolinea;
        $where['cbdo.numero'] = $numero;
        $where['bdo.estado'] = 0;
        
        $this->db->select('*');
        $this->db->from('comentarios_bdo cbdo');
        $this->db->join('bdo bdo', 'bdo.numero = cbdo.numero AND bdo.id_aerolinea = cbdo.id_aerolinea');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->num_rows();        
    }
}
