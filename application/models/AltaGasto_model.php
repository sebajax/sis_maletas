<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaGasto_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaGasto_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        $this->db->insert("gastos", $data);
    }
}
