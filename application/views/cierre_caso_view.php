<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre caso</title>
    <!--link the bootstrap css file-->
    <link href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>" rel="stylesheet" type="text/css" />
    <!--load functions js file-->
    <script src="<?php echo base_url('assets/js/functions.js'); ?>"></script>   
    <!--include jquery library-->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <!--include bootstrap library-->
    <script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"</script>
    
    <style type="text/css">
        .colbox {
            margin-left: 0px;
            margin-right: 0px;
        }
        .noresize {
            resize: none; 
        } 
        .top-buffer { margin-top:30px; }
    </style>
    
    <script type="text/javascript">
        
        function buscarCierreCaso() {
            var aerolinea = $("#aerolinea").val();
            var numero    = $("#numero").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/cierre_caso/buscarCierreCaso"); ?>",
                data: { aerolinea: aerolinea, numero: numero }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function cargoInformacion() {
           
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("index.php/menu_bdo"); ?>";
        } 
        
        function cerrarCaso(numero, id_aerolinea) {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/cierre_caso/cerrarCaso"); ?>",
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
</body>
</html>