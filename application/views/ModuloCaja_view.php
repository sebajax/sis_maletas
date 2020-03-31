<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo Caja</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#menu_caja").addClass("active");
            $("#imagen_principal").remove();
            $("#monto_inicialDiv").html("");
            
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("ModuloCaja/montoInicial"); ?>"
            }).done(function(data) {
                $("#monto_inicialDiv").html(data);
            });       
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

        function buscar() {
            $("#busqueda_error").html("");
            $("#printDiv").html("");
            var fecha_desde  = $("#fecha_desde").val();
            var fecha_hasta  = $("#fecha_hasta").val();
            var mes          = $("#mes").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
            */ 
            
            if(!mes || mes == 0) {
                if(!fecha_desde) {
                    $("#busqueda_error").html(manejoMensajes("vacio", "fecha_desde"));
                    $("#fecha_desde").focus();
                    return false;
                }

                if(!fecha_hasta) {
                    $("#busqueda_error").html(manejoMensajes("vacio", "fecha_hasta"));
                    $("#fecha_hasta").focus();
                    return false;
                }  

                /*
                 * VERIFICO FECHAS
                 */
                if(!isValidDate(fecha_desde)) {
                    $("#busqueda_error").html(manejoMensajes("fecha", "fecha_desde"));
                    $("#fecha_desde").focus();
                    return false;                
                }              

                if(!isValidDate(fecha_hasta)) {
                    $("#busqueda_error").html(manejoMensajes("fecha", "fecha_hasta"));
                    $("#fecha_hasta").focus();
                    return false;                
                }            
            }
            
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("ModuloCaja/buscarTransacciones"); ?>",
                data: { mes: mes, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta }
            }).done(function(data) {
                $("#printDiv").html(data['content']);
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuPrincipal"); ?>";
        } 
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("ModuloCaja/exportarExcel"); ?>";
        }  
    </script>
    
</head>
<body>

    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Modulo caja</li>
            </ol> 
        </nav>  
    
        <legend>Modulo caja</legend>
        
        <form class="my-3">
            
            <div class="form-row">
            
                <div class="col-2">   
                    <div class="input-group">
                        <input aria-label="fecha desde" aria-describedby="fecha_desde_addon" id="fecha_desde" name="fecha_desde" placeholder="fecha desde" type="text" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text far fa-calendar-alt fa-lg pt-2"></span>
                        </div>
                    </div>            
                </div>        

                <div class="col-2 ml-5">       
                    <div class="input-group">
                        <input aria-label="fecha hasta" aria-describedby="fecha_hasta_addon" id="fecha_hasta" name="fecha_hasta" placeholder="fecha hasta" type="text" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text far fa-calendar-alt fa-lg pt-2"></span>
                        </div>
                    </div>
                </div>

                <div class="col-2 ml-5">       
                    <div class="form-group">
                        <select id="mes" class="custom-select">
                            <option value="" selected>-SELECCIONE MES-</option>
                            <option value="1">ENERO</option>
                            <option value="2">FEBRERO</option>
                            <option value="3">MARZO</option>
                            <option value="4">ABRIL</option>
                            <option value="5">MAYO</option>
                            <option value="6">JUNIO</option>
                            <option value="7">JULIO</option>
                            <option value="8">AGOSTO</option>
                            <option value="9">SEPTIEMBRE</option>
                            <option value="10">OCTUBRE</option>
                            <option value="11">NOVIEMBRE</option>
                            <option value="12">DICIEMBRE</option>
                        </select>
                    </div> 
                </div>
                
            </div>
            
        </form>         
        
        <div class="row top-buffer"></div>
        <span id='busqueda_error' class="text-danger"></span>
        
        <form class="form-inline">
            <button type="button" class="btn btn-outline-success col-2" onclick="buscar();">Enviar</button>
            <button type="button" class="btn btn-outline-success ml-5 col-2" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-outline-success ml-5 col-2" onclick="printDiv();">Imprimir</button>
            <button type="button" class="btn btn-outline-danger ml-5 col-2" onclick="irMenu();">Volver</button>
        </form>  
        
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>         

        <div class="row justify-content-end"><div id="monto_inicialDiv" class="w-auto"></div></div>

        <hr>
        
        <div id="printDiv"></div>
            
    </div>
</body>
</html>