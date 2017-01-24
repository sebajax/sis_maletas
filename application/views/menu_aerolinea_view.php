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
            window.location.href = "<?php echo base_url("alta_aerolinea"); ?>";
        }
        function irConsultarEliminarAerolineas() {
            window.location.href = "<?php echo base_url("eliminar_modificar_aerolinea"); ?>";
        }
        function irMenuPrincipal() {
            window.location.href = "<?php echo base_url("menu_principal"); ?>";
        }        
    </script>    
    
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url("menu_principal"); ?>">Menu Principal</a></li>
            <li class="active">Menu Aerolinea</li>
        </ol>        
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
            <ul class="nav nav-pills nav-justified">
                <li role="presentation"><a href="<?php echo base_url("menu_principal"); ?>">Principal</a></li>
                <li role="presentation"><a href="<?php echo base_url("menu_bdo"); ?>">BDO</a></li>
                <li role="presentation"><a href="<?php echo base_url("menu_sector"); ?>">Sector</a></li>
                <li role="presentation" class="active"><a href="#">Aerolinea</a></li>
                <li role="presentation"><a href="<?php echo base_url("menu_valor"); ?>">Valor</a></li>
                <li role="presentation"><a href="<?php echo base_url("login"); ?>">Salir</a></li>
            </ul>  
        </div>
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu Aerolinea</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menuaerolineaform", "name" => "menuaerolineaform");
        echo form_open("menu_aerolinea/index", $attributes);
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