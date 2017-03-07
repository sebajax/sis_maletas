<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarAerolinea_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarAerolinea_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarAerolinea($aerolinea) {
        $where = array();

        if(!empty($aerolinea)) {
            $where['id_aerolinea'] = $aerolinea;
        }
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('aerolineas');
        $query = $this->db->get();   
        return $query->result();
    }
    
    public function verificarAerolineaBdo($id_aerolinea) {
        $where = array(
            "aerolineas.id_aerolinea" => $id_aerolinea
        );
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('aerolineas');
        $this->db->join('bdo', 'aerolineas.id_aerolinea = bdo.id_aerolinea');
        $query = $this->db->get(); 
        if($query->num_rows() > 0) {
            return true;
        }else { 
            return false;
        }
    }
    
    public function eliminarAerolinea($id_aerolinea) {
        $this->db->delete('aerolineas', array('id_aerolinea' => $id_aerolinea));
    }
    
    public function obtengoNombreAerolinea($id_aerolinea) {
       $where = array(
            "id_aerolinea" => $id_aerolinea
        );
        $this->db->select('nombre_aerolinea');
        $this->db->where($where);
        $this->db->from('aerolineas');
        $query = $this->db->get(); 
        $row = $query->row();
        if(isset($row)) {
            return $row->nombre_aerolinea;
        }else {
            return "";
        }
    }
    
    public function modificarAerolinea($id_aerolinea, $nombre_aerolinea) {
        $data = array(
            'nombre_aerolinea' => $nombre_aerolinea
        );
        $where = array(
            'id_aerolinea' => $id_aerolinea
        );
        $this->db->where($where);
        $this->db->update('aerolineas', $data);
    }
}
