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
            p.marca, 
            p.genero, 
            p.color, 
            p.descuento,
            p.existencias,
            GROUP_CONCAT(t.id ORDER BY t.talla ASC) as id_tallas,
            GROUP_CONCAT(t.talla ORDER BY t.talla ASC) as tallas
        FROM productos p
        LEFT JOIN tallas t ON p.id = t.producto_id
        WHERE p.existencias >= 1
    ";
    
        // Arreglo para almacenar condiciones adicionales basadas en los filtros
        $conditions = [];
    
        // Verifica si se han pasado filtros y los agrega a la consulta SQL
        if (!empty($filtros)) {
            // Filtra por marca si está presente en los filtros
            if (!empty($filtros['marca'])) {
                $conditions[] = "p.marca IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['marca'])) . "')";
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
                $conditions[] = "p.color IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['color'])) . "')";
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
            $query .= " AND " . implode(" AND ", $conditions);
        }
    
        $query .= " GROUP BY p.id";

        $query .= " LIMIT ? OFFSET ?";
    
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $limite, $offset);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function contarProductos($filtros = []) {
        $query = "
            SELECT COUNT(DISTINCT p.id) as total
            FROM productos p
            LEFT JOIN tallas t ON p.id = t.producto_id
            WHERE p.existencias >= 1
        ";

        $conditions = [];
        
        // Verifica si se han pasado filtros y los agrega a la consulta SQL
        if (!empty($filtros)) {
            // Filtra por marca si está presente en los filtros
            if (!empty($filtros['marca'])) {
                $conditions[] = "p.marca IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['marca'])) . "')";
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
                $conditions[] = "p.color IN ('" . implode("','", array_map([$this->db, 'escape_string'], $filtros['color'])) . "')";
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
            $query .= " AND " . implode(" AND ", $conditions);
        }
    
        $resultado = $this->db->query($query);
        $data = $resultado->fetch_assoc();
        return $data['total'];
    
    
    }

    public function mostrarProductos() {
        // Obtiene los filtros de la solicitud (GET)
        $filtros = [];
        if (isset($_GET['marca'])) {
            $filtros['marca'] = $_GET['marca'];
        }
        if (isset($_GET['genero'])) {
            $filtros['genero'] = $_GET['genero'];
        }
        // En tu archivo PHP que procesa el formulario
        if (isset($_GET['talla'])) {
            $filtros['talla'] = $_GET['talla'];
        }

        if (isset($_GET['color'])) {
            $filtros['color'] = $_GET['color'];
        }
        if (isset($_GET['descuento'])) {
            $filtros['descuento'] = $_GET['descuento'];
        }
        if (isset($_GET['precio_min']) && isset($_GET['precio_max'])) {
            $filtros['precio_min'] = $_GET['precio_min'];
            $filtros['precio_max'] = $_GET['precio_max'];
        }
    }


    
    // Método para obtener los detalles de un producto específico por su ID
    public function obtenerProductoPorId($id) {
        $query = "
            SELECT 
                p.id, 
                p.nombre, 
                p.descripcion, 
                p.precio, 
                p.imagen, 
                p.marca, 
                p.genero, 
                p.color, 
                p.descuento,
                p.existencias,
                GROUP_CONCAT(t.id ORDER BY t.talla ASC) as id_tallas,
                GROUP_CONCAT(t.talla ORDER BY t.talla ASC) as tallas
            FROM productos p
            LEFT JOIN tallas t ON p.id = t.producto_id
            WHERE p.id = ?
            GROUP BY p.id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
    


    // Método para agregar una nueva talla a un producto
    public function agregarTalla($producto_id, $talla) {
        // Inserta la nueva talla en la tabla tallas
        $stmt = $this->db->prepare("INSERT INTO tallas (producto_id, talla) VALUES (?, ?)");
        $stmt->bind_param("is", $producto_id, $talla);
        $stmt->execute();
    
        // Actualiza el número de existencias en la tabla productos
        $stmt = $this->db->prepare("UPDATE productos SET existencias = existencias + 1 WHERE id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
    }

    // Método para eliminar una talla de un producto
    public function eliminarTalla($producto_id, $talla) {
        // Elimina la talla de la tabla tallas
        $stmt = $this->db->prepare("DELETE FROM tallas WHERE producto_id = ? AND talla = ?");
        $stmt->bind_param("is", $producto_id, $talla);
        $stmt->execute();
    
        // Actualiza el número de existencias en la tabla productos
        $stmt = $this->db->prepare("UPDATE productos SET existencias = existencias - 1 WHERE id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
    }
    
}
?>
