<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('cargoAerolinea')) {
    function cargoAerolinea() {
        $CI = get_instance();
        $CI->load->model('alta_valores_model');    
        return $CI->alta_valores_model->getAerolineas();
    } 
}