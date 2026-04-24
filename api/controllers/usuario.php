<?php
header('Content-Type: application/json');

session_start();

// Connection
require_once("../config/conexion.php");
// Models
require_once("../models/usuarioDTO.php");
require_once("../models/usuario.php");

$usuario = new Usuario();

$body = json_decode(file_get_contents("php://input"), true);

//$body = $_REQUEST;

$usuarioDTO = new UsuarioDTO(
    $body['idUsuario'] ?? 0,
    $body['usuario'] ?? '',
    $body['password'] ?? '',
    $body['nombre'] ?? '',
    $body['apellidoPat'] ?? '',
    $body['apellidoMat'] ?? '',
    $body['email'] ?? ''
);

switch ($body["option"]) {
    // Todos los usuarios
    case 'GetAll':
        $datos = $usuario->get_all_users();
        echo json_encode($datos);
        break;

    // Usuario por usuario
    case 'GetUser':
        $datos = $usuario->get_usuario($usuarioDTO);

        //var_dump($datos[0]['idUsuario']);
        //echo json_encode($datos);

        if (count($datos) == 0) {
            echo json_encode('{"value": "false"}');
        } else {
            $_SESSION['usuario'] = $datos[0]['usuario'];
            $_SESSION['idUsuario'] = $datos[0]['idUsuario'];

            echo json_encode('{"value": "true"}');
        }



        break;

    // Usuario por email
    case 'GetUserEmail':
        $datos = $usuario->get_email_user($usuarioDTO);
        echo json_encode($datos);
        break;

    case "InsertUser":
        $datos = $usuario->insert_user($usuarioDTO);
        echo json_encode('{"value": "true"}');
        break;

    case "UpdatetUser":
        $datos = $usuario->update_user($usuarioDTO);
        echo json_encode("Actualizado correctamente");
        break;

    case "DeleteUser":
        $datos = $usuario->delete_user($body['idUsuario']);
        echo json_encode("Usuario eliminado correctamente!!");
        break;

    default:
        print ("Sin opción de selección");
        break;
}
?>