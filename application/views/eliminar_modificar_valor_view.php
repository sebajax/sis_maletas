<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Valores</title>
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
       
        function buscarValor() {
            var aerolinea    = $("#aerolinea").val();
            var grupo_sector = $("#grupo_sector").val();
            var lugar        = $("#lugar").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_valor/buscarValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector, lugar: lugar }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function modificarValorForm(id_aerolinea, id_sector) {
            $("#modificar_valor_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_valor/modificarValorForm"); ?>",
                data: { id_aerolinea: id_aerolinea, id_sector: id_sector }
            }).done(function(data) {
                $("#modificar_valor_form").html(data);
                $('#modificar_valor').modal('show');
            });
        }
        
        function modificarValor(id_aerolinea, id_sector) {
            var valor_new = $("#valor_new").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_valor/modificarValor"); ?>",
                data: { id_aerolinea: id_aerolinea, id_sector: id_sector, valor_new: valor_new }
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
        
        function eliminarValor(id_aerolinea, id_sector) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("index.php/eliminar_modificar_valor/eliminarValor"); ?>",
                data: { id_aerolinea: id_aerolinea, id_sector: id_sector }
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
            window.location.href = "<?php echo base_url("index.php/menu_valor"); ?>";
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
            <div class="form-group">
                <label for="lugar">Lugar</label>
                <input id="lugar" name="lugar" placeholder="nombre del lugar" type="text" class="form-control" />
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
              <th>Lugar</th>
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