<?php
header('Content-Type: application/json');

session_start();


// Connection
require_once("../config/conexion.php");
// Models

require_once("../models/contenedorDTO.php");
require_once("../models/contenedor.php");



$contenedor = new Contenedor();


$body = json_decode(file_get_contents("php://input"), true);

//$body = $_REQUEST;

$contenedorDTO = new ContenedorDTO(
    $body['idContenedor'] ?? 0,
    $body['nombre'] ?? '',
    $body['bandera'] ?? 0,
    $body['altura'] ?? 0,
    $body['radio'] ?? 0,
    $body['casa_idCasa'] ?? 0
);

switch ($body["option"]) {
    // Todas las casas
    case 'GetAll':
        $datos = $contenedor->get_all();
        echo json_encode($datos);
        break;

    case "InsertContainer":
        $datos = $contenedor -> insert_container($contenedorDTO);
        echo json_encode('{"value": "true"}');
        break;

    default:
        print ("Sin opción de selección");
        break;
}


?>