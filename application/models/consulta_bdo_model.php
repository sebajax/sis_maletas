<?php
/**
 * Description of consulta_bdo_model
 *
 * @author Sebas
 */
class consulta_bdo_model extends CI_Model {
    
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
        
        if(!empty($numero)) {
            $where['bdo.numero'] = $numero;
        }
        if(!empty($id_aerolinea)) {
            $where['bdo.id_aerolinea'] = $id_aerolinea;
        }
        
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('bdo');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = bdo.id_aerolinea');
        $this->db->join('sectores', 'sectores.id_sector = bdo.id_sector');
        $query = $this->db->get();   
        return $query->row();
    }
}
