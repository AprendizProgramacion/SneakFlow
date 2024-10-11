<?php

require_once __DIR__ . '/../modelos/CarritoModelo.php'; // Requiere el modelo del carrito
require_once __DIR__ . '/../modelos/ProductoModelo.php'; // Requiere el modelo del producto

session_start(); // Inicia la sesión al principio del archivo

class CarritoControlador {

    private $carritoModelo; // Modelo del carrito
    private $productoModelo; // Modelo del producto

    // Constructor que inicializa los modelos
    public function __construct() {
        $this->carritoModelo = new CarritoModelo(); // Inicializa el modelo del carrito
        $this->productoModelo = new ProductoModelo(); // Inicializa el modelo del producto
    }

    // Método para mostrar los productos en el carrito
    public function mostrarCarrito() {
        // Verifica si el usuario está registrado
        $usuario = $_SESSION['id']; // Obtiene el ID del usuario
        $productos = $this->carritoModelo->obtenerProductos($usuario); // Obtiene los productos del carrito

        // Asocia tallas disponibles a cada producto
        foreach ($productos as $key => $producto) {
            $productoId = $producto['producto_id']; // Obtiene el ID del producto
            $tallas = $this->productoModelo->obtenerTallasPorProducto($productoId); // Obtiene las tallas disponibles para el producto

            // Asigna las tallas al producto, si existen
            $productos[$key]['tallas'] = !empty($tallas) ? $tallas : []; 
        }
        
        // Incluye la vista del carrito
        include_once __DIR__ . '/../../public/vistas/carrito/Carrito.php';
    }

    // Método para agregar un producto al carrito
    public function agregarAlCarrito() {
        error_reporting(E_ALL); // Activa la visualización de errores
        ini_set('display_errors', 1); // Configura la visualización de errores

        // Verificar si el usuario está registrado
        if (!isset($_SESSION['id'])) {
            // Si no está registrado, devuelve un error en JSON
            echo json_encode([
                'status' => 'error',
                'message' => 'Por favor, inicie sesión para agregar productos al carrito.'
            ]);
            exit(); // Finaliza la ejecución
        }
    
        // Verificar si todos los datos necesarios están presentes
        $errors = []; // Inicializa un array para almacenar errores
        $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : null; // Obtiene el ID del producto
        $tallaId = isset($_POST['talla_id']) ? intval($_POST['talla_id']) : null; // Obtiene el ID de la talla
        $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : null; // Obtiene la cantidad
    
        // Verifica si se seleccionaron los datos necesarios
        if (!$productoId) {
            $errors[] = 'Producto no seleccionado.'; // Agrega error si el producto no fue seleccionado
        }
        if (!$tallaId) {
            $errors[] = 'Talla no seleccionada.'; // Agrega error si la talla no fue seleccionada
        }
        if (!$cantidad) {
            $errors[] = 'Cantidad no proporcionada.'; // Agrega error si la cantidad no fue proporcionada
        }
    
        // Si hay errores, devuelve un error en JSON
        if (!empty($errors)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Datos incompletos: ' . implode(' ', $errors) // Mensaje de error con detalles
            ]);
            exit(); // Finaliza la ejecución
        }

    
        // Validación de datos
        if ($productoId <= 0 || $tallaId <= 0 || $cantidad <= 0) {
            // Si los datos son inválidos, devuelve un error en JSON
            echo json_encode([
                'status' => 'error',
                'message' => 'Datos inválidos proporcionados.'
            ]);
            exit(); // Finaliza la ejecución
        }
    
        $usuarioId = intval($_SESSION['id']); // Obtiene el ID del usuario
    
        try {
            // Verifica disponibilidad antes de reducir existencias
            $stockDisponible = $this->productoModelo->verificarStock($productoId, $tallaId); // Verifica el stock disponible
            if ($cantidad > $stockDisponible) {
                // Si no hay suficiente stock, devuelve un error en JSON
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No hay suficiente stock disponible.'
                ]);
                exit(); // Finaliza la ejecución
            }
    
           // Agrega el producto al carrito y reduce las existencias
           $this->carritoModelo->agregarAlCarrito($usuarioId, $productoId, $tallaId, $cantidad);
           $this->productoModelo->reducirExistencias($productoId, $cantidad, $tallaId);
    
            // Actualiza el contador del carrito en la sesión
            if (!isset($_SESSION['cart_count'])) {
                $_SESSION['cart_count'] = 0; // Inicializa el contador si no existe
            }
            $_SESSION['cart_count'] += $cantidad; // Aumenta el contador del carrito
    
            // Devuelve un mensaje de éxito en JSON
            echo json_encode([
                'status' => 'success',
                'message' => 'Producto añadido al carrito exitosamente.',
                'cart_count' => $_SESSION['cart_count'] // Contador actualizado del carrito
            ]);
        } catch (Exception $e) {
            // En caso de error, devuelve un mensaje de error en JSON
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al añadir el producto. Por favor, intente de nuevo.'
            ]);
        }
    
        exit(); // Finaliza la ejecución
    }
     
    

    public function actualizarCarrito() {
        // Verifica que se hayan enviado todos los datos necesarios
        if (isset($_POST['producto_id']) && isset($_POST['talla_id']) && isset($_POST['cantidad']) && isset($_POST['cantidad_original'])) {
            $productoId = intval($_POST['producto_id']); // Obtiene el ID del producto
            $tallaId = intval($_POST['talla_id']); // Obtiene el ID de la talla
            $cantidad = intval($_POST['cantidad']); // Obtiene la nueva cantidad
            $cantidadOriginal = intval($_POST['cantidad_original']); // Obtiene la cantidad original


            if ($productoId && $tallaId && $cantidad >= 0) {
                // Si la cantidad ha cambiado, restaurar existencias
                if ($cantidadOriginal != $cantidad) {
                    $diferencia = $cantidadOriginal - $cantidad; // Calcula la diferencia
                    $this->productoModelo->restaurarExistencias($productoId, $diferencia, $tallaId); // Restaura las existencias
                }

                // Actualiza el producto en el carrito
                $exito = $this->carritoModelo->actualizarProducto($productoId, $tallaId, $cantidad);

                if ($exito) {
                    $this->productoModelo->reducirExistencias($productoId, $cantidad, $tallaId); // Reduce existencias
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Carrito actualizado correctamente! ¡Buen trabajo!', // Mensaje de éxito
                        'tipo' => 'success'
                    ];
                } else {
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Error al actualizar el carrito! Inténtalo de nuevo.', // Mensaje de error
                        'tipo' => 'error'
                    ];
                }
            } else {
                $_SESSION['mensaje'] = [
                    'texto' => '¡Datos inválidos! Asegúrate de que todos los campos sean correctos.', // Mensaje de error
                    'tipo' => 'error'
                ];
            }
        } else {
            $_SESSION['mensaje'] = [
                'texto' => '¡Datos incompletos! Asegúrate de proporcionar toda la información.', // Mensaje de error
                'tipo' => 'error'
            ];
        }

        header('Location: Carrito'); // Redirige a la página del carrito
        exit(); // Finaliza la ejecución
    }
    
    
    public function editarCarrito() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $usuarioId = intval($_SESSION['id']); // Obtiene el ID del usuario
            $productoId = $_POST['producto_id'] ?? null; // Obtiene el ID del producto
            $tallaId = $_POST['talla_id'] ?? null; // Obtiene el ID de la talla
            $cantidad = $_POST['cantidad'] ?? null; // Obtiene la cantidad
    
            if ($productoId && $tallaId && $cantidad) {
                // Actualizar el carrito en la base de datos
                $this->carritoModelo->actualizarProducto($usuarioId, $productoId, $tallaId, $cantidad);
    
                // Redirigir a la página del carrito o a una página de éxito
                header('Location: Carrito');
                exit();
            } else {
                // Manejar el caso en que los datos no son válidos
                echo "Datos del formulario inválidos.";
            }
        }
    }

        // Método para eliminar un producto del carrito
    public function eliminarDelCarrito() {
        // Verificamos si el método de solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioId = $_SESSION['id']; // Obtenemos el ID del usuario desde la sesión
            $productoId = $_POST['producto_id'] ?? null; // Obtenemos el ID del producto, o null si no está definido
            $cantidad = $_POST['cantidad']; // Obtenemos la cantidad del producto a eliminar
            $tallaId = $_POST['talla_id'] ?? null; // Obtenemos el ID de la talla, o null si no está definido

            // Comprobamos que tanto el ID del producto como el de la talla estén presentes
            if ($productoId && $tallaId) {
                // Intentamos eliminar el producto del carrito
                $exito = $this->carritoModelo->eliminarDelCarrito($usuarioId, $productoId, $tallaId);
                // Restauramos las existencias del producto eliminado
                $this->productoModelo->restaurarExistencias($productoId, $cantidad, $tallaId);

                // Si la eliminación fue exitosa
                if ($exito) {
                    // Actualizamos el contador del carrito, asegurándonos de que no sea negativo
                    if (isset($_SESSION['cart_count'])) {
                        $_SESSION['cart_count'] = max(0, $_SESSION['cart_count'] - $cantidad);
                    }

                    // Almacenamos un mensaje de éxito en la sesión
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Producto eliminado del carrito! ¡Nos vemos pronto!',
                        'tipo' => 'success'
                    ];
                } else {
                    // Si hubo un error al eliminar el producto, almacenamos un mensaje de error
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Error al eliminar el producto del carrito! Inténtalo de nuevo.',
                        'tipo' => 'error'
                    ];
                }
            } else {
                // Si los datos son inválidos, almacenamos un mensaje de advertencia
                $_SESSION['mensaje'] = [
                    'texto' => '¡Datos inválidos! Asegúrate de que todos los campos sean correctos.',
                    'tipo' => 'warning'
                ];
            }
        }

        // Redirigimos a la página del carrito
        header('Location: Carrito');
        exit(); // Finalizamos la ejecución del script
    }


    public function eliminarTodoCarrito() {
        // Verificamos si el usuario está autenticado
        if (isset($_SESSION['id'])) {
            $usuarioId = $_SESSION['id']; // Obtenemos el ID del usuario desde la sesión
            
            try {
                // Recuperar todos los productos del carrito del usuario
                $productos = $this->carritoModelo->obtenerProductos($usuarioId);
    
                // Restaurar existencias para cada producto en el carrito
                foreach ($productos as $producto) {
                    $productoId = $producto['producto_id']; // Obtenemos el ID del producto
                    $tallaId = $producto['talla_id']; // Obtenemos el ID de la talla
                    $cantidad = $producto['cantidad']; // Obtenemos la cantidad del producto
    
                    // Restaurar existencias en el modelo de producto
                    $this->productoModelo->restaurarExistencias($productoId, $cantidad, $tallaId);
                }
    
                // Eliminar todo el carrito después de restaurar existencias
                $exito = $this->carritoModelo->eliminarTodo($usuarioId);
    
                // Si la eliminación fue exitosa
                if ($exito) {
                    $_SESSION['cart_count'] = 0; // Reseteamos el contador del carrito
                    // Almacenamos un mensaje de éxito en la sesión
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Todo el carrito ha sido limpiado y las existencias restauradas! ¡Un nuevo comienzo!',
                        'tipo' => 'success'
                    ];
                } else {
                    // Si hubo un error al eliminar el carrito, almacenamos un mensaje de error
                    $_SESSION['mensaje'] = [
                        'texto' => '¡Error al intentar limpiar el carrito! Inténtalo de nuevo.',
                        'tipo' => 'error'
                    ];
                }
            } catch (Exception $e) {
                // Capturamos cualquier excepción y almacenamos un mensaje de error
                $_SESSION['mensaje'] = [
                    'texto' => '¡Error en la operación! Inténtalo de nuevo.',
                    'tipo' => 'error'
                ];
            }
        } else {
            // Si no se pudo identificar al usuario, almacenamos un mensaje de advertencia
            $_SESSION['mensaje'] = [
                'texto' => '¡No se pudo identificar al usuario! Inicia sesión para continuar.',
                'tipo' => 'warning'
            ];
        }
    
        // Redirigimos a la página del carrito
        header("Location: Carrito");
        exit(); // Finalizamos la ejecución del script
    }
}    
?>
