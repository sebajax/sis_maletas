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
        array_push($region, "XV - Arica y Parinacota");
        array_push($region, "I - Tarapaca");
        array_push($region, "II - Antofagasta");
        array_push($region, "III - Atacama");
        array_push($region, "IV - Coquimbo");
        array_push($region, "V - Valparaiso");
        array_push($region, "RM - Metropolitana de Santiago");
        array_push($region, "VI - Libertador General Bernardo OHiggins");
        array_push($region, "VII - Maule");
        array_push($region, "VIII - Biobio");
        array_push($region, "IX - La Araucania");
        array_push($region, "XIV - Los Rios");
        array_push($region, "X - Los Lagos");
        array_push($region, "XI - Aisen del General Carlos Ibañez del Campo");
        array_push($region, "XII - Magallanes y de la Antartica Chilena");
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