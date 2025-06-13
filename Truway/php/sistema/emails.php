<?php
require '..\..\vendor\autoload.php'; // Ajuste la ruta según sea necesario si no está usando Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            // Enviar usando SMTP
    $mail->Host       = 'smtp.ejemplo.com';                     // Configura el servidor SMTP para enviar
    $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
    $mail->Username   = 'su_email@ejemplo.com';               // Usuario SMTP
    $mail->Password   = 'su_contraseña';                        // Contraseña SMTP
    $mail->SMTPSecure = 'tls'; // Habilitar encriptación TLS
    $mail->Port       = 587;                                    // Puerto TCP para conectar
    echo "Servidor SMTP configurado correctamente.\n";
}
catch (Exception $e) {
    echo "Error al configurar el servidor SMTP: {$mail->ErrorInfo}";
    exit;
}