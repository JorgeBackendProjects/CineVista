<?php

// Obtener todos los actores del reparto de una película. 
// JUNTAR LAS DOS FUNCIONES Y GUARDAR EN LA PELICULA UN ARRAY DE ID DE ACTORES...
function get_casting($movie_id) {
    $casting_data = array();

    $get_cast_movie = curl_init();

    curl_setopt($get_cast_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $movie_id . "/credits?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
    curl_setopt($get_cast_movie, CURLOPT_RETURNTRANSFER, true); 

    // Recojo la película correspondiente al id con que se ha hecho la solicitud.
    $casting = json_decode(curl_exec($get_cast_movie));

    // Cerrar sesión cURL.
    curl_close($get_cast_movie);

    array_push($casting_data, $casting);

    // Devolvemos el id de cada personal de reparto de la película.
    return $casting_data;
}

$reparto = get_casting(11);
var_dump($reparto);

function get_actors_casting($reparto) {
    $actors = array();

    // Devolvemos el id de cada personal de reparto de la película.
    //return $casting_data;

    foreach ($reparto as $actor) {
        $get_actor = curl_init();

        curl_setopt($get_actor, CURLOPT_URL, "https://api.themoviedb.org/3/person/" . $actor->id . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
        curl_setopt($get_actor, CURLOPT_RETURNTRANSFER, true); 

        // Recojo la película correspondiente al id con que se ha hecho la solicitud.
        $respuesta = json_decode(curl_exec($get_actor));

        // Cerrar sesión cURL.
        curl_close($get_actor);

        // Guardamos el actor en el array.
        $info_actor = array(
            "id" => $respuesta->id,
            "nombre" => $respuesta->name,
            "personaje" => $actor->character,
            "biografia" => $respuesta->biography,
            "lugar_nacimiento" => $respuesta->place_of_birth,
            "bithday" => $respuesta->birthday,
            "deathday" => $respuesta->deathday,
            "genero" => $respuesta->gender == 1 ? "Femenino" : ($respuesta->gender == 2 ? "Masculino" : "Otro"),
            "departamento" => $respuesta->known_for_department,
            "popularidad" => $respuesta->popularity,
            "imagen" => $respuesta->profile_path,
            "peliculas" => $respuesta->also_known_as
        );

        //array_push($actors, $casting);
    }
}

/*function get_popular_movies() {
    $movies_data = array();

    for ($i = 1; $i <= 5; $i++) {
        // Inicializa la sesión cURL para la solicitud.
        $get_popular_movies = curl_init();

        // Solicitud a la api para recoger los resultados de la primera página... ¿Quizá tenga que hacer la solicitud en un bucle e iterar la página?
        curl_setopt($get_popular_movies, CURLOPT_URL, "https://api.themoviedb.org/3/discover/movie?page=" . $i . "&language=es-ES&sort_by=popularity.desc&api_key=107cc8a9703efd86f41232ea75b85039");
        // Hacemos que la respuesta se guarde en una variable.
        curl_setopt($get_popular_movies, CURLOPT_RETURNTRANSFER, true); 

        // Ejecutar la solicitud y guardar la respuesta
        $popular_movies = json_decode(curl_exec($get_popular_movies))->results;

        // Cerrar sesión cURL
        curl_close($get_popular_movies);

        // Recorremos las películas de la página...
        foreach ($popular_movies as $pelicula) {
        // PELICULA
            $get_one_movie = curl_init();

            curl_setopt($get_one_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $pelicula->id . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
            curl_setopt($get_one_movie, CURLOPT_RETURNTRANSFER, true); 

            // Recojo la película correspondiente al id con que se ha hecho la solicitud.
            $movie = json_decode(curl_exec($get_one_movie));

            // Cerrar sesión cURL.
            curl_close($get_one_movie);

            // Guardamos la película en el array. // Añadir subarray con los id de los actores obtenidos en cada registro del array de reparto.
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
        }
    }

    return array("movies" => $movies_data);
}

//$resultado = get_popular_movies();
//var_dump($resultado);

*/





/*
// Verificar si hubo errores
if(curl_errno($get_popular_movies)){
    get_popular_movieso 'Error: ' . curl_error($get_popular_movies);
}
*/
?>
