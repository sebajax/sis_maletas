<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta valores</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        function altaValores() {
            $("span.text-danger").html('');
            
            var aerolinea    = $("#aerolinea").val();
            var grupo_sector = $("#grupo_sector").val();
            var valor        = $("#valor").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!aerolinea) {
                $("#aerolinea_error").html(manejoMensajes("vacio", "aerolinea"));
                $("#aerolinea").focus();
                return false;
            }
            
            if(!grupo_sector) {
                $("#grupo_sector_error").html(manejoMensajes("vacio", "grupo sector"));
                $("#grupo_sector").focus();
                return false;
            }
            
            if(!valor) {
                $("#valor_error").html(manejoMensajes("vacio", "valor"));
                $("#valor").focus();
                return false;
            }
            
            /*
             * VERIFICO NUMERICOS
             */
            if(!isNumber(valor)) {
                $("#valor_error").html(manejoMensajes("numerico", "valor"));
                $("#valor").focus();
                return false;                
            }            
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("alta_valores/altaValores"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector, valor: valor }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
                    resetearFormulario();
                }else if(data == "PK"){
                    mostrarMensaje("La informacion del valor que desea ingresar, ya existe.", "alert-danger");
                }else {
                    mostrarMensaje("Datos erroneos favor verifique.", "alert-danger");
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
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("menu_principal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("menu_valor"); ?>">Menu Valor</a></li>
            <li class="active">Alta valores</li>
        </ol>        
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Alta valores</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "altavaloresform", "name" => "altavaloresform");
        echo form_open("alta_valores/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="aerolinea" class="control-label">Aerolinea</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <?php
                        $attributes = 'class = "form-control" id = "aerolinea"';
                        echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                        ?>
                        <span id='aerolinea_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            

            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="grupo_sector" class="control-label">Grupo sector</label>
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
                        <label for="valor" class="control-label">Valor</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="valor" name="valor" placeholder="valor" type="text" class="form-control" />
                        <span id='valor_error' class="text-danger"></span>
                    </div>
                </div>
            </div>  
            
            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Alta valor" onclick="altaValores();" />
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