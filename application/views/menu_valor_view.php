<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Valor</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        function irAltaValores() {
            window.location.href = "<?php echo base_url("index.php/alta_valores"); ?>";
        }
        function irConsultarEliminarValores() {
            window.location.href = "<?php echo base_url("index.php/eliminar_modificar_valor"); ?>";
        }
        function irMenuPrincipal() {
            window.location.href = "<?php echo base_url("index.php/menu_principal"); ?>";
        }        
    </script>    
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu Valor</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menuvalorform", "name" => "menuvalorform");
        echo form_open("menu_valor/index", $attributes);
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