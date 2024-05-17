<?php
require_once ("Conexion.php");
require_once ("Pelicula.php");

class Lista {
    private int $id;
    private string $titulo;
    private string $fecha_creacion;
    private int $id_usuario;
    private array $peliculas;

    public function __construct(string $titulo, string $fecha_creacion, int $id_usuario, array $peliculas = array(), int $id = 0)
    {
        $this->titulo = $titulo;
        $this->fecha_creacion = $fecha_creacion;
        $this->id_usuario = $id_usuario;
        $this->peliculas = $peliculas;
        $this->id = $id;
    }

    // Getters
    public function get_id(): int
    {
        return $this->id;
    }

    public function get_titulo(): string
    {
        return $this->titulo;
    }

    public function get_fecha_creacion(): string
    {
        return $this->fecha_creacion;
    }

    public function get_id_usuario(): int
    {
        return $this->id_usuario;
    }

    public function get_peliculas(): array
    {
        return $this->peliculas;
    }

    // Setters
    public function set_id(int $id): void
    {
        $this->id = $id;
    }

    public function set_titulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function set_fecha_creacion(string $fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function set_id_usuario(int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function set_peliculas(array $peliculas): void
    {
        $this->peliculas = $peliculas;
    }
}