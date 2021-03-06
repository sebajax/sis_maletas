<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of CantidadSectores
 *
 * @author sebastian.ituarte@gmail.com
 */
class CantidadSectores extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('CantidadSectores_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
        if(!$this->perms->verificoPerfil(2)) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data['cantidad'] = $this->CantidadSectores_model->cantidadActual();
        $this->load->view('CantidadSectores_view', $data);
    }
    
    function cantidadSectores() {
        $data = array(
            "cantidad" => $this->input->post('cantidad'),
        );
        $errorEmpty = false;
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if(!$errorEmpty ) {
            $this->CantidadSectores_model->update($data);
            $this->Auditoria_model->insert($data, "update", "cantidad_sectores", $this->db->last_query());
            echo "OK";    
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
}
