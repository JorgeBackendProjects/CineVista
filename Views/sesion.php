<?php
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"] == "iniciar_sesion" ? "Iniciar sesion" : "Registro";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="Assets/Styles/sesion.css">-->
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title><?php echo $accion; ?></title>

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

        /*Contenedor principal*/
        .principal {
            display: flex;
            flex-direction: column;
            width: 30rem;
            height: 65vh;
            margin: 5% auto auto auto;
            background-color: rgba(0, 0, 0, 50%);
            border-radius: 30px;
        }

        /*Variación para la clase principal de registro*/
        #registro_principal {
            height: 72vh;
            margin: 3% auto auto auto;
        }

        .principal h1 {
            margin: 3rem auto 1rem 3rem;
        }

        .principal p {
            margin: 0 3vw 2rem 2.5vw;
        }

        /*Botón Volver*/
        .atras {
            width: 7rem;
            height: 2.5rem;
            font-size: 1.25rem;
            position: absolute;
            top: 6.8rem;
            left: 3rem;
            background: linear-gradient(90deg, rgb(219, 206, 0) 0%, rgb(255, 188, 0) 100%);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        /*FORMULARIO*/
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        input {
            width: 80%;
            height: 3rem;
            padding-left: 5%;
            margin: 2rem auto auto 3rem;
            border: 2px solid black;
            border-radius: 10px;
        }

        /*Botón de envío de formulario*/
        .boton_enviar {
            width: 10rem;
            height: 2.5rem;
            font-size: 1.25rem;
            margin: 3rem 0 3rem 45%;
            background: linear-gradient(90deg, rgb(219, 206, 0) 0%, rgb(255, 188, 0) 100%);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        /*Modal de información sobre el envío*/
        .modal_envio {
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

        .modal_envio h2 {
            margin-left: 1rem;
        }

        /*Footer*/
        .footer {
            position: absolute;
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
            font-size: 2rem;
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
                <?php include_once ("Assets/Templates/view_no_sesion_header.html"); ?>
            </div>
        </nav>
    </header>

    <main>
        <?php
        if ($accion == "Iniciar sesion") {
            include_once ("Assets/Templates/iniciar_sesion.html");
        } else {
            include_once ("Assets/Templates/registro.html");
        }
        ?>
    </main>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        // Listener para que, al pulsar el botón vuelve atrás hasta la última coordenada clickada en el index. 
        jQuery("#atras").on("click", function () {
            history.back();
        });

        jQuery("#boton_registro").on("click", function(event) {
            event.preventDefault();

            let key = jQuery("#key").val();
            var formData = new FormData(jQuery('#form_insert')[0]);
            jQuery.ajax({
                url: '../Controllers/usuario_controller.php',
                method: 'POST',
                data: {
                    id_pelicula: id_pelicula,
                    key: key
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
        });

        jQuery("#boton_inicio").on("click", function(event) {
            event.preventDefault();

            let key = jQuery("#key").val();
            var formData = new FormData(jQuery('#form_insert')[0]);
            jQuery.ajax({
                url: '../Controllers/usuario_controller.php',
                method: 'POST',
                data: {
                    id_pelicula: id_pelicula,
                    key: key
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
        });

    </script>
</body>

</html>