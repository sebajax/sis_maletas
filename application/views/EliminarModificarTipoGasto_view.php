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
            $("#menu_gasto").addClass("active");
            $("#imagen_principal").remove();
        });           
        
        function modificarTipoGastoForm(id_tipo_gasto) {
            $("#modificar_tipo_gasto_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarTipoGasto/modificarTipoGastoForm"); ?>",
                data: { id_tipo_gasto: id_tipo_gasto }
            }).done(function(data) {
                $("#modificar_tipo_gasto_form").html(data);
                $('#modificar_tipo_gasto').modal('show');
            });
        }        
        
        function modificarTipoGasto(id_tipo_gasto) {
            var tipo_gasto_new = $("#tipo_gasto_new").val();
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!tipo_gasto_new) {
                $("#tipo_gasto_new").focus();
                return false;
            }

            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarTipoGasto/modificarTipoGasto"); ?>",
                data: { id_tipo_gasto: id_tipo_gasto, tipo_gasto_new: tipo_gasto_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: tipo gasto modificado.", "alert-success");
                    location.reload(true);
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar el tipo gasto.", "alert-danger");
                }
            });            
        }
        
        function eliminarTipoGasto(id_tipo_gasto) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarTipoGasto/eliminarTipoGasto"); ?>",
                data: { id_tipo_gasto: id_tipo_gasto }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    location.reload(true);
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }   
        
        function cofirmaEliminar(id_tipo_gasto) {
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#delete', function () {
                    eliminarTipoGasto(id_tipo_gasto);
            });        
        }  
    </script>
</head>

<body>
    
    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu Gasto</li>
                <li class="breadcrumb-item active">Eliminar Modificar Tipo Gasto</li>
            </ol> 
        </nav>            
    
        <legend>Eliminar Modificar Tipo Gasto</legend>    
        
        <div class="form-group mt-2">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <div id="printDiv">
            <table class="table table-hover table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>Tipo Gasto</th>
                  <th>Modif</th>
                  <th>Eliminar</th>
                </tr>
              </thead>
              <tbody id="cuerpo"><?php echo $loadTipoGastos; ?></tbody>
            </table>
        </div>    
    </div>

    <!-- Modal modificar tipo gasto -->
    <div id="modificar_tipo_gasto" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">MODIFICAR TIPO GASTO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="modificar_tipo_gasto_form"></div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar tipo gasto -->
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

</body>
</html>