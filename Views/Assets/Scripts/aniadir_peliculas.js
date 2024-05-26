function iniciar_listeners() {
    var contenedor_modal = jQuery("#contenedor_modal");
    var modal = jQuery("#modal");

    jQuery(document).ready(function() {
        // Se oculta la pantalla de carga. 
        jQuery("#pantalla_carga").css("display", "none");

        // Obtenemos el valor de la cookie con la última página insertada, si no tiene se le asigna el número 171 (Las anteriores se han insertado ya).
        let ultima_pagina = jQuery.cookie('ultima_pagina_cookie');
        if (!ultima_pagina) {
            ultima_pagina = 171;
            jQuery.cookie('ultima_pagina_cookie', ultima_pagina, { expires: 90, path: '/' });
        }

        // Mostramos el valor en #ultima_pagina
        jQuery("#ultima_pagina").text(`Última página insertada: ${ultima_pagina}`);

        // Guardamos el valor incrementado en #num_pagina.
        let pagina_a_insertar = parseInt(ultima_pagina) + 1;
        jQuery("#num_pagina").val(pagina_a_insertar);

        // Evento click para añadir películas y actualizar la cookie.
        jQuery("#insertar_button").on("click", function() {
            jQuery("#pantalla_carga").css("display", "flex");
            
            jQuery.ajax({
                url: '../Controllers/pelicula_controller.php',
                method: 'POST',
                data: {
                    pagina: pagina_a_insertar,
                    key: "insert_peliculas"
                },
                success: function (data) {
                    jQuery("#pantalla_carga").css("display", "none");
                    let resultado = JSON.parse(data);

                    if (resultado == "OK") {
                        mostrar_modal("Se han insertado 100 nuevas películas");
                        
                        // Actualizamos la cookie con la última página insertada.
                        jQuery.cookie('ultima_pagina_cookie', pagina_a_insertar+9, { expires: 90, path: '/' });
                    } else {
                        mostrar_modal(resultado);
                    }
                },
                error: function (xhr, status, error) {
                    jQuery("#pantalla_carga").css("display", "none");
                    console.error("Se ha producido un error: " + error);
                }
            });
        });
    });
    
    // Eventos click para cerrar el modal tanto en la cruz como fuera del modal.
    jQuery("#cerrar_modal").on("click", function() {
        contenedor_modal.css("display", "none");
        window.location.reload();
    });

    jQuery(window).on("click", function(event) {
        if (event.target == contenedor_modal[0]) {
            contenedor_modal.css("display", "none");
            window.location.reload();
        }
    });

    // Listener para que, al pulsar el botón vuelva al index. 
    jQuery("#atras").on("click", function () {
        window.location = "../index.php";
    });
}

// Función para mostrar el modal con el mensaje determinado.
function mostrar_modal(mensaje) {
    jQuery("#mensaje_modal").text(mensaje);
    jQuery("#contenedor_modal").css("display", "flex");
    jQuery(".listas_modal").hide();
}
