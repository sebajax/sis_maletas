<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of TransaccionesBdo_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class TransaccionesBdo_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function TransaccionesBdo($id_aerolinea, $fecha_desde, $fecha_hasta) {
        $where = array();
        if(empty($id_aerolinea) || empty($fecha_desde) || empty($fecha_hasta)) return false;
        
        if(!empty($id_aerolinea)) {
            $where['transacciones_bdo_cerradas.id_aerolinea'] = $id_aerolinea;
        }
        if(!empty($fecha_desde) && !empty($fecha_hasta)) {
            $where['transacciones_bdo_cerradas.fecha_llegada >='] = $fecha_desde;
            $where['transacciones_bdo_cerradas.fecha_llegada <='] = $fecha_hasta;
        }
        $this->db->select('*');
        $this->db->from('transacciones_bdo_cerradas');
        $this->db->join('aerolineas', 'aerolineas.id_aerolinea = transacciones_bdo_cerradas.id_aerolinea');
        $this->db->where($where);
        $query = $this->db->get(); 
        return $query->result();
    }
}
