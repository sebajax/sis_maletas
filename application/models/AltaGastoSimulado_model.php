<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AltaGastoSimulado_model
 *
 * @author sebastian.ituarte@gmail.com
 */
class AltaGastoSimulado_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
}
