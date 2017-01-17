<?php
/**
 * Description of eliminar_modificar_sector
 *
 * @author Sebas
 */
class eliminar_modificar_sector extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('eliminar_modificar_sector_model');
        $this->load->library('validation');
        $this->load->helper(array('sectores_helper'));
    }
    
    function index() {
        $data = array();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('eliminar_modificar_sector_view', $data);
    }  
   
    public function buscarSector() {
        $grupo_sector = $this->input->post('grupo_sector');
        $lugar        = $this->input->post('lugar');
        
        $result = $this->eliminar_modificar_sector_model->buscarSector($grupo_sector, $lugar);
        $tbody = '';
        foreach ($result as $key => $row) {
            $tbody .= "
                <tr>
                    <th scope='row'>".($key + 1)."</th>
                    <td>".$row->id_sector."</td>
                    <td>".$row->grupo_sector."</td>
                    <td>".$row->lugar."</td>
                    <td>
                        <button type='button' class='btn btn-default btn-md'>
                            <span class='glyphicon glyphicon-pencil' aria-hidden='true' onclick='modificarSectorForm(".$row->id_sector.")'></span>
                        </button>   
                    </td>
                    <td>
                        <button type='button' class='btn btn-default btn-md'>
                            <span class='glyphicon glyphicon-trash' aria-hidden='true' onclick='eliminarSector(".$row->id_sector.")'></span>
                        </button>   
                    </td>                    
                </tr>";
        }
        echo $tbody;
    }  

    public function modificarSectorForm() {
        $id_sector = $this->input->post('id_sector');
        $grupo_sector = cargoSector();
        $row = $this->eliminar_modificar_sector_model->obtengoInformacionSector($id_sector);
        $attributes = 'class = "form-control" id = "grupo_sector_new"';
        $html = '
            <form>
                <div class="form-group">
                    <label for="grupo_sector_new" class="control-label">Grupo</label> 
                        '.form_dropdown("grupo_sector_new", $grupo_sector, $row->grupo_sector, $attributes).'
                </div>         
                <div class="form-group">
                    <label for="lugar_new" class="control-label">Lugar</label>
                    <input id="lugar_new" name="lugar_new" placeholder="nombre del lugar" type="text" class="form-control" value="'.$row->lugar.'"/>
                </div>     
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar sector" onclick="modificarSector('.$id_sector.');" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" onclick="cancelarModificarSector();"/>
            </form>';
        
        echo $html;
    }
    
    public function modificarSector() {
        $id_sector = $this->input->post('id_sector');
        $grupo_sector_new = $this->input->post('grupo_sector_new');
        $lugar_new = $this->input->post('lugar_new');
        
        if(!empty($id_sector) && !empty($grupo_sector_new) && !empty($lugar_new)) {
            $this->eliminar_modificar_sector_model->modificarSector($id_sector, $grupo_sector_new, $lugar_new);
            echo "OK";
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function eliminarSector() {
        $id_sector = $this->input->post('id_sector');
        
        $error = array(
            'estado' => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($id_sector)) {
            $error['mensaje'] = "ERROR el sector no puede ser vacia.";
            echo json_encode($error);
            return false;
        }
        
        if($this->eliminar_modificar_sector_model->verificarSectorBdo($id_sector)) {
            $error['mensaje'] = "ERROR el sector esta siendo usada en alguna bdo.";
            echo json_encode($error);
            return false;           
        }
        
        $this->eliminar_modificar_sector_model->eliminarSector($id_sector);
        $error['mensaje'] = "CORRECTO sector eliminado correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;
    }
}