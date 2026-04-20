<?php
header('Content-Type: application/json');

session_start();


// Connection
require_once("../config/conexion.php");
// Models

require_once("../models/casaDTO.php");
require_once("../models/casa.php");



$casa = new Casa();


$body = json_decode(file_get_contents("php://input"), true);

//$body = $_REQUEST;

$casaDTO = new CasaDTO(
    $body['idCasa'] ?? 0,
    $body['nombre'] ?? '',
    $body['direccion'] ?? '',
    $body['bandera'] ?? 0,
    $body['habitantes'] ?? 0,
    $body['usuario_idUsuario'] ?? 0
);

switch ($body["option"]) {
    // Todas las casas
    case 'GetAll':
        $datos = $casa->get_all_homes();
        echo json_encode($datos);
        break;

    case "InsertHome":
        $datos = $casa->insert_home($casaDTO);
        echo json_encode('{"value": "true"}');
        break;


    default:
        print ("Sin opción de selección");
        break;
}


?>