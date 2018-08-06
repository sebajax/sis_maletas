<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <?php require_once "assets/header/header.php"; ?>

    <style>.top-buffer { margin-top:20px; }</style>    
    
    <script type="text/javascript">
        function irMenuBdo() {
            window.location.href = "<?php echo base_url("MenuBdo"); ?>";
        }
        function irMenuAerolinea() {
            window.location.href = "<?php echo base_url("MenuAerolinea"); ?>";
        }
        function irMenuSector() {
            window.location.href = "<?php echo base_url("MenuSector"); ?>";
        }
        function irMenuValor() {
            window.location.href = "<?php echo base_url("MenuValor"); ?>";
        }
        function irMenuGasto() {
            window.location.href = "<?php echo base_url("MenuGasto"); ?>";
        }        
        function irModuloCaja() {
            window.location.href = "<?php echo base_url("ModuloCaja"); ?>";
        }           
        function cerrarSession() {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("MenuPrincipal/cerrar"); ?>",
            }).done(function() {
                window.location.href = "<?php echo base_url("Login"); ?>";
            });            
            
        }
    </script>    
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li class="active">Menu Principal</li>
        </ol>          
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
            <ul class="nav nav-pills nav-justified">
                <li role="presentation" class="active"><a href="#">Principal</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuBdo"); ?>">BDO</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuSector"); ?>">Sector</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuAerolinea"); ?>">Aerolinea</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuValor"); ?>">Valor</a></li>
                <li role="presentation"><a href="<?php echo base_url("MenuGasto"); ?>">Gasto</a></li>
                <li role="presentation"><a href="<?php echo base_url("ModuloCaja"); ?>">Caja</a></li>
                <li role="presentation"><a href="<?php echo base_url("Login"); ?>">Salir</a></li>
            </ul>  
        </div>      
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu Principal</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menuprincipalform", "name" => "menuprincipalform");
        echo form_open("MenuPrincipal/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irMenuBdo();">MENU B.D.O</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irMenuSector();">MENU SECTOR</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irMenuAerolinea();">MENU AEROLINEA</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irMenuValor();">MENU VALOR</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irMenuGasto();">MENU GASTO</button>
                <div class="row top-buffer"></div>         
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irModuloCaja();">MODULO CAJA</button>
                <div class="row top-buffer"></div>                    
                <button type="button" class="btn btn-danger btn-lg btn-block" onclick="cerrarSession();">CERRAR SESION</button>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>