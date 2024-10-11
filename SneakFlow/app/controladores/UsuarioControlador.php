<?php

require_once __DIR__ . '/../../configuracion/conexionBD.php'; // Incluye el archivo de configuración para la conexión a la base de datos
require_once __DIR__ . '/../modelos/UsuarioModelo.php'; // Incluye el modelo de usuario para interactuar con la base de datos
require_once __DIR__ . '/../modelos/CarritoModelo.php'; // Incluye el modelo de carrito para interactuar con la base de datos
require_once __DIR__ . '/../modelos/FavoritoModelo.php'; // Incluye el modelo de carrito para interactuar con la base de datos

session_start(); // Inicia la sesión al principio del archivo

class UsuarioControlador {

  // Modelo para gestionar la información del usuario
    private $usuarioModelo;

    // Modelo para gestionar las operaciones del carrito de compras
    private $carritoModelo;

    // Modelo para gestionar los productos marcados como favoritos
    private $favoritoModelo;


    public function __construct() {
        $this->usuarioModelo = new UsuarioModelo(); // Crea una instancia del modelo de usuario
        $this->carritoModelo = new CarritoModelo(); // Crea una instancia del modelo de carrito
        $this->favoritoModelo = new FavoritoModelo(); // Crea una instancia del modelo de carrito
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
                $_SESSION['id'] = $datos_usuario['id']; // Guarda el id del usuario en la sesión
                $_SESSION['usuario'] = $usuario; // Guarda el nombre de usuario en la sesión
                $_SESSION['rol'] = $datos_usuario['rol']; // Guarda el rol del usuario en la sesión
    
                // Calcula el total de productos en el carrito para este usuario desde la base de datos
                $_SESSION['cart_count'] = $this->carritoModelo->obtenerConteoCarrito($_SESSION['id']); // Usar el modelo de carrito
                $_SESSION['fav_count'] = $this->favoritoModelo->obtenerConteoFavoritos($_SESSION['id']); // Usar el modelo de favoritos

                // Redirige a la página de administración o inicio según el rol
                if ($_SESSION['rol'] === 'administrador') {
                    header("Location: Panel_Control");
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
        // Sanitiza la entrada del usuario para evitar inyecciones de código
        $usuario = filter_var($_POST['username']);
        $correo = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitiza el correo electrónico
        $contraseña = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña para almacenamiento seguro
    
        // Verifica si el usuario o correo ya están registrados
        if ($this->usuarioModelo->verificarUsuarioExistente($usuario, $correo)) {
            $this->mostrarError("El correo y/o usuario ya está registrado."); // Muestra mensaje de error si el usuario ya existe
        } else {
            // Intenta registrar el nuevo usuario
            if ($this->usuarioModelo->registrarUsuario($usuario, $correo, $contraseña)) {
                $this->mostrarError("Usuario registrado Exitosamente"); // Muestra mensaje de éxito si el registro fue exitoso
            } else {
                $this->mostrarError("Error al registrar el usuario"); // Muestra mensaje de error si hubo un problema al registrar
            }
        }
    }
    
    // Maneja el cierre de sesión del usuario
    public function logout() {
        session_start(); // Inicia la sesión para poder acceder a las variables de sesión
        session_unset(); // Limpia todas las variables de sesión, eliminando datos del usuario
        session_destroy(); // Destruye la sesión actual, cerrando efectivamente la sesión del usuario
        header("Location: login"); // Redirige a la página de inicio de sesión
        exit(); // Asegura que no se ejecute más código después de la redirección
    }

    // Muestra un mensaje de error utilizando JavaScript
    private function mostrarError($mensaje) {
        // Muestra un mensaje de alerta con el mensaje proporcionado
        echo '<script>
                alert("' . $mensaje . '");
                window.location = "login"; 
            </script>';
        // Redirige a la página de inicio de sesión después de mostrar el mensaje
    }

}
?>
