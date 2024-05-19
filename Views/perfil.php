<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

// Se almacena la última url para devolver al usuario a la misma página al iniciar o registrarse.
$redirect_url = $_SERVER['HTTP_REFERER'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="Assets/Styles/sesion.css">-->
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Perfil de usuario</title>

    <style>
         @import url('https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Inria Sans", sans-serif;
            font-size: 1.1rem;
            background-color: rgb(2, 16, 29, 93%);
            color: white;
        }

        /*Cabecera*/
        header {
            position: sticky;
            width: 100%;
            top: 0;
            z-index: 1;
            background-color: rgb(2, 27, 48);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 5rem;
            padding: 10px 20px;
        }

        .header_left,
        .header_right {
            display: flex;
            align-items: center;
        }

        .header_left {
            margin-left: 30px;
        }

        .header_right {
            margin-right: 30px;
        }

        .header_left .icon {
            width: 3.5rem;
            height: 3rem;
            background-image: url("Assets/Images/icon.png");
            background-size: 100% 100%;
        }

        .header_left a {
            text-decoration: none;
            color: white;
        }

        .header_left .title {
            font-family: "Montserrat", sans-serif;
            font-weight: normal;
            font-size: 1.9rem;
            margin: 0 20px;
        }

        .header_right ul {
            display: flex;
            margin: 0;
            list-style-type: none;
        }

        .header_right ul p {
            margin: 0.5rem 10px 0 0;
        }

        .header_right ul li {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .header_right ul li a {
            text-decoration: none;
            color: white;
            border: 1px solid;
            border-radius: 10px;
            padding: 0.4rem;
        }

        .header_right ul li a i {
            margin-right: 0.3rem;
        }

        /*Div principal del perfil*/
        .perfil {
            display: flex;
            flex-direction: column;
            width: 30rem;
            height: 65vh;
            margin: 1% auto auto auto;
            background-color: rgba(0, 0, 0, 50%);
            border-radius: 30px;
        }

        .perfil h1 {
            margin: 2rem auto 1rem 3rem;
        }

        .perfil p {
            margin: 1vw 3vw 2rem 2.5vw;
        }
        .perfil .info_perfil {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .perfil .imagen {
            width: 11rem;
            height: 10.5rem;
            background-image: url("Assets/Images/usuario_por_defecto.png");
            background-size: 100% 100%;
            border-radius: 50%;
        }

        /*Botones*/
        .container_boton_atras {
            display: flex;
            flex-direction: column;
            width: 30rem;
            margin: 2% auto auto auto;
        }

        .atras {
            width: 6rem;
            height: 2.7rem;
            margin: 0 0 0 0;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .perfil .editar_perfil_button {
            width: 12rem;
            height: 2.5rem;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .perfil .eliminar_perfil_button {
            width: 12rem;
            height: 2.5rem;
            margin-top: 10vh;
            font-size: 1.25rem;
            background-color: rgb(255, 50, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .perfil form {
            display: none;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .perfil form label {
            margin: 1rem auto 1vh 3.5rem;
        }

        .perfil form input {
            width: 80%;
            height: 3rem;
            padding-left: 5%;
            border: 2px solid black;
            border-radius: 10px;
        }

        .perfil form .botones {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 2vh;
        }
        
        .boton_cancelar {
            width: 30%;
            height: 2.5rem;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .boton_enviar {
            width: 30%;
            height: 2.5rem;
            font-size: 1.25rem;
            background-color: rgb(255, 50, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }
        
        .input_imagen {
            display: none; 
        }

        .imagen_label {
            display: inline-block;
            width: 50px;
            height: 50px;
            margin-left: 75%;
            margin-top: 60%;
            border-radius: 50%;
            background-color: #043962;
            color: white;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
            font-size: 24px;
            transition: background-color 0.3s ease;
        }

        .imagen_label:hover {
            background-color: #0056b3;
        }

        /*Modal de confirmación para eliminar perfil*/
        .contenedor_modal {
            display: none;
            position: fixed;
            width: 100%; 
            height: 100%; 
            left: 0;
            top: 0;
            z-index: 1;
            overflow: auto; 
            background-color: rgba(0,0,0,0.6); 
        }

        .modal {
            display: flex;
            flex-direction: row-reverse;
            width: 35rem;
            height: 15rem;
            margin: 18% auto;
            padding: 20px;
            background-color: white;
            border-radius: 35px;
            border: 1px solid black;
        }

        .columna_modal {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .mensaje_modal {
            display: flex;
            justify-content: center;
            text-align: center;
            font-size: 1.1rem;
            color: black;
        }

        .eliminar_cuenta_modal {
            display: none;
            width: 50%;
            height: 2.5rem;
            margin-top: 3vh;
            font-size: 1.2rem;
            background-color: rgb(255, 50, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
        }

        .cerrar_modal {
            color: grey;
            float: right;
            font-size: 30px;
            font-weight: bold;
        }

        .cerrar_modal:hover,
        .cerrar_modal:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /*Footer*/
        .footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            z-index: 1;
            background-color: rgb(2, 27, 48);
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 5rem;
            padding: 10px 20px;
        }

        .privacidad {
            display: flex;
            justify-content: space-between;
        }

        .privacidad p {
            margin-right: 2rem;
            cursor: pointer;
        }

        .social_media a {
            text-decoration: none;
            color: white;
            border-radius: 10px;
            padding: 0.4rem;
        }

        .social_media a i {
            margin-right: 0.3rem;
            font-size: 2rem;
        }

        @media only screen and (max-width: 1600px) {
            main {
                min-height: 150vh;
            }
        }

        @media only screen and (max-width: 1000px) { 
            #perfil {
                width: 25rem;
                margin: 3% auto auto auto;
            }

            .container_boton_atras {
                width: 25rem;
                margin: 3% auto auto auto;
            }
        }

        /*AÑADIR FOOTER, HEADER y MENOS ANCHURA AL CONTAINER */

    </style>
</head>

<body>
    <header>
        <nav>
            <div class="header_left">
                <a href="../index.php"><div class="icon"></div></a>
                <a href="../index.php"><h1 class="title">CineVista</h1></a>
            </div>
            <div class="header_right">
            <?php 
            if ($sesion_iniciada) {
                if ($_SESSION["rol"] == "Administrador") {
                    include_once("Assets/Templates/view_admin_header.html");
                } else {
                    include_once ("Assets/Templates/view_sesion_header.html"); 
                }
            }
            ?>
            </div>
        </nav>
    </header>

    <main>
        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION["id"]; ?>" />
        <input type="hidden" id="base64_imagen_code" name="base64_imagen_code" />
        <!--<input type="hidden" id="redirect_url" name="redirect_url" value="<?php //echo htmlspecialchars($redirect_url); ?>">-->
        <div class="container_boton_atras">
            <button id="atras" class="atras">Volver</button>
        </div>

        <div id="perfil" class="perfil">
            <h1 id="titulo" class="titulo">Tu perfil</h1>

            <div id="info_perfil" class="info_perfil">
                <div id="imagen" class="imagen">
                    <input type="file" id="input_imagen" name="input_imagen" class="input_imagen" accept="image/*">
                    <label for="input_imagen" class="imagen_label"><i class="fas fa-camera"></i></label>
                </div>
                <p id="username" class="username"><?php echo $_SESSION["username"]; ?></p>

                <button id="editar_perfil_button" class="editar_perfil_button">Editar perfil</button>                
                <button id="eliminar_perfil_button" class="eliminar_perfil_button">Eliminar cuenta</button>
            </div>
            
            <form id="editar_perfil_form">
                <label>Nombre de usuario</label>
                <input type="text" id="editar_username" name="editar_username" class="username" value="<?php echo $_SESSION["username"]; ?>" placeholder="Nombre de usuario" pattern="^[a-zA-Z0-9_.]{1,20}$" title="El nombre de usuario debe tener una longitud entre 5 y 20 caracteres sin espacios en blanco, como separador se permiten guiones bajos y puntos." required/>
                <label>E-mail</label>
                <input type="email" id="editar_email" name="editar_email" class="email" value="<?php echo $_SESSION["email"]; ?>" placeholder="E-mail" pattern="^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,5}$" title="La dirección de correo electrónico debe ser válida y terminar en .com o .es." required/>
                <label>Contraseña actual</label>
                <input type="password" id="editar_password" name="editar_password" class="password" placeholder="Contraseña" autocomplete="off" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_-])[A-Za-z\d$@$!%*?&_-]{8,25}$" title="La contraseña debe tener entre 8 y 25 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial." required/>
                <label>Nueva contraseña</label>
                <input type="password" id="editar_nueva_password" name="editar_nueva_password" class="password" placeholder="Nueva contraseña" autocomplete="off" required/>
                
                <div id="botones" class="botones">
                    <button id="boton_cancelar" name="boton_cancelar" class="boton_cancelar">Cancelar</button>    
                    <button id="boton_enviar" name="boton_enviar" class="boton_enviar">Editar perfil</button>
                </div>
            </form>
        </div>
    </main>

    <div id="contenedor_modal" class="contenedor_modal">
        <div id="modal" class="modal">
            <span id="cerrar_modal" class="cerrar_modal">&times;</span>
            <div class="columna_modal">
                <p id="mensaje_modal" class="mensaje_modal"></p>
                <button id="eliminar_cuenta_modal" class="eliminar_cuenta_modal">Si, elimina mi cuenta</button>
            </div>
        </div>
    </div>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        function iniciar_listeners() {
            var contenedor_modal = jQuery("#contenedor_modal");
            var modal = jQuery("#modal");

            jQuery(document).ready(function() {
                get_imagen_perfil();

                // Evento para mostrar el formulario de editar perfil y ocultar el resto.
                jQuery("#editar_perfil_button").on("click", function() {
                    jQuery("#info_perfil").hide();
                    jQuery("#titulo").text("Editar perfil");
                    jQuery("#editar_perfil_form").show().css("display", "flex");
                });

                // Evento para ocultar el formulario de editar perfil y mostrar el resto.
                jQuery("#boton_cancelar").on("click", function() {
                    jQuery("#editar_perfil_form").hide();
                    jQuery("#titulo").text("Tu perfil");
                    jQuery("#info_perfil").show();
                });

                // Mostrar modal de confirmación al pulsar sobre eliminar cuenta.
                jQuery("#eliminar_perfil_button").on("click", function() {
                    jQuery("#eliminar_cuenta_modal").show();
                    mostrar_modal("¿Estás seguro de que quieres eliminar tu cuenta?");
                });

                // Evento botón del modal para eliminar la cuenta.                
                jQuery("#eliminar_cuenta_modal").on("click", function() {
                    eliminar_cuenta();
                });

                // Eventos click para cerrar el modal tanto en la cruz como fuera del modal.
                jQuery("#cerrar_modal").on("click", function() {
                    contenedor_modal.css("display", "none");
                });

                jQuery(window).on("click", function(event) {
                    if (event.target == contenedor_modal[0]) {
                        contenedor_modal.css("display", "none");
                    }
                });

                // Prevenimos el comportamiento por defecto del elemento <a> para hacer una petición al controller de usuario que cierra la sesión y recargar la página.
                jQuery("#redirect_cerrar_sesion").on("click", function(event) {
                    event.preventDefault();

                    jQuery.ajax({
                        url: '../Controllers/usuario_controller.php',
                        method: 'POST',
                        data: {
                            key: "cerrar_sesion"
                        },
                        success: function(data) {
                            let resultado = JSON.parse(data);
                
                            if (resultado == "OK") {
                                window.location = "../index.php";
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cerrar sesión: " + error);
                        }
                    });
                });

                // Evento para el input file de cambiar imagen que se ejecuta cada vez que se sube un archivo nuevo.
                jQuery("#input_imagen").on("change", function(event) {
                    // Obtenemos el archivo del input de la imagen.
                    let archivo = event.target.files[0];

                    // Si hay algún archivo cargado y corresponde a una imagen, obtenemos su contenido en base64 con FileReader y la seteamos.
                    if (archivo && archivo.type.startsWith('image/')) {
                        let reader = new FileReader();
                        
                        // Leemos el fichero que se ha cargado para obtener su contenido
                        reader.onload = function(e) {
                            // Si la extensión de archivo es válida y corresponde a una imagen se actualiza, en caso contrario se muestra un mensaje.
                            let imagen_base64 = e.target.result;
                            jQuery("#imagen").css("background-image", `url(${imagen_base64})`);
                            actualizar_imagen(imagen_base64);
                        };

                        reader.readAsDataURL(archivo);
                    } else {
                        jQuery("#eliminar_cuenta_modal").hide();
                        mostrar_modal("La imagen seleccionada no es válida.");
                    }
                });

                // Listener para que, al pulsar el botón vuelve atrás hasta la coordenada anterior. 
                jQuery("#atras").on("click", function () {
                    history.back();
                });
            });
        }
        
        // Obtenemos la imagen del usuario de la base de datos y la cargamos:
        function get_imagen_perfil() {
            jQuery.ajax({
                url: '../Controllers/usuario_controller.php',
                method: 'POST',
                data: {
                    id_usuario: jQuery("#id_usuario").val(),
                    key: "get_imagen"
                },
                success: function (data) {
                    let imagen = JSON.parse(data);
                    
                    if (imagen != "") {
                        jQuery("#imagen").css("background-image", `url(${imagen})`);
                        jQuery("#base64_imagen_code").val(imagen);
                        imagen_base64 = imagen;
                    }
                },
                error: function(xhr, status, error) {
                    jQuery("#eliminar_cuenta_modal").hide();
                    mostrar_modal("No se pudo obtener tu imagen del perfil.");
                }
            });
        }

        // Se actualiza la imagen del perfil enviando por ajax el contenido de la imagen en base64 para insertarla en la base de datos.
        function actualizar_imagen(imagen_base64) {
            jQuery.ajax({
                url: '../Controllers/usuario_controller.php',
                method: 'POST',
                data: {
                    id_usuario: jQuery("#id_usuario").val(),
                    imagen: imagen_base64,
                    key: "editar_imagen"
                },
                success: function (data) {
                    let resultado = JSON.parse(data);
                    
                    if (resultado == "OK") {
                        window.location.reload();
                    } else {
                        jQuery("#eliminar_cuenta_modal").hide();
                        mostrar_modal(resultado);
                    }
                },
                error: function(xhr, status, error) {
                    jQuery("#eliminar_cuenta_modal").hide();
                    mostrar_modal("No se pudo obtener tu imagen del perfil.");
                }
            });
        }

        // FALTA // Controlar si hay nueva contraseña, si no dejar la que estaba...
        function actualizar_informacion() {
            jQuery.ajax({
                url: '../Controllers/usuario_controller.php',
                method: 'POST',
                data: {
                    id_usuario: jQuery("#id_usuario").val(),
                    username: jQuery("#editar_username").val(),
                    email: jQuery("#editar_email").val(),
                    password: jQuery("#editar_nueva_password").val(),
                    key: "editar_imagen"
                },
                success: function (data) {
                    let resultado = JSON.parse(data);
                    
                    if (resultado == "OK") {
                        window.location.reload();
                    } else {
                        jQuery("#eliminar_cuenta_modal").hide();
                        mostrar_modal(resultado);
                    }
                },
                error: function(xhr, status, error) {
                    jQuery("#eliminar_cuenta_modal").hide();
                    mostrar_modal("No se pudo obtener tu imagen del perfil.");
                }
            });
        }

        // Función que envía una petición para eliminar la cuenta de usuario y redirige al index.php
        function eliminar_cuenta() {
            jQuery.ajax({
                url: '../Controllers/usuario_controller.php',
                method: 'POST',
                data: {
                    id_usuario: jQuery("#id_usuario").val(),
                    key: "eliminar_usuario"
                },
                success: function (data) {
                    let respuesta = JSON.parse(data);

                    // Si se ha devuelto OK, se elimina la cuenta, se cierra la sesión y redirige al index.php.
                    if (respuesta.status == "OK") {
                        jQuery("#eliminar_cuenta_modal").hide();
                        mostrar_modal("Se ha eliminado cuenta. ¡Esperamos tenerte pronto de vuelta!.");

                        setTimeout(() => {
                            window.location = "../index.php";
                        }, 3000);
                    } else {
                        jQuery("#eliminar_cuenta_modal").hide();
                        mostrar_modal(respuesta.mensaje);
                    }
                },
                error: function(xhr, status, error) {
                    jQuery("#eliminar_cuenta_modal").hide();
                    mostrar_modal("No se pudo eliminar el perfil.");
                }
            });
        }

        // Función para mostrar el modal con el mensaje determinado.
        function mostrar_modal(mensaje) {
            jQuery("#mensaje_modal").text(mensaje);
            jQuery("#contenedor_modal").css("display", "block");
        }

        iniciar_listeners();
    </script>
</body>

</html>