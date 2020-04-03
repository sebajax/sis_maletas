<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of TransaccionesGasto
 *
 * @author sebastian.ituarte@gmail.com
 */
class TransaccionesGasto extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('TransaccionesGasto_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones', 'perms'));
        $this->load->helper(array('tipo_gasto_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['tipo_gasto'] = cargoTipoGasto();
        $this->load->view('TransaccionesGasto_view', $data);
    }  
    
    public function buscarTransacciones() {
        $id_tipo_gasto   = $this->input->post('tipo_gasto');
        $fecha_desde     = $this->input->post('fecha_desde');
        $fecha_hasta     = $this->input->post('fecha_hasta');
        $result = $this->TransaccionesGasto_model->TransaccionesGasto($id_tipo_gasto, $fecha_desde, $fecha_hasta);
        if(!empty($result)) {
            $this->session->set_userdata('result_transaccionesGasto', $this->funciones->objectToArray($result));
            echo json_encode($this->armoConsulta($this->session->userdata('result_transaccionesGasto')));
        }else {
            echo json_encode($this->armoConsulta());
        }
    }  
    
    public function exportarExcel() {
        $title = "transacciones_gasto";    
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

    public function armoConsulta($result = "") {
        $tbody = "";
        $monto_total = 0;
        if(!empty($result)) {
            foreach ($result as $row) {
                $tbody .= "
                    <tr>
                        <td>".$row['tipo_gasto']."</td>
                        <td><div class='float-right'>".$row['fecha']."</div></td>
                        <td>".$row['comentario']."</td>
                        <td><div class='float-right font-weight-bold'>$".number_format($row['monto'])." CLP</div></td>    
                    </tr>";
                $monto_total += $row['monto'];
            }
        }
        $tbody .= '<tr class="table-danger font-weight-bold" style="text-align: right; border-top: 1px solid #ddd;"><td colspan="4">TOTAL GASTOS: $'.number_format($monto_total).' CLP</td></tr>';
        return array('tbody' => $tbody, 'monto_total' => $monto_total);
    }
}