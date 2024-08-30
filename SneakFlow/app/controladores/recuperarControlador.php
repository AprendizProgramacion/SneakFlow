<?php

    require_once __DIR__ . '/../../configuracion/conexionBD.php'; // Incluye el archivo de conexión a la base de datos

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once __DIR__  . '/../../PHPmailer/Exception.php'; // Incluye la clase de excepción de PHPMailer
    require_once __DIR__  .  '/../../PHPmailer/PHPMailer.php'; // Incluye la clase PHPMailer
    require_once __DIR__  . '/../../PHPmailer/SMTP.php'; // Incluye la clase SMTP de PHPMailer

    class RecuperarControlador {

        private $db;

        public function __construct() {
            $conexionBD = new ConexionBD(); // Crea una instancia de la clase ConexionBD
            $this->db = $conexionBD->getConnection(); // Obtiene la conexión a la base de datos
        }

        public function enviarEnlace() {
            $correo = $_POST['email']; // Obtiene el correo electrónico del formulario
            
            // Verificar si el correo existe en la base de datos
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = ?");
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $usuario_id = $result->fetch_assoc()['id'];
                
                // Generar un token único para la recuperación
                $token = bin2hex(random_bytes(16));
                
                // Insertar el token en la base de datos
                $stmt = $this->db->prepare("INSERT INTO recuperaciones (usuario_id, token) VALUES (?, ?)");
                $stmt->bind_param("is", $usuario_id, $token);
                $stmt->execute();
                
                // Configuración del correo electrónico para enviar el enlace de recuperación
                $mail = new PHPMailer(true);
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                
                try {
                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'sn3akflow@gmail.com';
                    $mail->Password   = 'wajh ufgp xwno xhjt'; // Usa una contraseña de aplicación para Gmail
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    // Remitente y destinatario del correo
                    $mail->setFrom('sn3akflow@gmail.com', 'Sneak~Flow');
                    $mail->addAddress($correo);

                    // Configuración del contenido del correo
                    $mail->isHTML(true);    
                    $mail->Subject = 'Instrucciones para Restablecer tu Contraseña';
                    $mail->Body    = '
                        <div style="font-family: Arial, sans-serif; color: #333;">
                            <h2 style="color: #4CAF50;">Recuperación de Contraseña</h2>
                            <p>Hola,</p>
                            <p>Hemos recibido una solicitud para restablecer tu contraseña. Si no solicitaste este cambio, por favor ignora este correo. De lo contrario, puedes restablecer tu contraseña haciendo clic en el enlace a continuación:</p>
                            <p style="text-align: center;">
                                <a href="http://localhost/SneakFlow/public/nueva_contrasena?token=' . $token . '" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Restablecer Contraseña</a>
                            </p>
                            <p>Este enlace es válido por 24 horas. Después de este tiempo, deberás solicitar un nuevo enlace de recuperación.</p>
                            <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
                            <p>Gracias,</p>
                            <p>El equipo de SneakFlow</p>
                            <hr style="border: none; border-top: 1px solid #ddd;">
                            <p style="font-size: 12px; color: #777;">Este es un mensaje automático, por favor no respondas a este correo.</p>
                        </div>';                    
                    $mail->send();
                    // Mensaje y redirección si el correo se envía exitosamente
                    echo '<script>
                        alert("El enlace de recuperación ha sido enviado a tu correo electrónico.");
                        window.location = "recuperar";
                    </script>';
                } catch (Exception $e) {
                    // Mensaje de error si el correo no se puede enviar
                    echo "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                // Mensaje si el correo no está registrado
                echo '<script>
                    alert("El correo electrónico no esta registrado.");
                    window.location = "recuperar";
                </script>';
            }
        }

        public function actualizarContrasena() {
            $token = $_POST['token'];
            $nueva_contrasena = $_POST['password'];
            $nueva_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT); 
        
            // Depuración: Verifica el token antes de la consulta
            var_dump($token);
        
            // Verificar el token en la base de datos
            $stmt = $this->db->prepare("SELECT usuario_id FROM recuperaciones WHERE token = ? AND NOW() < DATE_ADD(created_at, INTERVAL 24 HOUR)");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $usuario_id = $result->fetch_assoc()['usuario_id'];
        
                // Actualizar la contraseña en la base de datos
                $stmt = $this->db->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
                $stmt->bind_param("si", $nueva_contrasena, $usuario_id);
                $stmt->execute();
                
                // Eliminar el token de recuperación después de usarlo
                $stmt = $this->db->prepare("DELETE FROM recuperaciones WHERE token = ?");
                $stmt->bind_param("s", $token);
                $stmt->execute();
        
                echo '<script>
                    alert("Contraseña actualizada correctamente.");
                    window.location = "login";
                </script>';
            } else {
                echo '<script>
                    alert("El enlace de recuperación es inválido o ha expirado.");
                    window.location = "recuperar";
                </script>';
            }
        }
        
        
    }
?>
