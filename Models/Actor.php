<?php
class Actor
{
    private int $id;
    private string $nombre;
    private string $personaje;
    private string $biografia;
    private string $lugar_nacimiento;
    private string $birthday;
    private string $deathday;
    private string $genero;
    private float $popularidad;
    private string $imagen;

    function __construct($id, $nombre, $personaje, $biografia, $lugar_nacimiento, $birthday, $deathday, $genero, $popularidad, $imagen)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->personaje = $personaje;
        $this->biografia = $biografia;
        $this->lugar_nacimiento = $lugar_nacimiento;
        $this->birthday = $birthday;
        $this->deathday = $deathday;
        $this->genero = $genero;
        $this->popularidad = $popularidad;
        $this->imagen = $imagen;
    }

    // Si el personaje es = "Construction Worker", "Dancer", etc... ¿QUÉ HAGO?
    static function get_actores_by_movie($id_pelicula)
    {
        $casting_data = array();
        $datos_actor = array();

        $array_actores = array();

        // Se obtienen todas las personas de los créditos. 
        $get_cast_movie = curl_init();
        curl_setopt($get_cast_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $id_pelicula . "/credits?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
        curl_setopt($get_cast_movie, CURLOPT_RETURNTRANSFER, true);
        // Recojo el casting de la pelicula y lo guardo en el array.
        $casting = json_decode(curl_exec($get_cast_movie));
        array_push($casting_data, $casting);
        curl_close($get_cast_movie);

        // Por cada persona de los créditos de la película compruebo que sea actor. 
        foreach ($casting_data[0]->cast as $actor) {
            // Si es actor guardo su id y papel que interpreta.
            if ($actor->known_for_department == "Acting") {
                $datos_actor[] = array(
                    "id" => $actor->id,
                    "personaje" => $actor->character
                );
            }
        }

        // Por cada actor recojo sus datos, los guardo en el array de objetos de la clase Actor e inserto su información en la base de datos.
        foreach ($datos_actor as $actor) {
            // Primero se busca si está en la base de datos, si no está se pide a la API.
            $pdo = Conexion::connection_database();
            $stmt = $pdo->prepare("SELECT * FROM actor WHERE id = ?");
            $stmt->execute([$actor["id"]]);

            // Si el actor se encuentra registrado en la base de datos no se busca en la API y se comprueba que exista un registro con el papel que interpreta en la película en la tabla intermedia.
            if ($stmt->rowCount() > 0) {
                // Se guarda la información del actor obtenida de la base de datos en el array .
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                $actor_object = new Actor($actor["id"], $data["nombre"], $actor["personaje"], $data["biografia"], $data["lugar_nacimiento"], $data["birthday"], $data["deathday"], $data["genero"], $data["popularidad"], $data["imagen"]);
                array_push($array_actores, $actor_object);

                // Se busca su participación en la película.
                $stmt = $pdo->prepare("SELECT * FROM pelicula_actor WHERE id_actor = ? AND id_pelicula = ?");
                $stmt->execute([$actor["id"], $id_pelicula]);

                // Si no se ha encontrado la participación en la pelicula se inserta.
                if ($stmt->rowCount() < 0) {
                    $stmt = $pdo->prepare("INSERT INTO pelicula_actor personaje, id_pelicula, id_actor VALUES (?, ?, ?)");
                    $stmt->execute([$actor["personaje"], $id_pelicula, $actor["id"]]);
                }

            // Si no se encuentra en la base de datos, se busca en la api.
            } else {
                $get_actor = curl_init();
                curl_setopt($get_actor, CURLOPT_URL, "https://api.themoviedb.org/3/person/" . $actor["id"] . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
                curl_setopt($get_actor, CURLOPT_RETURNTRANSFER, true);
                // Recojo el actor correspondiente al id con que se ha hecho la solicitud.
                $actor_info = json_decode(curl_exec($get_actor));
                // Cerrar sesión cURL.
                curl_close($get_actor);

                // Si se encuentra la persona y su papel es de actor. 
                if (!isset($actor_info->success)) {
                    $id = $actor["id"];
                    $nombre = isset($actor_info->name) ? $actor_info->name : "";
                    $personaje = $actor["personaje"];
                    $biografia = isset($actor_info->biography) ? $actor_info->biography : "";
                    $lugar_nacimiento = isset($actor_info->place_of_birth) ? $actor_info->place_of_birth : "";
                    $birthday = isset($actor_info->birthday) ? $actor_info->birthday : "";
                    $deathday = isset($actor_info->deathday) ? $actor_info->deathday : "actualidad";
                    $genero = isset($actor_info->gender) ? ($actor_info->gender == 1 ? "Femenino" : ($actor_info->gender == 2 ? "Masculino" : "Otro")) : "";
                    $popularidad = isset($actor_info->popularity) ? $actor_info->popularity : "";
                    $imagen = isset($actor_info->profile_path) ? "https://image.tmdb.org/t/p/original" . $actor_info->profile_path : "";

                    $actor_object = new Actor($id, $nombre, $personaje, $biografia, $lugar_nacimiento, $birthday, $deathday, $genero, $popularidad, $imagen);
                    
                    // Se inserta el nuevo actor a la base de datos.
                    Actor::insert_actor($actor_object, $id_pelicula);

                    // Se añade el actor al array a devolver.
                    array_push($array_actores, $actor_object);
                }
            }
        }

        return $array_actores;
    }

    // Inserta el actor en la tabla y el personaje que interpreta en la película en la tabla intermedia con su id, personaje e id de película. 
    static function insert_actor($actor, $id_pelicula) {
        $pdo = Conexion::connection_database();
        $stmt = $pdo->prepare("SELECT * FROM actor WHERE id = ?");
        $id_actor = $actor->get_id();

        // Si el actor no está en la base de datos se inserta.
        if (!$stmt->execute([$id_actor]) || $stmt->rowCount() == 0) {
            $nombre = $actor->get_nombre();
            $personaje = $actor->get_personaje();
            $biografia = $actor->get_biografia();
            $lugar_nacimiento = $actor->get_lugar_nacimiento();
            $birthday = $actor->get_birthday();
            $deathday = $actor->get_deathday();
            $genero = $actor->get_genero();
            $popularidad = $actor->get_popularidad();
            $imagen = $actor->get_imagen();
    
            // Insertamos la el actor a la tabla.
            $stmt = $pdo->prepare("INSERT IGNORE INTO actor (id, nombre, biografia, lugar_nacimiento, birthday, deathday, genero, popularidad, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if($stmt->execute([$id_actor, $nombre, $biografia, $lugar_nacimiento, $birthday, $deathday, $genero, $popularidad, $imagen])) {
                // Si se ha insertado correctamente, insertamos en la tabla intermedia su personaje con el id_actor e id_pelicula.
                $stmt = $pdo->prepare("INSERT IGNORE INTO pelicula_actor (personaje, id_pelicula, id_actor) VALUES (?, ?, ?)");
                $stmt->execute([$personaje, $id_pelicula, $id_actor]);
            }
        }

        $pdo = null;
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

    public function get_personaje(): string
    {
        return $this->personaje;
    }

    public function get_biografia(): string
    {
        return $this->biografia;
    }

    public function get_lugar_nacimiento(): string
    {
        return $this->lugar_nacimiento;
    }

    public function get_birthday(): string
    {
        return $this->birthday;
    }

    public function get_deathday(): string
    {
        return $this->deathday;
    }

    public function get_genero(): string
    {
        return $this->genero;
    }

    public function get_popularidad(): float
    {
        return $this->popularidad;
    }

    public function get_imagen(): string
    {
        return $this->imagen;
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

    public function set_personaje(string $personaje): void
    {
        $this->personaje = $personaje;
    }

    public function set_biografia(string $biografia): void
    {
        $this->biografia = $biografia;
    }

    public function set_lugar_nacimiento(string $lugar_nacimiento): void
    {
        $this->lugar_nacimiento = $lugar_nacimiento;
    }

    public function set_birthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function set_deathday(string $deathday): void
    {
        $this->deathday = $deathday;
    }

    public function set_genero(string $genero): void
    {
        $this->genero = $genero;
    }

    public function set_popularidad(float $popularidad): void
    {
        $this->popularidad = $popularidad;
    }

    public function set_imagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }
}
