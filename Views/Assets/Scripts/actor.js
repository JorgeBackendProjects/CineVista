// Esta función es la que usa todas las demás, tanto para crear el DOM como para inicializar los listener cuando el documento esté cargado y listo.
function create_DOM() {
    // Obtengo el id del input hidden.
    let id_actor = jQuery("#id_actor").val();

    // Se carga la información del actor.
    cargar_actor(id_actor);

    // Listener para que, al pulsar el botón redirige a la película donde nos encontrábamos. 
    jQuery("#atras").on("click", function () {
        let pelicula_url = jQuery("#pelicula_url").val();
        window.location = pelicula_url || "../index.php";
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
                // Mostrar modal.
            }
        });
    });
}

// Función que hace una llamada a actor_controller.php para obtener la información del actor. Se envía la key para saber la acción y el id_actor.
function cargar_actor(id_actor) {
    jQuery.ajax({
        url: '../Controllers/actor_controller.php',
        method: 'POST',
        data: {
            id_actor: id_actor,
            key: "get_actor"
        },
        success: function (data) {
            // Obtengo el actor.
            let actor = JSON.parse(data).actor;

            // Se cargan los datos en el DOM.
            create_DOM_actor(actor);
        }
    });
}

// Función que obtiene todos los datos del y los añade al DOM.
function create_DOM_actor(actor) {
    // Se añade la imagen al div.
    jQuery("#imagen").css("background-image", `url(${actor["imagen"]})`);
    
    let fecha_nacimiento = actor["birthday"] != "" ? (actor["birthday"].split("-")[2] + "/" + actor["birthday"].split("-")[1] + "/" + actor["birthday"].split("-")[0]) : "No disponible";
    
    let fecha_muerte = "";
    if (actor["deathday"].includes("-")) {
        fecha_muerte = (actor["deathday"].split("-")[2] + "/" + actor["deathday"].split("-")[1] + "/" + actor["deathday"].split("-")[0]);
    } else {
        fecha_muerte = "Actualidad";
    }

    // Se añaden los textos a los h3.
    jQuery("#biografia").text("Biografía: ").append(`<span> ${actor["biografia"]}</span>`);
    jQuery("#birthday").text("Fecha de nacimiento: ").append(`<span> ${fecha_nacimiento}</span>`);
    jQuery("#deathday").text("Fecha de defunción: ").append(`<span> ${fecha_muerte}</span>`);
    jQuery("#genero").text(`Género: `).append(`<span>${actor["genero"]}</span>`);
    jQuery("#lugar_nacimiento").text(`Lugar de nacimiento: `).append(`<span> ${actor["lugar_nacimiento"]}</span>`);
}
