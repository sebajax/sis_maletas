<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Aerolinea</title>
    <?php require_once "assets/header/header.php"; ?>
    
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