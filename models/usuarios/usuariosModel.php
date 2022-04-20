<?php 
    function LoginModel($json) {
        try {
            require_once('../config/conexion.php');
            $query = $mysqli->prepare("SELECT u.usuario, u.password, u.tipo_doc, u.numero_doc, u.nombres, u.apellidos, u.nivel, u.estado FROM usuarios u WHERE u.usuario = ?");
            $query->bind_param("s", $json->usuario);
            $query->execute();
    
            $query->bind_result($usuario, $password, $tipoDoc, $numDoc, $nombres, $apellidos, $nivel, $estado);
            if ($query->affected_rows) {
                $existe = $query->fetch();
                if ($existe) {
                    if (password_verify($json->contrasena, $password)) {
                        $_SESSION['usuario'] = $usuario;
                        $_SESSION['nombre'] = $nombres." ".$apellidos;
                        $_SESSION['nivel'] = $nivel;
                        $_SESSION['tipo_doc'] = $tipoDoc;
                        $_SESSION['numero_doc'] = $numDoc;
                        $_SESSION['estado'] = $estado;
                        $_SESSION['nivel'] = $nivel;
                        return  $response = array('status' => 'Exito', 'data' => $usuario);
                    }
                } else {
                    return $response = "Error";
                }
            }
            $query->close();
        } catch (Exception $e) {
            echo " Error " . $e->getMessage();
        }
    }

    function RegistroUsuarios($json){
      $passwordencriptar = password_hash($json->contrasena, PASSWORD_BCRYPT, ['cost' => 12,]);
        require_once('../config/conexion.php');
        $ejecutar = $mysqli->prepare("CALL insertarusuario(?,?,?,?,?,?,?)");
        $ejecutar->bind_param("sssssss", $json->tipoDoc, $json->numDoc, $json->usuario, $json->nombres, $json->apellidos, $passwordencriptar, $json->nivel);
        $ejecutar->execute();
        $ejecutar -> store_result();
        $ejecutar -> bind_result($datosalida);
        $ejecutar -> fetch();
        $datos = $datosalida;
        return $datos;
    }

    function EditaUsuario($json){
        require_once('../config/conexion.php');
        $ejecutar = $mysqli->prepare("CALL actualizarusuario(?,?,?,?,?,?)");
        $ejecutar->bind_param("ssssss", $json->tipoDoc, $json->nombres, $json->apellidos,$json->usuario, $json->nivel, $json->numDoc);
        $ejecutar->execute();
        $ejecutar -> store_result();
        $ejecutar -> bind_result($datosalida);
        $ejecutar -> fetch();
        $datos = $datosalida;
        return $datos;
    }

    function Busquedausuarios(){
        require_once('../config/conexion.php');
        $ejecutar = mysqli_query($mysqli, "CALL buscarusuarios()");
        $datos = array();
        while ($row = $ejecutar->fetch_assoc()) {
            $datos[] = $row;
        }
        return $datos;
        }
    function Busquedausuario($buscarporcampo){
        require_once('../config/conexion.php');
        $ejecutar = mysqli_query($mysqli, "CALL buscarusuario('$buscarporcampo')");
        $datos = array();
        while ($row = $ejecutar->fetch_assoc()) {
            $datos[] = $row;
        }
        return $datos;
        }

    function ObtenerUsu($id){
        require_once('../config/conexion.php');
        $ejecutar = $mysqli->prepare("CALL seleccionarusuario(?)");
        $ejecutar -> bind_param('s', $id);
        $ejecutar -> execute();
        $ejecutar -> store_result();
        $ejecutar -> bind_result($datousuario);
        $ejecutar -> fetch();
        $datos = $datousuario;
        return json_decode($datos);
        }

//   function insertartoken($usuarioid){
//         // $val = true;
//         // $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
//  $r1 = bin2hex(random_bytes(10));
//  $r2 = bin2hex(random_bytes(10));
//  $r3 = bin2hex(random_bytes(10));
//  $r4 = bin2hex(random_bytes(10));
//  $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
//         $date = date("y-m-d H:i");
//         $estado = "Activo";
//         $query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha) VALUES('$usuarioid','$token','$estado','$date')";
//         $verificar = parent::nonQuery($query);
//         if($verificar){
//             return $token;
//         }else{
//             return false;
//         }
//     }


    //     function buscarToken($token){
    //     $query = "SELECT  TokenId,UsuarioId,Estado from usuarios_token WHERE Token = '$token' AND Estado = 'Activo'";
    //     $resp = parent::obtenerDatos($query);
    //     if($resp){
    //         return $resp;
    //     }else{
    //         return 0;
    //     }
    // }

?>