<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

$id_lista = $_GET["id"] ? $_GET["id"] : 0;
$nombre = $_GET["nombre"] ? $_GET["nombre"] : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <link rel="stylesheet" href="Assets/Styles/lista.css">

    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="Assets/Scripts/lista.js"></script>

    <title><?php echo $nombre; ?></title>
</head>

<body>
    <header>
        <nav>
            <div class="header_left">
                <a href="../index.php">
                    <div class="icon"></div>
                </a>
                <a href="../index.php">
                    <h1 class="title">CineVista</h1>
                </a>
            </div>
            <div class="header_right">
                <?php
                if ($sesion_iniciada) {
                    if ($_SESSION["rol"] == "Administrador") {
                        include_once ("Assets/Templates/view_admin_header.html");
                    } else {
                        include_once ("Assets/Templates/view_sesion_header.html");
                    }
                }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <input type="hidden" id="id_lista" name="id_lista" value="<?php echo $id_lista; ?>" />

        <div class="container_boton_atras">
            <button id="atras" class="atras">Volver</button>
            <h1 id="nombre_lista" class="nombre_lista"><?php echo $nombre; ?></h1>
        </div>

        <div id="peliculas" class="peliculas"></div>

        <div id="contenedor_modal" class="contenedor_modal">
            <div id="modal" class="modal">
                <span id="cerrar_modal" class="cerrar_modal">&times;</span>
                <div class="columna_modal">
                    <input type="hidden" id="eliminar_id_modal" />
                    <p id="mensaje_modal" class="mensaje_modal"></p>
                    <button id="eliminar_pelicula_modal" class="eliminar_pelicula_modal">Eliminar película</button>
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