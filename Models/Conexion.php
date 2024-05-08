<?php
    class Conexion {
        private static $server = "localhost";
        private static $db = "cinevista";
        private static $user = "root";
        private static $password = "";

        public static function connection_database(){
            try{
                $conexion = new PDO("mysql:host=" . Conexion::$server . ";
                                    dbname=" . Conexion::$db . ";
                                    charset=utf8", 
                                    Conexion::$user, 
                                    Conexion::$password);
            }catch(PDOException $error){
                echo "No se ha podido conectar con el servidor de la base de datos.";
                die("Error " . $error->getCode() . ": " . $error->getMessage());
            }    

            return $conexion;
        }
    }