<?php
readonly class SensorDTO
{
    public function __construct(
        public int $idSensor = 0,
        public string $nombre = "",
        public string $tipo = "",
        public float $acuracy = 0,
        public int $contenedor_idContenedor = 0,
        public int $flag = 0
    ) {

    }

    public function idSensor(): int
    {
        return $this->idSensor;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function tipo(): string
    {
        return $this->tipo;
    }

    public function acuracy(): float
    {
        return $this->acuracy();
    }

    public function contenedor_idContenedor(): int
    {
        return $this->contenedor_idContenedor;
    }

    public function flag(): int
    {
        return $this-> flag;
    }
}
?>