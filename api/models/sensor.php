<?php

class Sensor extends Conectar
{

    public function get_all()
    {

        $conectar = parent::conexion();

        parent::set_name();

        $sql = "SELECT * FROM Sensor";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function get_sensor_by_content_id($contentId1, $contentId2){
        $conectar = parent::conexion();
        parent::set_name();
        $sql = "SELECT * FROM Sensor WHERE Contenedor_idContenedor = $contentId1 OR Contenedor_idContenedor = $contentId2";
        $sql = $conectar -> prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_sensor($sensorDTO)
    {
        $conectar = parent::conexion();
        parent::set_name();
        
        $sql = "INSERT INTO Sensor ( nombre, tipo, acuracy, Contenedor_idContenedor, flag) VALUES (?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        
        $sql->bindValue(1, $sensorDTO -> nombre);
        $sql->bindValue(2, $sensorDTO -> tipo);
        $sql->bindValue(3, $sensorDTO -> acuracy);
        $sql->bindValue(4, $sensorDTO -> contenedor_idContenedor);
        $sql->bindValue(5, $sensorDTO -> flag);

        //var_dump($sensorDTO);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


    }

}
?>