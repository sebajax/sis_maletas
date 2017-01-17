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
        $this->load->helper(array('sectores_helper', 'aerolineas_helper', 'bdo_helper'));
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('consulta_bdo_view', $data);
    }  
    
    public function buscarBdo() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');
        $nombre_pasajero = $this->input->post('pasajero');
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
        $grupo_sector = $this->input->post('grupo_sector');
        
        $result = $this->consulta_bdo_model->buscarBdo($numero, $id_aerolinea, $nombre_pasajero, $fecha_desde, $fecha_hasta, $grupo_sector);
        $tbody = '';
        foreach ($result as $key => $row) {
            if($row->estado == 1) {
                $estado = "CERRADO";
            }else {
                $estado = "ABIERTO";
            }
            
            $aux_numero       = '"'.$row->numero.'"';
            $aux_id_aerolinea = '"'.$row->id_aerolinea.'"';
            
            $tbody .= "
                <tr>
                  <th scope='row'>".($key + 1)."</th>
                  <td>".$row->numero."</td>
                  <td>".$row->nombre_aerolinea."</td>
                  <td>".$row->nombre_pasajero."</td>
                  <td>".$row->cantidad_maletas."</td>    
                  <td>".$row->valor."</td>
                  <td>".$estado."</td>
                  <td>".$row->fecha_llegada."</td>
                  <td>
                    <button type='button' class='btn btn-default btn-md'>
                        <span class='glyphicon glyphicon-search' aria-hidden='true' onclick='cargoInformacionExtra(".$aux_numero.", ".$aux_id_aerolinea.")'></span>
                    </button>   
                  </td>
                </tr>";
        }
        echo $tbody;
    }  
    
    public function cargoInformacionExtra() {
        echo cargoInformacionExtra($this->input->post('numero'),$this->input->post('aerolinea'));       
    } 
    
}