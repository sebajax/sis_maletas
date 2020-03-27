<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta B.D.O</title>
    <?php require_once "MenuPrincipal_view.php"; ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#menu_bdo").addClass("active");
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
            var iva = 0;
            var total = 0;
            
            if(aerolinea == 0 || grupo_sector == 0 || cantidad_maletas == 0) { return false; }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("AltaBdo/cargoValor"); ?>",
                data: { aerolinea: aerolinea, grupo_sector: grupo_sector, cantidad_maletas: cantidad_maletas}
            }).done(function(data) {
                iva = eval(data) * 0.19;
                total = eval(iva) + eval(data);
                $("#valor_estimado").val(data);
                $("#iva").val(iva);
                $("#valor").val(total);
            });            
        } 
        
        function verificar_valores() {
            var valor            = $("#valor").val();
            var valor_estimado   = $("#valor_estimado").val();
            var total            = eval($("#iva").val()) + eval(valor_estimado);
            if(valor != total) {
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
            $("#iva").val("");
        }
    </script>
</head>

<body>

<br/>
    
<div class="container">
    <div class="row">
        <div class="col-sm">   
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-primary">Menu B.D.O</li>
                    <li class="breadcrumb-item active">Alta B.D.O</li>
                </ol> 
            </nav>    


            <div class="jumbotron w-100 p-3 mx-auto">

            <legend>Alta B.D.O</legend>

            <form>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="numero_addon">Numero</span>
                        </div>                    
                        <input aria-label="numero bdo" aria-describedby="numero_addon" id="numero" name="numero" placeholder="numero bdo" type="text" class="form-control">
                    </div>
                    <span id="numero_error" class="text-danger"></span>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="aerolinea_addon">Aerolinea</span>
                        </div>                    
                        <?php
                        $attributes = 'class = "form-control" id = "aerolinea" aria-label="aerolinea" aria-describedby="aerolinea_addon"';
                        echo form_dropdown('aerolinea', $aerolinea, set_value('aerolinea'), $attributes);
                        ?>
                    </div>
                    <span id="aerolinea_error" class="text-danger"></span>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="fecha_llegada_addon">Fecha Llegada</span>
                        </div>                    
                        <input aria-label="fecha llegada" aria-describedby="fecha_llegada_addon" id="fecha_llegada" name="fecha_llegada" placeholder="fecha llegada" type="text" class="form-control">
                    </div>
                    <span id='fecha_llegada_error' class="text-danger"></span>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="nombre_pasajero_addon">Nombre Pasajero</span>
                        </div>                    
                        <input aria-label="nombre pasajero" aria-describedby="nombre_pasajero_addon" id="nombre_pasajero" name="nombre_pasajero" placeholder="nombre pasajero" type="text" class="form-control">
                    </div>
                    <span id='nombre_pasajero_error' class="text-danger"></span>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="cantidad_maletas_addon">Cantidad Maleta</span>
                        </div>                    
                        <input aria-label="cantidad maletas" aria-describedby="cantidad_maletas_addon" id="cantidad_maletas" name="cantidad_maletas" placeholder="cantidad de maletas" type="text" class="form-control">
                    </div>
                    <span id='cantidad_maletas_error' class="text-danger"></span>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="region_addon">Region</span>
                        </div>
                        <?php
                        $attributes = 'class = "form-control" id = "region" aria-label="region" aria-describedby="region_addon"';
                        echo form_dropdown('region', $region, set_value('region'), $attributes);
                        ?>
                        <span id='region_error' class="text-danger"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="grupo_sector_addon">Grupo sector</span>
                        </div>
                        <?php
                        $attributes = 'class = "form-control" id = "grupo_sector" aria-label="grupo_sector" aria-describedby="grupo_sector_addon"';
                        echo form_dropdown('grupo_sector', $grupo_sector, set_value('grupo_sector'), $attributes);
                        ?>
                    </div>
                    <span id='grupo_sector_error' class="text-danger"></span>
                </div>    

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="lugar_sector_addon">Lugar sector</span>
                        </div>
                            <select class="form-control" id="lugar_sector" aria-label="lugar sector" aria-describedby="lugar_sector_addon"> </select>
                    </div>
                    <span id='lugar_sector_error' class="text-danger"></span>
                </div> 

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="dureccion_addon">Direccion</span>
                        </div>
                        <textarea class="form-control noresize" rows="5" id="direccion" placeholder="direccion" aria-label="direccion" aria-describedby="direccion_addon"></textarea>
                    </div>
                    <span id='direccion_error' class="text-danger"></span>
                </div>            

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="telefono_addon">Telefono</span>
                        </div>
                        <input id="telefono" name="telefono" placeholder="telefono" type="text" class="form-control" aria-label="telefono" aria-describedby="telefono_addon">
                    </div>
                    <span id='telefono_error' class="text-danger"></span>
                </div>             

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="valor_estimado_addon">Valor Estimado</span>
                            <span class="input-group-text" id="valor_estimado_addon">$</span>
                        </div>
                        <input id="valor_estimado" name="valor_estimado" placeholder="valor" type="text" class="form-control" aria-label="valor estimado" aria-describedby="valor_estimado_addon" readonly>
                    </div>
                </div>             

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="iva_addon">IVA</span>
                            <span class="input-group-text" id="iva_addon">$</span>
                        </div>
                        <input id="iva" name="iva" placeholder="iva" type="text" class="form-control" aria-label="iva" aria-describedby="iva_addon" readonly>
                    </div>
                </div>              

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend w-25">
                            <span class="input-group-text bg-primary text-white w-100" id="region_addon">Valor</span>
                            <span class="input-group-text" id="valor_estimado_addon">$</span>
                        </div>
                        <input id="valor" name="valor" placeholder="valor" type="text" class="form-control" aria-label="direccion" aria-describedby="direccion_addon">
                    </div>
                    <span id='valor_error' class="text-danger"></span>
                </div>  

                <div class="form-group">
                    <div id="alert_placeholder"></div>
                </div>            

                <div class="form-group">
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2"><input id="btn_insertar" name="btn_insertar" type="button" class="btn btn-outline-success" value="Alta B.D.O" onclick="verificar_valores();"></div>
                        <div class="p-2"><input id="btn_cancelar" name="btn_cancelar" type="reset" class="btn btn-outline-danger" value="Cancelar"></div>
                    </div>
                </div>

            </form>

            <?php echo form_close(); ?>
        </div>
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
                <button type="button" class="btn btn-outline-success" data-dismiss="modal" id="confirmar">Confirmar</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>      
</body>
</html>