<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantidad sectores</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#menu_sector").addClass("active");
            $("#imagen_principal").remove();
        });        
        
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
    </script>
    
</head>
<body>
    
<div class="container p-3">
    <div class="row">
        <div class="col-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-primary">Menu Sector</li>
                    <li class="breadcrumb-item active">Cantidad Sectores</li>
                </ol> 
            </nav>      
            
            <div class="jumbotron w-100 p-3 mx-auto">
                <legend>Cantidad sectores</legend>
                
                <form>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="cantidad_addon">Cantidad</span>
                            </div>
                            <input value="<?php echo $cantidad; ?>" id="cantidad" name="cantidad" placeholder="cantidad de sectores" type="text" class="form-control" aria-label="cantidad" aria-describedby="cantidad_addon">
                        </div>
                        <span id='cantidad_error' class="text-danger"></span>
                    </div>                    
                    
                    <div class="form-group">
                        <div id="alert_placeholder"></div>
                    </div> 
                    
                    <div class="form-group">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2"><input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-outline-success" value="Actualizar" onclick="cantidadSectores();"></div> 
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