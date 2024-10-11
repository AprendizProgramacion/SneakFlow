<?php
    // Se incluye el archivo del modelo de productos
    require_once __DIR__ . '/../modelos/ProductoModelo.php'; 
    session_start(); // Inicia la sesión para mantener datos del usuario

    /**
    * Controlador para manejar las operaciones relacionadas con los productos.
    */
    class ProductoControlador {

        private $productoModelo; // Variable para almacenar la instancia del modelo de productos

        /**
        * Constructor de la clase. Inicializa el modelo de productos.
        */
        public function __construct() {
            // Crea una instancia del modelo de productos
            $this->productoModelo = new ProductoModelo(); 
        }

        /**
        * Muestra la página de productos con los productos filtrados y paginados.
        */
        public function mostrarProductos() {
            $filtros = $_GET; // Captura los filtros de búsqueda enviados por GET
            
            $productosPorPagina = 10; // Define el número de productos que se mostrarán por página
            // Obtiene la página actual desde la URL, si no está definida, se establece en 1
            $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 
            // Calcula el desplazamiento para la consulta SQL
            $offset = ($paginaActual - 1) * $productosPorPagina;
        
            // Llama al modelo para obtener los productos filtrados y paginados
            $productos = $this->productoModelo->obtenerProductos($filtros, $productosPorPagina, $offset);
            // Obtiene las marcas, colores y tallas disponibles
            $marcas = $this->productoModelo->obtenerMarcas();
            $colores = $this->productoModelo->obtenerColores();
            $tallas = $this->productoModelo->obtenerTallas();

            // Recorre los productos para asociar las tallas correspondientes
            foreach ($productos as $key => $producto) {
                // Obtiene las tallas para el producto actual
                $productoTallas = $this->productoModelo->obtenerTallasPorProducto($producto['id']);
                // Inicializa un arreglo para asociar tallas al producto
                $productos[$key]['tallas_assoc'] = [];

                // Asocia cada talla al producto actual
                foreach ($productoTallas as $talla) {
                    $productos[$key]['tallas_assoc'][$talla['id']] = [
                        'nombre' => $talla['talla'], // Nombre de la talla
                        'cantidad' => $talla['cantidad'] // Cantidad disponible de esa talla
                    ];
                }
            }
            
            // Obtiene el número total de productos para la paginación
            $totalProductos = $this->productoModelo->contarProductos($filtros);
            // Calcula el número total de páginas necesarias
            $totalPaginas = ceil($totalProductos / $productosPorPagina);

            // Incluye la vista de productos, pasando los datos necesarios
            include_once __DIR__ . '../../../public/vistas/Productos/Productos.php';
        }    
    }
?>
