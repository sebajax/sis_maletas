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
        $this->load->library(array('validation', 'perms'));
        $this->load->helper(array('sectores_helper', 'aerolineas_helper'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['aerolinea']    = cargoAerolinea();
        $data['region']       = cargoRegion();
        $data['grupo_sector'] = cargoSector();
        $this->load->view('alta_bdo_view', $data);
    }
    
    public function cargoValor() {
        echo ($this->input->post('cantidad_maletas') * $this->alta_valores_model->getValor($this->input->post('aerolinea'), $this->input->post('grupo_sector')));
    }
    
    public function altaBdo() {
        
        //obtener id_sector
        $id_sector = getSector($this->input->post('grupo_sector'), $this->input->post('lugar_sector'));
        
        //cargo el post en variables
        $data = array(
            "numero"               => $this->input->post('numero'),
            "id_aerolinea"         => $this->input->post('aerolinea'),
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
    
    public function cargoLugares() {
        $grupo_sector = $this->input->post('grupo_sector');
        echo cargoLugares($grupo_sector);
    }
    
    private function validatePK($pk) {
        if($this->alta_bdo_model->validatePK($pk) > 0) { return false; } else { return true; }
    }
}
