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
        function irAltaUsuario() {
            window.location.href = "<?php echo base_url("AltaUsuario"); ?>";
        }  
        function irConsultarEliminarUsuario() {
            window.location.href = "<?php echo base_url("EliminarModificarUsuario"); ?>";
        }         
        /*
         * FIN: MENU AUDITORIA
         */           

        function cambiarClaveModal() {
            $("#cambiar_clave").modal("show");
        }
        
        function cambiarClave() {
            var clave  = $("#clave").val();
            var clave2 = $("#clave2").val();
            
            if(!clave) {
                alert("ERROR: Clave ingresada no puede ser vacia.");
                return false;
            }
            
            if(clave.length < 6) {
                alert("ERROR: La nueva clave debe contener al menos 6 digitos.");
                return false;                
            }
            
            if(clave != clave2) {
                alert("ERROR: Claves no coinciden.");
                return false;
            }
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url("MenuPrincipal/cambiarClave"); ?>",
                data: { clave: clave, clave2: clave }
            }).done(function(data) {
                if(data == 1) {
                    alert("Clave actualizada correctamente!.");
                    $("#clave").val("");
                    $("#clave2").val("");
                }else {
                    alert("ERROR: no se pudo modificar la clave.");
                }
            });           
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
        <a class="navbar-brand" href="<?php echo base_url("MenuPrincipal"); ?>"><i class="fas fa-suitcase-rolling fa-2x"></i></a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <?php if($this->perms->verificoPerfil(2)) { ?>
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
                <?php } ?>
                
                <?php if($this->perms->verificoPerfil(1)) { ?>
                <li class="nav-item dropdown px-3" id="menu_admin">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu Admin</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="irAuditoria();">AUDITORIA</a>
                        <a class="dropdown-item" href="#" onclick="irAltaUsuario();">ALTA USUARIO</a>
                        <a class="dropdown-item" href="#" onclick="irConsultarEliminarUsuario();">CONSULTAR MODIFICAR ELIMINAR USUARIO</a>
                    </div>
                </li>
                <?php } ?>
            </ul> 
            
            <button onclick="cambiarClaveModal()" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="<?php echo strtoupper($this->session->usuario); ?>">
                <i class="text-white nav-link d-inline-flex flex-row-reverse fas fa-user fa-2x" style="opacity: 0.5;"></i>
            </button>
            
            <button onclick="cerrarSession()" type='button' class='btn btn-default'>
                <i class="text-white nav-link d-inline-flex flex-row-reverse fas fa-sign-out-alt fa-2x" style="opacity: 0.5;"></i>
            </button>
        </div>
    </nav>
    
    <form id="imagen_principal">
        <div class="d-flex justify-content-center" style="padding-top: 70px; font-size: 34px;">
            <span class="fas fa-luggage-cart fa-10x" style="opacity: 0.1;"></span>
        </div>
        <div class="form-group row d-flex justify-content-center my-5">
            <h6 style="opacity: 0.3;">Sistema de Gestion de Maletas - Version <?php echo VERSION; ?></h6>
        </div>
    </form>
    
    <!-- Cambiar Clave modal -->
    <div id="cambiar_clave" class="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cambiar Contraseña - <?php echo strtoupper($this->session->usuario); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="cambiar_clave_form">
                    <form>
                        <div class="form-group">
                            <label for="clave" class="control-label">Constraseña</label>
                            <input id="clave" name="clave" placeholder="contraseña nueva" type="password" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="clave2" class="control-label">Re-Escribir</label>
                            <input id="clave2" name="clave2" placeholder="re-escribir contraseña" type="password" class="form-control"/>
                        </div>                   
                    </form>
                </div>
                <div class="modal-footer">
                    <input id="btn_cambiar_clave" name="btn_cambiar_clave" type="button" class="btn btn-primary" value="Confirmar" onclick="cambiarClave();" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>    
    
</body>
</html>