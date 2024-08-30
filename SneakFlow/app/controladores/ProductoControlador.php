<?php
    require_once __DIR__ . '/../modelos/ProductoModelo.php'; // Incluye el archivo del modelo

    /**
     * Controlador para manejar las operaciones relacionadas con los productos.
     */
    class ProductoControlador {

        private $productoModelo; // Variable para almacenar la instancia del modelo
        /**
         * Constructor de la clase. Inicializa el modelo de productos.
         */
        public function __construct() {
            $this->productoModelo = new ProductoModelo(); // Crea una instancia del modelo
        }

        /**
         * Muestra la página de productos con los productos filtrados.
         */
        public function mostrarProductos() {
            $filtros = $_GET; // Supón que ya has manejado la captura de filtros aquí
        
            $productosPorPagina = 4; // Número de productos por página
            $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $offset = ($paginaActual - 1) * $productosPorPagina;
        
            // Obtener productos filtrados y paginados
            $productos = $this->productoModelo->obtenerProductos($filtros, $productosPorPagina, $offset);
            
            foreach ($productos as $key => $producto) {
                if (!empty($producto['tallas'])) {
                    $productos[$key]['tallas'] = explode(',', $producto['tallas']);
                    $productos[$key]['id_tallas'] = explode(',', $producto['id_tallas']);
                    $productos[$key]['tallas_assoc'] = array_combine($productos[$key]['id_tallas'], $productos[$key]['tallas']);
                } else {
                    $productos[$key]['tallas'] = [];
                    $productos[$key]['id_tallas'] = [];
                    $productos[$key]['tallas_assoc'] = [];
                }
            }
            
            // Obtener el número total de productos (para la paginación)
            $totalProductos = $this->productoModelo->contarProductos($filtros);
            $totalPaginas = ceil($totalProductos / $productosPorPagina);
        

            // Pasar datos a la vista
            include_once __DIR__ . '../../../public/vistas/Productos/Productos.php';
        }        
    }   
?>
