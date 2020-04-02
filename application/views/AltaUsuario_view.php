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
            $("#menu_admin").addClass("active");
            $("#imagen_principal").remove();
        });        
        
        function altaUsuario() {
            
            $("span.text-danger").html('');
            
            var usuario     = $("#usuario").val();
            var nombre      = $("#nombre").val();
            var apellido    = $("#apellido").val();
            var privilegios = $("#privilegios").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!usuario) {
                $("#usuario_error").html(manejoMensajes("vacio", "usuario"));
                $("#usuario").focus();
                return false;
            }
            
            if(!nombre) {
                $("#nombre_error").html(manejoMensajes("vacio", "nombre"));
                $("#nombre").focus();
                return false;
            }

            if(!apellido) {
                $("#apellido_error").html(manejoMensajes("vacio", "apellido"));
                $("#apellido").focus();
                return false;
            }
            
            if(!privilegios) {
                $("#privilegios_error").html(manejoMensajes("vacio", "privilegios"));
                $("#privilegios").focus();
                return false;
            }   
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaUsuario/altaUsuario"); ?>",
                data: { usuario: usuario, nombre: nombre, apellido: apellido, privilegios: privilegios, nombre_perfil: $("#privilegios option:selected").html() }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Usuario creado correctamente.", "alert-success");
                    resetearFormulario();
                }else if(data == "PK"){
                    mostrarMensaje("Usuario que desea ingresar ya se encuentran en BD..", "alert-danger");
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
                    <li class="breadcrumb-item text-primary">Menu Admin</li>
                    <li class="breadcrumb-item active">Alta Usuario</li>
                </ol> 
            </nav>      
            
            <div class="jumbotron w-100 p-3 mx-auto">
                <legend>Alta Usuario</legend>
                
                <form>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="usuario_addon">Usuario</span>
                            </div>
                            <input id="usuario" name="usuario" placeholder="usuario" type="text" class="form-control" aria-label="usuario" aria-describedby="usuario_addon">
                        </div>
                        <span id='usuario_error' class="text-danger"></span>
                    </div>                     
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="nombre_addon">Nombre</span>
                            </div>
                            <input id="nombre" name="nombre" placeholder="nombre del usuario" type="text" class="form-control" aria-label="nombre" aria-describedby="nombre_addon">
                        </div>
                        <span id='nombre_error' class="text-danger"></span>
                    </div>   
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="apellido_addon">Apellido</span>
                            </div>
                            <input id="apellido" name="apellido" placeholder="apellido del usuario" type="text" class="form-control" aria-label="apellido" aria-describedby="apellido_addon">
                        </div>
                        <span id='apellido_error' class="text-danger"></span>
                    </div>                      
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="privilegios_addon">Privilegios</span>
                            </div>                    
                            <select class="custom-select" id="privilegios">
                                <option value="" selected>-SELECCIONE-</option>
                                <option value="1">ADMINISTRADOR</option>
                                <option value="2">USUARIO</option>
                                <option value="3">CONSULTA</option>
                            </select>                              
                        </div>
                        <span id="privilegios_error" class="text-danger"></span>
                    </div>                
                    
                    <div class="form-group">
                        <div id="alert_placeholder"></div>
                    </div> 
                    
                    <div class="form-group">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2"><input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-outline-success" value="Alta Usuario" onclick="altaUsuario();"></div> 
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