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
        function irAltaAerolineas() {
            window.location.href = "<?php echo base_url("AltaAerolinea"); ?>";
        }
        function irConsultarEliminarAerolineas() {
            window.location.href = "<?php echo base_url("EliminarModificarAerolinea"); ?>";
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
            <li class="active">Menu Aerolinea</li>
        </ol>        
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
            <ul class="nav nav-pills nav-justified">
                <li role="presentation"><a href="<?php echo base_url("MenuPrincipal"); ?>">Principal</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuBdo"); ?>">BDO</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuSector"); ?>">Sector</a></li>
                <li role="presentation" class="active"><a href="#">Aerolinea</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuValor"); ?>">Valor</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuGasto"); ?>">Gasto</a></li>
                <li role="presentation"><a href="<?php echo base_url("ModuloCaja"); ?>">Caja</a></li>                
                <li role="presentation"><a href="<?php echo base_url("Login"); ?>">Salir</a></li>
            </ul>  
        </div>
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu Aerolinea</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menuaerolineaform", "name" => "menuaerolineaform");
        echo form_open("MenuAerolinea/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaAerolineas();">INGRESAR AEROLINEAS</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irConsultarEliminarAerolineas();">CONSULTAR ELIMINAR MODIFICAR AEROLINEAS</button>
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