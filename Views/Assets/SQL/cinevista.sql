-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2024 a las 01:11:36
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cinevista`
--

CREATE DATABASE `cinevista`;
USE DATABASE `cinevista`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actor`
--

CREATE TABLE `actor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `biografia` varchar(500) NOT NULL,
  `lugar_nacimiento` varchar(100) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `deathday` varchar(100) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `popularidad` float NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(12, 'Aventura'),
(14, 'Fantasía'),
(16, 'Animación'),
(18, 'Drama'),
(27, 'Terror'),
(28, 'Acción'),
(35, 'Comedia'),
(36, 'Historia'),
(37, 'Western'),
(53, 'Suspense'),
(80, 'Crimen'),
(99, 'Documental'),
(878, 'Ciencia ficción'),
(9648, 'Misterio'),
(10749, 'Romance'),
(10751, 'Familia'),
(10752, 'Bélica'),
(10770, 'Película de TV');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `comentario` varchar(245) NOT NULL,
  `valoracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista`
--

CREATE TABLE `lista` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_pelicula`
--

CREATE TABLE `lista_pelicula` (
  `id` int(11) NOT NULL,
  `id_lista` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `sinopsis` varchar(200) NOT NULL,
  `duracion` int(11) NOT NULL,
  `presupuesto` float NOT NULL,
  `ganancias` float NOT NULL,
  `fecha_estreno` varchar(50) NOT NULL,
  `pais_origen` varchar(50) NOT NULL,
  `web` varchar(200) NOT NULL,
  `popularidad` float NOT NULL,
  `valoracion` float NOT NULL,
  `total_votos` int(11) NOT NULL,
  `fondo` varchar(100) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `adulto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`id`, `titulo`, `sinopsis`, `duracion`, `presupuesto`, `ganancias`, `fecha_estreno`, `pais_origen`, `web`, `popularidad`, `valoracion`, `total_votos`, `fondo`, `poster`, `adulto`) VALUES
(11, 'La guerra de las galaxias', 'La princesa Leia, líder del movimiento rebelde que desea reinstaurar la República en la galaxia en los tiempos ominosos del Imperio, es capturada por las malévolas Fuerzas Imperiales, capitaneadas por', 121, 11000000, 775398000, '1977-05-25', 'US', '', 429.523, 8.203, 19966, 'https://image.tmdb.org/t/p/original/4qCqAdHcNKeAHcK8tJ8wNJZa9cx.jpg', 'https://image.tmdb.org/t/p/original/ahT4ObS7XKedQkOSpGr1wQ97aKA.jpg', ''),
(106, 'Depredador', 'Un comando de mercenarios es contratados por la CIA para rescatar a unos pilotos apresados por las guerrillas en la selva Centroamericana. La misión resulta satisfactoria, pero durante su viaje de reg', 102, 15000000, 98267600, '1987-06-12', 'US', '', 369.041, 7.524, 7696, 'https://image.tmdb.org/t/p/original/YL3GPOiDcNraIJOVDCZsoOBoDy.jpg', 'https://image.tmdb.org/t/p/original/bzLLeqhNBNmO6WImHrrmLNyhMxi.jpg', ''),
(141, 'Donnie Darko', 'Donnie es un chico americano dotado de gran inteligencia e imaginación. Tras escapar milagrosamente de una muerte casi segura, comienza a sufrir alucinaciones que lo llevan a actuar como nunca hubiera', 113, 4500000, 7500000, '2001-01-19', 'US', '', 367.625, 7.779, 11995, 'https://image.tmdb.org/t/p/original/8eLXy49T36e0e1YhYvUQOCXNRhm.jpg', 'https://image.tmdb.org/t/p/original/1YjDHBC4v2O7IQDKYAiM8fOxzf3.jpg', ''),
(218, 'Terminator', 'Un cyborg ha sido enviado desde el futuro en una misión mortal: eliminar a Sarah Connor, una joven cuya vida tendrá una gran importancia en los próximos años. Sarah tiene sólo un protector —Kyle Reese', 108, 6400000, 78371200, '1984-10-26', 'US', '', 426.383, 7.7, 12507, 'https://image.tmdb.org/t/p/original/6dpnthrofbqWmvapUyvqCrkdHG.jpg', 'https://image.tmdb.org/t/p/original/kbPqRWsGS1siVUeEFVtLKloTG0Y.jpg', ''),
(603, 'Matrix', 'Thomas Anderson lleva una doble vida: por el día es programador en una importante empresa de software, y por la noche un hacker informático llamado Neo. Su vida no volverá a ser igual cuando unos mist', 138, 63000000, 463517000, '1999-03-31', 'US', '', 421.173, 8.2, 24843, 'https://image.tmdb.org/t/p/original/icmmSD4vTTDKOq2vvdulafOGw93.jpg', 'https://image.tmdb.org/t/p/original/qK76PKQLd6zlMn0u83Ej9YQOqPL.jpg', ''),
(680, 'Pulp Fiction', 'Jules y Vincent, dos asesinos a sueldo con muy pocas luces, trabajan para Marsellus Wallace. Vincent le confiesa a Jules que Marsellus le ha pedido que cuide de Mia, su mujer. Jules le recomienda prud', 154, 8500000, 213900000, '1994-09-10', 'US', '', 379.265, 8.5, 27042, 'https://image.tmdb.org/t/p/original/suaEOtk1N1sgg2MTM7oZd2cfVp3.jpg', 'https://image.tmdb.org/t/p/original/hNcQAuquJxTxl2fJFs1R42DrWcf.jpg', ''),
(1700, 'Misery', 'Un escritor llamado Paul Sheldon (James Caan) lleva años malgastando su talento con unas románticas historias, de gran éxito comercial, cuya protagonista es una mujer llamada Misery. Decidido a acabar', 107, 20000000, 61300000, '1990-11-30', 'US', '', 358.901, 7.756, 4424, 'https://image.tmdb.org/t/p/original/cgo3OmF84touDrrLkQ1DQ3MRFyO.jpg', 'https://image.tmdb.org/t/p/original/gAELWNF6ViSF5OG1fibPvUbtnZn.jpg', ''),
(1924, 'Superman', 'Desde una galaxia remota, un recién nacido es enviado por sus padres al espacio debido a la inminente destrucción del planeta donde viven. La nave aterriza en la Tierra, y el niño es adoptado por unos', 143, 55000000, 300500000, '1978-12-14', 'US', '', 364.609, 7.134, 3642, 'https://image.tmdb.org/t/p/original/v6MVBFnQOscITvmAy5N5ras2JKZ.jpg', 'https://image.tmdb.org/t/p/original/pS4i2L1kUERAd6bm8j14uke7Apx.jpg', ''),
(7451, 'xXx', 'Xander Cage es XXX, un antiguo ganador de X-Games y atleta profesional de deportes de extremo, que sobrevive vendiendo videos de sus increíbles hazañas, las cuales hacen emitir adrenalina por todo el ', 124, 70000000, 277500000, '2002-08-09', 'US', '', 470.334, 5.933, 4031, 'https://image.tmdb.org/t/p/original/qwK9soQmmJ7kRdjLZVXblw3g7AQ.jpg', 'https://image.tmdb.org/t/p/original/ewGhwS8dbAfFDJBEpbsWOuwS4Ov.jpg', ''),
(9482, 'Juez Dredd', 'En el año 2139, la humanidad vive envuelta en una permanente violencia. Sin embargo, en MegaCity Uno, una de las tres megaciudades que existen en Estados Unidos, hay un hombre dispuesto a luchar contr', 96, 90000000, 113493000, '1995-06-30', 'US', '', 321.769, 5.794, 2305, 'https://image.tmdb.org/t/p/original/baJHUXBcoaHnMf2sjwegbuhIjEV.jpg', 'https://image.tmdb.org/t/p/original/9sw2Z9V0E0NxRvJY3cRxF5jQtko.jpg', ''),
(10138, 'Iron Man 2', 'El mundo sabe que el multimillonario Tony Stark es Iron Man, el superhéroe enmascarado. Sometido a presiones por parte del gobierno, la prensa y la opinión pública para que comparta su tecnología con ', 125, 200000000, 623933000, '2010-04-28', 'US', '', 424.995, 6.84, 20418, 'https://image.tmdb.org/t/p/original/7lmBufEG7P7Y1HClYK3gCxYrkgS.jpg', 'https://image.tmdb.org/t/p/original/ayyJVOV5I4MGjti7nIHC3mVCagR.jpg', ''),
(16320, 'Serenity', 'Siglo XXVI. Tras ganar la guerra Civil Galáctica, las dos grandes potencias mundiales, EE.UU. y China, se unen para formar un gobierno totalitario llamado Alianza Universal. El Capitán Malcolm Reynold', 119, 39000000, 38869500, '2005-09-25', 'US', '', 372.93, 7.4, 3346, 'https://image.tmdb.org/t/p/original/csGprKcRxt7SDpsrKiwxpgLdEsx.jpg', 'https://image.tmdb.org/t/p/original/zD81lzAEsTeEDl8f1C6t4USRihg.jpg', ''),
(43074, 'Cazafantasmas', 'Manhattan, Nueva York. Después de casi treinta años sin saber de ellos, los fantasmas y demonios se han vuelto a escapar de los infiernos para destruir la ciudad. Esta vez un nuevo equipo de Cazafanta', 116, 144000000, 229148000, '2016-07-14', 'US', '', 469.556, 5.358, 6201, 'https://image.tmdb.org/t/p/original/3RWsSQlqzRjsuqSRmoyggy74UA7.jpg', 'https://image.tmdb.org/t/p/original/gG8Tv060zoUwmeGEk8lGBULO9hw.jpg', ''),
(49047, 'Gravity', 'Durante un paseo espacial rutinario, dos astronautas sufren un grave accidente y quedan flotando en el espacio. Una es la doctora Ryan Stone, una brillante ingeniera en su primera misión espacial en l', 93, 105000000, 723193000, '2013-10-03', 'US', 'http://gravitymovie.warnerbros.com', 358.129, 7.164, 14912, 'https://image.tmdb.org/t/p/original/a2n6bKD7qhCPCAEALgsAhWOAQcc.jpg', 'https://image.tmdb.org/t/p/original/3CKbEXrw88LNvBU3baISh1I7JP4.jpg', ''),
(68730, 'Silencio', 'Dos sacerdotes jesuitas, Sebastião Rodrigues y Francisco Garupe, viajan al Japón del siglo XVII que, bajo el shogunato Tokugawa, prohibió el catolicismo y casi todos los contactos extranjeros. Allí so', 159, 46000000, 23700000, '2016-12-22', 'US', '', 315.172, 7.123, 2954, 'https://image.tmdb.org/t/p/original/2tE0A6WjLowwQOUY8se1Xlf3O6U.jpg', 'https://image.tmdb.org/t/p/original/jZxSqam9PImEIDXtD3HIKPwmd9K.jpg', ''),
(126889, 'Alien: Covenant', 'Rumbo a un remoto planeta al otro lado de la galaxia, la tripulación de la nave colonial Covenant descubre lo que creen que es un paraíso inexplorado, pero resulta tratarse de un mundo oscuro y hostil', 122, 97000000, 240892000, '2017-05-09', 'US', '', 367.4, 6.105, 8175, 'https://image.tmdb.org/t/p/original/2qluV8y79LnBBHaMpwewCjQ1Htk.jpg', 'https://image.tmdb.org/t/p/original/245tgZ3mTHWs0NRiPSwPjKobKHf.jpg', ''),
(157336, 'Interstellar', 'Narra las aventuras de un grupo de exploradores que hacen uso de un agujero de gusano recientemente descubierto para superar las limitaciones de los viajes espaciales tripulados y vencer las inmensas ', 169, 165000000, 701729000, '2014-11-05', 'US', 'https://www.warnerbros.co.uk/movies/interstellar', 361.411, 8.434, 34272, 'https://image.tmdb.org/t/p/original/xJHokMbljvjADYdit5fK5VQsXEG.jpg', 'https://image.tmdb.org/t/p/original/nrSaXF39nDfAAeLKksRCyvSzI2a.jpg', ''),
(284052, 'Doctor Strange', 'La vida del famoso neurocirujano Stephen Strange cambia radicalmente cuando un accidente le impide el uso de sus manos y se ve forzado a buscar una cura en un misterioso enclave. Inmediatamente aprend', 115, 180000000, 676343000, '2016-10-25', 'US', '', 338.907, 7.423, 21556, 'https://image.tmdb.org/t/p/original/3zvZ699gMW2RhWc0GisIukzq0Ls.jpg', 'https://image.tmdb.org/t/p/original/wJEZI3PWyMW7qcW6n9jyCh7Cclf.jpg', ''),
(284053, 'Thor: Ragnarok', 'Thor está preso al otro lado del universo sin su poderoso martillo y se enfrenta a una carrera contra el tiempo. Su objetivo es volver a Asgard y parar el Ragnarok porque significaría la destrucción d', 131, 180000000, 855302000, '2017-10-02', 'US', '', 458.693, 7.6, 20180, 'https://image.tmdb.org/t/p/original/kaIfm5ryEOwYg8mLbq8HkPuM1Fo.jpg', 'https://image.tmdb.org/t/p/original/pGtkLdk4rnF2A3Yz2BHiTgRwMU4.jpg', ''),
(297762, 'Wonder Woman', 'Diana, princesa de las Amazonas, entrenada para ser una guerrera invencible, fue criada en una isla paradisíaca protegida, hasta que un día, un piloto norteamericano, que tuvo un accidente y acabó en ', 141, 149000000, 823971000, '2017-05-30', 'US', '', 431.292, 7.229, 19491, 'https://image.tmdb.org/t/p/original/6iUNJZymJBMXXriQyFZfLAKnjO6.jpg', 'https://image.tmdb.org/t/p/original/js7cN75bbBnNeQScT0jTRfIkTAa.jpg', ''),
(298618, 'Flash', 'Flash, el héroe más rápido, viaja a una línea temporal en que la Tierra está en crisis y sus héroes perdidos o dispersados.', 144, 220000000, 271333000, '2023-06-13', 'US', '', 430.158, 6.744, 3862, 'https://image.tmdb.org/t/p/original/yF1eOkaYvwiORauRCPWznV9xVvi.jpg', 'https://image.tmdb.org/t/p/original/x9Qc86JEyYkAKsdzjDpS5kbaAB7.jpg', ''),
(299536, 'Vengadores: Infinity War', 'El todopoderoso Thanos ha despertado con la promesa de arrasar con todo a su paso, portando el Guantelete del Infinito, que le confiere un poder incalculable. Los únicos capaces de pararle los pies so', 156, 300000000, 2052410000, '2018-04-25', 'US', '', 359.109, 8.247, 28841, 'https://image.tmdb.org/t/p/original/mDfJG3LC3Dqb67AZ52x3Z0jU0uB.jpg', 'https://image.tmdb.org/t/p/original/ksBQ4oHQDdJwND8H90ay8CbMihU.jpg', ''),
(299537, 'Capitana Marvel', 'La historia sigue a Carol Danvers mientras se convierte en uno de los héroes más poderosos del universo, cuando la Tierra se encuentra atrapada en medio de una guerra galáctica entre dos razas alieníg', 125, 152000000, 1131420000, '2019-03-06', 'US', '', 427.148, 6.824, 15246, 'https://image.tmdb.org/t/p/original/qAzYK4YPSWDc7aa4R43LcwRIAyb.jpg', 'https://image.tmdb.org/t/p/original/5SPa7dZ85p54xa7E9tHRmfKq5ce.jpg', ''),
(329865, 'La llegada', 'Unas misteriosas naves espaciales aterrizan por todo el mundo. Un equipo, liderado por la lingüista Louise Banks, intenta descifrar el motivo de su visita. A medida que la humanidad se tambalea al bor', 116, 47000000, 203388000, '2016-11-10', 'US', '', 349.137, 7.602, 17234, 'https://image.tmdb.org/t/p/original/iTyh3hqTUjiRqQo8Uz1w1KtQti9.jpg', 'https://image.tmdb.org/t/p/original/tbVITeytclB4JKx2LxxasrCCmZx.jpg', ''),
(346698, 'Barbie', 'Barbie vive en Barbieland donde todo es ideal y lleno de música y color. Un buen día decide conocer el mundo real. Cuando el CEO de Mattel se entere, tratará de evitarlo a toda costa y devolver a Barb', 114, 145000000, 1445640000, '2023-07-19', 'US', 'https://www.warnerbros.es/peliculas/barbie', 469.812, 7.068, 8185, 'https://image.tmdb.org/t/p/original/ctMserH8g2SeOAnCw5gFjdQF8mo.jpg', 'https://image.tmdb.org/t/p/original/fNtqD4BTFj0Bgo9lyoAtmNFzxHN.jpg', ''),
(359410, 'Road House (De profesión: duro)', 'Dalton es un exluchador de la UFC en horas bajas que acepta un trabajo como portero en un conflictivo bar de carretera de los Cayos de Florida, sólo para descubrir que este paraíso no es todo lo que p', 114, 85000000, 0, '2024-03-08', 'US', 'https://www.primevideo.com/detail/0O70LSZ5KT12QBNQRUQGGRIWDP/ref=atv_nb_lcl_es_ES?ie=UTF8&language=es_ES', 507.256, 7.02, 1689, 'https://image.tmdb.org/t/p/original/oe7mWkvYhK4PLRNAVSvonzyUXNy.jpg', 'https://image.tmdb.org/t/p/original/wmnVOIaTsGcRpZ9rLv2msbtqi3C.jpg', ''),
(378018, 'El vacío', 'Un policía traslada a un hombre herido a un pequeño hospital, y la violencia no tarda en desatarse. Los pocos médicos y pacientes que hay se ven rodeados por unos encapuchados y amenazados por una ext', 85, 0, 151042, '2016-09-22', 'CA', '', 321.866, 5.942, 1160, 'https://image.tmdb.org/t/p/original/oZwwwezJFlHmQGBRJDLmENXwOIt.jpg', 'https://image.tmdb.org/t/p/original/h3lw4MBYQajGaMPu5jokE4QNASn.jpg', ''),
(381288, 'Múltiple', 'A pesar de que Kevin le ha demostrado a su psiquiatra de confianza, la Dra. Fletcher, que posee 23 personalidades diferentes, aún queda una por emerger, decidida a dominar a todas las demás. Obligado ', 117, 9000000, 278454000, '2017-01-19', 'US', '', 367.154, 7.343, 16866, 'https://image.tmdb.org/t/p/original/9pkZesKMnblFfKxEhQx45YQ2kIe.jpg', 'https://image.tmdb.org/t/p/original/Ag51YF1ZTNTefjhVMVGBCFv8h5s.jpg', ''),
(385687, 'Fast & Furious X', 'Durante numerosas misiones más que imposibles, Dom Toretto y su familia han sido capaces de ser más listos, de tener más valor y de ir más rápido que cualquier enemigo que se cruzara con ellos. Pero a', 141, 340000000, 704710000, '2023-05-17', 'US', 'https://www.universalpictures.es/micro/fast-y-furious-x', 551.854, 7.124, 5132, 'https://image.tmdb.org/t/p/original/4XM8DUTQb3lhLemJC51Jx4a2EuA.jpg', 'https://image.tmdb.org/t/p/original/x3zlm6VxPvVrYWE3bHkYUQMR798.jpg', ''),
(395990, 'El justiciero', 'Paul Kersey (Bruce Willis) es un famoso cirujano que vive con su familia en Nueva York. Un día, su esposa (Elisabeth Shue) y su hija (Camila Morrone) son brutalmente atacadas en su casa. Paul, que sie', 107, 30000000, 34017000, '2018-03-02', 'US', '', 309.285, 6.157, 2467, 'https://image.tmdb.org/t/p/original/uQqQvmptJLPTcWDrZXn22p7j7s3.jpg', 'https://image.tmdb.org/t/p/original/3hkImCSIM8ROpTSA8EF2joYdBNd.jpg', ''),
(399170, 'La suerte de los Logan', 'Jimmy está desempleado, divorciado y no tiene un duro, Clyde perdió un brazo en la guerra de Irak y ahora trabaja de camarero en un antro, y Mellie es una peluquera obsesionada con los coches, los tre', 119, 29000000, 48453600, '2017-08-17', 'US', '', 305.19, 6.73, 3359, 'https://image.tmdb.org/t/p/original/d3Y9L11tgnYIKhAaRWfbaKGCjcM.jpg', 'https://image.tmdb.org/t/p/original/6oRcVB1iFwfFkbL6qSgZYTxxpI7.jpg', ''),
(414906, 'Batman', 'Cuando un asesino se dirige a la élite de Gotham con una serie de maquinaciones sádicas, un rastro de pistas crípticas envía Batman a una investigación en los bajos fondos. A medida que las pruebas co', 176, 185000000, 771000000, '2022-03-01', 'US', 'https://www.warnerbros.es/peliculas/batman', 498.104, 7.7, 9521, 'https://image.tmdb.org/t/p/original/b0PlSFdDwbyK0cf5RxwDpaOJQvQ.jpg', 'https://image.tmdb.org/t/p/original/mo7teil1qH0SxgLijnqeYP1Eb4w.jpg', ''),
(424139, 'La noche de Halloween', 'Jamie Lee Curtis regresa a su papel icónico como Laurie Strode, quien llega a su enfrentamiento final con Michael Myers, la figura enmascarada que la ha perseguido desde que escapó por poco de su juer', 109, 10000000, 259900000, '2018-10-18', 'US', '', 337.081, 6.554, 4523, 'https://image.tmdb.org/t/p/original/tZ358Wk4BnOc4FjdGsiexAUvCMH.jpg', 'https://image.tmdb.org/t/p/original/xbniRigN0Ao3KjH8ha7yySK1g2B.jpg', ''),
(438631, 'Dune', 'En un lejano futuro, la galaxia conocida es gobernada mediante un sistema feudal de casas nobles bajo el mandato del Emperador. Las alianzas y la política giran entorno a un pequeño planeta, Dune,  de', 155, 165000000, 407574000, '2021-09-15', 'US', 'https://www.warnerbros.es/peliculas/dune', 552.559, 7.779, 11536, 'https://image.tmdb.org/t/p/original/lzWHmYdfeFiMIY4JaMmtR7GEli3.jpg', 'https://image.tmdb.org/t/p/original/hIEKzq0klqtz1H3S7QxzH4mMbvT.jpg', ''),
(490132, 'Green Book', 'Años 60. Cuando Tony Lip, un rudo italoamericano del Bronx, es contratado como chófer del virtuoso pianista negro Don Shirley durante una gira de conciertos por el Sur de Estados Unidos, deberá confia', 130, 23000000, 319700000, '2018-11-16', 'US', '', 362.982, 8.244, 11158, 'https://image.tmdb.org/t/p/original/2Xe9lISpwXKhvKiHttbFfVRERQX.jpg', 'https://image.tmdb.org/t/p/original/od2A7qPtpimcYfqfKXkpHqoKyuS.jpg', ''),
(526896, 'Morbius', 'Peligrosamente enfermo de un extraño trastorno sanguíneo, y determinado a salvar a otras personas que padecen su mismo destino, el doctor Morbius intenta una apuesta desesperada. Lo que en un principi', 109, 75000000, 167636000, '2022-03-30', 'US', 'https://www.sonypictures.es/peliculas/morbius', 353.029, 6.044, 4071, 'https://image.tmdb.org/t/p/original/gG9fTyDL03fiKnOpf2tr01sncnt.jpg', 'https://image.tmdb.org/t/p/original/4jcJHqIVsb4MFdYrDajXeEVlDvH.jpg', ''),
(577922, 'Tenet', 'Armado solamente con una palabra, Tenet, el protagonista deberá luchar por la supervivencia del mundo entero y evitar la Tercera Guerra Mundial, en una historia de espionaje internacional. La misión s', 155, 205000000, 365304000, '2020-08-22', 'US', 'https://www.warnerbros.es/peliculas/tenet/', 423.726, 7.2, 9359, 'https://image.tmdb.org/t/p/original/yY76zq9XSuJ4nWyPDuwkdV7Wt0c.jpg', 'https://image.tmdb.org/t/p/original/buSr2RIxzJ5Zh6dLaLBsqAdvz3I.jpg', ''),
(601796, 'Alienoid', '‎Los gurús de finales de la dinastía Goryeo intentan obtener una espada legendaria y sagrada, y los humanos en 2022 persiguen a un prisionero alienígena que está encerrado en el cuerpo de un humano. L', 142, 24500000, 12600000, '2022-07-20', 'KR', '', 566.891, 6.815, 314, 'https://image.tmdb.org/t/p/original/7ZP8HtgOIDaBs12krXgUIygqEsy.jpg', 'https://image.tmdb.org/t/p/original/dwh2pqqWobsOmnDFsJkiLRLBQ94.jpg', ''),
(609681, 'The Marvels', 'Cuando sus obligaciones la envían a un agujero de gusano vinculado a un revolucionario kree, los poderes de Carol Danvers, la capitana Marvel, se entremezclan con los de Kamala Khan, también conocida ', 105, 274800000, 207090000, '2023-11-08', 'US', '', 379.217, 6.157, 2265, 'https://image.tmdb.org/t/p/original/w4pRLYYbhHn3sh9kqRgPZM6GjyS.jpg', 'https://image.tmdb.org/t/p/original/vpuuFM032yiX8tox4L84Wl9MGjG.jpg', ''),
(615777, 'Babylon', 'Ambientada en Los Angeles durante los años 20, cuenta una historia de ambición y excesos desmesurados que recorre la ascensión y caída de múltiples personajes durante una época de desenfrenada decaden', 188, 78000000, 63363600, '2022-12-22', 'US', '', 343.95, 7.412, 2779, 'https://image.tmdb.org/t/p/original/oCKZAdUROqdlTcUOstqJ1gM8JQt.jpg', 'https://image.tmdb.org/t/p/original/oLZULW6Kn5imFM427tWfqIPMLmP.jpg', ''),
(617127, 'Blade', 'Película protagonizada por Mahershala Ali, encarnando a Blade, el famoso cazavampiros de Marvel Comics, creado por el escritor Marv Wolfman y el dibujante Gene Colan, su primera aparición fue en el co', 0, 0, 0, '2025-11-05', 'US', '', 321.996, 0, 0, 'https://image.tmdb.org/t/p/original/hFtJz4TvoiJJcw2ZOMdhK22aU9P.jpg', 'https://image.tmdb.org/t/p/original/fKqA4rgVJwrM7Gb3tQ9TGHnu8Tr.jpg', ''),
(618588, 'Arthur', 'Mikael Lindnord, el capitán del equipo sueco de atletismo de aventura, tuvo un extraño encuentro durante la carrera de 400 millas en la jungla ecuatoriana, cuando en su camino se cruzó un perro callej', 107, 19000000, 31649900, '2024-03-15', 'US', '', 435.311, 6.879, 107, 'https://image.tmdb.org/t/p/original/vTlK3chwsEToSoQJYUcJaHlNhIf.jpg', 'https://image.tmdb.org/t/p/original/q1DDwFuWeQlwR0lcjFiEsM8iRkd.jpg', ''),
(634492, 'Madame Web', 'Cassandra Webb es una paramédica en Manhattan que podría tener habilidades clarividentes. Obligada a enfrentarse a sucesos que se han revelado de su pasado, crea una relación con tres jóvenes destinad', 116, 80000000, 100299000, '2024-02-14', 'US', '', 543.913, 5.611, 1231, 'https://image.tmdb.org/t/p/original/pwGmXVKUgKN13psUjlhC9zBcq1o.jpg', 'https://image.tmdb.org/t/p/original/blq050GHBt0Fzx1j9FvohaEuknJ.jpg', ''),
(653346, 'El reino del planeta de los simios', 'Ambientada varias generaciones en el futuro tras el reinado de César, en la que los simios son la especie dominante que vive en armonía y los humanos se han visto reducidos a vivir en la sombra. Mient', 145, 0, 0, '2024-05-08', 'US', '', 1291, 7.1, 31, 'https://image.tmdb.org/t/p/original/fypydCipcWDKDTTCoPucBsdGYXW.jpg', 'https://image.tmdb.org/t/p/original/r8L3fUvftNeqPMCITdXJfiXbFBU.jpg', ''),
(693134, 'Dune: Parte dos', 'Sigue el viaje mítico de Paul Atreides mientras se une a Chani y los Fremen en una guerra de venganza contra los conspiradores que destruyeron a su familia. Al enfrentarse a una elección entre el amor', 167, 190000000, 704300000, '2024-02-27', 'US', '', 1270.02, 8.215, 3714, 'https://image.tmdb.org/t/p/original/xOMo8BRK7PfcJv9JCnx7s5hj0PX.jpg', 'https://image.tmdb.org/t/p/original/9rk0NJXs1izgJPZwbkSrkiVFWMQ.jpg', ''),
(699280, 'Becoming', 'Únase a la ex primera dama Michelle Obama en un documental íntimo que analiza su vida, esperanzas y conexión con los demás mientras gira con \"Becoming\".', 89, 0, 0, '2020-05-06', 'US', '', 363.936, 7.4, 146, 'https://image.tmdb.org/t/p/original/l6trIrFvJbQIvHYpaFCKuwqLUbS.jpg', 'https://image.tmdb.org/t/p/original/f0vo1yoEVlbpJ0Fkn0FgU7dTrO8.jpg', ''),
(746036, 'El especialista', 'Es un doble de acción, y al igual que todos en la comunidad de especialistas, sale volando, le disparan, se estrella, se tira desde ventanas y cae desde las alturas más extremas, todo para nuestro ent', 126, 125000000, 65403000, '2024-04-24', 'US', 'https://www.universalpictures.es/micro/el-especialista', 381.401, 7.4, 267, 'https://image.tmdb.org/t/p/original/1jj4HXkx0pvEYhISYqktADYAITJ.jpg', 'https://image.tmdb.org/t/p/original/ceiGl0SNZpR01o5lfYImt2QgKuq.jpg', ''),
(748783, 'Garfield: La película', 'El mundialmente famoso Garfield, el gato casero que odia los lunes y que adora la lasaña, está a punto de vivir una aventura ¡en el salvaje mundo exterior! Tras una inesperada reunión con su largament', 101, 0, 22000000, '2024-04-30', 'US', 'https://www.sonypictures.es/pelicula/garfield', 722.214, 6.5, 47, 'https://image.tmdb.org/t/p/original/v5XyXZe8FADw8iHupB4L7QOAwH9.jpg', 'https://image.tmdb.org/t/p/original/6QR2FOCQr41gSduN70WulRIhJb7.jpg', ''),
(763215, 'Damsel', 'La boda de una joven con un príncipe encantador se convierte en una encarnizada lucha por sobrevivir cuando la ofrecen como sacrificio a una dragona escupefuego.', 110, 60000000, 5000, '2024-03-07', 'US', 'https://www.netflix.com/es/title/80991090', 299.808, 7.138, 1745, 'https://image.tmdb.org/t/p/original/deLWkOLZmBNkm8p16igfapQyqeq.jpg', 'https://image.tmdb.org/t/p/original/6tJWxRfBKWGIPFkfLTod2CgCexU.jpg', ''),
(784651, 'Fighter', '', 160, 30069500, 43160600, '2024-01-24', 'IN', '', 449.619, 5.287, 68, 'https://image.tmdb.org/t/p/original/keVfqCMKmJ55nHzmqR2Q5K7LwJt.jpg', 'https://image.tmdb.org/t/p/original/fy7cDkhCAER6a1i3SAiVvyLx5oO.jpg', ''),
(787699, 'Wonka', 'Basada en el personaje que protagoniza \"Charlie y la fábrica de chocolate\", el libro infantil más emblemático de Roald Dahl y uno de los más vendidos de todos los tiempos, \"Wonka\" cuenta la historia d', 117, 125000000, 632302000, '2023-12-06', 'GB', '', 355.855, 7.186, 2940, 'https://image.tmdb.org/t/p/original/yyFc8Iclt2jxPmLztbP617xXllT.jpg', 'https://image.tmdb.org/t/p/original/6eHcR7zwvNSvkOl9jbctU0lvZQ1.jpg', ''),
(821937, '578: Phát Đạn Của Kẻ Điên', '', 108, 0, 0, '2022-05-20', 'VN', '', 614.202, 5.3, 30, 'https://image.tmdb.org/t/p/original/6a3aiSYNqABoV1Fq8n10LMOBxhH.jpg', 'https://image.tmdb.org/t/p/original/cPTphSqJ0dF0EPeeAR1qeeNbMPV.jpg', ''),
(823464, 'Godzilla y Kong: El nuevo imperio', 'Una aventura cinematográfica completamente nueva, que enfrentará al todopoderoso Kong y al temible Godzilla contra una colosal amenaza desconocida escondida dentro de nuestro mundo. La nueva y épica p', 115, 150000000, 546504000, '2024-03-27', 'US', '', 1506.77, 6.488, 977, 'https://image.tmdb.org/t/p/original/qrGtVFxaD8c7et0jUtaYhyTzzPg.jpg', 'https://image.tmdb.org/t/p/original/2YqZ6IyFk7menirwziJvfoVvSOh.jpg', ''),
(843527, 'La idea de tenerte', 'Solène, madre soltera de 40 años, comienza un romance inesperado con Hayes Campbell, de 24 años, el cantante principal de August Moon, la banda de chicos más popular del planeta.', 116, 0, 0, '2024-05-02', 'US', '', 1204.22, 7.584, 421, 'https://image.tmdb.org/t/p/original/sI6uCeF8mUlZx22mFfHSi9W3XQ9.jpg', 'https://image.tmdb.org/t/p/original/heci4aAOBfN5I2BQ1QpVFE2o5qi.jpg', ''),
(844185, 'Sin edulcorar', 'Cuando la leche y los cereales eran los reyes del desayuno, un nuevo bollo iba a desatar una implacable batalla comercial.', 97, 0, 0, '2024-04-30', 'US', 'https://www.netflix.com/es/title/81481606', 359.297, 5.325, 97, 'https://image.tmdb.org/t/p/original/pyCS2FWvTOTsLq4qCOsdsQY7hbZ.jpg', 'https://image.tmdb.org/t/p/original/c6S4MbZQvI3XVyPOctaYJjCj07b.jpg', ''),
(845111, 'Los tres mosqueteros: Milady', 'Desde el museo del Louvre al Palacio de Buckingham, pasando por las alcantarillas de París al asedio de La Rochelle... En un reino dividido por guerras religiosas y bajo la amenaza constante de la inv', 121, 39000000, 21730800, '2023-12-13', 'FR', '', 565.396, 6.509, 383, 'https://image.tmdb.org/t/p/original/qGJASuD3fs9ZBxuEZoxCLVidVq8.jpg', 'https://image.tmdb.org/t/p/original/cxttOyp3kVIuR86bUOLOcfkYpYN.jpg', ''),
(850888, 'Sayen: La cazadora', 'El thriller lleno de acción sigue el viaje de Sayen, una mujer mapuche que descubre una peligrosa conspiración liderada por una corporación internacional que está destruyendo la tierra de su familia y', 88, 0, 0, '2024-04-26', 'CL', '', 732.881, 6.587, 23, 'https://image.tmdb.org/t/p/original/AuTfo1lbE8s2Y8RVTmlbJAeLWPK.jpg', 'https://image.tmdb.org/t/p/original/btmngK5iXaxyAEl0ScIWCQG2ITr.jpg', ''),
(865921, 'Return of Special Forces V', 'Long Wei, que acaba de poner fin a una cruenta guerra en un país extranjero, recibe un mensaje de socorro de su ex esposa Leng Yun, que no se había puesto en contacto con él desde hacía diez años.', 97, 0, 0, '2021-07-10', 'CN', '', 440.716, 6, 1, '', 'https://image.tmdb.org/t/p/original/4wn6jJL6rC8NYJCNgC4kmI1xOb8.jpg', ''),
(872585, 'Oppenheimer', 'Película sobre el físico J. Robert Oppenheimer y su papel como desarrollador de la bomba atómica. Basada en el libro \'American Prometheus: The Triumph and Tragedy of J. Robert Oppenheimer\' de Kai Bird', 181, 100000000, 952000000, '2023-07-19', 'US', '', 642.477, 8.103, 7934, 'https://image.tmdb.org/t/p/original/nb3xI8XI3w4pMVZ38VijbsyBqP4.jpg', 'https://image.tmdb.org/t/p/original/ncKCQVXgk4BcQV6XbvesgZ2zLvZ.jpg', ''),
(920342, 'Monster\'s Battlefield', 'Un científico fusiona genes de bestias misteriosas y da vida a una criatura tipo dragón.', 83, 0, 0, '2021-12-27', 'CN', '', 1106.15, 3, 1, 'https://image.tmdb.org/t/p/original/7kQvHmGyKJv2wSKVfCUux50rd7A.jpg', 'https://image.tmdb.org/t/p/original/nBVYp2xxx2R02n21EGlDky8CgWR.jpg', ''),
(929590, 'Civil War', 'En un futuro cercano donde América está sumida en una cruenta guerra civil, un equipo de periodistas y fotógrafos de guerra emprenderá un viaje por carretera en dirección a Washington DC. Su misión: l', 109, 50000000, 95684700, '2024-04-10', 'GB', '', 528.536, 7.4, 610, 'https://image.tmdb.org/t/p/original/uv2twFGMk2qBdyJBJAVcrpRtSa9.jpg', 'https://image.tmdb.org/t/p/original/qDU7PMMVMxtFI5w95mXS3BjpODG.jpg', ''),
(934632, 'Rebel Moon (Parte Dos): La Guerrera Que Deja Marcas', 'Los rebeldes se preparan para luchar contra las implacables fuerzas del Mundomadre mientras se forjan vínculos inquebrantables, surgen nuevos héroes y nacen las leyendas.', 123, 83000000, 0, '2024-04-19', 'US', 'https://www.netflix.com/es/title/81624666', 914.7, 6.12, 682, 'https://image.tmdb.org/t/p/original/tpiqEVTLRz2Mq7eLq5DT8jSrp71.jpg', 'https://image.tmdb.org/t/p/original/ivhOeG5S2CzKjcKhureKAtfonHg.jpg', ''),
(935271, 'After the Pandemic', 'Ambientado en un mundo postapocalíptico donde una pandemia global transmitida por el aire ha acabado con el 90% de la población de la Tierra y solo los jóvenes e inmunes han sobrevivido como carroñero', 84, 0, 0, '2022-03-01', 'US', '', 311.017, 4.8, 57, 'https://image.tmdb.org/t/p/original/9c0lHTXRqDBxeOToVzRu0GArSne.jpg', 'https://image.tmdb.org/t/p/original/cboUHkM1zA7m3SaCrf6dW5jGqqW.jpg', ''),
(938614, 'Late Night with the Devil', 'Una transmisión de televisión en vivo en 1977 sale terriblemente mal, desatando el mal en las salas de estar de la nación.', 93, 2000000, 11006700, '2024-03-19', 'US', '', 347.362, 7.4, 300, 'https://image.tmdb.org/t/p/original/4yrOyO3N55XazHQXXYoqiiPQd40.jpg', 'https://image.tmdb.org/t/p/original/x7phbLV4IpiOo3P8GUoGpz9Pjw0.jpg', ''),
(940551, 'Migración. Un viaje patas arriba', 'La familia Mallard se ha quedado \'estancada\'. Mientras papá Mack se siente realizado cuidando de su familia en su estanque de Nueva Inglaterra, mamá Pam se muere de ganas de vivir la vida y hacer desc', 83, 72000000, 297405000, '2023-12-06', 'US', 'https://www.universalpictures.es/micro/migracion', 572.486, 7.477, 1302, 'https://image.tmdb.org/t/p/original/2KGxQFV9Wp1MshPBf8BuqWUgVAz.jpg', 'https://image.tmdb.org/t/p/original/diEeiB2DmZZadHISkg24RO2n0rT.jpg', ''),
(940721, 'Godzilla Minus One', 'En el Japón de la posguerra surge un nuevo terror. ¿Podrán sobrevivir las personas devastadas... y mucho menos defenderse?', 125, 15000000, 115857000, '2023-11-03', 'JP', '', 2792.37, 7.807, 791, 'https://image.tmdb.org/t/p/original/bWIIWhnaoWx3FTVXv6GkYDv3djL.jpg', 'https://image.tmdb.org/t/p/original/q35kdC8ci9Fm2gVQazJdsohtGpD.jpg', ''),
(942047, 'Outsource', '', 102, 0, 0, '2022-01-18', 'AE', '', 330.684, 2.3, 11, 'https://image.tmdb.org/t/p/original/dcnSWFCtk4b2aIzkhq6IDbzoIf1.jpg', 'https://image.tmdb.org/t/p/original/fjnlNMmQxxtcfHbFfzbe2jDTnUa.jpg', ''),
(948549, 'Sangre en los labios', 'Jackie está decidida a triunfar como culturista y se dirige a Las Vegas para participar en una competición. En su camino, pasa por un pequeño pueblo de Nuevo México donde conoce a Lou, la solitaria ge', 104, 0, 8770950, '2024-03-08', 'US', 'http://www.avalon.me/distribucion/catalogo/sangre-en-los-labios', 376.436, 6.707, 145, 'https://image.tmdb.org/t/p/original/oMiKHO3H5RixfLsiU5Vumhlp5sj.jpg', 'https://image.tmdb.org/t/p/original/yEQKiZOVzVZquN7R6BRyY4n6JET.jpg', ''),
(967847, 'Cazafantasmas: Imperio helado', 'Después de los eventos de Oklahoma, el equipo de Cazafantasmas regresa a donde comenzó todo: ¡Nueva York! La historia de la familia Spengler continúa con un nuevo grupo de Cazafantasmas.', 115, 100000000, 195103000, '2024-03-20', 'US', '', 468.881, 6.543, 438, 'https://image.tmdb.org/t/p/original/5cCfqeUH2f5Gnu7Lh9xepY9TB6x.jpg', 'https://image.tmdb.org/t/p/original/fIUqk6Pjo3uf5RiOGT19KQ53ekq.jpg', ''),
(969492, 'Misión hostil', 'Kinney, un controlador de apoyo aéreo con poca experiencia, se incorpora a un equipo Delta Force en una misión en Filipinas. Cuando el equipo queda atrapado sin armas, las oportunidades de sobrevivir ', 113, 18000000, 6461950, '2024-01-25', 'AU', '', 378.185, 7.3, 704, 'https://image.tmdb.org/t/p/original/oBIQDKcqNxKckjugtmzpIIOgoc4.jpg', 'https://image.tmdb.org/t/p/original/syKwepJwzvoYhPLBfUy4YYSrstr.jpg', ''),
(976906, 'Spitfire Over Berlin', 'Agosto de 1944. Con la 8ª Fuerza Aérea Americana preparada para atacar sobre la Alemania Nazi, la Inteligencia Británica se entera de que podrían estar volando hacia una trampa mortal. Con solo horas ', 80, 0, 0, '2022-05-13', 'US', '', 530.834, 3.8, 18, 'https://image.tmdb.org/t/p/original/ilK1JRbMjo4sMJtNKLOKnqRf1RH.jpg', 'https://image.tmdb.org/t/p/original/syFEBhLY5rV9QlShUSphD134Rgx.jpg', ''),
(984324, 'El salario del miedo', 'Para salvar a cientos de personas de la explosión de un pozo petrolífero, un equipo de expertos emprende una peligrosa travesía por el desierto con una carga de nitroglicerina.', 107, 0, 0, '2024-03-28', 'FR', 'https://www.netflix.com/es/title/81654966', 366.703, 5.751, 217, 'https://image.tmdb.org/t/p/original/qekky2LbtT1wtbD5MDgQvjfZQ24.jpg', 'https://image.tmdb.org/t/p/original/li9PN0QuQRbilaX1XOBmmkst5DX.jpg', ''),
(1011985, 'Kung Fu Panda 4', 'Po se prepara para ser el líder espiritual del Valle de la Paz, buscando un sucesor como Guerrero Dragón. Mientras entrena a un nuevo practicante de kung fu, enfrenta al villano llamado \"el Camaleón\",', 94, 85000000, 520540000, '2024-03-02', 'US', '', 1096.62, 7.107, 1541, 'https://image.tmdb.org/t/p/original/kYgQzzjNis5jJalYtIHgrom0gOx.jpg', 'https://image.tmdb.org/t/p/original/zS8BSQdbOesql0EWbs17kPvLoAT.jpg', ''),
(1041613, 'Immaculate', 'Cecilia, una mujer de fe devota, recibe una calurosa bienvenida en la perfecta campiña italiana, donde se le ofrece un nuevo papel en un ilustre convento. Pero se vuelve más claro para Cecilia que su ', 89, 9000000, 22314900, '2024-03-20', 'US', '', 748.586, 6.2, 408, 'https://image.tmdb.org/t/p/original/5Eip60UDiPLASyKjmHPMruggTc4.jpg', 'https://image.tmdb.org/t/p/original/dFxjlcejJxSusT82UZl6QfVOgBA.jpg', ''),
(1063879, 'Vermin: La plaga', 'Kaleb está a punto de cumplir 30 años y nunca ha estado más solo. Está peleando con su hermana por un asunto de herencia y ha cortado los lazos con su mejor amigo. Apasionado por los animales exóticos', 106, 0, 2110010, '2023-12-27', 'FR', '', 502.839, 6.905, 173, 'https://image.tmdb.org/t/p/original/k0ucFBBgSDTXYU8fVHXJyjAuIIe.jpg', 'https://image.tmdb.org/t/p/original/iExe6Meo3xMYcSUQiH5UqXboPiY.jpg', ''),
(1094844, 'Ape vs. Mecha Ape', 'Al reconocer el poder destructivo de su gigante cautivo Ape, el ejército crea su propia IA lista para la batalla, Mecha Ape. Pero su primera prueba práctica sale terriblemente mal, y los militares no ', 80, 0, 0, '2023-03-24', 'US', '', 1203.81, 5.279, 129, 'https://image.tmdb.org/t/p/original/jnE1GA7cGEfv5DJBoU2t4bZHaP4.jpg', 'https://image.tmdb.org/t/p/original/ohlZkxCjQ8Ua3Up9TuH7gAVV9ZF.jpg', ''),
(1096197, 'Atrapados en el abismo', 'Esta película sigue a personajes de orígenes muy diferentes que se juntan cuando el avión en el que viajan se estrella en el Océano Pacífico. Cuando el avión se detiene peligrosamente cerca del borde ', 90, 0, 0, '2024-01-18', 'GB', '', 982.291, 6.403, 606, 'https://image.tmdb.org/t/p/original/4woSOUD0equAYzvwhWBHIJDCM88.jpg', 'https://image.tmdb.org/t/p/original/fSY6BYUZMObTIzPfRBlhuAb5lsd.jpg', ''),
(1105407, 'Damaged', '', 98, 0, 0, '2024-04-12', 'US', '', 493.559, 4.8, 76, 'https://image.tmdb.org/t/p/original/fUC5VsQcU3m6zmYMD96R7RqPuMn.jpg', 'https://image.tmdb.org/t/p/original/u3aPmYOkd8GclXg8nTvKQ4w1f7L.jpg', ''),
(1107387, 'Hachiko', 'Hachiko (Batong) es un lindo perro pastor chino. Conoce a su dueño Chen Jingxiu entre la gran multitud y se convierte en miembro de la familia Chen. Con el paso del tiempo, la casa que alguna vez fue ', 124, 0, 42423200, '2023-03-31', 'CN', '', 336.162, 7.5, 20, 'https://image.tmdb.org/t/p/original/kGWpaisyiOrOhkjn5FviMRUaoCb.jpg', 'https://image.tmdb.org/t/p/original/rpnZlagXNjWh6GUMmGosC5MHrYy.jpg', ''),
(1111873, 'Abigail', 'A una banda de delincuentes se les ha encargado secuestrar a Abigail, una bailarina de doce años hija de una poderosa figura del inframundo. Su misión requiere también vigilarla durante la noche para ', 109, 28000000, 28536300, '2024-04-18', 'US', '', 423.408, 7, 123, 'https://image.tmdb.org/t/p/original/ySgY4jBvZ6qchrxKnBg4M8tZp8V.jpg', 'https://image.tmdb.org/t/p/original/1wIp3yBijtgEpQrHZLqoX5laGLJ.jpg', ''),
(1209288, 'Liga de la Justicia: Crisis en Tierras Infinitas, parte 2', 'El Antimonitor (la contrapartida malvada del Monitor) se desata en el Multiverso DC y comienza a destruir las diferentes Tierras que lo componen. El Monitor intenta reclutar a héroes de todo el Multiv', 94, 0, 0, '2024-04-22', 'US', '', 353.231, 6.4, 59, 'https://image.tmdb.org/t/p/original/4G3qbrqCMI4rNOGJw0XEqP8Tn4p.jpg', 'https://image.tmdb.org/t/p/original/aOT8n3YOOkInZ5VHJN4FffHrm43.jpg', ''),
(1216299, 'La noche que volvimos a casa', 'En el oeste estadounidense de finales del siglo XIX, un grupo de forajidos nativos americanos aterroriza a los habitantes de un pequeño pueblo. Cuando un grupo de colonos decide luchar contra ellos, s', 105, 0, 0, '2024-01-12', 'US', '', 599.29, 5.833, 15, 'https://image.tmdb.org/t/p/original/v8RgWCgabyym0eVOuQJaxL4GS8p.jpg', 'https://image.tmdb.org/t/p/original/1G1t12Ac3Txxb1fMgIJBoZxEKVJ.jpg', ''),
(1219685, 'Un père idéal', '', 0, 0, 0, '2024-04-21', 'FR', '', 382.94, 0, 0, '', 'https://image.tmdb.org/t/p/original/4xJd3uwtL1vCuZgEfEc8JXI9Uyx.jpg', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_actor`
--

CREATE TABLE `pelicula_actor` (
  `id` int(11) NOT NULL,
  `personaje` varchar(100) DEFAULT NULL,
  `id_pelicula` int(11) DEFAULT NULL,
  `id_actor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula_categoria`
--

CREATE TABLE `pelicula_categoria` (
  `id` int(11) NOT NULL,
  `id_pelicula` int(11) DEFAULT NULL,
  `id_genero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula_categoria`
--

INSERT INTO `pelicula_categoria` (`id`, `id_pelicula`, `id_genero`) VALUES
(267, 940721, 878),
(268, 940721, 27),
(269, 940721, 28),
(270, 823464, 28),
(271, 823464, 878),
(272, 823464, 12),
(273, 653346, 878),
(274, 653346, 12),
(275, 653346, 28),
(276, 693134, 878),
(277, 693134, 12),
(278, 843527, 10749),
(279, 843527, 35),
(280, 1094844, 28),
(281, 1094844, 878),
(282, 920342, 878),
(283, 1011985, 16),
(284, 1011985, 28),
(285, 1011985, 10751),
(286, 1011985, 35),
(287, 1011985, 14),
(288, 1096197, 28),
(289, 1096197, 27),
(290, 1096197, 53),
(291, 934632, 878),
(292, 934632, 28),
(293, 934632, 18),
(294, 1041613, 27),
(295, 1041613, 9648),
(296, 1041613, 53),
(297, 850888, 28),
(298, 850888, 53),
(299, 748783, 16),
(300, 748783, 35),
(301, 748783, 10751),
(302, 872585, 18),
(303, 872585, 36),
(304, 821937, 28),
(305, 821937, 53),
(306, 1216299, 37),
(307, 1216299, 53),
(308, 1216299, 28),
(309, 940551, 16),
(310, 940551, 28),
(311, 940551, 12),
(312, 940551, 35),
(313, 940551, 10751),
(314, 601796, 878),
(315, 601796, 28),
(316, 601796, 14),
(317, 601796, 12),
(318, 845111, 12),
(319, 845111, 28),
(320, 845111, 18),
(321, 438631, 878),
(322, 438631, 12),
(323, 385687, 28),
(324, 385687, 80),
(325, 385687, 53),
(326, 634492, 28),
(327, 634492, 14),
(328, 976906, 10752),
(329, 976906, 28),
(330, 976906, 36),
(331, 929590, 10752),
(332, 929590, 28),
(333, 929590, 18),
(334, 359410, 28),
(335, 359410, 53),
(336, 1063879, 27),
(337, 414906, 80),
(338, 414906, 9648),
(339, 414906, 53),
(340, 1105407, 28),
(341, 1105407, 80),
(342, 1105407, 53),
(343, 7451, 28),
(344, 7451, 12),
(345, 7451, 53),
(346, 7451, 80),
(347, 346698, 35),
(348, 346698, 12),
(349, 43074, 28),
(350, 43074, 14),
(351, 43074, 35),
(352, 967847, 14),
(353, 967847, 12),
(354, 967847, 35),
(355, 284053, 28),
(356, 284053, 12),
(357, 284053, 878),
(358, 784651, 28),
(359, 784651, 53),
(360, 784651, 10752),
(361, 865921, 28),
(362, 618588, 18),
(363, 618588, 12),
(364, 297762, 28),
(365, 297762, 12),
(366, 297762, 14),
(367, 298618, 28),
(368, 298618, 12),
(369, 298618, 878),
(370, 11, 12),
(371, 11, 28),
(372, 11, 878),
(373, 299537, 28),
(374, 299537, 12),
(375, 299537, 878),
(376, 7451, 28),
(377, 7451, 12),
(378, 7451, 53),
(379, 7451, 80),
(380, 43074, 28),
(381, 43074, 14),
(382, 43074, 35),
(383, 967847, 14),
(384, 967847, 12),
(385, 967847, 35),
(386, 787699, 35),
(387, 787699, 10751),
(388, 787699, 14),
(389, 284053, 28),
(390, 284053, 12),
(391, 284053, 878),
(392, 126889, 878),
(393, 126889, 27),
(394, 126889, 9648),
(395, 609681, 878),
(396, 609681, 12),
(397, 609681, 28),
(398, 490132, 18),
(399, 490132, 36),
(400, 865921, 28),
(401, 942047, 28),
(402, 942047, 35),
(403, 297762, 28),
(404, 297762, 12),
(405, 297762, 14),
(406, 298618, 28),
(407, 298618, 12),
(408, 298618, 878),
(409, 11, 12),
(410, 11, 28),
(411, 11, 878),
(412, 299537, 28),
(413, 299537, 12),
(414, 299537, 878),
(415, 218, 28),
(416, 218, 53),
(417, 218, 878),
(418, 10138, 12),
(419, 10138, 28),
(420, 10138, 878),
(421, 577922, 28),
(422, 577922, 53),
(423, 577922, 878),
(424, 1111873, 27),
(425, 1111873, 53),
(426, 1111873, 35),
(427, 526896, 28),
(428, 526896, 878),
(429, 526896, 14),
(430, 329865, 18),
(431, 329865, 878),
(432, 329865, 9648),
(433, 1219685, 18),
(434, 1219685, 10770),
(435, 746036, 28),
(436, 746036, 35),
(437, 680, 53),
(438, 680, 80),
(439, 609681, 878),
(440, 609681, 12),
(441, 609681, 28),
(442, 969492, 28),
(443, 969492, 53),
(444, 969492, 10752),
(445, 948549, 80),
(446, 948549, 10749),
(447, 948549, 53),
(448, 16320, 878),
(449, 16320, 28),
(450, 16320, 12),
(451, 16320, 53),
(452, 106, 878),
(453, 106, 28),
(454, 106, 12),
(455, 106, 53),
(456, 141, 14),
(457, 141, 18),
(458, 141, 9648),
(459, 126889, 878),
(460, 126889, 27),
(461, 126889, 9648),
(462, 381288, 27),
(463, 381288, 53),
(464, 984324, 28),
(465, 984324, 53),
(466, 1924, 878),
(467, 1924, 28),
(468, 1924, 12),
(469, 699280, 99),
(470, 490132, 18),
(471, 490132, 36),
(472, 157336, 12),
(473, 157336, 18),
(474, 157336, 878),
(475, 844185, 35),
(476, 844185, 36),
(477, 299536, 12),
(478, 299536, 28),
(479, 299536, 878),
(480, 1700, 18),
(481, 1700, 53),
(482, 49047, 878),
(483, 49047, 53),
(484, 49047, 18),
(485, 1111873, 27),
(486, 1111873, 53),
(487, 1111873, 35),
(488, 526896, 28),
(489, 526896, 878),
(490, 526896, 14),
(491, 329865, 18),
(492, 329865, 878),
(493, 329865, 9648),
(494, 603, 28),
(495, 603, 878),
(496, 395990, 28),
(497, 395990, 80),
(498, 395990, 18),
(499, 395990, 53),
(500, 617127, 14),
(501, 284052, 28),
(502, 284052, 12),
(503, 284052, 14),
(504, 1209288, 16),
(505, 1209288, 878),
(506, 1209288, 28),
(507, 424139, 27),
(508, 424139, 53),
(509, 615777, 18),
(510, 615777, 35),
(511, 381288, 27),
(512, 381288, 53),
(513, 9482, 878),
(514, 1107387, 18),
(515, 1107387, 10751),
(516, 378018, 9648),
(517, 378018, 27),
(518, 378018, 878),
(519, 1219685, 18),
(520, 1219685, 10770),
(521, 935271, 878),
(522, 935271, 28),
(523, 68730, 18),
(524, 68730, 36),
(525, 399170, 35),
(526, 399170, 80),
(527, 399170, 28),
(528, 399170, 18),
(529, 763215, 14),
(530, 763215, 28),
(531, 763215, 12),
(532, 938614, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `foto_perfil` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lista_pelicula`
--
ALTER TABLE `lista_pelicula`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pelicula_actor`
--
ALTER TABLE `pelicula_actor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pelicula_categoria`
--
ALTER TABLE `pelicula_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista`
--
ALTER TABLE `lista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista_pelicula`
--
ALTER TABLE `lista_pelicula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pelicula_actor`
--
ALTER TABLE `pelicula_actor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pelicula_categoria`
--
ALTER TABLE `pelicula_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=533;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
