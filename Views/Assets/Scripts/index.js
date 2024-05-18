// Hace una petición al controller de películas para obtener los id, títulos y pósters mediante la key para identificar la petición en el back-end
function get_peliculas(pagina) {
    jQuery.ajax({
        url: 'Controllers/pelicula_controller.php',
        method: 'POST',
        data: {
            key: "get_movies_preview",
            pagina: pagina
        },
        success: function (data) {
            // Una vez se obtienen los datos se parsean
            let resultado = JSON.parse(data);
            let peliculas = resultado.peliculas;
            let total_paginas = resultado.total_paginas;
            let total_peliculas = resultado.total_peliculas;

            // Se recorre el array de películas y se añade una a una al DOM.
            create_dinamic_DOM_index(peliculas);

            // Se añaden los pósters de cada película.
            asignar_imagenes_peliculas(peliculas);

            // Se inserta la paginación.
            set_paginacion(total_paginas, pagina, total_peliculas);
        },
        error: function(xhr, status, error) {
            // En caso de error, se agrega un mensaje al contenedor de películas.
            jQuery("#peliculas").empty().append("<h2>No se han podido cargar las películas. Vuelve a intentarlo más tarde.</h2>");
        }
    });
}

// Hace una petición al controller de películas para obtener las películas que coincidan en título.
function buscar_peliculas() {
    let busqueda = jQuery("#buscador").val();

    jQuery.ajax({
        url: 'Controllers/pelicula_controller.php',
        method: 'POST',
        data: {
            key: "buscar_peliculas",
            busqueda: busqueda
        },
        success: function(data) {
            // Una vez se obtienen los datos se parsean
            let resultado = JSON.parse(data);
            let peliculas = resultado.peliculas;
            let total_peliculas = resultado.total_peliculas == 0 ? "Sin" : resultado.total_peliculas;

            // Se recorre el array de películas y se añade una a una al DOM.
            create_dinamic_DOM_index(peliculas);

            // Se añaden los pósters de cada película.
            asignar_imagenes_peliculas(peliculas);

            // Ocultamos la paginación y los textos de la cabecera y el total de páginas.
            jQuery("#paginacion").hide();
            jQuery("#titulo_main").hide();
            jQuery("#numero_pagina_text").hide();
            jQuery("#numero_paginas").hide();

            // Eliminamos el texto de resultado de búsqueda existente, si lo hay.
            jQuery("#resultado_busqueda_text").remove();
            jQuery("#num_peliculas_busqueda_text").remove();

            // Añadimos el texto que indica que nos encontramos ante una búsqueda.
            let resultado_busqueda_text = jQuery("<h2>").attr("id", "resultado_busqueda_text").text("Resultados de la búsqueda");
            let num_peliculas_busqueda_text = jQuery("<h2>").attr("id", "num_peliculas_busqueda_text").text(`${total_peliculas} resultados`);
            jQuery("#texto_principal_container").append(resultado_busqueda_text, num_peliculas_busqueda_text);
        },
        error: function(xhr, status, error) {
            // En caso de error, se agrega un mensaje al contenedor de películas.
            jQuery("#peliculas").empty().append("<h2>No se han podido buscar las películas. Vuelve a intentarlo más tarde.</h2>");
        }
    });
}

// Crea una estructura para cada película que se añade al div principal con id "peliculas".
function create_dinamic_DOM_index(peliculas) {
    // Vacía el contenedor de películas para añadirlas según la paginación.
    jQuery("#peliculas").empty();

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

        // Agregamos los elementos creados con sus datos al div de la película.
        pelicula_container.append(input_hidden_id_pelicula, poster_container, titulo_p);

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
    });
}

// Por cada div con clase "poster" se asigna su poster correspondiente.
function asignar_imagenes_peliculas(peliculas) {
    jQuery(".poster").each(function(i) {
        jQuery(this).css("background-image", `url(${peliculas[i].poster})`);
    });
}

// Actualiza el número dinámico de páginas y añade una clase al botón que corresponde a la página actual.
function set_paginacion(total_paginas, pagina_actual, total_peliculas) {
    // Se oculta el texto que indica que nos encontramos ante una búsqueda.
    jQuery("#resultado_busqueda_text").hide();
    jQuery("#num_peliculas_busqueda_text").hide();
    // Muestra el contenedor de paginación y lo vacía. 
    jQuery("#paginacion").show();
    jQuery("#paginacion").empty();
    // Se muestran los textos de la cabecera y número de páginas.
    jQuery("#titulo_main").show();
    jQuery("#numero_pagina_text").show();
    jQuery("#numero_paginas").show();

    // Calcula el rango de botones a mostrar, siempre debe haber mínimo 10 botones.
    let inicio = Math.max(1, Math.min(pagina_actual - 1, total_paginas - 6));
    let fin = Math.min(total_paginas, inicio + 6);

    // Agregamos el botón con clase "anterior" cuando no estamos en la primera página.
    if (pagina_actual > 1) {
        jQuery("#paginacion").append(`<button id="anterior" class="pagina anterior">Anterior</button>`);
    }

    // Agregamos el botón a la primera página siempre.
    if (inicio > 1) {
        jQuery("#paginacion").append(`<button class="pagina">1</button>`);
        if (inicio > 2) {
            jQuery("#paginacion").append(`<button class="pagina">...</button>`);
        }
    }

    // Se crean los botones de paginación para cada página dentro del rango.
    for (let i = inicio; i <= fin; i++) {
        let boton = jQuery(`<button class="pagina">${i}</button>`);
        
        // Al botón de la página que se está visualizando se le añade la clase "pagina_actual."
        if (i == pagina_actual) {
            boton.addClass("pagina_actual");
        }

        // Se añade cada botón al div de paginación.
        jQuery("#paginacion").append(boton);
    }

    // Agregamos el botón a la última página siempre.
    if (fin < total_paginas) {
        if (fin < total_paginas - 1) {
            jQuery("#paginacion").append(`<button class="pagina">...</button>`);
        }
        jQuery("#paginacion").append(`<button class="pagina">${total_paginas}</button>`);
    }

    // Agrega el botón con clase "siguiente" cuando no estamos en la última página.
    if (pagina_actual < total_paginas) {
        jQuery("#paginacion").append(`<button id="siguiente" class="pagina siguiente">Siguiente</button>`);
    }

    // Se añade el número total de películas y páginas al div de paginación.
    jQuery("#numero_paginas").text(`Total: ${total_peliculas} películas en ${total_paginas} páginas`);

    // Se añade la página actual al h2 de arriba.
    jQuery("#numero_pagina_text").text(`Página ${pagina_actual}`);
}

// Inicia los listeners para el index.php
function inicializar_DOM() {
    var pagina_actual = jQuery("#pagina_actual").val();

    // Cuando el documento está listo, se hace una llamada para obtener las primeras 20 películas.
    jQuery(document).ready(function() {
        get_peliculas(pagina_actual); 
    });

    jQuery(document).on("input", "#buscador", function(){
        // Obtenemos el valor que hay en el input.
        let busqueda = jQuery(this).val();

        // Si el input de búsqueda está vacío carga todas las películas de nuevo. En caso contrario hace otra busqueda por título. 
        if (busqueda.trim() == "") {
            get_peliculas(pagina_actual);
        } else {
            // Hacer una llamada al servidor para obtener las películas que coincidan con el título o la fecha
            buscar_peliculas();
        }
    });

    // Listener onclick que, cuando carga el documento se aplica a todos los div con clase "pelicula"
    jQuery(document).on("click", ".pelicula", function() {
        // Recoge el id del input hidden y el título.
        let id_pelicula = jQuery(this).find(".id_pelicula").val();
        let titulo = jQuery(this).find(".titulo").text();
    
        // Redirige a la página de detalles de película con el id y título en la URL
        window.location = `Views/pelicula.php?id=${id_pelicula}&titulo=${titulo}&pagina=${pagina_actual}`;
    });

    // Listener onclick que, al pulsar un botón de paginación obtiene el número de la página del texto del botón y vuelve a solicitar al servidor las películas de la página actual. 
    jQuery(document).on("click", ".pagina", function() {
        // Obtiene el número de página del botón
        let pagina = parseInt(jQuery(this).text());
    
        // Si el botón que se ha pulsado tiene la clase "anterior", resta 1 a la página actual.
        if (jQuery(this).hasClass("anterior")) {
            pagina_actual--;

        // Si el botón que se ha pulsado tiene la clase "siguiente", suma 1 a la página actual.
        } else if (jQuery(this).hasClass("siguiente")) {
            pagina_actual++;
        
        // Si no es "anterior" ni "siguiente", establece la página actual.
        } else {
            pagina_actual = pagina;
        }

        // Elimina todo el contenido del div y carga las películas de esta página.
        get_peliculas(pagina_actual);
        
        // Desplaza la página hacia el principio en una animación que dura 1 segundo.
        jQuery('html, body').animate({
            scrollTop: 0
        }, 1000);
    });

    // Prevenimos el comportamiento por defecto del elemento <a> para hacer una petición al controller de usuario que cierra la sesión y recargar la página.
    jQuery("#redirect_cerrar_sesion").on("click", function(event) {
        event.preventDefault();

        jQuery.ajax({
            url: 'Controllers/usuario_controller.php',
            method: 'POST',
            data: {
                key: "cerrar_sesion"
            },
            success: function(data) {
                let resultado = JSON.parse(data);
    
                if (resultado == "OK") {
                    window.location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cerrar sesión: " + error);
            }
        });
    });
}