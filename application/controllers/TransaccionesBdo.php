<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of TransaccionesBdo
 *
 * @author sebastian.ituarte@gmail.com
 */
class TransaccionesBdo extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('TransaccionesBdo_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones', 'perms'));
        $this->load->helper(array('aerolineas_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $this->load->view('TransaccionesBdo_view', $data);
    }  
    
    public function buscarTransacciones() {
        $id_aerolinea    = $this->input->post('aerolinea');
        $fecha_desde     = $this->input->post('fecha_desde');
        $fecha_hasta     = $this->input->post('fecha_hasta');
        $result = $this->TransaccionesBdo_model->TransaccionesBdo($id_aerolinea, $fecha_desde, $fecha_hasta);
        $this->session->set_userdata('result_transaccionesBdo', $this->funciones->objectToArray($result));
        echo json_encode($this->armoConsulta($this->session->userdata('result_transaccionesBdo')));
    }  
    
    public function exportarExcel() {
        $title = "transacciones_bdo";    
        $header = array();
        $header[] = "NUMERO BDO";
        $header[] = "AEROLINEA";
        $header[] = "PASAJERO";
        $header[] = "FECHA";
        $header[] = "DIRECCION";
        $header[] = "SECTOR";
        $header[] = "COMUNA";
        $header[] = "VALOR";
        $body = array();
        if($this->session->has_userdata('result_transaccionesBdo')) {
            $i = 0;
            foreach ($this->session->userdata('result_transaccionesBdo') as $row) {
                $body[$i][0] = $row['numero_bdo'];
                $body[$i][1] = $row['nombre_aerolinea'];
                $body[$i][2] = $row['nombre_pasajero'];
                $body[$i][3] = $row['fecha_llegada'];
                $body[$i][4] = $row['domicilio_direccion'];
                $body[$i][5] = $row['grupo_sector'];
                $body[$i][6] = $row['lugar'];
                $body[$i][7] = $row['valor'];
                $i++;
            }
        }
        $this->excel->crearExcel($header, $body, $title);
    }

    public function armoConsulta($result) {
        $tbody = "";
        $valor_total = 0;
        foreach ($result as $row) {
            $tbody .= "
                <tr>
                    <td><div class='font-weight-bold'>".$row['numero_bdo']."</div></td>
                    <td>".$row['nombre_aerolinea']."</td>
                    <td>".$row['nombre_pasajero']."</td>
                    <td><div class='float-right'>".$row['fecha_llegada']."</div></td>    
                    <td>".$row['domicilio_direccion']."</td>
                    <td><div class='float-right'>".$row['grupo_sector']."</div></td>
                    <td>".$row['lugar']."</td>
                    <td><div class='float-right font-weight-bold'>$".number_format($row['valor'])." CLP</div></td>
                </tr>";
            $valor_total += $row['valor'];
        }
        $tbody .= '<tr class="table-primary font-weight-bold" style="text-align: right; border-top: 1px solid #ddd;"><td colspan="8">TOTAL: $'.number_format($valor_total).' CLP</td></tr>';
        return array('tbody' => $tbody, 'valor_total' => $valor_total);
    }
}