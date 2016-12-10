<?php
/**
 * Description of consulta_bdo
 *
 * @author Sebas
 */
class consulta_bdo extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('consulta_bdo_model', 'alta_valores_model'));
        $this->load->library('validation');
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = $this->cargoAerolinea();
        $data['grupo_sector'] = $this->cargoSector();
        $this->load->view('consulta_bdo_view', $data);
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
    
    public function buscarBdo() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');
        $result = $this->consulta_bdo_model->buscarBdo($numero, $id_aerolinea);
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
    
}
