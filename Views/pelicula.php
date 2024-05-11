<?php
$id_pelicula = isset($_GET["id"]) ? $_GET["id"] : null;    
$titulo = isset($_GET["titulo"]) ? "Película: " . $_GET["titulo"] : "Película";

$sesion_iniciada = isset($_SESSION["usuario"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .header_right ul li {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .header_right ul p {
            margin-right: 10px;
        }

        .header_right ul li a {
            text-decoration: none;
            color: white;
        }

        .fondo {
            position: absolute;
            width: 90%;
            height: 85%;
            left: 5%;
            top: 10rem;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            opacity: 0.5;
            border-radius: 15px;
        }

        .pelicula {
            display: flex;
            width: 90rem;
            margin: 8rem auto;
        }

        .poster {
            position: relative;
            width: 300px;
            height: 400px;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            border-radius: 15px;
        }

        .valoracion_container {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3.2rem;
            height: 3rem;
            top: 5px;
            right: 5px;
            border-radius: 50%;
            background-color: lightgreen;
        }

        .valoracion {
            text-align: center;
            font-weight: bold;
        }

        .info_principal {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 300px;
            height: 29rem;
        }

        .titulo {
            text-align: center;
        }

        #sinopsis {
            text-align: justify;
            padding: 1rem 2rem;
        }

        .info {
            position: relative;
        }

        .info span p {
            padding: 0.5rem 2rem;
        }

        .actores {
            display: flex;
        }

        .actor {
            margin-left: 2rem;
        }

        .imagen_actor {
            width: 150px;
            height: 200px;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            border-radius: 15px;
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
                        include_once("Assets/Templates/sesion_header.html");
                    } else {
                        include_once("Assets/Templates/no_sesion_header.html");
                    }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <div id="fondo" class="fondo"></div>

        <div id="pelicula" class="pelicula">
            <input type="hidden" id="id_pelicula" name="id_pelicula" value="<?php echo $id_pelicula; ?>" />

            <div class="info_principal">
                <div id="poster" class="poster">
                    <div id="valoracion_container" class="valoracion_container">
                        <p id="valoracion" class="valoracion"></p>
                    </div>
                </div>

                <h1 id="titulo" class="titulo"></h1>
            </div>
                
            <div id="info" class="info">
                <span>
                    <p id="sinopsis" class="sinopsis"></p>
                    <p id="duracion" class="duracion"></p>
                    <p id="presupuesto" class="presupuesto"></p>
                    <p id="ganancias" class="ganancias"></p>
                    <p id="popularidad" class="popularidad"></p>
                    <p id="adulto" class="adulto"></p>
                    <p id="web" class="web"></p>
                    <p id="total_votos" class="total_votos"></p>
                </span>
            </span>

            <div id="actores" class="actores"></div>

            <div id="comentarios" class="comentarios"></div>
        </div>
    </main>

    <footer></footer>
    
    <script>
        // Me traigo la info de la base de datos y busco sus actores
        let id_pelicula = jQuery("#id_pelicula").val();
        
        jQuery.ajax({
            url: '../Controllers/pelicula_controller.php',
            method: 'POST',
            data: {
                id_pelicula: id_pelicula,
                key: "get_movie"
            },
            success: function (data) {
                // Obtengo el objeto película y el array de actores
                let pelicula = JSON.parse(data).pelicula;
                let actores = JSON.parse(data).actores;

                //console.log(pelicula);
                //console.log(actores);

                create_DOM_pelicula(pelicula);
                create_DOM_actores(actores);
            }
        });

        function create_DOM_pelicula(pelicula) {
            // Pelicula
            jQuery("#poster").css("background-image", `url(${pelicula["poster"]})`);
            jQuery("#fondo").css("background-image", `url(${pelicula["fondo"]})`);
            jQuery("#valoracion").text(`${pelicula["valoracion"]}`);
            jQuery("#titulo").text(`${pelicula["titulo"]}`);
            jQuery("#sinopsis").text(`${pelicula["sinopsis"]}`);
            jQuery("#duracion").text(`Duración: ${pelicula["duracion"]} min`);
            jQuery("#presupuesto").text(`Presupuesto: ${pelicula["presupuesto"]}$`);
            jQuery("#ganancias").text(`Ganancias: ${pelicula["ganancias"]}$`);
            jQuery("#popularidad").text(`Popularidad: ${pelicula["popularidad"]}`);
            let para_adultos = pelicula["adulto"] == true ? "+18" : "Para todas las edades";
            jQuery("#adulto").text(`${para_adultos}`);
            jQuery("#web").text(`Web: ${pelicula["web"]}`);
            jQuery("#total_votos").text(`Total de votos: ${pelicula["total_votos"]}`);
        }

        function create_DOM_actores(actores) {
            actores.forEach(actor => {
                // Se crea la estructura para el actor y se añade al contenedor de actores.
                let actorDiv = jQuery("<div class='actor'><input type='hidden' name='id_actor' value='" + actor["id"] + "' /><div class='imagen_actor'></div><div class='info_actor'><p class='nombre'></p><p class='personaje'></p></div></div>");
                jQuery("#actores").append(actorDiv);

                // Se obtiene la imagen, si no hay se muestra una por defecto.
                let imagen = actor["imagen"].length > 0 ? actor["imagen"] : "Assets/Images/estrella_cine.webp"; 
                
                // Se buscan los campos de la estructura del actor que hemos creado y añadimos sus datos.
                actorDiv.find(".imagen_actor").css("background-image", "url(" + imagen + ")");
                actorDiv.find(".nombre").text(actor["nombre"]);
                actorDiv.find(".personaje").text(actor["personaje"]);
            });
        }
    </script>
</body>
</html>