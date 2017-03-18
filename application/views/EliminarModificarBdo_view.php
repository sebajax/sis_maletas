<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Modificar B.D.O</title>
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
        
        function irAMenu() {
            window.location.href = "<?php echo base_url("MenuBdo"); ?>";
        } 
        
        function buscarBdo() {
            var aerolinea    = $("#aerolinea").val();
            var numero       = $("#numero").val();
            var pasajero     = $("#pasajero").val();
            var fecha_desde  = $("#fecha_desde").val();
            var fecha_hasta  = $("#fecha_hasta").val();
            var grupo_sector = $("#grupo_sector").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarBdo/buscarBdo"); ?>",
                data: { aerolinea: aerolinea, numero: numero, pasajero: pasajero, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function grupoSectorEvents() {
            cargoValor();
            cargoLugares($("#grupo_sector_new").val());
        }

        function cargoInformacionExtra(numero, id_aerolinea) {
            $("#informacion_extra_bdo").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarBdo/cargoInformacionExtra"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea }
            }).done(function(data) {
                $("#informacion_extra_bdo").html(data);
                $('#informacion_bdo').modal('show');
            });
        }
        
        function modificarBdoForm(numero, id_aerolinea) {
            $("#modificar_bdo_form").html("");
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarBdo/modificarBdoForm"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea }
            }).done(function(data) {
                $("#modificar_bdo_form").html(data);
                $("#fecha_llegada_new").datepicker();
                cargoValorEstimado();
                $('#modificar_bdo').modal('show');
            });
        }        
        
        function modificarBdo(numero, id_aerolinea) {
            var fecha_llegada_new = $("#fecha_llegada_new").val();
            var nombre_pasajero_new = $("#nombre_pasajero_new").val();
            var cantidad_maletas_new = $("#cantidad_maletas_new").val();
            var region_new = $("#region_new").val();
            var direccion_new = $("#direccion_new").val();
            var telefono_new = $("#telefono_new").val();
            var grupo_sector_new = $("#grupo_sector_new").val();
            var lugar_sector_new = $("#lugar_sector_new").val();
            var valor_new = $("#valor_new").val();            
        
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!numero) {
                $("#numero_new").focus();
                return false;
            }
            
            if(!id_aerolinea) {
                $("#aerolinea_new").focus();
                return false;
            }
            
            if(!fecha_llegada_new) {
                $("#fecha_llegada_new").focus();
                return false;
            }
            
            if(!nombre_pasajero_new) {
                $("#nombre_pasajero_new").focus();
                return false;
            }
            
            if(!cantidad_maletas_new) {
                $("#cantidad_maletas_new").focus();
                return false;
            }
            
            if(!region_new) {
                $("#region_new").focus();
                return false;
            }
            
            if(!direccion_new) {
                $("#direccion_new").focus();
                return false;
            }
            
            if(!telefono_new) {
                $("#telefono_new").focus();
                return false;
            }
            
            if(!grupo_sector_new) {
                $("#grupo_sector_new").focus();
                return false;
            }    
            
            if(!lugar_sector_new) {
                $("#lugar_sector_new").focus();
                return false;
            }              
            
            if(!valor_new) {
                $("#valor_new").focus();
                return false;
            } 
            
            /*
             * VERIFICO NUMERICOS
             */
            if(!isNumber(cantidad_maletas_new)) {
                $("#cantidad_maletas_new").focus();
                return false;                
            }
            
            if(!isNumber(valor_new)) {
                $("#valor_new").focus();
                return false;                
            }            
            
            /*
             * VERIFICO FECHAS
             */
            if(!isValidDate(fecha_llegada_new)) {
                $("#fecha_llegada_new").focus();
                return false;                
            }          
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarBdo/modificarBdo"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea, fecha_llegada_new: fecha_llegada_new, nombre_pasajero_new: nombre_pasajero_new, cantidad_maletas_new: cantidad_maletas_new, region_new: region_new, direccion_new: direccion_new, telefono_new: telefono_new, grupo_sector_new: grupo_sector_new, lugar_sector_new: lugar_sector_new, valor_new: valor_new }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("CORRECTO: datos de bdo modificados.", "alert-success");
                    buscarBdo();
                }else {
                    mostrarMensaje("ERROR: no se pudieron modificar datos de la bdo.", "alert-danger");
                }
            });            
        }
        
        function verificar_valores(numero, id_aerolinea) {
            var valor            = $("#valor_new").val();
            var valor_estimado   = $("#valor_estimado_new").val();
            if(valor != valor_estimado) {
                $('#confirm_valores').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                .one('click', '#confirmar_valores', function() {
                    modificarBdo(numero, id_aerolinea);
                });                
            }else {
                modificarBdo(numero, id_aerolinea);
            }
        }        
        
        function cancelarModificarBdo() {
            $('#modificar_bdo').modal('toggle');
        }        

        function cancelarComentario() {
            $('#comentario_bdo').modal('toggle');
        }    

        function eliminarBdo(numero, id_aerolinea) {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo base_url("EliminarModificarBdo/eliminarBdo"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea }
            }).done(function(data) {
                if(data['estado'] == "1") {
                    mostrarMensaje(data['mensaje'], "alert-success");
                    buscarBdo();
                }else {
                    mostrarMensaje(data['mensaje'], "alert-danger");
                }
            });            
        }   
        
        function cargoLugares(grupo_sector) {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaBdo/cargoLugares"); ?>",
                data: { grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#lugar_sector_new").html(data);
            });            
        }  
        
        function cargoValor() {
            var aerolinea    = $("#aerolinea_new").val();
            var grupo_sector = $("#grupo_sector_new").val();
            var cantidad_maletas = $("#cantidad_maletas_new").val();
            
            if(aerolinea == 0 || grupo_sector == 0 || cantidad_maletas == 0) { return false; }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaBdo/cargoValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector, cantidad_maletas: cantidad_maletas}
            }).done(function(data) {
                $("#valor_estimado_new").val(data);
                $("#valor_new").val(data);
            });            
        }
        
        function cargoValorEstimado() {
            var aerolinea    = $("#aerolinea_new").val();
            var grupo_sector = $("#grupo_sector_new").val();
            var cantidad_maletas = $("#cantidad_maletas_new").val();
            
            if(aerolinea == 0 || grupo_sector == 0 || cantidad_maletas == 0) { return false; }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaBdo/cargoValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector, cantidad_maletas: cantidad_maletas}
            }).done(function(data) {
                $("#valor_estimado_new").val(data);
            });            
        }        
        
        function ordenarBuscar(parametro) {
            ordenamiento();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarBdo/ordenarBuscar"); ?>",
                data: { parametro: parametro, ordenamiento: $("#ordenamiento").val() }
            }).done(function(data) {
                $("#cuerpo").html(data);
            });
        }
        
        function exportarExcel() {
            window.location.href = "<?php echo base_url("EliminarModificarBdo/exportarExcel"); ?>";
        }    
        
        function cofirmaEliminar(numero, id_aerolinea) {
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#delete', function () {
                    eliminarBdo(numero, id_aerolinea);
            });        
        }  
        
        function agregarComentarioForm(numero, id_aerolinea, nombre_aerolinea) {
            $("#numero_comentario").val(numero);
            $("#id_aerolinea_comentario").val(id_aerolinea);
            $("#nombre_aerolinea_comentario").val(nombre_aerolinea);
            $("#comentario").val("");
            $('#comentario_bdo').modal('show');            
        }
        
        function agregarComentario() {
            var numero = $("#numero_comentario").val();
            var id_aerolinea = $("#id_aerolinea_comentario").val();
            var comentario = $("#comentario").val();
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("EliminarModificarBdo/agregarComentario"); ?>",
                data: { numero: numero, id_aerolinea: id_aerolinea, comentario: comentario }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Comentario agregado correctamente.", "alert-success");
                }else {
                    mostrarMensaje("ERROR: Problemas al agregar comentario.", "alert-danger");
                }
            });            
        }
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuBdo"); ?>">Menu B.D.O</a></li>
            <li class="active">Eliminar Modificar B.D.O</li>
        </ol>         
        <legend>Eliminar Modificar B.D.O</legend>
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
            <button type="button" class="btn btn-primary"onclick="buscarBdo()" id="btnenviar">Enviar</button>
            <button type="button" class="btn btn-primary" onclick="exportarExcel();">Exportar Excel</button>
            <button type="button" class="btn btn-primary" onclick="printDiv();">Imprimir</button>
            <button type="button" class="btn btn-danger" onclick="irAMenu()" id="btnvolver">Volver</button>
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
                  <th>Coment</th>
                  <th>Modif</th>
                  <th>Eliminar</th>
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
     <div class="modal-body" id="informacion_extra_bdo">
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     </div>
   </div>
 </div>
</div>

<!-- Modal modificar b.d.o -->
<div id="modificar_bdo" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">MODIFICAR BDO</h4>
            </div>
            <div class="modal-body" id="modificar_bdo_form"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="confirm" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
               ¿ Seguro quieres eliminar el registro ?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Borrar</button>
                <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
            </div>
        </div>   
    </div>    
</div>

<!-- Modal confirmacion BDO valores distintos -->
<div id="confirm_valores" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                El valor estimado es distinto al valor ingresado, esta seguro que desea realizar el ingreso.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmar_valores">Confirmar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div> 

<!-- Agregar comentario modal -->
<div id="comentario_bdo" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar comentario a BDO</h4>
            </div>
            <div class="modal-body" id="comentario_bdo_form">
                <form>
                    <div class="form-group">
                        <label for="numero_comentario" class="control-label">Numero</label>
                        <input id="numero_comentario" disabled= "disabled" name="numero_comentario" placeholder="numero bdo" type="text" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="nombre_aerolinea_comentario" class="control-label">Aerolinea</label>
                        <input id="nombre_aerolinea_comentario" disabled= "disabled" name="nombre_aerolinea_comentario" placeholder="aerolinea" type="text" class="form-control"/>
                        <input id="id_aerolinea_comentario" disabled= "disabled" name="id_aerolinea_comentario" placeholder="aerolinea" type="hidden" class="form-control"/>
                    </div>                    
                    <div class="form-group">
                        <label for="comentario" class="control-label">Comentario</label>
                        <textarea class="form-control noresize" rows="8" id="comentario" placeholder="comentario"></textarea>
                    </div>
                    <input id="btn_comentario" name="btn_comentario" type="button" class="btn btn-primary" value="Agregar comentario" onclick="agregarComentario();" />
                    <input id="btn_cancelar" name="btn_cancelar_comentario" type="reset" class="btn btn-danger" value="Cancelar" onclick="cancelarComentario();"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>