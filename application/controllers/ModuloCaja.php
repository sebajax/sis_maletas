<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of ModuloCaja
 *
 * @author sebastian.ituarte@gmail.com
 */
class ModuloCaja extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('ModuloCaja_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones', 'perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('ModuloCaja_view');
    }  
    
    public function buscarTransacciones() {
        $fecha_desde     = $this->input->post('fecha_desde');
        $fecha_hasta     = $this->input->post('fecha_hasta');
        
        $result_ingresos = $this->ModuloCaja_model->IngresosCaja($fecha_desde, $fecha_hasta);
        if(!empty($result_ingresos)) $this->session->set_userdata('result_ingresosCaja', $this->funciones->objectToArray($result_ingresos));
        
        $result_salidas = $this->ModuloCaja_model->SalidasCaja($fecha_desde, $fecha_hasta);
        if (!empty($result_salidas)) $this->session->set_userdata('result_salidasCaja', $this->funciones->objectToArray($result_salidas));
        
        echo json_encode($this->armoConsulta($this->session->userdata('result_ingresosCaja'), $this->session->userdata('result_salidasCaja')));
    }  
    
    /*
     * TO DO
     */
    public function exportarExcel() {
        $title = "transacciones_bdo";    
        $header = array();
        $header[] = "ID GASTO";
        $header[] = "TIPO GASTO";
        $header[] = "FECHA";
        $header[] = "COMENTARIO";
        $header[] = "MONTO";
        $body = array();
        if($this->session->has_userdata('result_transaccionesGasto')) {
            $i = 0;
            foreach ($this->session->userdata('result_transaccionesGasto') as $row) {
                $body[$i][0] = $row['id_gasto'];
                $body[$i][1] = $row['tipo_gasto'];
                $body[$i][2] = $row['fecha'];
                $body[$i][3] = $row['comentario'];
                $body[$i][4] = $row['monto'];
                $i++;
            }
        }
        $this->excel->crearExcel($header, $body, $title);
    }

    public function armoConsulta($result_ingresosCaja, $result_salidasCaja) {
        $monto_ingreso = 0;
        $monto_egreso  = 0;
        
        $content = '<div class="well"><h4 class="text-success">INGRESOS</h4>';
        
        $content .= '
            <table class="table table-hover" id="ingresos">
              <thead>
                <tr>
                    <th>Aerolinea</th>
                    <th>Monto</th>
                </tr>
              </thead>
              <tbody id="cuerpo_ingresos">';
        
        foreach ($result_ingresosCaja as $row) {
            $content .= "
                <tr>
                    <th scope='row'>".$row['aerolinea']."</th>
                    <td>".$row['monto']."</td>
                </tr>";
            $monto_ingreso += $row['monto'];
        }
        $content .= '<tr class="success" style="text-align: right; border-top: 1px solid #ddd;"><td colspan="2">TOTAL - '.$monto_ingreso.' CLP</td></tr>';
        $content .= '</tbody></table></div>';

        $content .= '<div class="well"><h4 class="text-danger">EGRESOS</h4>';

        $content .= '
            <table class="table table-hover" id="egresos">
              <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                </tr>
              </thead>
              <tbody id="cuerpo_ingresos">';        
        
        foreach ($result_salidasCaja as $row) {
            $content .= "
                <tr>
                    <th scope='row'>".$row['fecha']."</th>
                    <td>".$row['tipo_gasto']."</td>
                    <td>".$row['monto']."</td>
                </tr>";
            $monto_egreso += $row['monto'];
        }
        $content .= '<tr class="danger" style="text-align: right; border-top: 1px solid #ddd;"><td colspan="3">TOTAL - '.$monto_egreso.' CLP</td></tr>';
        $content .= '</tbody></table></div>';
        
        $flujo_total = $monto_ingreso - $monto_egreso;
        
        if($flujo_total > 0) {
            $content .= '<div class="well" style="background-color: #BCF5A9; float: right !important;"><h3 class="text-success">GANANCIA    '.$flujo_total.'</h3>';
        }else {
            $content .= '<div class="well" style="background-color: #F5A9A9; float: right !important;"><h3 class="text-danger">PERDIDA    '.$flujo_total.'</h3>';
        }
        return array('content' => $content);
    }
}