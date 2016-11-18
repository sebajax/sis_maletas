<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu principal</title>
    <!--link the bootstrap css file-->
    <link href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>" rel="stylesheet" type="text/css" />
    <!--include jquery library-->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    
    <style type="text/css">
        .colbox {
            margin-left: 0px;
            margin-right: 0px;
        }
        .noresize {
            resize: none; 
        } 
        .top-buffer { margin-top:30px; }
    </style>
    
    <script type="text/javascript">
        function irAltaBdo() {
            window.location.href = "<?php echo base_url("index.php/alta_bdo"); ?>";
        }
        function irAltaAerolinea() {
            window.location.href = "<?php echo base_url("index.php/alta_aerolinea"); ?>";
        }
        function irAltaSector() {
            window.location.href = "<?php echo base_url("index.php/alta_sector"); ?>";
        }
        function irAltaValor() {
            window.location.href = "<?php echo base_url("index.php/alta_valores"); ?>";
        }      
        function irCierreCaso() {
            window.location.href = "<?php echo base_url("index.php/cierre_caso"); ?>";
        }        
    </script>    
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Menu principal</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "menuprincipalform", "name" => "menuprincipalform");
        echo form_open("menu_principal/index", $attributes);
        ?>
        
        <fieldset>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaBdo();">INGRESAR B.D.O</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaSector();">INGRESAR SECTORES</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaAerolinea();">INGRESAR AEROLINEAS</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irAltaValor();">INGRESAR VALORES</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irCierreCaso();">CIERRE CASO</button>
                <div class="row top-buffer"></div>
                <button type="button" class="btn btn-danger btn-lg btn-block" onclick="">CERRAR SESION</button>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>