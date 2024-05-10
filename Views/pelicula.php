<?php
$id_pelicula = isset($_GET["id"]) ? $_GET["id"] : null;    
$titulo = isset($_GET["titulo"]) ? "Película: " . $_GET["titulo"] : "Película";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/001ac9542b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title><?php echo $titulo; ?></title>
</head>
<body>
    <input type="hidden" id="id_pelicula" name="id_pelicula" value="<?php echo $id_pelicula; ?>" />


    <script>
        // Me traigo la info de la base de datos y busco los actores de la API
        let id_pelicula = jQuery("#id_pelicula").val();
        
        jQuery.ajax({
            url: '../Controllers/pelicula_controller.php',
            method: 'POST',
            data: {
                id_pelicula: id_pelicula,
                key: "get_movie"
            },
            success: function (data) {
                console.log(data);
            }
        });
    </script>
</body>
</html>