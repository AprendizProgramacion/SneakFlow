<?php
    // Importa la clase PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    // Importa la clase Exception de PHPMailer para manejar excepciones
    use PHPMailer\PHPMailer\Exception; 

    require_once __DIR__  . '/../../PHPmailer/Exception.php'; // Incluye la clase de excepción de PHPMailer
    require_once __DIR__  .  '/../../PHPmailer/PHPMailer.php'; // Incluye la clase PHPMailer
    require_once __DIR__  . '/../../PHPmailer/SMTP.php'; // Incluye la clase SMTP de PHPMailer

    class ContactoModelo {

        public function validate($nombre_completo, $email, $asunto, $mensaje) {
            // Verifica si alguno de los campos está vacío
            if (empty($nombre_completo) || empty($email) || empty($asunto) || empty($mensaje)) {
                return false; // Retorna falso si algún campo está vacío
            }
        
            // Validar formato de correo electrónico utilizando filter_var
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false; // Retorna falso si el formato del correo electrónico no es válido
            }
        
            return true; // Retorna verdadero si todas las validaciones pasan
        }
        

        public function sendEmail($nombre_completo, $email, $asunto, $mensaje) {
            // Crear una nueva instancia de PHPMailer para enviar el correo
            $mail = new PHPMailer(true);
        
            // Configuración de opciones SMTP para permitir conexiones seguras
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false, // Desactiva la verificación del par SSL
                    'verify_peer_name' => false, // Desactiva la verificación del nombre del par SSL
                    'allow_self_signed' => true // Permite certificados autofirmados
                )
            );
        
            try {
                // Configuración del servidor SMTP para el envío del correo
                $mail->isSMTP(); // Indica que se va a usar SMTP
                $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP de Gmail
                $mail->SMTPAuth   = true; // Habilita la autenticación SMTP
                $mail->Username   = 'sn3akflow@gmail.com'; // Usuario para la autenticación
                $mail->Password   = 'wajh ufgp xwno xhjt'; // Contraseña de aplicación para Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita TLS
                $mail->Port       = 587; // Puerto para conexiones TLS
            
                // Configuración del remitente y destinatario del correo
                $mail->setFrom($email, $nombre_completo);  // El correo que envía y su nombre
                $mail->addAddress('sn3akflow@gmail.com', 'SneakFlow');  // El destinatario del correo
            
                // Configuración del contenido del correo
                $mail->isHTML(true); // Indica que el contenido es HTML
                $mail->Subject = $asunto; // Asunto del correo
                $mail->Body    = nl2br($mensaje);  // Cuerpo del correo, convierte saltos de línea en etiquetas <br>
                $mail->AltBody = strip_tags($mensaje);  // Texto plano para clientes que no soportan HTML
            
                // Intentar enviar el correo
                $mail->send();
                return true;  // Indica que el envío fue exitoso
            } catch (Exception $e) {
                // En caso de error durante el envío, se registra el error
                error_log('Error al enviar el correo: ' . $mail->ErrorInfo);
                return false;  // Indica que el envío falló
            }            
        }
    }
