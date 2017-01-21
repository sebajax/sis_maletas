<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Valores</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
       
        function buscarValor() {
            var aerolinea    = $("#aerolinea").val();
            var grupo_sector = $("#grupo_sector").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("eliminar_modificar_valor/buscarValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function modificarValorForm(id_aerolinea, grupo_sector) {
            $("#modificar_valor_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("eliminar_modificar_valor/modificarValorForm"); ?>",
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
                url: "<?php echo base_url("eliminar_modificar_valor/modificarValor"); ?>",
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
                url: "<?php echo base_url("eliminar_modificar_valor/eliminarValor"); ?>",
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
        
        function irMenu() {
            window.location.href = "<?php echo base_url("menu_valor"); ?>";
        } 
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <legend>Eliminar Modificar Valores</legend>
        <form class="form-inline">
            <div class="form-group">
                <label for="aerolinea">Aerolinea</label>
                <?php
                $attributes = 'class = "form-control" id = "aerolinea"';
                echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                ?>
            </div>
            <div class="form-group">
                <label for="grupo_sector">Grupo sector</label>
                <?php
                $attributes = 'class = "form-control" id = "grupo_sector"';
                echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                ?>
            </div>             
            <button type="button" class="btn btn-primary" onclick="buscarValor();">Enviar</button>
            <button type="button" class="btn btn-danger" onclick="irMenu();">Volver</button>           
        </form> 
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Aerolinea</th>
              <th>Grupo sector</th>
              <th>Valor</th>
              <th>Modif</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody id="cuerpo">

          </tbody>
        </table>
    </div>
</div>

<!-- Modal modificar aerolinea -->
<div id="modificar_valor" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">MODIFICAR VALOR</h4>
            </div>
            <div class="modal-body" id="modificar_valor_form"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


</body>
</html>