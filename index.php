<?php
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="Views/Assets/Scripts/index.js"></script>
    <link rel="stylesheet" href="Views/Assets/Styles/index.css">
    <title>CineVista</title>
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
                        include_once("Views/Assets/Templates/index_sesion_header.html");
                    } else {
                        include_once("Views/Assets/Templates/index_no_sesion_header.html");
                    }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <div id="container_buscador" class="container_buscador">
            <input type="text" id="buscador" name="buscador" class="buscador" placeholder=" Buscar película" />
            <select id="categorias" name="categorias" class="categorias">
                <option value="">Categorías</option>
            </select>
        </div>

        <div id="peliculas" class="peliculas"></div>
    </main>

    <footer>

    </footer>

    <script>
        get_peliculas();
        inicia_listeners();
    </script>
</body>

</html>