<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre caso</title>
    <?php require_once "assets/header/header.php"; ?>
    
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
        
        function cerrarCaso(numero, id_aerolinea) {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("cierre_caso/cerrarCaso"); ?>",
                data: { id_aerolinea: id_aerolinea, numero: numero }
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
            <button type="button" class="btn btn-primary" onclick="buscarCierreCaso();">Enviar</button>
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
              <th>Fecha</th>
              <th>Info</th>
              <th>Cerrar</th>
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