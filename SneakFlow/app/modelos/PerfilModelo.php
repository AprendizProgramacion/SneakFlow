<?php

    require_once __DIR__ . '/../../configuracion/conexionBD.php';

    class PerfilModelo {

        private $db;

        public function __construct() {
            $conexionBD = new ConexionBD();
            $this->db = $conexionBD->getConnection();
        }

        // Obtiene la información del perfil del usuario
        public function obtenerPerfil($usuario) {
            $stmt = $this->db->prepare("SELECT id, usuario, correo FROM usuarios WHERE usuario = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        public function actualizarUsuario($usuarioActual, $nuevoUsuario) {
            // Prepara la consulta SQL para actualizar el nombre de usuario
            $stmt = $this->db->prepare("UPDATE usuarios SET usuario = ? WHERE usuario = ?");
            
            // Vincula los parámetros: el nuevo nombre de usuario y el nombre de usuario actual
            $stmt->bind_param("ss", $nuevoUsuario, $usuarioActual);
            
            // Ejecuta la consulta y maneja el resultado
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception('Error al actualizar el usuario: ' . $stmt->error);
            }
        }
        
        
        public function actualizarCorreo($usuario, $correo) {
            // Validar el correo
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El correo proporcionado no es válido');
            }
        
            $stmt = $this->db->prepare("UPDATE usuarios SET correo = ? WHERE usuario = ?");
            $stmt->bind_param("ss", $correo, $usuario);
        
            if ($stmt->execute()) {
                return true;
                
            } else {
                throw new Exception('Error al actualizar el correo: ' . $stmt->error);
            }
        }
        
        public function actualizarContrasena($usuario, $contrasena) {
            // Hashear la nueva contraseña
            $hashedContrasena = password_hash($contrasena, PASSWORD_BCRYPT);
        
            $stmt = $this->db->prepare("UPDATE usuarios SET contrasena = ? WHERE usuario = ?");
            $stmt->bind_param("ss", $hashedContrasena, $usuario);
        
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception('Error al actualizar la contraseña: ' . $stmt->error);
            }
        }
        
        public function actualizarImagen($usuario, $imagen) {
            $stmt = $this->db->prepare("UPDATE usuarios SET imagen = ? WHERE usuario = ?");
            $stmt->bind_param("ss", $imagen, $usuario);
        
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception('Error al actualizar la imagen: ' . $stmt->error);
            }
        }     
    }
?>
