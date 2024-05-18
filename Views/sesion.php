<?php
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"] == "iniciar_sesion" ? "Iniciar sesion" : "Registro";
}

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
    <title><?php echo $accion; ?></title>

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

        main {
            min-height: 150vh;
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

        /*Botón Volver*/
        .atras {
            width: 7rem;
            height: 2.5rem;
            font-size: 1.25rem;
            position: absolute;
            top: 6.8rem;
            left: 3rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        /*Texto*/
        .principal h1 {
            margin: 3rem auto 1rem 3rem;
        }

        .principal p {
            margin: 0 3vw 2rem 2.5vw;
        }

        #registro_ver_password {
            display: flex;
            justify-content: center;
            width: 6rem;
            height: 2rem;
            margin: 0rem 0 1rem 6%;
            font-size: 1.25rem;
            background-color: blue;
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        /*Variación para la clase principal de inicio*/
        #iniciar_principal {
            display: flex;
            flex-direction: column;
            width: 30rem;
            height: 65vh;
            margin: 5% auto auto auto;
            background-color: rgba(0, 0, 0, 50%);
            border-radius: 30px;
        }

        #iniciar_principal form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        #iniciar_principal form input {
            width: 80%;
            height: 3rem;
            padding-left: 5%;
            margin: 2rem auto auto 3rem;
            border: 2px solid black;
            border-radius: 10px;
        }

        #iniciar_principal form .boton_enviar {
            width: 10rem;
            height: 2.5rem;
            font-size: 1.25rem;
            margin: 3rem 0 3rem 45%;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        /*Variación para la clase principal de registro*/
        #registro_principal {
            display: flex;
            flex-direction: column;
            width: 50vw;
            height: 120vh;
            margin: 3% auto auto auto;
            background-color: rgba(0, 0, 0, 50%);
            border-radius: 30px;
        }

        #registro_principal form{
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: center;
            align-content: flex-end;
            align-items: flex-end;
            width: 82.5%;
        } 

        #registro_principal form input{
            width: 30vw;
            height: 3rem;
            padding-left: 5%;
            margin: 1rem 1rem 1rem 2rem;
            border: 2px solid black;
            border-radius: 10px;
        } 

        #registro_principal form label{
            margin-left: 5%;
        } 

        #registro_inputs {
            display: flex;
            flex-direction: column;
        }
        
        #registro_principal form .boton_enviar{
            width: 10rem;
            height: 2.5rem;
            margin: 2rem 2% 0 0;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        } 

        /*Modal de información sobre el envío*/
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
            width: 25%;
            height: 20%;
            margin: 18% auto;
            padding: 20px;
            background-color: white;
            border-radius: 35px;
            border: 1px solid black;
        }

        .mensaje_modal {
            display: flex;
            justify-content: center;
            margin-top: 6vh;
            text-align: center;
            font-size: 1.1rem;
            color: black;
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

            #registro_principal {
                height: 200vh;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="header_left">
                <div class="icon"></div>
                <h1 class="title">CineVista</h1>
            </div>
            <div class="header_right">
                <?php include_once ("Assets/Templates/view_no_sesion_header.html"); ?>
            </div>
        </nav>
    </header>

    <main>
        <?php
        if ($accion == "Iniciar sesion") {
            include_once ("Assets/Templates/iniciar_sesion.html");
        } else {
            include_once ("Assets/Templates/registro.html");
        }
        ?>
    </main>

    <div id="contenedor_modal" class="contenedor_modal">
        <div id="modal" class="modal">
            <span id="cerrar_modal" class="cerrar_modal">&times;</span>
            <p id="mensaje_modal" class="mensaje_modal"></p>
        </div>
    </div>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        function iniciar_listeners() {
            var contenedor_modal = jQuery("#contenedor_modal");
            var modal = jQuery("#modal");

            // Cuando el documento cargue se inician todos los listeners.
            jQuery(document).ready(function() {
                // Eventos click para cerrar el modal tanto en la cruz como fuera del modal.
                jQuery("#cerrar_modal").on("click", function() {
                    contenedor_modal.css("display", "none");
                });

                jQuery(window).on("click", function(event) {
                    if (event.target == contenedor_modal[0]) {
                        contenedor_modal.css("display", "none");
                    }
                });

                // Evento para envío de credenciales. Se previene el comportamiento por defecto y se envía una petición ajax al controller de usuarios. 
                jQuery("#boton_inicio").on("click", function(event) {
                    event.preventDefault();

                    // Se envía el username, password y la url desde donde se ha llegado a sesion.php, para devolver al usuario al finalizar la petición.
                    jQuery.ajax({
                        url: '../Controllers/usuario_controller.php',
                        method: 'POST',
                        data: {
                            username: jQuery('#username_inicio').val(),
                            password: jQuery("#password_inicio").val(),
                            key: "inicio",
                            redirect_url: jQuery("#redirect_url").val()
                        },
                        success: function (data) {
                            let respuesta = JSON.parse(data);

                            // Si se ha devuelto OK, redirige al usuario a la página anterior.
                            if (respuesta.status == "OK") {
                                let redirect_url = respuesta.redirect_url;
                                window.location = redirect_url || "../index.php";
                            } else {
                                mostrar_modal(respuesta.mensaje);
                            }
                        },
                        error: function(xhr, status, error) {
                            mostrar_modal("Ocurrió un error en el servidor. Por favor, inténtalo de nuevo.");
                        }
                    });
                });

                jQuery("#boton_registro").on("click", function(event) {
                    event.preventDefault();

                    let nombre = jQuery("#registro_nombre").val();
                    let username = jQuery("#registro_username").val();
                    let email = jQuery("#registro_email").val();
                    let password = jQuery("#registro_password").val();
                    let repetir_password = jQuery("#registro_repetir_password").val();

                    // Si las contraseñas coinciden se comprueban los campos con expresiones regulares.
                    if (password == repetir_password) {
                        let comp_username = /^[a-zA-Z0-9_.]{5,20}$/;
                        let comp_email = /^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,5}$/;
                        let comp_password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_-])[A-Za-z\d$@$!%*?&_-]{8,25}$/;
                        
                        // Si todas las expresiones regulares se cumplen, se procede al envío para registrar la cuenta de usuario.
                        if (!comp_username.test(username)) {
                            mostrar_modal("El nombre de usuario debe tener una longitud entre 5 y 20 caracteres sin espacios en blanco, como separador se permiten guiones bajos y puntos.");
                        } else if (!comp_email.test(email)) {
                            mostrar_modal("La dirección de correo electrónico no es válida.");
                        } else if (!comp_password.test(password)) {
                            mostrar_modal("La contraseña debe tener una longitud entre 8 y 15 caracteres sin espacios en blanco en los que, al menos haya: una minúscula, una mayúscula, un número y un carácter especial.");
                        
                        // Se hace la solicitud ajax al controller de usuario.
                        } else {
                            jQuery.ajax({
                                url: '../Controllers/usuario_controller.php',
                                method: 'POST',
                                data: {
                                    nombre: nombre,
                                    username: username,
                                    email: email,
                                    password: password,
                                    key: "registro",
                                    redirect_url: jQuery("#redirect_url").val()
                                },
                                success: function (data) {
                                    let respuesta = JSON.parse(data);

                                    // Si se ha devuelto OK, redirige al usuario a la página anterior.
                                    if (respuesta.status == "OK") {
                                        mostrar_modal("La cuenta se ha registrado con éxito, inicia sesión cuando quieras.");

                                        setTimeout(() => {
                                            let redirect_url = respuesta.redirect_url;
                                            window.location = redirect_url || "../index.php";
                                        }, 3000);
                                    } else {
                                        mostrar_modal(respuesta.mensaje);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    mostrar_modal("Ocurrió un error en el servidor. Por favor, inténtalo de nuevo.");
                                }
                            });
                        }

                    } else {
                        mostrar_modal("Las contraseñas no coinciden.");
                    }
                });

                jQuery("#registro_ver_password").on("click", function() {
                    let tipo_1 = jQuery("#registro_password").attr("type") == "password" ? "text" : "password";
                    jQuery("#registro_password").attr("type", tipo_1);

                    let tipo_2 = jQuery("#registro_repetir_password").attr("type") == "password" ? "text" : "password";
                    jQuery("#registro_repetir_password").attr("type", tipo_2);
                });
            });

            // Listener para que, al pulsar el botón vuelve atrás hasta la coordenada anterior. 
            jQuery("#atras").on("click", function () {
                history.back();
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