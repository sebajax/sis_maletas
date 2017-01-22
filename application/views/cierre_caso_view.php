<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre caso</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>.top-buffer { margin-top:20px; }</style>
    
    <script type="text/javascript">
        
        function buscarCierreCaso() {
            var aerolinea = $("#aerolinea").val();
            var numero    = $("#numero").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("cierre_caso/buscarCierreCaso"); ?>",
                data: { aerolinea: aerolinea, numero: numero }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("menu_bdo"); ?>";
        } 
        
        function cargoInformacionExtra(numero, id_aerolinea) {
            $("#informacion_extra_bdo").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("consulta_bdo/cargoInformacionExtra"); ?>",
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
                url: "<?php echo base_url("cierre_caso/ordenarBuscar"); ?>",
                data: { parametro: parametro, ordenamiento: $("#ordenamiento").val() }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("cierre_caso/exportarExcel"); ?>";
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
                url: "<?php echo base_url("cierre_caso/cerrarCaso"); ?>",
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
        
        function cancelarComentario() {
            $('#comentario_bdo').modal('toggle');
        }            
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <legend>Cierre caso B.D.O</legend>
        <form class="form-inline">
          <div class="form-group">
            <label for="aerolinea">Aerolinea</label>
            <?php
            $attributes = 'class = "form-control" id = "aerolinea"';
            echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
            ?>
          </div>
          <div class="form-group">
            <label for="numero">Numero</label>
            <input id="numero" name="numero" placeholder="numero bdo" type="text" class="form-control" />
          </div>
        </form>    
        <div class="row top-buffer"></div>
        <form class="form-inline">    
            <button type="button" class="btn btn-primary" onclick="buscarCierreCaso();">Enviar</button>
            <button type="button" class="btn btn-success" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-info" onclick="printDiv();">Imprimir</button>
            <button type="button" class="btn btn-danger" onclick="irMenu();">Volver</button>
        </form>         
        
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <div id="printDiv">
            <table class="table table-hover">
              <thead>
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
</div>
    
<!-- Modal informacion b.d.o -->
<div id="informacion_bdo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">INFORMACION EXTRA B.D.O</h4>
            </div>
            <div class="modal-body" id="informacion_extra_bdo"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> 

<!-- Agregar comentario modal -->
<div id="comentario_bdo" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cerrar caso BDO</h4>
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
                    <input id="btn_comentario" name="btn_comentario" type="button" class="btn btn-primary" value="Cerrar caso" onclick="cerrarCaso();" />
                    <input id="btn_cancelar" name="btn_cancelar_comentario" type="reset" class="btn btn-danger" value="Cancelar" onclick="cancelarComentario();"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>