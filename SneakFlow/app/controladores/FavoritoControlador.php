<?php
// Se requiere el modelo de favoritos y productos
require_once __DIR__ . '/../modelos/FavoritoModelo.php';
require_once __DIR__ . '/../modelos/ProductoModelo.php';

// Inicia la sesión al principio del archivo
session_start();

class FavoritoControlador {
    private $favoritoModelo; // Modelo para manejar los favoritos de los usuarios
    private $productoModelo; // Modelo para manejar la información de los productos

    // Constructor que inicializa los modelos
    public function __construct() {
        $this->favoritoModelo = new FavoritoModelo(); // Inicializa el modelo de favoritos
        $this->productoModelo = new ProductoModelo(); // Inicializa el modelo de productos
    }


    // Mostrar Favoritos de un usuario
    public function mostrarFavoritos() {
        // Verifica si el usuario está autenticado
        if (isset($_SESSION['id'])) {
            $usuarioId = $_SESSION['id'];
            // Obtener productos favoritos
            $productosFavoritos = $this->favoritoModelo->obtenerFavoritos($usuarioId);

            // Obtener detalles de los productos
            $productosDetalles = [];
            foreach ($productosFavoritos as $favorito) {
                // Obtener detalles del producto a partir del ID
                $productoDetalles = $this->productoModelo->obtenerProductoPorId($favorito['producto_id']);
                if ($productoDetalles) {
                    // Obtener tallas para el producto
                    $tallas = $this->productoModelo->obtenerTallasPorProducto($favorito['producto_id']);
                    $productoDetalles['tallas_assoc'] = [];
                    
                    // Asocia las tallas al producto
                    foreach ($tallas as $talla) {
                        $productoDetalles['tallas_assoc'][$talla['id']] = $talla;
                    }

                    // Agrega el producto detallado a la lista
                    $productosDetalles[] = $productoDetalles;
                }
            }
    
            // Actualiza el conteo de favoritos en la sesión
            $_SESSION['fav_count'] = $this->favoritoModelo->obtenerConteoFavoritos($usuarioId);

            // Pasa los detalles a la vista
            include_once __DIR__ . '/../../public/vistas/favoritos/Favoritos.php';
        } else {
            // Mensaje de alerta si el usuario no ha iniciado sesión
            echo "<script>alert('¡Por favor, inicia sesión para ver tus Favoritos!'); window.location.href = 'login';</script>";
        }
    }
    
    // Agregar un producto a Favoritos
    public function agregarFavorito() {
        // Verifica si el usuario está autenticado
        if (isset($_SESSION['id'])) {
            $usuarioId = $_SESSION['id'];
            $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0; // Obtiene el ID del producto
            
            if ($productoId > 0) {
                $respuesta = [];
    
                // Verificar si el producto ya está en los favoritos
                $favoritoExistente = $this->favoritoModelo->verificarFavorito($usuarioId, $productoId);
    
                if ($favoritoExistente) {
                    // Si el favorito existe y está inactivo, lo activa
                    if ($favoritoExistente['estado'] == 0) {
                        $resultado = $this->favoritoModelo->actualizarFavorito($usuarioId, $productoId, 1);
    
                        if ($resultado) {
                            // Actualiza el conteo de favoritos en la sesión
                            $_SESSION['fav_count'] = $this->favoritoModelo->obtenerConteoFavoritos($usuarioId);
                            // Mensaje de producto agregado a favoritos
                            $respuesta['status'] = 'success';
                            $respuesta['message'] = '¡Producto añadido a tus Favoritos con éxito! 😎';
                            $respuesta['fav_count'] = $_SESSION['fav_count'];
                        } else {
                            // Mensaje de error al actualizar el favorito
                            $respuesta['status'] = 'error';
                            $respuesta['message'] = 'Oops, algo salió mal al actualizar el Favorito. 😕';
                        }
                    } else {
                        // Mensaje de información si el producto ya está en favoritos
                        $respuesta['status'] = 'info';
                        $respuesta['message'] = '¡Este producto ya está en tus Favoritos! 😎';
                    }
                } else {
                    // Agrega el producto a favoritos
                    $resultado = $this->favoritoModelo->agregarFavorito($usuarioId, $productoId);
    
                    if ($resultado) {
                        // Actualiza el conteo de favoritos en la sesión
                        $_SESSION['fav_count'] = $this->favoritoModelo->obtenerConteoFavoritos($usuarioId);
                        $respuesta['status'] = 'success';
                        $respuesta['message'] = '¡Producto añadido a tus Favoritos con éxito! 😎';
                        $respuesta['fav_count'] = $_SESSION['fav_count'];
                    } else {
                        // Mensaje de error al agregar a favoritos
                        $respuesta['status'] = 'error';
                        $respuesta['message'] = 'Oops, algo salió mal al agregar a Favoritos. 😕';
                    }
                }
    
                // Devuelve la respuesta en formato JSON
                echo json_encode($respuesta);
            } else {
                // Mensaje de error si el ID del producto es inválido
                echo json_encode([
                    'status' => 'error',
                    'message' => '¡ID del producto inválido! 😲'
                ]);
            }
        } else {
            // Mensaje de error si el usuario no ha iniciado sesión
            echo json_encode([
                'status' => 'error',
                'message' => '¡Necesitas iniciar sesión para agregar Favoritos! 🔒'
            ]);
        }
        exit();
    }
    
    // Eliminar un producto de Favoritos
    public function eliminarFavorito() {
        // Verifica si el usuario está autenticado
        if (isset($_SESSION['id'])) {
            $usuarioId = $_SESSION['id'];
            $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0; // Obtiene el ID del producto
            
            if ($productoId > 0) {
                // Intenta eliminar el producto de favoritos
                $resultado = $this->favoritoModelo->eliminarFavorito($usuarioId, $productoId);
                
                if ($resultado) {
                    // Actualiza el conteo de favoritos en la sesión
                    $_SESSION['fav_count'] = $this->favoritoModelo->obtenerConteoFavoritos($usuarioId);
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Producto eliminado del carrito! ¡Nos vemos pronto!',
                        'tipo' => 'success'
                    ];
                } else {
                    // Mensaje de error al eliminar el producto de favoritos
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Error al eliminar el producto del carrito! Inténtalo de nuevo.',
                        'tipo' => 'error'
                    ];
                }
            } else {
                // Mensaje de advertencia si los datos son inválidos
                $_SESSION['mensaje'] = [
                    'texto' => '¡Datos inválidos! Asegúrate de que todos los campos sean correctos.',
                    'tipo' => 'warning'
                ];
            }
        }
        // Redirecciona a la página de favoritos
        header('Location: Favoritos');
        exit();
    }

    // Eliminar todos los Favoritos de un usuario
    public function eliminarTodosFavoritos() {
        // Verifica si el usuario está autenticado
        if (isset($_SESSION['id'])) {
            $usuarioId = $_SESSION['id'];
            // Intenta eliminar todos los favoritos del usuario
            $resultado = $this->favoritoModelo->eliminarTodosFavoritos($usuarioId);

            if ($resultado) {
                // Actualiza el conteo de favoritos en la sesión
                $_SESSION['fav_count'] = 0;
                echo "<script>alert('¡Todos tus Favoritos han sido eliminados! 🗑️'); window.location.href = 'productos';</script>";
            } else {
                // Mensaje de error al eliminar todos los favoritos
                echo "<script>alert('Oops, algo salió mal al eliminar todos los Favoritos. 😕'); window.location.href = 'productos';</script>";
            }
        } else {
            // Mensaje de error si el usuario no ha iniciado sesión
            echo "<script>alert('¡Necesitas iniciar sesión para eliminar todos los Favoritos! 🔒'); window.location.href = 'productos';</script>";
        }
        exit();
    }
}
?>
