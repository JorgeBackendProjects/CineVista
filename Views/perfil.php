<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>

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

        /*Botón Volver*/
        .atras {
            width: 7rem;
            height: 2.5rem;
            font-size: 1.25rem;
            position: absolute;
            top: 6.8rem;
            left: 3rem;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }


        /*Texto*/
        .principal h1 {
            margin: 3rem auto 1rem 3rem;
        }

        .principal p {
            margin: 0 3vw 2rem 2.5vw;
        }

        /*Variación para la clase principal de inicio*/
        .principal {
            display: flex;
            flex-direction: column;
            width: 30rem;
            height: 65vh;
            margin: 5% auto auto auto;
            background-color: rgba(0, 0, 0, 50%);
            border-radius: 30px;
        }

        .principal form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .principal form input {
            width: 80%;
            height: 3rem;
            padding-left: 5%;
            margin: 2rem auto auto 3rem;
            border: 2px solid black;
            border-radius: 10px;
        }

        .principal form .boton_enviar {
            width: 10rem;
            height: 2.5rem;
            font-size: 1.25rem;
            margin: 3rem 0 3rem 45%;
            background-color: rgb(255, 188, 50);
            color: white;
            border-radius: 15px;
            cursor: pointer;
            border: 1px solid;
        }
        
        /*Modal de información sobre el envío*/
        .contenedor_modal {
            display: none;
            position: fixed;
            width: 100%; 
            height: 100%; 
            left: 0;
            top: 0;
            z-index: 1;
            overflow: auto; 
            background-color: rgba(0,0,0,0.6); 
        }

        .modal {
            width: 25%;
            height: 20%;
            margin: 18% auto;
            padding: 20px;
            background-color: white;
            border-radius: 35px;
            border: 1px solid black;
        }

        .mensaje_modal {
            display: flex;
            justify-content: center;
            margin-top: 6vh;
            text-align: center;
            font-size: 1.1rem;
            color: black;
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
                
            <?php 
            if ($sesion_iniciada) {
                if ($_SESSION["rol"] == "Administrador") {
                    include_once("Assets/Templates/view_admin_header.html");
                } else {
                    include_once ("Assets/Templates/view_sesion_header.html"); 
                }
            }
            ?>
            </div>
        </nav>
    </header>

    <main>
        <div id="principal" class="principal">
            <button id="atras" class="atras">Volver</button>
            <h1>Tu perfil</h1>
            
            <form id="editar_perfil_form">
                <input type="hidden" id="redirect_url" name="redirect_url" value="<?php echo htmlspecialchars($redirect_url); ?>">

                <input type="text" id="editar_nombre" name="editar_nombre" class="nombre" placeholder="Nombre" required/>
                <input type="text" id="editar_username" name="editar_username" class="username" placeholder="Nombre de usuario" pattern="^[a-zA-Z0-9_.]{1,20}$" title="El nombre de usuario debe tener una longitud entre 5 y 20 caracteres sin espacios en blanco, como separador se permiten guiones bajos y puntos." required/>
                <input type="email" id="editar_email" name="editar_email" class="email" placeholder="E-mail" pattern="^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,5}$" title="La dirección de correo electrónico debe ser válida y terminar en .com o .es." required/>
                <input type="password" id="editar_password" name="editar_password" class="password" placeholder="Contraseña" autocomplete="off" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_-])[A-Za-z\d$@$!%*?&_-]{8,25}$" title="La contraseña debe tener entre 8 y 25 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial." required/>
                <input type="password" id="editar_repetir_password" name="editar_repetir_password" class="password" placeholder="Repetir contraseña" autocomplete="off" required/>
                
                <button id="boton_registro" name="boton_registro" class="boton_enviar">Editar perfil</button>
            </form>
        </div>
    </main>

    <div id="contenedor_modal" class="contenedor_modal">
        <div id="modal" class="modal">
            <span id="cerrar_modal" class="cerrar_modal">&times;</span>
            <p id="mensaje_modal" class="mensaje_modal"></p>
        </div>
    </div>

    <?php include_once ("Assets/Templates/footer.html"); ?>
</body>

</html>