<?php
session_start();
include('conexion.php');
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';

// mensaje para mostrar al usuario
$mensaje = '';
$id_usuario = $_SESSION['id'] ?? 0;

// obtener productos del carrito del usuario
$id_productos = [];
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
        for ($i = 0; $i < $col['cantidad']; $i++) {
            $id_productos[] = $col['id_producto'];
            if ($col['fecha_reserva']) {
                $fechas_reserva[] = $col['fecha_reserva'];
            }
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
    if ($id_usuario && count($id_productos) > 0 && $nombre_titular && $numero_tarjeta && $vencimiento && $cvv) {
        $cantidad = count($id_productos);

        // obtener la fecha mas cercana a hoy 
        $fecha = date('Y-m-d');
        if (count($fechas_reserva) > 0) {
            $hoy = strtotime(date('Y-m-d'));
            $fecha_mas_cercana = null;
            $diferencia_minima = null;
            foreach ($fechas_reserva as $f) {
                $diff = abs(strtotime($f) - $hoy);
                if ($diferencia_minima === null || $diff < $diferencia_minima) {
                    $diferencia_minima = $diff;
                    $fecha_mas_cercana = $f;
                }
            }
            if ($fecha_mas_cercana) {
                $fecha = $fecha_mas_cercana;
            }
        }

        // crear pedido pendiente
        $sql = "INSERT INTO pedidos (id_usuario, fecha, precio_total, metodo_pago, cantidad) 
                VALUES ($id_usuario, '$fecha', $carrito_total, '$metodo_pago', $cantidad)";
        if (mysqli_query($conexion, $sql)) {
            $id_pedido = mysqli_insert_id($conexion);

            // guardar todos los productos del carrito en detalle_pedido
            foreach ($id_productos as $id_prod) {
                $id_prod = intval($id_prod);
                mysqli_query($conexion, "INSERT INTO detalle_pedido (id_pedido, id_producto) VALUES ($id_pedido, $id_prod)");
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
    <section class="facturacion">
        <h2>Datos de facturacion</h2>
        <?php if ($mensaje): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php elseif (count($id_productos) === 0): ?>
            <p>No hay productos en el carrito</p>
        <?php else: ?>
        <form method="post" class="form-facturacion">
            <div class="cont-input">
                <label for="nombre_titular">Nombre del titular</label>
                <input type="text" id="nombre_titular" name="nombre_titular" required>
            </div>
            <div class="cont-input">
                <label for="numero_tarjeta">Numero de tarjeta</label>
                <input type="text" id="numero_tarjeta" name="numero_tarjeta" maxlength="19" pattern="\d{16,19}" required>
            </div>
            <div class="cont-input">
                <label for="vencimiento">Vencimiento</label>
                <input type="month" id="vencimiento" name="vencimiento" required>
            </div>
            <div class="cont-input">
                <label for="cvv">CVV</label>
                <input type="password" id="cvv" name="cvv" maxlength="4" pattern="\d{3,4}" required>
            </div>
            <div class="cont-input">
                <button type="submit" class="btn-confirmar">Confirmar pedido</button>
            </div>
        </form>
        <?php endif; ?>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>