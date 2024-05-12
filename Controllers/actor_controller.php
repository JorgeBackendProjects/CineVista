<?php
require_once("../Models/Conexion.php");
require_once("../Models/Pelicula.php");
require_once("../Models/Actor.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_pelicula"]) && isset($_POST["key"]) && $_POST["key"] == "get_actores") {
    $id_pelicula = $_POST["id_pelicula"];
    
    // Obtenemos los actores de la película y recorremos el array guardando cada registro en otro array.
    $actores = Actor::get_actores_by_movie($id_pelicula);
    $array_actores = array();
    foreach ($actores as $actor) {
        $array_actores[] = array (
            "id" => $actor->get_id(),
            "nombre" => $actor->get_nombre(),
            "personaje" => $actor->get_personaje(),
            "imagen" => $actor->get_imagen(),
            "biografia" => $actor->get_biografia(),
            "lugar_nacimiento" => $actor->get_lugar_nacimiento(),
            "birthday" => $actor->get_birthday(),
            "deathday" => $actor->get_deathday(),
            "genero" => $actor->get_genero(),
            "popularidad" => $actor->get_popularidad()
        );
    }
    
    echo json_encode(array("actores" => $array_actores));
}