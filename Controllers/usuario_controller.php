<?php
require_once("../Models/Usuario.php");
require_once("../Models/Lista.php");

// Condición para iniciar sesión. Se obtiene la última url desde donde se hizo el redirect a sesion.php para devolver a la misma página.
if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["key"]) && $_POST["key"] == "inicio") {
    $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : '../index.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    $inicio = Usuario::iniciar_sesion($username, $password); 

    if ($inicio == "OK") {
        echo json_encode(["status" => "OK", "redirect_url" => $redirect_url]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => $inicio]);
    }
}

// Condición para cerrar sesión.
if (isset($_POST["key"]) && $_POST["key"] == "cerrar_sesion") {
    Usuario::cerrar_sesion();
    echo json_encode("OK");
}

// Condición para registrar un nuevo usuario.
if (isset($_POST["nombre"]) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["key"]) && $_POST["key"] == "registro") {
    $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : '../index.php';
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $nombre = $_POST["nombre"];

    $registro = Usuario::insert_usuario($username, $email, $password, $nombre); 

    // Si el registro ha ido bien, se crea una lista favoritos para el usuario y se devuelve un OK.
    if ($registro == "OK") {
        $id_usuario = Usuario::get_id_usuario($username);
        if ($id_usuario != false) {
            Lista::insert_lista("Favoritos", date("Y-m-d", strtotime("now")), $id_usuario);
        }

        echo json_encode(["status" => "OK", "redirect_url" => $redirect_url]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => $registro]);
    }
}

if (isset($_POST["key"]) && $_POST["key"] == "editar_usuario") {
    
}

if (isset($_POST["key"]) && $_POST["key"] == "eliminar_usuario") {
    
}