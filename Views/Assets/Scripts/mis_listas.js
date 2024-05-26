function iniciar_listeners() {
    jQuery(document).ready(function() {
        var contenedor_modal = jQuery("#contenedor_modal");
        var modal = jQuery("#modal");
        
        // Se cargan las listas del usuario.
        cargar_listas();

        // Listener para crear una nueva lista mediante AJAX.
        jQuery("#crear_lista_modal").on("click", function() {
            crear_lista();
        });

        // Evento para abrir el modal con el objetivo de crear una lista.
        jQuery("#nueva_lista_button").on("click", function() {
            mostrar_modal("Asigna un nombre para la nueva lista");
            jQuery("#crear_lista_modal").show();
            jQuery(".nuevo_nombre_lista").show();
        });

        // Listener para editar el nombre de una lista.
        jQuery("#editar_lista_modal").on("click", function() {
            let id_lista = jQuery(this).siblings(".id_lista_modal").val();
            editar_lista(id_lista);
        });

        // Listener para eliminar una lista
        jQuery("#eliminar_lista_modal").on("click", function() {
            let id_lista = jQuery(this).siblings(".id_lista_modal").val();
            eliminar_lista(id_lista);
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

        // Listener para que, al pulsar el botón vuelve atrás hasta la página anterior. 
        jQuery("#atras").on("click", function () {
            window.location.href = "../index.php";
        });
    });
}

// Crea el DOM de las listas de un usuario.
function create_DOM_listas(listas) {
    listas.forEach(lista => {
        // Obtenemos los datos de la lista.
        let id = lista["id"];
        let nombre = lista["nombre"];
        let fecha = lista["fecha"] != "" ? lista["fecha"].split("-")[2] + "/" + lista["fecha"].split("-")[1] + "/" + lista["fecha"].split("-")[0] : "No disponible";

        // Creamos los elementos por separado para el lista.
        let nueva_lista = jQuery("<tr>").addClass("lista");

        let id_lista = jQuery("<input>").attr({
            type: "hidden",
            name: "id_lista",
            class: "id_lista",
            value: id
        });

        let columna_nombre = jQuery("<td class='primer_td'>").text(nombre);
        let columna_fecha = jQuery("<td>").text(fecha);
        let columna_ver = jQuery("<td>").append(`<button class="btn btn_lista ver_button">Ver</button>`);         
        let columna_editar = jQuery("<td>");
        let columna_eliminar = jQuery("<td>");

        // Si es la lista de favoritos no se podrá editar ni borrar.
        if (nombre != "Favoritos") {
            columna_editar.append(`<button class="btn btn_lista editar_button">Editar</button>`);
            columna_eliminar.append(`<button class="btn btn_lista eliminar_button">Eliminar</button>`);
        }

        // Agregamos los elementos a la tabla de listas.
        nueva_lista.append(id_lista, columna_nombre, columna_fecha, columna_ver, columna_editar, columna_eliminar);

        // Se agrega el div del lista al contenedor de actores.
        jQuery("#tabla_listas tbody").append(nueva_lista);
    });

    // Después de agregar los elementos le asignamos el evento click para ver su información, editar y borrar.
    jQuery(".ver_button").on("click", function () {
        let id_lista = jQuery(this).closest("tr").find(".id_lista").val();
        let nombre = jQuery(this).closest("tr").find(".primer_td").text();
        window.location = `lista.php?id=${id_lista}&nombre=${nombre}`;
    });

    // Se le pasa el id de lista al modal para poder hacer la petición ajax y se muestra el modal con un input para el nombre y el botón de editar.
    jQuery(".editar_button").on("click", function () {
        // Asignamos el id de la lista a un input hidden dentro del modal.
        let id_lista = jQuery(this).closest("tr").find(".id_lista").val();
        jQuery(".id_lista_modal").val(id_lista);

        mostrar_modal("Elige un nuevo nombre para la lista");
        jQuery("#editar_lista_modal").show();
        jQuery(".nuevo_nombre_lista").show();
    });

    // Se le pasa el id de lista al modal para poder hacer la petición ajax y se muestra el modal con el botón de eliminar.
    jQuery(".eliminar_button").on("click", function () {
        // Asignamos el id de la lista a un input hidden dentro del modal.
        let id_lista = jQuery(this).closest("tr").find(".id_lista").val();
        jQuery(".id_lista_modal").val(id_lista);

        mostrar_modal("¿Estás seguro de que quieres eliminar esta lista?");
        jQuery("#eliminar_lista_modal").show();
    });
}

// Función para cargar las listas del usuario.
function cargar_listas() {
    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_usuario: jQuery("#id_usuario").val(),
            key: "get_listas_usuario"
        },
        success: function (data) {
            if (JSON.parse(data) != "false") {
                let listas = JSON.parse(data);
                create_DOM_listas(listas);
            } else {
                jQuery("#eliminar_lista_modal").hide();
                jQuery("#editar_lista_modal").hide();
                mostrar_modal("No se han encontrado listas creadas");
            }                
        },
        error: function (xhr, status, error) {
            console.error("Ha ocurrido un error: " . error);
        }
    });
}

// Función para crear una lista.
function crear_lista() {
    let id_usuario = jQuery("#id_usuario").val();
    let nombre = jQuery(".nuevo_nombre_lista").val();

    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_usuario: id_usuario, 
            nombre: nombre,
            key: "create_lista"
        },
        success: function (data) {
            let resultado = JSON.parse(data);

            if (resultado == "OK") {
                window.location.reload();
            } else {
                mostrar_modal(resultado);
            }                
        },
        error: function (xhr, status, error) {
            console.error("Ha ocurrido un error: " . error);
        }
    });
}

// Función para editar el nombre de una lista.
function editar_lista(id_lista) {
    let nombre = jQuery(".nuevo_nombre_lista").val();

    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_lista: id_lista,
            nombre: nombre,
            key: "edit_lista"
        },
        success: function (data) {
            let resultado = JSON.parse(data);

            if (resultado == "OK") {
                window.location.reload();
            } else {
                mostrar_modal(resultado);
            }                
        },
        error: function (xhr, status, error) {
            console.error("Ha ocurrido un error: " . error);
        }
    });
}

// Función para eliminar una lista.
function eliminar_lista(id_lista) {
    jQuery.ajax({
        url: '../Controllers/lista_controller.php',
        method: 'POST',
        data: {
            id_lista: id_lista,
            key: "delete_lista"
        },
        success: function (data) {
            let resultado = JSON.parse(data);

            if (resultado == "OK") {
                window.location.reload();
            } else {
                mostrar_modal(resultado);
            }                
        },
        error: function (xhr, status, error) {
            console.error("Ha ocurrido un error: " . error);
        }
    });
}

// Función para mostrar el modal con el mensaje determinado.
function mostrar_modal(mensaje) {
    jQuery("#mensaje_modal").text(mensaje);
    jQuery("#contenedor_modal").css("display", "flex");

    jQuery("#eliminar_lista_modal").hide();
    jQuery("#crear_lista_modal").hide();
    jQuery("#editar_lista_modal").hide();
    jQuery(".nuevo_nombre_lista").hide();
}
