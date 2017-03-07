<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta B.D.O</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>.top-buffer { margin-top:20px; }</style>
    
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
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuBdo"); ?>">Menu B.D.O</a></li>
            <li class="active">Consulta B.D.O</li>
        </ol> 
        <legend>Consulta B.D.O</legend>
        <form class="form-inline">
          <div class="form-group">
            <label for="aerolinea">Aerolinea</label>
            <?php
            $attributes = 'class = "form-control" id = "aerolinea"';
            echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
            ?>
          </div>
          <div class="form-group">
            <label for="numero">Numero</label>
            <input id="numero" name="numero" placeholder="numero bdo" type="text" class="form-control" />
          </div>
          <div class="form-group">
            <label for="pasajero">Pasajero</label>
            <input id="pasajero" name="pasajero" placeholder="nombre pasajero" type="text" class="form-control" />
          </div>            
        </form> 
        <div class="row top-buffer"></div>
        <form class="form-inline">
            <div class="form-group">
                <label for="fecha_desde">Fecha desde</label>
                <input id="fecha_desde" name="fecha_desde" placeholder="fecha llegada desde" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <label for="fecha_hasta">Fecha hasta</label>
                <input id="fecha_hasta" name="fecha_hasta" placeholder="fecha llegada hasta" type="text" class="form-control" />
            </div>            
            <div class="form-group">
                <label for="grupo_sector">Grupo sector</label>
                <?php
                $attributes = 'class = "form-control" id = "grupo_sector"';
                echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                ?>
            </div>
        </form>    
        <div class="row top-buffer"></div>
        <form class="form-inline">
            <div class="form-group">
                <label for="estado">Estado</label>
                <select class = "form-control" id = "estado">
                    <option value="">-SELECCIONE-</option>
                    <option value="0">ABIERTO</option>
                    <option value="1">CERRADO</option>
                </select>    
            </div> 
            <button type="button" class="btn btn-primary" onclick="buscarBdo();">Enviar</button>
            <button type="button" class="btn btn-primary" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-primary" onclick="printDiv();">Imprimir</button>
            <button type="button" class="btn btn-danger" onclick="irMenu();">Volver</button>
        </form>         
        
        <div class="form-group">
            <div id="alert_placeholder"></div>
        </div>         
        
        <hr />
        
        <div id="printDiv">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#<span id="th_order"></span></th>
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
</div>

<!-- Modal informacion b.d.o -->
<div id="informacion_bdo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">INFORMACION EXTRA B.D.O</h4>
            </div>
            <div class="modal-body" id="informacion_extra_bdo"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>