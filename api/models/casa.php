<?php

class Casa extends Conectar
{

// Obtenemos todos los datos
    public function get_all_homes()
    {

        $conectar = parent::conexion();

        parent::set_name();

        $sql = "SELECT * FROM Casa";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    // Obtenemos el nombre de la primera casa registrada por id del usuario

    public function get_home_by_user_id($userId){
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "SELECT * FROM Casa WHERE Usuario_idUsuario = $userId LIMIT 1";
        $sql = $conectar -> prepare($sql);
        $sql -> execute();

        return $resultado = $sql -> fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertamos una nueva casa
    public function insert_home($casaDTO)
    {
        $conectar = parent::conexion();
        parent::set_name();
        
        $sql = "INSERT INTO Casa ( nombre, direccion, bandera, Habitantes, Usuario_idUsuario) VALUES ( ?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $casaDTO -> nombre);
        $sql->bindValue(2, $casaDTO -> direccion);
        $sql->bindValue(3, $casaDTO -> bandera);
        $sql->bindValue(4, $casaDTO -> Habitantes);
        $sql->bindValue(5, $casaDTO -> Usuario_idUsuario);
 

        $sql->execute();

        $sql = "SELECT LAST_INSERT_ID() as idCasa";
        $sql = $conectar -> prepare($sql);
        $sql -> execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>