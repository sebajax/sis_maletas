<?php
/**
 * Description of eliminar_modificar_aerolinea
 *
 * @author Sebas
 */
class eliminar_modificar_aerolinea extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('eliminar_modificar_aerolinea_model', 'alta_valores_model'));
        $this->load->library('validation');
        $this->load->helper(array('aerolineas_helper'));
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $this->load->view('eliminar_modificar_aerolinea_view', $data);
    }  

    public function buscarAerolinea() {
        $aerolinea = $this->input->post('aerolinea');
        $result = $this->eliminar_modificar_aerolinea_model->buscarAerolinea($aerolinea);
        $tbody = '';
        foreach ($result as $key => $row) {
            $tbody .= "
                <tr>
                    <th scope='row'>".($key + 1)."</th>
                    <td>".$row->id_aerolinea."</td>
                    <td>".$row->nombre_aerolinea."</td>
                    <td>
                        <button type='button' class='btn btn-default btn-md'>
                            <span class='glyphicon glyphicon-pencil' aria-hidden='true' onclick='modificarAerolineaForm(".$row->id_aerolinea.")'></span>
                        </button>   
                    </td>
                    <td>
                        <button type='button' class='btn btn-default btn-md'>
                            <span class='glyphicon glyphicon-trash' aria-hidden='true' onclick='eliminarAerolinea(".$row->id_aerolinea.")'></span>
                        </button>   
                    </td>                    
                </tr>";
        }
        echo $tbody;
    }  
    
    public function modificarAerolineaForm() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $nombre_aerolinea = $this->eliminar_modificar_aerolinea_model->obtengoNombreAerolinea($id_aerolinea);
        $html = '
            <form>
                <div class="form-group">
                    <label for="aerolinea_modificada">Aerolinea</label>
                    <input type="text" class="form-control" id="aerolinea_modificada" placeholder="nombre aerolinea" value="'.$nombre_aerolinea.'">
                </div>
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar aerolinea" onclick="modificarAerolinea('.$id_aerolinea.');" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" onclick="cancelarModificarAerolinea();"/>
            </form>';
        
        echo $html;
    }
    
    public function modificarAerolinea() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $nombre_aerolinea = $this->input->post('nombre_aerolinea_new');
        if(!empty($id_aerolinea) && !empty($nombre_aerolinea)) {
            $this->eliminar_modificar_aerolinea_model->modificarAerolinea($id_aerolinea, $nombre_aerolinea);
            echo "OK";
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function eliminarAerolinea() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        
        $error = array(
            'estado' => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($id_aerolinea)) {
            $error['mensaje'] = "ERROR la aerolinea no puede ser vacia.";
            echo json_encode($error);
            return false;
        }
        
        if($this->eliminar_modificar_aerolinea_model->verificarAerolineaBdo($id_aerolinea)) {
            $error['mensaje'] = "ERROR la aerolinea esta siendo usada en alguna bdo.";
            echo json_encode($error);
            return false;           
        }
        
        $this->eliminar_modificar_aerolinea_model->eliminarAerolinea($id_aerolinea);
        $error['mensaje'] = "CORRECTO aerolinea eliminada correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;
    }
}