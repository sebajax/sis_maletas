<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>
        html, body, .container-table {
            height: 100%;
        }
        .container-table {
            display: table;
        }
        .vertical-center-row {
            display: table-cell;
            vertical-align: middle;
        }     
    </style>
    
    <script type="text/javascript">
        function login() {
            $("span.text-danger").html('');
            
            var usuario = $("#usuario").val();
            var clave = $("#clave").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!usuario) {
                $("#usuario_error").html(manejoMensajes("vacio", "usuario"));
                $("#usuario").focus();
                return false;
            }
            
            if(!clave) {
                $("#clave_error").html(manejoMensajes("vacio", "clave"));
                $("#clave").focus();
                return false;
            }            
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("login/intentoLogin"); ?>",
                data: { usuario: usuario, clave: clave }
            }).done(function(data) {
                if(data == "OK") {
                    window.location.href = "<?php echo base_url("menu_principal"); ?>";
                }else {
                    mostrarMensaje("Datos de acceso incorrectos.", "alert-danger");
                }
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("menu_aerolinea"); ?>";
        }        
    </script>
    
</head>
<body>
<div class="container container-table">
    <div class="row vertical-center-row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Login</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
        echo form_open("login/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="usuario" class="control-label">Usuario</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="usuario" name="usuario" placeholder="ingrese su usuario" type="text" class="form-control" />
                        <span id='usuario_error' class="text-danger"></span>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="clave" class="control-label">Contraseña</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="clave" name="clave" placeholder="ingrese su contraseña" type="password" class="form-control" />
                        <span id='clave_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            

            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_login" name="btn_login" type="button" class="btn btn-large btn-block btn-success" value="Login" onclick="login();" />
            </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>