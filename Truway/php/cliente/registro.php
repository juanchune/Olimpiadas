<?php
include $_SERVER['DOCUMENT_ROOT'] . '//php/componentes/header.php';

if(
        isset($_POST['nombre']) &&
        isset($_POST['apellido']) &&
        isset($_POST['nombreDeUsuario']) &&
        isset($_POST['correo']) &&
        isset($_POST['contrasenia']) &&
        isset($_POST['telefono'])
    ) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $nombreDeUsuario = $_POST['nombreDeUsuario'];
        $correo = $_POST['correo'];
        $contrasenia = $_POST['contrasenia'];
        $telefono = $_POST['telefono'];

        // Encriptar la contraseña
        $contrasenia_MD5 = md5($contrasenia);

        // Verificar si el correo ya está registrado
        $consulta = "SELECT correo FROM usuarios WHERE correo='$correo'";
        $consulta1 = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($consulta1) > 0) {
            $mensaje = "El correo ya está registrado. <a href='register.php'>Vuelve</a> y usa otro.";
        } else {
            $sql = "INSERT INTO usuarios (nombre, apellido, email, contrasena, fecha_registro, telefono, sexo, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$nombreDeUsuario', '$correo', '$contrasenia_MD5', '$telefono', '$rol')";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                $mensaje = "Registro exitoso. Redirigiendo al login...";
                header("Refresh:2; url=ingreso.php");
                exit;
            } else {
                $mensaje = "Error al registrar usuario.";
            }
            echo $mensaje;
        }
    }
?>