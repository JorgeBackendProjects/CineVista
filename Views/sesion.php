<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

if (isset($_GET["accion"])) {
    $accion = $_GET["accion"] == "iniciar_sesion" ? "Iniciar sesion" : "Registro";
}

$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
$busqueda = isset($_GET["busqueda"]) ? $_GET["busqueda"] : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <link rel="stylesheet" href="Assets/Styles/sesion.css">
    
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="Assets/Scripts/sesion.js"></script>
    <title><?php echo $accion; ?></title>
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
                    include_once ("Assets/Templates/view_sesion_header.html"); 
                } else { 
                    include_once ("Assets/Templates/view_no_sesion_header.html"); 
                }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <input type="hidden" id="pagina" name="pagina" value="<?php echo $pagina; ?>" />
        <input type="hidden" id="busqueda" name="busqueda" value="<?php echo $busqueda; ?>" />

        <?php
        if ($accion == "Iniciar sesion") {
            include_once ("Assets/Templates/iniciar_sesion.html");
        } else {
            include_once ("Assets/Templates/registro.html");
        }
        ?>
    </main>

    <div id="contenedor_modal" class="contenedor_modal">
        <div id="modal" class="modal">
            <span id="cerrar_modal" class="cerrar_modal">&times;</span>
            <div class="columna_modal">
                <p id="mensaje_modal" class="mensaje_modal"></p>
            </div>
        </div>
    </div>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        iniciar_listeners();
    </script>
</body>

</html>