<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta B.D.O</title>
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
            
            $("#fecha_llegada").datepicker();
            
            $("#grupo_sector").on("change", function() {
                cargoValor();
                cargoLugares(this.value);
            });
            
            $("#aerolinea").on("change", function() {
                cargoValor();
            });  
            
            $("#cantidad_maletas").on("change", function() {
                cargoValor();
            });  
        });
        
        function altaBDO() {
            $("span.text-danger").html('');
            
            var numero           = $("#numero").val();
            var aerolinea        = $("#aerolinea").val();
            var fecha_llegada    = $("#fecha_llegada").val();
            var nombre_pasajero  = $("#nombre_pasajero").val();
            var cantidad_maletas = $("#cantidad_maletas").val();
            var region           = $("#region").val();
            var direccion        = $("#direccion").val();
            var telefono         = $("#telefono").val();
            var grupo_sector     = $("#grupo_sector").val();
            var lugar_sector     = $("#lugar_sector").val();
            var valor            = $("#valor").val();
            
            /*
             * VERIFICO ELEMENTOS VACIOS 
             */
            if(!numero) {
                $("#numero_error").html(manejoMensajes("vacio", "numero"));
                $("#numero").focus();
                return false;
            }
            
            if(!aerolinea) {
                $("#aerolinea_error").html(manejoMensajes("vacio", "aerolinea"));
                $("#aerolinea").focus();
                return false;
            }
            
            if(!fecha_llegada) {
                $("#fecha_llegada_error").html(manejoMensajes("vacio", "fecha_llegada"));
                $("#fecha_llegada").focus();
                return false;
            }
            
            if(!nombre_pasajero) {
                $("#nombre_pasajero_error").html(manejoMensajes("vacio", "nombre_pasajero"));
                $("#nombre_pasajero").focus();
                return false;
            }
            
            if(!cantidad_maletas) {
                $("#cantidad_maletas_error").html(manejoMensajes("vacio", "cantidad_maletas"));
                $("#cantidad_maletas").focus();
                return false;
            }
            
            if(!region) {
                $("#region_error").html(manejoMensajes("vacio", "region"));
                $("#region").focus();
                return false;
            }
            
            if(!direccion) {
                $("#direccion_error").html(manejoMensajes("vacio", "direccion"));
                $("#direccion").focus();
                return false;
            }
            
            if(!telefono) {
                $("#telefono_error").html(manejoMensajes("vacio", "telefono"));
                $("#telefono").focus();
                return false;
            }
            
            if(!grupo_sector) {
                $("#grupo_sector_error").html(manejoMensajes("vacio", "grupo sector"));
                $("#grupo_sector").focus();
                return false;
            }    
            
            if(!lugar_sector) {
                $("#lugar_sector_error").html(manejoMensajes("vacio", "lugar sector"));
                $("#lugar_sector").focus();
                return false;
            }              
            
            if(!valor) {
                $("#valor_error").html(manejoMensajes("vacio", "valor"));
                $("#valor").focus();
                return false;
            } 
            
            /*
             * VERIFICO NUMERICOS
             */
            if(!isNumber(cantidad_maletas)) {
                $("#cantidad_maletas_error").html(manejoMensajes("numerico", "cantidad_maletas"));
                $("#cantidad_maletas").focus();
                return false;                
            }
            
            if(!isNumber(valor)) {
                $("#valor_error").html(manejoMensajes("numerico", "valor"));
                $("#valor").focus();
                return false;                
            }            
            
            /*
             * VERIFICO FECHAS
             */
            if(!isValidDate(fecha_llegada)) {
                $("#fecha_llegada_error").html(manejoMensajes("fecha", "fecha_llegada"));
                $("#fecha_llegada").focus();
                return false;                
            }  
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaBdo/altaBdo"); ?>",
                data: { numero: numero, aerolinea: aerolinea, fecha_llegada: fecha_llegada, nombre_pasajero: nombre_pasajero, cantidad_maletas: cantidad_maletas, region: region, direccion: direccion, telefono: telefono, grupo_sector: grupo_sector, lugar_sector: lugar_sector,valor: valor }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
                    resetear_bdo();
                }else if(data == "PK") {
                    mostrarMensaje("El numero de b.d.o que desea ingresar, ya existe.", "alert-danger");
                }else {
                    mostrarMensaje("Datos erroneos favor verifique.", "alert-danger");
                }
            });
        }
        
        function cargoLugares(grupo_sector) {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaBdo/cargoLugares"); ?>",
                data: { grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#lugar_sector").html(data);
            });            
        }  
        
        function cargoValor() {
            var aerolinea    = $("#aerolinea").val();
            var grupo_sector = $("#grupo_sector").val();
            var cantidad_maletas = $("#cantidad_maletas").val();
            
            if(aerolinea == 0 || grupo_sector == 0 || cantidad_maletas == 0) { return false; }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaBdo/cargoValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector, cantidad_maletas: cantidad_maletas}
            }).done(function(data) {
                $("#valor_estimado").val(data);
                $("#valor").val(data);
            });            
        } 
        
        function irMenu() {
            window.location.href = "<?php echo base_url("MenuBdo"); ?>";
        }  
        
        function verificar_valores() {
            var valor            = $("#valor").val();
            var valor_estimado   = $("#valor_estimado").val();
            if(valor != valor_estimado) {
                $('#confirm').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                .one('click', '#confirmar', function() {
                    altaBDO();
                });                
            }else {
                altaBDO();
            }
        }
        
        function resetear_bdo() {
            $("#numero").val("");
            $("#fecha_llegada").val("");
            $("#nombre_pasajero").val("");
            $("#cantidad_maletas").val("");
            $("#direccion").val("");
            $("#telefono").val("");
            $("#valor").val("");     
            $("#valor_estimado").val("");
        }
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li><a href="<?php echo base_url("MenuBdo"); ?>">Menu B.D.O</a></li>
            <li class="active">Alta B.D.O</li>
        </ol>         
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Alta B.D.O</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "altabdoform", "name" => "altabdoform");
        echo form_open("AltaBdo/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="numero" class="control-label">Numero</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="numero" name="numero" placeholder="numero bdo" type="text" class="form-control" />
                        <span id='numero_error' class="text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="aerolinea" class="control-label">Aerolinea</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <?php
                        $attributes = 'class = "form-control" id = "aerolinea"';
                        echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                        ?>
                        <span id='aerolinea_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="fecha_llegada" class="control-label">Fecha Llegada</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="fecha_llegada" name="fecha_llegada" placeholder="fecha llegada" type="text" class="form-control" />
                        <span id='fecha_llegada_error' class="text-danger"></span>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="nombre_pasajero" class="control-label">Nombre Pasajero</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="nombre_pasajero" name="nombre_pasajero" placeholder="nombre pasajero" type="text" class="form-control" />
                        <span id='nombre_pasajero_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            

            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="cantidad_maletas" class="control-label">Cantidad Maletas</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="cantidad_maletas" name="cantidad_maletas" placeholder="cantidad maletas" type="text" class="form-control" />
                        <span id='cantidad_maletas_error' class="text-danger"></span>
                    </div>
                </div>
            </div>  
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="region" class="control-label">Region</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <?php
                        $attributes = 'class = "form-control" id = "region"';
                        echo form_dropdown('region', $region, set_value('region'), $attributes);
                        ?>
                        <span id='region_error' class="text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="grupo_sector" class="control-label">Grupo sector</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <?php
                        $attributes = 'class = "form-control" id = "grupo_sector"';
                        echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                        ?>
                        <span id='grupo_sector_error' class="text-danger"></span>
                    </div>
                </div>
            </div>    
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="lugar_sector" class="control-label">Lugar sector</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <select class="form-control" id="lugar_sector"> </select>
                        <span id='lugar_sector_error' class="text-danger"></span>
                    </div>
                </div>
            </div> 

            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="direccion" class="control-label">Direccion</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <textarea class="form-control noresize" rows="5" id="direccion" placeholder="direccion"></textarea>
                        <span id='direccion_error' class="text-danger"></span>
                    </div>
                </div>
            </div>            

            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="telefono" class="control-label">Telefono</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="telefono" name="telefono" placeholder="telefono" type="text" class="form-control" />
                        <span id='telefono_error' class="text-danger"></span>
                    </div>
                </div>
            </div>             
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="valor_estimado" class="control-label">Estimado</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">CLP</div>
                            <input id="valor_estimado" name="valor_estimado" placeholder="valor" type="text" class="form-control" readonly/>
                        </div>
                        <span id='valor_estimado_error' class="text-danger"></span>
                    </div>
                </div>
            </div>             
            
            <div class="form-group">
                <div class="row colbox">
                    <div class="col-lg-4 col-sm-4">
                        <label for="valor" class="control-label">Valor</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">CLP</div>
                            <input id="valor" name="valor" placeholder="valor" type="text" class="form-control" />
                        </div>
                        <span id='valor_error' class="text-danger"></span>
                    </div>
                </div>
            </div>  
            
            <div class="form-group">
                <div id="alert_placeholder"></div>
            </div>            
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Alta B.D.O" onclick="verificar_valores();" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" />
                <input id="btn_volver" name="btn_volver" type="button" class="btn btn-primary" value="Volver" onclick="irMenu();" />
            </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- Modal confirmacion BDO valores distintos -->
<div id="confirm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                El valor estimado es distinto al valor ingresado, esta seguro que desea realizar el ingreso.
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