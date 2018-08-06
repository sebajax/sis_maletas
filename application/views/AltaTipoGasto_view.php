<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta tipo gasto</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        function altaTipoGasto() {
            $("span.text-danger").html('');
            
            var tipo_gasto = $("#tipo_gasto").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!tipo_gasto) {
                $("#tipo_gasto_error").html(manejoMensajes("vacio", "aerolinea"));
                $("#tipo_gasto").focus();
                return false;
            }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaTipoGasto/altaTipoGasto"); ?>",
                data: { tipo_gasto: tipo_gasto }
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
            window.location.href = "<?php echo base_url("MenuGasto"); ?>";
        }        
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuAerolinea"); ?>">Menu Gastos</a></li>
            <li class="active">Alta tipo gasto</li>
        </ol>          
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Alta tipo gasto</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "altatipogastoform", "name" => "altatipogastoform");
        echo form_open("AltaTipoGasto/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="tipo_Gasto" class="control-label">Tipo Gasto</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="tipo_gasto" name="tipo_gasto" placeholder="tipo de gasto" type="text" class="form-control" />
                        <span id='tipo_gasto_error' class="text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Alta tipo gasto" onclick="altaTipoGasto();" />
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