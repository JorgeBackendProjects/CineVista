<?php
require_once ("Conexion.php");
require_once ("Pelicula.php");

class Lista {
    private int $id;
    private string $nombre;
    private string $fecha_creacion;
    private string $visibilidad;
    private int $id_usuario;
    private array $peliculas;

    public function __construct(int $id, string $nombre, string $fecha_creacion, string $visibilidad, int $id_usuario = 0, array $peliculas = array())
    {
        $this->nombre = $nombre;
        $this->fecha_creacion = $fecha_creacion;
        $this->visibilidad = $visibilidad;
        $this->id_usuario = $id_usuario;
        $this->peliculas = $peliculas;
        $this->id = $id;
    }

    public static function get_listas_usuario($id_usuario) {
        $pdo = Conexion::connection_database();
        $stmt = $pdo->prepare("SELECT * FROM lista WHERE id_usuario = ?");

        if ($stmt->execute([$id_usuario])) {
            $listas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $array_objetos = array();
            foreach ($listas as $lista) {
                $lista_object = new Lista($lista["id"], $lista["nombre"], $lista["fecha_creacion"], $lista["visibilidad"], $lista["id_usuario"]);
                array_push($array_objetos, $lista_object);
            }
            
            return $array_objetos;
        } else {
            return "No se han encontrado listas para este usuario.";
        }
    }

    public static function insert_lista($nombre, $fecha_creacion, $id_usuario) {
        $pdo = Conexion::connection_database();
        $stmt = $pdo->prepare("INSERT INTO lista (nombre, fecha_creacion, id_usuario, visibilidad) VALUES (?, ?, ?, ?)");

        if ($stmt->execute([$nombre, $fecha_creacion, $id_usuario, "Privada"])) {
            return "OK";
        } else {
            return "No se ha podido crear la lista en estos momentos.";
        }
    }

    public static function update_lista($nombre) {
        $pdo = Conexion::connection_database();
        $stmt = $pdo->prepare("UPDATE lista SET nombre = ?");

        if ($stmt->execute([$nombre])) {
            return "OK";
        } else {
            return "No se ha cambiar el nombre de la lista en estos momentos.";
        }
    }
    
    public static function delete_lista($id_usuario, $nombre) {
        $pdo = Conexion::connection_database();
        $stmt = $pdo->prepare("DELETE lista WHERE id_usuario = ? AND nombre = ?");

        if ($stmt->execute([$id_usuario, $nombre])) {
            return "OK";
        } else {
            return "No se ha podido eliminar la lista en estos momentos.";
        }
    }

    // Getters
    public function get_id(): int
    {
        return $this->id;
    }

    public function get_nombre(): string
    {
        return $this->nombre;
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

    public function set_nombre(string $nombre): void
    {
        $this->nombre = $nombre;
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