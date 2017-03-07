<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Login
 *
 * @author sebastian.ituarte@gmail.com
 */

class Login extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library(array('validation', 'session', 'user_agent'));
    }
    
    function index() {
        $this->session->sess_destroy();
        $this->load->view('Login_view');
    }
    
    public function intentoLogin() {
        $this->session->set_userdata('is_logged', 0);
        $mensaje = "ERROR";
        $usuario = array(
            "ip_address" => $this->input->ip_address(),
            "user_agent"  => $this->agent->agent_string(),
            "usuario"     => $this->input->post('usuario'),
            "clave"       => $this->input->post('clave'),
        );
        if($this->Login_model->validate($usuario) == 1) {
            $this->session->set_userdata('is_logged', 1);
            $mensaje = "OK";
        }
        $this->session->set_userdata('ip_address', $this->input->ip_address());
        $this->session->set_userdata('user_agent', $this->agent->agent_string());
        $this->session->set_userdata('usuario', $this->input->post('usuario'));
        log_message("debug", print_r($this->session->userdata(), true));
        echo $mensaje;
    }
}
