<?php 
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json; charset=UTF-8' );
header( 'Access-Control-Max-Age: 3600' );
header( 'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With' );

if ( isset( $_SERVER['HTTP_ORIGIN'] ) ) {
    header( "Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}" );
    header( 'Access-Control-Allow-Credentials: true' );
}

if ( $_SERVER['REQUEST_METHOD'] == 'OPTIONS' ) {
    if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ) )
    header( 'Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS' );
    if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ) )
    header( "Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}" );
}

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $function = $request->function;
    $function();

    function Login(){
        require_once('../models/usuarios/usuariosModel.php');
        global $request;
        $json = $request->datos;
        if($json->usuario != '' && $json->contrasena != ''){
            if(!strlen($json->contrasena) < 6){
                $response = LoginModel($json);
            }else{
                $response = 'La contraseña debe contener minimo 6 caracteres';
            }
        }else{
            $response = 'Debe diligenciar todos los campos';
        }
    
        if(empty($response)){
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        }else{
            $arrResponse = array('status' => true, 'data' => $response);
        }
        echo json_encode($arrResponse);
    }


    function RegistroUsuario()
    {
        global $request;
        $datos = $request->datos;
    require_once('../models/usuarios/usuariosModel.php');
        if ($datos->tipoDoc != '' && $datos->numDoc != '' && $datos->nombres != '' && $datos->apellidos != '' && $datos->usuario != '' && $datos->contrasena != '' && $datos->nivel != '') {
            $opciones = array(
                'cost' => 12
            );
            $pass = password_hash($datos->contrasena, PASSWORD_BCRYPT, $opciones);
            $datos->contrasena = $pass;
            $doc = (int)$datos->numDoc;
            $datos->numDoc = $doc;
            $response = RegistroUsuarios($datos);
        } else {
            $response = 'Debe diligenciar todos los campos';
        }
        echo $response;
    }



    function EditarUsuario(){
        global $request;
        require_once('../models/usuarios/usuariosModel.php');
    if ($request->tipoDoc != '' && $request->numDoc != '' && $request->nombres != '' && $request->apellidos != '' && $request->usuario != '') {
        $doc = (int)$request->numDoc;
        $request->numDoc = $doc;
        $response = EditaUsuario($request);
    } else {
        $response = 'Debe diligenciar todos los campos';
    }
    echo $response;
}

function listarusuarios(){
    require_once('../models/usuarios/usuariosModel.php');
            $arrUsuario = Busquedausuarios();
            if(empty($arrUsuario)){
                $arrResponse = 'Datos no encontrados';
            }else{
                $arrResponse =  $arrUsuario;
            }
            echo json_encode($arrResponse);
      
        die();
}


function Buscarusuario(){
    global $request;
    require_once('../models/usuarios/usuariosModel.php');
    $campoabuscar = $request->campodebusqueda;
            $arrUsuario = Busquedausuario($campoabuscar);
            if(empty($arrUsuario)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            }else{
                $arrResponse = array('status' => true, 'data' => $arrUsuario);
            }
            echo json_encode($arrResponse);
      
        die();
}

function ObtenerUsuario(){
    global $request;
    require_once('../models/usuarios/usuariosModel.php');
    $id = $request->datos;
    if($id > 0){
            $arrUsuario = ObtenerUsu($id);
            if(empty($arrUsuario)){
                $arrResponse = 'Datos no encontrados';
            }else{
                $arrResponse =  $arrUsuario;
            }
            echo json_encode($arrResponse);
        }
        die();
}

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        
        
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
   
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT") {
  
} else {
   
}


?>