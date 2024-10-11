<?php

class MarcaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new MarcaModelo();
    }

    public function mostrarMarcas() {
        $marcas = $this->modelo->obtenerMarcas();
        return $marcas;
    }

    public function mostrarProductosPorMarca() {
        if (isset($_GET['id'])) {
            $id_marca = isset($_GET['id']) ? intval($_GET['id']) : null; 
            
            // Obtener los productos y la información de la marca
            $productos = $this->modelo->obtenerProductosPorMarca($id_marca);
            $producto_marca = $this->modelo->obtenerMarcaPorId($id_marca);
            $colores = $this->modelo->obtenerColores();
            $tallas = $this->modelo->obtenerTallas();
            
            // No es necesario inicializar $productos aquí, ya que ya tiene datos.
            
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $genero = $_GET['genero'] ?? [];
                $talla = $_GET['talla'] ?? [];
                $color = $_GET['color'] ?? [];
                $descuento = $_GET['descuento'] ?? [];
                $precio_min = $_GET['precio_min'] ?? 0;
                $precio_max = $_GET['precio_max'] ?? 1000000;
    
                // Llama al modelo para obtener productos filtrados
                $productos = $this->modelo->filtrarProductos(
                    $id_marca,
                    $genero,
                    $talla,
                    $color,
                    $descuento,
                    $precio_min,
                    $precio_max
                );
            }
    
            foreach ($productos as &$producto) {
                $productoId = $producto['id'];
                
                // Obtén las tallas del producto
                $tallaproducto = $this->modelo->obtenerTallasPorProducto($productoId);
                
                // Asegúrate de que las tallas sean un array
                if (!empty($tallaproducto)) {
                    $producto['tallaproducto'] = $tallaproducto; // Asigna las tallas si no está vacío
                } else {
                    $producto['tallaproducto'] = []; // Si no hay tallas, asigna un array vacío
                }
            }
            unset($producto); // Desreferencia el último elemento
            
    
            if ($producto_marca) {
                require_once __DIR__ . '/../../public/vistas/Producto_Marca/product_marca.php';
            } else {
                echo "Marca no encontrada.";
            }
        } else {
            echo "No se proporcionó el ID de la marca.";
        }
    }
    
        
}
