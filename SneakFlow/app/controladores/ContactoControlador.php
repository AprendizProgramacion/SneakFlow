<?php

class ContactoControlador {
    private $model; // Propiedad para almacenar la instancia del modelo de contacto

    public function __construct() {
        // Inicializamos el modelo de contacto al crear el controlador
        $this->model = new ContactoModelo();
    }

    public function contacto() {
        // Incluimos la vista de contacto
        include_once __DIR__ . '/../../public/vistas/contactenos/contactenos.php';
    }

    public function enviarEmail() {
        // Verificamos si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recogemos y limpiamos los datos del formulario
            $nombre_completo = trim($_POST['nombre_completo']);
            $email = trim($_POST['email']);
            $asunto = trim($_POST['asunto']);
            $mensaje = trim($_POST['mensaje']);

            // Validar los datos usando el modelo
            if ($this->model->validate($nombre_completo, $email, $asunto, $mensaje)) {
                // Enviar el correo usando el modelo
                if ($this->model->sendEmail($nombre_completo, $email, $asunto, $mensaje)) {
                    // Responder con JSON de éxito si el correo se envió correctamente
                    echo json_encode(['success' => true, 'message' => 'Mensaje enviado con éxito.']);
                } else {
                    // Responder con JSON de error si hubo un problema al enviar el mensaje
                    echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje.']);
                }
            } else {
                // Responder con JSON de error de validación si los datos no son válidos
                echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos correctamente.']);
            }
        } else {
            // Responder con un error si no es un método POST
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        }

        // Terminar la ejecución para evitar cargar vistas adicionales
        exit;
    }
}
