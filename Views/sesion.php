<?php
    if (isset($_GET["accion"])) {
        $accion = $_GET["accion"] == "iniciar_sesion" ? "Iniciar sesion" : "Registro";
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Assets/Styles/sesion.css">
    <title><?php echo $accion; ?></title>
</head>

<body>
    <?php
        if ($accion == "Iniciar sesion") {
            include_once("Assets/Templates/iniciar_sesion.html");
        } else {
            include_once("Assets/Templates/registro.html");
        }
    ?>
</body>

</html>