<?php
$id_pelicula = isset($_GET["id"]) ? $_GET["id"] : null;
$titulo = isset($_GET["titulo"]) ? "Película: " . $_GET["titulo"] : "Película";

//session_start();
//$_SESSION["usuario"] = "ElPiezass";

//session_destroy();
//$_SESSION["usuario"] = null;

$sesion_iniciada = isset($_SESSION["usuario"]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Views/Assets/Images/icon.ico" sizes="64x64" type="image/png">
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <title><?php echo $titulo; ?></title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Inria Sans", sans-serif;
            font-size: 1.1rem;
            background-color: #021B30;
            color: white;
        }

        /*Cabecera*/
        header {
            position: sticky;
            width: 100%;
            top: 0;
            z-index: 1;
            background-color: #011727;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 5rem;
            padding: 10px 20px;
        }

        .header_left,
        .header_right {
            display: flex;
            align-items: center;
        }

        .header_left {
            margin-left: 30px;
        }

        .header_right {
            margin-right: 30px;
        }

        .header_left .icon {
            width: 3.5rem;
            height: 3rem;
            background-image: url("Assets/Images/icon.png");
            background-size: 100% 100%;
        }

        .header_left .title {
            font-family: "Montserrat", sans-serif;
            font-weight: normal;
            font-size: 1.9rem;
            margin: 0 20px;
        }

        .header_right ul {
            display: flex;
            margin: 0;
            list-style-type: none;
        }

        .header_right ul p {
            margin: 0.5rem 10px 0 0;
        }

        .header_right ul li {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .header_right ul li a {
            text-decoration: none;
            color: white;
            border: 1px solid;
            border-radius: 10px;
            padding: 0.4rem;
        }

        .header_right ul li a i {
            margin-right: 0.3rem;
        }

        /*Botón Volver*/
        .atras {
            width: 3.7rem;
            height: 3.2rem;
            font-size: 1.25rem;
            position: absolute;
            top: 7.4rem;
            left: 12.5vw;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 50%;
            cursor: pointer;
            border: 1px solid;
        }

        /*Pantalla de carga*/
        .pantalla_carga {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70%;
            height: 200px;
            margin: 10rem auto 10rem auto;
            overflow-x: auto;
            z-index: 10;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .pantalla_carga img {
            width: 50px;
            height: 50px;
        }

        .pantalla_carga h2 {
            margin-left: 1rem;
        }

        /*Vista película*/
        .principal {
            display: flex;
            flex-direction: column;
        }

        .fondo {
            position: absolute;
            width: 75%;
            height: 75.5vh;
            top: 13rem;
            left: 12.5%;
            opacity: 0.7;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            border-radius: 15px;
        }

        .pelicula {
            position: relative;
            display: flex;
            width: 75%;
            height: 75.5vh;
            padding: 4rem 3.5rem;
            margin: 0 auto;
            top: 8rem;
            background-color: rgba(0, 0, 0, 65%);
            border-radius: 15px;
        }

        .poster {
            display: flex;
            flex-direction: row-reverse;
            height: 80%;
            margin-bottom: 5%;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            border-radius: 15px;
        }

        .valoracion_container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3.2rem;
            height: 3rem;
            top: 2%;
            right: 2%;
            border-radius: 50%;
            background-color: grey;
        }

        .valoracion {
            text-align: center;
            font-weight: bold;
            font-size: 1.4rem;
        }

        .info_principal {
            display: flex;
            flex-direction: column;
            width: 25%;
            height: 100%;
        }

        .info_detallada {
            width: 75%;
            padding: 0 0 1rem 1vw;
            border-radius: 20px;
        }

        .info_detallada span h3 {
            padding: 0.5rem 0 0.5rem 1.5vw;
            font-size: 1.2rem;
            text-align: justify;
        }

        .info_detallada span h3 span {
            font-weight: 200;
        }

        #web a {
            color: orange;
        }

        .titulo {
            font-size: 1.7rem;
            text-align: center;
        }

        .aniadir_pelicula {
            display: flex;
            justify-content: center;
            width: 90%;
            margin: 0 auto;
        }

        .aniadir_pelicula .aniadir_a_lista {
            width: 75%;
            height: 2.5rem;
            margin: 2rem auto 0 auto;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .aniadir_pelicula .aniadir_a_favoritos {
            width: 20%;
            height: 2.5rem;
            margin: 2rem auto 0 auto;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .secundario {
            display: flex;
            flex-direction: column;
            margin: 10rem auto;
            width: 70%;
        }

        .secundario h1 {
            display: none;
            margin: 0 0 2rem 0;
        }

        /*Actores*/
        .actores {
            display: flex;
            justify-content: flex-start;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .actor {
            height: 100%;
            margin: 0 3.1% 0 0;
            cursor: pointer;
        }

        .info_actor {
            margin-top: 0.5rem;
            text-align: center;
        }

        .imagen_actor {
            width: 150px;
            height: 220px;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            border-radius: 15px;
        }

        .personaje {
            margin: 5% auto 10% auto;
        }

        .botones_carousel {
            display: none;
            justify-content: center;
        }

        .boton_carousel {
            width: 7rem;
            height: 2.5rem;
            font-size: 1.25rem;
            margin: 1rem 3rem 0 3rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 30px;
            cursor: pointer;
            border: 1px solid;
        }

        /*Footer*/
        .footer {
            position: sticky;
            width: 100%;
            bottom: 0;
            z-index: 1;
            background-color: #011727;
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 5rem;
            padding: 10px 20px;
        }

        .privacidad {
            display: flex;
            justify-content: space-between;
        }

        .privacidad p {
            margin-right: 2rem;
            cursor: pointer;
        }

        .social_media a {
            text-decoration: none;
            color: white;
            border-radius: 10px;
            padding: 0.4rem;
        }

        .social_media a i {
            margin-right: 0.3rem;
            font-size: 2rem;
        }

        @media only screen and (max-width: 1600px) {
            .info_principal {
                width: 30%;
            }

            .info_detallada {
                width: 70%;
            }
        }
        
        @media only screen and (max-width: 1450px) {
            .info_principal {
                width: 35%;
            }

            .info_detallada {
                width: 65%;
            }

            .info_detallada span h3 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="header_left">
                <div class="icon"></div>
                <h1 class="title">CineVista</h1>
            </div>
            <div class="header_right">
                <?php
                if ($sesion_iniciada) {
                    include_once ("Assets/Templates/view_sesion_header.html");
                } else {
                    include_once ("Assets/Templates/view_no_sesion_header.html");
                }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <div class="principal">
            <input type="hidden" id="id_pelicula" name="id_pelicula" value="<?php echo $id_pelicula; ?>" />

            <button id="atras" class="atras"><i class="fa-solid fa-backward-step"></i></button>

            <div id="fondo" class="fondo"></div>

            <div id="pelicula" class="pelicula">

                <div class="info_principal">
                    <div id="poster" class="poster">
                        <div id="valoracion_container" class="valoracion_container">
                            <p id="valoracion" class="valoracion"></p>
                        </div>
                    </div>

                    <h1 id="titulo" class="titulo"></h1>

                    <div class="aniadir_pelicula">
                        <button id="aniadir_a_lista" class="aniadir_a_lista">Añadir a lista</button>
                        <button id="aniadir_a_favoritos" class="aniadir_a_favoritos"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>

                <div id="info_detallada" class="info_detallada">
                    <span>
                        <h3 id="generos" class="generos"></h3>
                        <h3 id="sinopsis" class="sinopsis"></h3>
                        <h3 id="duracion" class="duracion"></h3>
                        <h3 id="fecha" class="fecha"></h3>
                        <h3 id="presupuesto" class="presupuesto"></h3>
                        <h3 id="ganancias" class="ganancias"></h3>
                        <h3 id="adulto" class="adulto"></h3>
                        <h3 id="web" class="web"></h3>
                        <h3 id="total_votos" class="total_votos"></h3>
                    </span>
                </div>
            </div>
        </div>

        <div id="pantalla_carga" class="pantalla_carga">
            <img src="Assets/Images/cargando.gif" alt="Cargando">
            <h2>Estamos cargando los actores... por favor espere.</h2>
        </div>

        <div class="secundario">
            <h1>Reparto</h1>
           
            <div id="actores" class="actores"></div>

            <div class="botones_carousel">
                <button id="btn_anterior" class="boton_carousel"><i class="fa-solid fa-backward"></i></button>
                <button id="btn_siguiente" class="boton_carousel"><i class="fa-solid fa-forward"></i></button>
            </div>

            <div id="comentarios" class="comentarios"></div>
        </div>
    </main>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        // Esta función es la que usa todas las demás, tanto para crear el DOM como para inicializar los listener cuando el documento esté cargado y listo.
        function create_DOM() {
            // Obtengo el id del input hidden.
            let id_pelicula = jQuery("#id_pelicula").val();

            // Se carga la película en el DOM.
            cargar_pelicula(id_pelicula);

            // Una vez se cargue la película y el documento esté listo se obtienen y cargan los actores.
            jQuery(document).ready(function () {
                cargar_actores(id_pelicula);

                // Inicializa los eventos click de los botones para el scroll de los botones
                scroll_actores();

                // Listener para que, al pulsar el botón vuelve atrás hasta la última coordenada clickada en el index. 
                jQuery("#atras").on("click", function () {
                    history.back();
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
            // Obtenemos los nombres de los géneros en un string separado por ", ". 
            let generos = pelicula["generos"].length > 0 ? pelicula["generos"].map(genero => genero.nombre).join(", ") : "No disponible";
            // Obtenemos la duración en horas y minutos.
            let duracion = pelicula["duracion"] > 0 ? Math.floor(pelicula["duracion"] / 60) + "h y " + pelicula["duracion"] % 60 + " minutos." : "No disponible";
            // Obtenemos la fecha con el formato español.
            let fecha = pelicula["fecha_estreno"] != "" ? pelicula["fecha_estreno"].split("-")[2] + "/" + pelicula["fecha_estreno"].split("-")[1] + "/" + pelicula["fecha_estreno"].split("-")[0] : "No disponible";
            // Obtenemos el resto de los atributos si no están vacíos.
            let sinopsis = pelicula["sinopsis"] != "" ? pelicula["sinopsis"] : "No disponible";
            let presupuesto = pelicula["presupuesto"] > 0 ? pelicula["presupuesto"].toLocaleString() + " $" : "No disponible";
            let ganancias = pelicula["ganancias"] > 0 ? pelicula["ganancias"].toLocaleString() + " $" : "No disponible";
            let popularidad = pelicula["popularidad"] > 0 ? pelicula["popularidad"] : "No disponible";
            let para_adultos = pelicula["adulto"] == true ? "+18" : "Para todas las edades";

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
            jQuery("#adulto").text(`Categoría: `).append(`<span>${para_adultos}</span>`);
            // Si se obtiene la url de la web se añade, si no se escribe "No disponible".
            pelicula["web"] != "" ? jQuery("#web").text(`Web: `).append(`<a href = '${pelicula["web"]}'>${pelicula["web"]}</a>`) : jQuery("#web").text("Web: ").append(`<span>No disponible</span>`);
            jQuery("#total_votos").text(`Total de votos: `).append(`<span>${pelicula["total_votos"]}</span>`);
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
                window.location = `actor.php?id=${id_actor}&nombre=${nombre}`;
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

        create_DOM();
    </script>
</body>

</html>