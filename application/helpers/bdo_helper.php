<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('cargoInformacionExtra')) {
    function cargoInformacionExtra($numero, $id_aerolinea) {
        $CI = get_instance();
        $CI->load->model('ConsultaBdo_model');   
        $table_comments = "";
        
        $result = $CI->ConsultaBdo_model->cargoInformacionExtra($numero, $id_aerolinea);
        
        if(!$result) {
            echo "";
            return false;
        }
        
        $result_coments = $CI->ConsultaBdo_model->cargoComentarios($numero, $id_aerolinea);
        
        foreach ($result_coments as $row) {
            $table_comments .= '
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Fecha</td>
                            <td>'.$row->fecha.'</td>
                        </tr>
                        <tr>
                            <td>Usuario</td>
                            <td>'.$row->usuario.'</td>
                        </tr>
                        <tr>
                            <td>Comentario</td>
                            <td>'.$row->comentario.'</td>
                        </tr>
                    </tbody>        
                </table>';
        }
        
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
                            <td>Direccion</td>
                            <td>'.$result->domicilio_direccion.'</td>
                        </tr>
                        <tr>
                            <td>Region</td>
                            <td>'.regionTransform($result->domicilio_region).'</td>
                        </tr>
                        <tr>
                            <td>Sector</td>
                            <td>'.$result->grupo_sector.'</td>
                        </tr>
                        <tr>
                            <td>Nombre sector</td>
                            <td>'.$result->lugar.'</td>
                        </tr>  
                        </tr>
                        <tr>
                            <td>Valor</td>
                            <td>'.$result->valor.'</td>
                        </tr>                         
                        <tr>
                            <td>Fecha cierre</td>
                            <td>'.$result->fecha_modif_estado.'</td>
                        </tr>                        
                    </tbody>   
                </table>';
        
        echo $table.'<hr /> <label> Comentarios </label>'.$table_comments;
    }     
}


