<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarTipoGasto
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarTipoGasto extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('EliminarModificarTipoGasto_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms', 'session', 'funciones'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['loadTipoGastos'] = $this->loadTipoGastos();
        $this->load->view('EliminarModificarTipoGasto_view', $data);
    }  
    
    public function modificarTipoGastoForm() {
        $id_tipo_gasto     = $this->input->post('id_tipo_gasto');
        $tipo_gasto        = $this->EliminarModificarTipoGasto_model->cargoTipoGasto($id_tipo_gasto);
        $aux_id_tipo_gasto = "'".$id_tipo_gasto."'";
        
        $html = '
            <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="id_gasto_new" class="control-label">ID - Tipo Gasto</label>
                    <input id="id_gasto_new" disabled= "disabled" name="id_gasto_new" placeholder="id gasto" type="text" class="form-control" value="'.$id_tipo_gasto.'" />
                </div>

                <div class="form-group">
                    <label for="tipo_gasto_new" class="control-label">Tipo Gasto</label>
                    <input id="tipo_gasto_new" name="tipo_gasto_new" placeholder="tipo gasto" type="text" class="form-control" value="'.$tipo_gasto->tipo_gasto.'"/>
                </div> 
            </form>
            </div>
            <div class="modal-footer">
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar" onclick="modificarTipoGasto('.$aux_id_tipo_gasto.');" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>';
        
        echo $html;
    }
    
    public function modificarTipoGasto() {      
        //cargo el post en variables
        $data = array(
            "id_tipo_gasto" => $this->input->post('id_tipo_gasto'),
            "tipo_gasto"    => strtoupper($this->input->post('tipo_gasto_new')),
        );
       
        $errorEmpty  = false;
        
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if(!$errorEmpty) {
            $this->EliminarModificarTipoGasto_model->modificarTipoGasto($data);
            $this->Auditoria_model->insert($data, "update", "tipos_gasto", $this->db->last_query());
            echo "OK";
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function eliminarTipoGasto() {
        $id_tipo_gasto = $this->input->post('id_tipo_gasto');
        
        $error = array(
            'estado'  => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($id_tipo_gasto)) {
            $error['mensaje'] = "ERROR no puede contener elementos vacios al eliminar.";
            echo json_encode($error);
            return false;
        }

        if($this->EliminarModificarTipoGasto_model->chequeoDataPK($id_tipo_gasto) > 0) {
            $error['mensaje'] = "ERROR no se puede eliminar un tipo de gasto que esta siendo usado verifique";
            echo json_encode($error);
            return false;
        }        
        
        $this->EliminarModificarTipoGasto_model->eliminarTipoGasto($id_tipo_gasto);
        $this->Auditoria_model->insert(array("id_tipo_gasto" => $id_tipo_gasto), "delete", "tipos_gasto", $this->db->last_query());
        $error['mensaje'] = "CORRECTO tipo gasto eliminado correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;            
    } 

    public function loadTipoGastos() {
        $result = $this->funciones->objectToArray($this->EliminarModificarTipoGasto_model->loadTipoGastos());
        $tbody = "";
        foreach ($result as $key => $row) {
            $aux_id_tipo_gasto = '"'.$row['id_tipo_gasto'].'"';
            $tbody .= "
                <tr>
                  <td>".$row['tipo_gasto']."</div></td>
                  <td>
                    <div class='d-flex justify-content-center'>
                        <button type='button' class='btn btn-default btn-md'>
                            <i aria-hidden='true' class='fas fa-save fa-lg' onclick='modificarTipoGastoForm(".$aux_id_tipo_gasto.")'></i>
                        </button>
                    </div>
                  </td>
                  <td>
                    <div class='d-flex justify-content-center'>
                        <button type='button' class='btn btn-default btn-md'>
                            <i aria-hidden='true' class='fas fa-trash-alt fa-lg' onclick='cofirmaEliminar(".$aux_id_tipo_gasto.")'></i>
                        </button>
                    </div>
                  </td>                    
                </tr>";
        }
        return $tbody;
    }
}