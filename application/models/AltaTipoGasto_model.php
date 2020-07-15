<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaTipoGasto_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaTipoGasto_model extends CI_Model {

    private $table = 'tipos_gasto';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }  
    
    public function insert($data) {
        $this->db->insert($this->table, $data);
    }    
    
    public function getTipoGasto() {
        $tipos_gasto = array();
        $tipos_gasto[0] = '-TIPO DE GASTO-';
        $query = $this->db->get($this->table);
        foreach($query->result() as $row) {
            $tipos_gasto[$row->id_tipo_gasto] = $row->tipo_gasto;
        }
        return $tipos_gasto;
    }
    
}
