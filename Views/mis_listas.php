<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <link rel="stylesheet" href="Assets/Styles/mis_listas.css">

    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="Assets/Scripts/mis_listas.js"></script>
    <title>Mis listas</title>
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
        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION["id"]; ?>" />

        <div class="container_boton_atras">
            <button id="atras" class="btn atras">Volver</button>
        </div>

        <div id="tabla_container" class="tabla_container">
            <h1 id="titulo" class="titulo">Mis listas</h1>

            <table id="tabla_listas" class="tabla_listas">
                <thead>
                    <tr class="encabezado">
                        <td>Nombre</td>
                        <td>Fecha</td>
                        <td>Ver</td>
                        <td>Editar</td>
                        <td>Eliminar</td>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>

            <div class="nueva_lista_container">
                <button id="nueva_lista_button" class="btn nueva_lista_button">Nueva lista</button>
            </div>
        </div>
    </main>

    <div id="contenedor_modal" class="contenedor_modal">
        <div id="modal" class="modal">
            <span id="cerrar_modal" class="cerrar_modal">&times;</span>
            <div class="columna_modal">
                <p id="mensaje_modal" class="mensaje_modal"></p>
                <input type="hidden" class="id_lista_modal" />
                <input type="text" class="nuevo_nombre_lista" placeholder="Nombre para la lista"/>
                <button id="crear_lista_modal" class="btn crear_lista_modal">Crear</button>
                <button id="editar_lista_modal" class="btn editar_lista_modal">Editar</button>
                <button id="eliminar_lista_modal" class="eliminar_lista_modal">Si, elimina la lista</button>
            </div>
        </div>
    </div>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        iniciar_listeners();
    </script>
</body>

</html>