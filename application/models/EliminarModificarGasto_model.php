<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarGasto_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarGasto_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarGasto($tipo_gasto, $fecha_desde, $fecha_hasta) {
        $where = array();
        
        if(!empty($tipo_gasto)) {
            $where['gastos.id_tipo_gasto'] = $tipo_gasto;
        }

        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $where['gastos.fecha >='] = $fecha_desde;
            $where['gastos.fecha <='] = $fecha_hasta;
        }
        
        $this->db->select('*');
        $this->db->from('gastos');
        $this->db->join('tipos_gasto', 'gastos.id_tipo_gasto = tipos_gasto.id_tipo_gasto');
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('gastos.fecha', 'DESC');
        $query = $this->db->get();   
        return $query->result();
    }
    
    public function infoGasto($id_gasto) {
        $this->db->select('*');
        $this->db->from('gastos');  
        $this->db->where(array('id_gasto' => $id_gasto));
        $query = $this->db->get();
        return $query->row();
    }
    
    public function eliminarGasto($id_gasto) {
        $data = array(
            'id_gasto' => $id_gasto
        );
        $this->db->delete('gastos', $data);
    }  
    
    public function modificarGasto($data) {
        $where = array(
            'id_gasto' => $data['id_gasto']
        );
       
        $data_update = array(
            "id_tipo_gasto" => $data["id_tipo_gasto"],
            "fecha"         => $data["fecha"],
            "comentario"    => $data["comentario"],
            "monto"         => $data["monto"]
        );
        
        $this->db->where($where);
        $this->db->update('gastos', $data_update);
    }    
}
