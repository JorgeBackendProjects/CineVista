<?php
require_once ("Conexion.php");

class Usuario {
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $nombre;
    private string $imagen;
    private string $rol;

    public function __construct($username, $email, $nombre, $rol, $imagen = "", $password = "", $id = 0) {
        $this->username = $username;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
        $this->rol = $rol;
        $this->password = $password;
        $this->id = $id;
    }

    public static function insert_usuario($username, $email, $password, $nombre) {
        $pdo = Conexion::connection_database();
        $username_existente = false;
        $email_existente = false;

        // Se obtienen todos los usuarios de la base de datos para evitar que se repita el username o email.
        $stmt = $pdo->prepare("SELECT username, email, rol, password FROM usuario");
        if ($stmt->execute()) {
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Si hay usuarios se recorre el array en busca de la coincidencia de username o email.
            if (count($usuarios) > 0) {
                foreach ($usuarios as $usuario) {
                    // Si el username o email coinciden se setea a true la variable.
                    if ($usuario["username"] == $username) {
                        $username_existente = true;
                    }

                    if ($usuario["email"] == $email) {
                        $email_existente = true;
                    }
                }
            }

            // Si el username o email existen se devuelve un mensaje, en caso contrario se inserta el usuario y se devuelve un OK.
            if ($username_existente && $email_existente) {
                return "Ya existe un usuario registrado con el mismo username y email.";
            } else if ($username_existente) {
                return "Ya existe un usuario registrado con el mismo username.";
            } else if ($email_existente) {
                return "Ya existe un usuario registrado con el mismo email.";
            } else {
                // Se inserta el usuario.
                $stmt = $pdo->prepare("INSERT INTO usuario (username, email, password, nombre, imagen, rol) VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$username, $email, password_hash($password, PASSWORD_ARGON2I), $nombre, "", "Usuario"])) {
                    return "OK";
                } else {
                    return "Ha habido un error al procesar el registro. Inténtalo de nuevo más tarde.";
                }
            }
        }
    }

    public static function update_usuario($id, $username, $email, $password, $ciudad, $imagen) {
        // OBTENER EL USUARIO POR ID Y REEMPLAZAR EL RESTO.
    }

    //FALTA: HACER EN LISTAS DELETE LISTAS USUARIO. // Se eliminan todos los comentarios del usuario y el usuario.
    public static function delete_usuario($id) {
        $pdo = Conexion::connection_database();
        $stmt = $pdo->prepare("DELETE FROM comentario WHERE id_usuario = ?");
        $stmt->execute([$id]);

        $stmt = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
        if ($stmt->execute([$id])) {
            echo json_encode("OK");
        } else {
            echo json_encode("No se ha podido eliminar el perfil. Prueba de nuevo más tarde.");
        }
    }

    // Inicia sesión con // AÑADIR PASSWORD VERIFY.
    public static function iniciar_sesion($username, $password) {
        $pdo = Conexion::connection_database();
        $usuario_existente = false;
        $credenciales = false;

        $stmt = $pdo->prepare("SELECT id, username, email, rol, password FROM usuario");
        if ($stmt->execute()) {
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Si hay usuarios se recorre el array en busca de la coincidencia de username o email.
            if (count($usuarios) > 0) {
                foreach ($usuarios as $usuario) {
                    // Si el username o email coinciden se setea a true la variable de usuario existente.
                    if ($usuario["username"] == $username || $usuario["email"] == $username) {
                        // Si la contraseña también coincide se inicia la sesión con el id, username y email; y se setea la variable credenciales a true.
                        if (password_verify($password, $usuario["password"])) {
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
                return "OK";
            } else if ($usuario_existente && $credenciales == false) {
                return "La contraseña no coincide.";
            } else if ($usuario_existente == false){
                return "No se ha encontrado ningún usuario con ese nombre.";
            } else {
                return "No se han podido comprobar las credenciales, inténtalo de nuevo más tarde.";
            }
        }
    }

    // Setea el array $_SESSION y se destruye la sesión.
    public static function cerrar_sesion() {
        session_start();
        
        $_SESSION = array();

        session_destroy();
        session_abort();
    }
    
    // Obtiene el id del usuario mediante su username.
    public static function get_id_usuario($username) {
        $pdo = Conexion::connection_database();
        $stmt = $pdo->prepare("SELECT id FROM usuario WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchColumn();
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

    public function get_nombre(): string
    {
        return $this->nombre;
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

    public function set_nombre(string $nombre): void
    {
        $this->nombre = $nombre;
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