<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaGasto
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaGasto extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('AltaGasto_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms', 'session'));
        $this->load->helper(array('tipo_gasto_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['tipo_gasto'] = cargoTipoGasto();
        $this->load->view('AltaGasto_view', $data);
    }
    
    public function altaGasto() {
        //cargo el post en variables
        $data = array(
            "id_tipo_gasto" => $this->input->post('tipo_gasto'),
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
            $this->AltaGasto_model->insert($data);
            $this->Auditoria_model->insert($data, "insert", "gastos", $this->db->last_query());
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
}
