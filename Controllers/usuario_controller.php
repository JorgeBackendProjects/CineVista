<?php
require_once("../Models/Usuario.php");

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

if (isset($_POST["key"]) && $_POST["key"] == "cerrar_sesion") {
    Usuario::cerrar_sesion();
    echo json_encode("OK");
}

if (isset($_POST["key"]) && $_POST["key"] == "registro") {
    
}

if (isset($_POST["key"]) && $_POST["key"] == "editar_usuario") {
    
}

if (isset($_POST["key"]) && $_POST["key"] == "eliminar_usuario") {
    
}



if (isset($_POST["key"]) && $_POST["key"] == "escribir_comentario") {
    
}

/*if (isset($_POST["key"]) && $_POST["key"] == "editar_comentario") {
    
}*/

if (isset($_POST["key"]) && $_POST["key"] == "eliminar_comentario") {
    
}