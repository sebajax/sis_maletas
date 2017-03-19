<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantidad sectores</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        function cantidadSectores() {
            $("span.text-danger").html('');
            
            var cantidad = $("#cantidad").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!cantidad) {
                $("#cantidad_error").html(manejoMensajes("vacio", "cantidad"));
                $("#cantidad").focus();
                return false;
            }
            
            if(!isNumber(cantidad)) {
                $("#cantidad_error").html(manejoMensajes("numerico", "cantidad"));
                $("#cantidad").focus();
                return false;                
            }              
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("CantidadSectores/cantidadSectores"); ?>",
                data: { cantidad: cantidad }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
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
            <li class="active">Cantidad sectores</li>
        </ol>          
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Cantidad sectores</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "cantidadsectoresform", "name" => "cantidadsectoresform");
        echo form_open("CantidadSectores/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="cantidad" class="control-label">Cantidad</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="cantidad" name="cantidad" placeholder="cantidad sectores" type="text" class="form-control" value="<?php echo $cantidad; ?>" />
                        <span id='cantidad_error' class="text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Actualizar cantidad" onclick="cantidadSectores();" />
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