<?php
/**
 * Description of alta_bdo
 *
 * @author Sebas
 */
class alta_bdo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('alta_bdo_model', 'alta_valores_model'));
        $this->load->library('validation');
    }
    
    function index() {
        $data = array();
        $data['aerolinea']    = $this->cargoAerolinea();
        $data['region']       = $this->cargoRegion();
        $data['grupo_sector'] = $this->cargoSector();
        $this->load->view('alta_bdo_view', $data);
    }
    
    function cargoLugares() {
        echo $this->cargoLugaresProcess();
    }    
    
    function cargoValor() {
        //obtener id_sector
        $id_sector = $this->alta_valores_model->getSector($this->input->post('grupo_sector'), $this->input->post('lugar_sector'));
        echo $this->alta_valores_model->getValor($this->input->post('aerolinea'), $id_sector);
    }
    
    function altaBdo() {
        
        //obtener id_sector
        $id_sector = $this->alta_valores_model->getSector($this->input->post('grupo_sector'), $this->input->post('lugar_sector'));
        
        //cargo el post en variables
        $data = array(
            "numero"               => $this->input->post('numero'),
            "id_aerolinea"            => $this->input->post('aerolinea'),
            "fecha_llegada"        => $this->input->post('fecha_llegada'),
            "nombre_pasajero"      => $this->input->post('nombre_pasajero'),
            "cantidad_maletas"     => $this->input->post('cantidad_maletas'),
            "domicilio_region"     => $this->input->post('region'),
            "domicilio_comuna"     => $this->input->post('comuna'),
            "domicilio_direccion"  => $this->input->post('direccion'),
            "telefono"             => $this->input->post('telefono'),
            "id_sector"            => $id_sector,
            "valor"                => $this->input->post('valor')
        );
        
        $errorPk    = false;
        $errorEmpty = false;
        $errorDate  = false;
        
        if(!$this->validatePK($data)) { $errorPk = true; }
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        if($this->validation->validateDate($data['fecha_llegada'])) { $errorDate = true; }
        
        if($errorPk) { echo "PK"; return false; }
        
        if(!$errorEmpty && !$errorDate) {
            $this->alta_bdo_model->insert($data);
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    private function cargoAerolinea() {
        return $this->alta_valores_model->getAerolineas();
    }
    
    private function cargoRegion() {
        $region = array('-SELECCIONE-');
        array_push($region, "REGION DE LOS LAGOS");
        array_push($region, "REGION DE VALPARAISO");
        array_push($region, "REGION METROPOLITANA");
        return $region;
    }
    
    private function cargoSector() {
        $sector = array('-SELECCIONE-');
        for($i=0; $i < 12; $i++) {
            array_push($sector, ($i+1));
        }
        return $sector;
    }
    
    private function cargoLugaresProcess() {
        $html = "<option> </option>";
        $grupo_sector = $this->input->post('grupo_sector');
        
        if(empty($grupo_sector)) {
            return $html;
        }
        
        $lugares = $this->alta_valores_model->getLugares($grupo_sector);
        
        foreach($lugares as $val) {
            $html .= "<option value='".$val."'>".$val."</option>";
        }
        return $html;
    }    
    
    private function validatePK($pk) {
        if($this->alta_bdo_model->validatePK($pk) > 0) { return false; } else { return true; }
    }
}
