<?php
readonly class MedicionDTO
{
    public function __construct(
        public int $idMedicion = 0,
        public string $fecha = "",
        public float $volumen = 0,
        public float $nivelCm = 0,
        public int $sensor_idSensor = 0
    ) {

    }

    public function idMedicion(): int
    {
        return $this->idMedicion;
    }

    public function nombre(): string
    {
        return $this->fecha;
    }

    public function volumen(): float
    {
        return $this->volumen;
    }

    public function nivelCm(): float
    {
        return $this->nivelCm();
    }

    public function sensor_idSensor(): int
    {
        return $this->sensor_idSensor;
    }

}
?>