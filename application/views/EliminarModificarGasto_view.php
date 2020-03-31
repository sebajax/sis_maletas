<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar Gasto</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#menu_gasto").addClass("active");
            $("#imagen_principal").remove();
        });           
        //load datepicker control onfocus
        $(function() {
            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'yy/mm/dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            }; 
            $.datepicker.setDefaults($.datepicker.regional['es']);             
            
            $("#fecha_desde").datepicker();
            $("#fecha_hasta").datepicker();
        });        
        
        function buscarGasto() {
            var tipo_gasto  = $("#tipo_gasto").val();
            var fecha_desde = $("#fecha_desde").val();
            var fecha_hasta = $("#fecha_hasta").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarGasto/buscarGasto"); ?>",
                data: { tipo_gasto: tipo_gasto, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function modificarGastoForm(id_gasto) {
            $("#modificar_gasto_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarGasto/modificarGastoForm"); ?>",
                data: { id_gasto: id_gasto }
            }).done(function(data) {
                $("#modificar_gasto_form").html(data);
                $("#fecha_new").datepicker();
                $('#modificar_gasto').modal('show');
            });
        }        
        
        function modificarGasto(id_gasto) {
            var id_tipo_gasto_new = $("#tipo_gasto_new").val();
            var fecha_new         = $("#fecha_new").val();
            var comentario_new    = $("#comentario_new").val();
            var monto_new         = $("#monto_new").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!id_tipo_gasto_new) {
                $("#tipo_gasto_new").focus();
                return false;
            }
            
            if(!fecha_new) {
                $("#fecha_new").focus();
                return false;
            }
            
            if(!comentario_new) {
                $("#comentario_new").focus();
                return false;
            }
            
            if(!monto_new) {
                $("#monto_new").focus();
                return false;
            }
            
            /*
             * VERIFICO NUMERICOS
             */
            if(!isNumber(monto_new)) {
                $("#monto_new").focus();
                return false;                
            }
            
            /*
             * VERIFICO FECHAS
             */
            if(!isValidDate(fecha_new)) {
                $("#fecha_new").focus();
                return false;                
            }          
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarGasto/modificarGasto"); ?>",
                data: { id_gasto: id_gasto, id_tipo_gasto_new: id_tipo_gasto_new, fecha_new: fecha_new, comentario_new: comentario_new, monto_new: monto_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: gasto modificado.", "alert-success");
                    buscarGasto();
                }else {
                    mostrarMensaje("ERROR: no se pudo modificar el gasto.", "alert-danger");
                }
            });            
        }
        
        function eliminarGasto(id_gasto) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarGasto/eliminarGasto"); ?>",
                data: { id_gasto: id_gasto }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    buscarGasto();
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }   
        
        function ordenarBuscar(parametro) {
            ordenamiento();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarGasto/ordenarBuscar"); ?>",
                data: { parametro: parametro, ordenamiento: $("#ordenamiento").val() }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("EliminarModificarBdo/exportarExcel"); ?>";
        }    
        
        function cofirmaEliminar(id_gasto) {
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#delete', function () {
                    eliminarGasto(id_gasto);
            });        
        }  
    </script>
</head>

<body>
    
    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu Gasto</li>
                <li class="breadcrumb-item active">Eliminar Modificar Gasto</li>
            </ol> 
        </nav>            
    
        <legend>Eliminar Modificar Gasto</legend>    

        <form class="my-3">
        
            <div class="form-row">
                
                <div class="form-group col-2">
                    <?php
                    $attributes = 'class="custom-select" id="tipo_gasto" aria-label="tipo_gasto" aria-describedby="tipo_gasto_addon"';
                    echo form_dropdown('tipo_gasto', $tipo_gasto, set_value('tipo_gasto'), $attributes);
                    ?>
                </div>
                
                <div class="form-group col-2 ml-5">   
                    <div class="input-group">
                        <input aria-label="fecha desde" aria-describedby="fecha_desde_addon" id="fecha_desde" name="fecha_desde" placeholder="fecha desde" type="text" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text far fa-calendar-alt fa-lg pt-2"></span>
                        </div>
                    </div>            
                </div>        

                <div class="form-group col-2 ml-5">       
                    <div class="input-group">
                        <input aria-label="fecha hasta" aria-describedby="fecha_hasta_addon" id="fecha_hasta" name="fecha_hasta" placeholder="fecha hasta" type="text" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text far fa-calendar-alt fa-lg pt-2"></span>
                        </div>
                    </div>
                </div>                
                
            </div>
       
        </form> 
       
        <form class="form-inline mt-3">
            <button type="button" class="btn btn-outline-success col-2" onclick="buscarGasto()" id="btnenviar">Enviar</button>
        </form>        
        
        <div class="form-group mt-2">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <div id="printDiv">
            <table class="table table-hover table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('id_tipo_gasto')">Tipo Gasto</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('fecha')">Fecha</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('comentario')">Comentario</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('monto')">Monto</th>
                  <th>Modif</th>
                  <th>Eliminar</th>
                </tr>
              </thead>
              <tbody id="cuerpo"></tbody>
            </table>
        </div>    
        <input id="ordenamiento" type="hidden" value=""/>
    </div>

    <!-- Modal modificar gasto -->
    <div id="modificar_gasto" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">MODIFICAR GASTO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="modificar_gasto_form"></div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar gasto -->
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