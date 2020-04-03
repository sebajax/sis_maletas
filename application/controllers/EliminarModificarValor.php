<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarValor
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarValor extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('EliminarModificarValor_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms'));
        $this->load->helper(array('sectores_helper', 'aerolineas_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('EliminarModificarValor_view', $data);
    }  
    
    public function buscarValor() {
        $id_aerolinea = $this->input->post('aerolinea');
        $grupo_sector = $this->input->post('grupo_sector');
        
        $result = $this->EliminarModificarValor_model->buscarValor($id_aerolinea, $grupo_sector);
        $tbody = '';
        foreach ($result as $key => $row) {
            $tbody .= "
                <tr>
                    <td>".$row->nombre_aerolinea."</td>
                    <td><div class='float-right'>".$row->grupo_sector."</div></td>
                    <td><div class='float-right'>$".number_format($row->valor)."</div></td>
                    <td>
                        <div class='d-flex justify-content-center'>
                            <button type='button' class='btn btn-default btn-md'>
                                <i aria-hidden='true' class='fas fa-save fa-lg' onclick='modificarValorForm(".$row->id_aerolinea.", ".$row->grupo_sector.")'></i>
                            </button>
                        </div>                     
                    </td>
                    <td>
                        <div class='d-flex justify-content-center'>
                            <button type='button' class='btn btn-default btn-md'>
                                <i aria-hidden='true' class='fas fa-trash-alt fa-lg' onclick='cofirmaEliminar(".$row->id_aerolinea.", ".$row->grupo_sector.")'></i>
                            </button>
                        </div>                      
                    </td>                    
                </tr>";
        }
        echo $tbody;
    }  

    public function modificarValorForm() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $grupo_sector = $this->input->post('grupo_sector');
        $aerolinea = cargoAerolinea();
        $grupo_sectores = cargoSector();
        $row = $this->EliminarModificarValor_model->obtengoInformacionValor($id_aerolinea, $grupo_sector);
        $attributes_aerolinea = 'class = "form-control" id = "aerolinea_new" disabled= "disabled"';
        $attributes_grupo_sector = 'class = "form-control" id = "grupo_sector_new" disabled= "disabled"';
        
        $html = '
            <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="aerolinea" class="control-label">Aerolinea</label>
                    '.form_dropdown('aerolinea_new', $aerolinea, $row->id_aerolinea, $attributes_aerolinea).'
                </div>            

                <div class="form-group">
                    <label for="grupo_sector" class="control-label">Grupo sector</label>
                    '.form_dropdown('grupo_sector_new', $grupo_sectores, $row->grupo_sector, $attributes_grupo_sector).'
                </div>    

                <div class="form-group">
                    <label for="valor_new" class="control-label">Valor</label>
                    <input id="valor_new" name="valor_new" placeholder="valor" type="text" class="form-control" value="'.$row->valor.'" />
                </div>  
            </form>
            </div>    
            <div class="modal-footer">
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar Valor" onclick="modificarValor('.$id_aerolinea.', '.$grupo_sector.');" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>'; 
        
        echo $html;
    }
    
    public function modificarValor() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $grupo_sector = $this->input->post('grupo_sector');
        $valor_new    = $this->input->post('valor_new');
        if(!empty($id_aerolinea) && !empty($grupo_sector) && !empty($valor_new)) {
            $this->EliminarModificarValor_model->modificarValor($id_aerolinea, $grupo_sector, $valor_new);
            $this->Auditoria_model->insert(array("id_aerolinea" => $id_aerolinea, "grupo_sector" => $grupo_sector, "valor" => $valor_new), "update", "valores", $this->db->last_query());
            echo "OK";
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function eliminarValor() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        $grupo_sector = $this->input->post('grupo_sector');
        
        $error = array(
            'estado' => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($id_aerolinea)) {
            $error['mensaje'] = "ERROR la aerolinea no puede ser vacia.";
            echo json_encode($error);
            return false;
        }
        
        if(empty($grupo_sector)) {
            $error['mensaje'] = "ERROR el sector no puede ser vacio.";
            echo json_encode($error);
            return false;
        }       
        
        $this->EliminarModificarValor_model->eliminarValor($id_aerolinea, $grupo_sector);
        $this->Auditoria_model->insert(array("id_aerolinea" => $id_aerolinea, "grupo_sector" => $grupo_sector), "delete", "valores", $this->db->last_query());
        $error['mensaje'] = "CORRECTO valor eliminada correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;
    }    
}