<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of CierreCaso
 *
 * @author sebastian.ituarte@gmail.com
 */
class CierreCaso extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('CierreCaso_model', 'ConsultaBdo_model', 'EliminarModificarSector_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones', 'perms'));
        $this->load->helper(array('aerolineas_helper', 'bdo_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $this->load->view('CierreCaso_view', $data);
    }  
    
    public function buscarCierreCaso() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');
        $result = $this->CierreCaso_model->buscarCierreCaso($numero, $id_aerolinea);
        $this->session->set_userdata('result_buscarCierreCaso', $this->funciones->objectToArray($result));
        echo $this->armoConsulta($this->session->userdata('result_buscarCierreCaso'));        
    }
    
    public function ordenarBuscar() {
        $parametro = $this->input->post('parametro');
        $ordenamiento = $this->input->post('ordenamiento');
        if($this->session->has_userdata('result_buscarCierreCaso')) {
            $result = $this->funciones->array_sort($this->session->userdata('result_buscarCierreCaso'), $parametro, $ordenamiento);
            $this->session->set_userdata('result_buscarCierreCaso', $result);
            echo $this->armoConsulta($result);
        }
    }
    
    public function exportarExcel() {
        $title = "consulta_cierre_caso";    
        $header = array();
        $header[] = "NUMERO BDO";
        $header[] = "AEROLINEA";
        $header[] = "PASAJERO";
        $header[] = "FECHA";
        $body = array();
        if($this->session->has_userdata('result_buscarCierreCaso')) {
            $i = 0;
            foreach ($this->session->userdata('result_buscarCierreCaso') as $row) {
                $body[$i][0] = $row['numero'];
                $body[$i][1] = $row['nombre_aerolinea'];
                $body[$i][2] = $row['nombre_pasajero'];
                $body[$i][3] = $row['fecha_llegada'];
                $i++;
            }
        }
        $this->excel->crearExcel($header, $body, $title);
    }    
    
    public function cerrarCaso() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('id_aerolinea');
        $comentario   = $this->input->post('comentario');
        
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
        
        $this->CierreCaso_model->cerrarCaso($data);
        $this->Auditoria_model->insert($data, "insert", "cierre_caso", $this->db->last_query());
        echo "OK";
        return true;        
    }
    
    public function cerrarCasos() {
        $seleccionBdo = json_decode($this->input->post('seleccionBdo'));
        
        if(empty($seleccionBdo)) {
            echo "ERROR";
            return false;
        }
        
        foreach($seleccionBdo as $row) {
            $value = explode("|", $row->value);
            
            $data = array(
                "numero" => $value[0],
                "id_aerolinea" => $value[1],
                "comentario" => "OK -> Se cerro en modulo cascada (Cierre de Multiples BDO)",
                "usuario" => $this->session->userdata('usuario')
            );

            $this->CierreCaso_model->cerrarCaso($data);  
            $this->Auditoria_model->insert($data, "insert", "cierre_caso", $this->db->last_query());
        }
        echo "OK";
        return true;        
    }    

    public function cargoInformacionExtra() {
        echo cargoInformacionExtra($this->input->post('numero'),$this->input->post('aerolinea'));
    } 
    
    private function armoConsulta($result) {
        $tbody = '';
        foreach ($result as $row) {
            $class = "class='table-light'";
            //Parametros para funcion cerrarCaso JS
            $env_numero = "'".$row['numero']."'";
            $env_id_aerolinea = "'".$row['id_aerolinea']."'";
            $env_nombre_aerolinea = "'".$row['nombre_aerolinea']."'";
            if($this->ConsultaBdo_model->countComentarios($row['numero'], $row['id_aerolinea']) > 0) {
                $class="class='table-warning'";
            }
            
            //value del checkbox PK => (numbero_bdo, id_aerolinea)
            $seleccionBdo = implode("|", array($row['numero'], $row['id_aerolinea']));
           
            $tbody .= '
                <tr '.$class.'>
                  <td><div class="form-check"><input id="seleccionBdo" class="form-check-input" type="checkbox" name="seleccionBdo[]" value="'.$seleccionBdo.'"></div></td>
                  <td>'.$row['numero'].'</td>
                  <td>'.$row['nombre_aerolinea'].'</td>
                  <td>'.$row['nombre_pasajero'].'</td>
                  <td>'.$row['fecha_llegada'].'</td>
                  <td>
                    <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-default">
                        <i aria-hidden="true" class="fas fa-search-plus fa-lg" onclick="cargoInformacionExtra('.$env_numero.', '.$env_id_aerolinea.')"></i>
                    </button>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-default">
                        <i aria-hidden="true" class="fas fa-check-circle fa-lg" onclick="cerrarCasoForm('.$env_numero.', '.$env_id_aerolinea.', '.$env_nombre_aerolinea.')"></i>
                    </button>
                    </div>
                  </td>                  
                </tr>';
        }
        return $tbody;        
    }
    
}
