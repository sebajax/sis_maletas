<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarBdo
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarBdo extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('EliminarModificarBdo_model', 'AltaValores_model', 'ConsultaBdo_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones', 'perms'));
        $this->load->helper(array('sectores_helper', 'aerolineas_helper', 'bdo_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('EliminarModificarBdo_view', $data);
    }  
    
    public function buscarBdo() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');
        $nombre_pasajero = $this->input->post('pasajero');
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
        $grupo_sector = $this->input->post('grupo_sector');
        $result = $this->EliminarModificarBdo_model->buscarBdo($numero, $id_aerolinea, $nombre_pasajero, $fecha_desde, $fecha_hasta, $grupo_sector);
        $this->session->set_userdata('result_buscarBdo', $this->funciones->objectToArray($result));
        echo $this->armoConsulta($this->session->userdata('result_buscarBdo'));
    }  
    
    public function cargoInformacionExtra() {
        echo cargoInformacionExtra($this->input->post('numero'),$this->input->post('id_aerolinea'));
    } 
    
    public function modificarBdoForm() {
        $numero = $this->input->post('numero');
        $id_aerolinea = $this->input->post('id_aerolinea');
        $info_bdo = $this->ConsultaBdo_model->cargoInformacionExtra($numero, $id_aerolinea);
        $aerolinea = cargoAerolinea();
        $grupo_sector = cargoSector();
        $region = cargoRegion();
        $attr_aerolinea = 'class = "form-control" id = "aerolinea_new" disabled= "disabled"';
        $attr_region = 'class = "form-control" id = "region_new"';
        $attr_grupo_sector = 'class = "form-control" id = "grupo_sector_new" onchange="grupoSectorEvents()"';
        $aux_numero       = "'".$numero."'";
        
        $html = '
            <form>
                <div class="form-group">
                    <label for="numero_new" class="control-label">Numero</label>
                    <input id="numero_new" disabled= "disabled" name="numero_new" placeholder="numero bdo" type="text" class="form-control" value="'.$info_bdo->numero.'" />
                </div>

                <div class="form-group">
                    <label for="aerolinea_new" class="control-label">Aerolinea</label>
                    '.form_dropdown('aerolinea_new', $aerolinea, $info_bdo->id_aerolinea, $attr_aerolinea).'
                </div>            

                <div class="form-group">
                    <label for="fecha_llegada_new" class="control-label">Fecha Llegada</label>
                    <input id="fecha_llegada_new" name="fecha_llegada_new" placeholder="fecha llegada" type="text" class="form-control" value="'.str_replace("-", "/", $info_bdo->fecha_llegada).'" />
                </div>

                <div class="form-group">
                    <label for="nombre_pasajero_new" class="control-label">Nombre Pasajero</label>
                    <input id="nombre_pasajero_new" name="nombre_pasajero_new" placeholder="nombre pasajero" type="text" class="form-control" value="'.$info_bdo->nombre_pasajero.'" />
                </div>            

                <div class="form-group">
                    <label for="cantidad_maletas_new" class="control-label">Cantidad Maletas</label>
                    <input id="cantidad_maletas_new" name="cantidad_maletas_new" placeholder="cantidad maletas" type="text" class="form-control" value="'.$info_bdo->cantidad_maletas.'" />
                </div>  

                <div class="form-group">
                    <label for="region_new" class="control-label">Region</label>
                    '.form_dropdown('region_new', $region, $info_bdo->domicilio_region, $attr_region).'
                </div>

                <div class="form-group">
                    <label for="comuna_new" class="control-label">Comuna</label>
                    <input id="comuna_new" name="comuna_new" placeholder="comuna" type="text" class="form-control" value="'.$info_bdo->domicilio_comuna.'" />
                </div>

                <div class="form-group">
                    <label for="direccion_new" class="control-label">Direccion</label>
                    <textarea class="form-control noresize" rows="5" id="direccion_new" placeholder="direccion">'.$info_bdo->domicilio_direccion.'</textarea>
                </div>            

                <div class="form-group">
                    <label for="telefono_new" class="control-label">Telefono</label>
                    <input id="telefono_new" name="telefono_new" placeholder="telefono" type="text" class="form-control" value="'.$info_bdo->telefono.'" />
                </div>             

                <div class="form-group">
                    <label for="grupo_sector_new" class="control-label">Grupo sector</label>
                    '.form_dropdown('grupo_sector_new', $grupo_sector, $info_bdo->grupo_sector, $attr_grupo_sector).'
                </div>    

                <div class="form-group">
                    <label for="lugar_sector_new" class="control-label">Lugar sector</label>
                    <select class="form-control" id="lugar_sector_new"> <option value="'.$info_bdo->lugar.'">'.$info_bdo->lugar.'</option> </select>
                </div>  

                <div class="form-group">
                    <label for="valor_new" class="control-label">Valor</label>
                    <input id="valor_new" name="valor_new" placeholder="valor" type="text" class="form-control" value="'.$info_bdo->valor.'" readonly/>
                </div> 

                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar bdo" onclick="modificarBdo('.$aux_numero.', '.$id_aerolinea.');" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" onclick="cancelarModificarBdo();"/>
            </form>';
        
        echo $html;
    }
    
    public function modificarBdo() {
        //obtener id_sector
        $id_sector_new = $this->AltaValores_model->getSector($this->input->post('grupo_sector_new'), $this->input->post('lugar_sector_new'));
        
        //cargo el post en variables
        $data = array(
            "numero"               => $this->input->post('numero'),
            "id_aerolinea"         => $this->input->post('id_aerolinea'),
            "fecha_llegada"        => $this->input->post('fecha_llegada_new'),
            "nombre_pasajero"      => $this->input->post('nombre_pasajero_new'),
            "cantidad_maletas"     => $this->input->post('cantidad_maletas_new'),
            "domicilio_region"     => $this->input->post('region_new'),
            "domicilio_comuna"     => $this->input->post('comuna_new'),
            "domicilio_direccion"  => $this->input->post('direccion_new'),
            "telefono"             => $this->input->post('telefono_new'),
            "id_sector"            => $id_sector_new,
            "valor"                => $this->input->post('valor_new')
        );
       
        $errorEmpty  = false;
        $errorDate   = false;
        $errorEstado = false;
        
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        if($this->validation->validateDate($data['fecha_llegada'])) { $errorDate = true; }
 
        if($this->EliminarModificarBdo_model->verificoEstadoBdo($data['numero'], $data['id_aerolinea']) != 0) {
            $errorEstado = true;
        }
        
        
        if(!$errorEmpty && !$errorDate && !$errorEstado) {
            $this->EliminarModificarBdo_model->modificarBdo($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function eliminarBdo() {
        $numero = $this->input->post('numero');
        $id_aerolinea = $this->input->post('id_aerolinea');
        
        $error = array(
            'estado' => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($numero) && empty($id_aerolinea)) {
            $error['mensaje'] = "ERROR no puede contener elementos vacios al eliminar.";
            echo json_encode($error);
            return false;
        }
        
        if($this->EliminarModificarBdo_model->verificoEstadoBdo($numero, $id_aerolinea) != 0) {
            $error['mensaje'] = "ERROR para poder eliminar una bdo, esta tiene que ser un caso abierto.";
            echo json_encode($error);
            return false;
        }
        
        $this->EliminarModificarBdo_model->eliminarBdo($numero, $id_aerolinea);
        $error['mensaje'] = "CORRECTO bdo eliminada correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;
    } 
    
    public function agregarComentario() {
        $numero = $this->input->post('numero');
        $id_aerolinea = $this->input->post('id_aerolinea');
        $comentario = $this->input->post('comentario');
        
        if(empty($numero) || empty($id_aerolinea) || empty($comentario)) {
            echo "ERROR";
            return false;
        }
        
        $data = array(
            "numero" => $numero,
            "id_aerolinea" => $id_aerolinea,
            "comentario" => $comentario,
            "usuario" => $this->session->userdata('usuario')
        );
        
        $this->EliminarModificarBdo_model->agregarComentario($data);
        echo "OK";
        return true;
    }
    
    public function ordenarBuscar() {
        $parametro = $this->input->post('parametro');
        $ordenamiento = $this->input->post('ordenamiento');
        if($this->session->has_userdata('result_buscarBdo')) {
            $result = $this->funciones->array_sort($this->session->userdata('result_buscarBdo'), $parametro, $ordenamiento);
            $this->session->set_userdata('result_buscarBdo', $result);
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
        foreach ($result as $key => $row) {
            $class = "";
            if($row['estado'] == 1) {
                $estado = "CERRADO";
            }else {
                $estado = "ABIERTO";
            }
            $aux_numero       = '"'.$row['numero'].'"';
            $aux_id_aerolinea = '"'.$row['id_aerolinea'].'"';
            $aux_nombre_aerolinia = '"'.$row['nombre_aerolinea'].'"';
            if($this->ConsultaBdo_model->countComentarios($row['numero'], $row['id_aerolinea']) > 0) {
                $class="class='warning'";
            }            
            $tbody .= "
                <tr ".$class.">
                  <th scope='row'>".($key + 1)."</th>
                  <td>".$row['numero']."</td>
                  <td>".$row['nombre_aerolinea']."</td>
                  <td>".$row['nombre_pasajero']."</td>
                  <td>".$row['cantidad_maletas']."</td>    
                  <td>".$row['valor']."</td>
                  <td>".$estado."</td>
                  <td>".$row['fecha_llegada']."</td>
                  <td>
                    <button type='button' class='btn btn-default btn-md'>
                        <span class='glyphicon glyphicon-search' aria-hidden='true' onclick='cargoInformacionExtra(".$aux_numero.", ".$aux_id_aerolinea.")'></span>
                    </button>   
                  </td>
                  <td>
                    <button type='button' class='btn btn-default btn-md'>
                        <span class='glyphicon glyphicon-edit' aria-hidden='true' onclick='agregarComentarioForm(".$aux_numero.", ".$aux_id_aerolinea.", ".$aux_nombre_aerolinia.")'></span>
                    </button>   
                  </td>                  
                  <td>
                    <button type='button' class='btn btn-default btn-md'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true' onclick='modificarBdoForm(".$aux_numero.", ".$aux_id_aerolinea.")'></span>
                    </button>   
                  </td>
                  <td>
                    <button type='button' class='btn btn-default btn-md'>
                        <span class='glyphicon glyphicon-trash' aria-hidden='true' onclick='cofirmaEliminar(".$aux_numero.", ".$aux_id_aerolinea.")'></span>
                    </button>   
                  </td>                    
                </tr>";
        }
        return $tbody;
    }
    
}