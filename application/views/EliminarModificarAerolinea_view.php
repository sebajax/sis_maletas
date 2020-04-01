<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Aerolineas</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#menu_aerolinea").addClass("active");
            $("#imagen_principal").remove();
        });    
        
        function buscarAerolinea() {
            var aerolinea = $("#aerolinea").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarAerolinea/buscarAerolinea"); ?>",
                data: { aerolinea: aerolinea }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }

        function ordenarBuscar(parametro) {
            ordenamiento();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarAerolinea/ordenarBuscar"); ?>",
                data: { parametro: parametro, ordenamiento: $("#ordenamiento").val() }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }

        function modificarAerolineaForm(id_aerolinea) {
            $("#modificar_aerolinea_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarAerolinea/modificarAerolineaForm"); ?>",
                data: { id_aerolinea: id_aerolinea }
            }).done(function(data) {
                $("#modificar_aerolinea_form").html(data);
                $('#modificar_aerolinea').modal('show');
            });
        }
        
        function modificarAerolinea(id_aerolinea) {
            var nombre_aerolinea_new = $("#aerolinea_modificada").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarAerolinea/modificarAerolinea"); ?>",
                data: { id_aerolinea: id_aerolinea, nombre_aerolinea_new: nombre_aerolinea_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: el nombre de la aerolinea fue modificado correctamente.", "alert-success");
                    buscarAerolinea();
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar la aerolinea.", "alert-danger");
                }
            });            
        }
        
        function cancelarModificarAerolinea() {
            $('#modificar_aerolinea').modal('toggle');
        }
        
        function eliminarAerolinea(id_aerolinea) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarAerolinea/eliminarAerolinea"); ?>",
                data: { id_aerolinea: id_aerolinea }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    buscarAerolinea();
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }        
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("EliminarModificarAerolinea/exportarExcel"); ?>";
        }
        
        function cofirmaEliminar(id_aerolinea) {
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#delete', function () {
                    eliminarAerolinea(id_aerolinea);
            });        
        }
    </script>
    
</head>
<body>
    
    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu Aerolinea</li>
                <li class="breadcrumb-item active">Eliminar Modificar Aerolineas</li>
            </ol> 
        </nav>         
        
        <legend>Eliminar Modificar Aerolineas</legend>
        
        <form class="my-3">
            
            <div class="form-row">
                <div class="form-group col-2">
                    <?php
                    $attributes = 'class="custom-select" id="aerolinea" aria-label="aerolinea" aria-describedby="aerolinea_addon"';
                    echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                    ?>
                </div>
            </div>
            
        </form>
        
        <form class="form-inline mt-3">
            <button type="button" class="btn btn-outline-success col-2" onclick="buscarAerolinea()" id="btnenviar">Enviar</button>
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
                  <th style="cursor: pointer;" onclick="ordenarBuscar('id_aerolinea')">Id</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('nombre_aerolinea')">Aerolinea</th>
                  <th>Modif</th>
                  <th>Eliminar</th>
                </tr>
              </thead>
              <tbody id="cuerpo">
              </tbody>
            </table>
        </div>    
        <input id="ordenamiento" type="hidden" value=""/>        
        
    </div>   
    
    <!-- Modal modificar aerolinea -->
    <div id="modificar_aerolinea" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">MODIFICAR AEROLINEA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="modificar_aerolinea_form"></div>
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