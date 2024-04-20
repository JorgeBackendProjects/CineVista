<?php
// Inicializar sesión cURL
$ch = curl_init();

// Configurar la URL y otras opciones
curl_setopt($ch, CURLOPT_URL, "https://api.themoviedb.org/3/movie/11?api_key=107cc8a9703efd86f41232ea75b85039");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para que la respuesta se guarde en una variable en lugar de imprimirla directamente

// Ejecutar la solicitud y guardar la respuesta
$response = curl_exec($ch);

// Verificar si hubo errores
if(curl_errno($ch)){
    echo 'Error: ' . curl_error($ch);
}

// Cerrar sesión cURL
curl_close($ch);

// Hacer algo con la respuesta
echo $response;
?>
