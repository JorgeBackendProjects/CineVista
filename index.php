<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

$pagina_actual = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" sizes="152x152" href="Views/Assets/Images/icon.png" type="image/png" />    
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
                <div class="icon"></div>
                <h1 class="title">CineVista</h1>
            </div>
            <div class="header_right">
                <?php
                    if ($sesion_iniciada) {
                        if ($_SESSION["rol"] == "Administrador") {
                            include_once("Views/Assets/Templates/index_admin_header.html");
                        } else {
                            include_once("Views/Assets/Templates/index_sesion_header.html");
                        }
                    } else {
                        include_once("Views/Assets/Templates/index_no_sesion_header.html");
                    }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <input type="hidden" id="pagina_actual" name="pagina_actual" value="<?php echo $pagina_actual; ?>"/>
        <div id="container_buscador" class="container_buscador">
            <input type="search" id="buscador" class="buscador" placeholder="Busca películas por título o fecha" autocomplete="off">
        </div>

        <div id="texto_principal_container" class="texto_principal_container">
            <h2 id="titulo_main" class="titulo_main">Películas más populares</h2>
            <h2 id="numero_pagina_text" class="numero_pagina_text">Página 1</h2>
        </div>
        
        <div id="peliculas" class="peliculas"></div>

        <div id="container_paginacion" class="container_paginacion">
            <div id="paginacion" class="paginacion"></div>
            <p id="numero_paginas" class="numero_paginas"></p>
        </div>
    </main>

    <?php include_once("Views/Assets/Templates/footer.html"); ?>

    <script>
        inicializar_DOM();
    </script>
</body>

</html>