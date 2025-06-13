<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Consulta para obtener los pedidos entregados
$query = "SELECT p.id_pedido, p.id_usuario, p.fecha, p.precio_total, p.metodo_pago, p.cantidad, pr.id_producto, pr.nombre, pr.descripcion, pr.precio 
          FROM pedidos p
          JOIN detalle_carrito dc ON p.id_pedido = dc.id_carrito
          JOIN productos pr ON dc.id_producto = pr.id_producto
          WHERE p.estado = 'aprobado'";
$result = mysqli_query($conexion, $query);
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; ?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-pedidos.css">
    <div class="cont-titulo-btn">
        <h2 class="subtitulo">Consultar pedidos</h2>
    </div>
    <div class="seleccionar-tipo-pedido">
        <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-entregados.php" class="tipo-pedido entregados seleccionado">Entregados</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-pendientes.php" class="tipo-pedido pendientes">Pendientes</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-rechazados.php" class="tipo-pedido rechazados">Rechazados</a>
    </div>
    <section class="section-tabla-productos">
        <?php while ($dato = mysqli_fetch_assoc($result)) { ?>
            <article class="producto">
                <div class="informacion-principal">
                    <button class="btn-desplegable">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path class="icon" fill="currentColor" d="M4 18q-.425 0-.712-.288T3 17t.288-.712T4 16h16q.425 0 .713.288T21 17t-.288.713T20 18zm0-5q-.425 0-.712-.288T3 12t.288-.712T4 11h16q.425 0 .713.288T21 12t-.288.713T20 13zm0-5q-.425 0-.712-.288T3 7t.288-.712T4 6h16q.425 0 .713.288T21 7t-.288.713T20 8z"/>
                        </svg>
                    </button>
                    <div class="informacion">
                        <span class="lbl-informacion">ID PEDIDO: <?= $dato['id_pedido'] ?></span>
                        <span class="lbl-informacion">ID USUARIO: <?= $dato['id_usuario'] ?></span>
                        <span class="lbl-informacion">FECHA PEDIDO: <?= $dato['fecha'] ?></span>
                        <span class="lbl-informacion">PRECIO TOTAL: <?= $dato['precio_total'] ?></span>
                        <span class="lbl-informacion">METODO PAGO: <?= $dato['metodo_pago'] ?></span>
                        <span class="lbl-informacion">CANTIDAD: <?= $dato['cantidad'] ?></span>
                    </div>
                </div>
                <div class="detalles-producto oculto">
                    <div class="informacion-secundaria">
                        <div class="informacion">
                            <span class="lbl-informacion">ID PRODUCTO: <?= $dato['id_producto'] ?></span>
                            <span class="lbl-informacion">NOMBRE PRODUCTO: <?= $dato['nombre'] ?></span>
                            <span class="lbl-informacion">DESCRIPCIÓN: <?= $dato['descripcion'] ?></span>
                            <span class="lbl-informacion">PRECIO: <?= $dato|['precio'] ?></span>
                        </div>
                    </div>
                </div>
            </article>
        <?php } ?>
    </section>
</main>

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
</body>