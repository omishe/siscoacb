<?php
readonly class CasaDTO
{
    public function __construct(
        public int $idCasa = 0,
        public string $nombre = '',
        public string $direccion = '',
        public int $bandera = 0,
        public int $Habitantes = 0,
        public int $Usuario_idUsuario = 0
    ) {

    }

    public function idCasa(): int
    {
        return $this->idCasa;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function direccion(): string
    {
        return $this->direccion;
    }

    public function bandera(): int
    {
        return $this->bandera();
    }

    public function Habitantes(): int
    {
        return $this->Habitantes;
    }

    public function Usuario_idUsuario(): int
    {
        return $this-> Usuario_idUsuario;
    }
}
?>