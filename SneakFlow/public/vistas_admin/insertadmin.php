<?php
    // Incluir el archivo de configuración para la conexión a la base de datos
    require_once __DIR__ . '/../configuracion/conexionBD.php';

    // Función para agregar un usuario a la base de datos
    function agregarUsuario($usuario, $correo, $contrasena, $rol) {
        // Crear una nueva instancia de ConexionBD
        $conexion = new ConexionBD();
        $db = $conexion->getConnection();

        // Encriptar la contraseña usando bcrypt
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        // Preparar la consulta para insertar el nuevo usuario
        $query = "INSERT INTO usuarios (usuario, correo, contrasena, rol) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssss", $usuario, $correo, $contrasena, $rol);
        
        // Ejecutar la consulta y manejar el resultado
        if ($stmt->execute()) {
            echo "Usuario $usuario registrado exitosamente.<br>";
        } else {
            echo "Error al registrar el usuario $usuario: " . $stmt->error . "<br>";
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
        $conexion->close();
    }

    // Agregar usuarios al sistema
    agregarUsuario('Admin1', 'admin@gmail.com', '123456789', 'administrador');
    agregarUsuario('Admin2', 'admin1@email.com', '123456789', 'administrador');
    agregarUsuario('Admin3', 'admin2@email.com', '123456789', 'administrador'); // Corregido el typo en el email

?>
