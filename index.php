<?php

function get_popular_movies() {
    $movies_data = array();
    $actors_data = array();

    for ($i = 1; $i <= 2; $i++) {
        // Inicializa la sesión cURL para la solicitud.
        $get_popular_movies = curl_init();
        // Solicitud a la api para recoger los resultados de la página.
        curl_setopt($get_popular_movies, CURLOPT_URL, "https://api.themoviedb.org/3/discover/movie?page=" . $i . "&language=es-ES&sort_by=popularity.desc&api_key=107cc8a9703efd86f41232ea75b85039");
        // Hacemos que la respuesta se guarde en una variable.
        curl_setopt($get_popular_movies, CURLOPT_RETURNTRANSFER, true); 
        // Ejecutar la solicitud y guardar la respuesta
        $popular_movies = json_decode(curl_exec($get_popular_movies))->results;
        // Cerrar sesión cURL
        curl_close($get_popular_movies);

        // Recorremos cada película de la página.
        foreach ($popular_movies as $pelicula) {
            $casting_data = array();
            $id_actors = array();

        // PELICULA
            $get_one_movie = curl_init();
            curl_setopt($get_one_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $pelicula->id . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
            curl_setopt($get_one_movie, CURLOPT_RETURNTRANSFER, true); 
            // Recojo la película correspondiente al id con que se ha hecho la solicitud.
            $movie = json_decode(curl_exec($get_one_movie));
            curl_close($get_one_movie);
        
        // REPARTO
            $get_cast_movie = curl_init();
            curl_setopt($get_cast_movie, CURLOPT_URL, "https://api.themoviedb.org/3/movie/" . $pelicula->id . "/credits?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
            curl_setopt($get_cast_movie, CURLOPT_RETURNTRANSFER, true); 
            // Recojo el casting de la pelicula y lo guardo en el array.
            $casting = json_decode(curl_exec($get_cast_movie));
            array_push($casting_data, $casting);
            curl_close($get_cast_movie);
        
            //var_dump($casting_data[0]->cast);

        // ACTORES
            // Por cada actor del casting de la película guardo sus datos.
            $contador_actor = 0;
            foreach ($casting_data[0]->cast as $actor) {
                $id = isset($actor->id) ? $actor->id : null;
                $lugar_nacimiento = isset($actor->place_of_birth) ? $actor->place_of_birth : null;
                $nombre = isset($actor->name) ? $actor->name : null;

                $get_actor = curl_init();
                curl_setopt($get_actor, CURLOPT_URL, "https://api.themoviedb.org/3/person/" . $actor->id . "?language=es-ES&api_key=107cc8a9703efd86f41232ea75b85039");
                curl_setopt($get_actor, CURLOPT_RETURNTRANSFER, true); 
                // Recojo la película correspondiente al id con que se ha hecho la solicitud.
                $actor_info = json_decode(curl_exec($get_actor));
                // Cerrar sesión cURL.
                curl_close($get_actor);

                if (!isset($actor_info->success)) {
                    if ($actor_info->known_for_department == "Acting") {
                        $actor_data = array(
                            "id" => $id,
                            "nombre" => $nombre,
                            "personaje" => isset($actor_info->character) ? $actor_info->character : null,
                            "biografia" => isset($actor_info->biography) ? $actor_info->biography : null,
                            "lugar_nacimiento" => isset($lugar_nacimiento) ? $lugar_nacimiento : null,
                            "bithday" => $lugar_nacimiento,
                            "deathday" => isset($actor_info->deathday) ? $actor_info->deathday : null,
                            "genero" => isset($actor_info->gender) ? ($actor_info->gender == 1 ? "Femenino" : ($actor_info->gender == 2 ? "Masculino" : "Otro")) : null,
                            "departamento" => isset($actor_info->known_for_department) ? $actor_info->known_for_department : null,
                            "popularidad" => isset($actor_info->popularity) ? $actor_info->popularity : null,
                            "imagen" => isset($actor_info->profile_path) ? $actor_info->profile_path : null,
                            "peliculas" => isset($actor_info->also_known_as) ? $actor_info->also_known_as : null
                        );

                        var_dump($actor_data);
                    }
                }

                

                

                /*if (array_filter($actor_data, 'strlen')) {
                    array_push($actors_data, $actor_data);
                    array_push($id_actors, $actor_data["id"]);
                }*/
            }

            //var_dump($id_actors);

            // Guardamos la película en el array. // Añadir subarray con los id de los actores obtenidos en cada registro del array de reparto.
            $movie_data = array(
                "id" => $movie->id, // Es el id por el que he buscado en la petición.
                "adult" => $movie->adult, // Boolean, si es de adultos o no.
                "backdrop_path" => $movie->backdrop_path, // Fondo de la película que seguramente no haga falta.
                "belongs_to_collection" => $movie->belongs_to_collection, // Me devuelve 4 datos que seguramente no hagan falta.
                "budget" => $movie->budget, // Me devuelve el presupuesto.
                "genres" => $movie->genres, // Es un array que puede tener varios géneros. Recorrer y por cada uno obtener el género con la key ["name"].
                "homepage" => $movie->homepage, // Página donde ver la película.
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
                "id_actors" => $id_actors // ID de todos los actores del reparto.
            );
            
            array_push($movies_data, $movie_data);
        }
    }

    return array("movies" => $movies_data, "actors" => $actors_data);
}

$resultado = get_popular_movies();
//var_dump($resultado);







/*
// Verificar si hubo errores
if(curl_errno($get_popular_movies)){
    get_popular_movieso 'Error: ' . curl_error($get_popular_movies);
}
*/
?>
