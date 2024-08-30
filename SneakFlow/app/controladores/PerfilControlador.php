<?php

require_once __DIR__ . '/../modelos/PerfilModelo.php'; // Incluye el modelo de perfil para interactuar con la base de datos

class PerfilControlador {

    private $perfilModelo;

    public function __construct() {
        $this->perfilModelo = new PerfilModelo(); // Crea una instancia del modelo de perfil
    }

    // Muestra el perfil del usuario
    public function mostrarPerfil() {
        if (!isset($_SESSION['usuario'])) {
            // Si el usuario no está autenticado, redirige al login
            header("Location: login");
            exit();
        }

        $usuario = $_SESSION['usuario']; // Obtiene el usuario actual de la sesión
        $perfil = $this->perfilModelo->obtenerPerfil($usuario); // Obtiene los datos del perfil del modelo

        require_once __DIR__ . '/../../public/profill/perfil.php'; // Incluye la vista del perfil
    }

    // Actualiza el perfil del usuario
    public function actualizarPerfil() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica que la solicitud sea un POST
            // Obtener datos del formulario
            $usuarioActual = $_SESSION['usuario']; // Usuario actual de la sesión
            $nuevoUsuario = $_POST['usuario'] ?? null; // Nuevo nombre de usuario si se proporciona
            $correo = $_POST['correo'] ?? null; // Nuevo correo electrónico si se proporciona
            $contrasena = $_POST['contrasena'] ?? null; // Nueva contraseña si se proporciona
            $imagen = $_FILES['imagen'] ?? null; // Imagen subida si se proporciona
            $imagenRuta = null;

            // Si se ha subido una imagen
            if ($imagen && $imagen['error'] === UPLOAD_ERR_OK) {
                // Validar el tipo de archivo
                $validTypes = ['image/jpeg', 'image/png'];
                if (!in_array($imagen['type'], $validTypes)) {
                    echo 'Tipo de archivo no permitido. Solo se permiten imágenes JPEG y PNG.';
                    return;
                }
                
                // Mover el archivo a un directorio de destino
                $imagenRuta = 'path/to/your/uploads/' . basename($imagen['name']);
                if (!move_uploaded_file($imagen['tmp_name'], $imagenRuta)) {
                    echo 'Error al subir la imagen.';
                    return;
                }
            }

            try {
                // Actualizar el nombre de usuario si se proporciona y es diferente del actual
                if ($nuevoUsuario !== $usuarioActual) {
                    $this->perfilModelo->actualizarUsuario($usuarioActual, $nuevoUsuario);
                    $_SESSION['usuario'] = $nuevoUsuario; // Actualiza la sesión con el nuevo nombre de usuario
                }
                // Actualizar el correo electrónico si se proporciona
                if ($correo) {
                    $this->perfilModelo->actualizarCorreo($usuarioActual, $correo);
                }

                // Actualizar la contraseña si se proporciona
                if ($contrasena) {
                    $this->perfilModelo->actualizarContrasena($usuarioActual, $contrasena);
                }

                // Actualizar la imagen si se proporciona
                if ($imagenRuta) {
                    $this->perfilModelo->actualizarImagen($usuarioActual, $imagenRuta);
                }

                // Mensaje de éxito y redirección al perfil
                echo '<script>alert("Perfil actualizado con éxito."); window.location.href = "perfil";</script>';
            } catch (Exception $e) {
                // Manejo de errores y redirección al perfil
                echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location.href = "perfil";</script>';
            }
        } else {
            // Mensaje de error si el método de solicitud no es POST
            echo '<script>alert("Método de solicitud no válido."); window.location.href = "perfil";</script>';
        }    
    }
}
        
?>
