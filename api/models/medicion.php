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

    public function insert_medicion($medicionDTO)
    {
        date_default_timezone_set("America/Mexico_City");

        $conectar = parent::conexion();
        parent::set_name();

        $sql = "INSERT INTO Medicion (fecha, volumen, nivelCm, Sensor_idSensor) VALUES (?, ?,?,?)";
        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, date("Y-m-d H:i:s"));
        $sql->bindValue(2, $medicionDTO->volumen);
        $sql->bindValue(3, $medicionDTO->nivelCm);
        $sql->bindValue(4, $medicionDTO->sensor_idSensor);

        //var_dump($medicionDTO);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


    }

}
?>