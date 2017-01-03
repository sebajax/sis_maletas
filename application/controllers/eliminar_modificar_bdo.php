<?php
/**
 * Description of eliminar_modificar_bdo
 *
 * @author Sebas
 */
class eliminar_modificar_bdo extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('eliminar_modificar_bdo_model', 'alta_valores_model'));
        $this->load->library('validation');
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = $this->cargoAerolinea();
        $data['grupo_sector'] = $this->cargoSector();
        $this->load->view('eliminar_modificar_bdo_view', $data);
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
        $nombre_pasajero = $this->input->post('pasajero');
        $fecha_desde = $this->input->post('fecha_desde');
        $fecha_hasta = $this->input->post('fecha_hasta');
        $id_sector = $this->input->post('grupo_sector');
        
        $result = $this->eliminar_modificar_bdo_model->buscarBdo($numero, $id_aerolinea, $nombre_pasajero, $fecha_desde, $fecha_hasta, $id_sector);
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
                  <td>
                    <button type='button' class='btn btn-default btn-md'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true' onclick='modificarBdo(".$aux_numero.", ".$aux_id_aerolinea.")'></span>
                    </button>   
                  </td>
                  <td>
                    <button type='button' class='btn btn-default btn-md'>
                        <span class='glyphicon glyphicon-trash' aria-hidden='true' onclick='eliminarBdo(".$aux_numero.", ".$aux_id_aerolinea.")'></span>
                    </button>   
                  </td>                    
                </tr>";
        }
        echo $tbody;
    }  
    
    public function cargoInformacionExtra() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');

        $result = $this->eliminar_modificar_bdo_model->cargoInformacionExtra($numero, $id_aerolinea);
        
        $table = '<table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Numero B.D.O</td>
                            <td>'.$numero.'</td>
                        </tr>
                        <tr>
                            <td>Nombre Pasajero</td>
                            <td>'.$result->nombre_pasajero.'</td>
                        </tr>
                        <tr>
                            <td>Aerolinea</td>
                            <td>'.$result->nombre_aerolinea.'</td>
                        </tr>
                        <tr>
                            <td>Telefono</td>
                            <td>'.$result->telefono.'</td>
                        </tr>
                        <tr>
                            <td>Comuna</td>
                            <td>'.$result->domicilio_comuna.'</td>
                        </tr>
                        <tr>
                            <td>Direccion</td>
                            <td>'.$result->domicilio_direccion.'</td>
                        </tr>
                        <tr>
                            <td>Region</td>
                            <td>'.$result->domicilio_region.'</td>
                        </tr>
                        <tr>
                            <td>Sector</td>
                            <td>'.$result->grupo_sector.'</td>
                        </tr>
                        <tr>
                            <td>Nombre sector</td>
                            <td>'.$result->lugar.'</td>
                        </tr>                    
                    </tbody>   
                </table>';  
        
        echo $table;
    } 
    
    public function modificarBdo() {
        $numero       = $this->input->post('numero');
        $id_aerolinea = $this->input->post('aerolinea');

        $result = $this->eliminar_modificar_bdo_model->cargoInformacionExtra($numero, $id_aerolinea);

        
    }
    
}