<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Description of funciones
 *
 * @author sebastianituartebonfrisco
 */
class funciones {
    
    /*
     * $on: el parametro que deseamos ordenar por
     * $order: SORT_DESC, SORT_ASC
     */
    public function array_sort($array, $on, $order) {
        $order = $this->mapSort($order);
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
    
    private function mapSort($sort) {
        if(empty($sort)) {
            $sort = SORT_ASC;
        }else if($sort == "SORT_ASC") {
            $sort = SORT_ASC;
        }else if($sort == "SORT_DESC") {
            $sort = SORT_DESC;
        }else {
            $sort = SORT_ASC;
        }
        return $sort;
    }

    public function objectToArray($object) {
        return json_decode(json_encode($object), true);
    }    
}