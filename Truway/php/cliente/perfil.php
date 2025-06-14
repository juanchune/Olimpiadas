<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header("Location: /Olimpiadas/Truway/php/general/iniciar-sesion.php");
exit();
}
/*Obtiene nombre y apellido para mostrarlos*/
$id_usuario = (int)$_SESSION['id'];
$query_usuario = "SELECT nombre, apellido FROM usuarios WHERE id_usuario = $id_usuario";
$resultado_usuario = mysqli_query($conexion, $query_usuario);

if ($resultado_usuario) {
    $fila = mysqli_fetch_assoc($resultado_usuario);
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
}

// Consultar los pedidos del usuario
// // Inicializar listas de pedidos
// $pendientes = [];
// $aprobados = [];
// $rechazados = [];

// // Clasificar los pedidos según su estado
// while ($pedido = mysqli_fetch_assoc($resultado)) {
//     switch ($pedido['estado']) {
//         case 'pendiente':
//             $pendientes[] = $pedido;
//             break;
//         case 'aprobado':
//             $aprobados[] = $pedido;
//             break;
//         case 'rechazado':
//             $rechazados[] = $pedido;
//             break;
//     }
// }
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/perfil.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; ?>

    <section class="section-informacion-user">
        <span class="nombre-apellido"><?php echo $nombre ?> <?php echo $apellido ?></span>
    </section>
    <h2 class="subtitulo">Mis pedidos</h2>
    <section class="section-pedidos-realizados">
    <div class=cont-filtros>
            <h2 class="subtitulo">Tipo de pedido</h2>
            <form class="filtros" method="get" action="">
                <div class="input-filtro">
                    <input type="checkbox" id="todos" name="tipo-pedido" value="todos">
                    <label for="todos" class="lbl">Todos los pedidos</label>
                </div>
                <div class="input-filtro">
                    <input type="checkbox" id="apobados" name="tipo-pedido" value="apobados">
                    <label for="apobados" class="lbl">Aprobados</label>
                </div>
                <div class="input-filtro">
                    <input type="checkbox" id="pendientes" name="tipo-pedido" value="pendientes">
                    <label for="pendientes" class="lbl">Pendientes</label>
                </div>
                <div class="input-filtro">
                    <input type="checkbox" id="rechazados" name="tipo-pedido" value="rechazados">
                    <label for="rechazados" class="lbl">Rechazados</label>
                </div>

            </form>
        </div>
    <div class="pedidos">
        <?php
        $query = "SELECT * FROM pedidos WHERE id_usuario = $id_usuario ORDER BY fecha DESC";
        $resultado = mysqli_query($conexion, $query);

         if (mysqli_num_rows($resultado) >= 1) {
                ?> <div class="grid-pedidos"> <?php
                $pedidos = array(); 
                //todos los resultados y los guarda en al array
                while ($todosPedidos = mysqli_fetch_assoc($resultado)) {
                $pedidos[] = $todosPedidos['id'];
                }
                
                foreach($pedidos as $clave=>$valor){?>
                <article class="tarjeta-pedido pendiente">
                    <div class="cont-datos-pedido">
                        <div class="cont-informacion">
                            <span class="lbl">ID Orden</span>
                            <span class="lbl-informacion id"><?php echo $resultado['id_pedido']?></span>
                        </div>
                        <div class="cont-informacion">
                            <span class="lbl">Total</span>
                            <span class="lbl-informacion total"><?php echo $resultado['precio_total']?></span>
                        </div>
                        <div class="cont-informacion">
                            <span class="lbl">Tipo de pago</span>
                            <span class="lbl-informacion pago"><?php echo $resultado['metodo_pago']?></span>
                        </div>
                        <div class="cont-informacion">
                            <span class="lbl">Fecha pedido</span>
                            <span class="lbl-informacion fecha"><?php echo $resultado['fecha']?></span>
                        </div>
                        <div class="cont-informacion">
                            <span class="lbl">Cantidad de productos</span>
                            <span class="lbl-informacion catn-productos"><?php echo $resultado['cantidad']?></span>
                        </div>
                        <div class="cont-informacion">
                            <span class="lbl">Estado</span>
                            <span class="lbl-informacion estdo-pendiente"><?php echo $resultado['estado']?></span>
                        </div>
                    </div>

                    <div class="grid-productos">
                        <article class="producto">
                            <?php
                            //Obtener todos los id de los productos seleccionado del pedido
                             $arrIdPedido = [];
                            $buscarProducto = "SELECT id_producto FROM detalle_carrito WHERE id_pedido='$valor'";  
                            $resBuscarImg = mysqli_query($conexion, $buscarImg);
                            ?>
                            <div class="cont-superior">
                                <div class="cont-tag">
                                    <div class="tag">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g class="icon" fill="none" fill-rule="evenodd"><path class="icon"  d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path class="icon" fill="currentColor" d="M15.764 4a3 3 0 0 1 2.683 1.658l1.386 2.771q.366-.15.72-.324a1 1 0 0 1 .894 1.79a32 32 0 0 1-.725.312l.961 1.923A3 3 0 0 1 22 13.473V16a3 3 0 0 1-1 2.236V19.5a1.5 1.5 0 0 1-3 0V19H6v.5a1.5 1.5 0 0 1-3 0v-1.264c-.614-.55-1-1.348-1-2.236v-2.528a3 3 0 0 1 .317-1.341l.953-1.908q-.362-.152-.715-.327a1.01 1.01 0 0 1-.45-1.343a1 1 0 0 1 1.342-.448q.355.175.72.324l1.386-2.77A3 3 0 0 1 8.236 4zM7.5 13a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m9 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m-.736-7H8.236a1 1 0 0 0-.832.445l-.062.108l-1.27 2.538C7.62 9.555 9.706 10 12 10c2.142 0 4.101-.388 5.61-.817l.317-.092l-1.269-2.538a1 1 0 0 0-.77-.545L15.765 6Z"/></g></svg>
                                        <span class="nombre-tag">Paquete turistico</span> <!--TIPO DE PRODUCTO DESDE LA BDD-->
                                    </div>
                                </div>
                                <div class="cont-grid-titulo-btns">
                                    <h3>Bariloche</h3> <!--NOMBRE DEL PAQUETE SELECCIONADO-->
                                    <div class="cont-btns">
                                        <!-- BOTONES PARA MODIFICAR Y BORRAR. SI SE PRECIONA EL DE MODIFICAR DEBERA ENVIAR A LA INTERFAZ DEL PRODUCTO Y MODIFICAR DESDE AHI -->
                                        <button class="btn modificar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M20.71 7.04c-.34.34-.67.67-.68 1c-.03.32.31.65.63.96c.48.5.95.95.93 1.44s-.53 1-1.04 1.5l-4.13 4.14L15 14.66l4.25-4.24l-.96-.96l-1.42 1.41l-3.75-3.75l3.84-3.83c.39-.39 1.04-.39 1.41 0l2.34 2.34c.39.37.39 1.02 0 1.41M3 17.25l9.56-9.57l3.75 3.75L6.75 21H3z"/></svg>
                                        </button>
                                        <button class="btn borrar">
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
                                        <span class="informacion destino">Bariloche</span> <!--COMPLETAR CON EL DESTINO DESDE LA BDD-->
                                        <span class="informacion fecha">11/08/2025</span>    <!--COMPLETAR CON LA FECHA DESDE LA BDD-->
                                        <span class="informacion personas">4</span>   <!--COMPLETAR CON LA CANTIDAD DE PERSONAS SELECCIONADAS POR EL USUARIO-->
                                    </div>
                                </div>
                                <div class="cont-importe">
                                    <span class="importe">$4.200.000,00</span> <!--PRECIO TOTAL, SE MULTIPLICA LA CANTIDAD DE PERSONAS POR EL PRECIO UNITARIO DEL PAQUETE-->
                                </div>
                            </div>
                        </article>
                    </div>
                </article>
            <?php
                }
            }
        ?>
    </div> 
    </section>
</main>
<script>
    // Envía automáticamente el formulario cuando se hace click en un checkbox
    document.querySelectorAll('.filtros input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>