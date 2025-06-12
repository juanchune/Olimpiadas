<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
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
            header("Location: /Olimpiadas/Truway/php/admin/consultar-productos.php");
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
                header("Location: ../../index.php");
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
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/iniciar-sesion.css">

   <main>
        <section class="logo-titulo">
            <div class="cont-img">
                <img src="/Olimpiadas/Truway/css/recursos/Logo-2 1.png">
            </div>
            <h2 class="titulo">Truway</h2>
        </section>
        <div class="cont-formulario-subtitulo">
        <h2>Iniciar sesion</h2>
        <form class="cont-formulario" method="post" action="iniciar-sesion.php">

             <div class="cont-input">
                <label class="lbl iniciar-sesion" name="correo">Correo</label>
                <input class="input input-iniciar-sesion email" type="email" name="email" id="email" required>
            </div>
             <div class="cont-input">
                <label class="lbl iniciar-sesion" name="contraseña">Contraseña</label>
                <input class="input input-iniciar-sesion contrasenia" type="password" name="contrasena" id="contrasena" maxlength="50" required>
            </div>
             <?php if ($mensaje): ?>
                <p class="mensaje"><?= $mensaje ?></p>
            <?php endif; ?>
            <div class="cont-btn-link">
            <span><a href="/Olimpiadas/Truway/php/cliente/registro.php">¿No tienes cuenta?</a></span>
            <button type="submit" class="btn-iniciar-sesion">Iniciar sesion</button>
            </div>
        </form>
        </div>
    </main>
</body>
</html>
