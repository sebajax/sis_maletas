<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of IngresoCajaSimulado_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class IngresoCajaSimulado_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
}
