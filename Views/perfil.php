<?php
session_start();
$sesion_iniciada = isset($_SESSION["username"]);

$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
$busqueda = isset($_GET["busqueda"]) ? $_GET["busqueda"] : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/Styles/perfil.css">
    <link rel="icon" href="Assets/Images/icon.png" sizes="156x156" type="image/png">
    <script src="Assets/Scripts/perfil.js"></script>
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Perfil de usuario</title>
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
        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION["id"]; ?>" />
        <input type="hidden" id="pagina" name="pagina" value="<?php echo $pagina; ?>" />
        <input type="hidden" id="busqueda" name="busqueda" value="<?php echo $busqueda; ?>" />

        <div class="container_boton_atras">
            <button id="atras" class="btn atras">Volver</button>
        </div>

        <div id="perfil" class="perfil">
            <h1 id="titulo" class="titulo">Mi perfil</h1>
            <p id="info_editar" class="info_editar">Puedes editar sin modificar la contraseña</p>

            <div id="info_perfil" class="info_perfil">
                <div id="imagen" class="imagen">
                    <input type="file" id="input_imagen" name="input_imagen" class="input_imagen" accept="image/*">
                    <label for="input_imagen" class="imagen_label"><i class="fas fa-camera"></i></label>
                </div>
                <p id="username" class="username"><?php echo $_SESSION["username"]; ?></p>

                <button id="editar_perfil_button" class="btn editar_perfil_button">Editar perfil</button>                
                <button id="eliminar_perfil_button" class="btn eliminar_perfil_button">Eliminar cuenta</button>
            </div>
            
            <form id="editar_perfil_form">
                <label>Nombre de usuario</label>
                <input type="text" id="editar_username" name="editar_username" class="username" value="<?php echo $_SESSION["username"]; ?>" placeholder="Nombre de usuario" pattern="^[a-zA-Z0-9_.]{1,20}$" title="El nombre de usuario debe tener una longitud entre 5 y 20 caracteres sin espacios en blanco, como separador se permiten guiones bajos y puntos." required/>
                <label>E-mail</label>
                <input type="email" id="editar_email" name="editar_email" class="email" value="<?php echo $_SESSION["email"]; ?>" placeholder="E-mail" pattern="^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,5}$" title="La dirección de correo electrónico debe ser válida y terminar en .com o .es." required/>
                <label>Contraseña actual</label>
                <input type="password" id="editar_password" name="editar_password" class="password" placeholder="Contraseña" autocomplete="off" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_-])[A-Za-z\d$@$!%*?&_-]{8,25}$" title="La contraseña debe tener entre 8 y 25 caracteres, incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial." required/>
                <label>Nueva contraseña</label>
                <input type="password" id="editar_nueva_password" name="editar_nueva_password" class="password" placeholder="Nueva contraseña" autocomplete="off" required/>
                
                <div id="botones" class="botones">
                    <div class="container_botones">
                        <div id="editar_ver_password" class="btn">Ver contraseña</div>  
                        <button id="boton_enviar" name="boton_enviar" class="btn boton_enviar">Editar perfil</button>    
                    </div>

                    <button id="boton_cancelar" name="boton_cancelar" class="btn boton_cancelar">Cancelar</button>
                </div>
                
                </div>
            </form>
        </div>
    </main>

    <div id="contenedor_modal" class="contenedor_modal">
        <div id="modal" class="modal">
            <span id="cerrar_modal" class="cerrar_modal">&times;</span>
            <div class="columna_modal">
                <p id="mensaje_modal" class="mensaje_modal"></p>
                <button id="eliminar_cuenta_modal" class="btn eliminar_cuenta_modal">Si, elimina mi cuenta</button>
            </div>
        </div>
    </div>

    <?php include_once ("Assets/Templates/footer.html"); ?>

    <script>
        iniciar_listeners();
    </script>
</body>

</html>