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

    case 'GetRecent24HrsValues':
        $idSensor = $body['idSensor'];
        $datos = $contenedor->get_recent_24_hrs_values($idSensor);
        echo json_encode($datos);
        break;

    case 'GetRecentTodayValues':
        $idSensor = $body['idSensor'];
        $datos = $contenedor->get_today_values($idSensor);
        echo json_encode($datos);
        break;

    case 'GetServiceStatus':
        $idSensor = $body['idSensor'];
        $datos = $contenedor->get_service_status($idSensor);
        //var_dump($datos[0]["ultimo_llenado"]);
        $fecha_db = $datos[0]["ultimo_llenado"];
        $ultimoLlenado = new DateTime($fecha_db);
        $hoy = new DateTime();
        $diferencia = $hoy->diff($ultimoLlenado);

        $diasLimite = 3;
        //var_dump($diferencia->days);
        if ($diferencia->days >= $diasLimite) {
            //echo 'Enviar mensaje: ';
        }

        echo json_encode($diferencia->days);
        break;

    case 'GetDataDays':
        $idSensor = $body['idSensor'];
        $datos = $contenedor->get_data_days($idSensor);
        $etiquetas = array_column($datos, 'etiqueta');
        $datos = array_column($datos, 'total');
        echo json_encode([$etiquetas, $datos]);
        break;

    case 'GetDataMonths':
        $idSensor = $body['idSensor'];
        $datos = $contenedor->get_data_months($idSensor);
        $etiquetas = array_column($datos, 'etiqueta');
        $datos = array_column($datos, 'total');
        echo json_encode([$etiquetas, $datos]);
        break;

    case 'GetWaterContainerLevel':
        $idSensorValue = $body['idSensor'];
        $datos = $contenedor->get_water_container_level($idSensorValue);
        echo json_encode($datos);
        break;

    case "InsertMedicion":
        $datos = $contenedor->insert_medicion($medicionDTO);
        echo json_encode('{"value": "true"}');
        break;

    default:
        print ("Sin opción de selección");
        break;
}


?>