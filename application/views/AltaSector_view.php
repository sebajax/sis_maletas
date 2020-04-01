<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar sector</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#menu_sector").addClass("active");
            $("#imagen_principal").remove();
        });        
        
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
    </script>
    
</head>
<body>
    
<div class="container p-3">
    <div class="row">
        <div class="col-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-primary">Menu Sector</li>
                    <li class="breadcrumb-item active">Alta Sector</li>
                </ol> 
            </nav>      
            
            <div class="jumbotron w-100 p-3 mx-auto">
                <legend>Alta Sector</legend>
                
                <form>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="grupo_sector_addon">Grupo</span>
                            </div>                    
                            <?php
                            $attributes = 'class = "form-control" id="grupo_sector" aria-label="grupo_sector" aria-describedby="grupo_sector_addon"';
                            echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                            ?>
                        </div>
                        <span id="grupo_sector_error" class="text-danger"></span>
                    </div>                

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="lugar_addon">Lugar</span>
                            </div>
                            <input id="lugar" name="lugar" placeholder="nombre del sector" type="text" class="form-control" aria-label="lugar" aria-describedby="lugar_addon">
                        </div>
                        <span id='lugar_error' class="text-danger"></span>
                    </div>                    
                    
                    <div class="form-group">
                        <div id="alert_placeholder"></div>
                    </div> 
                    
                    <div class="form-group">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2"><input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-outline-success" value="Alta Sector" onclick="altaSector();"></div> 
                            <div class="p-2"><input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-outline-danger" value="Cancelar"></div>
                        </div>
                    </div>                       
                    
                </form>
                
            </div>        
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</body>
</html>