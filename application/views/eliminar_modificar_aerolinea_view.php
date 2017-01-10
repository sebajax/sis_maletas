<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Aerolineas</title>
    <!-- link jquery ui css-->
    <link href="<?php echo base_url('assets/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!--link the bootstrap css file-->
    <link href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>" rel="stylesheet" type="text/css" />
    <!--load functions js file-->
    <script src="<?php echo base_url('assets/js/functions.js'); ?>"></script>       
    <!--include jquery library-->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <!--include bootstrap library-->
    <script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"</script>
    <!--load jquery ui js file-->
    <script src="<?php echo base_url('assets/jquery-ui/jquery-ui.min.js'); ?>"></script>    
    
    <style type="text/css">
        .colbox {
            margin-left: 0px;
            margin-right: 0px;
        }
        .noresize {
            resize: none; 
        } 
        .top-buffer { margin-top:10px; }
        
    </style>
    
    <script type="text/javascript">
        function buscarAerolinea() {
            var aerolinea = $("#aerolinea").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_aerolinea/buscarAerolinea"); ?>",
                data: { aerolinea: aerolinea }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function modificarAerolineaForm(id_aerolinea) {
            $("#modificar_aerolinea_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_aerolinea/modificarAerolineaForm"); ?>",
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
                url: "<?php echo base_url("index.php/eliminar_modificar_aerolinea/modificarAerolinea"); ?>",
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
                url: "<?php echo base_url("index.php/eliminar_modificar_aerolinea/eliminarAerolinea"); ?>",
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
            window.location.href = "<?php echo base_url("index.php/menu_aerolinea"); ?>";
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
              <th>Id</th>
              <th>Aerolinea</th>
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