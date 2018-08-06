<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Valor</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>.top-buffer { margin-top:20px; }</style>
    
    <script type="text/javascript">
        function irAltaValores() {
            window.location.href = "<?php echo base_url("AltaValores"); ?>";
        }
        function irConsultarEliminarValores() {
            window.location.href = "<?php echo base_url("EliminarModificarValor"); ?>";
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
            <li class="active">Menu Valor</li>
        </ol>        
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
            <ul class="nav nav-pills nav-justified">
                <li role="presentation"><a href="<?php echo base_url("MenuPrincipal"); ?>">Principal</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuBdo"); ?>">BDO</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuSector"); ?>">Sector</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuAerolinea"); ?>">Aerolinea</a></li>
                <li role="presentation" class="active"><a href="#">Valor</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuGasto"); ?>">Gasto</a></li>
                <li role="presentation"><a href="<?php echo base_url("ModuloCaja"); ?>">Caja</a></li>                
                <li role="presentation"><a href="<?php echo base_url("Login"); ?>">Salir</a></li>
            </ul>  
        </div>      
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu Valor</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menuvalorform", "name" => "menuvalorform");
        echo form_open("MenuValor/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaValores();">INGRESAR VALORES</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irConsultarEliminarValores();">CONSULTAR MODIFICAR ELIMINAR VALORES</button>
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