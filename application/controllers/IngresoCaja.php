<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of IngresoCaja
 *
 * @author sebastian.ituarte@gmail.com
 */
class IngresoCaja extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('IngresoCaja_model', 'Auditoria_model', 'ModuloCaja_model'));
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
    
    public function montoInicial() {
        $flujo_total = $this->ModuloCaja_model->montoInicial();
        if($flujo_total > 0) {
            return '<div class="w-auto bg-success card-header rounded"><h4 class="mb-0 text-white text-center">TOTAL ACTUAL EN CAJA $'.number_format($flujo_total).' CLP</h4></div>';
        }else {
            return '<div class="w-auto bg-danger card-header rounded"><h4 class="mb-0 text-white text-center">TOTAL ACTUAL EN CAJA $'.number_format($flujo_total).' CLP</h4></div>';
        }           
    }
    
    public function ingresoCaja() {
        //cargo el post en variables
        $data = array(
            "tipo_ingreso"  => $this->input->post('tipo_ingreso'),
            "fecha"         => $this->input->post('fecha'),
            "comentario"    => $this->input->post('comentario'),
            "monto"         => $this->input->post('monto'),
            "usuario"       => $this->session->userdata('usuario')
        );
        
        $errorEmpty = false;
        $errorDate  = false;
        
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        if($this->validation->validateDate($data['fecha'])) { $errorDate = true; }
        
        if(!$errorEmpty && !$errorDate) {
            $this->IngresoCaja_model->insert($data);
            $this->Auditoria_model->insert($data, "insert", "transacciones_bdo_cerradas", $this->db->last_query());
            echo $this->montoInicial();    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
}
