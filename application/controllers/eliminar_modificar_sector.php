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
    }
    
    function index() {
        $data = array();
        $data['grupo_sector'] = $this->cargoSector();
        $this->load->view('eliminar_modificar_sector_view', $data);
    }  
    
    private function cargoSector() {
        $sector = array('-SELECCIONE-');
        for($i=0; $i < 12; $i++) {
            array_push($sector, ($i+1));
        }
        return $sector;
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
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true' onclick='modificarSector(".$row->id_sector.")'></span>
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
    
    public function modificarBdo() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');

        $result = $this->eliminar_modificar_sector_model->cargoInformacionExtra($numero, $id_aerolinea);

        
    }
    
}