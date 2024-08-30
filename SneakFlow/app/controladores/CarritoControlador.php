<?php 
    require_once __DIR__ . '/../modelos/carritoModelo.php'; // Incluye el modelo de perfil para interactuar con la base de datos
    class CarritoControlador {
        private $carritoModelo;

        public function __construct() {
            // Instanciar el modelo directamente
            $this->carritoModelo = new CarritoModelo();
        }

        public function mostrarCarrito() {
            // Verifica si el usuario está logueado
            if (!isset($_SESSION['usuario'])) {
                header("Location: inicio");
                exit();
            }       
            
        $usuario = $_SESSION['id'];
        $productos = $this->carritoModelo->obtenerProductos($usuario);

        // Incluye la vista del carrito
        include_once __DIR__ . '/../../public/vistas/carrito/Carrito.php';
    }
    

        // Agregar un producto al carrito
        public function agregarAlCarrito() {
            $usuarioId =  $_SESSION['id'];
            $productoId = $_POST['producto_id'];
            $tallaId = $_POST['talla_id'];
            $cantidad = $_POST['cantidad'];
            $this->carritoModelo->agregarAlCarrito($usuarioId, $productoId,$tallaId, $cantidad);
            // Redirige o muestra un mensaje de éxito
            header("Location: Carrito");
        }

        // Método para actualizar la talla y cantidad de un producto en el carrito
        public function editarCarrito() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener datos del formulario
                $productoId = $_POST['producto_id'] ?? null;
                $tallaId = $_POST['talla_id'] ?? null;
                $cantidad = $_POST['cantidad'] ?? null;
        
                if ($productoId && $tallaId && $cantidad) {
                    // Actualizar el carrito en la base de datos
                    $this->carritoModelo->actualizarCarrito($productoId, $tallaId, $cantidad);
        
                    // Redirigir a la página del carrito o a una página de éxito
                    header('Location: Carrito');
                    exit();
                } else {
                    // Manejar el caso en que los datos no son válidos
                    echo "Datos del formulario inválidos.";
                }
            }
        }
        
        public function actualizarDelCarrito() {
            $usuarioId = $_SESSION['id']; // Asegúrate de que el ID del usuario esté disponible en la sesión
            $productoId = $_POST['producto_id'] ?? null;
            $tallaId = $_POST['talla_id'] ?? null;
            $cantidad = $_POST['cantidad'] ?? null;
        
            if ($productoId && $tallaId && $cantidad) {
                $this->carritoModelo->actualizarCarrito($usuarioId, $productoId, $tallaId, $cantidad);
            }
        
            // Redirige a la página del carrito
            header('Location: carrito');
            exit();
        }  

        public function eliminarDelCarrito() {
            // Verifica si la solicitud es POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtén los parámetros del POST
                $usuarioId = $_SESSION['id']; // O el método que uses para obtener el ID del usuario
                $productoId = $_POST['producto_id'] ?? null;
                $tallaId = $_POST['talla_id'] ?? null;
                
                if ($productoId && $tallaId) {
                    // Llama al modelo para eliminar el producto del carrito
                    $exito = $this->carritoModelo->eliminarDelCarrito($usuarioId, $productoId, $tallaId);
    
                    // Redirige o maneja la respuesta según el resultado
                    if ($exito) {
                        // Redirige al usuario a la página del carrito o muestra un mensaje de éxito
                        header('Location: Carrito'); // Ajusta la ruta según sea necesario
                        exit();
                    } else {
                        // Muestra un mensaje de error o redirige a una página de error
                        echo "Error al eliminar el producto del carrito.";
                    }
                } else {
                    // Maneja la situación cuando los parámetros no están presentes
                    echo "Datos inválidos.";
                }
            }
        }
    }
?>