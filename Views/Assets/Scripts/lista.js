function iniciar_listeners() {
    var contenedor_modal = jQuery("#contenedor_modal");
    var modal = jQuery("#modal");

    jQuery(document).ready(function () {
        var id_lista = jQuery("#id_lista").val();

        // Se cargan las películas de la lista.
        cargar_peliculas(id_lista);

        // Listener para eliminar una lista
        jQuery("#eliminar_pelicula_modal").on("click", function () {
            let id_pelicula = jQuery("#eliminar_id_modal").val();
            eliminar_pelicula(id_lista, id_pelicula);
        });

        // Listener onclick que, cuando carga el documento se aplica a todos los div con clase "pelicula"
        jQuery(document).on("click", ".pelicula", function() {
            // Recoge el id del input hidden y el título.
            let id_pelicula = jQuery(this).find(".id_pelicula").val();
            let titulo = jQuery(this).find(".titulo").text();
            let busqueda = jQuery("#buscador").val();
            let nombre_lista = jQuery("#nombre_lista").text();
        
            // Redirige a la página de detalles de película con el id y titulo en la URL, además del id y nombre de la lista para regresar al mismo lugar luego.
            window.location = `pelicula.php?id=${id_pelicula}&titulo=${titulo}&id_lista=${id_lista}&nombre_lista=${nombre_lista}`;
        });

        // Prevenimos el comportamiento por defecto del elemento <a> para hacer una petición al controller de usuario que cierra la sesión y recargar la página.
        jQuery("#redirect_cerrar_sesion").on("click", function (event) {
            event.preventDefault();

            jQuery.ajax({
                url: '../Controllers/usuario_controller.php',
                method: 'POST',
                data: {
                    key: "cerrar_sesion"
                },
                success: function (data) {
                    let resultado = JSON.parse(data);

                    if (resultado == "OK") {
                        window.location = "../index.php";
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error al cerrar sesión: " + error);
                }
            });
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

        // Listener para que, al pulsar el botón vuelve atrás hasta la página anterior. 
        jQuery("#atras").on("click", function () {
            window.location = "mis_listas.php";
        });
    });
}

// Función para cargar las peliculas de la lista.
function cargar_peliculas(id_lista) {
    jQuery.ajax({
        url: '../Controllers/pelicula_controller.php',
        method: 'POST',
        data: {
            id_lista: id_lista,
            key: "get_peliculas_lista"
        },
        success: function (data) {
            if (JSON.parse(data) != "false") {
                let peliculas = JSON.parse(data);
                create_DOM_lista(peliculas);
                asignar_imagenes_peliculas(peliculas);
            } else {
                mostrar_modal("Aún no se han añadido películas a la lista.");
                jQuery("#eliminar_pelicula_modal").hide();
            }
        },
        error: function (xhr, status, error) {
            console.error("Ha ocurrido un error: " + error);
        }
    });
}

// Por cada div con clase "poster" se asigna su poster correspondiente.
function asignar_imagenes_peliculas(peliculas) {
    jQuery(".poster").each(function(i) {
        jQuery(this).css("background-image", `url(${peliculas[i].poster})`);
    });
}

// Crea el DOM de las listas de un usuario.
function create_DOM_lista(peliculas) {
    // Se recorre el array de películas y se añade una a una al DOM.
    peliculas.forEach(pelicula => {
        // Creamos los elementos de la película en variables.
        let pelicula_container = jQuery("<div>").addClass("pelicula");
        let input_hidden_id_pelicula = jQuery("<input>").attr({
            type: "hidden",
            name: "id_pelicula",
            class: "id_pelicula",
            value: pelicula.id
        });
        let poster_container = jQuery("<div>").addClass("poster");
        let titulo_p = jQuery("<p>").addClass("titulo").text(pelicula.titulo);
        let valoracion_container = jQuery("<div>").addClass("valoracion_container");
        let valoracion_p = jQuery("<p>").addClass("valoracion").text((pelicula.valoracion).toFixed(1));
        valoracion_container.append(valoracion_p);
        poster_container.append(valoracion_container);
        let boton_eliminar = jQuery("<div>").addClass("eliminar_button").text("Eliminar");

        // Agregamos los elementos creados con sus datos al div de la película.
        pelicula_container.append(input_hidden_id_pelicula, poster_container, titulo_p, boton_eliminar);

        // Agregamos el div película al contenedor principal películas.
        jQuery("#peliculas").append(pelicula_container);

        // Agregamos el color de fondo según la valoración.
        if (pelicula.valoracion > 0 && pelicula.valoracion <= 4) {
            valoracion_container.css("background", "linear-gradient(90deg, rgba(207, 37, 9, 1) 0%, rgba(230, 133, 50, 1) 100%)");
        } else if (pelicula.valoracion > 4 && pelicula.valoracion <= 7) {
            valoracion_container.css("background", "linear-gradient(90deg, rgba(219, 206, 0, 1) 0%, rgba(255, 188, 0, 1) 100%)");
        } else if (pelicula.valoracion > 7 && pelicula.valoracion <= 10) {
            valoracion_container.css("background", "linear-gradient(90deg, rgba(144, 219, 0, 1) 0%, rgba(0, 207, 107, 1) 100%)");
        }

        // Evento para abrir el modal de eliminar película
        boton_eliminar.on("click", function(event) {
            // Evitamos que se use el evento click de .pelicula
            event.stopPropagation();

            let id_pelicula = jQuery(this).siblings(".id_pelicula").val();
            jQuery("#eliminar_id_modal").val(id_pelicula);

            mostrar_modal("¿Seguro que quieres eliminar la película?");
        });
    });
}

// Función para eliminar una película de la lista
function eliminar_pelicula(id_lista, id_pelicula) {
    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_lista: id_lista,
            id_pelicula: id_pelicula,
            key: "delete_pelicula_lista"
        },
        success: function (data) {
            let resultado = JSON.parse(data);

            // Si se ha eliminado correctamente se elimina el div del DOM y se oculta el modal, para hacerlo dinámico.
            if (resultado == "OK") {
                jQuery(`.pelicula:has(input.id_pelicula[value='${id_pelicula}'])`).remove();
                jQuery("#contenedor_modal").hide();
            } else {
                mostrar_modal(resultado);
            }
        },
        error: function (xhr, status, error) {
            console.error("Ha ocurrido un error: " + error);
        }
    });
}

// Función para mostrar el modal con el mensaje determinado.
function mostrar_modal(mensaje) {
    jQuery("#mensaje_modal").text(mensaje);
    jQuery("#contenedor_modal").css("display", "block");
    jQuery(".listas_modal").hide();
}
