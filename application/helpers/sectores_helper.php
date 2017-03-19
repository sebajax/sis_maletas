<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('cargoSector')) {
    function cargoSector() {
        $CI = get_instance();
        $CI->load->model('CantidadSectores_model');    
        $cantidad = $CI->CantidadSectores_model->cantidadActual();
        $sector = array('-SELECCIONE-');
        for($i=0; $i < $cantidad; $i++) {
            array_push($sector, ($i+1));
        }
        return $sector;
    } 
}

if(!function_exists('cargoLugares')) {
    function cargoLugares($grupo_sector) {
        $CI = get_instance();
        $CI->load->model('AltaValores_model');
        
        $html = "<option> </option>";
        
        if(empty($grupo_sector)) {
            return $html;
        }
        
        $lugares = $CI->AltaValores_model->getLugares($grupo_sector);
        
        foreach($lugares as $val) {
            $html .= "<option value='".$val."'>".$val."</option>";
        }
        return $html;
    } 
}

if(!function_exists('cargoRegion')) {
    function cargoRegion() {
        $region = array();
        $region[0] = "-SELECCIONE-";
        $region[1] = "XV - Arica y Parinacota";
        $region[2] = "I - Tarapaca";
        $region[3] = "II - Antofagasta";
        $region[4] = "III - Atacama";
        $region[5] = "IV - Coquimbo";
        $region[6] = "V - Valparaiso";
        $region[7] = "RM - Metropolitana de Santiago";
        $region[8] = "VI - Libertador General Bernardo OHiggins";
        $region[9] = "VII - Maule";
        $region[10] = "VIII - Biobio";
        $region[11] = "IX - La Araucania";
        $region[12] = "XIV - Los Rios";
        $region[13] = "X - Los Lagos";
        $region[14] = "XI - Aisen del General Carlos Ibañez del Campo";
        $region[15] = "XII - Magallanes y de la Antartica Chilena";
        return $region;
    } 
}

if(!function_exists('regionTransform')) {
    function regionTransform($codigoRegion) {
        switch ($codigoRegion) {
            case 1:
                $codigoRegion = "XV - Arica y Parinacota";
                break;
            case 2:
                $codigoRegion = "I - Tarapaca";
                break;
            case 3:
                $codigoRegion = "II - Antofagasta";
                break;
            case 4:
                $codigoRegion = "III - Atacama";
                break;
            case 5:
                $codigoRegion = "IV - Coquimbo";
                break;
            case 6:
                $codigoRegion = "V - Valparaiso";
                break;
            case 7:
                $codigoRegion = "RM - Metropolitana de Santiago";
                break;
            case 8:
                $codigoRegion = "VI - Libertador General Bernardo OHiggins";
                break;
            case 9:
                $codigoRegion = "VII - Maule";
                break;
            case 10:
                $codigoRegion = "VIII - Biobio";
                break;
            case 11: 
                $codigoRegion = "IX - La Araucania";
                break;
            case 12:
                $codigoRegion = "XIV - Los Rios";
                break;
            case 13:
                $codigoRegion = "X - Los Lagos";
                break;
            case 14:
                $codigoRegion = "XI - Aisen del General Carlos Ibañez del Campo";
                break;
            case 15:
                $codigoRegion = "XII - Magallanes y de la Antartica Chilena";
                break;                
        }
        return $codigoRegion;
    } 
}

if(!function_exists('getSector')) {
    function getSector($grupo_sector, $lugar) {
        $CI = get_instance();
        $CI->load->model('AltaValores_model');
        return $CI->AltaValores_model->getSector($grupo_sector, $lugar);
    } 
}