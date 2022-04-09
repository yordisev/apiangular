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
        if($request->usuario != '' && $request->password != ''){
            if(!strlen($request->password) < 6){
                $response = LoginModel($request);
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


    if($_SERVER['REQUEST_METHOD'] == "GET"){
        
        
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
   
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT") {
  
} else {
   
}


?>