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
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $this->load->view('ModuloCaja_view');
    }  
    
    public function montoInicial() {
        $flujo_total = $this->ModuloCaja_model->montoInicial();
        if($flujo_total > 0) {
            echo json_encode('<div class="w-auto bg-success card-header rounded"><h4 class="mb-0 text-white text-center">TOTAL EN CAJA $'.number_format($flujo_total).' CLP</h4></div>');
        }else {
            echo json_encode('<div class="w-auto bg-danger card-header rounded"><h4 class="mb-0 text-white text-center">TOTAL EN CAJA $'.number_format($flujo_total).' CLP</h4></div>');
        }
    }
    
    public function buscarTransacciones() {
        $mes             = $this->input->post('mes');
        $fecha_desde     = $this->input->post('fecha_desde');
        $fecha_hasta     = $this->input->post('fecha_hasta');
        
        if(!empty($mes)) {
            $fecha_desde = date("Y")."/01/01";
            $fecha_hasta = date("Y")."/".$mes."/31";
        }
        
        $fecha_desde = date($fecha_desde." 00:00:00");
        $fecha_hasta = date($fecha_hasta." 00:00:00");
        
        $result_ingresos = $this->ModuloCaja_model->IngresosCaja($fecha_desde, $fecha_hasta);
        $this->session->set_userdata('result_ingresosCaja', $this->funciones->objectToArray($result_ingresos));
        
        $result_salidas = $this->ModuloCaja_model->SalidasCaja($fecha_desde, $fecha_hasta);
        $this->session->set_userdata('result_salidasCaja', $this->funciones->objectToArray($result_salidas));
        
        echo json_encode($this->armoConsulta($this->session->userdata('result_ingresosCaja'), $this->session->userdata('result_salidasCaja')));
    }  
    
    /*
     * TO DO
     */
    public function exportarExcel() {
        $title = "modulo_caja";    
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
        
        $content_add = "";
        foreach ($result_ingresosCaja as $row) {
            $content_add .= "
                <tr>
                    <th scope='row'>".$row['fecha_llegada']."</th>
                    <td>".$row['fecha_transaccion']."</td>
                    <td>".$row['aerolinea']."</td>
                    <td><div class='float-right font-weight-bold'>$".$row['monto']."</div></td>
                </tr>";
            $monto_ingreso += $row['monto'];
        }        
        
        $content = '<div class="accordion my-2 w-100" id="accordionCajaIngreso"><div class="card"><div style="cursor: pointer;" class="bg-primary card-header" data-toggle="collapse" data-target="#collapseIngresos" aria-expanded="true" aria-controls="collapseIngresos">';
        $content .= '<h4 class="mb-0 text-white float-left">INGRESOS</h4><h4 class="mb-0 text-white float-right">TOTAL $'.number_format($monto_ingreso).' CLP</h4></div>';
        
        $content .= '
            <div id="collapseIngresos" class="collapse" aria-labelledby="headingOne" data-parent="#accordionCajaIngreso">
            <div class="card-body">
            <table class="table table-hover table-bordered" id="ingresos">
              <thead class="thead-light">
                <tr>
                    <th>Fecha BDO</th>
                    <th>Fecha Transaccion</th>
                    <th>Aerolinea</th>
                    <th><div class="float-right">Monto</div></th>
                </tr>
              </thead>
              <tbody id="cuerpo_ingresos">';
        
        $content .= $content_add;
        $content .= '</tbody></table></div></div></div></div>';
        
        $content_add = "";
        foreach ($result_salidasCaja as $row) {
            $content_add .= "
                <tr>
                    <th scope='row'>".$row['fecha']."</th>
                    <td>".$row['tipo_gasto']."</td>
                    <td><div class='float-right font-weight-bold'>$".$row['monto']."</div></td>
                </tr>";
            $monto_egreso += $row['monto'];
        }        
        
        $content .= '<div class="form-group my-5"></div>';
        $content .= '<div class="accordion" id="accordionCajaEgreso"><div class="card"><div style="cursor: pointer;" class="bg-primary card-header" data-toggle="collapse" data-target="#collapseEgresos" aria-expanded="true" aria-controls="collapseEgresos">';
        $content .= '<h4 class="mb-0 text-white float-left">EGRESOS</h4><h4 class="mb-0 text-white float-right">TOTAL $'.number_format($monto_egreso).' CLP</h4></div>';
       
        $content .= '
            <div id="collapseEgresos" class="collapse" aria-labelledby="headingOne" data-parent="#accordionCajaEgreso">
            <div class="card-body">            
            <table class="table table-hover table-bordered" id="egresos">
              <thead class="thead-light">
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th><div class="float-right">Monto</div></th>
                </tr>
              </thead>
              <tbody id="cuerpo_ingresos">';        
        
        
        $content .= $content_add;
        $content .= '</tbody></table></div></div></div></div>';
        
        $flujo_total = $monto_ingreso - $monto_egreso;
        
        if($flujo_total > 0) {
            $content .= '<div class="my-5 w-auto bg-success card-header float-right rounded"><h4 class="mb-0 text-white float-right">GANANCIA $'.number_format($flujo_total).' CLP</h4></div>';
        }else {
            $content .= '<div class="my-5 w-auto bg-danger card-header float-right rounded"><h4 class="mb-0 text-white float-right">PERDIDA $'.number_format($flujo_total).' CLP</h4></div>';
        }
        return array('content' => $content);
    }
}