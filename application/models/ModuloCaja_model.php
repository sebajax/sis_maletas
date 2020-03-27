<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of ModuloCaja_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class ModuloCaja_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function IngresosCaja($fecha_desde, $fecha_hasta) {
        if(empty($fecha_desde) || empty($fecha_hasta)) return false;
        $this->db->select('aerolineas.nombre_aerolinea AS aerolinea, SUM(transacciones_bdo_cerradas.valor) AS monto');
        $this->db->from('transacciones_bdo_cerradas');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = transacciones_bdo_cerradas.id_aerolinea');
        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $this->db->where('transacciones_bdo_cerradas.fecha_transaccion >=', $fecha_desde);
            $this->db->where('transacciones_bdo_cerradas.fecha_transaccion <=', $fecha_hasta);
        }
        $this->db->group_by('transacciones_bdo_cerradas.id_aerolinea');
        $query = $this->db->get(); 
        //log_message("error", $this->db->last_query());
        return $query->result();
    }
    
    public function SalidasCaja($fecha_desde, $fecha_hasta) {
        if(empty($fecha_desde) || empty($fecha_hasta)) return false;
        $this->db->select('gastos.fecha, gastos.monto, tipos_gasto.tipo_gasto');
        $this->db->from('gastos');
        $this->db->join('tipos_gasto', 'gastos.id_tipo_gasto = tipos_gasto.id_tipo_gasto');
        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $this->db->where('gastos.fecha >=', $fecha_desde);
            $this->db->where('gastos.fecha <=', $fecha_hasta);
        }
        $query = $this->db->get(); 
        return $query->result();
    }
}
