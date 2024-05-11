<?php
$id_pelicula = isset($_GET["id"]) ? $_GET["id"] : null;    
$titulo = isset($_GET["titulo"]) ? "Película: " . $_GET["titulo"] : "Película";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title><?php echo $titulo; ?></title>

    <style>
        .pelicula {
            display: flex;
            flex-direction: column;
            width: 65rem;
            margin: 0 auto;
        }

        .imagenes {
            display: flex;
            justify-content: space-evenly;
        }

        .poster {
            position: relative;
            width: 300px;
            height: 400px;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            border-radius: 15px;
            margin-right: 5rem;
        }

        .valoracion_container {
            position: absolute;
            width: 3.2rem;
            top: 5px;
            right: 5px;
            border-radius: 50%;
            background-color: lightgreen;
        }

        .valoracion {
            text-align: center;
            padding-right: 2px;
        }

        .fondo {
            width: 650px;
            height: 400px;
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        .titulo {
            text-align: center;
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
    <input type="hidden" id="id_pelicula" name="id_pelicula" value="<?php echo $id_pelicula; ?>" />

    <div id="pelicula" class="pelicula">
        <div id="imagenes" class="imagenes">
            <div id="poster" class="poster">
                <div id="valoracion_container" class="valoracion_container">
                    <p id="valoracion" class="valoracion"></p>
                </div>
            </div>
            <div id="fondo" class="fondo"></div>
        </div>

        <h1 id="titulo" class="titulo"></h1>

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
            jQuery("#valoracion").text(`${pelicula["valoracion"]}`)
            jQuery("#titulo").text(`${pelicula["titulo"]}`);
            jQuery("#sinopsis").text(`Sinopsis: ${pelicula["sinopsis"]}`);
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