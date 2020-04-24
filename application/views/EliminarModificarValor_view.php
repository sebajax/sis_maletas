<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Valores</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#menu_valor").addClass("active");
            $("#imagen_principal").remove();
        });           
       
        function buscarValor() {
            var aerolinea    = $("#aerolinea").val();
            var grupo_sector = $("#grupo_sector").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarValor/buscarValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function modificarValorForm(id_aerolinea, grupo_sector) {
            $("#modificar_valor_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarValor/modificarValorForm"); ?>",
                data: { id_aerolinea: id_aerolinea, grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#modificar_valor_form").html(data);
                $('#modificar_valor').modal('show');
            });
        }
        
        function modificarValor(id_aerolinea, grupo_sector) {
            var valor_new = $("#valor_new").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarValor/modificarValor"); ?>",
                data: { id_aerolinea: id_aerolinea, grupo_sector: grupo_sector, valor_new: valor_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: el valor fue modificado correctamente.", "alert-success");
                    buscarValor();
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar el valor.", "alert-danger");
                }
            });            
        }
        
        function cancelarModificarValor() {
            $('#modificar_valor').modal('toggle');
        }
        
        function eliminarValor(id_aerolinea, grupo_sector) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarValor/eliminarValor"); ?>",
                data: { id_aerolinea: id_aerolinea, grupo_sector: grupo_sector }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    buscarValor();
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }       
        
        function cofirmaEliminar(id_aerolinea, grupo_sector) {
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#delete', function () {
                    eliminarValor(id_aerolinea, grupo_sector);
            });        
        }        
    </script>
    
</head>
<body>
    
    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu Valor</li>
                <li class="breadcrumb-item active">Eliminar Modificar Valores</li>
            </ol> 
        </nav>         
        
        <legend>Eliminar Modificar Valores</legend>
        
        <form class="my-3">
            
            <div class="form-row">
                <div class="form-group col-2">
                    <?php
                    $attributes = 'class="custom-select" id="aerolinea" aria-label="aerolinea" aria-describedby="aerolinea_addon"';
                    echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                    ?>
                </div>
                
                <div class="form-group col-2 ml-5">
                    <?php
                    $attributes = 'class="custom-select" id="grupo_sector" aria-label="grupo_sector" aria-describedby="grupo_sector_addon"';
                    echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                    ?>
                </div>
            </div>
            
        </form>        
        
        <form class="form-inline mt-3">
            <button type="button" class="btn btn-outline-success col-2" onclick="buscarValor()" id="btnenviar">Enviar</button>
            <button type="button" class="btn btn-outline-success col-2 ml-5" onclick="printDiv()" id="btnenviar">Imprimir</button>
        </form>        
        
        <div class="form-group mt-2">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />        
        
        <div id="printDiv">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Aerolinea</th>
                        <th>Grupo sector</th>
                        <th>Valor</th>
                        <th>Modif</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody id="cuerpo"></tbody>
            </table>
        </div>         
           
    </div>    

    <!-- Modal modificar aerolinea -->
    <div id="modificar_valor" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">MODIFICAR VALOR</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="modificar_valor_form"></div>
            </div>
        </div>
    </div>

    <div id="confirm" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                   ¿ Seguro quieres eliminar el registro ?
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">ELIMINAR</button>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>   
        </div>    
    </div>

</body>
</html>