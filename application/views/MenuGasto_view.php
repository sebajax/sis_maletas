<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Aerolinea</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>.top-buffer { margin-top:20px; }</style>
    
    <script type="text/javascript">
        function irAltaTipoGasto() {
            window.location.href = "<?php echo base_url("AltaTipoGasto"); ?>";
        }
        function irConsultarEliminarTipoGasto() {
            window.location.href = "<?php echo base_url("EliminarModificarTipoGasto"); ?>";
        }
        function irAltaGasto() {
            window.location.href = "<?php echo base_url("AltaGasto"); ?>";
        }        
        function irConsultarEliminarGasto() {
            window.location.href = "<?php echo base_url("EliminarModificarGasto"); ?>";
        }   
        function irTransaccionesGasto() {
            window.location.href = "<?php echo base_url("TransaccionesGasto"); ?>";
        }            
        function irMenuPrincipal() {
            window.location.href = "<?php echo base_url("MenuPrincipal"); ?>";
        }        
    </script>    
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("MenuPrincipal"); ?>">Menu Principal</a></li>
            <li class="active">Menu Gasto</li>
        </ol>        
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
            <ul class="nav nav-pills nav-justified">
                <li role="presentation"><a href="<?php echo base_url("MenuPrincipal"); ?>">Principal</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuBdo"); ?>">BDO</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuSector"); ?>">Sector</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuAerolinea"); ?>">Aerolinea</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuValor"); ?>">Valor</a></li>
                <li role="presentation" class="active"><a href="#">Gasto</a></li>
                <li role="presentation"><a href="<?php echo base_url("ModuloCaja"); ?>">Caja</a></li>
                <li role="presentation"><a href="<?php echo base_url("Login"); ?>">Salir</a></li>
            </ul>  
        </div>
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu Gasto</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menugastoform", "name" => "menugastoform");
        echo form_open("MenuGasto/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaTipoGasto();">INGRESAR TIPO DE GASTO</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irConsultarEliminarTipoGasto();">CONSULTAR ELIMINAR MODIFICAR TIPO DE GASTO</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaGasto();">INGRESAR GASTO</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irConsultarEliminarGasto();">CONSULTAR ELIMINAR MODIFICAR GASTO</button>
                <div class="row top-buffer"></div>  
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irTransaccionesGasto();">TRANSACCIONES GASTO</button>
                <div class="row top-buffer"></div>                  
                <button type="button" class="btn btn-danger btn-lg btn-block" onclick="irMenuPrincipal();">VOLVER A MENU PRINCIPAL</button>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>