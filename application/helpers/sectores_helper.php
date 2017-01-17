<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('cargoSector')) {
    function cargoSector() {
        $sector = array('-SELECCIONE-');
        for($i=0; $i < 12; $i++) {
            array_push($sector, ($i+1));
        }
        return $sector;
    } 
}

if(!function_exists('cargoLugares')) {
    function cargoLugares($grupo_sector) {
        $CI = get_instance();
        $CI->load->model('alta_valores_model');
        
        $html = "<option> </option>";
        
        if(empty($grupo_sector)) {
            return $html;
        }
        
        $lugares = $CI->alta_valores_model->getLugares($grupo_sector);
        
        foreach($lugares as $val) {
            $html .= "<option value='".$val."'>".$val."</option>";
        }
        return $html;
    } 
}

if(!function_exists('cargoRegion')) {
    function cargoRegion() {
        $region = array('-SELECCIONE-');
        array_push($region, "REGION DE LOS LAGOS");
        array_push($region, "REGION DE VALPARAISO");
        array_push($region, "REGION METROPOLITANA");
        return $region;
    } 
}

if(!function_exists('getSector')) {
    function getSector($grupo_sector, $lugar) {
        $CI = get_instance();
        $CI->load->model('alta_valores_model');
        return $CI->alta_valores_model->getSector($grupo_sector, $lugar);
    } 
}