<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta B.D.O</title>
    <!--link the bootstrap css file-->
    <link href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- link jquery ui css-->
    <link href="<?php echo base_url('assets/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!--include jquery library-->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <!--load jquery ui js file-->
    <script src="<?php echo base_url('assets/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <!--load functions js file-->
    <script src="<?php echo base_url('assets/js/functions.js'); ?>"></script>        
    
    <style type="text/css">
        .colbox {
            margin-left: 0px;
            margin-right: 0px;
        }
        .noresize {
            resize: none; 
        } 

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
            
            $("#fecha_llegada").datepicker();
            
            $("#grupo_sector").on("change", function() {
                cargoLugares(this.value);
            });
            
            $("#lugar_sector").on("change", function() {
                cargoValor();
            });   
            
            $("#aerolinea").on("change", function() {
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
            var comuna           = $("#comuna").val();
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
            
            if(!comuna) {
                $("#comuna_error").html(manejoMensajes("vacio", "comuna"));
                $("#comuna").focus();
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
                url: "<?php echo base_url("index.php/alta_bdo/altaBdo"); ?>",
                data: { numero: numero, aerolinea: aerolinea, fecha_llegada: fecha_llegada, nombre_pasajero: nombre_pasajero, cantidad_maletas: cantidad_maletas, region: region, comuna: comuna, direccion: direccion, telefono: telefono, grupo_sector: grupo_sector, lugar_sector: lugar_sector,valor: valor }
            }).done(function(data) {
                if(data == "OK") {
                    mostrarMensaje("Datos almacenados correctamente.", "alert-success");
                    resetearFormulario();
                }else if(data == "PK"){
                    mostrarMensaje("El numero de b.d.o que desea ingresar, ya existe.", "alert-danger");
                }else {
                    mostrarMensaje("Datos erroneos favor verifique.", "alert-danger");
                }
            });
        }
        
        function cargoLugares(grupo_sector) {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/alta_valores/cargoLugares"); ?>",
                data: { grupo_sector: grupo_sector }
            }).done(function(data) {
                $("#lugar_sector").html(data);
            });            
        }  
        
        function cargoValor() {
            var aerolinea    = $("#aerolinea").val();
            var grupo_sector = $("#grupo_sector").val();
            var lugar_sector = $("#lugar_sector").val();
            
            if(aerolinea == 0 || grupo_sector == 0 || lugar_sector == 0) { return false; }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("index.php/alta_bdo/cargoValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector, lugar_sector: lugar_sector }
            }).done(function(data) {
                $("#valor").val(data);
            });            
        }         
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Alta B.D.O</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "altabdoform", "name" => "altabdoform");
        echo form_open("alta_bdo/index", $attributes);
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
                        <label for="comuna" class="control-label">Comuna</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <input id="comuna" name="comuna" placeholder="comuna" type="text" class="form-control" />
                        <span id='comuna_error' class="text-danger"></span>
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
                        <label for="valor" class="control-label">Valor</label>
                    </div>
                    <div class="col-lg-8 col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">CLP</div>
                            <input id="valor" name="valor" placeholder="valor" type="text" class="form-control" readonly/>
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
                <input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-primary" value="Alta B.D.O" onclick="altaBDO();" />
                <input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-danger" value="Cancelar" />
            </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>