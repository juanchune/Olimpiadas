<?php
session_start();
include('conexion.php');
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';

$mensaje = '';
$id_usuario = $_SESSION['id'] ?? 0;

// obtener productos del carrito del usuario
$productos_cantidades = [];
$carrito_total = 0;
$fechas_reserva = [];
if ($id_usuario) {
    $sql_carrito = "SELECT c.id_carrito, dc.id_producto, dc.cantidad, dc.precio_carrito, dc.fecha_reserva 
                    FROM carrito c 
                    JOIN detalle_carrito dc ON c.id_carrito = dc.id_carrito 
                    WHERE c.id_usuario = $id_usuario";
    $res_carrito = mysqli_query($conexion, $sql_carrito);
    $id_carrito = null;
    while ($col = mysqli_fetch_assoc($res_carrito)) {
        $id_carrito = $col['id_carrito'];
        $id_producto = $col['id_producto'];
        $cantidad = $col['cantidad'];
        if (!isset($productos_cantidades[$id_producto])) {
            $productos_cantidades[$id_producto] = 0;
        }
        $productos_cantidades[$id_producto] += $cantidad;
        if ($col['fecha_reserva']) {
            $fechas_reserva[] = $col['fecha_reserva'];
        }
        $carrito_total += $col['precio_carrito'] * $col['cantidad'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // recibir datos de tarjeta
    $nombre_titular = $_POST['nombre_titular'] ?? '';
    $numero_tarjeta = $_POST['numero_tarjeta'] ?? '';
    $vencimiento = $_POST['vencimiento'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $metodo_pago = 'Tarjeta_credito';

    // validar datos
    if ($id_usuario && count($productos_cantidades) > 0 && $nombre_titular && $numero_tarjeta && $vencimiento && $cvv) {
        $cantidad_total = array_sum($productos_cantidades);

        // guardar la fecha de hoy
        $fecha = date('Y-m-d');

        // crear pedido pendiente
        $sql = "INSERT INTO pedidos (id_usuario, fecha, precio_total, metodo_pago, cantidad) 
                VALUES ($id_usuario, '$fecha', $carrito_total, '$metodo_pago', $cantidad_total)";
        if (mysqli_query($conexion, $sql)) {
            $id_pedido = mysqli_insert_id($conexion);

            // guardar todos los productos del carrito en detalle_pedido (uno por producto, sumando cantidad)
            foreach ($productos_cantidades as $id_prod => $cantidad) {
                $id_prod = intval($id_prod);
                $cantidad = intval($cantidad);
                mysqli_query($conexion, "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES ($id_pedido, $id_prod, $cantidad)");
            }

            // marcar pedido como pendiente
            mysqli_query($conexion, "INSERT INTO pedidos_pendientes (id_pedido) VALUES ($id_pedido)");

            // vaciar el carrito del usuario
            if (isset($id_carrito)) {
                mysqli_query($conexion, "DELETE FROM detalle_carrito WHERE id_carrito = $id_carrito");
                mysqli_query($conexion, "DELETE FROM carrito WHERE id_carrito = $id_carrito");
            }

            $mensaje = "Pedido realizado su pedido esta pendiente de entrega";
        } else {
            $mensaje = "Error al registrar el pedido intente nuevamente";
        }
    } else {
        $mensaje = "Complete todos los campos y asegurese de tener productos en el carrito";
    }
}
?>

<link rel="stylesheet" href="/Olimpiadas/Truway/css/facturacion.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
    <section class="facturacion">
        <h2 class="subtitulo">Datos de facturacion</h2>
        <?php if ($mensaje): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>

        <?php elseif (count($productos_cantidades) === 0): ?>
            <div class="cont-mensaje">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g fill="none"> <path class="icon" d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path class="icon"  fill="currentColor" d="m13.299 3.148l8.634 14.954a1.5 1.5 0 0 1-1.299 2.25H3.366a1.5 1.5 0 0 1-1.299-2.25l8.634-14.954c.577-1 2.02-1 2.598 0M12 15a1 1 0 1 0 0 2a1 1 0 0 0 0-2m0-7a1 1 0 0 0-.993.883L11 9v4a1 1 0 0 0 1.993.117L13 13V9a1 1 0 0 0-1-1"/></g></svg>
                <p>No hay productos en el carrito.</p>
            </div>

        <?php else: ?>
        <form method="post" class="form-facturacion">
             <div class="cont-input">
                <label for="tipo_tarjeta" class="lbl">Tipo tarjeta</label>
                <div class="seleccion-tarjeta">
                    <label class="cont-tipo-tarjeta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" fill-rule="evenodd" d="M2 7a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v1H2zm0 3v7a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-7zm5 2a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2z" clip-rule="evenodd"/></svg>
                        <input checked type="radio" name="tipo_tarjeta" value="debito"> Debito
                    </label>
                    <label class="cont-tipo-tarjeta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9M3 9V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2M3 9h18M7 13h5"/></svg>
                        <input type="radio" name="tipo_tarjeta" value="credito"> Credito   
                    </label>
                </div>
            </div>

            <div class="cont-input">
                <label for="nombre_titular" class="lbl">Nombre del titular</label>
                <input class="input-tarjeta" type="text" id="nombre_titular" name="nombre_titular" required>
            </div>
            <div class="cont-input">
                <label for="numero_tarjeta" class="lbl">Numero de tarjeta</label>
                <input class="input-tarjeta" type="text" id="numero_tarjeta" name="numero_tarjeta" maxlength="19" pattern="\d{16,19}" required>
            </div>
            <div class="cont-input">
                <label for="vencimiento" class="lbl">Vencimiento</label>
                <input class="input-tarjeta" type="month" id="vencimiento" name="vencimiento" required>
            </div>
            <div class="cont-input">
                <label for="cvv" class="lbl">CVV</label>
                <input class="input-tarjeta" type="password" id="cvv" name="cvv" maxlength="4" pattern="\d{3,4}" required>
            </div>
            <div class="cont-input">
                <button class="btn-confirmar" type="submit" class="btn-confirmar">Confirmar pedido</button>
            </div>
        </form>
        <?php endif; ?>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>