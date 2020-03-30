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
                <table class="table table-bordered table-light">
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
                            <td class="table-primary">Numero B.D.O</td>
                            <td>'.$numero.'</td>
                        </tr>
                        <tr>
                            <td class="table-primary">Nombre Pasajero</td>
                            <td>'.$result->nombre_pasajero.'</td>
                        </tr>
                        <tr>
                            <td class="table-primary">Aerolinea</td>
                            <td>'.$result->nombre_aerolinea.'</td>
                        </tr>
                        <tr>
                            <td class="table-primary">Telefono</td>
                            <td>'.$result->telefono.'</td>
                        </tr>
                        <tr>
                            <td class="table-primary">Direccion</td>
                            <td>'.$result->domicilio_direccion.'</td>
                        </tr>
                        <tr>
                            <td class="table-primary">Region</td>
                            <td>'.regionTransform($result->domicilio_region).'</td>
                        </tr>
                        <tr>
                            <td class="table-primary">Sector</td>
                            <td>'.$result->grupo_sector.'</td>
                        </tr>
                        <tr>
                            <td class="table-primary">Nombre sector</td>
                            <td>'.$result->lugar.'</td>
                        </tr>  
                        </tr>
                        <tr>
                            <td class="table-primary">Valor</td>
                            <td>'.$result->valor.'</td>
                        </tr>                         
                        <tr>
                            <td class="table-primary">Fecha cierre</td>
                            <td>'.$result->fecha_modif_estado.'</td>
                        </tr>                        
                    </tbody>   
                </table>';
        
        echo $table.'<hr /> <div class="p-3 mb-2 bg-primary text-white"><label> Comentarios </label></div>'.$table_comments;
    }     

    if(!function_exists('cargoModalInformacionExtra')) {    
        function cargoModalInformacionExtra() {
            return '
                <div id="informacion_bdo" class="modal fade" role="dialog">
                    <div class="modal-dialog" role="document">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">INFORMACION EXTRA B.D.O</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body" id="informacion_extra_bdo"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>';             
        }
    }
}


