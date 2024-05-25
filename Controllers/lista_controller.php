<?php
require_once("../Models/Conexion.php");
require_once("../Models/Usuario.php");
require_once("../Models/Lista.php");
require_once("../Models/Pelicula.php");

// Obtiene las listas de un usuario y las devuelve si las hay.
if (isset($_POST["id_usuario"]) && isset($_POST["key"]) && $_POST["key"] == "get_listas_usuario") {
    $id_usuario = $_POST["id_usuario"];
    $listas = Lista::get_listas_usuario($id_usuario);

    if (count($listas) > 0) {
        $array_listas = array();
        foreach ($listas as $lista) {
            $array_listas[] = array(
                "id" => $lista->get_id(),
                "nombre" => $lista->get_nombre(),
                "fecha" => $lista->get_fecha_creacion()
            );
        }
    
        echo json_encode($array_listas);
    } else {
        echo json_encode("false");
    }
}

// Obtiene el id de la lista de favoritos de un usuario.
if (isset($_POST["id_usuario"]) && isset($_POST["key"]) && $_POST["key"] == "get_id_favoritos") {
    $id_usuario = $_POST["id_usuario"];

    $id_favoritos = Lista::get_id_lista_favoritos($id_usuario);

    echo json_encode($id_favoritos);
}

// Crea una lista nueva para el usuario.
if (isset($_POST["id_usuario"]) && isset($_POST["nombre"]) && isset($_POST["key"]) && $_POST["key"] == "create_lista") {
    $id_usuario = $_POST["id_usuario"];
    $nombre = $_POST["nombre"];

    $creada = Lista::insert_lista($nombre, date("Y-m-d", strtotime("now")), $id_usuario);

    echo json_encode($creada);
}

//EDITA EL NOMBRE DE UNA LISTA
if (isset($_POST["id_lista"]) && isset($_POST["nombre"]) && isset($_POST["key"]) && $_POST["key"] == "edit_lista") {
    $id_lista = $_POST["id_lista"];
    $nombre = $_POST["nombre"];

    $resultado = Lista::update_lista($id_lista, $nombre);

    echo json_encode($resultado);
}

// Elimina una lista
if (isset($_POST["id_lista"]) && isset($_POST["key"]) && $_POST["key"] == "delete_lista") {
    $id_lista = $_POST["id_lista"];

    $resultado = Lista::delete_lista($id_lista);

    echo json_encode($resultado);
}

// Comprueba si una película ya está en una lista
if (isset($_POST["id_pelicula"]) && isset($_POST["id_lista"]) && isset($_POST["key"]) && $_POST["key"] == "comprobar_pelicula_lista") {
    $id_pelicula = $_POST["id_pelicula"];
    $id_lista = $_POST["id_lista"];

    $resultado = Pelicula::comp_pelicula_en_lista($id_pelicula, $id_lista);

    echo json_encode($resultado);
}

// Añade una película a una lista
if (isset($_POST["id_pelicula"]) && isset($_POST["id_lista"]) && isset($_POST["key"]) && $_POST["key"] == "add_pelicula_lista") {
    $id_pelicula = $_POST["id_pelicula"];
    $id_lista = $_POST["id_lista"];

    $resultado = Pelicula::add_movie_to_list($id_pelicula, $id_lista);

    echo json_encode($resultado);
}

// Elimina una película de una lista
if (isset($_POST["id_pelicula"]) && isset($_POST["id_lista"]) && isset($_POST["key"]) && $_POST["key"] == "delete_pelicula_lista") {
    $id_pelicula = $_POST["id_pelicula"];
    $id_lista = $_POST["id_lista"];

    $resultado = Pelicula::delete_movie_to_list($id_pelicula, $id_lista);

    echo json_encode($resultado);
}
