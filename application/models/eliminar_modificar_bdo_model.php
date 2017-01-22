<?php
/**
 * Description of eliminar_modificar_bdo_model
 *
 * @author Sebas
 */
class eliminar_modificar_bdo_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarBdo($numero, $id_aerolinea, $nombre_pasajero, $fecha_desde, $fecha_hasta, $grupo_sector) {
        $where = array();
        
        $where['estado'] = 0;
        
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
        $this->db->select('*');
        $this->db->from('bdo');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = bdo.id_aerolinea');
        $this->db->join('sectores', 'sectores.id_sector = bdo.id_sector');
        $this->db->where($where);
        $query = $this->db->get();   
        return $query->result();
    }
    
    public function verificoEstadoBdo($numero, $id_aerolinea) {
        $where = array(
            'numero' => $numero, 
            'id_aerolinea' => $id_aerolinea
        );
        
        $this->db->select('*');
        $this->db->from('bdo');
        $this->db->where($where);
        $query = $this->db->get();   
        return $query->row()->estado;        
    }
    
    public function eliminarBdo($numero, $id_aerolinea) {
        $this->db->delete('bdo', array('numero' => $numero, 'id_aerolinea' => $id_aerolinea));
    }  
    
    public function modificarBdo($data) {
        $where = array(
            'numero' => $data['numero'],
            'id_aerolinea' => $data['id_aerolinea']
        );
       
        $data_update = array(
            "fecha_llegada"        => $data["fecha_llegada"],
            "nombre_pasajero"      => $data["nombre_pasajero"],
            "cantidad_maletas"     => $data["cantidad_maletas"],
            "domicilio_region"     => $data["domicilio_region"],
            "domicilio_comuna"     => $data["domicilio_comuna"],
            "domicilio_direccion"  => $data["domicilio_direccion"],
            "telefono"             => $data["telefono"],
            "id_sector"            => $data["id_sector"],
            "valor"                => $data["valor"]
        );
        
        $this->db->where($where);
        $this->db->update('bdo', $data_update);
    }    
    
    public function agregarComentario($data) {
        $this->db->insert("comentarios_bdo", $data);
    }
}
