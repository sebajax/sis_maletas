<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('cargoTipoGasto')) {
    function cargoTipoGasto() {
        $CI = get_instance();
        $CI->load->model('AltaTipoGasto_model');
        return $CI->AltaTipoGasto_model->getTipoGasto();
    } 
}