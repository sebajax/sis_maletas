<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarAerolinea
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarAerolinea extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('EliminarModificarAerolinea_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones', 'perms'));
        $this->load->helper(array('aerolineas_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $this->load->view('EliminarModificarAerolinea_view', $data);
    }  

    public function buscarAerolinea() {
        $aerolinea = $this->input->post('aerolinea');
        $result = $this->EliminarModificarAerolinea_model->buscarAerolinea($aerolinea);
        $this->session->set_userdata('result_buscarAerolinea', $this->funciones->objectToArray($result));
        echo $this->armoConsulta($this->session->userdata('result_buscarAerolinea'));
    }  
    
    public function modificarAerolineaForm() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $nombre_aerolinea = $this->EliminarModificarAerolinea_model->obtengoNombreAerolinea($id_aerolinea);
        $html = '
            <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="aerolinea_modificada">Aerolinea</label>
                    <input type="text" class="form-control" id="aerolinea_modificada" placeholder="nombre aerolinea" value="'.$nombre_aerolinea.'">
                </div>
            </form>
            </div>    
            <div class="modal-footer">
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar Aerolinea" onclick="modificarAerolinea('.$id_aerolinea.');" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>';            

        echo $html;
    }
    
    public function modificarAerolinea() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $nombre_aerolinea = $this->input->post('nombre_aerolinea_new');
        if(!empty($id_aerolinea) && !empty($nombre_aerolinea)) {
            $this->EliminarModificarAerolinea_model->modificarAerolinea($id_aerolinea, $nombre_aerolinea);
            $this->Auditoria_model->insert(array("id_aerolinea" => $id_aerolinea, "nombre_aerolinea" => $nombre_aerolinea), "update", "aerolineas", $this->db->last_query());
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
        
        if($this->EliminarModificarAerolinea_model->verificarAerolineaBdo($id_aerolinea)) {
            $error['mensaje'] = "ERROR la aerolinea esta siendo usada en alguna bdo.";
            echo json_encode($error);
            return false;           
        }
        
        $this->EliminarModificarAerolinea_model->eliminarAerolinea($id_aerolinea);
        $this->Auditoria_model->insert(array("id_aerolinea" => $id_aerolinea), "delete", "aerolineas", $this->db->last_query());
        $error['mensaje'] = "CORRECTO aerolinea eliminada correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;
    }
    
    public function ordenarBuscar() {
        $parametro = $this->input->post('parametro');
        $ordenamiento = $this->input->post('ordenamiento');
        if($this->session->has_userdata('result_buscarAerolinea')) {
            $result = $this->funciones->array_sort($this->session->userdata('result_buscarAerolinea'), $parametro, $ordenamiento);
            $this->session->set_userdata('result_buscarAerolinea', $result);
            echo $this->armoConsulta($result);
        }
    }
    
    public function exportarExcel() {
        $title = "consulta_aerolineas";    
        $header = array();
        $header[] = "ID AEROLINEA";
        $header[] = "AEROLINEA";
        $body = array();
        if($this->session->has_userdata('result_buscarAerolinea')) {
            $i = 0;
            foreach ($this->session->userdata('result_buscarAerolinea') as $row) {
                $body[$i][0] = $row['id_aerolinea'];
                $body[$i][1] = $row['nombre_aerolinea'];
                $i++;
            }
        }
        $this->excel->crearExcel($header, $body, $title);
    }
    
    private function armoConsulta($result) {
        $tbody = '';
        foreach ($result as $key => $row) {
            $tbody .= "
                <tr>
                    <td>".$row['id_aerolinea']."</td>
                    <td>".$row['nombre_aerolinea']."</td>
                    <td>
                        <div class='d-flex justify-content-center'>
                            <button type='button' class='btn btn-default btn-md'>
                                <i aria-hidden='true' class='fas fa-save fa-lg' onclick='modificarAerolineaForm(".$row['id_aerolinea'].")'></i>
                            </button>
                        </div>                    
                    </td>
                    <td>
                        <div class='d-flex justify-content-center'>
                            <button type='button' class='btn btn-default btn-md'>
                                <i aria-hidden='true' class='fas fa-trash-alt fa-lg' onclick='cofirmaEliminar(".$row['id_aerolinea'].")'></i>
                            </button>
                        </div>                    
                    </td>                    
                </tr>";
        }
        return $tbody;        
    }
}