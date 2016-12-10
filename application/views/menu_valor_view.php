<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Valor</title>
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
        function irAltaValores() {
            window.location.href = "<?php echo base_url("index.php/alta_valores"); ?>";
        }
        function irConsultarEliminarValores() {
            window.location.href = "<?php echo base_url("index.php/consultar_eliminar_valores"); ?>";
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
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="irConsultarEliminarValores();">CONSULTAR Y ELIMINAR VALORES (pendiente)</button>
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