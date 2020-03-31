<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta B.D.O</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#menu_bdo").addClass("active");
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

        function buscarBdo() {
            var aerolinea    = $("#aerolinea").val();
            var numero       = $("#numero").val();
            var pasajero     = $("#pasajero").val();
            var fecha_desde  = $("#fecha_desde").val();
            var fecha_hasta  = $("#fecha_hasta").val();
            var grupo_sector = $("#grupo_sector").val();
            var estado       = $("#estado").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("ConsultaBdo/buscarBdo"); ?>",
                data: { aerolinea: aerolinea, numero: numero, pasajero: pasajero, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, grupo_sector: grupo_sector, estado: estado }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function cargoInformacionExtra(numero, id_aerolinea) {
            $("#informacion_extra_bdo").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("ConsultaBdo/cargoInformacionExtra"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea }
            }).done(function(data) {
                $("#informacion_extra_bdo").html(data);
                $('#informacion_bdo').modal('show');
            });
        }
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuBdo"); ?>";
        } 
        
        function ordenarBuscar(parametro) {
            ordenamiento();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("ConsultaBdo/ordenarBuscar"); ?>",
                data: { parametro: parametro, ordenamiento: $("#ordenamiento").val() }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("ConsultaBdo/exportarExcel"); ?>";
        }  
    </script>
    
</head>
<body>

    <div class="p-3 mx-5">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary">Menu B.D.O</li>
                <li class="breadcrumb-item active">Consulta B.D.O</li>
            </ol> 
        </nav>           
    
        <legend>Consulta B.D.O</legend>

        <form class="my-3">
            
            <div class="form-row">
                
                <div class="form-group col-2">
                    <input id="numero" name="numero" placeholder="numero bdo" type="text" class="form-control" />
                </div>
                
                <div class="form-group col-2 ml-5">
                    <?php
                    $attributes = 'class = "custom-select" id = "aerolinea"';
                    echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                    ?>
                </div>
                
                <div class="form-group col-2 ml-5">
                    <input id="pasajero" name="pasajero" placeholder="nombre pasajero" type="text" class="form-control" >
                </div>
                
            </div>   
            
            <div class="form-row">
                
                <div class="form-group col-2">   
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
                
                <div class="form-group col-2 ml-5">
                    <?php
                    $attributes = 'class = "form-control" id = "grupo_sector"';
                    echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                    ?>
                </div>  
                
                <div class="form-group col-2 ml-5">
                    <select class = "form-control" id = "estado">
                        <option value="">-Estado B.D.O-</option>
                        <option value="0">ABIERTO</option>
                        <option value="1">CERRADO</option>
                    </select>    
                </div>  
                
            </div>  
            
        </form>  
       
        <form class="form-inline mt-3">      
            <button type="button" class="btn btn-outline-success col-2" onclick="buscarBdo();">Enviar</button>
            <button type="button" class="btn btn-outline-success ml-5 col-2" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-outline-success ml-5 col-2" onclick="printDiv();">Imprimir</button>
        </form>  
        
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>          
        
        <hr />
        
        <div id="printDiv">
            <table class="table table-hover table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('numero')">Numero BDO</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('id_aerolinea')">Aerolinea</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('nombre_pasajero')">Pasajero</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('cantidad_maletas')">Maletas</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('valor')">Valor</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('estado')">Estado</th>
                  <th style="cursor: pointer;" onclick="ordenarBuscar('fecha_llegada')">Fecha</th>
                  <th>Info</th>
                </tr>
              </thead>
              <tbody id="cuerpo"></tbody>
            </table>
        </div>
        <input id="ordenamiento" type="hidden" value=""/>        
        
    </div>        

    <!-- Modal informacion b.d.o -->
    <?php echo cargoModalInformacionExtra(); ?>
    
</body>
</html>