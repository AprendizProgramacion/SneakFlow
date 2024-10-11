<?php
    class FavoritoModelo {
        private $db;

        public function __construct() {
            $conexionBD = new ConexionBD();
            $this->db = $conexionBD->getConnection();
        }

        // Obtener los favoritos activos de un usuario
        public function obtenerFavoritos($usuarioId) {
            $query = "
                SELECT 
                    f.usuario_id, 
                    f.producto_id, 
                    f.estado,
                    f.fecha_creacion
                FROM favoritos f
                WHERE f.usuario_id = ? AND f.estado = 1
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $usuarioId);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        

        // Agregar o activar un producto en favoritos
        public function agregarFavorito($usuarioId, $productoId) {
            $stmt = $this->db->prepare("
                INSERT INTO favoritos (usuario_id, producto_id, estado, fecha_creacion) 
                VALUES (?, ?, 1, NOW()) 
                ON DUPLICATE KEY UPDATE estado = 1
            ");
            $stmt->bind_param("ii", $usuarioId, $productoId);
            return $stmt->execute();
        }
        

        // Desactivar un producto en favoritos (cambiar estado a 0)
        public function eliminarFavorito($usuarioId, $productoId) {
            $stmt = $this->db->prepare("UPDATE favoritos SET estado = 0 WHERE usuario_id = ? AND producto_id = ?");
            $stmt->bind_param("ii", $usuarioId, $productoId);
            return $stmt->execute();
        }

        // Desactivar todos los productos en favoritos de un usuario
        public function eliminarTodosFavoritos($usuarioId) {
            $stmt = $this->db->prepare("DELETE FROM favoritos WHERE usuario_id = ?");
            $stmt->bind_param("i", $usuarioId);
            return $stmt->execute();
        }        

        // Obtener el conteo de favoritos activos de un usuario
        public function obtenerConteoFavoritos($usuarioId) {
            // Prepara la consulta para contar los favoritos activos del usuario
            $query = "SELECT COUNT(*) FROM favoritos WHERE usuario_id = ? AND estado = 1";
            $stmt = $this->db->prepare($query);
            
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . $this->db->error);
            }
            
            // Enlaza el parámetro del usuario_id
            $stmt->bind_param("i", $usuarioId);
            
            // Ejecuta la consulta
            $stmt->execute();
            
            // Inicializa conteo en 0 por defecto
            $conteo = 0;
            
            // Enlaza el resultado de la consulta
            $stmt->bind_result($conteo);
            
            // Obtiene el resultado
            if ($stmt->fetch()) {
                // Solo asigna el conteo si fetch fue exitoso
                $conteo = intval($conteo); // Asegúrate de que sea un entero
            }
            
            // Cierra el statement
            $stmt->close();
            
            // Devuelve el conteo de favoritos activos
            return $conteo;
        }
        
        
        

        public function verificarFavorito($usuarioId, $productoId) {
            $query = "SELECT estado FROM favoritos WHERE usuario_id = ? AND producto_id = ?";
            $stmt = $this->db->prepare($query);
        
            // Verificar si la preparación de la consulta fue exitosa
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . $this->db->error);
            }
        
            // Enlaza los parámetros
            $stmt->bind_param("ii", $usuarioId, $productoId);
            $stmt->execute();
            
            $estado = null; // Inicializar en null para evitar "undefined variable"

            // Obtener el resultado
            $stmt->bind_result($estado);
        
            // Inicializa el resultado
            $resultado = null;
        
            // Si se obtiene un resultado, asignar el estado
            if ($stmt->fetch()) {
                $resultado = ['estado' => $estado];
            }
        
            // Cierra el statement
            $stmt->close();
        
            // Devolver el resultado, ya sea un array con el estado o null
            return $resultado;
        }
        

        public function actualizarFavorito($usuarioId, $productoId, $estado) {
            $query = "UPDATE favoritos SET estado = ? WHERE usuario_id = ? AND producto_id = ?";
            
            if ($stmt = $this->db->prepare($query)) {
                // Vincular parámetros
                $stmt->bind_param("iii", $estado, $usuarioId, $productoId);
                
                // Ejecutar la consulta
                $result = $stmt->execute();
                
                // Cerrar el statement
                $stmt->close();
                
                return $result;
            } else {
                // Manejar errores de preparación de la consulta
                echo "Error: " . $this->db->error;
                return false;
            }
        }
        
        // Método para obtener las tallas disponibles para un producto dado su ID
        public function obtenerTallasPorProductoId($productoId) {
            // Consulta SQL para seleccionar las tallas donde el ID del producto coincida
            $query = "SELECT talla FROM tallas WHERE producto_id = ?";
            
            // Preparar la declaración
            $stmt = $this->db->prepare($query);
            
            // Asocia el parámetro de entrada (ID del producto) a la declaración
            $stmt->bind_param('i', $productoId);
            
            // Ejecuta la consulta
            $stmt->execute();
            
            // Obtiene el resultado de la ejecución
            $resultado = $stmt->get_result();
            
            // Inicializa un array para almacenar las tallas
            $tallas = [];
            
            // Itera sobre cada fila del resultado y añade la talla al array
            while ($fila = $resultado->fetch_assoc()) {
                $tallas[] = $fila['talla'];
            }
            
            // Cierra la declaración
            $stmt->close();
            
            // Retorna el array de tallas
            return $tallas;
        }

    }
?>
