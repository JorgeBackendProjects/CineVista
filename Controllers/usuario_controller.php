<?php
require_once("../Models/Usuario.php");

if (isset($_POST["key"]) && $_POST["key"] == "inicio" && isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $inicio = Usuario::iniciar_sesion($username, $password); 

    echo json_encode($inicio);
}

if (isset($_POST["key"]) && $_POST["key"] == "cerrar_sesion") {
    Usuario::cerrar_sesion();
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