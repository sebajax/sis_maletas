<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso Caja</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#menu_simulado").addClass("active");
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
            
            $("#fecha").datepicker();
        });
        
        function ingresoCajaSimulado() {
            $("span.text-danger").html('');
            
            var tipo_ingreso = $("#tipo_ingreso").val();
            var fecha        = $("#fecha").val();
            var monto        = $("#monto").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!tipo_ingreso) {
                $("#tipo_ingreso_error").html(manejoMensajes("vacio", "tipo_ingreso"));
                $("#tipo_ingreso").focus();
                return false;
            }
            
            if(!fecha) {
                $("#fecha_error").html(manejoMensajes("vacio", "fecha"));
                $("#fecha").focus();
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
                url: "<?php echo base_url("IngresoCajaSimulado/ingresoCajaSimulado"); ?>",
                data: { tipo_ingreso: tipo_ingreso, fecha: fecha, monto: monto }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
                    resetear_ingreso();
                }else {
                    mostrarMensaje("Datos erroneos favor verifique.", "alert-danger");
                }
            });
        }
        
        function resetear_ingreso() {
            $("#tipo_ingreso").val("");
            $("#fecha").val("");
            $("#monto").val("");
        }
    </script>
    
</head>
<body>
    
<div class="container p-3">
    <div class="row">
        <div class="col-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-primary">Menu Simulado</li>
                    <li class="breadcrumb-item active">Ingreso Caja (SIMULADO)</li>
                </ol> 
            </nav>      
            
            <div class="jumbotron w-100 p-3 mx-auto">

                <legend>Ingreso Caja (SIMULADO)</legend>

                <form>
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="tipo_ingreso_addon">Tipo Ingreso</span>
                            </div>                    
                            <input aria-label="tipo ingreso" aria-describedby="tipo_ingreso_addon" id="tipo_ingreso" name="tipo_ingreso" placeholder="tipo ingreso" type="text" class="form-control">
                        </div>
                        <span id="tipo_ingreso_error" class="text-danger"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="fecha_addon">Fecha</span>
                            </div>                    
                            <input aria-label="fecha" aria-describedby="fecha_addon" id="fecha" name="fecha" placeholder="fecha" type="text" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text far fa-calendar-alt fa-lg pt-2"></span>
                            </div>
                        </div>
                        <span id='fecha_error' class="text-danger"></span>
                    </div>   
                   
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend w-25">
                                <span class="input-group-text bg-primary text-white w-100" id="monto_addon">Monto</span>
                                <span class="input-group-text" id="monto_addon">$</span>
                            </div>
                            <input id="monto" name="monto" placeholder="monto" type="text" class="form-control" aria-label="monto" aria-describedby="monto_addon">
                        </div>
                        <span id='monto_error' class="text-danger"></span>
                    </div>
                    
                    <div class="form-group">
                        <div id="alert_placeholder"></div>
                    </div> 
                    
                    <div class="form-group">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2"><input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-outline-success" value="Ingreso Caja (SIMULADO)" onclick="ingresoCaja();"></div> 
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