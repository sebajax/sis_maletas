<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Description of validation
 *
 * @author Sebas
 */
class validation {

    function validateEmpty($data) {
        foreach($data as $val) {
            if(empty($val)) {
                return false;
            }
        }
        return true;
    }
    
    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }    
    
}
