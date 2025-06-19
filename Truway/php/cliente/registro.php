<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
$mensaje = '';
if(     // Verificar si los campos del formulario están definidos
        isset($_POST['nombre']) && 
        isset($_POST['apellido']) && 
        isset($_POST['email']) &&
        isset($_POST['contrasena']) &&
        isset($_POST['fecha_nacimiento'])&&  
        isset($_POST['prefijo'])&&    
        isset($_POST['telefono'])
    ) {
        // Asignar los valores de los campos del formulario a variables
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $telefono = $_POST['prefijo'] . $_POST['telefono'];
        // Encriptar la contraseña
        $contrasena_MD5 = md5($contrasena);
        // Verificar si el correo electrónico ya posee una cuenta existente en la base de datos
        $consulta = "SELECT email FROM usuarios WHERE email='$email'";
        $consulta1 = mysqli_query($conexion, $consulta);
        // Si el email ya está registrado, mostrar un mensaje de error
        if (mysqli_num_rows($consulta1) > 0) {
            $mensaje = "El email ya está registrado.";
        } else {
            // Si el email no está registrado, insertar los datos en la base de datos
            $insertar = "INSERT INTO usuarios (nombre, apellido, email, contrasena, fecha_nacimiento, telefono) 
                         VALUES ('$nombre', '$apellido', '$email', '$contrasena_MD5', '$fecha_nacimiento', '$telefono')";
            $resultado = mysqli_query($conexion, $insertar);
            // Verificar si la inserción fue exitosa
            if ($resultado) {
               header("Location: ../general/iniciar-sesion.php");
            } else {
                $mensaje = "Error al registrar. Por favor intenta nuevamente.";
            }
        }
    }       
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/registro.css">
<main>
<section class="logo-titulo">
            <div class="cont-img">
                <img src="/Olimpiadas/Truway/css/recursos/Logo-2 1.png">
            </div>
            <h2 class="titulo">Truway</h2>
        </section>
        <div class="cont-formulario-subtitulo">
        <h2>Registrarse</h2>
        <form class="cont-formulario" method="post" action="registro.php">
            <div class="cont-input doble nombre-apellido">
                <div class="cont-input">
                    <label class="lbl" name="nombre">Nombre</label>
                    <input class="input" type="text" name="nombre" id="nombre" maxlength="50" required>
                </div>
                <div class="cont-input">
                    <label class="lbl" name="apellido">Apellido</label>
                    <input class="input" type="text" name="apellido" id="apellido" maxlength="50" required>
                </div>
            </div>
                
                <div class=cont-input>
                    <label class="lbl" for="fecha-nacimiento">Fecha de nacimiento</label>
                    <input class="input" type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>
                </div>
             <div class="cont-input doble telefono">
                <div class="cont-input">
                        <label class="lbl" for="prefijo">Prefijo</label>
                            <select class="input" id="prefijo" name="prefijo">
                                <option value="+54">+54 🇦🇷</option>
                                <option value="+49">+49 🇩🇪</option>
                                <option value="+61">+61 🇭🇲</option>
                                <option value="+43">+43 🇦🇹</option>
                                <option value="+32">+32 🇧🇪</option>
                                <option value="+55">+55 🇧🇷</option>
                                <option value="+1">+1 🇨🇦</option>
                                <option value="+56">+56 🇨🇱</option>
                                <option value="+57">+57 🇨🇴</option>
                                <option value="+506">+506 🇨🇷</option>
                                <option value="+385">+385 🇭🇷</option>
                                <option value="+53">+53 🇨🇺</option>
                                <option value="+45">+45 🇩🇰</option>
                                <option value="+1-809">+1-809 🇩🇴</option>
                                <option value="+1">+1 🇺🇲</option>
                                <option value="+593">+593 🇪🇨</option>
                                <option value="+503">+503 🇸🇻</option>
                                <option value="+358">+358 🇫🇮</option>
                                <option value="+33">+33 🇲🇫</option>
                                <option value="+30">+30 🇬🇷</option>
                                <option value="+502">+502 🇬🇹</option>
                                <option value="+504">+504 🇭🇳</option>
                                <option value="+354">+354 🇮🇸</option>
                                <option value="+353">+353 🇮🇪</option>
                                <option value="+39">+39 🇮🇹</option>
                                <option value="+1-876">+1-876 🇯🇲</option>
                                <option value="+81">+81 🇯🇵</option>
                                <option value="+52">+52 🇲🇽</option>
                                <option value="+377">+377 🇲🇨</option>
                                <option value="+212">+212 🇲🇦</option>
                                <option value="+31">+31 🇳🇱</option>
                                <option value="+64">+64 🇳🇿</option>
                                <option value="+505">+505 🇳🇮</option>
                                <option value="+47">+47 🇸🇯</option>
                                <option value="+507">+507 🇵🇦</option>
                                <option value="+595">+595 🇵🇾</option>
                                <option value="+48">+48 🇵🇱</option>
                                <option value="+351">+351 🇵🇹</option>
                                <option value="+1-787">+1-787 🇵🇷</option>
                                <option value="+7">+7 🇷🇺</option>
                                <option value="+34">+34 🇪🇦</option>
                                <option value="+46">+46 🇸🇪</option>
                                <option value="+41">+41 🇨🇭</option>
                                <option value="+90">+90 🇹🇷</option>
                                <option value="+44">+44 🇬🇧</option>
                                <option value="+82">+82 🇰🇷</option>
                                <option value="+380">+380 🇺🇦</option>
                                <option value="+598">+598 🇺🇾</option>
                                <option value="+58">+58 🇻🇪</option>
                            </select>
                </div>
                <div class="cont-input">
                    <label class="lbl" name="telefono">Telefono</label>
                    <input class="input" type="tel" name="telefono" id="telefono" required>
                </div>
            </div>

             <div class="cont-input">
                <label class="lbl" name="email">Correo</label>
                <input class="input" type="email" name="email" id="email" required>
            </div>
             <div class="cont-input">
                <label class="lbl" name="contraseña">Contraseña</label>
                <input class="input" type="password" name="contrasena" id="contrasena" maxlength="50" required>
            </div>
            <span class="mensaje"><?php echo $mensaje ?></span>
            <div class="cont-btn-link">
            <span><a href="/Olimpiadas/Truway/php/general/iniciar-sesion.php">¿Ya tienes cuenta?</a></span>
            <button type="submit" class="btn-enviar" name="enviar">Registrarse</button>
            </div>
        </form>
        </div>
</main>
</body>
</html>
