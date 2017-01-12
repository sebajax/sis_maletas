<?php
/**
 * Description of eliminar_modificar_valor
 *
 * @author Sebas
 */
class eliminar_modificar_valor extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('eliminar_modificar_valor_model', 'alta_valores_model'));
        $this->load->library('validation');
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = $this->cargoAerolinea();
        $data['grupo_sector'] = $this->cargoSector();
        $this->load->view('eliminar_modificar_valor_view', $data);
    }  
    
    private function cargoAerolinea() {
        return $this->alta_valores_model->getAerolineas();
    }
    
    private function cargoSector() {
        $sector = array('-SELECCIONE-');
        for($i=0; $i < 12; $i++) {
            array_push($sector, ($i+1));
        }
        return $sector;
    }    
    
    public function buscarValor() {
        $id_aerolinea = $this->input->post('aerolinea');
        $grupo_sector = $this->input->post('grupo_sector');
        $lugar        = $this->input->post('lugar');
        
        $result = $this->eliminar_modificar_valor_model->buscarValor($id_aerolinea, $grupo_sector, $lugar);
        $tbody = '';
        foreach ($result as $key => $row) {
            $tbody .= "
                <tr>
                    <th scope='row'>".($key + 1)."</th>
                    <td>".$row->nombre_aerolinea."</td>
                    <td>".$row->grupo_sector."</td>
                    <td>".$row->lugar."</td>
                    <td>".$row->valor."</td>
                    <td>
                        <button type='button' class='btn btn-default btn-md'>
                            <span class='glyphicon glyphicon-pencil' aria-hidden='true' onclick='modificarValorForm(".$row->id_aerolinea.", ".$row->id_sector.")'></span>
                        </button>   
                    </td>
                    <td>
                        <button type='button' class='btn btn-default btn-md'>
                            <span class='glyphicon glyphicon-trash' aria-hidden='true' onclick='eliminarValor(".$row->id_aerolinea.", ".$row->id_sector.")'></span>
                        </button>   
                    </td>                    
                </tr>";
        }
        echo $tbody;
    }  

    public function modificarValorForm() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $id_sector    = $this->input->post('id_sector');
        $aerolinea = $this->cargoAerolinea();
        $grupo_sector = $this->cargoSector();
        $row = $this->eliminar_modificar_valor_model->obtengoInformacionValor($id_aerolinea, $id_sector);
        $attributes_aerolinea = 'class = "form-control" id = "aerolinea_new" disabled= "disabled"';
        $attributes_grupo_sector = 'class = "form-control" id = "grupo_sector_new" disabled= "disabled"';
        
        $html = '
            <form>
                <div class="form-group">
                    <label for="aerolinea" class="control-label">Aerolinea</label>
                    '.form_dropdown('aerolinea_new', $aerolinea, $row->id_aerolinea, $attributes_aerolinea).'
                </div>            

                <div class="form-group">
                    <label for="grupo_sector" class="control-label">Grupo sector</label>
                    '.form_dropdown('grupo_sector_new', $grupo_sector, $row->grupo_sector, $attributes_grupo_sector).'
                </div>    
            
                <div class="form-group">
                    <label for="lugar_sector" class="control-label">Lugar sector</label>
                    <select class="form-control" id="lugar_sector" disabled="disabled">
                        <option value="'.$row->lugar.'">'.$row->lugar.'</option> 
                    </select>
                </div>            

                <div class="form-group">
                    <label for="valor_new" class="control-label">Valor</label>
                    <input id="valor_new" name="valor_new" placeholder="valor" type="text" class="form-control" value="'.$row->valor.'" />
                </div>  
                
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar valor" onclick="modificarValor('.$id_aerolinea.', '.$id_sector.');" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" onclick="cancelarModificarValor();"/>
            </form>';
        
        echo $html;
    }
    
    public function modificarValor() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $id_sector    = $this->input->post('id_sector');
        $valor_new    = $this->input->post('valor_new');
        if(!empty($id_aerolinea) && !empty($id_sector) && !empty($valor_new)) {
            $this->eliminar_modificar_valor_model->modificarValor($id_aerolinea, $id_sector, $valor_new);
            echo "OK";
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function eliminarValor() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $id_sector    = $this->input->post('id_sector');
        
        $error = array(
            'estado' => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($id_aerolinea)) {
            $error['mensaje'] = "ERROR la aerolinea no puede ser vacia.";
            echo json_encode($error);
            return false;
        }
        
        if(empty($id_sector)) {
            $error['mensaje'] = "ERROR el sector no puede ser vacio.";
            echo json_encode($error);
            return false;
        }       
        
        $this->eliminar_modificar_valor_model->eliminarValor($id_aerolinea, $id_sector);
        $error['mensaje'] = "CORRECTO valor eliminada correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;
    }    
}