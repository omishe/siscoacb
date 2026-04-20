<?php
header('Content-Type: application/json');

session_start();


// Connection
require_once("../config/conexion.php");
// Models


require_once("../models/sensor.php");
require_once("../models/sensorDTO.php");

$contenedor = new Sensor();


$body = json_decode(file_get_contents("php://input"), true);

//$body = $_REQUEST;

$sensorDTO = new SensorDTO(
    $body['idSensor'] ?? 0,
    $body['nombre'] ?? '',
    $body['tipo'] ?? '',
    $body['acuracy'] ?? 0,
    $body['contenedor_idContenedor'] ?? 0,
    $body['flag'] ?? 0
);

switch ($body["option"]) {
    // Todas las casas
    case 'GetAll':
        $datos = $contenedor->get_all();
        echo json_encode($datos);
        break;

    case "InsertSensor":
        $datos = $contenedor -> insert_sensor($sensorDTO);
        echo json_encode('{"value": "true"}');
        break;

    default:
        print ("Sin opción de selección");
        break;
}


?>