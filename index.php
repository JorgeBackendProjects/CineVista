<?php
// Inicializa la sesión cURL para la solicitud.
$get_all_movies = curl_init();

// POPULAR PAGE 1
//curl_setopt($get_all_movies, CURLOPT_URL, "https://api.themoviedb.org/3/movie/popular?page=1&languague=es_ES&api_key=107cc8a9703efd86f41232ea75b85039");

// MOVIE PAGE 1
// Solicitud a la api para recoger los resultados de la primera página... ¿Quizá tenga que hacer la solicitud en un bucle e iterar la página?
curl_setopt($get_all_movies, CURLOPT_URL, "https://api.themoviedb.org/3/discover/movie?page=100&language=es-ES&sort_by=popularity.desc&api_key=107cc8a9703efd86f41232ea75b85039");
// Hacemos que la respuesta se guarde en una variable.
curl_setopt($get_all_movies, CURLOPT_RETURNTRANSFER, true); 

// Ejecutar la solicitud y guardar la respuesta
$movies = json_decode(curl_exec($get_all_movies))->results;

// Cerrar sesión cURL
curl_close($get_all_movies);

// Recorremos las películas de la primera página... // Para obtener reparto seguramente se haga a otra url con el id de película (AÑADIR)...
$movies_data = array();
foreach ($movies as $pelicula) {
    $get_one_movie = curl_init();

    curl_setopt($get_one_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $pelicula->id . "?language=es-ES&sort_by=popularity.desc&api_key=107cc8a9703efd86f41232ea75b85039");
    curl_setopt($get_one_movie, CURLOPT_RETURNTRANSFER, true); 

    // Recojo la película correspondiente al id con que se ha hecho la solicitud.
    $movie = json_decode(curl_exec($get_one_movie));

    $movie_data = array(
        "adult" => $movie->adult, // Boolean, si es de adultos o no.
        "backdrop_path" => $movie->backdrop_path, // Fondo de la película que seguramente no haga falta.
        "belongs_to_collection" => $movie->belongs_to_collection, // Me devuelve 4 datos que seguramente no hagan falta.
        "budget" => $movie->budget, // Me devuelve el presupuesto.
        "genres" => $movie->genres, // Es un array que puede tener varios géneros. Recorrer y por cada uno obtener el género con la key ["name"].
        "homepage" => $movie->homepage, // Página donde ver la película.
        "id" => $movie->id, // Es el id por el que he buscado en la petición.
        "imdb_id" => $movie->imdb_id, // Id que seguramente no haga falta.
        "origin_country" => $movie->origin_country, // Array (un solo valor?) con String.
        "original_language" => $movie->original_language, // Valor en/es etc... Hacer función para modificarlo y guardarlo sin abreviatura.
        "original_title" => $movie->original_title, // Me da el título en inglés.
        "overview" => $movie->overview, // String con la sinopsis de la película.
        "popularity" => $movie->popularity, // Float con el valor de popularidad. Es útil ???
        "poster_path" => "https://image.tmdb.org/t/p/original" . $movie->poster_path, // Ruta completa a la imágen de la película. // Hacer función js para convertir img a blob al recoger la url y mostrarla.
        "production_companies" => $movie->production_companies, // Array con el nombre de la compañía en la clave ["name"]
        "production_countries" => $movie->production_countries, // Array con el nombre del país en la clave ["name"]
        "release_date" => $movie->release_date, // Date con la fecha de estreno
        "revenue" => $movie->revenue, // Ganancias.
        "runtime" => $movie->runtime, // Tiempo en minutos de duración.
        "spoken_languages" => $movie->spoken_languages,
        "status" => $movie->status, // *En inglés* released (liberada/estrenada/disponible), u otros tipos.
        "tagline" => $movie->tagline, // Lema de la película, la mayoría no tiene.
        "title" => $movie->title, // Me da el título en español.
        "video" => $movie->video, // Boolean, si hay o no vídeo.
        "vote_average" => $movie->vote_average, // Float con puntuación. 
        "vote_count" => $movie->vote_count, // Int con total de calificaciones obtenidos.
    );
    
    array_push($movies_data, $movie_data);

    // Cerrar sesión cURL.
    curl_close($get_one_movie);
}

// Se ha recogido cada info de cada pelicula de una pagina.
var_dump($movies_data);


/*
// Verificar si hubo errores
if(curl_errno($get_all_movies)){
    get_all_movieso 'Error: ' . curl_error($get_all_movies);
}
*/
?>
