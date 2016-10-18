<?php
/**
 * Description of alta_valores
 *
 * @author Carolina
 */
class alta_valores extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('alta_valores_model');
        $this->load->library('validation');
    } 
    
    function index() {
        $data = array();
        $data['aerolinea'] = $this->cargoAerolinea();
        $data['grupo_sector'] = $this->cargoGrupoSector();
        $this->load->view('alta_valores_view', $data);         
    }
    
    function cargoLugares() {
        echo $this->cargoLugaresProcess();
    }
    
    function altaValores() {
        $data = array(
            "aerolinea"    => $this->input->post('aerolinea'),
            "grupo_sector" => $this->input->post('grupo_sector'),
            "lugar"        => $this->input->post('lugar'),
            "valor"        => $this->input->post('valor'),
        );
        
        $errorPk    = false;
        $errorEmpty = false;       
        
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }    
        
        //obtener id_sector
        $id_sector = $this->alta_valores_model->getSector($data['grupo_sector'], $data['lugar']);

        unset($data);
        $data = array(
            "id_aerolinea" => $this->input->post('aerolinea'),
            "id_sector"    => $id_sector,
            "valor"        => $this->input->post('valor'),
        );
        
        if(!$this->validatePK($data)) { $errorPk = true; }
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }    
         
        if($errorPk) { echo "PK"; return false; }
        
        if(!$errorEmpty) {
            $this->alta_valores_model->insert($data);
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
    
    private function cargoGrupoSector() {
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
        if($this->alta_valores_model->validatePK($pk) > 0) { return false; } else { return true; }
    }    
}
