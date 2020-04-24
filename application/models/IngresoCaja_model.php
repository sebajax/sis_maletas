<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of IngresoCaja_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class IngresoCaja_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        $id_aerolinea = 99; //Aerolina 99 NO BDO
        $numero_bdo   = 1; //Aerolina 99 NO BDO
        $this->db->trans_start();
        $data_ingreso_caja = array(
            'numero'       => $numero_bdo,
            'id_aerolinea' => $id_aerolinea,
            'monto'        => $data['monto'],
        );
        $data_trans = array(
            'numero_bdo'          => $numero_bdo,
            'id_aerolinea'        => $id_aerolinea,
            'nombre_pasajero'     => $data['tipo_ingreso'],
            'fecha_llegada'       => $data['fecha'],
            'domicilio_direccion' => $data['comentario'],
            'grupo_sector'        => 1,
            'lugar'               => 1,
            'valor'               => $data['monto'],
        );
        $this->db->insert("ingresos_caja", $data_ingreso_caja);
        $this->db->insert("transacciones_bdo_cerradas", $data_trans);
        $this->db->trans_complete();
    }
    
    public function nextBdoNumber($id_aerolinea) {
        $this->db->select_max('numero');
        $where['id_aerolinea'] = $id_aerolinea;
        $this->db->where($where);
        $query = $this->db->get('bdo');
        $row = $query->row();   
        return $row->numero + 1;
    }
    
    public function firstIdSector() {
        $this->db->select_min('id_sector');
        $query = $this->db->get('sectores');
        $row = $query->row(); 
        return $row->id_sector;
    }
}
