<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Aerolineas</title>
    <?php require_once "assets/header/header.php"; ?> 
    
    <script type="text/javascript">
        function buscarAerolinea() {
            var aerolinea = $("#aerolinea").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("eliminar_modificar_aerolinea/buscarAerolinea"); ?>",
                data: { aerolinea: aerolinea }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }

        function ordenarBuscar(parametro) {
            ordenamiento();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("eliminar_modificar_aerolinea/ordenarBuscar"); ?>",
                data: { parametro: parametro, ordenamiento: $("#ordenamiento").val() }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }

        function modificarAerolineaForm(id_aerolinea) {
            $("#modificar_aerolinea_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("eliminar_modificar_aerolinea/modificarAerolineaForm"); ?>",
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
                url: "<?php echo base_url("eliminar_modificar_aerolinea/modificarAerolinea"); ?>",
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
                url: "<?php echo base_url("eliminar_modificar_aerolinea/eliminarAerolinea"); ?>",
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
        
        function irMenu() {
            window.location.href = "<?php echo base_url("menu_aerolinea"); ?>";
        } 
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("eliminar_modificar_aerolinea/exportarExcel"); ?>";
        }
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <legend>Eliminar Modificar Aerolineas</legend>
        <form class="form-inline">
            <div class="form-group">
                <label for="aerolinea">Aerolinea</label>
                <?php
                $attributes = 'class = "form-control" id = "aerolinea"';
                echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                ?>
            </div>
            <button type="button" class="btn btn-primary" onclick="buscarAerolinea();">Enviar</button>
            <button type="button" class="btn btn-success" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-danger" onclick="irMenu();">Volver</button>
        </form>         
        
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#<span id="th_order"></span></th>
              <th style="cursor: pointer;" onclick="ordenarBuscar('id_aerolinea')">Id</th>
              <th style="cursor: pointer;" onclick="ordenarBuscar('nombre_aerolinea')">Aerolinea</th>
              <th>Modif</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody id="cuerpo">
          </tbody>
        </table>
        <input id="ordenamiento" type="hidden" value=""/>
    </div>
</div>

<!-- Modal modificar aerolinea -->
<div id="modificar_aerolinea" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">MODIFICAR AEROLINEA</h4>
            </div>
            <div class="modal-body" id="modificar_aerolinea_form"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>