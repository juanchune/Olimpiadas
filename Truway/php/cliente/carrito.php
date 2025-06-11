<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
include('conexion.php');

$consulta = "SELECT * FROM carrito WHERE id_usuario = '".$_SESSION['id']."'"; // Asegúrate de que la sesión tenga el id del usuario
$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
// Inicializamos variables para almacenar los datos del carrito
$cantidad_paquetes = 0;
$subtotal = 0;
$precio_final = 0;
// Creamos un array para almacenar los productos del carrito
$productos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $id_producto = $fila['id_producto'];
    $cantidad_personas = $fila['cantidad_personas'];
    
    // Realizamos una consulta para obtener los detalles del producto
    $consulta_producto = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
    $resultado_producto = mysqli_query($conexion, $consulta_producto);
    
    if ($resultado_producto && mysqli_num_rows($resultado_producto) > 0) {
        $producto = mysqli_fetch_assoc($resultado_producto);
        
        // Calculamos el precio total del producto
        $precio_unitario = $producto['precio']; // Asegúrate de que este campo exista en tu tabla productos
        $precio_total = $precio_unitario * $cantidad_personas;
        
        // Agregamos los datos del producto al array
        $productos[] = [
            'nombre' => $producto['nombre'], // Asegúrate de que este campo exista en tu tabla productos
            'tipo' => $producto['tipo'], // Asegúrate de que este campo exista en tu tabla productos
            'destino' => $producto['destino'], // Asegúrate de que este campo exista en tu tabla productos
            'fecha' => $producto['fecha'], // Asegúrate de que este campo exista en tu tabla productos
            'cantidad_personas' => $cantidad_personas,
            'precio_total' => $precio_total,
            'id_producto' => $id_producto
        ];
        
        // Actualizamos las variables de resumen del carrito
        $cantidad_paquetes++;
        $subtotal += $precio_total;
        $precio_final += $precio_total;
    }
}

function vaciar_carrito() {
    // Lógica para vaciar el carrito (por ejemplo, borrando la sesión o la base de datos)
    unset($_SESSION['carrito']); // En este caso, borramos la sesión del carrito
    // (Reemplaza esta línea con la lógica que corresponda a tu implementación)
}
    // Si se hace clic en el botón vaciar carrito, ejecutamos la función
    if (isset($_POST['vaciar_carrito'])) {
        vaciar_carrito();
        // Redirige al usuario a la página del carrito
        header('Location: carrito.php'); // Reemplaza carrito.php con la URL correcta
        exit();
    }
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/carrito.css">
<section class="section-carrito">
            <div class="grid-productos">
                <h2 class="subtitulo">Mis reservas</h2>
                <article class="producto">
                    <div class="cont-superior">
                        <div class="cont-tag">
                            <div class="tag">
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g class="icon" fill="none" fill-rule="evenodd"><path class="icon"  d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path class="icon" fill="currentColor" d="M15.764 4a3 3 0 0 1 2.683 1.658l1.386 2.771q.366-.15.72-.324a1 1 0 0 1 .894 1.79a32 32 0 0 1-.725.312l.961 1.923A3 3 0 0 1 22 13.473V16a3 3 0 0 1-1 2.236V19.5a1.5 1.5 0 0 1-3 0V19H6v.5a1.5 1.5 0 0 1-3 0v-1.264c-.614-.55-1-1.348-1-2.236v-2.528a3 3 0 0 1 .317-1.341l.953-1.908q-.362-.152-.715-.327a1.01 1.01 0 0 1-.45-1.343a1 1 0 0 1 1.342-.448q.355.175.72.324l1.386-2.77A3 3 0 0 1 8.236 4zM7.5 13a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m9 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m-.736-7H8.236a1 1 0 0 0-.832.445l-.062.108l-1.27 2.538C7.62 9.555 9.706 10 12 10c2.142 0 4.101-.388 5.61-.817l.317-.092l-1.269-2.538a1 1 0 0 0-.77-.545L15.765 6Z"/></g></svg>
                                <span class="nombre-tag">$tipo_producto</span> <!--TIPO DE PRODUCTO DESDE LA BDD-->
                            </div>
                        </div>
                        <div class="cont-grid-titulo-btns">
                            <h3>$nombre_producto</h3> <!--NOMBRE DEL PAQUETE SELECCIONADO-->
                            <div class="cont-btns">
                                <!-- BOTONES PARA MODIFICAR Y BORRAR. SI SE PRECIONA EL DE MODIFICAR DEBERA ENVIAR A LA INTERFAZ DEL PRODUCTO Y MODIFICAR DESDE AHI -->
                                <button class="btn modificar" onclick.location.href='/Olimpiadas/truway/php/general/producto-especifico.php?id_producto=$id_producto'>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M20.71 7.04c-.34.34-.67.67-.68 1c-.03.32.31.65.63.96c.48.5.95.95.93 1.44s-.53 1-1.04 1.5l-4.13 4.14L15 14.66l4.25-4.24l-.96-.96l-1.42 1.41l-3.75-3.75l3.84-3.83c.39-.39 1.04-.39 1.41 0l2.34 2.34c.39.37.39 1.02 0 1.41M3 17.25l9.56-9.57l3.75 3.75L6.75 21H3z"/></svg>
                                </button>
                                <button class="btn borrar" onclick.location.href='/Olimpiadas/truway/php/general/producto-especifico.php?id_producto=$id_producto'>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="cont-inferior">
                        <div class="cont-datos-especificos">

                            <div class="cont-lbls">
                                <span class="lbl-nombre">Destino:</span>
                                <span class="lbl-nombre">Fecha:</span>
                                <span class="lbl-nombre">Personas:</span>
                            </div>
                            <div class="cont-informacion">
                                <span class="informacion destino">$destino</span> <!--COMPLETAR CON EL DESTINO DESDE LA BDD-->
                                <span class="informacion fecha">$fecha</span>    <!--COMPLETAR CON LA FECHA DESDE LA BDD-->
                                <span class="informacion personas">$cantidad_personas</span>   <!--COMPLETAR CON LA CANTIDAD DE PERSONAS SELECCIONADAS POR EL USUARIO-->
                            </div>
                        </div>
                        <div class="cont-importe">
                            <span class="importe">$precio</span> <!--PRECIO TOTAL, SE MULTIPLICA LA CANTIDAD DE PERSONAS POR EL PRECIO UNITARIO DEL PAQUETE-->
                        </div>
                    </div>
                </article>
            </div>

            <div class="pre-factura">
                <h2 class="subtitulo">Resumen de pedido</h2>
                <article class="resumen-pedido">
                    <div class="cont-precios-generales">
                        <div class="cont-precios">
                            <div class="cont-resumen">
                                <span class="lbl">Paquetes</span>
                                <span class="lbl-informacion cant-paquetes">$cantidad_paquetes</span> <!--TOTAL DE TODOS LOS PAQUETES SELECCIONADOS-->
                            </div>
                            <div class="cont-resumen">
                                <span class="lbl">Subtotal 1:</span> <!--CADA PAQUETE TIENE SU SUBTOTAL, CON EL PRECIO TOTAL (PERSONAS*PRECIO UNITARIO)-->
                                <span class="lbl-informacion sub-1">$subtotal</span>
                            </div>
                        </div>

                        <div class="cont-total-pagar">
                            <span class="lbl">Total:</span> 
                            <span class="lbl-informacion sub-1">$precio_final</span> <!--TOTAL A PAGAR (LA SUMA DE TODOS LOS SUBTOTALES)-->
                        </div>
                    </div>
                    <div class="cont-btns">
                        <button class="btn siguiente" onclick.location.href='Olimpiadas/Truway/php/cliente/finalizar-pedido.php'>Siguiente</button> <!--LLEVA AL USER A LA SIGUIENTE INTERFAZ PARA COMPLETAR LOS DATOS DEL PEDIDO-->
                        <button class="btn borrar" name="vaciar_carrito">Vaciar carrito</button > <!--VACIA EL CARRITO-->
                        
                    </div>
                </article>
            </div>
        </section>
    </main>