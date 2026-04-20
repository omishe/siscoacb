<?php
readonly class ContenedorDTO
{
    public function __construct(
        public int $idContenedor = 0,
        public string $nombre = '',
        public int $bandera = 0,
        public float $altura = 0.0,
        public float $radio = 0.0,
        public int $casa_idCasa = 0
    ) {

    }

    public function idContenedor(): int
    {
        return $this->idContenedor;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function bandera(): int
    {
        return $this->bandera;
    }

    public function altura(): float
    {
        return $this->altura();
    }

    public function radio(): float
    {
        return $this->radio();
    }

    public function casa_idCasa (): int
    {
        return $this->casa_idCasa;
    }

}
?>