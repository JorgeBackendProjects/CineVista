// Esta función es la que usa todas las demás, tanto para crear el DOM como para inicializar los listener cuando el documento esté cargado y listo.
function inicializar_listeners() {
    let id_usuario = jQuery("#comp_sesion").val();
    let id_pelicula = jQuery("#id_pelicula").val();
    var contenedor_modal = jQuery("#contenedor_modal");
    var modal = jQuery("#modal");

    // Se carga la película en el DOM.
    cargar_pelicula(id_pelicula);

    // Una vez se cargue la película y el documento esté listo se obtienen y cargan los actores.
    jQuery(document).ready(function () {
        cargar_actores(id_pelicula);

        // Inicializa los eventos click de los botones para el scroll de los botones
        scroll_actores();

        // Condición para cargar las listas del usuario en el modal.
        if (id_usuario > 0) {
            cargar_listas(id_usuario);
        }

        // Eventos click para cerrar el modal tanto en la cruz como fuera del modal.
        jQuery("#cerrar_modal").on("click", function() {
            contenedor_modal.css("display", "none");
        });

        jQuery(window).on("click", function(event) {
            if (event.target == contenedor_modal[0]) {
                contenedor_modal.css("display", "none");
            }
        });

        // Evento click Añadir a lista que abre el modal mostrando las listas del usuario.
        jQuery("#aniadir_a_lista").on("click", function() {
            // Si la sesión no está iniciada se muestra un modal, en caso contrario FALTA SELECCION DE LISTAS.
            if (id_usuario == 0) {
                mostrar_modal("Para guardar películas en listas debes iniciar sesión.");
            } else {
                mostrar_modal("Selecciona una lista para guardar la película.");
                jQuery(".listas_modal").show();
            }
        });

        // Evento click para añadir película a Favoritos. 
        jQuery("#aniadir_a_favoritos").on("click", function() {
            // Si la sesión no está iniciada se muestra un modal, en caso contrario FALTA SELECCION DE LISTAS.
            if (id_usuario == 0) {
                mostrar_modal("Para guardar películas en listas debes iniciar sesión.");
            } else {
                let id_favoritos = jQuery("#id_favoritos").val();

                // Obtenemos la lista favoritos para quitarle o añadirle el check.
                let lista_favoritos = jQuery(".listas_modal .lista").filter(function() {
                    return jQuery(this).find(".nombre_lista").text() == "Favoritos";
                });

                // Si la película no está en favoritos, se añade. En caso contrario se elimina. Se intercambian los iconos. 
                if (jQuery(this).find("i.fa-regular").length > 0) {
                    guardar_en_lista(id_favoritos);
                    jQuery(this).find("i.fa-regular").removeClass("fa-regular").addClass("fa-solid");
                    lista_favoritos.append("<i class='fa-solid fa-check'></i>");
                } else {
                    eliminar_de_lista(id_favoritos);
                    jQuery(this).find("i.fa-solid").removeClass("fa-solid").addClass("fa-regular");
                    lista_favoritos.find("i.fa-check").remove();
                }
            }
        });

        // Listener para que, al pulsar el botón vuelve atrás hasta la última coordenada clickada en el index. 
        jQuery("#atras").on("click", function () {
            let pagina_actual = jQuery("#pagina_actual").val();
            let busqueda = jQuery("#busqueda_actual").val();
            let id_lista = jQuery("#id_lista").val();
            let nombre_lista = jQuery("#nombre_lista").val();

            // Redirige a lista.php o al index.
            if (id_lista > 0) {
                console.log(id_lista + " : " + nombre_lista);
                window.location.href = `lista.php?id=${id_lista}&nombre=${nombre_lista}`;
            } else {
                window.location.href = `../index.php?pagina=${pagina_actual}&busqueda=${busqueda}`;
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
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al cerrar sesión: " + error);
                }
            });
        });
    });
}

// Función que hace una llamada a pelicula_controller.php para obtener la información de la película. Se envía la key para saber la acción y el id_pelicula.
function cargar_pelicula(id_pelicula) {
    jQuery.ajax({
        url: '../Controllers/pelicula_controller.php',
        method: 'POST',
        data: {
            id_pelicula: id_pelicula,
            key: "get_movie"
        },
        success: function (data) {
            // Obtengo el objeto película
            let pelicula = JSON.parse(data).pelicula;

            // Se carga la película en el DOM.
            create_DOM_pelicula(pelicula);
        },
        error: function(xhr, status, error) {
            // En caso de error, se agrega un mensaje al contenedor principal y se oculta el resto de elementos.
            jQuery("#principal").append("<h2>No se han podido cargar las películas. Vuelve a intentarlo más tarde.</h2>");

            jQuery("#pelicula").hide();
            jQuery("#secundario").hide();
            jQuery("#pantalla_carga").hide();
        }
    });
}

// Función que obtiene todos los datos de la película y los setea correctamente para añadirlos al DOM.
function create_DOM_pelicula(pelicula) {
    // Obtenemos los nombres de los géneros en un string separado por ", " desde una estructura Set para omitir los repetidos, si los hay. 
    let generos = pelicula["generos"].length > 0 ? [...new Set(pelicula["generos"].map(genero => genero.nombre))].join(", ") : "No disponible";
    // Obtenemos la duración en horas y minutos.
    let duracion = pelicula["duracion"] > 0 ? Math.floor(pelicula["duracion"] / 60) + "h y " + pelicula["duracion"] % 60 + " minutos." : "No disponible";
    // Obtenemos la fecha con el formato español.
    let fecha = pelicula["fecha_estreno"] != "" ? pelicula["fecha_estreno"].split("-")[2] + "/" + pelicula["fecha_estreno"].split("-")[1] + "/" + pelicula["fecha_estreno"].split("-")[0] : "No disponible";
    // Obtenemos el resto de los atributos si no están vacíos.
    let sinopsis = pelicula["sinopsis"] != "" ? pelicula["sinopsis"] : "No disponible";
    let presupuesto = pelicula["presupuesto"] > 0 ? pelicula["presupuesto"].toLocaleString() + " $" : "No disponible";
    let ganancias = pelicula["ganancias"] > 0 ? pelicula["ganancias"].toLocaleString() + " $" : "No disponible";
    let popularidad = pelicula["popularidad"] > 0 ? pelicula["popularidad"] : "No disponible";

    if (pelicula["valoracion"] > 0 && pelicula["valoracion"] <= 4) {
        jQuery(".valoracion_container").css("background", "linear-gradient(90deg, rgba(207, 37, 9, 1) 0%, rgba(230, 133, 50, 1) 100%)");
    } else if (pelicula["valoracion"] > 4 && pelicula["valoracion"] <= 7) {
        jQuery(".valoracion_container").css("background", "linear-gradient(90deg, rgba(219, 206, 0, 1) 0%, rgba(255, 188, 0, 1) 100%)");
    } else if (pelicula["valoracion"] > 7 && pelicula["valoracion"] <= 10) {
        jQuery(".valoracion_container").css("background", "linear-gradient(90deg, rgba(144, 219, 0, 1) 0%, rgba(0, 207, 107, 1) 100%)");
    }

    // Se añaden las imágenes a los div y los textos a los h3.
    jQuery("#poster").css("background-image", `url(${pelicula["poster"]})`);
    jQuery("#fondo").css("background-image", `url(${pelicula["fondo"]})`);
    // La función toFixed obtiene por parámetro el número de decimales que tendrá el float.
    jQuery("#valoracion").text(`${pelicula["valoracion"].toFixed(1)}`);
    jQuery("#titulo").text(`${pelicula["titulo"]}`);
    jQuery("#generos").text(`Géneros: `).append(`<span>${generos}</span>`);
    jQuery("#sinopsis").text(`Sinopsis: `).append(`<span>${sinopsis}</span>`);
    jQuery("#fecha").text(`Fecha: `).append(`<span>${fecha}</span>`);
    jQuery("#duracion").text(`Duración: `).append(`<span>${duracion}</span>`);
    jQuery("#presupuesto").text(`Presupuesto: `).append(`<span>${presupuesto}</span>`);
    jQuery("#ganancias").text(`Ganancias: `).append(`<span>${ganancias}</span>`);
    jQuery("#popularidad").text(`Popularidad: `).append(`<span>${popularidad}</span>`);
    // Si se obtiene la url de la web se añade, si no se escribe "No disponible".
    pelicula["web"] != "" ? jQuery("#web").text(`Web: `).append(`<a href='${pelicula["web"]}' target='blank'>${pelicula["web"]}</a>`) : jQuery("#web").text("Web: ").append(`<span>No disponible</span>`);
    jQuery("#total_votos").text(`Votaciones: `).append(`<span>${pelicula["total_votos"]}</span>`);
}

// Función que hace una llamada a actor_controller.php para obtener un array con los actores de la película. Se envía la key para saber la acción y el id_pelicula.
function cargar_actores(id_pelicula) {
    jQuery.ajax({
        url: '../Controllers/actor_controller.php',
        method: 'POST',
        data: {
            id_pelicula: id_pelicula,
            key: "get_actores"
        },
        success: function (data) {
            // Obtengo el array de actores.
            let actores = JSON.parse(data).actores;

            // Se muestra el h1 y se oculta la pantalla de carga.
            jQuery(".secundario h1").show();
            jQuery("#pantalla_carga").hide();

            // Se cargan los datos en el DOM.
            create_DOM_actores(actores);
        },
        error: function(xhr, status, error) {
            // En caso de error, se agrega un mensaje al contenedor principal y se oculta el resto de elementos.
            jQuery("#principal").append("<h2>No se han podido cargar las películas. Vuelve a intentarlo más tarde.</h2>");

            jQuery("#pelicula").hide();
            jQuery("#secundario").hide();
            jQuery("#pantalla_carga").hide();
        }
    });
}

// Función que obtiene todos los actores en un array y los recorre, generando una estructura para cada uno y añadiendo sus correspondientes datos y evento onclick.
function create_DOM_actores(actores) {
    actores.forEach(actor => {
        // Creamos los elementos por separado para el actor.
        let actor_container = jQuery("<div>").addClass("actor");
        let input_hidden_id_actor = jQuery("<input>").attr({
            type: "hidden",
            name: "id_actor",
            class: "id_actor",
            value: actor["id"]
        });
        let imagen_actor_container = jQuery("<div>").addClass("imagen_actor");
        let info_actor_container = jQuery("<div>").addClass("info_actor");
        let nombre_p = jQuery("<p>").addClass("nombre").text(actor["nombre"]);
        let personaje_p = jQuery("<p>").addClass("personaje").text(`Papel: ${actor["personaje"] != "" ? actor["personaje"] : "No disponible"}`);

        // Se agrega la imagen al div de imagen_actor. Si no la encuentra, muestra una por defecto.
        let imagen = actor["imagen"].length > 0 ? actor["imagen"] : "Assets/Images/estrella_cine.webp";
        imagen_actor_container.css("background-image", `url('${imagen}')`);

        // Agregamos los elementos al div del actor.
        info_actor_container.append(nombre_p, personaje_p);
        actor_container.append(input_hidden_id_actor, imagen_actor_container, info_actor_container);

        // Se agrega el div del actor al contenedor de actores.
        jQuery("#actores").append(actor_container);
    });

    // Después de agregar los elementos le asignamos el evento click para ver su información detallada en actor.php.
    jQuery(".actor").on("click", function() {
        let id_actor = jQuery(this).find(".id_actor").val();
        let nombre = jQuery(this).find(".nombre").text();
        let pelicula_url = window.location.href;
        window.location = `actor.php?id=${id_actor}&nombre=${nombre}&pelicula_url=${encodeURIComponent(pelicula_url)}`;
    });

    // Se cambia el display del div de los botones para scrollear.
    jQuery(".botones_carousel").css("display", "flex");
}

// Función para hacer scrollLeft y scrollRight con el contenido del contenedor de actores.
function scroll_actores() { 
    let intervalo;
    let velocidad = 3;

    // Al mantener presionado el puntero sobre el botón anterior se avanza mediante scrollLeft con un intervalo. Al soltarlo se detiene el intervalo.
    jQuery('#btn_anterior').on("mousedown", function() {
        intervalo = setInterval(function() {
            let posicion_actual = jQuery('.actores').scrollLeft();

            if (posicion_actual > 0) {
                jQuery('.actores').scrollLeft(posicion_actual - velocidad);
            }
        }, 5);
    }).on("mouseup mouseleave", function() {
        clearInterval(intervalo);
    });

    // Al mantener presionado el botón siguiente se avanza mediante scrollLeft con un intervalo. Al soltarlo se detiene el intervalo.
    jQuery('#btn_siguiente').on("mousedown", function() {
        intervalo = setInterval(function() {
            let posicion_actual = jQuery('.actores').scrollLeft();

            jQuery('.actores').scrollLeft(posicion_actual + velocidad);
        }, 5);
    }).on("mouseup mouseleave", function() {
        clearInterval(intervalo);
    });
}

// Función para cargar las listas del usuario.
function cargar_listas(id_usuario) {
    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_usuario: id_usuario,
            key: "get_listas_usuario"
        },
        success: function (data) {
            let listas = JSON.parse(data);

            // Se cargan las listas en el modal.
            create_DOM_listas(listas);
        },
        error: function(xhr, status, error) {
            console.error("Ha ocurrido un error: " + error);
        }
    });
}

// Función para crear botones con los nombres e id de las listas en el modal.
function create_DOM_listas(listas) {
    let listas_container = jQuery("<div>").addClass("listas_modal");

    listas.forEach(lista => {
        // Obtenemos los datos de la lista.
        let id = lista["id"];
        let nombre = lista["nombre"];

        // Creamos los elementos por separado para el lista.
        let nueva_lista = jQuery("<div>").addClass("lista");

        let id_lista = jQuery("<input>").attr({
            type: "hidden",
            name: "id_lista",
            class: "id_lista",
            value: id
        });

        let nombre_lista_p = jQuery("<p>").addClass("nombre_lista").text(nombre);

        // Si la película ya está en esa lista se añade un icono check.
        comprobar_pelicula_en_lista(id).then(en_lista => {
            if (en_lista) {
                nueva_lista.append(id_lista, nombre_lista_p, "<i class='fa-solid fa-check'></i>");

                // Si la lista es favoritos, se intercambia el icono del corazón.
                if (nombre == "Favoritos") {
                    jQuery("#aniadir_a_favoritos i").removeClass("fa-regular").addClass("fa-solid");
                } 
            } else {
                nueva_lista.append(id_lista, nombre_lista_p);
            }
        }).catch(error => {
            console.error("Error comprobando si la película está en la lista: " + error);
        });

        // Se agrega el div de lista al contenedor de listas.
        jQuery(listas_container).append(nueva_lista);

        // Si la lista actual es favoritos, se guarda su id en un input hidden.
        if (nombre == "Favoritos") {
            jQuery("#id_favoritos").val(id);
        }

        // Evento para añadir/elimnar película a/de lista.
        jQuery(nueva_lista).on("click", function() {
            let id_lista = jQuery(this).find(".id_lista").val();
            let nombre_lista = jQuery(this).find(".nombre_lista").text();
            let icono_check = jQuery(this).find("i.fa-check");

            // Si la película ya está en una lista se elimina de la lista. En caso contrario se añade. Se intercambian los iconos.
            if (icono_check.length > 0) { 
                eliminar_de_lista(id_lista);
                jQuery(this).find("i.fa-check").remove();

                if (nombre_lista == "Favoritos") {
                    jQuery("#aniadir_a_favoritos i").removeClass("fa-solid").addClass("fa-regular");
                }
            } else {
                guardar_en_lista(id_lista);
                jQuery(this).append("<i class='fa-solid fa-check'></i>");

                if (nombre_lista == "Favoritos") {
                    jQuery("#aniadir_a_favoritos i").removeClass("fa-regular").addClass("fa-solid");
                }
            }
        });
    });

    // Se agrega el div contenedor de listas al modal.
    jQuery(".columna_modal").append(listas_container);
}

// Función que comprueba si una película se encuentra en una lista.
function comprobar_pelicula_en_lista(id_lista) {
    let id_pelicula = jQuery("#id_pelicula").val();

    return new Promise((resolve, reject) => {
        jQuery.ajax({
            url: '../Controllers/lista_controller.php',
            method: 'POST',
            data: {
                id_pelicula: id_pelicula,
                id_lista: id_lista,
                key: "comprobar_pelicula_lista"
            },
            success: function (data) {
                let resultado = JSON.parse(data);

                if (resultado == "true") {
                    resolve(true);
                } else {
                    resolve(false);
                }
            },
            error: function(xhr, status, error) {
                console.error("Ha ocurrido un error: " + error);
                reject(error);
            }
        });
    });
}

// Añade una película a una lista.
function guardar_en_lista(id_lista) {
    let id_pelicula = jQuery("#id_pelicula").val();

    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_pelicula: id_pelicula,
            id_lista: id_lista,
            key: "add_pelicula_lista"
        },
        success: function (data) {
            let resultado = JSON.parse(data);

            if (resultado != "OK") {
                mostrar_modal(resultado);
            }
        },
        error: function(xhr, status, error) {
            console.error("Ha ocurrido un error: " + error);
        }
    });
}

// Elimina una pelicula de una lista.
function eliminar_de_lista(id_lista) {
    let id_pelicula = jQuery("#id_pelicula").val();

    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_pelicula: id_pelicula,
            id_lista: id_lista,
            key: "delete_pelicula_lista"
        },
        success: function (data) {
            let resultado = JSON.parse(data);

            if (resultado != "OK") {
                mostrar_modal(resultado);
            }
        },
        error: function(xhr, status, error) {
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
