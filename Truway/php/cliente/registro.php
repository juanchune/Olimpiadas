<?php
include $_SERVER['DOCUMENT_ROOT'] . 'php/componentes/header.php';


if(     // Verificar si los campos del formulario están definidos
        isset($_POST['nombre']) && 
        isset($_POST['apellido']) && 
        isset($_POST['nombreDeUsuario']) &&
        isset($_POST['email']) &&
        isset($_POST['contrasena']) &&
        isset($_POST['telefono'])&&
        isset($_POST['sexo']) &&
        isset($_POST['fecha_nacimiento'])
    ) {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre']; 
        $apellido = $_POST['apellido']; 
        $nombreDeUsuario = $_POST['nombreDeUsuario']; 
        $email = $_POST['email']; 
        $contrasena = $_POST['contrasena']; 
        $telefono = $_POST['telefono']; 
        $sexo = $_POST['sexo']; 
        $fecha_nacimiento = $_POST['fecha_nacimiento']; 

        //Encriptar la contraseña
        $contrasena_MD5 = md5($contrasena); 

        // Verificar si el email ya está registrado
        $consulta = "SELECT email FROM usuarios WHERE email='$email'";
        $consulta1 = mysqli_query($conexion, $consulta); 

        // Si el email ya está registrado, mostrar un mensaje de error
        if (mysqli_num_rows($consulta1) > 0) {
                $mensaje = "El email ya está registrado. <a href='register.php'>Vuelve</a> y usa otro.";
            } else {
            $sql = "INSERT INTO usuarios (nombre, apellido, email, contrasena, telefono, sexo, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$email', '$contrasena_MD5', '$telefono', '$sexo', '$fecha_nacimiento')";
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
<link rel="stylesheet" href="style.css">
<h2>Registro de Usuario</h2>
<form method="POST" action="registro.php">
    <div class="">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="" id="nombre" name="nombre" required>
    </div>
    <div class="">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="" id="apellido" name="apellido" required>
    </div>
    <div class="">
    </div>
    <div class="">
        <label for="email" class="form-label">email Electrónico</label>
        <input type="email" class="" id="email" name="email" required>
    </div>
    <div class="">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" class="" id="contrasena" name="contrasena" required>
    </div>
    <div class="">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="tel" class="" id="telefono" name="telefono">
    </div>
    <div class="">
        <label for="sexo" class="form-label">Sexo</label>
        <select class="form-select" id="sexo" name='sexo' required>
            <option value="" disabled selected>Seleccione una opción</option>
            <option value='Masculino'>Masculino</option>
            <option value='Femenino'>Femenino</option>
            <option value='Otro'>Otro</option>
        </select>
    </div>
    <div class=''>
        <label for='fecha_nacimiento' class='form-label'>Fecha de Nacimiento</label>
        <input type='date' class='' id='fecha_nacimiento' name='fecha_nacimiento' required>
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>

