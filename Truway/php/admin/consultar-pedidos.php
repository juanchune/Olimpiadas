<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
$estado_facturacion = $_GET['estado_facturacion'] ?? 'aprobados';
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
                die('Estado no válido');
        }

        $pedidos_query = "SELECT id_pedido FROM `$tabla`";
        $pedidos_result = mysqli_query($conexion, $pedidos_query);
    ?>
    <section class="section-tabla-productos">
        <article class="producto">
            <div class="informacion-principal">
                <div class="informacion">
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

            // Obtener los productos que componen el pedido y su cantidad
            $detalle_query = "SELECT id_producto, cantidad FROM detalle_pedido WHERE id_pedido = '$id_pedido'";
            $detalle_result = mysqli_query($conexion, $detalle_query);
        ?>
        <article class="producto">
            <div class="informacion-principal">
                <button class="btn-desplegable">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M4 18q-.425 0-.712-.288T3 17t.288-.712T4 16h16q.425 0 .713.288T21 17t-.288.713T20 18zm0-5q-.425 0-.712-.288T3 12t.288-.712T4 11h16q.425 0 .713.288T21 12t-.288.713T20 13zm0-5q-.425 0-.712-.288T3 7t.288-.712T4 6h16q.425 0 .713.288T21 7t-.288.713T20 8z"/></svg>
                </button>
                <div class="informacion">
                    <span class="lbl-informacion"><?php echo $pedido['id_pedido']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['id_usuario']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['fecha']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['precio_total']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['metodo_pago']; ?></span>
                    <span class="lbl-informacion"><?php echo $pedido['cantidad']; ?></span>
                </div>
            </div>
            <div class="detalles-producto oculto">
            <div class="informacion-secundaria">
                <div class="informacion">
                    <span class="lbl-informacion"><strong>ID PRODUCTO</strong></span>
                    <span class="lbl-informacion"><strong>NOMBRE</strong></span>
                    <span class="lbl-informacion"><strong>DESCRIPCIÓN</strong></span>
                    <span class="lbl-informacion"><strong>PRECIO</strong></span>
                    <span class="lbl-informacion"><strong>CANTIDAD</strong></span>
                </div>
                <div class="lista-productos-pedido">
                    <?php
                    while ($detalle = mysqli_fetch_assoc($detalle_result)) {
                        $id_producto = $detalle['id_producto'];
                        $cantidad_producto = $detalle['cantidad'];
                        $producto_query = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
                        $producto_result = mysqli_query($conexion, $producto_query);
                        $producto = mysqli_fetch_assoc($producto_result);
                    ?>
                    <div class="informacion producto-pedido">
                        <span class="lbl-informacion"><?php echo $producto['id_producto']; ?></span>
                        <span class="lbl-informacion"><?php echo $producto['nombre']; ?></span>
                        <span class="lbl-informacion"><?php echo $producto['descripcion']; ?></span>
                        <span class="lbl-informacion"><?php echo $producto['precio']; ?></span>
                        <span class="lbl-informacion"><?php echo $cantidad_producto; ?></span>
                    </div>
                    <?php } ?>
                </div>
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

            // Cierra todos los demás detalles-producto
            document.querySelectorAll('.detalles-producto').forEach(detalle => {
                if (detalle !== detalleActual) {
                    detalle.classList.remove('activo');
                    detalle.classList.add('oculto');
                }
            });

            // Alterna el actual
            detalleActual.classList.toggle('activo');
            detalleActual.classList.toggle('oculto');
        });
    });
</script>