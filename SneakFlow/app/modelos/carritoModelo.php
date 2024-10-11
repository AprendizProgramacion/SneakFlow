<?php 
// Incluir el archivo de conexión a la base de datos
require_once __DIR__ . '/../../configuracion/conexionBD.php';

class CarritoModelo {
    private $db; // Variable para almacenar la conexión a la base de datos

    // Constructor de la clase
    public function __construct() {
        // Crear una nueva instancia de la clase de conexión a la base de datos
        $conexionBD = new ConexionBD();
        // Obtener la conexión y asignarla a la variable $db
        $this->db = $conexionBD->getConnection();
    }

    // Método para obtener productos del carrito del usuario
    public function obtenerProductos($usuario) {
        // Consulta SQL para obtener los productos del carrito junto con su información
        $query = "SELECT p.id AS producto_id, p.nombre, p.descripcion, p.imagen, p.genero, p.precio, c.cantidad, t.id AS talla_id, t.talla, t.cantidad AS cantidad_talla
                  FROM carrito c
                  JOIN productos p ON c.producto_id = p.id
                  LEFT JOIN tallas t ON c.talla_id = t.id
                  WHERE c.usuario_id = ? AND t.disponible = 1";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        // Vincular el parámetro de usuario a la consulta
        $stmt->bind_param("i", $usuario);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado de la consulta
        $resultado = $stmt->get_result();
        // Retornar todos los resultados como un arreglo asociativo
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTallasDisponibles($productoId) {
        // Consulta SQL para obtener las tallas disponibles para un producto específico
        $query = "SELECT t.id, t.talla
                    FROM tallas t
                    JOIN productos p ON t.id = p.talla_id
                    WHERE p.id = ? AND t.disponible = 1";
        
        // Preparar la consulta
        $stmt = $this->db->prepare($query);
        
        // Vincular el parámetro de ID del producto a la consulta
        $stmt->bind_param("i", $productoId);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $resultado = $stmt->get_result();
        
        // Retornar todas las tallas disponibles como un arreglo asociativo
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
       
    // Agregar un producto al carrito
    public function agregarAlCarrito($usuarioId, $productoId, $tallaId, $cantidad) {
        // Intenta actualizar la cantidad de una entrada existente en el carrito
        $queryActualizar = "UPDATE carrito 
                            SET cantidad = cantidad + ? 
                            WHERE usuario_id = ? AND producto_id = ? AND talla_id = ?";

        // Prepara la consulta para actualizar la cantidad del producto en el carrito
        $stmt = $this->db->prepare($queryActualizar);
        
        // Vincula los parámetros de la consulta (cantidad, usuarioId, productoId, tallaId)
        $stmt->bind_param("iiii", $cantidad, $usuarioId, $productoId, $tallaId);
        
        // Ejecuta la consulta de actualización
        $stmt->execute();

        // Si no se actualizó ninguna fila (es decir, el producto no estaba en el carrito), inserta una nueva entrada
        if ($stmt->affected_rows == 0) {
            // Consulta para insertar un nuevo producto en el carrito
            $queryInsertar = "INSERT INTO carrito (usuario_id, producto_id, talla_id, cantidad)
                            VALUES (?, ?, ?, ?)";

            // Prepara la consulta de inserción
            $stmt = $this->db->prepare($queryInsertar);
            
            // Vincula los parámetros de la consulta (usuarioId, productoId, tallaId, cantidad)
            $stmt->bind_param("iiii", $usuarioId, $productoId, $tallaId, $cantidad);
            
            // Ejecuta la consulta de inserción
            $stmt->execute();
        }

        // Cierra la declaración preparada
        $stmt->close();
    }

    public function actualizarProducto($productoId, $tallaId, $cantidad) {
        // Registra en el log la acción de actualizar un producto
        error_log("Actualizando producto: Producto ID: $productoId, Talla ID: $tallaId, Cantidad: $cantidad");
    
        // Consulta SQL para actualizar la cantidad y la talla del producto en el carrito
        $query = "UPDATE carrito SET cantidad = ?, talla_id = ? WHERE producto_id = ?";
        
        // Prepara la consulta SQL
        $stmt = $this->db->prepare($query);
        
        // Vincula los parámetros: cantidad, tallaId y productoId (todos son enteros)
        $stmt->bind_param("iii", $cantidad, $tallaId, $productoId);
    
        // Ejecuta la consulta y verifica si hay errores
        if (!$stmt->execute()) {
            // Si hay un error, lo registra en el log
            error_log("Error en la ejecución de la consulta: " . $stmt->error);
        }
    
        // Retorna verdadero si se actualizó alguna fila, falso en caso contrario
        return $stmt->affected_rows > 0;
    }
    
        
    // Eliminar un producto del carrito (marcar como inactivo en lugar de eliminar)
    public function eliminarDelCarrito($usuarioId, $productoId, $tallaId) {
        // Consulta SQL para eliminar la entrada del carrito para el producto especificado
        $query = "DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ? AND talla_id = ?";
        
        // Prepara la consulta SQL
        $stmt = $this->db->prepare($query);
        
        // Vincula los parámetros: usuarioId, productoId y tallaId (todos son enteros)
        $stmt->bind_param("iii", $usuarioId, $productoId, $tallaId);
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Retorna verdadero si se eliminó alguna fila, falso en caso contrario
        return $stmt->affected_rows > 0;
    }

        

    public function obtenerConteoCarrito($usuarioId) {
        // Prepara la consulta para contar los productos en el carrito del usuario
        $query = "SELECT COUNT(*) FROM carrito WHERE usuario_id = ?";
        
        // Prepara la consulta SQL
        $stmt = $this->db->prepare($query);
        
        // Verifica si la preparación fue exitosa
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . $this->db->error);
        }
    
        // Vincula el parámetro usuarioId a la consulta
        $stmt->bind_param("i", $usuarioId);
        
        // Ejecuta la consulta
        $stmt->execute();
            
        // Inicializa el conteo en 0 por defecto
        $conteo = 0;
        
        // Vincula el resultado de la consulta a la variable $conteo
        $stmt->bind_result($conteo);
        
        // Recupera el resultado
        $stmt->fetch();
        
        // Cierra la sentencia
        $stmt->close();
        
        // Retorna el conteo como un entero
        return intval($conteo);
    }
    
    
    public function eliminarTodo($usuarioId) {
        // Prepara y ejecuta la consulta para eliminar todos los productos del carrito del usuario
        $query = "DELETE FROM carrito WHERE usuario_id = ?";
        
        // Prepara la consulta SQL
        $stmt = $this->db->prepare($query);
        
        // Vincula el parámetro usuarioId a la consulta
        $stmt->bind_param("i", $usuarioId);
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Retorna true si se eliminaron filas, false en caso contrario
        return $stmt->affected_rows > 0;
    }
        
}
