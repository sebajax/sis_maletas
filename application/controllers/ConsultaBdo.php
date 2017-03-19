<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of ConsultaBdo
 *
 * @author sebastian.ituarte@gmail.com
 */
class ConsultaBdo extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('ConsultaBdo_model'));
        $this->load->library(array('validation', 'excel', 'session', 'funciones', 'perms'));
        $this->load->helper(array('sectores_helper', 'aerolineas_helper', 'bdo_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['aerolinea'] = cargoAerolinea();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('ConsultaBdo_view', $data);
    }  
    
    public function buscarBdo() {
        $numero          = $this->input->post('numero');
        $id_aerolinea    = $this->input->post('aerolinea');
        $nombre_pasajero = $this->input->post('pasajero');
        $fecha_desde     = $this->input->post('fecha_desde');
        $fecha_hasta     = $this->input->post('fecha_hasta');
        $grupo_sector    = $this->input->post('grupo_sector');
        $estado          = $this->input->post('estado');
        $result = $this->ConsultaBdo_model->buscarBdo($numero, $id_aerolinea, $nombre_pasajero, $fecha_desde, $fecha_hasta, $grupo_sector, $estado);
        $this->session->set_userdata('result_buscarBdo', $this->funciones->objectToArray($result));
        echo $this->armoConsulta($this->session->userdata('result_buscarBdo'));
    }  
    
    public function cargoInformacionExtra() {
        echo cargoInformacionExtra($this->input->post('numero'),$this->input->post('id_aerolinea'));       
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

    public function armoConsulta($result) {
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
                </tr>";
        }
        return $tbody;
    }
}