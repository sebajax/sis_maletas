<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Auditoria
 *
 * @author sebastian.ituarte@gmail.com
 */
class Auditoria extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('Auditoria_model'));
        $this->load->library(array('validation', 'session', 'funciones', 'perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('Auditoria_view');
    }  
    
    public function buscarAuditorias() {
        $accion       = $this->input->post('accion');
        $tabla        = $this->input->post('tabla');
        $fecha_desde  = $this->input->post('fecha_desde');
        $fecha_hasta  = $this->input->post('fecha_hasta');
        $result = $this->Auditoria_model->transaccionesAuditoria($accion, $tabla, $fecha_desde, $fecha_hasta);
        if(!empty($result)) {
            echo json_encode($this->armoConsulta($result));
        }else {
            echo json_encode($this->armoConsulta());
        }
    }  
    
    public function armoConsulta($result = "") {
        $tbody = "
            <table class='table table-bordered table-hover w-100'>
                <thead class='thead-dark'>
                    <tr>
                        <th scope='col'>Fecha Auditoria</th>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Tabla</th>
                        <th scope='col'>Accion</th>
                        <th scope='col'>Data ingresada</th>
                    </tr>
                </thead>
        ";          
        $tbody .= "<tbody>";
        if(!empty($result)) {
            foreach ($result as $row) {
                $tbody .= "
                    <tr>
                        <td><div class='font-weight-bold'>".$row->fecha_auditoria."</div></td>
                        <td>".$row->usuario."</td>
                        <td>".$row->tabla."</td>
                        <td>".$row->accion_ejecutada."</td>  
                        <td>".wordwrap($row->data, 75, "<br />", true)."</td>  
                    </tr>";
            }
        }
        $tbody .= '</tbody></table>';
        return $tbody;
    }
}