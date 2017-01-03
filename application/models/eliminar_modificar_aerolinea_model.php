<?php
/**
 * Description of eliminar_modificar_aerolinea_model
 *
 * @author Sebas
 */
class eliminar_modificar_aerolinea_model extends CI_Model {
    
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
}
