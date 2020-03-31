<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones Gasto</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>
        .top-buffer { margin-top:20px; }
    </style>
    
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
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuGasto"); ?>";
        } 
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("TransaccionesGasto/exportarExcel"); ?>";
        }  
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuGasto"); ?>">Menu Gasto</a></li>
            <li class="active">Transacciones Gasto</li>
        </ol> 
        <legend>Transacciones Gasto</legend>
        <form class="form-inline">
            <div class="form-group">
                <label for="tipo_gasto">Tipo gasto</label>
                <?php
                $attributes = 'class = "form-control" id = "tipo_gasto"';
                echo form_dropdown('tipo_gasto', $tipo_gasto, set_value('tipo_gasto'), $attributes);
                ?>
            </div>
            <div class="form-group">
                <label for="fecha_desde">Fecha desde</label>
                <input id="fecha_desde" name="fecha_desde" placeholder="fecha desde" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <label for="fecha_hasta">Fecha hasta</label>
                <input id="fecha_hasta" name="fecha_hasta" placeholder="fecha hasta" type="text" class="form-control" />
            </div>   
        </form> 
        <div class="row top-buffer"></div>
        <span id='busqueda_error' class="text-danger"></span>
        <form class="form-inline">
            <button type="button" class="btn btn-primary" onclick="buscarGasto();">Enviar</button>
            <button type="button" class="btn btn-primary" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-primary" onclick="printDiv();">Imprimir</button>
            <button type="button" class="btn btn-danger" onclick="irMenu();">Volver</button>
        </form>         
        
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <div id="printDiv">
            <table class="table table-hover" id="transacciones">
              <thead>
                <tr>
                    <th>#<span id="th_order"></span></th>
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
</div>
</body>
</html>