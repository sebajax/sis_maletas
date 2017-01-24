<?php
/**
 * Description of alta_aerolinea
 *
 * @author Sebas
 */

class login extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library(array('validation', 'session', 'user_agent'));
    }
    
    function index() {
        $this->session->sess_destroy();
        $this->load->view('login_view');
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
        if($this->login_model->validate($usuario) == 1) {
            $this->session->set_userdata('is_logged', 1);
            $mensaje = "OK";
        }
        $this->session->set_userdata('ip_addresss', $this->input->ip_address());
        $this->session->set_userdata('user_agent', $this->agent->agent_string());
        $this->session->set_userdata('usuario', $this->input->post('usuario'));
        log_message("debug", print_r($this->session->userdata(), true));
        echo $mensaje;
    }
}
