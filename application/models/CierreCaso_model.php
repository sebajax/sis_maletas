<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of CierreCaso_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class CierreCaso_model extends CI_Model {

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
            $informacionBdo = $this->informacionBDO($data['numero'], $data['id_aerolinea']);
            $sector = $this->EliminarModificarSector_model->obtengoInformacionSector($informacionBdo->id_sector);
            $data_ingreso_caja = array(
                'numero' => $data['numero'],
                'id_aerolinea' => $data['id_aerolinea'],
                'monto' => $informacionBdo->valor,
            );
            $data_trans = array(
                'numero_bdo' => $data['numero'],
                'id_aerolinea' => $data['id_aerolinea'],
                'nombre_pasajero' => $informacionBdo->nombre_pasajero,
                'fecha_llegada' => $informacionBdo->fecha_llegada,
                'domicilio_direccion' => $informacionBdo->domicilio_direccion,
                'grupo_sector' => $sector->grupo_sector,
                'lugar' => $sector->lugar,
                'valor' => $informacionBdo->valor,
            );
            $this->db->insert("ingresos_caja", $data_ingreso_caja);
            $this->db->insert("transacciones_bdo_cerradas", $data_trans);
            $this->db->insert("comentarios_bdo", $data);
            $this->db->insert("cierre_caso", $data);
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
    
    private function montoTransaccion($numero, $id_aerolinea) {
        $where = array();
        $where['bdo.numero'] = $numero;
        $where['bdo.id_aerolinea'] = $id_aerolinea;
        $this->db->select('bdo.valor');
        $this->db->from('bdo');
        $this->db->where($where);
        $query = $this->db->get();   
        $row = $query->row();
        return $row->valor;      
    }
    
    private function informacionBDO($numero, $id_aerolinea) {
        $where = array();
        $where['bdo.numero'] = $numero;
        $where['bdo.id_aerolinea'] = $id_aerolinea;
        $this->db->select('bdo.*');
        $this->db->from('bdo');
        $this->db->where($where);
        $query = $this->db->get();   
        return $query->row();
    }
}
