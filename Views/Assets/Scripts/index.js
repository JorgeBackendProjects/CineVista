var pagina_actual = 1;

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

            // Vacía el contenedor de películas para añadirlas según la paginación.
            jQuery("#peliculas").empty();

            // Se recorre el array de películas y se añade una a una al DOM.
            for (let i = 0; i < peliculas.length; i++) {
                create_dinamic_DOM_index(peliculas[i]);
            }

            // Se añaden los pósters de cada película.
            asignar_imagenes_peliculas(peliculas);

            // Se inserta la paginación.
            set_paginacion(total_paginas, pagina);
        }
    });
}

// Crea una estructura para cada película que se añade al div principal con id "peliculas".
function create_dinamic_DOM_index(pelicula) {
    jQuery("#peliculas").append(`<div class="pelicula">
                                    <input type="hidden" name="id_pelicula" class="id_pelicula" value="${pelicula.id}"/>
                                    <div class="poster">
                                        <div class="valoracion_container">
                                            <p class="valoracion">${(pelicula.valoracion).toFixed(1)}</p>
                                        </div>
                                    </div>
                                    <p class="titulo">${pelicula.titulo}</p>
                                </div>`);

    // Obtenemos el div con clase "valoracion_container" de la película actual y agregamos el color de fondo según su puntuación
    let valoracionContainer = jQuery(".pelicula:last").find(".valoracion_container");
    if (pelicula.valoracion > 0 && pelicula.valoracion <= 4) {
        valoracionContainer.css("background", "linear-gradient(90deg, rgba(207, 37, 9, 1) 0%, rgba(230, 133, 50, 1) 100%)");
    } else if (pelicula.valoracion > 4 && pelicula.valoracion <= 7) {
        valoracionContainer.css("background", "linear-gradient(90deg, rgba(219, 206, 0, 1) 0%, rgba(255, 188, 0, 1) 100%)");
    }  else if (pelicula.valoracion > 7 && pelicula.valoracion <= 10) {
        valoracionContainer.css("background", "linear-gradient(90deg, rgba(144, 219, 0, 1) 0%, rgba(0, 207, 107, 1) 100%)");
    }
}

// Por cada div con clase "poster" se asigna su poster correspondiente.
function asignar_imagenes_peliculas(peliculas) {
    jQuery(".poster").each(function(i) {
        jQuery(this).css("background-image", `url(${peliculas[i].poster})`);
    });
}

// Actualiza el número dinámico de páginas y añade una clase al botón que corresponde a la página actual.
function set_paginacion(total_paginas, pagina_actual) {
    // Vacía el contenedor de paginación.
    jQuery("#paginacion").empty();

    // Calcula el rango de botones a mostrar, siempre debe haber mínimo 10 botones.
    let inicio = Math.max(1, Math.min(pagina_actual - 4, total_paginas - 9));
    let fin = Math.min(total_paginas, inicio + 9);

    // Agregamos el botón con clase "anterior" cuando no estamos en la primera página.
    if (pagina_actual > 1) {
        jQuery("#paginacion").append(`<button id="anterior" class="pagina anterior">Anterior</button>`);
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

    // Agrega el botón con clase "siguiente" cuando no estamos en la última página.
    if (pagina_actual < total_paginas) {
        jQuery("#paginacion").append(`<button id="siguiente" class="pagina siguiente">Siguiente</button>`);
    }

    // Se añade el número total de páginas al div de paginación.
    jQuery("#numero_paginas").text(`Total: ${total_paginas} páginas`);
}

// Inicia los listeners para el index.html
function inicia_listeners() {
    // Cuando el documento está listo, se hace una llamada para obtener las primeras 20 películas.
    jQuery(document).ready(function() {
        get_peliculas(1); 
    });

    // Listener onclick que, cuando carga el documento se aplica a todos los div con clase "pelicula"
    jQuery(document).on("click", ".pelicula", function() {
        // Recoge el id del input hidden y el título.
        let id_pelicula = jQuery(this).find(".id_pelicula").val();
        let titulo = jQuery(this).find(".titulo").text();
    
        // Redirige a la página de detalles de película con el id y título en la URL
        window.location = `Views/pelicula.php?id=${id_pelicula}&titulo=${titulo}`;
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
    });
}