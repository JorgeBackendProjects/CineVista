<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]) ? true : header("Location: ../index.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <link rel="stylesheet" href="Assets/Styles/aniadir_peliculas.css">

    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="Assets/Scripts/aniadir_peliculas.js"></script>

    <title>Añadir películas</title>
</head>

<body>
    <header>
        <nav>
            <div class="header_left">
                <a href="../index.php"><div class="icon"></div></a>
                <a href="../index.php"><h1 class="title">CineVista</h1></a>
            </div>
            <div class="header_right">
                <?php
                if ($sesion_iniciada) {
                    include_once ("Assets/Templates/view_admin_header.html");
                } else {
                    include_once ("Assets/Templates/view_no_sesion_header.html");
                }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <div>
            <div class="container_boton_atras">
                <button id="atras" class="atras">Volver</button>
            </div>

            <div id="principal" class="principal">
                <h1>Añadir películas</h1>
                <p id="ultima_pagina" class="ultima_pagina"></p>
                <p>Insertar a partir de la página siguiente:</p>

                <div class="insercion_form">
                    <input type="text" id="num_pagina" class="num_pagina" readonly />
                    <button id="insertar_button" class="btn insertar_button">Añadir</button>
                </div>
            </div>
        </div>

        <div id="pantalla_carga" class="pantalla_carga">
            <img src="Assets/Images/cargando.gif" alt="Cargando">
            <h2>Espera mientras se insertan las nuevas películas...</h2>
        </div>

        <div id="contenedor_modal" class="contenedor_modal">
            <div id="modal" class="modal">
                <span id="cerrar_modal" class="cerrar_modal">&times;</span>
                <div class="columna_modal">
                    <p id="mensaje_modal" class="mensaje_modal"></p>
                </div>
            </div>
        </div>
    </main>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        iniciar_listeners();
    </script>
</body>

</html>