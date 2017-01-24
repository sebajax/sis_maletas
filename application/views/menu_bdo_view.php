<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu B.D.O</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <style>.top-buffer { margin-top:20px; }</style>
    
    <script type="text/javascript">
        function irAltaBdo() {
            window.location.href = "<?php echo base_url("alta_bdo"); ?>";
        }
        function irCierreCaso() {
            window.location.href = "<?php echo base_url("cierre_caso"); ?>";
        }
        function irConsultaBdo() {
            window.location.href = "<?php echo base_url("consulta_bdo"); ?>";
        }        
        function irEliminarBdo() {
            window.location.href = "<?php echo base_url("eliminar_modificar_bdo"); ?>";
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
            <ul class="nav nav-pills nav-justified">
                <li role="presentation"><a href="<?php echo base_url("menu_principal"); ?>">Principal</a></li>
                <li role="presentation" class="active"><a href="#">BDO</a></li>
                <li role="presentation"><a href="<?php echo base_url("menu_sector"); ?>">Sector</a></li>
                <li role="presentation"><a href="<?php echo base_url("menu_aerolinea"); ?>">Aerolinea</a></li>
                <li role="presentation"><a href="<?php echo base_url("menu_valor"); ?>">Valor</a></li>
                <li role="presentation"><a href="<?php echo base_url("login"); ?>">Salir</a></li>
            </ul>  
        </div>        
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu B.D.O</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menubdoform", "name" => "menubdoform");
        echo form_open("menu_bdo/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaBdo();">INGRESAR B.D.O</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irCierreCaso();">CIERRE CASO</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irConsultaBdo();">CONSULTAS B.D.O</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irEliminarBdo();">ELIMINAR MODIFICAR B.D.O</button>
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