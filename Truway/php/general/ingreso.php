<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . './Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

$mensaje = '';

$emailJefeDeVentas = "Matias@admin.com";
$contrasenaJefeDeVentas = "gige121234";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['contrasena'])) {
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $contrasena_MD5 = md5($contrasena);
        // Verificar si es el jefe de ventas
        if ($email === $emailJefeDeVentas && $contrasena === $contrasenaJefeDeVentas) {
            $_SESSION['id'] = 'admin';
            $_SESSION['email'] = $email;
            $_SESSION['rol'] = 'admin';
            header("Location: index.php");
            exit;
        }
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = mysqli_query($conexion, $sql);
        if ($result && mysqli_num_rows($result) == 1) {
            $result2 = mysqli_fetch_assoc($result);
            if ($contrasena_MD5 == $result2['contrasena']) {
                $_SESSION['id'] = $result2['id_usuario'];
                $_SESSION['email'] = $result2['email'];
                $_SESSION['rol'] = 'cliente';
                header("Location: index.php");
                exit;
            } else {
                $mensaje = 'Contraseña incorrecta';
            }
        } else {
            $mensaje = 'No existe la cuenta';
        }
    }
}
?>
<header>
    <link rel="stylesheet" href="./css/iniciar-sesion.css">
</header>
    <div class="imagen-principal">
         <img class="img-iniciar-sesion" src="./css/recursos/Principal.png"> 
    </div>
    <div class="cont-formulario-iniciar-sesion">
        <h4 class="titulo-iniciar-sesion">Iniciar sesión</h4>
        <?php if ($mensaje): ?>
            <p style="color:red;"><?= $mensaje ?></p>
        <?php endif; ?>
        <form action="ingreso.php" method="POST" class="form-iniciar-sesion">
            <div class="cont-input">
                <label class="lbl-iniciar-sesion" for="email">email</label>
                <input class="input-iniciar-sesion email" type="text" id="email" name="email" required>
            </div>
            <div class="cont-input">
                <label class="lbl-iniciar-sesion" for="contrasenia">Contraseña</label>
                <input class="input-iniciar-sesion contrasenia" type="password" id="contrasenia" name="contrasena" required>
            </div>
            <a href="">¿Olvidaste tu contraseña?</a>
            <button type="submit" class="btn-iniciar-sesion">Iniciar sesión</button>
        </form>
    </div>