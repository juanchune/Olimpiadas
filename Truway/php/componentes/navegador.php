<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
if (isset($_SESSION['email'])):  // Verificamos si existe una sesión iniciada con un tipo de usuario definido 
    if ($_SESSION['rol'] === 'cliente'): //Dependiendo del tipo de usuario, mostramos un menú personalizado
            include_once('conexion.php');
            // Verificar si el usuario ha iniciado sesión
        
        if (isset($_SESSION['id'])) {
            $id_usuario = $_SESSION['id'];
            // Consulta para obtener los datos del usuario
            $query = "SELECT nombre FROM usuarios WHERE id_usuario = $id_usuario";
            $resultado = mysqli_query($conexion, $query);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
            $nombre = htmlspecialchars($usuario['nombre']);
            } else {
                $nombre = 'Usuario';
               
            }
        } else {
    $nombre = 'Usuario';
    }
?> <!-- Menú para clientes -->

<link rel="stylesheet" href="/Olimpiadas/Truway/css/navegador.css">
 <nav>
            <div class="cont-logo-nombre">
                <div class="cont-img">
                    <img src="/Olimpiadas/Truway/css/recursos/Logo-2 1.png" alt="Logo">
                </div>
                <h6 class="titulo-nav">Truway</h6>
            </div>
            <div class="cont-btns">
                <ul class="nav-lista-btns">
                    <li class="btns"><a href="/Olimpiadas/Truway/index.php">Inicio</a></li>
                    <li class="btns"><a href="#">Sobre nosotros</a></li>
                    <li class="btns"><a href="/Olimpiadas/Truway/php/cliente/mostrarProducto.php">Productos</a></li>
                </ul>
            </div>
            <div class="cont-btns cont-usuario">
                    <ul class="nav-lista-btns">
                        <li class="btns">
                             <form action="/Olimpiadas/Truway/php/cliente/carrito.php" method="POST"> 
                                <button type="submit" class="carrito-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" fill-rule="evenodd" d="M10 2.25a1.75 1.75 0 0 0-1.582 1c-.684.006-1.216.037-1.692.223A3.25 3.25 0 0 0 5.3 4.563c-.367.493-.54 1.127-.776 1.998l-.047.17l-.513 2.964q-.277.191-.486.459c-.901 1.153-.472 2.87.386 6.301c.545 2.183.818 3.274 1.632 3.91C6.31 21 7.435 21 9.685 21h4.63c2.25 0 3.375 0 4.189-.635c.814-.636 1.086-1.727 1.632-3.91c.858-3.432 1.287-5.147.386-6.301a2.2 2.2 0 0 0-.487-.46l-.513-2.962l-.046-.17c-.237-.872-.41-1.506-.776-2a3.25 3.25 0 0 0-1.426-1.089c-.476-.186-1.009-.217-1.692-.222A1.75 1.75 0 0 0 14 2.25zm8.418 6.896l-.362-2.088c-.283-1.04-.386-1.367-.56-1.601a1.75 1.75 0 0 0-.768-.587c-.22-.086-.486-.111-1.148-.118A1.75 1.75 0 0 1 14 5.75h-4a1.75 1.75 0 0 1-1.58-.998c-.663.007-.928.032-1.148.118a1.75 1.75 0 0 0-.768.587c-.174.234-.277.56-.56 1.6l-.362 2.089C6.58 9 7.91 9 9.685 9h4.63c1.775 0 3.105 0 4.103.146M8 12.25a.75.75 0 0 1 .75.75v4a.75.75 0 0 1-1.5 0v-4a.75.75 0 0 1 .75-.75m8.75.75a.75.75 0 0 0-1.5 0v4a.75.75 0 0 0 1.5 0zM12 12.25a.75.75 0 0 1 .75.75v4a.75.75 0 0 1-1.5 0v-4a.75.75 0 0 1 .75-.75" clip-rule="evenodd"/></svg>
                                </button>
                            </form>
                        </li>

                        <li class="btns user-dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg"class="svg-icon" viewBox="0 0 24 24" onclick="bandejaUsuario(event)"><circle cx="12" cy="6" r="4" fill="currentColor " class="icon"/><path class="icon" fill="currentColor" d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5"/>
                            </svg>
                        
                            <ul class="user-dropdown-content">
                                <li>
                                    <div class="user-info">
                                        <span class="user-name"><?php echo $nombre ?></span>
                                        <!-- <span class="user-username"></span> -->
                                    </div>
                                </li>

                                <li>
                                    <div class="btn-dropdown perfil">
                                        <a href="/Olimpiadas/Truway/php/cliente/perfil.php" class="perfil-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg"class="svg-icon" viewBox="0 0 24 24" onclick="bandejaUsuario(event)"><circle  class="nav-icon" cx="12" cy="6" r="4" fill="currentColor " class="icon"/><path class="nav-icon" fill="currentColor" d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5"/>
                                        </svg>
                                            <span>Perfil</span>
                                        </a>
                                    </div>
                                </li>

                                <li>
                                    <div class="btn-dropdown logout">
                                        <form action="/Olimpiadas/Truway/php/componentes/logout.php" method="POST"> 
                                            <button type="submit" class="logout-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="nav-icono" fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6q.425 0 .713.288T12 4t-.288.713T11 5H5v14h6q.425 0 .713.288T12 20t-.288.713T11 21zm12.175-8H10q-.425 0-.712-.288T9 12t.288-.712T10 11h7.175L15.3 9.125q-.275-.275-.275-.675t.275-.7t.7-.313t.725.288L20.3 11.3q.3.3.3.7t-.3.7l-3.575 3.575q-.3.3-.712.288t-.713-.313q-.275-.3-.262-.712t.287-.688z"/></svg>
                                                <span>Cerrar sesión</span>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    
                </div>
        </nav>
<?php elseif ($_SESSION['rol'] === 'admin'): ?> <!-- Menú para administradores -->
 <link rel="stylesheet" href="/Olimpiadas/Truway/css/navegador-admin.css">
  <nav class="nav-principal">
        <div class="cont-izquierda">
            <button class="btn-menu-lateral" id="btn-menu-admin">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                    <path class="icon" fill="currentColor"
                        d="M4 18q-.425 0-.712-.288T3 17t.288-.712T4 16h16q.425 0 .713.288T21 17t-.288.713T20 18zm0-5q-.425 0-.712-.288T3 12t.288-.712T4 11h16q.425 0 .713.288T21 12t-.288.713T20 13zm0-5q-.425 0-.712-.288T3 7t.288-.712T4 6h16q.425 0 .713.288T21 7t-.288.713T20 8z" />
                </svg>
            </button>
            <div class="cont-logo-nombre">
                <div class="cont-img">
                    <img src="/Olimpiadas/Truway/css/recursos/Logo-2 1.png" alt="Logo">
                </div>
                <h6 class="titulo-nav">Truway</h6>
            </div>
        </div>
        <div class="cont-btns">
            <!-- <ul class="nav-lista-btns">
                    <li class="btns"><a href>Inicio</a></li>
                    <li class="btns"><a href>Sobre nosotros</a></li>
                    <li class="btns"><a href>Porductos</a></li>
                </ul> -->
        </div>
        <div class="cont-btns cont-usuario">
            <ul class="nav-lista-btns">
                <li class="btns user-dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"
                        onclick="bandejaUsuario(event)">
                        <circle cx="12" cy="6" r="4" fill="currentColor " class="icon" />
                        <path class="icon" fill="currentColor"
                            d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5" />
                    </svg>
                    <ul class="user-dropdown-content">
                        <li>
                            <div class="user-info">
                                <span class="user-name">ADMINISTRADOR</span>
                                <!-- <span class="user-username"></span> -->
                            </div>
                        </li>
                        <li>
                            <div class="btn-dropdown logout">
                                <form action="/Olimpiadas/Truway/php/componentes/logout.php" method="POST"> 
                                    <button type="submit" class="logout-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="nav-icono" fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6q.425 0 .713.288T12 4t-.288.713T11 5H5v14h6q.425 0 .713.288T12 20t-.288.713T11 21zm12.175-8H10q-.425 0-.712-.288T9 12t.288-.712T10 11h7.175L15.3 9.125q-.275-.275-.275-.675t.275-.7t.7-.313t.725.288L20.3 11.3q.3.3.3.7t-.3.7l-3.575 3.575q-.3.3-.712.288t-.713-.313q-.275-.3-.262-.712t.287-.688z"/></svg>
                                        <span>Cerrar sesión</span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <aside class="menu-lateral" id="menu-lateral-admin">
        <nav class="nav-lateral">
            <ul class="lista-menu-lateral">
                <li>
                    <a href="admin-principal.html">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                            <path fill="currentColor" class="icon"
                                d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0s.41-1.08 0-1.49zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14" />
                        </svg>
                        <span class="seccion-menu">Consultar productos</span>
                    </a>
                </li>
                <li>
                    <a href="agregar-productos.html">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                            <path fill="currentColor" class="icon"
                                d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z" />
                        </svg>
                        <span class="seccion-menu">Agregar productos</span>
                    </a>
                </li>
                <li>
                    <a href="consultar-pedidos-entregados.html">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                            <path class="icon" fill="currentColor"
                                d="M8 3.5A1.5 1.5 0 0 1 9.5 2h5A1.5 1.5 0 0 1 16 3.5v1A1.5 1.5 0 0 1 14.5 6h-5A1.5 1.5 0 0 1 8 4.5z" />
                            <path class="icon" fill="currentColor" fill-rule="evenodd"
                                d="M6.5 4.037c-1.258.07-2.052.27-2.621.84C3 5.756 3 7.17 3 9.998v6c0 2.829 0 4.243.879 5.122c.878.878 2.293.878 5.121.878h6c2.828 0 4.243 0 5.121-.878c.879-.88.879-2.293.879-5.122v-6c0-2.828 0-4.242-.879-5.121c-.569-.57-1.363-.77-2.621-.84V4.5a3 3 0 0 1-3 3h-5a3 3 0 0 1-3-3zM6.25 10.5A.75.75 0 0 1 7 9.75h10a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m1 3.5a.75.75 0 0 1 .75-.75h8a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75m1 3.5a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="seccion-menu">Consultar pedidos</span>
                    </a>
                </li>
                <li>
                    <a href="ventas-pagas.html">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                            <path class="icon" fill="currentColor"
                                d="M21.92 6.62a1 1 0 0 0-.54-.54A1 1 0 0 0 21 6h-5a1 1 0 0 0 0 2h2.59L13 13.59l-3.29-3.3a1 1 0 0 0-1.42 0l-6 6a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0L9 12.41l3.29 3.3a1 1 0 0 0 1.42 0L20 9.41V12a1 1 0 0 0 2 0V7a1 1 0 0 0-.08-.38" />
                        </svg>
                        <span class="seccion-menu">Ventas</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

        <script>
        const menuLateral = document.getElementById('menu-lateral-admin');
        const boton = document.getElementById('btn-menu-admin');

        // Función para abrir/cerrar el menu
        boton.addEventListener('click', () => {
            menuLateral.classList.toggle('desplegar-menu');
        });

        //Marcar automaticamente el item seleccionado basado en el ink
        const currentUrl = window.location.pathname;
        const itemsMenu = document.querySelectorAll('.lista-menu-lateral li a');

        itemsMenu.forEach(item => {
            if (item.getAttribute('href') === currentUrl) {
                item.classList.add('selected');
            }
        });
    </script>

    <?php endif;
else: ?>
<!-- Menú para usuarios no autenticados -->
<link rel="stylesheet" href="/Olimpiadas/Truway/css/navegador.css">
<nav>
            <div class="cont-logo-nombre">
                <div class="cont-img">
                    <img src="/Olimpiadas/Truway/css/recursos/Logo-2 1.png" alt="Logo">
                </div>
                <h6 class="titulo-nav">Truway</h6>
            </div>
            <div class="cont-btns">
                <ul class="nav-lista-btns">
                    <li class="btns"><a href>Inicio</a></li>
                    <li class="btns"><a href>Sobre nosotros</a></li>
                    <li class="btns"><a href>Productos</a></li>
                </ul>
            </div>
            <div class="cont-btns cont-usuario">
                    <ul class="nav-lista-btns">
                    <li class="btns">
                        <button class="iniciar-sesion" onclick="location.href='/Olimpiadas/Truway/php/general/iniciar-sesion.php'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="icon-iniciar-sesion" fill="currentColor" d="M12 2a5 5 0 1 1-5 5l.005-.217A5 5 0 0 1 12 2m2 12a5 5 0 0 1 5 5v1a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-1a5 5 0 0 1 5-5z"/></svg>
                            Iniciar sesión
                        </button>
                    </li>

                    <li class="btns"> 
                        <button class="registrarse" onclick="location.href='/Olimpiadas/Truway/php/cliente/registro.php'">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g class="icon-registrarse" fill="none"><path class="icon-registrarse" d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path class="icon-registrarse"  fill="currentColor" d="M16 14a5 5 0 0 1 5 5v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1a5 5 0 0 1 5-5zm4-6a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1V9a1 1 0 0 1 1-1m-8-6a5 5 0 1 1 0 10a5 5 0 0 1 0-10"/></g></svg>
                            Registrarse
                            
                        </button> 
                    </li>
                    
                </div>
        </nav>
<?php endif; ?>

