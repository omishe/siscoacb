<?php
header('Content-Type: application/json');

session_start();


// Connection
require_once("../config/conexion.php");
// Models


require_once("../models/medicion.php");
require_once("../models/medicionDTO.php");

$contenedor = new Medicion();


$body = json_decode(file_get_contents("php://input"), true);

//$body = $_REQUEST;

$medicionDTO = new MedicionDTO(
    $body['idMedicion'] ?? 0,
    $body['fecha'] ?? '',
    $body['volumen'] ?? 0,
    $body['nivelCm'] ?? 0,
    $body['sensor_idSensor'] ?? 0
);

switch ($body["option"]) {
    // Todas las mediciones
    case 'GetAll':
        $datos = $contenedor->get_all();
        echo json_encode($datos);
        break;

    case 'GetMeditionBySensorId':
        $idSensor = $body['idSensor'];
        $datos = $contenedor->get_medition_by_id_sensor($idSensor);
        echo json_encode($datos);
        break;

        case 'GetLastMeditionTime':
            //$datos = $contenedor->get_last_medition_time();


    case "InsertMedicion":
        $datos = $contenedor->insert_medicion($medicionDTO);
        echo json_encode('{"value": "true"}');
        break;


    default:
        print ("Sin opción de selección");
        break;
}


?>