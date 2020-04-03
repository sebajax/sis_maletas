<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of EliminarModificarUsuario
 *
 * @author sebastian.ituarte@gmail.com
 */
class EliminarModificarUsuario extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('EliminarModificarUsuario_model', 'Auditoria_model'));
        $this->load->library(array('validation', 'perms', 'session', 'funciones'));
        if(!$this->perms->verifico()) { die("USTED NO TIENE PERMISOS PARA ACCEDER A ESTE SITIO."); }
    }
    
    function index() {
        $data = array();
        $data['usuarios'] = $this->loadUsuarios();
        $this->load->view('EliminarModificarUsuario_view', $data);
    }  
    
    public function modificarUsuarioForm() {
        $usuario       = $this->input->post('usuario');
        $datos_usuario = $this->EliminarModificarUsuario_model->cargoDatosUsuario($usuario);
        $aux_usuario   = "'".$usuario."'";
        
        $attr_perfil = 'class="form-control" id="id_perfil_new"';
        
        $perfiles = array(
            1 => "ADMINISTRADOR",
            2 => "USUARIO",
            3 => "CONSULTA"
        );
        
        $html = '
            <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="usuario_new" class="control-label">Usuario</label>
                    <input id="usuario_new" disabled= "disabled" name="usuario_new" placeholder="usuario" type="text" class="form-control" value="'.$usuario.'" />
                </div>

                <div class="form-group">
                    <label for="nombre_new" class="control-label">Nombre</label>
                    <input id="nombre_new" name="nombre_new" placeholder="nombre" type="text" class="form-control" value="'.$datos_usuario->nombre.'"/>
                </div> 
                
                <div class="form-group">
                    <label for="apellido_new" class="control-label">Apellido</label>
                    <input id="apellido_new" name="apellido_new" placeholder="apellido" type="text" class="form-control" value="'.$datos_usuario->apellido.'"/>
                </div> 
                
                <div class="form-group">
                    <label for="id_perfil_new" class="control-label">Privilegios</label>
                    '.form_dropdown('id_perfil_new', $perfiles, $datos_usuario->id_perfil, $attr_perfil).'
                </div>  

            </form>
            </div>
            <div class="modal-footer">
                <input id="btn_modificar" name="btn_modificar" type="button" class="btn btn-primary" value="Modificar" onclick="modificarUsuario('.$aux_usuario.');" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>';
        
        echo $html;
    }
    
    public function modificarUsuario() {      
        //cargo el post en variables
        $data = array(
            "usuario"       => $this->input->post('usuario'),
            "nombre"        => $this->input->post('nombre'),
            "apellido"      => $this->input->post('apellido'),
            "id_perfil"     => $this->input->post('id_perfil'),
            "nombre_perfil" => $this->input->post('nombre_perfil')
        );
       
        $errorEmpty  = false;
        
        if(!$this->validation->validateEmpty($data)) { $errorEmpty = true; }
        
        if(!$errorEmpty) {
            $this->EliminarModificarUsuario_model->modificarUsuario($data);
            $this->Auditoria_model->insert($data, "update", "usuarios", $this->db->last_query());
            echo "OK";
            return true;
        }else {
            echo "ERROR";
            return false;
        }
    }
    
    public function limpiarClave() {
        $usuario = $this->input->post('usuario');
        
        if(empty($usuario)) {
            echo json_encode("ERROR");
            return false;
        }else{
            $this->EliminarModificarUsuario_model->limpiarClave($usuario);
            $this->Auditoria_model->insert(array("usuario" => $usuario), "update", "usuarios", $this->db->last_query());
            echo json_encode("OK");
            return true;            
        }
    }
    
    public function eliminarUsuario() {
        $usuario = $this->input->post('usuario');
        
        $error = array(
            'estado'  => 0,
            'mensaje' => "ERROR GENERICO"
        );
        
        if(empty($usuario)) {
            $error['mensaje'] = "ERROR no puede contener elementos vacios al eliminar.";
            echo json_encode($error);
            return false;
        }

        $this->EliminarModificarUsuario_model->eliminarUsuario($usuario);
        $this->Auditoria_model->insert(array("usuario" => $usuario), "delete", "usuarios", $this->db->last_query());
        $error['mensaje'] = "CORRECTO usuario eliminado correctamente";
        $error['estado'] = 1;
        echo json_encode($error);
        return true;            
    } 

    public function loadUsuarios() {
        $result = $this->funciones->objectToArray($this->EliminarModificarUsuario_model->loadUsuarios());
        $tbody = "";
        foreach ($result as $key => $row) {
            $aux_usuario = '"'.$row['usuario'].'"';
            $tbody .= "
                <tr>
                  <td><div class='font-weight-bold'>".$row['usuario']."</div></td>
                  <td>".$row['nombre']."</td>
                  <td>".$row['apellido']."</td>
                  <td><div class='float-right'>".$row['id_perfil']."</div></td>    
                  <td>".$row['nombre_perfil']."</td> 
                  <td>
                    <div class='d-flex justify-content-center'>
                        <button type='button' class='btn btn-default btn-md'>
                            <i aria-hidden='true' class='fas fa-save fa-lg' onclick='modificarUsuarioForm(".$aux_usuario.")'></i>
                        </button>
                    </div>
                  </td>                      
                  <td>
                    <div class='d-flex justify-content-center'>
                        <button type='button' class='btn btn-default btn-md'>
                            <i aria-hidden='true' class='fas fa-unlock fa-lg' onclick='confirmaLimpiarClave(".$aux_usuario.")'></i>
                        </button>
                    </div>
                  </td>
                  <td>
                    <div class='d-flex justify-content-center'>
                        <button type='button' class='btn btn-default btn-md'>
                            <i aria-hidden='true' class='fas fa-trash-alt fa-lg' onclick='cofirmaEliminar(".$aux_usuario.")'></i>
                        </button>
                    </div>
                  </td>                    
                </tr>";
        }
        return $tbody;
    }
}