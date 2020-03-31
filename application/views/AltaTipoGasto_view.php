<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta tipo gasto</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#menu_gasto").addClass("active");
            $("#imagen_principal").remove();
        });
        
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
    </script>
    
</head>
<body>
    
<div class="container p-3">
    <div class="row">
        <div class="col-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-primary">Menu Gasto</li>
                    <li class="breadcrumb-item active">Alta Tipo Gasto</li>
                </ol> 
            </nav>      
            
            <div class="jumbotron w-100 p-3 mx-auto">

                <legend>Alta Tipo Gasto</legend>

                <form>
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="tipo_gasto_addon">Tipo Gasto</span>
                            </div>                    
                            <input aria-label="tipo_gasto" aria-describedby="tipo_gasto_addon" id="tipo_gasto" name="tipo_gasto" placeholder="tipo gasto" type="text" class="form-control">
                        </div>
                        <span id="tipo_gasto_error" class="text-danger"></span>
                    </div>                    
                    
                    <div class="form-group">
                        <div id="alert_placeholder"></div>
                    </div> 
                    
                    <div class="form-group">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2"><input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-outline-success" value="Ingresar" onclick="altaTipoGasto();"></div> 
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