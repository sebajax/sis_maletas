<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarTipoGasto_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarTipoGasto_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function loadTipoGastos() {
        $this->db->select('*');
        $this->db->from('tipos_gasto');
        $this->db->order_by('tipo_gasto', 'ASC');
        $query = $this->db->get();   
        return $query->result();
    }
    
    public function eliminarTipoGasto($id_tipo_gasto) {
        $data = array(
            'id_tipo_gasto' => $id_tipo_gasto
        );
        $this->db->delete('tipos_gasto', $data);
    }  
    
    public function modificarTipoGasto($data) {
        $where = array(
            'id_tipo_gasto' => $data['id_tipo_gasto']
        );
       
        $data_update = array(
            "tipo_gasto" => $data["tipo_gasto"]
        );
        
        $this->db->where($where);
        $this->db->update('tipos_gasto', $data_update);
    }  
    
    public function cargoTipoGasto($id_tipo_gasto) {
        $this->db->select('*');
        $this->db->from('tipos_gasto');  
        $this->db->where(array('id_tipo_gasto' => $id_tipo_gasto));
        $query = $this->db->get();
        return $query->row();        
    }
    
    public function chequeoDataPK($id_tipo_gasto) {
        $this->db->from('gastos');
        $this->db->where(array('id_tipo_gasto' => $id_tipo_gasto));
        return $this->db->count_all_results();
    }
}
