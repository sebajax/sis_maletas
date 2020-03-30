<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('cargoAerolinea')) {
    function cargoAerolinea() {
        $CI = get_instance();
        $CI->load->model('AltaValores_model');    
        return $CI->AltaValores_model->getAerolineas();
    }
}