<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of TransaccionesGasto_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class TransaccionesGasto_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function TransaccionesGasto($id_tipo_gasto, $fecha_desde, $fecha_hasta) {
        $where = array();
        if(empty($fecha_desde) || empty($fecha_hasta)) return false;
        
        if(!empty($id_tipo_gasto)) {
            $where['gastos.id_tipo_gasto'] = $id_tipo_gasto;
        }
        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $where['gastos.fecha >='] = $fecha_desde;
            $where['gastos.fecha <='] = $fecha_hasta;
        }
        $this->db->select('*');
        $this->db->from('gastos');
        $this->db->join('tipos_gasto', 'tipos_gasto.id_tipo_gasto = gastos.id_tipo_gasto');
        $this->db->where($where);
        $this->db->order_by('tipo_gasto', 'ASC');
        $query = $this->db->get(); 
        return $query->result();
    }
}
