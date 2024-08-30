<?php

    require_once __DIR__ . '/../../configuracion/conexionBD.php';

    class CarritoModelo {
        private $db;

        public function __construct() {
            $conexionBD = new ConexionBD();
            $this->db = $conexionBD->getConnection();
        }


        // Obtener productos del carrito del usuario
        public function obtenerProductos($usuario) {
            $query = "SELECT p.id AS producto_id, p.nombre, p.descripcion, p.imagen, p.genero, p.precio, c.cantidad, t.id AS talla_id, t.talla, t.cantidad AS cantidad_talla
                    FROM carrito c
                    JOIN productos p ON c.producto_id = p.id
                    LEFT JOIN tallas t ON c.talla_id = t.id
                    WHERE c.usuario_id = ? AND c.estado = 1 AND t.disponible = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $usuario);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        
        public function obtenerTallasDisponibles($productoId) {
            $query = "SELECT t.id, t.talla
                      FROM tallas t
                      JOIN productos p ON t.id = p.talla_id
                      WHERE p.id = ? AND t.disponible = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $productoId);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
           
        // Agregar un producto al carrito
        public function agregarAlCarrito($usuarioId, $productoId, $tallaId, $cantidad) {
            $query = "INSERT INTO carrito (usuario_id, producto_id, talla_id, cantidad, estado)
                      VALUES (?, ?, ?, ?, 1)
                      ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad), estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iiii", $usuarioId, $productoId, $tallaId, $cantidad);
            $stmt->execute();
        }
        

        public function actualizarCarrito($productoId, $tallaId, $cantidad) {
            $query = "UPDATE carrito
                      SET cantidad = ?
                      WHERE producto_id = ? AND talla_id = ? AND estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iii", $cantidad, $productoId, $tallaId);
            $stmt->execute();
        }
        
        

        // Eliminar un producto del carrito (marcar como inactivo en lugar de eliminar)
        public function eliminarDelCarrito($usuarioId, $productoId, $tallaId) {
            // Actualiza el estado del carrito para el producto especificado
            $query = "UPDATE carrito
                      SET estado = 0
                      WHERE usuario_id = ? AND producto_id = ? AND talla_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iii", $usuarioId, $productoId, $tallaId);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        }


    }

?>