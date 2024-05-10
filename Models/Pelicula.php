<?php
require_once ("Conexion.php");

class Pelicula
{
    private int $id;
    private string $titulo;
    private string $sinopsis;
    private int $duracion;
    private float $presupuesto;
    private float $ganancias;
    private string $fecha_estreno;
    private string $pais_origen;
    private string $web;
    private float $popularidad;
    private float $valoracion;
    private int $total_votos;
    private string $fondo;
    private string $poster;
    private bool $adulto;
    private array $generos;

    function __construct($id = 0, $titulo = "", $sinopsis = "", $duracion = 0, $presupuesto = 0, $ganancias = 0, $fecha_estreno = "", $pais_origen = "", $web = "", $popularidad = 0, $valoracion = 0, $total_votos = 0, $fondo = "", $poster = "", $adulto = false, $generos = array())
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->sinopsis = $sinopsis;
        $this->duracion = $duracion;
        $this->presupuesto = $presupuesto;
        $this->ganancias = $ganancias;
        $this->fecha_estreno = $fecha_estreno;
        $this->pais_origen = $pais_origen;
        $this->web = $web;
        $this->popularidad = $popularidad;
        $this->valoracion = $valoracion;
        $this->total_votos = $total_votos;
        $this->fondo = $fondo;
        $this->poster = $poster;
        $this->adulto = $adulto;
        $this->generos = $generos;
    }

    // Función que me permitió al principio obtener las 100 películas más populares para almacenarlas en la base de datos.
    static function insert_100_movies_database() {
        $pdo = Conexion::connection_database();
        $array_peliculas = array();

        for ($i = 1; $i <= 5; $i++) {
            // Inicializa la sesión cURL para la solicitud.
            $get_popular_movies = curl_init();
            // Solicitud a la api para recoger los resultados de la página.
            curl_setopt($get_popular_movies, CURLOPT_URL, "https://api.themoviedb.org/3/discover/movie?page=" . $i . "&language=es-ES&sort_by=popularity.desc&api_key=107cc8a9703efd86f41232ea75b85039");
            // Hacemos que la respuesta se guarde en una variable.
            curl_setopt($get_popular_movies, CURLOPT_RETURNTRANSFER, true);
            // Ejecutar la solicitud y guardar la respuesta
            $popular_movies = json_decode(curl_exec($get_popular_movies))->results;
            // Cerrar sesión cURL
            curl_close($get_popular_movies);

            // Recorremos cada película de la página.
            foreach ($popular_movies as $pelicula) {
                // PELICULA
                $get_one_movie = curl_init();
                curl_setopt($get_one_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $pelicula->id . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
                curl_setopt($get_one_movie, CURLOPT_RETURNTRANSFER, true);
                // Recojo la película correspondiente al id con que se ha hecho la solicitud.
                $movie = json_decode(curl_exec($get_one_movie));
                curl_close($get_one_movie);

                // Obtenemos los datos de la película.
                $id = isset($movie->id) ? $movie->id : ""; // Es el id por el que he buscado en la petición.
                $titulo = isset($movie->title) ? $movie->title : ""; // Me da el título en español.
                $sinopsis = isset($movie->overview) ? $movie->overview : ""; // String con la sinopsis de la película.
                $duracion = isset($movie->runtime) ? $movie->runtime : ""; // Tiempo en minutos de duración.
                $presupuesto = isset($movie->budget) ? $movie->budget : ""; // Me devuelve el presupuesto.
                $ganancias = isset($movie->revenue) ? $movie->revenue : ""; // Ganancias.
                $fecha_estreno = isset($movie->release_date) ? $movie->release_date : ""; // Date con la fecha de estreno
                $pais_origen = isset($movie->origin_country) ? $movie->origin_country : ""; // Array (un solo valor?) con String.
                $web = isset($movie->homepage) ? $movie->homepage : ""; // Página donde ver la película.
                $popularidad = isset($movie->popularity) ? $movie->popularity : ""; // Float con el valor de popularidad. Es útil ???
                $valoracion = isset($movie->vote_average) ? $movie->vote_average : ""; // Float con puntuación. 
                $total_votos = isset($movie->vote_count) ? $movie->vote_count : ""; // Int con total de calificaciones obtenidos.
                $fondo = isset($movie->backdrop_path) ? "https://image.tmdb.org/t/p/original" . $movie->backdrop_path : ""; // Fondo de la película que seguramente no haga falta.
                $poster = isset($movie->poster_path) ? "https://image.tmdb.org/t/p/original" . $movie->poster_path : ""; // Ruta completa a la imágen de la película. // Hacer función js para convertir img a blob al recoger la url y mostrarla.
                $adulto = isset($movie->adult) ? $movie->adult : ""; // Boolean, si es de adultos o no.
                // Se obtienen los generos en un array.
                $generos = array();
                foreach ($movie->genres as $genero) {
                    $generos[] = array(
                        "id" => $genero->id,
                        "nombre" => $genero->name
                    );
                }

                $pelicula = new Pelicula($id, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen[0], $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto, $generos);

                array_push($array_peliculas, $pelicula);
            }
        }

        // Obtenemos un array de objetos Pelicula.
        $contador_inserciones_peliculas = $contador_inserciones_generos = $contador_inserciones_intermedias = 0;
    
        // Por cada película en el array de objetos obtenemos sus datos.
        foreach ($array_peliculas as $pelicula) {
            $id_pelicula = $pelicula->get_id();
            $titulo = $pelicula->get_titulo();
            $sinopsis = $pelicula->get_sinopsis();
            $duracion = $pelicula->get_duracion();
            $presupuesto = $pelicula->get_presupuesto();
            $ganancias = $pelicula->get_ganancias();
            $fecha_estreno = $pelicula->get_fecha_estreno();
            $pais_origen = $pelicula->get_pais_origen();
            $web = $pelicula->get_web();
            $popularidad = $pelicula->get_popularidad();
            $valoracion = $pelicula->get_valoracion();
            $total_votos = $pelicula->get_total_votos();
            $fondo = $pelicula->get_fondo();
            $poster = $pelicula->get_poster();
            $adulto = $pelicula->get_adulto();
    
            // Insertamos la película a la tabla.
            $stmt = $pdo->prepare("INSERT IGNORE INTO pelicula (id, titulo, sinopsis, duracion, presupuesto, ganancias, fecha_estreno, pais_origen, web, popularidad, valoracion, total_votos, fondo, poster, adulto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if($stmt->execute([$id_pelicula, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen, $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto])) {
                // Si se ha insertado correctamente obtenemos sus géneros y los insertamos también.
                $generos = $pelicula->get_generos();
                foreach ($generos as $genero) {
                    $id_genero = $genero["id"];
                    $nombre = $genero["nombre"];
    
                    $stmt = $pdo->prepare("INSERT IGNORE INTO categoria (id, nombre) VALUES (?, ?)");
                    // Si el género se ha insertado bien, guardamos en la tabla intermedia el id de la película y el id del género.
                    if($stmt->execute([$id_genero, $nombre])) {
                        $stmt = $pdo->prepare("INSERT IGNORE INTO pelicula_categoria (id_pelicula, id_genero) VALUES (?, ?)");
                        if($stmt->execute([$id_pelicula, $id_genero])) {
                            $contador_inserciones_intermedias++;
                        }
    
                        $contador_inserciones_generos++;
                    }
                }
    
                $contador_inserciones_peliculas++;
            }
        }
    
        $pdo = null;
        echo "<h1>Se han insertado $contador_inserciones_peliculas películas, $contador_inserciones_generos géneros y $contador_inserciones_intermedias registros intermedios.</h1>";
    }

    /*static function get_100_popular_movies_api()
    {
        $array_peliculas = array();

        for ($i = 1; $i <= 5; $i++) {
            // Inicializa la sesión cURL para la solicitud.
            $get_popular_movies = curl_init();
            // Solicitud a la api para recoger los resultados de la página.
            curl_setopt($get_popular_movies, CURLOPT_URL, "https://api.themoviedb.org/3/discover/movie?page=" . $i . "&language=es-ES&sort_by=popularity.desc&api_key=107cc8a9703efd86f41232ea75b85039");
            // Hacemos que la respuesta se guarde en una variable.
            curl_setopt($get_popular_movies, CURLOPT_RETURNTRANSFER, true);
            // Ejecutar la solicitud y guardar la respuesta
            $popular_movies = json_decode(curl_exec($get_popular_movies))->results;
            // Cerrar sesión cURL
            curl_close($get_popular_movies);

            // Recorremos cada película de la página.
            foreach ($popular_movies as $pelicula) {
                // PELICULA
                $get_one_movie = curl_init();
                curl_setopt($get_one_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $pelicula->id . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
                curl_setopt($get_one_movie, CURLOPT_RETURNTRANSFER, true);
                // Recojo la película correspondiente al id con que se ha hecho la solicitud.
                $movie = json_decode(curl_exec($get_one_movie));
                curl_close($get_one_movie);

                // Obtenemos los datos de la película.
                $id = isset($movie->id) ? $movie->id : ""; // Es el id por el que he buscado en la petición.
                $titulo = isset($movie->title) ? $movie->title : ""; // Me da el título en español.
                $sinopsis = isset($movie->overview) ? $movie->overview : ""; // String con la sinopsis de la película.
                $duracion = isset($movie->runtime) ? $movie->runtime : ""; // Tiempo en minutos de duración.
                $presupuesto = isset($movie->budget) ? $movie->budget : ""; // Me devuelve el presupuesto.
                $ganancias = isset($movie->revenue) ? $movie->revenue : ""; // Ganancias.
                $fecha_estreno = isset($movie->release_date) ? $movie->release_date : ""; // Date con la fecha de estreno
                $pais_origen = isset($movie->origin_country) ? $movie->origin_country : ""; // Array (un solo valor?) con String.
                $web = isset($movie->homepage) ? $movie->homepage : ""; // Página donde ver la película.
                $popularidad = isset($movie->popularity) ? $movie->popularity : ""; // Float con el valor de popularidad. Es útil ???
                $valoracion = isset($movie->vote_average) ? $movie->vote_average : ""; // Float con puntuación. 
                $total_votos = isset($movie->vote_count) ? $movie->vote_count : ""; // Int con total de calificaciones obtenidos.
                $fondo = isset($movie->backdrop_path) ? "https://image.tmdb.org/t/p/original" . $movie->backdrop_path : ""; // Fondo de la película que seguramente no haga falta.
                $poster = isset($movie->poster_path) ? "https://image.tmdb.org/t/p/original" . $movie->poster_path : ""; // Ruta completa a la imágen de la película. // Hacer función js para convertir img a blob al recoger la url y mostrarla.
                $adulto = isset($movie->adult) ? $movie->adult : ""; // Boolean, si es de adultos o no.
                // Se obtienen los generos en un array.
                $generos = array();
                foreach ($movie->genres as $genero) {
                    $generos[] = array(
                        "id" => $genero->id,
                        "nombre" => $genero->name
                    );
                }

                $pelicula = new Pelicula($id, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen[0], $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto, $generos);

                array_push($array_peliculas, $pelicula);
            }
        }

        return $array_peliculas;
    }*/

// Funciones CRUD

    // Obtiene el id, titulo y póster de las películas para mostrarlas en el index.php
    static function select_previews_all_movies() {
        $pdo = Conexion::connection_database();

        $peliculas = array();

        $stmt = $pdo->prepare("SELECT id, titulo, poster FROM pelicula");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $pelicula) {
                $pelicula_object = new Pelicula();
                $pelicula_object->set_id($pelicula["id"]);
                $pelicula_object->set_titulo($pelicula["titulo"]);
                $pelicula_object->set_poster($pelicula["poster"]);
                
                array_push($peliculas, $pelicula_object);
            }
        }

        $pdo = null;

        return $peliculas;
    }

    // Obtiene la información de una película. Si no la encuentra en la base de datos la obtiene de la API y la inserta.
    static function get_movie($id_pelicula) {
        $pdo = Conexion::connection_database();
        
        $resultado = "";

        $stmt = $pdo->prepare("SELECT * FROM pelicula WHERE id = ?");
        $stmt->execute([$id_pelicula]);
        
        // Si encuentra la película en la base de datos se almacena en un objeto y se buscan sus géneros.
        if ($stmt->rowCount() > 0) {
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['id'];
            $titulo = $datos[0]['titulo'];
            $sinopsis = $datos[0]['sinopsis'];
            $duracion = $datos[0]['duracion'];
            $presupuesto = $datos[0]['presupuesto'];
            $ganancias = $datos[0]['ganancias'];
            $fecha_estreno = $datos[0]['fecha_estreno'];
            $pais_origen = $datos[0]['pais_origen'];
            $web = $datos[0]['web'];
            $popularidad = $datos[0]['popularidad'];
            $valoracion = $datos[0]['valoracion'];
            $total_votos = $datos[0]['total_votos'];
            $fondo = $datos[0]['fondo'];
            $poster = $datos[0]['poster'];
            $adulto = $datos[0]['adulto']; 

            $pelicula = new Pelicula($id, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen[0], $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto);
            $generos = array();
            //echo $pelicula->toString();

            // Obtenemos los nombres de los géneros.
            $stmt = $pdo->prepare("SELECT c.id, c.nombre FROM pelicula_categoria pc JOIN categoria c ON pc.id_genero = c.id WHERE pc.id_pelicula = ?");
            $stmt->execute([$id_pelicula]);

            // Si se encuentran los géneros en la base de datos se añaden al objeto.
            if ($stmt->rowCount() > 0) {
                $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $row) {
                    $generos[] = array(
                        "id" => $row["id"],
                        "nombre" => $row["nombre"]
                    );
                }

                // Se setean los género.
                $pelicula->set_generos($generos);
            }

            return $pelicula;
            
        // Si la película no está en la base de datos se busca en la API.
        } else {
            $get_one_movie = curl_init();
            curl_setopt($get_one_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $id_pelicula . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
            curl_setopt($get_one_movie, CURLOPT_RETURNTRANSFER, true);
            // Recojo la película correspondiente al id con que se ha hecho la solicitud.
            $movie = json_decode(curl_exec($get_one_movie));
            curl_close($get_one_movie);

            // Obtenemos los datos de la película.
            $id = isset($movie->id) ? $movie->id : ""; // Es el id por el que he buscado en la petición.
            $titulo = isset($movie->title) ? $movie->title : ""; // Me da el título en español.
            $sinopsis = isset($movie->overview) ? $movie->overview : ""; // String con la sinopsis de la película.
            $duracion = isset($movie->runtime) ? $movie->runtime : ""; // Tiempo en minutos de duración.
            $presupuesto = isset($movie->budget) ? $movie->budget : ""; // Me devuelve el presupuesto.
            $ganancias = isset($movie->revenue) ? $movie->revenue : ""; // Ganancias.
            $fecha_estreno = isset($movie->release_date) ? $movie->release_date : ""; // Date con la fecha de estreno
            $pais_origen = isset($movie->origin_country) ? $movie->origin_country : ""; // Array (un solo valor?) con String.
            $web = isset($movie->homepage) ? $movie->homepage : ""; // Página donde ver la película.
            $popularidad = isset($movie->popularity) ? $movie->popularity : ""; // Float con el valor de popularidad. Es útil ???
            $valoracion = isset($movie->vote_average) ? $movie->vote_average : ""; // Float con puntuación. 
            $total_votos = isset($movie->vote_count) ? $movie->vote_count : ""; // Int con total de calificaciones obtenidos.
            $fondo = isset($movie->backdrop_path) ? "https://image.tmdb.org/t/p/original" . $movie->backdrop_path : ""; // Fondo de la película que seguramente no haga falta.
            $poster = isset($movie->poster_path) ? "https://image.tmdb.org/t/p/original" . $movie->poster_path : ""; // Ruta completa a la imágen de la película. // Hacer función js para convertir img a blob al recoger la url y mostrarla.
            $adulto = isset($movie->adult) ? $movie->adult : ""; // Boolean, si es de adultos o no.

            // Se obtienen los generos en un array.
            $generos = array();
            foreach ($movie->genres as $genero) {
                $generos[] = array(
                    "id" => $genero->id,
                    "nombre" => $genero->name
                );
            }

            $pelicula = new Pelicula($id, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen[0], $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto, $generos);
            
            // Se inserta la nueva película en la base de datos.
            Pelicula::insert_movie($pelicula);

            return $pelicula;
        }
    }
               
    static function insert_movie($pelicula) {
        $pdo = Conexion::connection_database();

        $id_pelicula = $pelicula->get_id();
        $titulo = $pelicula->get_titulo();
        $sinopsis = $pelicula->get_sinopsis();
        $duracion = $pelicula->get_duracion();
        $presupuesto = $pelicula->get_presupuesto();
        $ganancias = $pelicula->get_ganancias();
        $fecha_estreno = $pelicula->get_fecha_estreno();
        $pais_origen = $pelicula->get_pais_origen();
        $web = $pelicula->get_web();
        $popularidad = $pelicula->get_popularidad();
        $valoracion = $pelicula->get_valoracion();
        $total_votos = $pelicula->get_total_votos();
        $fondo = $pelicula->get_fondo();
        $poster = $pelicula->get_poster();
        $adulto = $pelicula->get_adulto();

        // Insertamos la película a la tabla.
        $stmt = $pdo->prepare("INSERT IGNORE INTO pelicula (id, titulo, sinopsis, duracion, presupuesto, ganancias, fecha_estreno, pais_origen, web, popularidad, valoracion, total_votos, fondo, poster, adulto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if($stmt->execute([$id_pelicula, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen, $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto])) {
            // Si se ha insertado correctamente obtenemos sus géneros y si el array no está vacío los insertamos también.
            $generos = $pelicula->get_generos();

            if (count($generos) > 0) {
                foreach ($generos as $genero) {
                    $id_genero = $genero["id"];
                    $nombre = $genero["nombre"];

                    $stmt = $pdo->prepare("INSERT IGNORE INTO categoria (id, nombre) VALUES (?, ?)");
                    // Si el género se ha insertado bien, guardamos en la tabla intermedia el id de la película y el id del género.
                    if($stmt->execute([$id_genero, $nombre])) {
                        $stmt = $pdo->prepare("INSERT IGNORE INTO pelicula_categoria (id_pelicula, id_genero) VALUES (?, ?)");
                        $stmt->execute([$id_pelicula, $id_genero]);
                    }
                }
            }
        }

        $pdo = null;
    }
    
    static function buscar_peliculas() {
        
    }

    public function toString(): string {
        $properties = get_object_vars($this);
        $values = [];
        
        foreach ($properties as $property => $value) {
            $getterName = 'get_' . $property;
            if (method_exists($this, $getterName)) {
                $values[] = $this->$getterName();
            }
        }
        
        return implode('_', $values);
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

    public function get_sinopsis(): string
    {
        return $this->sinopsis;
    }

    public function get_duracion(): int
    {
        return $this->duracion;
    }

    public function get_presupuesto(): float
    {
        return $this->presupuesto;
    }

    public function get_ganancias(): float
    {
        return $this->ganancias;
    }

    public function get_fecha_estreno(): string
    {
        return $this->fecha_estreno;
    }

    public function get_pais_origen(): string
    {
        return $this->pais_origen;
    }

    public function get_web(): string
    {
        return $this->web;
    }

    public function get_popularidad(): float
    {
        return $this->popularidad;
    }

    public function get_valoracion(): float
    {
        return $this->valoracion;
    }

    public function get_total_votos(): int
    {
        return $this->total_votos;
    }

    public function get_fondo(): string
    {
        return $this->fondo;
    }

    public function get_poster(): string
    {
        return $this->poster;
    }

    public function get_adulto(): bool
    {
        return $this->adulto;
    }

    public function get_generos(): array
    {
        return $this->generos;
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

    public function set_sinopsis(string $sinopsis): void
    {
        $this->sinopsis = $sinopsis;
    }

    public function set_duracion(int $duracion): void
    {
        $this->duracion = $duracion;
    }

    public function set_presupuesto(float $presupuesto): void
    {
        $this->presupuesto = $presupuesto;
    }

    public function set_ganancias(float $ganancias): void
    {
        $this->ganancias = $ganancias;
    }

    public function set_fecha_estreno(string $fecha_estreno): void
    {
        $this->fecha_estreno = $fecha_estreno;
    }

    public function set_pais_origen(string $pais_origen): void
    {
        $this->pais_origen = $pais_origen;
    }

    public function set_web(string $web): void
    {
        $this->web = $web;
    }

    public function set_popularidad(float $popularidad): void
    {
        $this->popularidad = $popularidad;
    }

    public function set_valoracion(float $valoracion): void
    {
        $this->valoracion = $valoracion;
    }

    public function set_total_votos(int $total_votos): void
    {
        $this->total_votos = $total_votos;
    }

    public function set_fondo(string $fondo): void
    {
        $this->fondo = $fondo;
    }

    public function set_poster(string $poster): void
    {
        $this->poster = $poster;
    }

    public function set_adulto(bool $adulto): void
    {
        $this->adulto = $adulto;
    }

    public function set_generos(array $generos): void
    {
        $this->generos = $generos;
    }
}