<?php
require_once("../Models/Conexion.php");
require_once("../Models/Pelicula.php");
require_once("../Models/Actor.php");

//Petición que recoge las primeras 100 películas populares de la API y las inserta en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["key"]) && $_POST["key"] == "insert_100_movies_database") {
    insert_100_movies_database();
    header("Location: ../index.html");
}

// Petición para cargar las películas de la base de datos en el index.html
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["key"]) && $_POST["key"] == "get_movies_preview") {
    $peliculas_array = array();
    $peliculas = Pelicula::select_previews_all_movies();

    foreach($peliculas as $pelicula) {
        $peliculas_array[] = array(
            "id" => $pelicula->get_id(),
            "titulo" => $pelicula->get_titulo(),
            "poster" => $pelicula->get_poster()
        );
    }

    echo json_encode($peliculas_array);
}

// Petición para cargar la información de una película y sus actores.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["key"]) && $_POST["key"] == "get_movies_preview") {
}

function insert_100_movies_database() {
    $pdo = Conexion::connection_database();

    // Obtenemos un array de objetos Pelicula.
    $cien_peliculas_populares = Pelicula::get_100_popular_movies_api();
    $contador_inserciones_peliculas = $contador_inserciones_generos = $contador_inserciones_intermedias = 0;

    // Por cada película obtenemos sus datos.
    foreach ($cien_peliculas_populares as $pelicula) {
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