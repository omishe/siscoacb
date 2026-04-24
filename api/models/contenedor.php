<?php

class Contenedor extends Conectar
{

    public function get_all()
    {

        $conectar = parent::conexion();

        parent::set_name();

        $sql = "SELECT * FROM Contenedor";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function get_containers_by_house_id($houseId){
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "SELECT * FROM Contenedor WHERE Casa_idCasa = $houseId";
        $sql = $conectar -> prepare($sql);
        $sql -> execute();

        return $resultado = $sql -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_container($containerDTO)
    {
        $conectar = parent::conexion();
        parent::set_name();
        
        $sql = "INSERT INTO Contenedor ( bandera, nombre, altura, Casa_idCasa, radio) VALUES (?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        
        $sql->bindValue(1, $containerDTO -> bandera);
        $sql->bindValue(2, $containerDTO -> nombre);
        $sql->bindValue(3, $containerDTO -> altura);
        $sql->bindValue(4, $containerDTO -> casa_idCasa);
        $sql->bindValue(5, $containerDTO -> radio);

        //var_dump($containerDTO);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


    }

}
?>