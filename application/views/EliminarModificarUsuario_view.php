<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Tipo Gasto</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#menu_admin").addClass("active");
            $("#imagen_principal").remove();
        });           
        
        function modificarUsuarioForm(usuario) {
            $("#modificar_usuario_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarUsuario/modificarUsuarioForm"); ?>",
                data: { usuario: usuario }
            }).done(function(data) {
                $("#modificar_usuario_form").html(data);
                $('#modificar_usuario').modal('show');
            });
        }        
        
        function modificarUsuario(usuario) {
            var nombre_new        = $("#nombre_new").val();
            var apellido_new      = $("#apellido_new").val();
            var id_perfil_new     = $("#id_perfil_new").val();
            var nombre_perfil_new = $("#id_perfil_new option:selected").html()
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!nombre_new) {
                $("#nombre_new").focus();
                return false;
            }
            
            if(!apellido_new) {
                $("#apellido_new").focus();
                return false;
            }
            
            if(!id_perfil_new) {
                $("#id_perfil_new").focus();
                return false;
            }            
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarUsuario/modificarUsuario"); ?>",
                data: { usuario: usuario, nombre: nombre_new, apellido: apellido_new, id_perfil: id_perfil_new, nombre_perfil: nombre_perfil_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: usuario modificado.", "alert-success");
                    location.reload(true);
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar el usuario.", "alert-danger");
                }
            });            
        }
        
        function eliminarUsuario(usuario) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarUsuario/eliminarUsuario"); ?>",
                data: { usuario: usuario }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    location.reload(true);
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }   
        
        function limpiarClave(usuario) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarUsuario/limpiarClave"); ?>",
                data: { usuario: usuario }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: clave reiniciada.", "alert-success");
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar el usuario.", "alert-danger");
                }
            });            
        }         
        
        function cofirmaEliminar(usuario) {
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#delete', function () {
                    eliminarUsuario(usuario);
            });        
        }  
        
        function confirmaLimpiarClave(usuario) {
            $('#confirm_clave').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#limpiar', function () {
                    limpiarClave(usuario);
            });             
        }
    </script>
</head>

<body>
    
    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu Admin</li>
                <li class="breadcrumb-item active">Eliminar Modificar Usuario</li>
            </ol> 
        </nav>            
    
        <legend>Eliminar Modificar Usuario</legend>    
        
        <div class="form-group mt-2">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <div id="printDiv">
            <table class="table table-hover table-bordered">
              <thead class="thead-dark">
                <tr>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Id Perfil</th>
                    <th>Perfil</th>
                    <th>Modif</th>
                    <th>L.Clave</th>
                    <th>Eliminar</th>
                </tr>
              </thead>
              <tbody id="cuerpo"><?php echo $usuarios; ?></tbody>
            </table>
        </div>    
    </div>

    <!-- Modal modificar usuario -->
    <div id="modificar_usuario" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">MODIFICAR USUARIO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="modificar_usuario_form"></div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar usuario -->
    <div id="confirm" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                   ¿ Seguro quieres eliminar el registro ?
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">ELIMINAR</button>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>   
        </div>    
    </div>
    
    <!-- Modal vaciar clave -->
    <div id="confirm_clave" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                   ¿ Seguro quieres limpiar la clave ?
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-danger" id="limpiar">LIMPIAR CLAVE</button>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>   
        </div>    
    </div>    

</body>
</html>