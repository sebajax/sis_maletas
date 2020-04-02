<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarGasto
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarGasto extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('EliminarModificarGasto_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms', 'session', 'funciones'));
        $this->load->helper(array('tipo_gasto_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['tipo_gasto'] = cargoTipoGasto();
        $this->load->view('EliminarModificarGasto_view', $data);
    }  
    
    public function buscarGasto() {
        $this->session->unset_userdata('result_buscarGasto');
        $tipo_gasto  = $this->input->post('tipo_gasto');
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
        $result = $this->EliminarModificarGasto_model->buscarGasto($tipo_gasto, $fecha_desde, $fecha_hasta);
        $this->session->set_userdata('result_buscarGasto', $this->funciones->objectToArray($result));
        echo $this->armoConsulta($this->session->userdata('result_buscarGasto'));
    }  
    
    public function modificarGastoForm() {
        $id_gasto        = $this->input->post('id_gasto');
        $tipo_gasto      = cargoTipoGasto();
        $info_gasto      = $this->EliminarModificarGasto_model->infoGasto($id_gasto);
        $attr_tipo_gasto = 'class="form-control" id="tipo_gasto_new"';
        $aux_id_gasto    = "'".$id_gasto."'";
        
        $html = '
            <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="id_gasto_new" class="control-label">Id Gasto</label>
                    <input id="id_gasto_new" disabled= "disabled" name="id_gasto_new" placeholder="id gasto" type="text" class="form-control" value="'.$id_gasto.'" />
                </div>

                <div class="form-group">
                    <label for="tipo_gasto_new" class="control-label">Tipo Gasto</label>
                    '.form_dropdown('tipo_gasto_new', $tipo_gasto, $info_gasto->id_tipo_gasto, $attr_tipo_gasto).'
                </div>            

                <div class="form-group">
                    <label for="fecha_new" class="control-label">Fecha</label>
                    <input id="fecha_new" name="fecha_new" placeholder="fecha" type="text" class="form-control" value="'.str_replace("-", "/", $info_gasto->fecha).'" />
                </div>

                <div class="form-group">
                    <label for="comentartio_new" class="control-label">Comentario</label>
                    <textarea class="form-control noresize" rows="5" id="comentario_new" placeholder="comentario">'.$info_gasto->comentario.'</textarea>
                </div>            

                <div class="form-group">
                    <label for="monto_new" class="control-label">Monto</label>
                    <input id="monto_new" name="monto_new" placeholder="valor" type="text" class="form-control" value="'.$info_gasto->monto.'"/>
                </div> 
            </form>
            </div>
            <div class="modal-footer">
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar Gasto" onclick="modificarGasto('.$aux_id_gasto.');" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>';
        
        echo $html;
    }
    
    public function modificarGasto() {        
        //cargo el post en variables
        $data = array(
            "id_gasto"      => $this->input->post('id_gasto'),
            "id_tipo_gasto" => $this->input->post('id_tipo_gasto_new'),
            "fecha"         => $this->input->post('fecha_new'),
            "comentario"    => $this->input->post('comentario_new'),
            "monto"         => $this->input->post('monto_new'),
        );
       
        $errorEmpty  = false;
        $errorDate   = false;
        
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        if($this->validation->validateDate($data['fecha'])) { $errorDate = true; }
        
        if(!$errorEmpty && !$errorDate) {
            $this->EliminarModificarGasto_model->modificarGasto($data);
            $this->Auditoria_model->insert($data, "update", "gastos", $this->db->last_query());
            echo "OK";
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function eliminarGasto() {
        $id_gasto = $this->input->post('id_gasto');
        
        $error = array(
            'estado'  => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($id_gasto)) {
            $error['mensaje'] = "ERROR no puede contener elementos vacios al eliminar.";
            echo json_encode($error);
            return false;
        }
        $this->EliminarModificarGasto_model->eliminarGasto($id_gasto);
        $this->Auditoria_model->insert(array("id_gasto" => $id_gasto), "delete", "gastos", $this->db->last_query());
        $error['mensaje'] = "CORRECTO gasto eliminado correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;            
    } 
    
    public function ordenarBuscar() {
        $parametro = $this->input->post('parametro');
        $ordenamiento = $this->input->post('ordenamiento');
        if($this->session->has_userdata('result_buscarGasto')) {
            $result = $this->funciones->array_sort($this->session->userdata('result_buscarGasto'), $parametro, $ordenamiento);
            $this->session->set_userdata('result_buscarGasto', $result);
            echo $this->armoConsulta($result);
        }
    }
    
    public function exportarExcel() {
        $title = "consulta_bdo";    
        $header = array();
        $header[] = "NUMERO BDO";
        $header[] = "AEROLINEA";
        $header[] = "PASAJERO";
        $header[] = "MALETAS";
        $header[] = "VALOR";
        $header[] = "ESTADO";
        $header[] = "FECHA";
        $body = array();
        if($this->session->has_userdata('result_buscarBdo')) {
            $i = 0;
            foreach ($this->session->userdata('result_buscarBdo') as $row) {
                if($row['estado'] == 1) {
                    $estado = "CERRADO";
                }else {
                    $estado = "ABIERTO";
                }                
                $body[$i][0] = $row['numero'];
                $body[$i][1] = $row['nombre_aerolinea'];
                $body[$i][2] = $row['nombre_pasajero'];
                $body[$i][3] = $row['cantidad_maletas'];
                $body[$i][4] = $row['valor'];
                $body[$i][5] = $estado;
                $body[$i][6] = $row['fecha_llegada'];
                $i++;
            }
        }
        $this->excel->crearExcel($header, $body, $title);
    }    
    
    private function armoConsulta($result) {
        $tbody = "";
        $monto_total = 0;
        foreach ($result as $key => $row) {
            $aux_id_gasto = '"'.$row['id_gasto'].'"';
            $tbody .= "
                <tr>
                  <td>".$row['tipo_gasto']."</div></td>
                  <td><div class='float-right'>".$row['fecha']."</div></td>
                  <td>".$row['comentario']."</td>
                  <td><div class='float-right'>$".number_format($row['monto'])."</div></td>                  
                  <td>
                    <div class='d-flex justify-content-center'>
                        <button type='button' class='btn btn-default btn-md'>
                            <i aria-hidden='true' class='fas fa-save fa-lg' onclick='modificarGastoForm(".$aux_id_gasto.")'></i>
                        </button>
                    </div>
                  </td>
                  <td>
                    <div class='d-flex justify-content-center'>
                        <button type='button' class='btn btn-default btn-md'>
                            <i aria-hidden='true' class='fas fa-trash-alt fa-lg' onclick='cofirmaEliminar(".$aux_id_gasto.")'></i>
                        </button>
                    </div>
                  </td>                    
                </tr>";
            $monto_total += $row['monto'];
        }
        $tbody .= '<tr class="table-danger font-weight-bold" style="text-align: right; border-top: 1px solid #ddd;"><td colspan="6">TOTAL GASTOS: $'.number_format($monto_total).' CLP</td></tr>';
        return $tbody;
    }
}