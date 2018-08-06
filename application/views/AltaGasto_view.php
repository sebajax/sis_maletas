<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Gasto</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
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
            
            $("#fecha").datepicker();
        });
        
        function altaGasto() {
            $("span.text-danger").html('');
            
            var tipo_gasto = $("#tipo_gasto").val();
            var fecha      = $("#fecha").val();
            var comentario = $("#comentario").val();
            var monto      = $("#monto").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!tipo_gasto) {
                $("#tipo_gasto_error").html(manejoMensajes("vacio", "tipo_gasto"));
                $("#tipo_gasto").focus();
                return false;
            }
            
            if(!fecha) {
                $("#fecha_error").html(manejoMensajes("vacio", "fecha"));
                $("#fecha").focus();
                return false;
            }
            
            if(!comentario) {
                $("#comentario_error").html(manejoMensajes("vacio", "comentario"));
                $("#comentario").focus();
                return false;
            }
            
            if(!monto) {
                $("#monto_error").html(manejoMensajes("vacio", "monto"));
                $("#monto").focus();
                return false;
            } 
            
            /*
             * VERIFICO NUMERICOS
             */
            if(!isNumber(monto)) {
                $("#monto_error").html(manejoMensajes("numerico", "monto"));
                $("#monto").focus();
                return false;                
            }            
            
            /*
             * VERIFICO FECHAS
             */
            if(!isValidDate(fecha)) {
                $("#fecha_error").html(manejoMensajes("fecha", "fecha"));
                $("#fecha").focus();
                return false;                
            }  
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaGasto/altaGasto"); ?>",
                data: { tipo_gasto: tipo_gasto, fecha: fecha, comentario: comentario, monto: monto }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
                    resetear_gasto();
                }else {
                    mostrarMensaje("Datos erroneos favor verifique.", "alert-danger");
                }
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuGasto"); ?>";
        }  
        
        function verificar_gasto() {
            $('#confirm').modal({
                backdrop: 'static',
                keyboard: false
            })
            .one('click', '#confirmar', function() {
                altaGasto();
            });                
        }
        
        function resetear_gasto() {
            $("#fecha").val("");
            $("#comentario").val("");
            $("#monto").val("");
        }
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuGasto"); ?>">Menu Gasto</a></li>
            <li class="active">Alta Gasto</li>
        </ol>         
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Alta Gasto</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "altagastoform", "name" => "altagastoform");
        echo form_open("AltaGasto/index", $attributes);
        ?>
        
        <fieldset>
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="tipo_gasto" class="control-label">Tipo Gasto</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <?php
                        $attributes = 'class = "form-control" id = "tipo_gasto"';
                        echo form_dropdown('tipo_gasto', $tipo_gasto, set_value('tipo_gasto'), $attributes);
                        ?>
                        <span id='tipo_gasto_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="fecha" class="control-label">Fecha</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="fecha" name="fecha" placeholder="fecha" type="text" class="form-control" />
                        <span id='fecha_error' class="text-danger"></span>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="comentario" class="control-label">Comentario</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <textarea class="form-control noresize" rows="5" id="comentario" placeholder="comentario"></textarea>
                        <span id='comentario_error' class="text-danger"></span>
                    </div>
                </div>
            </div>             
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="monto" class="control-label">Monto</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">CLP</div>
                            <input id="monto" name="monto" placeholder="monto" type="text" class="form-control" />
                        </div>
                        <span id='monto_error' class="text-danger"></span>
                    </div>
                </div>
            </div>  
            
            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Alta Gasto" onclick="verificar_gasto();" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" />
                <input id="btn_volver" name="btn_volver" type="button" class="btn btn-primary" value="Volver" onclick="irMenu();" />
            </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- Modal confirmacion -->
<div id="confirm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                Esta seguro desea ingrestar este gasto ?. 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmar">Confirmar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>      
</body>
</html>