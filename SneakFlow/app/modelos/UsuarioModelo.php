<?php

require_once __DIR__ . '/../../configuracion/conexionBD.php'; // Incluye el archivo de conexión a la base de datos

class UsuarioModelo {

    private $db;

    public function __construct() {
        $conexionBD = new ConexionBD(); // Crea una instancia de la conexión a la base de datos
        $this->db = $conexionBD->getConnection(); // Obtiene la conexión a la base de datos
    }

    // Obtiene los datos del usuario por su ID
    public function obtenerUsuarioPorId($id) {
        $stmt = $this->db->prepare("SELECT  usuario, correo, rol FROM usuarios WHERE id = ?"); // Prepara la consulta
        $stmt->bind_param("i", $id); // Víncula el parámetro (i para entero)
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result(); // Obtiene el resultado
        return $result->fetch_assoc(); // Devuelve los datos como un array asociativo
    }

    // Obtiene los datos del usuario por su nombre
    public function obtenerUsuarioPorNombre($usuario) {
        $stmt = $this->db->prepare("SELECT id, usuario, contrasena, rol FROM usuarios WHERE usuario = ?"); // Prepara la consulta
        $stmt->bind_param("s", $usuario); // Víncula el parámetro
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result(); // Obtiene el resultado
        return $result->fetch_assoc(); // Devuelve los datos como un array asociativo
    }

    // Verifica si el usuario o correo ya existen en la base de datos
    public function verificarUsuarioExistente($usuario, $correo) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ? OR usuario = ?"); // Prepara la consulta
        $stmt->bind_param("ss", $correo, $usuario); // Víncula los parámetros
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result(); // Obtiene el resultado
        return $result->num_rows > 0; // Devuelve verdadero si hay registros, falso si no hay
    }

    // Registra un nuevo usuario en la base de datos
    public function registrarUsuario($usuario, $correo, $contraseña) {
        $stmt = $this->db->prepare("INSERT INTO usuarios (usuario, correo, contrasena) VALUES (?, ?, ?)"); // Prepara la consulta
        $stmt->bind_param("sss", $usuario, $correo, $contraseña); // Víncula los parámetros
        return $stmt->execute(); // Ejecuta la consulta y devuelve el resultado
    }
}
?>
