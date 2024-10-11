<?php
require_once __DIR__ . '/../../configuracion/conexionBD.php'; 

class ProductoModelo {

    // Propiedad para almacenar la conexión a la base de datos
    private $db;

    // Constructor que inicializa la conexión a la base de datos usando la clase ConexionBD
    public function __construct() {
        $conexionBD = new ConexionBD(); 
        $this->db = $conexionBD->getConnection();
    }

    // Método para obtener productos con la opción de aplicar filtros
    public function obtenerProductos($filtros, $limite, $offset) {
        // Consulta SQL para obtener productos junto con sus tallas, asegurando que tengan existencias
        $query = "
            SELECT 
                p.id, 
                p.nombre, 
                p.descripcion, 
                p.precio, 
                p.imagen, 
                m.marca AS marca, 
                c.color AS color, 
                p.genero, 
                p.descuento,
                p.existencias,
                GROUP_CONCAT(t.id ORDER BY t.talla ASC) AS id_tallas,
                GROUP_CONCAT(t.talla ORDER BY t.talla ASC) AS tallas
            FROM productos p
            LEFT JOIN marcas m ON p.marca_id = m.id
            LEFT JOIN colores c ON p.color_id = c.id
            LEFT JOIN tallas t ON p.id = t.producto_id
            WHERE p.existencias >= 1
        ";
        
        // Arreglo para almacenar condiciones adicionales basadas en los filtros
        $conditions = [];
        
        // Verifica si se han pasado filtros y los agrega a la consulta SQL
        if (!empty($filtros)) {
            // Filtra por marca si está presente en los filtros
            if (!empty($filtros['marca'])) {
                $conditions[] = "m.marca IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['marca'])) . "')";
            }
            // Filtra por género si está presente en los filtros
            if (!empty($filtros['genero'])) {
                $conditions[] = "p.genero IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['genero'])) . "')";
            }
            // Filtra por talla si está presente en los filtros
            if (!empty($filtros['talla'])) {
                $conditions[] = "t.talla IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['talla'])) . "')";
            }
            // Filtra por color si está presente en los filtros
            if (!empty($filtros['color'])) {
                $conditions[] = "c.color IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['color'])) . "')";
            }
            // Filtra por descuento si está presente en los filtros
            if (!empty($filtros['descuento'])) {
                $conditions[] = "p.descuento IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['descuento'])) . "')";
            }
            // Filtra por rango de precios si están presentes en los filtros
            if (isset($filtros['precio_min']) && isset($filtros['precio_max'])) {
                $precio_min = $this->db->escape_string($filtros['precio_min']);
                $precio_max = $this->db->escape_string($filtros['precio_max']);
                $conditions[] = "p.precio BETWEEN $precio_min AND $precio_max";
            }
        }
        if (!empty($conditions)) {
            // Si hay condiciones de filtrado, se añaden a la consulta SQL con "AND"
            $query .= " AND " . implode(" AND ", $conditions);
        }
        
        // Agrupa los resultados por los campos especificados
        $query .= " GROUP BY p.id, p.nombre, p.descripcion, p.precio, p.imagen, m.marca, c.color, p.genero, p.descuento, p.existencias";
        
        // Añade límites a la consulta para la paginación
        $query .= " LIMIT ? OFFSET ?";
        
        // Prepara la consulta SQL para su ejecución
        $stmt = $this->db->prepare($query);
        
        // Vincula los parámetros de límite y desplazamiento a la consulta
        $stmt->bind_param('ii', $limite, $offset);
        
        // Ejecuta la consulta preparada
        $stmt->execute();
        
        // Obtiene el resultado de la consulta ejecutada
        $resultado = $stmt->get_result();
        
        // Verifica si hay resultados y retorna un arreglo asociativo con los datos
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC); // Retorna todos los resultados en forma de arreglo asociativo
        } else {
            return []; // Retorna un arreglo vacío
        }
    }
    public function contarProductos($filtros = []) {
        // Inicia la consulta SQL para contar el número de productos distintos
        $query = "
            SELECT COUNT(DISTINCT p.id) as total
            FROM productos p
            LEFT JOIN tallas t ON p.id = t.producto_id
            LEFT JOIN colores c ON p.color_id = c.id
            LEFT JOIN marcas m ON p.marca_id = m.id
    
            WHERE p.existencias >= 1
        ";
    
        // Array para almacenar las condiciones de filtrado
        $conditions = [];
    
        // Verifica si se han pasado filtros y los agrega a la consulta SQL
        if (!empty($filtros)) {
            // Filtra por marca si está presente en los filtros
            if (!empty($filtros['marca'])) {
                $conditions[] = "m.marca IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['marca'])) . "')";
            }
            // Filtra por género si está presente en los filtros
            if (!empty($filtros['genero'])) {
                $conditions[] = "p.genero IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['genero'])) . "')";
            }
            // Filtra por talla si está presente en los filtros
            if (!empty($filtros['talla'])) {
                $conditions[] = "t.talla IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['talla'])) . "')";
            }
            // Filtra por color si está presente en los filtros
            if (!empty($filtros['color'])) {
                $conditions[] = "c.color IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['color'])) . "')";
            }
            // Filtra por descuento si está presente en los filtros
            if (!empty($filtros['descuento'])) {
                $conditions[] = "p.descuento IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['descuento'])) . "')";
            }
            // Filtra por rango de precios si están presentes en los filtros
            if (isset($filtros['precio_min']) && isset($filtros['precio_max'])) {
                $precio_min = $this->db->escape_string($filtros['precio_min']);
                $precio_max = $this->db->escape_string($filtros['precio_max']);
                $conditions[] = "p.precio BETWEEN $precio_min AND $precio_max";
            }
        }
    
        if (!empty($conditions)) {
            // Si hay condiciones de filtrado, las agrega a la consulta
            $query .= " AND " . implode(" AND ", $conditions);
        }
        
        // Ejecuta la consulta en la base de datos
        $resultado = $this->db->query($query);
        
        // Recupera el resultado como un arreglo asociativo
        $data = $resultado->fetch_assoc();
        
        // Devuelve el total de productos contados
        return $data['total'];
        
    }
    

    public function mostrarProductos() {
        // Inicializa un arreglo para almacenar los filtros obtenidos de la solicitud (GET)
        $filtros = [];
    
        // Verifica si se ha establecido un filtro de 'marca' y lo agrega al arreglo de filtros
        if (isset($_GET['marca'])) {
            $filtros['marca'] = $_GET['marca'];
        }
    
        // Verifica si se ha establecido un filtro de 'genero' y lo agrega al arreglo de filtros
        if (isset($_GET['genero'])) {
            $filtros['genero'] = $_GET['genero'];
        }
    
        // Verifica si se ha establecido un filtro de 'talla' y lo agrega al arreglo de filtros
        if (isset($_GET['talla'])) {
            $filtros['talla'] = $_GET['talla'];
        }
    
        // Verifica si se ha establecido un filtro de 'color' y lo agrega al arreglo de filtros
        if (isset($_GET['color'])) {
            $filtros['color'] = $_GET['color'];
        }
    
        // Verifica si se ha establecido un filtro de 'descuento' y lo agrega al arreglo de filtros
        if (isset($_GET['descuento'])) {
            $filtros['descuento'] = $_GET['descuento'];
        }
    
        // Verifica si se han establecido filtros de 'precio_min' y 'precio_max' y los agrega al arreglo de filtros
        if (isset($_GET['precio_min']) && isset($_GET['precio_max'])) {
            $filtros['precio_min'] = $_GET['precio_min'];
            $filtros['precio_max'] = $_GET['precio_max'];
        }
    
        // Aquí se podría agregar la lógica para mostrar los productos filtrados según los filtros recolectados
    }
    
   // Método para obtener los detalles de un producto específico por su ID
    public function obtenerProductoPorId($id) {
        // Consulta SQL para seleccionar los detalles del producto junto con la marca y el color
        $query = "
            SELECT 
                p.id, 
                p.nombre, 
                p.descripcion, 
                p.precio, 
                p.imagen, 
                m.marca AS marca, 
                c.color AS color, 
                p.genero, 
                p.descuento,
                p.existencias,
                p.fecha_agregado
            FROM productos p
            LEFT JOIN marcas m ON p.marca_id = m.id
            LEFT JOIN colores c ON p.color_id = c.id
            WHERE p.id = ?
        ";

        // Prepara la declaración
        $stmt = $this->db->prepare($query);
        
        // Manejo de errores de preparación de la declaración
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->db->error);
        }

        // Asocia el parámetro de entrada (ID del producto) a la declaración
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Obtiene el resultado de la ejecución de la consulta
        $resultado = $stmt->get_result();

        // Verifica si se encontraron resultados
        if ($resultado->num_rows > 0) {
            // Devuelve el primer resultado como un arreglo asociativo
            return $resultado->fetch_assoc();
        } else {
            // Devuelve null si no se encuentra el producto (o lanzar una excepción si prefieres)
            return null; 
        }
    }

    // Método para obtener las tallas disponibles para un producto específico
    public function obtenerTallasPorProducto($productoId) {
        // Consulta SQL para seleccionar el ID, la talla y la cantidad de la tabla tallas
        $query = "SELECT id, talla, cantidad FROM tallas WHERE producto_id = ?";
        $stmt = $this->db->prepare($query);
        
        // Asocia el parámetro de entrada (ID del producto) a la declaración
        $stmt->bind_param("i", $productoId);
        $stmt->execute();
        
        // Obtiene el resultado de la ejecución de la consulta
        $result = $stmt->get_result();
        
        // Inicializa un arreglo para almacenar las tallas
        $tallas = [];
        
        // Itera sobre los resultados y agrega cada talla al arreglo
        while ($row = $result->fetch_assoc()) {
            $tallas[] = $row;
        }
        
        // Devuelve el arreglo de tallas
        return $tallas;
    }

    // Método para obtener todas las marcas
    public function obtenerMarcas() {
        // Consulta SQL para seleccionar todas las marcas
        $query = "SELECT id, marca FROM marcas";
        $resultado = $this->db->query($query);
        
        // Manejo de errores en la consulta
        if (!$resultado) {
            die("Error en la consulta: " . $this->db->error);
        }
        
        // Devuelve todas las marcas como un arreglo asociativo
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener todos los colores
    public function obtenerColores() {
        // Consulta SQL para seleccionar todos los colores
        $query = "SELECT id, color FROM colores";
        $resultado = $this->db->query($query);
        
        // Manejo de errores en la consulta
        if (!$resultado) {
            die("Error en la consulta: " . $this->db->error);
        }
        
        // Devuelve todos los colores como un arreglo asociativo
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener todas las tallas distintas
    public function obtenerTallas() {
        // Consulta SQL para seleccionar tallas distintas
        $query = "SELECT DISTINCT talla FROM tallas";
        $resultado = $this->db->query($query);
        
        // Manejo de errores en la consulta
        if (!$resultado) {
            die("Error en la consulta: " . $this->db->error);
        }
        
        // Devuelve las tallas distintas como un arreglo asociativo
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Método para reducir las existencias de un producto y de su talla
    public function reducirExistencias($productoId, $cantidad, $tallaId) {
        // Consulta SQL para reducir las existencias del producto
        $queryProducto = "UPDATE productos SET existencias = existencias - ? WHERE id = ?";
        $stmtProducto = $this->db->prepare($queryProducto);
        
        // Asocia los parámetros de entrada (cantidad y ID del producto) a la declaración
        $stmtProducto->bind_param("ii", $cantidad, $productoId);
        
        // Ejecuta la consulta
        $stmtProducto->execute();

        // Verifica si se ha seleccionado una talla para reducir su cantidad
        if ($tallaId) {
            // Consulta SQL para reducir la cantidad disponible de la talla
            $queryTalla = "UPDATE tallas SET cantidad = cantidad - ? WHERE id = ? AND producto_id = ?";
            $stmtTalla = $this->db->prepare($queryTalla);
            
            // Asocia los parámetros de entrada (cantidad, ID de la talla y ID del producto) a la declaración
            $stmtTalla->bind_param("iii", $cantidad, $tallaId, $productoId);
            
            // Ejecuta la consulta
            $stmtTalla->execute();
        }
    }

    // Método para restaurar las existencias de un producto y de su talla
    public function restaurarExistencias($productoId, $cantidad, $tallaId) {
        // Consulta SQL para restaurar las existencias del producto
        $queryProducto = "UPDATE productos SET existencias = existencias + ? WHERE id = ?";
        $stmtProducto = $this->db->prepare($queryProducto);
        
        // Asocia los parámetros de entrada (cantidad y ID del producto) a la declaración
        $stmtProducto->bind_param("ii", $cantidad, $productoId);
        
        // Ejecuta la consulta
        $stmtProducto->execute();

        // Verifica si se ha seleccionado una talla para restaurar su cantidad
        if ($tallaId) {
            // Consulta SQL para restaurar la cantidad de la talla
            $queryTalla = "UPDATE tallas SET cantidad = cantidad + ? WHERE id = ? AND producto_id = ?";
            $stmtTalla = $this->db->prepare($queryTalla);
            
            // Asocia los parámetros de entrada (cantidad, ID de la talla y ID del producto) a la declaración
            $stmtTalla->bind_param("iii", $cantidad, $tallaId, $productoId);
            
            // Ejecuta la consulta
            $stmtTalla->execute();
        }
    }

    // Método para verificar la cantidad disponible de un producto o su talla específica
    public function verificarStock($productoId, $tallaId) {
        // Inicializar cantidad disponible
        $cantidadDisponible = 0;

        // Verificar si se ha proporcionado una talla
        if ($tallaId) {
            // Consultar la cantidad disponible para la talla específica
            $query = "SELECT cantidad FROM tallas WHERE id = ? AND producto_id = ?";
            $stmt = $this->db->prepare($query);
            
            // Asocia los parámetros de entrada (ID de la talla y ID del producto) a la declaración
            $stmt->bind_param("ii", $tallaId, $productoId);
            
            // Ejecuta la consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Si se encuentra una fila, asigna la cantidad disponible de la talla
            if ($row = $result->fetch_assoc()) {
                $cantidadDisponible = $row['cantidad'];
            }

            // Cierra la declaración
            $stmt->close();
        } else {
            // Si no se proporciona talla, consultar la cantidad total disponible del producto
            $query = "SELECT existencias FROM productos WHERE id = ?";
            $stmt = $this->db->prepare($query);
            
            // Asocia el parámetro de entrada (ID del producto) a la declaración
            $stmt->bind_param("i", $productoId);
            
            // Ejecuta la consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Si se encuentra una fila, asigna la cantidad disponible del producto
            if ($row = $result->fetch_assoc()) {
                $cantidadDisponible = $row['existencias'];
            }

            // Cierra la declaración
            $stmt->close();
        }

        // Retorna la cantidad disponible
        return $cantidadDisponible;

    }


}
?>
