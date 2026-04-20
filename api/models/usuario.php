<?php

class Usuario extends Conectar
{

    public function get_all_users()
    {

        $conectar = parent::conexion();

        parent::set_name();

        $sql = "SELECT * FROM Usuario";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }
    public function get_usuario($usuarioDTO)
    {

        $conectar = parent::conexion();

        parent::set_name();

        $sql = "SELECT * FROM Usuario WHERE usuario = ? AND password = ?";
        $sql = $conectar->prepare($sql);
        $sql -> bindValue(1, $usuarioDTO -> usuario);
        $sql -> bindValue(2, $usuarioDTO -> password);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function get_email_user($usuarioDTO)
    {
        $conectar = parent::conexion();

        parent::set_name();

        $sql = "SELECT * FROM Usuario WHERE email =?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usuarioDTO -> email);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_user($usuarioDTO)
    {
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "INSERT INTO Usuario (idUsuario, usuario, password, nombre, apelliPat, apellidoMat, email) VALUES (null, ?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usuarioDTO -> usuario);
        $sql->bindValue(2, $usuarioDTO -> password);
        $sql->bindValue(3, $usuarioDTO -> nombre);
        $sql->bindValue(4, $usuarioDTO -> apellidoPat);
        $sql->bindValue(5, $usuarioDTO -> apellidoMat);
        $sql->bindValue(6, $usuarioDTO -> email);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update_user($usuarioDTO)
    {
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "UPDATE Usuario SET usuario = ?, password = ?, nombre = ?, apelliPat = ?, apellidoMat = ?, email = ? WHERE usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usuarioDTO -> usuario);
        $sql->bindValue(2, $usuarioDTO -> password);
        $sql->bindValue(3, $usuarioDTO -> nombre);
        $sql->bindValue(4, $usuarioDTO -> apellidoPat);
        $sql->bindValue(5, $usuarioDTO -> apellidoMat);
        $sql->bindValue(6, $usuarioDTO -> email);
        $sql->bindValue(7, $usuarioDTO -> usuario);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_user($usuarioId)
    {
        $conectar = parent::conexion();
        parent::set_name();

        $sql = "DELETE  FROM Usuario WHERE idUsuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usuarioId);

        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>