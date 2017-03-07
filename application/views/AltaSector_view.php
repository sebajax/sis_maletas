<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar sector</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        
        function altaSector() {
            $("span.text-danger").html('');
            
            var grupo_sector = $("#grupo_sector").val();
            var lugar        = $("#lugar").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!grupo_sector) {
                $("#grupo_sector_error").html(manejoMensajes("vacio", "grupo_sector"));
                $("#grupo_sector").focus();
                return false;
            }
            
            if(!lugar) {
                $("#lugar_error").html(manejoMensajes("vacio", "lugar"));
                $("#lugar").focus();
                return false;
            }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaSector/altaSector"); ?>",
                data: { grupo_sector: grupo_sector, lugar: lugar }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
                    resetearFormulario();
                }else if(data == "PK"){
                    mostrarMensaje("Grupo sector y lugar que desea ingresar ya se encuentran en BD..", "alert-danger");
                }else {
                    mostrarMensaje("Datos erroneos favor verifique.", "alert-danger");
                }
            });
        } 
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuSector"); ?>";
        }        
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuSector"); ?>">Menu Sector</a></li>
            <li class="active">Alta sector</li>
        </ol>         
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Alta sector</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "altasectorform", "name" => "altasectorform");
        echo form_open("AltaSector/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="grupo_sector" class="control-label">Grupo</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <?php
                        $attributes = 'class = "form-control" id = "grupo_sector"';
                        echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                        ?>
                        <span id='grupo_sector_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="lugar" class="control-label">Lugar</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="lugar" name="lugar" placeholder="nombre del lugar" type="text" class="form-control" />
                        <span id='lugar_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            

            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Alta sector" onclick="altaSector();" />
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