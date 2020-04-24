<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of IngresoCaja
 *
 * @author sebastian.ituarte@gmail.com
 */
class IngresoCaja extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('IngresoCaja_model', 'Auditoria_model', 'AltaBdo_model', 'CierreCaso_model', 'ModuloCaja_model', 'EliminarModificarSector_model'));
        $this->load->library(array('validation', 'perms', 'session'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array(
            "saldo_inicial" => $this->montoInicial()
        );
        $this->load->view('IngresoCaja_view', $data);
    }
    
    private function montoInicial() {
        $flujo_total = $this->ModuloCaja_model->montoInicial();
        if($flujo_total > 0) {
            return '<div class="w-auto bg-success card-header rounded"><h4 class="mb-0 text-white text-center">TOTAL ACTUAL EN CAJA $'.number_format($flujo_total).' CLP</h4></div>';
        }else {
            return '<div class="w-auto bg-danger card-header rounded"><h4 class="mb-0 text-white text-center">TOTAL ACTUAL EN CAJA $'.number_format($flujo_total).' CLP</h4></div>';
        }           
    }
    
    public function ingresoCaja() {
        $id_aerolinea = 99;
        $numero_bdo   = $this->IngresoCaja_model->nextBdoNumber($id_aerolinea);
        //Alta BDO
        $data = array(
            "numero"               => $numero_bdo,
            "id_aerolinea"         => $id_aerolinea,
            "fecha_llegada"        => $this->input->post('fecha'),
            "nombre_pasajero"      => $this->input->post('tipo_ingreso'),
            "cantidad_maletas"     => 1,
            "domicilio_region"     => 1,
            "domicilio_direccion"  => $this->input->post('comentario'),
            "telefono"             => 1,
            "id_sector"            => $this->IngresoCaja_model->firstIdSector(),
            "valor"                => $this->input->post('monto'),
            "usuario"              => $this->session->userdata('usuario')
        );
 
        $errorPk    = false;
        $errorEmpty = false;
        $errorDate  = false;

        if(!$this->validatePK($data)) { $errorPk = true; }
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        if($this->validation->validateDate($data['fecha_llegada'])) { $errorDate = true; }

        if($errorPk) { echo "PK"; return false; }

        if(!$errorEmpty && !$errorDate) {
            $this->AltaBdo_model->insert($data);
            $this->Auditoria_model->insert($data, "insert", "bdo", $this->db->last_query());
            $data = array(
                "numero"       => $numero_bdo,
                "id_aerolinea" => $id_aerolinea,
                "comentario"   => $this->input->post('comentario'),
                "usuario"      => $this->session->userdata('usuario')
            );
            $this->CierreCaso_model->cerrarCaso($data);
            $this->Auditoria_model->insert($data, "insert", "cierre_caso", $this->db->last_query());
            echo $this->montoInicial();  
            return true;
        }else {
            echo "ERROR";
            return false;
        }            
    }
    
    private function validatePK($pk) {
        if($this->AltaBdo_model->validatePK($pk) > 0) { return false; } else { return true; }
    }    
}
