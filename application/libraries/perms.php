<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Description of perms
 *
 * @author sebastianituartebonfrisco
 */

class perms {
    public function verifico() {
        $CI = get_instance();
        $CI->load->library("session");
        
        log_message("debug", print_r($CI->session->userdata(), true));
        
        if(!$CI->session->has_userdata('usuario')) {
            return false;
        }

        if(!$CI->session->has_userdata('ip_addresss')) {
            return false;
        }

        if(!$CI->session->has_userdata('user_agent')) {
            return false;
        }

        if(!$CI->session->has_userdata('is_logged')) {
            return false;
        }     
        
        if($CI->session->userdata('is_logged') != 1) {
            return false;
        }
        
        if($CI->session->userdata('is_logged') == 1) {
            return true;
        }
    }
}
