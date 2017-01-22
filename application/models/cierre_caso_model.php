<?php
/**
 * Description of cierre_caso_model
 *
 * @author Sebas
 */
class cierre_caso_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buscarCierreCaso($numero, $id_aerolinea) {
        $where = array();
        $where['bdo.estado'] = 0;
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
        $query = $this->db->get();   
        return $query->result();
    }
    
    public function cerrarCaso($data) {
        $result = $this->casoCerrado($data['numero'], $data['id_aerolinea']);
        if($result == 1) {
            $this->db->trans_start();
            $this->db->set('estado', 1);
            $this->db->set('fecha_modif_estado', date("Y-m-d H:i:s"));
            $this->db->where(array('numero' => $data['numero'], 'id_aerolinea' => $data['id_aerolinea'], 'estado' => 0));
            $this->db->update('bdo');
            $this->db->insert("cierre_caso", $data);
            $this->db->insert("comentarios_bdo", $data);
            $this->db->trans_complete();
        }
    }
    
    private function casoCerrado($numero, $id_aerolinea) {
        $where = array();
        $where['bdo.estado'] = 0;
        $where['bdo.numero'] = $numero;
        $where['bdo.id_aerolinea'] = $id_aerolinea;
        $this->db->select('*');
        $this->db->from('bdo');
        $this->db->where($where);
        $query = $this->db->get();   
        return $query->num_rows();
    }
}
