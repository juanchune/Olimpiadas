<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
$estado_facturacion = $_GET['estado_facturacion'] ?? 'aprobados';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = intval($_POST['id_pedido'] ?? 0);

    if (isset($_POST['aprobar'])) {
        mysqli_query($conexion, "DELETE FROM pedidos_pendientes WHERE id_pedido = $id_pedido");
        mysqli_query($conexion, "INSERT IGNORE INTO pedidos_aprobados (id_pedido) VALUES ($id_pedido)");


        $estado_result = mysqli_query($conexion, "SELECT id_estado FROM estado_facturacion WHERE estado = 'pendiente' LIMIT 1");
        $estado_row = mysqli_fetch_assoc($estado_result);
        $id_estado = $estado_row ? intval($estado_row['id_estado']) : 'NULL';

        $insert_ventas = "INSERT IGNORE INTO ventas (id_pedido, estado_facturacion) VALUES ($id_pedido, $id_estado)";
        mysqli_query($conexion, $insert_ventas);
    }
    if (isset($_POST['rechazar'])) {
        mysqli_query($conexion, "DELETE FROM pedidos_pendientes WHERE id_pedido = $id_pedido");
        mysqli_query($conexion, "INSERT IGNORE INTO pedidos_rechazados (id_pedido) VALUES ($id_pedido)");
    }
    header("Location: consultar-pedidos.php");
    exit();
}
?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-pedidos.css">
    <div class="cont-titulo-btn">
        <h2 class="subtitulo">Consultar pedidos</h2>
    </div>
    <div class="seleccionar-tipo-pedido">
        <a href="consultar-pedidos.php?estado_facturacion=aprobados" class="tipo-pedido entregados <?php echo ($estado_facturacion === 'aprobados') ? 'seleccionado' : ''; ?>">Entregados</a>
        <a href="consultar-pedidos.php?estado_facturacion=pendientes" class="tipo-pedido pendientes <?php echo ($estado_facturacion === 'pendientes') ? 'seleccionado' : ''; ?>">Pendientes</a>
        <a href="consultar-pedidos.php?estado_facturacion=rechazados" class="tipo-pedido rechazados <?php echo ($estado_facturacion === 'rechazados') ? 'seleccionado' : ''; ?>">Rechazados</a>
    </div>
    <?php
        switch ($estado_facturacion) {
            case 'aprobados':
                $tabla = 'pedidos_aprobados';
                break;
            case 'pendientes':
                $tabla = 'pedidos_pendientes';
                break;
            case 'rechazados':
                $tabla = 'pedidos_rechazados';
                break;
            default:
                die('Estado no valido');
        }

        $pedidos_query = "SELECT id_pedido FROM `$tabla`";
        $pedidos_result = mysqli_query($conexion, $pedidos_query);
    ?>
    <section class="section-tabla-productos">
        <article class="producto">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion"> </span>
                    <span class="lbl-informacion">ID PEDIDO</span>
                    <span class="lbl-informacion">ID USUARIO</span>
                    <span class="lbl-informacion">FECHA</span>
                    <span class="lbl-informacion">PRECIO TOTAL</span>
                    <span class="lbl-informacion">METODO PAGO</span>
                    <span class="lbl-informacion">CANTIDAD</span>
                </div>
            </div>
        </article>
        <?php
        while ($row = mysqli_fetch_assoc($pedidos_result)) {
            $id_pedido = $row['id_pedido'];
            $pedido_query = "SELECT * FROM pedidos WHERE id_pedido = '$id_pedido'";
            $pedido_result = mysqli_query($conexion, $pedido_query);
            $pedido = mysqli_fetch_assoc($pedido_result);

            $detalle_query = "SELECT id_producto, cantidad FROM detalle_pedido WHERE id_pedido = '$id_pedido'";
            $detalle_result = mysqli_query($conexion, $detalle_query);
        ?>
        <article class="producto">
            <div class="informacion-principal">
            
                <div class="informacion">
                    <button class="btn-desplegable">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M4 18q-.425 0-.712-.288T3 17t.288-.712T4 16h16q.425 0 .713.288T21 17t-.288.713T20 18zm0-5q-.425 0-.712-.288T3 12t.288-.712T4 11h16q.425 0 .713.288T21 12t-.288.713T20 13zm0-5q-.425 0-.712-.288T3 7t.288-.712T4 6h16q.425 0 .713.288T21 7t-.288.713T20 8z"/></svg>
                    </button>
                    <span class="lbl-informacion"><?php echo $pedido['id_pedido']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['id_usuario']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['fecha']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['precio_total']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['metodo_pago']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['cantidad']; ?></span>
                     <?php if ($estado_facturacion === 'pendientes'): ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                <button type="submit" name="aprobar" class="btn-aprobar"><svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M9 16.17L5.53 12.7a.996.996 0 1 0-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 1 0-1.41-1.41z"/></svg>
                                </button>
                                <button type="submit" name="rechazar" class="btn-rechazar"><svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g class="icon" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M5.47 5.47a.75.75 0 0 1 1.06 0l12 12a.75.75 0 1 1-1.06 1.06l-12-12a.75.75 0 0 1 0-1.06"/><path d="M18.53 5.47a.75.75 0 0 1 0 1.06l-12 12a.75.75 0 0 1-1.06-1.06l12-12a.75.75 0 0 1 1.06 0"/></g></svg></button>
                            </form>
                        <?php endif; ?>
                </div>
            </div>
            <div class="detalles-producto oculto">
            <div class="informacion-secundaria">
                <div class="informacion">
                    <span class="lbl-informacion"><strong>ID PRODUCTO</strong></span>
                    <span class="lbl-informacion"><strong>NOMBRE</strong></span>
                    <span class="lbl-informacion"><strong>DESCRIPCION</strong></span>
                    <span class="lbl-informacion"><strong>PRECIO</strong></span>
                    <span class="lbl-informacion"><strong>CANTIDAD</strong></span>
                </div>
                    <?php
                    while ($detalle = mysqli_fetch_assoc($detalle_result)) {?>
                        <?php 
                        $id_producto = $detalle['id_producto'];
                        $cantidad_producto = $detalle['cantidad'];
                        $producto_query = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
                        $producto_result = mysqli_query($conexion, $producto_query);
                        $producto = mysqli_fetch_assoc($producto_result);
                    ?>
                    <div class="informacion">
                        <span class="lbl-informacion"><?php echo $producto['id_producto']; ?></span>
                        <span class="lbl-informacion"><?php echo $producto['nombre']; ?></span>
                        <span class="lbl-informacion"><?php echo $producto['descripcion']; ?></span>
                        <span class="lbl-informacion"><?php echo $producto['precio']; ?></span>
                        <span class="lbl-informacion"><?php echo $cantidad_producto; ?></span>
                    </div>
                    <?php } ?>
            </div>
        </div>
        </article>
        <?php } ?>
    </section>
</main>
</body>

<script>
    document.querySelectorAll('.btn-desplegable').forEach(btn => {
        btn.addEventListener('click', () => {
            const producto = btn.closest('.producto');
            const detalleActual = producto.querySelector('.detalles-producto');

            document.querySelectorAll('.detalles-producto').forEach(detalle => {
                if (detalle !== detalleActual) {
                    detalle.classList.remove('activo');
                    detalle.classList.add('oculto');
                }
            });

            detalleActual.classList.toggle('activo');
            detalleActual.classList.toggle('oculto');
        });
    });
</script>