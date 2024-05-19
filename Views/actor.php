<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

$id_actor = isset($_GET["id"]) ? $_GET["id"] : null;
$nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : "";
$pelicula_url = isset($_GET["pelicula_url"]) ? $_GET["pelicula_url"] : '../index.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <link rel="stylesheet" href="Assets/Styles/actor.css">
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="Assets/Scripts/actor.js"></script>
    <title><?php echo $nombre; ?></title>
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
            <input type="hidden" id="pelicula_url" name="pelicula_url" value="<?php echo htmlspecialchars($pelicula_url); ?>" />
            <input type="hidden" id="id_actor" name="id_actor" value="<?php echo $id_actor; ?>" />

            <button id="atras" class="atras">Volver</button>

            <div id="actor" class="actor">
                <div class="info_principal">
                    <div id="imagen" class="imagen"></div>
                    <h1 id="nombre" class="nombre"><?php echo $nombre; ?></h1>
                </div>

                <div id="info_detallada" class="info_detallada">
                    <span>
                        <h3 id="biografia" class="biografia"></h3>
                        <h3 id="birthday" class="birthday"></h3>
                        <h3 id="deathday" class="deathday"></h3>
                        <h3 id="genero" class="genero"></h3>
                        <h3 id="lugar_nacimiento" class="lugar_nacimiento"></h3>
                    </span>
                </div>
            </div>
        </div>
    </main>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        create_DOM();
    </script>
</body>

</html>