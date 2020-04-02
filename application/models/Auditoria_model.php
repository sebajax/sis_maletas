<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Auditoria_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class Auditoria_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }  
    
    public function insert($data, $accion_ejecutada, $tabla, $query) {
        $data_audit = array (
            "usuario" => $this->session->usuario,
            "tabla"   => $tabla,
            "accion_ejecutada" => $accion_ejecutada,
            "data" => json_encode($data),
            "query" => strval($query)
        );
        $this->db->insert("auditoria", $data_audit);
    }
    
    public function transaccionesAuditoria($accion, $tabla, $fecha_desde, $fecha_hasta) {
        $where = array();
        
        if(empty($fecha_desde) || empty($fecha_hasta)) return false;
        
        if(!empty($accion)) {
            $where['accion_ejecutada'] = $accion;
        }

        if(!empty($tabla)) {
            $where['tabla'] = $tabla;
        }        
        
        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $where['fecha_auditoria >='] = $fecha_desde;
            $where['fecha_auditoria <='] = $fecha_hasta;
        }
        $this->db->select('*');
        $this->db->from('auditoria');
        $this->db->where($where);
        $this->db->order_by('fecha_auditoria', 'DESC');
        $query = $this->db->get(); 
        return $query->result();        
    }
}
