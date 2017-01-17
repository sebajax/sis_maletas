<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta B.D.O</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        //load datepicker control onfocus
        $(function() {
            $("#fecha_desde").datepicker();
            $("#fecha_hasta").datepicker();
        });

        function buscarBdo() {
            var aerolinea    = $("#aerolinea").val();
            var numero       = $("#numero").val();
            var pasajero     = $("#pasajero").val();
            var fecha_desde  = $("#fecha_desde").val();
            var fecha_hasta  = $("#fecha_hasta").val();
            var grupo_sector = $("#grupo_sector").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/consulta_bdo/buscarBdo"); ?>",
                data: { aerolinea: aerolinea, numero: numero, pasajero: pasajero, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function cargoInformacionExtra(numero, id_aerolinea) {
            $("#informacion_extra_bdo").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/consulta_bdo/cargoInformacionExtra"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea }
            }).done(function(data) {
                $("#informacion_extra_bdo").html(data);
                $('#informacion_bdo').modal('show');
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("index.php/menu_bdo"); ?>";
        } 
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <legend>Consulta B.D.O</legend>
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
          <div class="form-group">
            <label for="pasajero">Pasajero</label>
            <input id="pasajero" name="pasajero" placeholder="nombre pasajero" type="text" class="form-control" />
          </div>            
        </form> 
        <div class="row top-buffer"></div>
        <form class="form-inline">
            <div class="form-group">
                <label for="fecha_desde">Fecha desde</label>
                <input id="fecha_desde" name="fecha_desde" placeholder="fecha llegada desde" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <label for="fecha_hasta">Fecha hasta</label>
                <input id="fecha_hasta" name="fecha_hasta" placeholder="fecha llegada hasta" type="text" class="form-control" />
            </div>            
            <div class="form-group">
                <label for="grupo_sector">Grupo sector</label>
                <?php
                $attributes = 'class = "form-control" id = "grupo_sector"';
                echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                ?>
            </div>    
            <button type="button" class="btn btn-primary" onclick="buscarBdo();">Enviar</button>
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
              <th>Numero BDO</th>
              <th>Aerolinea</th>
              <th>Pasajero</th>
              <th>Maletas</th>
              <th>Valor</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th>Info</th>
            </tr>
          </thead>
          <tbody id="cuerpo">

          </tbody>
        </table>
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
</body>
</html>