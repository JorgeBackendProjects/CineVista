<?php
require_once("../Models/Conexion.php");
require_once("../Models/Pelicula.php");
require_once("../Models/Actor.php");

//Pelicula::insert_100_movies_database();
//Petición que recoge las películas más populares de 5 páginas de la API y las inserta en la base de datos.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["key"]) && $_POST["key"] == "insert_most_popular_movies") {
    Pelicula::insert_100_movies_database();
    //Setear el valor del SESSION ["ultima_pagina"] para añadir más con el administrador. (LA ULTIMA PAGINA ES LA 500) Añadir dos parámetros a la función 
    //header("Location: ../index.html");
}

// Se obtienen 20 películas para mostrar en el index junto al número total de páginas para paginación.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["key"]) && $_POST["key"] == "get_movies_preview") {
    // Variables para la paginación
    $pagina_actual = isset($_POST['pagina']) ? $_POST['pagina'] : 1;    
    $limite = 20;

    // Obtenemos el número total de películas
    $total_peliculas = Pelicula::get_num_peliculas();

    // Calcular el número total de páginas redondeando el float hacia arriba
    $total_paginas = ceil($total_peliculas / $limite);

    // Se obtiene la página a mostrar
    $pagina = ($pagina_actual - 1) * $limite;

    // Se obtienen las 20 películas de la página seleccionada 
    $peliculas = Pelicula::select_previews_all_movies($pagina, $limite);

    // Se añaden las películas al array.
    $peliculas_array = array();
    foreach($peliculas as $pelicula) {
        $peliculas_array[] = array(
            "id" => $pelicula->get_id(),
            "titulo" => $pelicula->get_titulo(),
            "poster" => $pelicula->get_poster(),
            "valoracion" => $pelicula->get_valoracion()
        );
    }

    // Se envía un array con las películas y el número de paginas.
    $resultado = array(
        "peliculas" => $peliculas_array,
        "total_paginas" => $total_paginas,
        "total_peliculas" => $total_peliculas
    );

    echo json_encode($resultado);
}

// Obtiene las películas mediante un filtro de búsqueda que coincida con la cadena. 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["busqueda"]) && isset($_POST["key"]) && $_POST["key"] == "buscar_peliculas") {
    $busqueda = $_POST["busqueda"];

    // Obtenemos las películas por título o fecha.
    $peliculas = Pelicula::search_movies($busqueda);

    $total_peliculas = 0;

    // Obtenemos los datos de cada película y los añadimos al array
    $peliculas_array = array();
    foreach($peliculas as $pelicula) {
        $peliculas_array[] = array(
            "id" => $pelicula->get_id(),
            "titulo" => $pelicula->get_titulo(),
            "poster" => $pelicula->get_poster(),
            "valoracion" => $pelicula->get_valoracion()
        );

        $total_peliculas++;
    }

    // Añadimos al array las películas y el número de páginas para enviarlo.
    $resultado = array(
        "peliculas" => $peliculas_array,
        "total_peliculas" => $total_peliculas
    );

    echo json_encode($resultado);
}

// Petición para cargar la información de una película con categorías y sus actores. Al obtener los datos se almacenan en la base de datos, por si han sido obtenidos de la API. 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_pelicula"]) && isset($_POST["key"]) && $_POST["key"] == "get_movie") {
    $id_pelicula = $_POST["id_pelicula"];

    // Obtenemos el objeto Pelicula con todos sus valores.
    $pelicula = Pelicula::get_movie($id_pelicula);
    $array_pelicula = array(
        "id" => $pelicula->get_id(),
        "titulo" => $pelicula->get_titulo(),
        "sinopsis" => $pelicula->get_sinopsis(),
        "duracion" => $pelicula->get_duracion(),
        "presupuesto" => $pelicula->get_presupuesto(),
        "ganancias" => $pelicula->get_ganancias(),
        "fecha_estreno" => $pelicula->get_fecha_estreno(),
        "pais_origen" => $pelicula->get_pais_origen(),
        "web" => $pelicula->get_web(),
        "popularidad" => $pelicula->get_popularidad(),
        "valoracion" => $pelicula->get_valoracion(),
        "total_votos" => $pelicula->get_total_votos(),
        "fondo" => $pelicula->get_fondo(),
        "poster" => $pelicula->get_poster(),
        "adulto" => $pelicula->get_adulto(),
        "generos" => $pelicula->get_generos()
    );

    echo json_encode(array("pelicula" => $array_pelicula));
}