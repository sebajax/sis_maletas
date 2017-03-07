<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta aerolinea</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        function altaAerolinea() {
            $("span.text-danger").html('');
            
            var aerolinea = $("#aerolinea").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!aerolinea) {
                $("#aerolinea_error").html(manejoMensajes("vacio", "aerolinea"));
                $("#aerolinea").focus();
                return false;
            }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaAerolinea/altaAerolinea"); ?>",
                data: { aerolinea: aerolinea }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
                    resetearFormulario();
                }else {
                    mostrarMensaje("Datos erroneos favor verifique.", "alert-danger");
                }
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuAerolinea"); ?>";
        }        
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuAerolinea"); ?>">Menu Aerolinea</a></li>
            <li class="active">Alta aerolinea</li>
        </ol>          
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Alta aerolinea</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "altaaerolineaform", "name" => "altaaerolineaform");
        echo form_open("AltaAerolinea/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="aerolinea" class="control-label">Aerolinea</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="aerolinea" name="aerolinea" placeholder="nombre aerolinea" type="text" class="form-control" />
                        <span id='aerolinea_error' class="text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Alta aerolinea" onclick="altaAerolinea();" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" />
                <input id="btn_volver" name="btn_volver" type="button" class="btn btn-primary" value="Volver" onclick="irMenu();" />
            </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>