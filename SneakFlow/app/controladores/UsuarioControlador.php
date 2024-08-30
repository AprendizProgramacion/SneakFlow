<?php

require_once __DIR__ . '/../../configuracion/conexionBD.php'; // Incluye el archivo de configuración para la conexión a la base de datos
require_once __DIR__ . '/../modelos/UsuarioModelo.php'; // Incluye el modelo de usuario para interactuar con la base de datos

class UsuarioControlador {

    private $usuarioModelo;

    public function __construct() {
        $this->usuarioModelo = new UsuarioModelo(); // Crea una instancia del modelo de usuario
    }

    // Maneja el inicio de sesión del usuario
    public function login() {
        // Sanitiza la entrada del usuario
        $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);
        $contrasena = $_POST['contraseña'];

        // Obtiene los datos del usuario del modelo
        $datos_usuario = $this->usuarioModelo->obtenerUsuarioPorNombre($usuario);

        // Verifica si el usuario existe y la contraseña es correcta
        if ($datos_usuario) {
            if (password_verify($contrasena, $datos_usuario["contrasena"])) {
                session_start(); // Inicia la sesión
                $_SESSION['id'] = $datos_usuario['id'];
                $_SESSION['usuario'] = $usuario; // Guarda el nombre de usuario en la sesión
                $_SESSION['rol'] = $datos_usuario['rol']; // Guarda el rol del usuario en la sesión

                // Redirige a la página de administración o inicio según el rol
                if ($_SESSION['rol'] === 'administrador') {
                    header("Location: admin");
                } else {
                    header("Location: inicio");
                }
                exit(); // Asegura que no se ejecute más código
            } else {
                $this->mostrarError("Usuario y/o contraseña incorrectos"); // Muestra mensaje de error
            }
        } else {
            $this->mostrarError("Usuario y/o contraseña incorrectos"); // Muestra mensaje de error si no se encuentra el usuario
        }
    }

    // Maneja el registro de un nuevo usuario
    public function registrar() {
        // Sanitiza la entrada del usuario
        $usuario = filter_var($_POST['username']);
        $correo = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $contraseña = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña para almacenamiento seguro

        // Verifica si el usuario o correo ya están registrados
        if ($this->usuarioModelo->verificarUsuarioExistente($usuario, $correo)) {
            $this->mostrarError("El correo y/o usuario ya está registrado."); // Muestra mensaje de error
        } else {
            // Intenta registrar el nuevo usuario
            if ($this->usuarioModelo->registrarUsuario($usuario, $correo, $contraseña)) {
                $this->mostrarError("Usuario registrado Exitosamente"); // Muestra mensaje de éxito
            } else {
                $this->mostrarError("Error al registrar el usuario"); // Muestra mensaje de error
            }
        }
    }

    // Maneja el cierre de sesión del usuario
    public function logout() {
        session_start(); // Inicia la sesión
        session_unset(); // Limpia todas las variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: login"); // Redirige a la página de inicio de sesión
        exit(); // Asegura que no se ejecute más código
    }

    // Muestra un mensaje de error utilizando JavaScript
    private function mostrarError($mensaje) {
        echo '<script>
                alert("' . $mensaje . '");
                window.location = "login"; // Redirige a la página de inicio de sesión
            </script>';
    }
}
?>
