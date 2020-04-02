<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <?php require_once "assets/header/header.php"; ?>
    
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        function irModuloCaja() {
            window.location.href = "<?php echo base_url("ModuloCaja"); ?>";
        }
        /*
         * INICIO: MENU BDO
         */
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
        /*
         * FIN: MENU BDO
         */   
        
        /*
         * INICIO: MENU GASTO
         */        
        function irAltaGasto() {
            window.location.href = "<?php echo base_url("AltaGasto"); ?>";
        }   
        function irAltaTipoGasto() {
            window.location.href = "<?php echo base_url("AltaTipoGasto"); ?>";
        }
        function irConsultarEliminarTipoGasto() {
            window.location.href = "<?php echo base_url("EliminarModificarTipoGasto"); ?>";
        }
        function irConsultarEliminarGasto() {
            window.location.href = "<?php echo base_url("EliminarModificarGasto"); ?>";
        }   
        function irTransaccionesGasto() {
            window.location.href = "<?php echo base_url("TransaccionesGasto"); ?>";
        }
        /*
         * FIN: MENU GASTO
         */   
        
        /*
         * INICIO: MENU SECTOR
         */   
        function irAltaSectores() {
            window.location.href = "<?php echo base_url("AltaSector"); ?>";
        }
        function irConsultarEliminarSectores() {
            window.location.href = "<?php echo base_url("EliminarModificarSector"); ?>";
        }
        function irCantidadSectores() {
            window.location.href = "<?php echo base_url("CantidadSectores"); ?>";
        }            
        /*
         * FIN: MENU SECTOR
         */
        
        /*
         * INICIO: MENU AEROLINEA
         */ 
        function irAltaAerolineas() {
            window.location.href = "<?php echo base_url("AltaAerolinea"); ?>";
        }
        function irConsultarEliminarAerolineas() {
            window.location.href = "<?php echo base_url("EliminarModificarAerolinea"); ?>";
        }        
        /*
         * FIN: MENU AEROLINEA
         */
        
        /*
         * INICIO: MENU VALOR
         */         
        function irAltaValores() {
            window.location.href = "<?php echo base_url("AltaValores"); ?>";
        }
        function irConsultarEliminarValores() {
            window.location.href = "<?php echo base_url("EliminarModificarValor"); ?>";
        }        
        /*
         * FIN: MENU VALOR
         */  
        
        /*
         * INICIO: MENU ADMINISTRADOR
         */         
        function irAuditoria() {
            window.location.href = "<?php echo base_url("Auditoria"); ?>";
        }        
        /*
         * FIN: MENU AUDITORIA
         */           

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
        <a class="navbar-brand" href="<?php echo base_url("MenuPrincipal"); ?>"><i class="fas fa-suitcase-rolling fa-2x"></i></a>

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
                
                <li class="nav-item dropdown px-3" id="menu_gasto">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu Gasto</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="irAltaGasto();">INGRESAR GASTO</a>
                        <a class="dropdown-item" href="#" onclick="irAltaTipoGasto();">INGRESAR TIPO DE GASTO</a>
                        <a class="dropdown-item" href="#" onclick="irTransaccionesGasto();">TRANSACCIONES GASTO</a>
                        <a class="dropdown-item" href="#" onclick="irConsultarEliminarGasto();">CONSULTAR ELIMINAR MODIFICAR GASTO</a>
                        <a class="dropdown-item" href="#" onclick="irConsultarEliminarTipoGasto();">CONSULTAR ELIMINAR MODIFICAR TIPO DE GASTO</a>
                    </div>
                </li> 
                
                <li class="nav-item px-3"><a id="menu_caja" class="nav-link" href="<?php echo base_url("ModuloCaja"); ?>">Caja</a></li>
                
                <li class="nav-item dropdown px-3" id="menu_sector">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu Sector</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="irAltaSectores();">INGRESAR SECTOR</a>
                        <a class="dropdown-item" href="#" onclick="irConsultarEliminarSectores();">CONSULTAR MODIFICAR ELIMINAR SECTORES</a>
                        <a class="dropdown-item" href="#" onclick="irCantidadSectores();">CANTIDAD SECTORES</a>
                    </div>
                </li> 
                
                <li class="nav-item dropdown px-3" id="menu_aerolinea">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu Aerolinea</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="irAltaAerolineas();">INGRESAR AEROLINEA</a>
                        <a class="dropdown-item" href="#" onclick="irConsultarEliminarAerolineas();">CONSULTAR ELIMINAR MODIFICAR AEROLINEAS</a>
                    </div>
                </li>      
                
                <li class="nav-item dropdown px-3" id="menu_valores">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu Valores</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="irAltaValores();">INGRESAR VALORES</a>
                        <a class="dropdown-item" href="#" onclick="irConsultarEliminarValores();">CONSULTAR MODIFICAR ELIMINAR VALORES</a>
                    </div>
                </li>   
                
                <li class="nav-item dropdown px-3" id="menu_admin">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu Admin</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="irAuditoria();">AUDITORIA</a>
                    </div>
                </li>                   
            </ul> 
            
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="<?php echo strtoupper($this->session->usuario); ?>">
                <i class="text-white nav-link d-inline-flex flex-row-reverse fas fa-user fa-2x" style="opacity: 0.5;"></i>
            </button>
            
            <button onclick="cerrarSession()" type='button' class='btn btn-default'>
                <i class="text-white nav-link d-inline-flex flex-row-reverse fas fa-sign-out-alt fa-2x" style="opacity: 0.5;"></i>
            </button>
        </div>
    </nav>
   
    <div id="imagen_principal" class="d-flex justify-content-center" style="padding-top: 70px; font-size: 34px;">
        <span class="fas fa-luggage-cart fa-10x" style="opacity: 0.1;"></span>
    </div>
    
</body>
</html>