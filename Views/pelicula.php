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
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
            background-color: rgb(2, 16, 29, 93%);
            color: white;
        }

        /*Cabecera*/
        header {
            position: sticky;
            width: 100%;
            top: 0;
            z-index: 1;
            background-color: rgb(2, 27, 48);
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

        .header_left i {
            font-size: 2.5em;
            color: white;
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
            top: 10rem;
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
            padding: 5rem;
            margin: 0 auto;
            top: 5rem;
            background-color: rgba(0, 0, 0, 65%);
            border-radius: 15px;
        }

        .poster {
            width: 300px;
            height: 100%;
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
            border-radius: 50%;
            background-color: grey;
            left: 80%;
        }

        .valoracion {
            text-align: center;
            font-weight: bold;
            font-size: 1.4rem;
        }

        .info_principal {
            display: flex;
            flex-direction: column;
            width: 300px;
            height: 34rem;
        }

        .info_detallada {
            margin-left: 2%;
            border-radius: 20px;
            padding: 0 2rem 0 1rem;   
        }

        .info_detallada span h3 {
            padding: 0.5rem 2rem;
            font-size: 1.3rem;
        }

        .info_detallada span h3 span {
            font-weight: 200;    
        }
        
        .titulo {
            text-align: center;
            padding-top: 5%;
        }

        #sinopsis {
            text-align: justify;
            padding: 1rem 15rem 1rem 2rem;
        }

        #web a {
            color: orange;
        }

        .secundario {
            display: flex;
            flex-direction: column;
            margin: 8rem auto;
            width: 70%;
        }

        .secundario h1 {
            display: none;
            margin-left: 0.5rem;
        }

        /*Actores*/
        .actores {
            display: flex;
            justify-content: space-evenly;
            width: 100%;
            margin: 2rem auto 10rem auto;
            overflow-x: auto;
        }

        .actor {
            width: 150px;
            margin: 0 0.5rem 0 0.5rem;
        }

        .info_actor {
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

        /*Footer*/
        .footer {
            position: sticky;
            width: 100%;
            bottom: 0;
            z-index: 1;
            background-color: rgb(2, 27, 48);
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
            font-size: 2.5rem;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="header_left">
                <i class="fa-solid fa-clapperboard"></i>
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

            <div id="fondo" class="fondo"></div>

            <div id="pelicula" class="pelicula">

                <div class="info_principal">
                    <div id="poster" class="poster">
                        <div id="valoracion_container" class="valoracion_container">
                            <p id="valoracion" class="valoracion"></p>
                        </div>
                    </div>

                    <h1 id="titulo" class="titulo"></h1>
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
            <div id="comentarios" class="comentarios"></div>
        </div>
    </main>

    <?php include_once("Assets/Templates/footer.html"); ?>

    <script>
        function create_DOM(){
            // Obtengo el id del input hidden.
            let id_pelicula = jQuery("#id_pelicula").val();

            // Se carga la película en el DOM.
            cargar_pelicula(id_pelicula);

            // Una vez se cargue la película y el documento esté listo se obtienen y cargan los actores.
            jQuery(document).ready(function(){
                cargar_actores(id_pelicula);
            });
        }

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
                }
            });
        }

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
                }
            });
        }

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

            if (pelicula["valoracion"] > 0 && pelicula["valoracion"] <= 2.5) {
                jQuery(".valoracion_container").css("background-color", "#E57373");
            } else if (pelicula["valoracion"] > 2.5 && pelicula["valoracion"] <= 5) {
                jQuery(".valoracion_container").css("background-color", "#FFB74D");
            } else if (pelicula["valoracion"] > 5 && pelicula["valoracion"] <= 7.5) {
                jQuery(".valoracion_container").css("background-color", "#FFF176");
            } else if (pelicula["valoracion"] > 7.5 && pelicula["valoracion"] <= 10) {
                jQuery(".valoracion_container").css("background-color", "#81C784");
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

        function create_DOM_actores(actores) {
            actores.forEach(actor => {
                // Se crea la estructura para el actor y se añade al contenedor de actores.
                let actorDiv = jQuery(`<div class='actor'>
                                        <input type='hidden' name='id_actor' value='${actor["id"]}' />
                                        <div class='imagen_actor'></div>
                                        <div class='info_actor'>
                                            <p class='nombre'></p>
                                            <p class='personaje'></p>
                                        </div>
                                       </div>`);

                jQuery("#actores").append(actorDiv);

                // Se obtiene la imagen, si no hay se muestra una por defecto.
                let imagen = actor["imagen"].length > 0 ? actor["imagen"] : "Assets/Images/estrella_cine.webp";

                // Se buscan los campos de la estructura del actor que hemos creado y añadimos sus datos.
                actorDiv.find(".imagen_actor").css("background-image", `url('${imagen}')`);
                actorDiv.find(".nombre").text(actor["nombre"]);
                actorDiv.find(".personaje").text(`Papel: ${actor["personaje"]}`);
            });
        }

        create_DOM();
    </script>
</body>

</html>