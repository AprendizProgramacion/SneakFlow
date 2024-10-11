<?php

// Incluye el archivo de configuración para la conexión a la base de datos
require_once __DIR__ . '/../../configuracion/conexionBD.php';

// Incluye el modelo de recuperación que maneja la lógica para el proceso de recuperación
require_once __DIR__ . '/../modelos/RecuperarModelo.php'; // Incluye el modelo

// Inicia la sesión para gestionar la información del usuario a lo largo de la aplicación
session_start();

// Importa las clases necesarias de PHPMailer para el envío de correos electrónicos
use PHPMailer\PHPMailer\PHPMailer; // Clase principal para el envío de correos
use PHPMailer\PHPMailer\Exception; // Clase de excepción para manejar errores en PHPMailer

// Incluye los archivos necesarios de PHPMailer para su funcionamiento
require_once __DIR__ . '/../../PHPmailer/Exception.php'; // Archivo de excepciones de PHPMailer
require_once __DIR__ . '/../../PHPmailer/PHPMailer.php'; // Archivo principal de PHPMailer
require_once __DIR__ . '/../../PHPmailer/SMTP.php'; // Archivo para el soporte de SMTP en PHPMailer


class RecuperarControlador {
    private $modelo;

    public function __construct() {
        // Instancia del modelo que maneja la lógica de recuperación
        $this->modelo = new RecuperarModelo(); 
    }

    public function enviarEnlace() {
        // Obtiene el correo electrónico enviado desde el formulario
        $correo = $_POST['email'];

        // Verifica si el correo está registrado en la base de datos
        $result = $this->modelo->verificarCorreo($correo);
        
        if ($result->num_rows > 0) {
            // Si el correo está registrado, obtiene el ID del usuario
            $usuario_id = $result->fetch_assoc()['id'];
            
            // Genera un token único para la recuperación de la contraseña
            $token = bin2hex(random_bytes(16));
            
            // Inserta el token en la base de datos asociado al usuario
            $this->modelo->insertarToken($usuario_id, $token);

            // Envía el correo electrónico con el enlace de recuperación
            $this->enviarCorreo($correo, $token);
        } else {
            // Si el correo no está registrado, muestra un mensaje de alerta
            echo '<script>
                alert("El correo electrónico no está registrado.");
                window.location = "Recuperar_Contrasena";
            </script>';
        }
    }

    private function enviarCorreo($correo, $token) {
        // Crea una nueva instancia de PHPMailer
        $mail = new PHPMailer(true);
        
        // Configura opciones de seguridad para SMTP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false, // Desactiva la verificación del certificado del servidor
                'verify_peer_name' => false, // Desactiva la verificación del nombre del servidor
                'allow_self_signed' => true // Permite certificados autofirmados
            )
        );
    
        try {
            // Configura el uso de SMTP
            $mail->isSMTP(); // Activa la funcionalidad SMTP
            $mail->Host       = 'smtp.gmail.com'; // Establece el servidor SMTP de Gmail
            $mail->SMTPAuth   = true; // Habilita la autenticación SMTP
            $mail->Username   = 'sn3akflow@gmail.com'; // Tu dirección de correo de Gmail
            $mail->Password   = 'wajh ufgp xwno xhjt'; // Tu contraseña de Gmail (considera usar una contraseña de aplicación)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Activa el cifrado TLS
            $mail->Port       = 587; // Establece el puerto TCP para la conexión
        
            // Configuración del correo
            $mail->setFrom('sn3akflow@gmail.com', 'Sneak~Flow'); // Remitente del correo
            $mail->addAddress($correo); // Agrega el destinatario (correo del usuario que solicita recuperación)
            $mail->isHTML(true); // Establece que el correo será en formato HTML
            $mail->Subject = 'Instrucciones para Restablecer tu Contraseña'; // Asunto del correo
        
            // Cuerpo del correo en HTML
            $mail->Body    = '
                <div style="font-family: Arial, sans-serif; color: #333;">
                    <h2 style="color: #4CAF50;">Recuperación de Contraseña</h2>
                    <p>Hola,</p>
                    <p>Hemos recibido una solicitud para restablecer tu contraseña. Si no solicitaste este cambio, por favor ignora este correo. De lo contrario, puedes restablecer tu contraseña haciendo clic en el enlace a continuación:</p>
                    <p style="text-align: center;">
                        <a href="http://localhost/SneakFlow/public/Nueva_contrasena?token=' . $token . '" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Restablecer Contraseña</a>
                    </p>
                    <p>Este enlace es válido por 24 horas. Después de este tiempo, deberás solicitar un nuevo enlace de recuperación.</p>
                    <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
                    <p>Gracias,</p>
                    <p>El equipo de SneakFlow</p>
                    <hr style="border: none; border-top: 1px solid #ddd;">
                    <p style="font-size: 12px; color: #777;">Este es un mensaje automático, por favor no respondas a este correo.</p>
                </div>';                    
        
            // Envía el correo
            $mail->send(); // Intenta enviar el correo
        
            // Mensaje de éxito
            echo '<script>
                alert("El enlace de recuperación ha sido enviado a tu correo electrónico.");
                window.location = "Recuperar_Contrasena"; // Redirige al usuario a la página de recuperación
            </script>';
        } catch (Exception $e) {
            // Manejo de errores en caso de que no se envíe el correo
            echo "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}"; // Muestra un mensaje de error
        }
    }        

    public function actualizarContrasena() {
        // Obtiene el token y la nueva contraseña del formulario
        $token = $_POST['token'];
        $nueva_contrasena = $_POST['password'];
    
        // Cifra la nueva contraseña usando password_hash
        $nueva_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    
        // Verifica si el token es válido
        $result = $this->modelo->verificarToken($token);
        
        if ($result->num_rows > 0) {
            // Si el token es válido, obtiene el ID del usuario asociado
            $usuario_id = $result->fetch_assoc()['usuario_id'];
    
            // Actualiza la contraseña del usuario en la base de datos
            $this->modelo->actualizarContrasena($usuario_id, $nueva_contrasena);
    
            // Elimina el token de la base de datos (ya no es necesario)
            $this->modelo->eliminarToken($token);
    
            // Mensaje de éxito y redirección al inicio de sesión
            echo '<script>
                alert("Contraseña actualizada correctamente.");
                window.location = "login"; // Redirige al usuario a la página de inicio de sesión
            </script>';
        } else {
            // Si el token no es válido, muestra un mensaje de error
            echo '<script>
                alert("El enlace de recuperación es inválido o ha expirado.");
                window.location = "Recuperar_Contrasena"; // Redirige al usuario a la página de recuperación
            </script>';
        }
    }
}    
?>
