<?php
require_once __DIR__ . '/../../configuracion/conexionBD.php';

class BusquedaModelo {
    private $db; // Variable para almacenar la conexión a la base de datos

    // Constructor de la clase
    public function __construct() {
        // Crear una nueva instancia de la clase de conexión a la base de datos
        $conexionBD = new ConexionBD();
        // Obtener la conexión y asignarla a la variable $db
        $this->db = $conexionBD->getConnection();
    }

    public function buscarProductos($query) {
        // Escapar el término de búsqueda para evitar inyecciones SQL
        $query = '%' . $this->db->real_escape_string($query) . '%';
    
        // Consulta SQL para buscar productos por nombre, descripción o marca
        $sql = "SELECT productos.* 
                FROM productos 
                INNER JOIN marcas ON productos.marca_id = marcas.id 
                WHERE productos.nombre LIKE ? 
                OR productos.descripcion LIKE ? 
                OR marcas.marca LIKE ?";
    
        // Preparar la consulta
        $stmt = $this->db->prepare($sql);
        
        // Vincular los parámetros (el término de búsqueda se aplica en tres lugares)
        $stmt->bind_param('sss', $query, $query, $query);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener los resultados
        $result = $stmt->get_result();
        $productos = $result->fetch_all(MYSQLI_ASSOC);
    
        // Cierra la conexión y devuelve los productos
        $stmt->close();
        return $productos;
    }   
}
?>
