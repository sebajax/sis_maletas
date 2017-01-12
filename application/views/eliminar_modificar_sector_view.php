<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Sectores</title>
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

        function buscarSector() {
            var lugar        = $("#lugar").val();
            var grupo_sector = $("#grupo_sector").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_sector/buscarSector"); ?>",
                data: { lugar: lugar, grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function modificarSectorForm(id_sector) {
            $("#modificar_sector_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_sector/modificarSectorForm"); ?>",
                data: { id_sector: id_sector }
            }).done(function(data) {
                $("#modificar_sector_form").html(data);
                $('#modificar_sector').modal('show');
            });
        }
        
        function modificarSector(id_sector) {
        
            var grupo_sector_new = $("#grupo_sector_new").val();
            var lugar_new        = $("#lugar_new").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/eliminar_modificar_sector/modificarSector"); ?>",
                data: { id_sector: id_sector, grupo_sector_new: grupo_sector_new, lugar_new: lugar_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: el sector fue modificado correctamente", "alert-success");
                    buscarSector();
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar el sector.", "alert-danger");
                }
            });            
        }
        
        function cancelarModificarSector() {
            $('#modificar_sector').modal('toggle');
        }
        
        function eliminarSector(id_sector) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("index.php/eliminar_modificar_sector/eliminarSector"); ?>",
                data: { id_sector: id_sector }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    buscarSector();
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }            
        
        function irMenu() {
            window.location.href = "<?php echo base_url("index.php/menu_sector"); ?>";
        } 
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <legend>Eliminar Modificar Sectores</legend>
        <form class="form-inline">
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
            <button type="button" class="btn btn-primary" onclick="buscarSector();">Enviar</button>
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
              <th>Grupo</th>
              <th>Lugar</th>
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
<div id="modificar_sector" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">MODIFICAR SECTOR</h4>
            </div>
            <div class="modal-body" id="modificar_sector_form"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>