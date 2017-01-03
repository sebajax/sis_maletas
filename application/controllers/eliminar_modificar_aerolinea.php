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
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = $this->cargoAerolinea();
        $this->load->view('eliminar_modificar_aerolinea_view', $data);
    }  
    
    private function cargoAerolinea() {
        return $this->alta_valores_model->getAerolineas();
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
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true' onclick='modificarAerolinea(".$row->id_aerolinea.")'></span>
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
    
    public function modificarAerolinea() {
        $id_aerolinea = $this->input->post('id_aerolinea');
        echo "Lo que paso paso entre tu y yo";
        //$result = $this->eliminar_modificar_sector_model->cargoInformacionExtra($numero, $id_aerolinea);
    }
}