<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo "Debes iniciar sesión para ver tus pedidos.";
    exit;
}

// Obtener nombre y apellido del usuario
$id_usuario = (int)$_SESSION['id'];
$query_usuario = "SELECT nombre, apellido FROM usuarios WHERE id_usuario = $id_usuario";
$resultado_usuario = mysqli_query($conexion, $query_usuario);

if ($resultado_usuario && mysqli_num_rows($resultado_usuario) > 0) {
    $fila = mysqli_fetch_assoc($resultado_usuario);
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
} else {
    echo "Error al obtener la información del usuario.";
    exit;
}

// Consultar los pedidos del usuario
$query_pedidos = "SELECT * FROM pedidos WHERE id_usuario = $id_usuario ORDER BY fecha DESC";
$resultado_pedidos = mysqli_query($conexion, $query_pedidos);
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/perfil.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; ?>

    <section class="section-informacion-user">
        <span class="nombre-apellido"><?php echo htmlspecialchars($nombre); ?> <?php echo htmlspecialchars($apellido); ?></span>
    </section>
    <section class="section-pedidos-realizados">
        <h2 class="subtitulo">Mis pedidos</h2>

        <?php if ($resultado_pedidos && mysqli_num_rows($resultado_pedidos) > 0): ?>
            <div class="grid-pedidos">
                <?php while ($pedido = mysqli_fetch_assoc($resultado_pedidos)): ?>
                    <article class="tarjeta-pedido <?php echo htmlspecialchars($pedido['estado']); ?>">
                        <div class="cont-datos-pedido">
                            <div class="cont-informacion">
                                <span class="lbl">ID Orden</span>
                                <span class="lbl-informacion id"><?php echo htmlspecialchars($pedido['id_pedido']); ?></span>
                            </div>
                            <div class="cont-informacion">
                                <span class="lbl">Total</span>
                                <span class="lbl-informacion total"><?php echo htmlspecialchars($pedido['precio_total']); ?></span>
                            </div>
                            <div class="cont-informacion">
                                <span class="lbl">Tipo de pago</span>
                                <span class="lbl-informacion pago"><?php echo htmlspecialchars($pedido['metodo_pago']); ?></span>
                            </div>
                            <div class="cont-informacion">
                                <span class="lbl">Fecha pedido</span>
                                <span class="lbl-informacion fecha"><?php echo htmlspecialchars($pedido['fecha']); ?></span>
                            </div>
                            <div class="cont-informacion">
                                <span class="lbl">Cantidad de productos</span>
                                <span class="lbl-informacion cant-productos"><?php echo htmlspecialchars($pedido['cantidad']); ?></span>
                            </div>
                            <div class="cont-informacion">
                                <span class="lbl">Estado</span>
                                <span class="lbl-informacion estado"><?php echo htmlspecialchars($pedido['estado']); ?></span>
                            </div>
                        </div>

                        <div class="grid-productos">
                            <?php
                            // Obtener los productos del pedido
                            $query_productos = "SELECT p.nombre, p.descripcion, p.precio, tp.tipo 
                                                FROM detalle_carrito dc
                                                JOIN productos p ON dc.id_producto = p.id_producto
                                                JOIN tipo_producto tp ON p.tipo_producto = tp.id_tipo
                                                WHERE dc.id_carrito = {$pedido['id_pedido']}";
                            $resultado_productos = mysqli_query($conexion, $query_productos);

                            if ($resultado_productos && mysqli_num_rows($resultado_productos) > 0):
                                while ($producto = mysqli_fetch_assoc($resultado_productos):
                            ?>
                                <article class="producto">
                                    <div class="cont-superior">
                                        <div class="cont-tag">
                                            <div class="tag">
                                                <span class="nombre-tag"><?php echo htmlspecialchars($producto['tipo']); ?></span>
                                            </div>
                                        </div>
                                        <div class="cont-grid-titulo-btns">
                                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                                            <div class="cont-btns">
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
                                                <span class="lbl-nombre">Descripción:</span>
                                                <span class="lbl-nombre">Precio:</span>
                                            </div>
                                            <div class="cont-informacion">
                                                <span class="informacion descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></span>
                                                <span class="informacion precio">$<?php echo htmlspecialchars($producto['precio']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php
                                endwhile;
                            endif;
                            ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No tienes pedidos realizados.</p>
        <?php endif; ?>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>