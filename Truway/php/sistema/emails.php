<?php
session_start();
include('conexion.php');
$id_usuario = $_SESSION['id'] ?? 0;
$email_usuario = $_SESSION['email'] ?? '';
$nombre_usuario = $_SESSION['nombre'] ?? '';
// Cargamos PHPMailer manualmente
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Mailgun
    $mail->isSMTP();
    $mail->Host = 'smtp.mailgun.org';
    $mail->SMTPAuth = true;
    $mail->Username = 'postmaster@truway.mailgun.org'; // el usuario SMTP de Mailgun
    $mail->Password = 'CONTRASEÑA'; // la clave SMTP de Mailgun
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Remitente y destinatario
    $mail->setFrom('ejemplo@dominio.com', 'Truway');
    $mail->addAddress($email_usuario, $nombre_usuario);

    // Contenido del email
    $mail->isHTML(true);
    $mail->Subject = 'Confirmación de Compra';
    $mail->Body    = 'Hola, '. $nombre_usuario . '. Muchas gracias por su compra. Su pedido está pendiente de entrega.';

    $mail->send();
    echo 'El mensaje ha sido enviado';
    mysqli_query($conexion, "INSERT INTO `mails_automaticos`(`destinatario`, `asunto`, `mensaje`,`estado_envio`)
    VALUES ($id_usuario,$mail->Subject,$mail->Body,'enviado')");
} catch (Exception $e) {
    echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
}
?>
