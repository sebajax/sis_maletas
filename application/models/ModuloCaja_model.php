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
    
    public function montoInicial() {
        //ganancia
        $this->db->select_sum('transacciones_bdo_cerradas.valor');
        $this->db->where('transacciones_bdo_cerradas.fecha_transaccion <=', date('Y/m/d 00:00:00'));
        $query = $this->db->get('transacciones_bdo_cerradas');
        $row = $query->row();
        $total = $row->valor;
        
        //gastos
        $this->db->select_sum('gastos.monto');
        $this->db->where('gastos.fecha <=', date('Y/m/d 00:00:00'));
        $query = $this->db->get('gastos');
        $row = $query->row();
        
        //total
        return $total - $row->monto;
    }
    
    public function IngresosCaja($fecha_desde, $fecha_hasta) {
        if(empty($fecha_desde) || empty($fecha_hasta)) return false;
        $this->db->select('aerolineas.nombre_aerolinea AS aerolinea, transacciones_bdo_cerradas.valor AS monto, transacciones_bdo_cerradas.fecha_llegada AS fecha_llegada, transacciones_bdo_cerradas.fecha_transaccion AS fecha_transaccion');
        $this->db->from('transacciones_bdo_cerradas');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = transacciones_bdo_cerradas.id_aerolinea');
        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $this->db->where('transacciones_bdo_cerradas.fecha_transaccion >=', $fecha_desde);
            $this->db->where('transacciones_bdo_cerradas.fecha_transaccion <=', $fecha_hasta);
        }
        $this->db->order_by('transacciones_bdo_cerradas.fecha_llegada DESC');
        $query = $this->db->get(); 
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
        $this->db->order_by('gastos.fecha DESC');
        $query = $this->db->get(); 
        return $query->result();
    }
}
