<?php
include $_SERVER['DOCUMENT_ROOT'] . 'php/componentes/header.php';
include('conexion.php');

$mensaje = '';

$UsuarioJefeDeVentas = "Matias";
$ContraseniaJefeDeVentas = "gige121234";

$email = $_POST['email'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$contrasena1 = $_POST['contrasena1'] ?? '';

// Validar que ambas contraseñas coincidan
if ($contrasena !== $contrasena1) {
    echo "Las contraseñas no coinciden. <a href='index.php'>Volver</a>";
    exit;
}

?>

<form action="ingreso.php" method="post">

    <label for="user_email">Introduzca su usuario o email</label>
    <input type="text" name="email" id="email" required><br><br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" id="contrasena" required><br><br>

    <label for="contrasena1">Repetir Contraseña:</label>
    <input type="password" name="contrasena1" id="contrasena1" required><br><br>

    <input type="submit" value="Entrar">
</form>