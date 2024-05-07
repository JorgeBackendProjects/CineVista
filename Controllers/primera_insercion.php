<?php
    require_once("../Models/Conexion.php");
    require_once("../Models/Pelicula.php");

    function insert_100_popular_movies_api() {
        $cien_peliculas_populares = Pelicula::get_100_popular_movies_api();
        var_dump($cien_peliculas_populares);
    }
    