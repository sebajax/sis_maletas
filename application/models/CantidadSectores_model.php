<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of CantidadSectores_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class CantidadSectores_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }  
    
    public function update($data) {
        $cantidad_anterior = $this->cantidadActual();
        $cantidad_nueva = $data['cantidad'];
        if($cantidad_anterior == $cantidad_nueva) {
            return true;
        }
        $cantidad_sectores_logs = array(
            "cantidad_anterior" => $cantidad_anterior,
            "cantidad_nueva" => $cantidad_nueva,
            "usuario" => $this->session->userdata('usuario'),
        );
        $this->db->trans_start();
        $this->db->set('cantidad', $cantidad_nueva);
        $this->db->update("cantidad_sectores");
        $this->db->insert("cantidad_sectores_log", $cantidad_sectores_logs);
        $this->db->trans_complete();
    } 
    
    public function cantidadActual() {
        $this->db->select('cantidad');
        $this->db->from('cantidad_sectores');
        $query = $this->db->get();        
        return $query->row()->cantidad;        
    }
    
}
