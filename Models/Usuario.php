<?php
require_once ("Conexion.php");

class Usuario {
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $ciudad;
    private string $fecha_nacimiento;
    private string $imagen;
    private string $rol;

    public function __construct($username, $email, $ciudad, $fecha_nacimiento, $imagen = "", $rol = "usuario", $password = "", $id = 0) {
        $this->username = $username;
        $this->email = $email;
        $this->ciudad = $ciudad;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->imagen = $imagen;
        $this->rol = $rol;
        $this->password = $password;
        $this->id = $id;
    }

    public static function insert_usuario($username, $email, $password, $ciudad, $fecha_nacimiento) {
        //$passwordHash = password_hash($usuario->getPassword(), PASSWORD_ARGON2I);
    }

    public static function update_usuario($id, $username, $email, $password, $ciudad, $fecha_nacimiento, $imagen) {

    }

    //HACER EN LISTAS DELETE LISTAS USUARIO.
    public static function delete_usuario($id) {
        
    }

    //GUARDAR $id y $username.
    public static function iniciar_sesion($username, $password) {
        $pdo = Conexion::connection_database();
        $usuario_existente = false;
        $credenciales = false;

        $stmt = $pdo->prepare("SELECT id, username, email, password FROM usuario");
        if ($stmt->execute()) {
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Si hay usuarios se recorre el array en busca de la coincidencia de username o email.
            if (count($usuarios) > 0) {
                foreach ($usuarios as $usuario) {
                    // Si el username o email coinciden se setea a true la variable de usuario existente.
                    if ($usuario["username"] == $username || $usuario["email"] == $username) {
                        // Si la contraseña también coincide se inicia la sesión con el id, username y email; y se setea la variable credenciales a true.
                        if (password_verify($usuario["password"], PASSWORD_ARGON2I)  == $password) {
                            session_start();
                            $_SESSION = array(
                                "id" => $usuario["id"],
                                "username" => $usuario["username"],
                                "email" => $usuario["email"],
                                "rol" => $usuario["rol"]
                            );

                            $credenciales = true;
                        }

                        $usuario_existente = true;
                        break;
                    }
                }
            }

            if ($usuario_existente && $credenciales) {
                return true;
            } else if ($usuario_existente && $credenciales == false) {
                return "La contraseña no coincide";
            } else if ($usuario_existente == false){
                return "No se ha encontrado ningún usuario con ese nombre";
            } 
        }
    }
    

    public static function escribir_comentario($id_pelicula) {
        
    }

    // Getters
    public function get_id(): int
    {
        return $this->id;
    }

    public function get_username(): string
    {
        return $this->username;
    }

    public function get_email(): string
    {
        return $this->email;
    }

    public function get_password(): string
    {
        return $this->password;
    }

    public function get_ciudad(): string
    {
        return $this->ciudad;
    }

    public function get_fecha_nacimiento(): string
    {
        return $this->fecha_nacimiento;
    }

    public function get_imagen(): string
    {
        return $this->imagen;
    }

    public function get_rol(): string
    {
        return $this->rol;
    }

    // Setters
    public function set_id(int $id): void
    {
        $this->id = $id;
    }

    public function set_username(string $username): void
    {
        $this->username = $username;
    }

    public function set_email(string $email): void
    {
        $this->email = $email;
    }

    public function set_password(string $password): void
    {
        $this->password = $password;
    }

    public function set_ciudad(string $ciudad): void
    {
        $this->ciudad = $ciudad;
    }

    public function set_fecha_nacimiento(string $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function set_imagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    public function set_rol(string $rol): void
    {
        $this->rol = $rol;
    }
}