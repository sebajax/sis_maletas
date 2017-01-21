<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Sector</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        function irAltaSectores() {
            window.location.href = "<?php echo base_url("alta_sector"); ?>";
        }
        function irConsultarEliminarSectores() {
            window.location.href = "<?php echo base_url("eliminar_modificar_sector"); ?>";
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
        <legend>Menu Sector</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menusectorform", "name" => "menusectorform");
        echo form_open("menu_sector/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaSectores();">INGRESAR SECTORES</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irConsultarEliminarSectores();">CONSULTAR MODIFICAR ELIMINAR SECTORES</button>
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