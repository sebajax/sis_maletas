<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Description of Perms
 *
 * @author sebastian.ituarte@gmail.com
 */
class Perms {
    public function verifico() {
        $CI = get_instance();
        $CI->load->library("session");
        
        if(!$CI->session->has_userdata('usuario')) {
            $CI->session->sess_destroy();
            return false;
        }

        if(!$CI->session->has_userdata('ip_address')) {
            $CI->session->sess_destroy();
            return false;
        }

        if(!$CI->session->has_userdata('user_agent')) {
            $CI->session->sess_destroy();
            return false;
        }

        if(!$CI->session->has_userdata('is_logged')) {
            $CI->session->sess_destroy();
            return false;
        }     
        
        if($CI->session->userdata('is_logged') != 1) {
            $CI->session->sess_destroy();
            return false;
        }
        
        if($CI->session->userdata('is_logged') == 1) {
            return true;
        }
    }
}
