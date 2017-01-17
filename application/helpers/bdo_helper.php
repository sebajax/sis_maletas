<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('cargoInformacionExtra')) {
    function cargoInformacionExtra($numero, $id_aerolinea) {
        $CI = get_instance();
        $CI->load->model('consulta_bdo_model');   
        
        $result = $CI->consulta_bdo_model->cargoInformacionExtra($numero, $id_aerolinea);
        
        $table = '<table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Numero B.D.O</td>
                            <td>'.$numero.'</td>
                        </tr>
                        <tr>
                            <td>Nombre Pasajero</td>
                            <td>'.$result->nombre_pasajero.'</td>
                        </tr>
                        <tr>
                            <td>Aerolinea</td>
                            <td>'.$result->nombre_aerolinea.'</td>
                        </tr>
                        <tr>
                            <td>Telefono</td>
                            <td>'.$result->telefono.'</td>
                        </tr>
                        <tr>
                            <td>Comuna</td>
                            <td>'.$result->domicilio_comuna.'</td>
                        </tr>
                        <tr>
                            <td>Direccion</td>
                            <td>'.$result->domicilio_direccion.'</td>
                        </tr>
                        <tr>
                            <td>Region</td>
                            <td>'.$result->domicilio_region.'</td>
                        </tr>
                        <tr>
                            <td>Sector</td>
                            <td>'.$result->grupo_sector.'</td>
                        </tr>
                        <tr>
                            <td>Nombre sector</td>
                            <td>'.$result->lugar.'</td>
                        </tr>                    
                    </tbody>   
                </table>';  
        
        echo $table;
    }     
}


