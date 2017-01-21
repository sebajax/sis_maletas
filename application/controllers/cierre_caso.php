<?php
/**
 * Description of cierre_caso
 *
 * @author Sebas
 */
class cierre_caso extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('cierre_caso_model', 'alta_valores_model', 'consulta_bdo_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones'));
        $this->load->helper(array('aerolineas_helper', 'bdo_helper'));
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $this->load->view('cierre_caso_view', $data);
    }  
    
    public function buscarCierreCaso() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');
        $result = $this->cierre_caso_model->buscarCierreCaso($numero, $id_aerolinea);
        $this->session->set_userdata('result_buscarCierreCaso', $this->funciones->objectToArray($result));
        echo $this->armoConsulta($this->session->userdata('result_buscarCierreCaso'));        
    }
    
    public function ordenarBuscar() {
        $parametro = $this->input->post('parametro');
        $ordenamiento = $this->input->post('ordenamiento');
        if(count($this->session->userdata('result_buscarCierreCaso')) > 0) {
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
        if(count($this->session->userdata('result_buscarCierreCaso')) > 0) {
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
        log_message("debug", "NUMERO:".$numero);
        log_message("debug", "ID AEROLINEA:".$id_aerolinea);
        if(!empty($numero) && !empty($id_aerolinea)) {
            $this->cierre_caso_model->cerrarCaso($numero, $id_aerolinea);
            echo "OK";
        }else {
            echo "ERROR";
        }
    }

    public function cargoInformacionExtra() {
        echo cargoInformacionExtra($this->input->post('numero'),$this->input->post('aerolinea'));
    } 
    
    private function armoConsulta($result) {
        $tbody = '';
        foreach ($result as $key => $row) {
            //Parametros para funcion cerrarCaso JS
            $env_numero = "'".$row['numero']."'";
            $env_id_aerolinea = "'".$row['id_aerolinea']."'";
            
            $tbody .= '
                <tr>
                  <th scope="row">'.($key + 1).'</th>
                  <td>'.$row['numero'].'</td>
                  <td>'.$row['nombre_aerolinea'].'</td>
                  <td>'.$row['nombre_pasajero'].'</td>
                  <td>'.$row['fecha_llegada'].'</td>
                  <td>
                    <button type="button" class="btn btn-default btn-md">
                        <span class="glyphicon glyphicon-search" aria-hidden="true" onclick="cargoInformacionExtra('.$env_numero.', '.$env_id_aerolinea.')"></span>
                    </button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-default btn-md">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="cerrarCaso('.$env_numero.', '.$env_id_aerolinea.')"></span>
                    </button>
                  </td>                  
                </tr>';
        }
        return $tbody;        
    }
    
}
