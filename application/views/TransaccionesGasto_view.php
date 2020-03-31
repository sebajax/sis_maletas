<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones Gasto</title>
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
            $("#busqueda_error").html("");
            var tipo_gasto   = $("#tipo_gasto").val();
            var fecha_desde  = $("#fecha_desde").val();
            var fecha_hasta  = $("#fecha_hasta").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
            */ 
            
            /*
            if(!tipo_gasto) {
                $("#busqueda_error").html(manejoMensajes("vacio", "aerolinea"));
                $("#aerolinea").focus();
                return false;
            }
            */
            
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
            
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("TransaccionesGasto/buscarTransacciones"); ?>",
                data: { tipo_gasto: tipo_gasto, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta}
            }).done(function(data) {
                $("#cuerpo").html(data['tbody']);
            });
        }
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("TransaccionesGasto/exportarExcel"); ?>";
        }  
    </script>
    
</head>
<body>
    
    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu Gasto</li>
                <li class="breadcrumb-item active">Transacciones Gasto</li>
            </ol> 
        </nav>
        
        <legend>Transacciones Gasto</legend>
        
        
        <form class="my-3">
            
            <div class="form-row">
            
            
                <div class="form-group col-2">
                    <?php
                    $attributes = 'class="custom-select" id="tipo_gasto"';
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
        
        <span id='busqueda_error' class="text-danger"></span>
        <form class="form-inline mt-3">      
            <button type="button" class="btn btn-outline-success col-2" onclick="buscarGasto();">Enviar</button>
            <button type="button" class="btn btn-outline-success ml-5 col-2" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-outline-success ml-5 col-2" onclick="printDiv();">Imprimir</button>
            <button type="button" class="btn btn-outline-danger ml-5 col-2" onclick="irMenu();">Volver</button>
        </form>  

        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>          

        <hr />           

        <div id="printDiv">
            <table class="table table-hover table-bordered" id="transacciones">
              <thead class="thead-dark">
                <tr>
                    <th>Tipo Gasto</th>
                    <th>Fecha</th>
                    <th>Comentario</th>
                    <th>Monto</th>
                </tr>
              </thead>
              <tbody id="cuerpo"></tbody>
            </table>
        </div>
        <input id="ordenamiento" type="hidden" value=""/>
    </div>
</body>
</html>