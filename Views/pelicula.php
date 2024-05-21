<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);
// Se usa para saber si se puede guardar la película en una lista o no.
$comp_sesion = $sesion_iniciada == true ? $_SESSION["id"] : 0;

$id_pelicula = isset($_GET["id"]) ? $_GET["id"] : 0;
$titulo = isset($_GET["titulo"]) ? "Película: " . $_GET["titulo"] : "Película";
$pagina_actual = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
$busqueda_actual = isset($_GET["busqueda"]) ? $_GET["busqueda"] : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <link rel="stylesheet" href="Assets/Styles/pelicula.css">

    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="Assets/Scripts/pelicula.js"></script>

    <title><?php echo $titulo; ?></title>
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
                    if ($_SESSION["rol"] == "Administrador") {
                        include_once ("Assets/Templates/view_admin_header.html");
                    } else {
                        include_once ("Assets/Templates/view_sesion_header.html");
                    }
                } else {
                    include_once ("Assets/Templates/view_no_sesion_header.html");
                }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <div class="principal">
            <input type="hidden" id="comp_sesion" name="comp_sesion" value="<?php echo $comp_sesion; ?>" />
            <input type="hidden" id="pagina_actual" name="pagina_actual" value="<?php echo $pagina_actual; ?>" />
            <input type="hidden" id="busqueda_actual" name="busqueda_actual" value="<?php echo $busqueda_actual; ?>" />
            <input type="hidden" id="id_pelicula" name="id_pelicula" value="<?php echo $id_pelicula; ?>" />
            <input type="hidden" id="id_favoritos" name="id_favoritos" />

            <button id="atras" class="atras">Volver</button>

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
                <button id="btn_anterior" class="boton_carousel"><i class="fa-solid fa-angles-left"></i></button>
                <button id="btn_siguiente" class="boton_carousel"><i class="fa-solid fa-angles-right"></i></button>
            </div>

            <div id="comentarios" class="comentarios"></div>
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
        
        inicializar_listeners();
    </script>
</body>

</html>