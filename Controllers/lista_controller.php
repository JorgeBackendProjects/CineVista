<?php
require_once("../Models/Conexion.php");
require_once("../Models/Usuario.php");
require_once("../Models/Lista.php");

// Obtiene las listas de un usuario.
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

if (isset($_POST["key"]) && $_POST["key"] == "crear_lista") {
    
}

if (isset($_POST["key"]) && $_POST["key"] == "eliminar_lista") {
    
}