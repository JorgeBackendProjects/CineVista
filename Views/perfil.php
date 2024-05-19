<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

// Se almacena la última url para devolver al usuario a la misma página al iniciar o registrarse.
$redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "..index.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/Styles/perfil.css">
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Perfil de usuario</title>
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

        <div class="container_boton_atras">
            <button id="atras" class="atras">Volver</button>
        </div>

        <div id="perfil" class="perfil">
            <h1 id="titulo" class="titulo">Tu perfil</h1>
            <p id="info_editar" class="info_editar">Puedes editar sin modificar la contraseña</p>

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
                    jQuery("#info_editar").show();
                    jQuery("#editar_perfil_form").show().css("display", "flex");
                });

                // Evento para ocultar el formulario de editar perfil y mostrar el resto.
                jQuery("#boton_cancelar").on("click", function() {
                    jQuery("#editar_perfil_form").hide();
                    jQuery("#info_editar").hide();
                    jQuery("#titulo").text("Tu perfil");
                    jQuery("#info_perfil").show();
                });

                // Mostrar modal de confirmación al pulsar sobre eliminar cuenta.
                jQuery("#eliminar_perfil_button").on("click", function() {
                    jQuery("#eliminar_cuenta_modal").show();
                    mostrar_modal("¿Estás seguro de que quieres eliminar tu cuenta?");
                });

                jQuery("#boton_enviar").on("click", function(event) {
                    event.preventDefault();
                    actualizar_informacion();
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

        // FALTA
        function actualizar_informacion() {
            let password_actual = jQuery("#editar_password").val();
            let password_nueva = jQuery("#editar_nueva_password").val();
            
            // Si no hay nueva contraseña se edita la información omitiendo esta. En caso contrario se comprueba la contraseña actual, y si coincide se edita toda la información.
            if (password_nueva == "") {
                jQuery.ajax({
                    url: '../Controllers/usuario_controller.php',
                    method: 'POST',
                    data: {
                        id_usuario: jQuery("#id_usuario").val(),
                        username: jQuery("#editar_username").val(),
                        email: jQuery("#editar_email").val(),
                        key: "editar_sin_password"
                    },
                    success: function (data) {
                        let resultado = JSON.parse(data);
                        
                        // Si todo ha ido bien se muestra un modal y se recarga la página a los 2 segundos. Si no, se muestra otro mensaje en el modal.
                        if (resultado == "OK") {
                            jQuery("#eliminar_cuenta_modal").hide();
                            mostrar_modal("Información editada con éxito");

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
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
            } else {
                jQuery.ajax({
                    url: '../Controllers/usuario_controller.php',
                    method: 'POST',
                    data: {
                        id_usuario: jQuery("#id_usuario").val(),
                        username: jQuery("#editar_username").val(),
                        email: jQuery("#editar_email").val(),
                        password_actual: password_actual,
                        password_nueva: password_nueva,
                        key: "editar_con_password"
                    },
                    success: function (data) {
                        let resultado = JSON.parse(data);
                        
                        // Si todo ha ido bien se muestra un modal y se recarga la página a los 2 segundos. Si no, se muestra otro mensaje en el modal.
                        if (resultado == "OK") {
                            jQuery("#eliminar_cuenta_modal").hide();
                            mostrar_modal("Información editada con éxito");

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            jQuery("#eliminar_cuenta_modal").hide();
                            mostrar_modal(resultado);
                        }
                    },
                    error: function(xhr, status, error) {
                        jQuery("#eliminar_cuenta_modal").hide();
                        mostrar_modal("No se pudo actualizar en estos momentos. Por favor, inténtalo más tarde.");
                    }
                });
            }
            
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