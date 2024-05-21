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
                        mostrar_modal("Se ha iniciado sesión con éxito.");

                        setTimeout(() => {
                            history.back();
                        }, 2000);
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
