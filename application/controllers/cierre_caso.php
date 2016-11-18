<?php
/**
 * Description of cierre_caso
 *
 * @author Sebas
 */
class cierre_caso extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('cierre_caso_model', 'alta_valores_model'));
        $this->load->library('validation');
    }
    
    function index() {
        $data = array();
        $data['aerolinea']    = $this->cargoAerolinea();
        $this->load->view('cierre_caso_view', $data);
    }  
    
    private function cargoAerolinea() {
        return $this->alta_valores_model->getAerolineas();
    }
    
    public function buscarCierreCaso() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');
        $result = $this->cierre_caso_model->buscarCierreCaso($numero, $id_aerolinea);
        $tbody = '';
        foreach ($result as $key => $row) {
            //Parametros para funcion cerrarCaso JS
            $env_numero = "'".$row->numero."'";
            $env_id_aerolinea = "'".$row->id_aerolinea."'";
            
            $tbody .= '
                <tr>
                  <th scope="row">'.($key + 1).'</th>
                  <td>'.$row->numero.'</td>
                  <td>'.$row->nombre_aerolinea.'</td>
                  <td>'.$row->nombre_pasajero.'</td>
                  <td>'.$row->fecha_llegada.'</td>
                  <td>
                    <button type="button" class="btn btn-default btn-md">
                        <span class="glyphicon glyphicon-search" aria-hidden="true" onclick="cargoInformacion()"></span>
                    </button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-default btn-md">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="cerrarCaso('.$env_numero.', '.$env_id_aerolinea.')"></span>
                    </button>
                  </td>                  
                </tr>';
        }
        echo $tbody;
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
}
