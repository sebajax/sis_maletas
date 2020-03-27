<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre caso</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#menu_bdo").addClass("active");
        });        
        
        function buscarCierreCaso() {
            var aerolinea = $("#aerolinea").val();
            var numero    = $("#numero").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("CierreCaso/buscarCierreCaso"); ?>",
                data: { aerolinea: aerolinea, numero: numero }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuBdo"); ?>";
        } 
        
        function cargoInformacionExtra(numero, id_aerolinea) {
            $("#informacion_extra_bdo").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("ConsultaBdo/cargoInformacionExtra"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea }
            }).done(function(data) {
                $("#informacion_extra_bdo").html(data);
                $('#informacion_bdo').modal('show');
            });
        }   
        
        function ordenarBuscar(parametro) {
            ordenamiento();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("CierreCaso/ordenarBuscar"); ?>",
                data: { parametro: parametro, ordenamiento: $("#ordenamiento").val() }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("CierreCaso/exportarExcel"); ?>";
        }  
        
        function cerrarCasoForm(numero, id_aerolinea, nombre_aerolinea) {
            $("#numero_comentario").val(numero);
            $("#id_aerolinea_comentario").val(id_aerolinea);
            $("#nombre_aerolinea_comentario").val(nombre_aerolinea);
            $("#comentario").val("");
            $('#comentario_bdo').modal('show');            
        }
        
        function cerrarCaso() {
            var numero = $("#numero_comentario").val();
            var id_aerolinea = $("#id_aerolinea_comentario").val();
            var comentario = $("#comentario").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("CierreCaso/cerrarCaso"); ?>",
                data: { id_aerolinea: id_aerolinea, numero: numero, comentario: comentario }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Se cierra el caso correctamente", "alert-success");
                    setTimeout(function(){
                        buscarCierreCaso();
                    }, 2000);
                }else {
                    mostrarMensaje("Hubo un problema al procesar su solicitud", "alert-danger");
                }
            });           
        }  
    </script>
    
</head>
<body>
    <div class="p-3 mx-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu B.D.O</li>
                <li class="breadcrumb-item active">Cierre caso B.D.O</li>
            </ol> 
        </nav>          

        <legend>Cierre caso B.D.O</legend>

        <form class="form-inline my-3">
            <label class="my-2 mr-2" for="aerolinea">Aerolinea</label>
            <?php
            $attributes = 'class = "custom-select" id = "aerolinea"';
            echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
            ?>
            <label class="my-2 mr-2 ml-5" for="numero">Numero</label>
            <input id="numero" name="numero" placeholder="numero bdo" type="text" class="form-control" />
        </form>   

        <div class="row top-buffer"></div>
        <form class="form-inline mt-3">    
            <button type="button" class="btn btn-outline-success" onclick="buscarCierreCaso();">Enviar</button>
            <button type="button" class="btn btn-outline-success ml-5" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-outline-success ml-5" onclick="printDiv();">Imprimir</button>
            <button type="button" class="btn btn-outline-success ml-5" onclick="cerrarTodosCasos();">Cerrar Casos</button>
            <button type="button" class="btn btn-outline-danger ml-5" onclick="irMenu();">Volver</button>
        </form>         

        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>         

        <hr />

        <div id="printDiv">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                  <th>#<span id="th_order"></span></th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('numero')">Numero BDO</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('id_aerolinea')">Aerolinea</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('nombre_pasajero')">Pasajero</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('fecha_llegada')">Fecha</th>
                  <th>Info</th>
                  <th>Cerrar</th>
                </tr>
              </thead>
              <tbody id="cuerpo"></tbody>
            </table>
        </div>    
        <input id="ordenamiento" type="hidden" value=""/>
    </div>

    
    <!-- Modal informacion b.d.o -->
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
    </div> 

    <!-- Agregar comentario modal -->
    <div id="comentario_bdo" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cerrar Caso BDO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="comentario_bdo_form">
                    <form>
                        <div class="form-group">
                            <label for="numero_comentario" class="control-label">Numero</label>
                            <input id="numero_comentario" disabled= "disabled" name="numero_comentario" placeholder="numero bdo" type="text" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="nombre_aerolinea_comentario" class="control-label">Aerolinea</label>
                            <input id="nombre_aerolinea_comentario" disabled= "disabled" name="nombre_aerolinea_comentario" placeholder="aerolinea" type="text" class="form-control"/>
                            <input id="id_aerolinea_comentario" disabled= "disabled" name="id_aerolinea_comentario" placeholder="aerolinea" type="hidden" class="form-control"/>
                        </div>                    
                        <div class="form-group">
                            <label for="comentario" class="control-label">Comentario</label>
                            <textarea class="form-control noresize" rows="8" id="comentario" placeholder="comentario"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input id="btn_comentario" name="btn_comentario" type="button" class="btn btn-primary" value="Confirmar" onclick="cerrarCaso();" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>