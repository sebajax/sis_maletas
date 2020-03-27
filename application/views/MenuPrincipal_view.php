<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        function irModuloCaja() {
            window.location.href = "<?php echo base_url("ModuloCaja"); ?>";
        }   
        function irAltaBdo() {
            window.location.href = "<?php echo base_url("AltaBdo"); ?>";
        }
        function irCierreCaso() {
            window.location.href = "<?php echo base_url("CierreCaso"); ?>";
        }
        function irConsultaBdo() {
            window.location.href = "<?php echo base_url("ConsultaBdo"); ?>";
        }        
        function irEliminarBdo() {
            window.location.href = "<?php echo base_url("EliminarModificarBdo"); ?>";
        }  
        function irTransaccionesBdo() {
            window.location.href = "<?php echo base_url("TransaccionesBdo"); ?>";
        }         
        function irMenuPrincipal() {
            window.location.href = "<?php echo base_url("MenuPrincipal"); ?>";
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
 
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#"><i class="fas fa-suitcase-rolling fa-2x"></i></a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown px-3" id="menu_bdo">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu BDO</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="irAltaBdo();">INGRESAR B.D.O</a>
                        <a class="dropdown-item" href="#" onclick="irCierreCaso();">CIERRE CASO</a>
                        <a class="dropdown-item" href="#" onclick="irConsultaBdo();">CONSULTAS B.D.O</a>
                        <a class="dropdown-item" href="#" onclick="irEliminarBdo();">ELIMINAR MODIFICAR B.D.O</a>
                        <a class="dropdown-item" href="#" onclick="irTransaccionesBdo();">TRANSACCIONES B.D.O</a>
                    </div>
                </li> 
                
                <li class="nav-item px-3"><a id="menu_sector" class="nav-link" href="<?php echo base_url("MenuSector"); ?>">Sector</a></li>
                <li class="nav-item px-3"><a id="menu_aerolinea" class="nav-link" href="<?php echo base_url("MenuAerolinea"); ?>">Aerolinea</a></li>
                <li class="nav-item px-3"><a id="menu_valor" class="nav-link" href="<?php echo base_url("MenuValor"); ?>">Valor</a></li>
                <li class="nav-item px-3"><a id="menu_gasto" class="nav-link" href="<?php echo base_url("MenuGasto"); ?>">Gasto</a></li>
                <li class="nav-item px-3"><a id="menu_caja" class="nav-link" href="<?php echo base_url("ModuloCaja"); ?>">Caja</a></li>
            </ul>    
            <a class="nav-link d-inline-flex flex-row-reverse text-white" href="<?php echo base_url("Login"); ?>">Salir</a>
        </div>
    </nav>
    
</body>
</html>