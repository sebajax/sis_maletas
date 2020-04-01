<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Sectores</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
  
    <script type="text/javascript">
        $(document).ready(function() {
            $("#menu_sector").addClass("active");
            $("#imagen_principal").remove();
        });            

        function buscarSector() {
            var lugar        = $("#lugar").val();
            var grupo_sector = $("#grupo_sector").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarSector/buscarSector"); ?>",
                data: { lugar: lugar, grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function modificarSectorForm(id_sector) {
            $("#modificar_sector_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarSector/modificarSectorForm"); ?>",
                data: { id_sector: id_sector }
            }).done(function(data) {
                $("#modificar_sector_form").html(data);
                $('#modificar_sector').modal('show');
            });
        }
        
        function modificarSector(id_sector) {
        
            var grupo_sector_new = $("#grupo_sector_new").val();
            var lugar_new        = $("#lugar_new").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarSector/modificarSector"); ?>",
                data: { id_sector: id_sector, grupo_sector_new: grupo_sector_new, lugar_new: lugar_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: el sector fue modificado correctamente", "alert-success");
                    buscarSector();
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar el sector.", "alert-danger");
                }
            });            
        }
        
        function cancelarModificarSector() {
            $('#modificar_sector').modal('toggle');
        }
        
        function eliminarSector(id_sector) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarSector/eliminarSector"); ?>",
                data: { id_sector: id_sector }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    buscarSector();
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }            
        
        function cofirmaEliminar(id_sector) {
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#delete', function () {
                    eliminarSector(id_sector);
            });        
        }        
    </script>
    
</head>
<body>
    
    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu Sector</li>
                <li class="breadcrumb-item active">Eliminar Modificar Sectores</li>
            </ol> 
        </nav>         
        
        <legend>Eliminar Modificar Sectores</legend>
        
        <form class="my-3">
            
            <div class="form-row">
                <div class="form-group col-2">
                    <?php
                    $attributes = 'class="custom-select" id="grupo_sector" aria-label="grupo_sector" aria-describedby="grupo_sector_addon"';
                    echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                    ?>
                </div>
                
                <div class="form-group col-2 ml-5">   
                    <input aria-label="lugar" aria-describedby="lugar_addon" id="lugar" name="lugar" placeholder="nombre del lugar" type="text" class="form-control">
                </div>                   
            </div>
            
        </form>        
        
        <form class="form-inline mt-3">
            <button type="button" class="btn btn-outline-success col-2" onclick="buscarSector()" id="btnenviar">Enviar</button>
            <button type="button" class="btn btn-outline-success col-2 ml-5" onclick="printDiv()" id="btnenviar">Imprimir</button>
        </form>        
        
        <div class="form-group mt-2">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />        
        
        <div id="printDiv">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Grupo</th>
                        <th>Lugar</th>
                        <th>Modif</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody id="cuerpo"></tbody>
            </table>
        </div>          
        
    </div>    

    <!-- Modal modificar aerolinea -->
    <div id="modificar_sector" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">MODIFICAR SECTOR</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="modificar_sector_form"></div>
            </div>
        </div>
    </div>

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