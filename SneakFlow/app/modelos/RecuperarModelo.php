<?php

require_once __DIR__ . '/../../configuracion/conexionBD.php';

class RecuperarModelo {
    private $db;

    // Constructor que inicializa la conexión a la base de datos
    public function __construct() {
        $conexionBD = new ConexionBD();
        $this->db = $conexionBD->getConnection();
    }

    // Verifica si el correo existe en la base de datos
    public function verificarCorreo($correo) {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        return $stmt->get_result(); // Retorna el resultado de la consulta
    }

    // Inserta un nuevo token de recuperación en la tabla 'recuperaciones'
    public function insertarToken($usuario_id, $token) {
        $stmt = $this->db->prepare("INSERT INTO recuperaciones (usuario_id, token) VALUES (?, ?)");
        $stmt->bind_param("is", $usuario_id, $token);
        return $stmt->execute(); // Retorna verdadero si la inserción fue exitosa
    }

    // Verifica si el token es válido y no ha expirado (menos de 24 horas)
    public function verificarToken($token) {
        $stmt = $this->db->prepare("SELECT usuario_id FROM recuperaciones WHERE token = ? AND NOW() < DATE_ADD(created_at, INTERVAL 24 HOUR)");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        return $stmt->get_result(); // Retorna el resultado de la verificación del token
    }

    // Actualiza la contraseña del usuario utilizando un nuevo valor
    public function actualizarContrasena($usuario_id, $nueva_contrasena) {
        // Hashear la nueva contraseña antes de almacenarla
        $nueva_contrasena = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
        
        $stmt = $this->db->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
        $stmt->bind_param("si", $nueva_contrasena, $usuario_id);
        return $stmt->execute(); // Retorna verdadero si la actualización fue exitosa
    }

    // Elimina el token de recuperación de la base de datos
    public function eliminarToken($token) {
        $stmt = $this->db->prepare("DELETE FROM recuperaciones WHERE token = ?");
        $stmt->bind_param("s", $token);
        return $stmt->execute(); // Retorna verdadero si la eliminación fue exitosa
    }
}
?>
