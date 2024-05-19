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

// Condición para obtener la imagen del perfil del usuario y cargarla en perfil.php.
if (isset($_POST["key"]) && $_POST["key"] == "get_imagen" && isset($_POST["id_usuario"])) {
    $id = $_POST["id_usuario"];

    $imagen = Usuario::get_imagen_by_id($id);

    if ($imagen != false) {
        echo json_encode($imagen);
    } else {
        echo json_encode("");
    }
}

// Condición para editar la imagen del perfil.
if (isset($_POST["key"]) && $_POST["key"] == "editar_imagen" && isset($_POST["id_usuario"]) && isset($_POST["imagen"])) {
    $id = $_POST["id_usuario"];
    $imagen = $_POST["imagen"];

    $actualizado = Usuario::update_imagen($id, $imagen);

    echo json_encode($actualizado);
}

// Se editan todos los campos del usuario menos la imagen
if (isset($_POST["key"]) && $_POST["key"] == "editar_con_password" && isset($_POST["id_usuario"]) && isset($_POST["password_actual"]) && isset($_POST["password_nueva"]) && isset($_POST["username"]) && isset($_POST["email"])) {
    $id = $_POST["id_usuario"];
    $password_actual = $_POST["password_actual"];
    $password_nueva = $_POST["password_nueva"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    // Si las contraseñas actuales coinciden se edita la información del usuario, en caso contrario se informa al usuario con un mensaje.
    $comp_password = Usuario::comp_password($id, $password_actual); 
    if ($comp_password == "OK") {
        $actualizado = Usuario::update_con_password($id, $username, $email, $password_nueva);

        // Si la actualización ha ido bien se devuelve OK, en caso contrario un mensaje.
        if ($actualizado == "OK") {
            echo json_encode("OK");
        } else {
            echo json_encode($actualizado);
        }
    } else {
        echo json_encode($comp_password);
    }
}

// Se editan todos los campos del usuario menos la imagen y la contraseña
if (isset($_POST["key"]) && $_POST["key"] == "editar_sin_password" && isset($_POST["id_usuario"]) && isset($_POST["username"]) && isset($_POST["email"])) {
    $id = $_POST["id_usuario"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    $actualizado = Usuario::update_sin_password($id, $username, $email);

    // Si la actualización ha ido bien se devuelve OK, en caso contrario un mensaje.
    if ($actualizado == "OK") {
        echo json_encode("OK");
    } else {
        echo json_encode($actualizado);
    }
}

// Condición para eliminar la cuenta de usuario y cerrar su sesión.
if (isset($_POST["key"]) && $_POST["key"] == "eliminar_usuario" && isset($_POST["id_usuario"])) {
    $id = $_POST["id_usuario"];

    $delete = Usuario::delete_usuario($id); 
    
    if ($delete == "OK") {
        echo json_encode(["status" => "OK"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => $delete]);
    }
}