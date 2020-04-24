<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta valores</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#menu_valor").addClass("active");
            $("#imagen_principal").remove();
        });        
        
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
                url: "<?php echo base_url("AltaValores/altaValores"); ?>",
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
    </script>
    
</head>
<body>
    
<div class="container p-3">
    <div class="row">
        <div class="col-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-primary">Menu Valor</li>
                    <li class="breadcrumb-item active">Alta Valor</li>
                </ol> 
            </nav>      
            
            <div class="jumbotron w-100 p-3 mx-auto">
                <legend>Alta Valores</legend>
                
                <form>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="aerolinea_addon">Aerolinea</span>
                            </div>                    
                            <?php
                            $attributes = 'class = "form-control" id="aerolinea" aria-label="aerolinea" aria-describedby="aerolinea_addon"';
                            echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                            ?>
                        </div>
                        <span id="aerolinea_error" class="text-danger"></span>
                    </div>                     
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="grupo_sector_addon">Grupo Sector</span>
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
                                <span class="input-group-text bg-primary text-white w-100" id="valor_addon">Valor</span>
                                <span class="input-group-text" id="valor_addon">$</span>
                            </div>
                            <input id="valor" name="valor" placeholder="valor" type="text" class="form-control" aria-label="valor" aria-describedby="valor_addon">
                        </div>
                        <span id='valor_error' class="text-danger"></span>
                    </div>                    
                    
                    <div class="form-group">
                        <div id="alert_placeholder"></div>
                    </div> 
                    
                    <div class="form-group">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2"><input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-outline-success" value="Alta Valor" onclick="altaValores();"></div> 
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