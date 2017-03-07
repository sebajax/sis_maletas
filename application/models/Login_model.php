<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Login_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class Login_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function insertLogin($usuario) {
        $data = array(
            'usuario'    => $usuario['usuario'],
            'ip_address' => $usuario['ip_address'],
            'user_agent' => $usuario['user_agent'],
            'intento'    => $usuario['intento']
        );
        $this->db->insert('login', $data);
    }
    
    public function validate($usuario) {
        $where = array('usuario' => $usuario['usuario'], 'clave' => sha1($usuario['clave']));
        $this->db->trans_start();
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where($where);
        if($this->db->count_all_results() == 1) {
            $usuario['intento'] = 1;
        }else {
            $usuario['intento'] = 0;
        }
        $this->insertLogin($usuario);
        $this->db->trans_complete();
        return $usuario['intento'];
    }     
    
}
