<?php

class Medicion extends Conectar
{

    public function get_all()
    {
        $conectar = parent::conexion();
        parent::set_name();
        $sql = "SELECT * FROM Medicion";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    // Revisamos el status del servicio del agua por los ultimos 3 dias
    public function get_service_status($idSensor)
    {
        $conectar = parent::conexion();
        parent::set_name();
        /*$sql = "SELECT IF(MIN(nivelCm) <= 10 AND MAX(nivelCm) <=10, 'Sin agua por 3 días','Con agua') 
        AS estado
        FROM Medicion
        WHERE Sensor_idSensor = $idSensor
        AND fecha >= DATE_SUB(NOW(), INTERVAL  3 DAY)";*/
        $sql = "SELECT MAX(fecha) as ultimo_llenado
        FROM Medicion
        WHERE nivelCm <= 5";
        $sql = $conectar->prepare($sql);
        $sql->execute();    
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // método para obtener las mediones de cada contenedor por su id
    public function get_medition_by_id_sensor($idSensor1Value)
    {
        $conectar = parent::conexion();
        parent::set_name();
        $sql = "SELECT * FROM Medicion WHERE Sensor_idSensor = $idSensor1Value ORDER BY idMedicion DESC LIMIT 3 ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // obtenemos las medicines de las últimas 24 hrs.
    public function get_recent_24_hrs_values($idSensorValue)
    {
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "SELECT nivelCm, fecha FROM Medicion m WHERE fecha >= DATE_SUB(NOW(), INTERVAL  1 DAY) AND Sensor_idSensor = $idSensorValue ORDER BY fecha ASC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenemos las mediciones por dias
    public function get_data_days($idSensor)
    {
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "SELECT 
            DATE_FORMAT(fecha, '%d/%b/%Y') as etiqueta, 
            SUM(volumen) as total 
        FROM Medicion 
        WHERE fecha >= DATE_SUB(NOW(), INTERVAL 3 DAY)
        AND Sensor_idSensor = $idSensor
        GROUP BY etiqueta 
        ORDER BY MAX(fecha) ASC";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenemos las mediciones por dias
    public function get_data_months($idSensor)
    {
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "SELECT 
            DATE_FORMAT(fecha, '%b/%Y') as etiqueta, 
            SUM(volumen) as total 
        FROM Medicion 
        WHERE fecha >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        AND Sensor_idSensor = $idSensor
        GROUP BY etiqueta 
        ORDER BY MAX(fecha) ASC";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    // Obtenemos las mediciones del dia de hoy
    public function get_today_values($idSensor)
    {
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "SELECT volumen, fecha FROM Medicion m WHERE fecha >= CURDATE() AND Sensor_idSensor = $idSensor ORDER BY fecha ASC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenemos el valor reciente de la altura del agua
    public function get_water_container_level($idSensorValue)
    {
        $conectar = parent::conexion();
        parent::set_name();
        //$sql = "SELECT AVG(nivelCm) AS promedio FROM Medicion m WHERE fecha >= DATE_SUB(NOW(), INTERVAL  5 DAY) AND m.Sensor_idSensor = $idSensorValue";
        $sql = "SELECT nivelCm AS promedio FROM Medicion m WHERE Sensor_idSensor = $idSensorValue ORDER BY fecha ASC LIMIT 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Aqui insertamos las mediciones
    public function insert_medicion($medicionDTO)
    {
        date_default_timezone_set("America/Mexico_City");

        $conectar = parent::conexion();
        parent::set_name();

        $sql = "INSERT INTO Medicion (fecha, volumen, nivelCm, Sensor_idSensor) VALUES (?, ?,?,?)";
        $sql = $conectar->prepare($sql);

        //$sql->bindValue(1, date("Y-m-d H:i:s"));
        $sql->bindValue(1, $medicionDTO->fecha);
        $sql->bindValue(2, $medicionDTO->volumen);
        $sql->bindValue(3, $medicionDTO->nivelCm);
        $sql->bindValue(4, $medicionDTO->sensor_idSensor);

        //var_dump($medicionDTO);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


    }

}
?>