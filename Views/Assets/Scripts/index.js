// Hace una petición al controller de películas para obtener los id, títulos y pósters mediante la key para identificar la petición en el back-end
function get_peliculas() {
    jQuery.ajax({
        url: 'Controllers/pelicula_controller.php',
        method: 'POST',
        data: {
            key: "get_movies_preview"
        },
        success: function (data) {
            // Una vez se obtienen los datos se parsean
            let peliculas = JSON.parse(data);

            // Se recorre el array de películas y por cada una se añade al DOM
            for (let i = 0; i < peliculas.length; i++) {
                create_dinamic_DOM_index(peliculas[i]);
            }

            // Se añaden los pósters de cada película
            asignar_imagenes_peliculas(peliculas);
        }
    });
}

// Crea una estructura para cada película que se añade al div principal con id "peliculas"
function create_dinamic_DOM_index(pelicula) {
    jQuery("#peliculas").append(`<div class="pelicula">
                                    <input type="hidden" name="id_pelicula" value="${pelicula.id}"/>
                                    <div class="poster"></div>
                                    <p class="titulo">${pelicula.titulo}</p>
                                </div>`);
}

// Por cada div con clase "poster" se asigna su poster correspondiente
function asignar_imagenes_peliculas(peliculas) {
    jQuery(".poster").each(function(i) {
        jQuery(this).css("background-image", `url(${peliculas[i].poster})`);
    });
}

// Inicia los listeners para el index.html
function inicia_listeners() {
    // Listener que, cuando carga el documento se aplica a todos los div con clase "pelicula"
    jQuery(document).on("click", ".pelicula", function() {
        // Recoge el id del input hidden y el título.
        let id_pelicula = jQuery(this).find("input").val();
        let titulo = jQuery(this).find("p").text();
    
        // Redirige a la página de detalles de película con el id y título en la URL
        window.location = `Views/pelicula.php?id=${id_pelicula}&titulo=${titulo}`;
    });
}
