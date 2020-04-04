<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>
        body {
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #eee;
        }

        .form-signin {
          max-width: 330px;
          padding: 15px;
          margin: 0 auto;
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
          margin-bottom: 10px;
        }
        .form-signin .checkbox {
          font-weight: normal;
        }
        .form-signin .form-control {
          position: relative;
          height: auto;
          -webkit-box-sizing: border-box;
             -moz-box-sizing: border-box;
                  box-sizing: border-box;
          padding: 10px;
          font-size: 16px;
        }
        .form-signin .form-control:focus {
          z-index: 2;
        }
        .form-signin input[type="text"] {
          margin-bottom: -1px;
          border-bottom-right-radius: 0;
          border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
          margin-bottom: 10px;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
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
                url: "<?php echo base_url("Login/intentoLogin"); ?>",
                data: { usuario: usuario, clave: clave }
            }).done(function(data) {
                if(data == "OK") {
                    window.location.href = "<?php echo base_url("MenuPrincipal"); ?>";
                }else {
                    mostrarMensaje("Datos de acceso incorrectos.", "alert-danger");
                }
            });
        }      
    </script>
    
</head>
<body>
  <body>
    <div class="container">
        <form class="form-signin">
            <h2 class="form-signin-heading">Login</h2>
            <label for="usuario" class="sr-only">Usuario</label>
            <input type="text" id="usuario" class="form-control" placeholder="Usuario" required autofocus>
            <span id='usuario_error' class="text-danger"></span>
            <label for="clave" class="sr-only">Clave</label>
            <input type="password" id="clave" class="form-control" placeholder="Clave" required>
            <span id='clave_error' class="text-danger"></span>
            <button id="btn_login" class="btn btn-lg btn-primary btn-block" type="button" onclick="login();">Login</button>
        </form>
        
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>     

        <form class="my-5">
            <div id="imagen_principal" class="form-group row d-flex justify-content-center">
                <span class="fas fa-luggage-cart fa-2x" style="opacity: 0.1;"></span>
            </div>    
            <div class="form-group row d-flex justify-content-center">
                <h6 style="opacity: 0.3;"><?php echo SYSTEM_TITLE." ".VERSION; ?></h6>
            </div>
        </form>         
        
    </div> <!-- /container -->
</body>
</html>