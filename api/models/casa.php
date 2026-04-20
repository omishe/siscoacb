<?php

class Casa extends Conectar
{

    public function get_all_homes()
    {

        $conectar = parent::conexion();

        parent::set_name();

        $sql = "SELECT * FROM Casa";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

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
        //$sql->bindValue(4, $casaDTO -> habitantes);
        //$sql->bindValue(5, $casaDTO -> Usuario_idUsuario);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>