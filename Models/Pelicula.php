<?php

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
    private string $lenguaje_origen;
    private string $web;
    private float $popularidad;
    private float $valoracion;
    private int $total_votos;
    private string $fondo;
    private string $poster;
    private bool $adulto;
    private array $generos;

    function __construct($id, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen, $lenguaje_origen, $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto, $generos)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->sinopsis = $sinopsis;
        $this->duracion = $duracion;
        $this->presupuesto = $presupuesto;
        $this->ganancias = $ganancias;
        $this->fecha_estreno = $fecha_estreno;
        $this->pais_origen = $pais_origen;
        $this->lenguaje_origen = $lenguaje_origen;
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
    static function get_100_popular_movies_api()
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
                $lenguaje_origen = isset($movie->original_language) ? $movie->original_language : ""; // Valor en/es etc... Hacer función para modificarlo y guardarlo sin abreviatura.
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

                $pelicula = new Pelicula($id, $titulo, $sinopsis, $duracion, $presupuesto, $ganancias, $fecha_estreno, $pais_origen[0], $lenguaje_origen, $web, $popularidad, $valoracion, $total_votos, $fondo, $poster, $adulto, $generos);

                array_push($array_peliculas, $pelicula);
            }
        }

        return $array_peliculas;
    }

    function get_movie($id_movie) {
        //Select a la DB, si el id está ahí, se muestra del select. Si la pelicula no está se busca en la api.
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

    public function get_lenguaje_origen(): string
    {
        return $this->lenguaje_origen;
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

    public function set_lenguaje_origen(string $lenguaje_origen): void
    {
        $this->lenguaje_origen = $lenguaje_origen;
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