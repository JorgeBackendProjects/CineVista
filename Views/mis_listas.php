<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

// Se almacena la última url para devolver al usuario a la misma página al iniciar o registrarse.
//$redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "..index.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="Assets/Styles/perfil.css">-->
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <!--<script src="Assets/Scripts/perfil.js"></script>-->
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Mis listas</title>

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
            background-color: #021B30;
            color: white;
        }

        main {
            min-height: 110vh;
        }

        /*Cabecera*/
        header {
            position: sticky;
            width: 100%;
            top: 0;
            z-index: 1;
            background-color: #011727;
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

        .header_left a {
            text-decoration: none;
            color: white;
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

        /*Div principal de la vista*/
        .tabla_container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 60rem;
            height: 40rem;
            margin: 1% auto auto auto;
            background-color: rgba(0, 0, 0, 50%);
            border-radius: 30px;
        }

        .tabla_container h1 {
            margin: 2rem auto 1rem 3rem;
        }

        .tabla_listas {}

        /*Botones*/
        .container_boton_atras {
            display: flex;
            flex-direction: column;
            width: 60rem;
            margin: 1% auto auto auto;
        }

        .atras {
            width: 6rem;
            height: 2.7rem;
            margin: 0 0 0 0;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .ver_button {
            width: 100%;
            height: 2.5rem;
            font-size: 0.9rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .editar_button {
            width: 100%;
            height: 2.5rem;
            font-size: 0.9rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .eliminar_button {
            width: 100%;
            height: 2.5rem;
            font-size: 0.9rem;
            background-color: rgb(255, 50, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .boton_cancelar {
            width: 30%;
            height: 2.3rem;
            font-size: 1.25rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        .boton_enviar {
            width: 30%;
            height: 2.3rem;
            font-size: 1.25rem;
            background-color: rgb(255, 50, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }

        /*Modal de confirmación para eliminar perfil*/
        .contenedor_modal {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: 1;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .modal {
            display: flex;
            flex-direction: row-reverse;
            width: 35rem;
            height: 15rem;
            margin: 18% auto;
            padding: 20px;
            background-color: white;
            border-radius: 35px;
            border: 1px solid black;
        }

        .columna_modal {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .mensaje_modal {
            display: flex;
            justify-content: center;
            text-align: center;
            font-size: 1.1rem;
            color: black;
        }

        .eliminar_modal {
            display: none;
            width: 50%;
            height: 2.5rem;
            margin-top: 3vh;
            font-size: 1.2rem;
            background-color: rgb(255, 50, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
        }

        .cerrar_modal {
            color: grey;
            float: right;
            font-size: 30px;
            font-weight: bold;
        }

        .cerrar_modal:hover,
        .cerrar_modal:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /*Footer*/
        .footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            z-index: 1;
            background-color: #011727;
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

        @media only screen and (max-width: 1600px) {
            main {
                min-height: 150vh;
            }
        }

        @media only screen and (max-width: 1020px) {
            .header_left {
                margin-left: 0;
            }

            .header_left .icon {
                width: 3rem;
                height: 2.8rem;
            }

            .header_left .title {
                font-size: 2.5vw;
                margin: 0 10px;
            }

            .header_right {
                margin-right: 0;
            }

            .header_right ul li a {
                font-size: 1.7vw;
            }

            #perfil {
                width: 25rem;
                margin: 3% auto auto auto;
            }

            .container_boton_atras {
                width: 25rem;
                margin: 3% auto auto auto;
            }

            .privacidad p {
                font-size: 0.7rem;
                margin-right: 1rem;
            }

            .social_media a i {
                font-size: 1.5rem;
                margin-right: 0;
            }
        }




        .tabla_listas {
            width: 80%;
            margin: 1rem auto;
            border-collapse: separate;
            border-spacing: 0 0.1rem;
            cursor: default;
        }

        .tabla_listas thead tr {
            background-color: #021B30;
            color: white;
            font-weight: bold;
        }

        .tabla_listas th,
        .tabla_listas td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #dddddd;
        }

        .tabla_listas tbody tr {
            background-color: white;
        }

        .tabla_listas .encabezado td:first-child,
        .tabla_listas .lista td:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .tabla_listas .encabezado td:last-child,
        .tabla_listas .lista td:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .tabla_listas .lista {
            color: black;
        }
    </style>
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
            <button id="atras" class="atras">Volver</button>
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
        </div>
    </main>

    <div id="contenedor_modal" class="contenedor_modal">
        <div id="modal" class="modal">
            <span id="cerrar_modal" class="cerrar_modal">&times;</span>
            <div class="columna_modal">
                <p id="mensaje_modal" class="mensaje_modal"></p>
                <button id="eliminar_lista_modal" class="eliminar_lista_modal">Si, elimina mi cuenta</button>
            </div>
        </div>
    </div>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        jQuery(document).ready(function() {
            console.log("DOCUMENTO LISTO");
            jQuery.ajax({
                url: '../Controllers/lista_controller.php',
                method: 'POST',
                data: {
                    id_usuario: jQuery("#id_usuario").val(),
                    key: "get_listas_usuario"
                },
                success: function (data) {
                    console.log("SE HA HECHO LA LLAMADA");
                    if (JSON.parse(data) != "false") {
                        let listas = JSON.parse(data);
                        create_DOM_listas(listas);
                    } else {
                        // MOSTRAR MODAL - NO HAY LISTAS
                    }                
                },
                error: function (xhr, status, error) {

                }
            });
        });
        

        function create_DOM_listas(listas) {
            listas.forEach(lista => {
                // Obtenemos los datos de la lista.
                let id = lista["id"];
                let nombre = lista["nombre"];
                let fecha = lista["fecha"] != "" ? lista["fecha"].split("-")[2] + "/" + lista["fecha"].split("-")[1] + "/" + lista["fecha"].split("-")[0] : "No disponible";

                // Creamos los elementos por separado para el lista.
                let nueva_lista = jQuery("<tr>").addClass("lista");

                let id_lista = jQuery("<input>").attr({
                    type: "hidden",
                    name: "id_lista",
                    class: "id_lista",
                    value: id
                });

                let columna_nombre = jQuery("<td>").text(nombre);
                let columna_fecha = jQuery("<td>").text(fecha);
                let columna_ver = jQuery("<td>").append(id_lista).append(`<button class="ver_button">Ver</button>`);               
                let columna_editar = jQuery("<td>").append(id_lista).append(`<button class="editar_button">Editar</button>`);
                let columna_eliminar = jQuery("<td>").append(id_lista).append(`<button class="eliminar_button">Eliminar</button>`);

                // Agregamos los elementos a la tabla de listas.
                nueva_lista.append(columna_nombre, columna_fecha, columna_ver, columna_editar, columna_eliminar);

                // Se agrega el div del lista al contenedor de actores.
                jQuery("#tabla_listas tbody").append(nueva_lista);
            });

            // Después de agregar los elementos le asignamos el evento click para ver su información, editar y borrar.
            jQuery(".ver_button").on("click", function () {
                let id_lista = jQuery(this).siblings(".id_lista").val();
                window.location = `lista.php?id=${id_lista}`;
            });

            jQuery(".editar_button").on("click", function () {
                let id_lista = jQuery(this).siblings(".id_lista").val();
                // MOSTRAR MODAL
            });

            jQuery(".editar_button").on("click", function () {
                let id_lista = jQuery(this).siblings(".id_lista").val();
                // MOSTRAR MODAL
            });
        }
    </script>
</body>

</html>