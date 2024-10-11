<?php
class MarcaModelo {
    private $db; // Variable para almacenar la conexión a la base de datos

    public function __construct() {
        $conexionBD = new ConexionBD(); // Crear una nueva instancia de la clase de conexión a la base de datos
        $this->db = $conexionBD->getConnection(); // Obtener la conexión
    }

    // Método para obtener todas las marcas
    public function obtenerMarcas() {
        $query = "SELECT id, marca, imagen FROM marcas"; // Consulta para seleccionar las marcas
        $stmt = $this->db->prepare($query); // Preparar la declaración
        $stmt->execute(); // Ejecutar la consulta
        $resultado = $stmt->get_result(); // Obtener el resultado de la ejecución

        $marcas = []; // Inicializar un array para almacenar las marcas
        if ($resultado) {
            // Iterar sobre el resultado y agregar cada marca al array
            while ($fila = $resultado->fetch_assoc()) {
                $marcas[] = $fila;
            }
        }
        return $marcas; // Retornar el array de marcas
    }

    // Método para obtener una marca por su ID
    public function obtenerMarcaPorId($id_marca) {
        $consulta = "SELECT * FROM marcas WHERE id = ?"; // Consulta para seleccionar la marca por ID
        $stmt = $this->db->prepare($consulta); // Preparar la declaración
        $stmt->bind_param('i', $id_marca); // Asociar el parámetro de entrada (ID de la marca)
        $stmt->execute(); // Ejecutar la consulta
        $resultado = $stmt->get_result(); // Obtener el resultado
        return $resultado->fetch_assoc(); // Retornar la marca encontrada
    }

    // Método para obtener productos por la marca
    public function obtenerProductosPorMarca($id_marca) {
        $sql = "SELECT * FROM productos WHERE marca_id = ?"; // Consulta para seleccionar productos de una marca específica
        $stmt = $this->db->prepare($sql); // Preparar la declaración
        $stmt->bind_param('i', $id_marca); // Asociar el parámetro (ID de la marca)
        $stmt->execute(); // Ejecutar la consulta
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Retornar todos los productos encontrados
    }

    // Método para obtener todas las tallas disponibles
    public function obtenerTallas() {
        $consulta = "SELECT DISTINCT talla FROM tallas"; // Consulta para seleccionar tallas distintas
        $stmt = $this->db->prepare($consulta); // Preparar la declaración
        $stmt->execute(); // Ejecutar la consulta
        $resultado = $stmt->get_result(); // Obtener el resultado
        
        $tallas = []; // Inicializar un array para almacenar las tallas
        while ($fila = $resultado->fetch_assoc()) {
            $tallas[] = $fila; // Agregar cada talla al array
        }
        return $tallas; // Retornar el array de tallas
    }

    // Método para obtener todos los colores disponibles
    public function obtenerColores() {
        $query = "SELECT id, color FROM colores"; // Consulta para seleccionar colores
        $stmt = $this->db->prepare($query); // Preparar la declaración
        $stmt->execute(); // Ejecutar la consulta
        $resultado = $stmt->get_result(); // Obtener el resultado
    
        $colores = []; // Inicializar un array para almacenar los colores
        while ($fila = $resultado->fetch_assoc()) {
            $colores[] = $fila; // Agregar cada color al array
        }
        return $colores; // Retornar el array de colores
    }

    // Método para obtener tallas por producto específico
    public function obtenerTallasPorProducto($id_producto) {
        $query = "SELECT id, talla FROM tallas WHERE producto_id = ?"; // Consulta para seleccionar tallas por ID de producto
        $stmt = $this->db->prepare($query); // Preparar la declaración
        $stmt->bind_param('i', $id_producto); // Asociar el parámetro (ID del producto)
        $stmt->execute(); // Ejecutar la consulta
        $resultado = $stmt->get_result(); // Obtener el resultado

        $tallas = []; // Inicializar un array para almacenar las tallas
        while ($fila = $resultado->fetch_assoc()) {
            $tallas[] = $fila; // Agregar cada talla al array
        }
        return $tallas; // Retornar el array de tallas para el producto específico
    }

    // Método para filtrar productos según varios criterios
    public function filtrarProductos($id_marca, $genero, $talla, $color, $descuento, $precio_min, $precio_max) {
        // Consulta inicial con las tablas productos, tallas y colores
        $query = "SELECT DISTINCT p.* FROM productos p 
          JOIN tallas t ON p.id = t.producto_id 
          JOIN colores c ON p.color_id = c.id 
          WHERE p.marca_id = ?"; // Cambia id_marca según tu estructura

        $params = [$id_marca]; // Inicializa los parámetros de la consulta

        // Agregar filtros según los parámetros proporcionados
        if (!empty($genero)) {
            $generoList = implode(',', array_fill(0, count($genero), '?')); // Crear la lista de parámetros para género
            $query .= " AND p.genero IN ($generoList)"; // Agregar filtro de género a la consulta
            $params = array_merge($params, $genero); // Unir los parámetros
        }

        if (!empty($talla)) {
            $tallaList = implode(',', array_fill(0, count($talla), '?')); // Crear la lista de parámetros para tallas
            $query .= " AND t.talla IN ($tallaList)"; // Agregar filtro de tallas a la consulta
            $params = array_merge($params, $talla); // Unir los parámetros
        }

        if (!empty($color)) {
            $colorList = implode(',', array_fill(0, count($color), '?')); // Crear la lista de parámetros para colores
            $query .= " AND c.color IN ($colorList)"; // Agregar filtro de colores a la consulta
            $params = array_merge($params, $color); // Unir los parámetros
        }

        if (!empty($descuento)) {
            $descuentoList = implode(',', array_fill(0, count($descuento), '?')); // Crear la lista de parámetros para descuentos
            $query .= " AND p.descuento IN ($descuentoList)"; // Agregar filtro de descuentos a la consulta
            $params = array_merge($params, $descuento); // Unir los parámetros
        }

        // Agregar filtro de precio
        $query .= " AND p.precio BETWEEN ? AND ?";
        $params[] = $precio_min; // Agregar el precio mínimo
        $params[] = $precio_max; // Agregar el precio máximo

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Asocia los parámetros
        $types = str_repeat('s', count($params)); // Tipo de todos los parámetros como string
        $stmt->bind_param($types, ...$params); // Asociar los parámetros a la consulta

        // Ejecuta la consulta
        $stmt->execute();

        // Retorna los resultados de la consulta
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    
}
?>
