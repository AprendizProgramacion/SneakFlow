<?php

require_once __DIR__ . '/../../configuracion/conexionBD.php'; // Incluir el archivo de conexión a la base de datos

class PerfilModelo {

    private $db; // Propiedad para almacenar la conexión a la base de datos

    // Constructor de la clase
    public function __construct() {
        $conexionBD = new ConexionBD(); // Crear una nueva instancia de la clase de conexión
        $this->db = $conexionBD->getConnection(); // Obtener la conexión a la base de datos
    }

    // Obtiene la información del perfil del usuario
    public function obtenerPerfil($usuario) {
        // Prepara la consulta SQL para seleccionar el id, usuario y correo del usuario especificado
        $stmt = $this->db->prepare("SELECT id, usuario, correo FROM usuarios WHERE usuario = ?");
        // Vincula el parámetro (el nombre de usuario)
        $stmt->bind_param("s", $usuario);
        // Ejecuta la consulta
        $stmt->execute();
        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();
        // Devuelve la información del usuario como un array asociativo
        return $result->fetch_assoc();
    }

    // Actualiza el nombre de usuario
    public function actualizarUsuario($usuarioActual, $nuevoUsuario) {
        // Prepara la consulta SQL para actualizar el nombre de usuario
        $stmt = $this->db->prepare("UPDATE usuarios SET usuario = ? WHERE usuario = ?");
        
        // Vincula los parámetros: el nuevo nombre de usuario y el nombre de usuario actual
        $stmt->bind_param("ss", $nuevoUsuario, $usuarioActual);
        
        // Ejecuta la consulta y maneja el resultado
        if ($stmt->execute()) {
            return true; // Retorna true si la actualización fue exitosa
        } else {
            // Lanza una excepción si hay un error en la ejecución
            throw new Exception('Error al actualizar el usuario: ' . $stmt->error);
        }
    }
    
    // Actualiza el correo del usuario
    public function actualizarCorreo($usuario, $correo) {
        // Validar el correo para asegurarse de que tiene un formato correcto
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El correo proporcionado no es válido'); // Lanza una excepción si el correo no es válido
        }
    
        // Prepara la consulta SQL para actualizar el correo
        $stmt = $this->db->prepare("UPDATE usuarios SET correo = ? WHERE usuario = ?");
        // Vincula los parámetros: el nuevo correo y el nombre de usuario
        $stmt->bind_param("ss", $correo, $usuario);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            return true; // Retorna true si la actualización fue exitosa
        } else {
            // Lanza una excepción si hay un error en la ejecución
            throw new Exception('Error al actualizar el correo: ' . $stmt->error);
        }
    }
    
    // Actualiza la contraseña del usuario
    public function actualizarContrasena($usuario, $contrasena) {
        // Hashear la nueva contraseña antes de almacenarla en la base de datos
        $hashedContrasena = password_hash($contrasena, PASSWORD_BCRYPT);
    
        // Prepara la consulta SQL para actualizar la contraseña
        $stmt = $this->db->prepare("UPDATE usuarios SET contrasena = ? WHERE usuario = ?");
        // Vincula los parámetros: la nueva contraseña y el nombre de usuario
        $stmt->bind_param("ss", $hashedContrasena, $usuario);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            return true; // Retorna true si la actualización fue exitosa
        } else {
            // Lanza una excepción si hay un error en la ejecución
            throw new Exception('Error al actualizar la contraseña: ' . $stmt->error);
        }
    }
    
    // Actualiza la imagen del usuario
    public function actualizarImagen($usuario, $imagen) {
        // Prepara la consulta SQL para actualizar la imagen del usuario
        $stmt = $this->db->prepare("UPDATE usuarios SET imagen = ? WHERE usuario = ?");
        // Vincula los parámetros: la nueva imagen y el nombre de usuario
        $stmt->bind_param("ss", $imagen, $usuario);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            return true; // Retorna true si la actualización fue exitosa
        } else {
            // Lanza una excepción si hay un error en la ejecución
            throw new Exception('Error al actualizar la imagen: ' . $stmt->error);
        }
    }     
}
?>
