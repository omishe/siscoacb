<?php
readonly class UsuarioDTO
{
    public function __construct(
        public int $id = 0,
        public string $usuario = '',
        public string $password = '',
        public string $nombre = '',
        public string $apellidoPat = '',
        public string $apellidoMat = '',
        public string $email = ''){

    }

    public function id(): int{
        return $this->id;
    }

    public function usuario(): string {
        return $this->usuario;
    }

    public function password(): string {
        return $this -> password;
    }

    public function nombre(): string {
        return $this -> nombre;
    }

    public function apellidoPat(): string {
        return $this -> apellidoPat;
    }

    public function apellidoMat(): string {
        return $this -> apellidoMat;
    }

    public function email(): string {
        return $this -> email;
    }
}
?>