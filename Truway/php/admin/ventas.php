<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');


$fecha_actual = date('Y-m-d');
$sql_ventas = "SELECT v.id_venta, v.id_pedido 
               FROM ventas v 
               WHERE v.estado_facturacion = 2 OR v.estado_facturacion = 1";
$resultado_ventas = mysqli_query($conexion, $sql_ventas);

while ($venta = mysqli_fetch_assoc($resultado_ventas)) {
    $idVenta = $venta['id_venta'];
    $idPedido = $venta['id_pedido'];


    $fechaMasCercana = null;
    $diferenciaMinima = null;
    $timestampActual = strtotime($fecha_actual);

    $sqlFechasDetalle = "SELECT fecha FROM detalle_pedido WHERE id_pedido = $idPedido";
    $resultadoFechas = mysqli_query($conexion, $sqlFechasDetalle);
    while ($detalle = mysqli_fetch_assoc($resultadoFechas)) {
        $fechaDetalle = $detalle['fecha'];
        $timestampDetalle = strtotime($fechaDetalle);
        $diferencia = abs($timestampDetalle - $timestampActual);
        if ($diferenciaMinima === null || $diferencia < $diferenciaMinima) {
            $diferenciaMinima = $diferencia;
            $fechaMasCercana = $fechaDetalle;
        }
    }

    if ($fechaMasCercana) {
        $unDiaAntes = date('Y-m-d', strtotime($fechaMasCercana . ' -1 day'));
        if ($fecha_actual >= $unDiaAntes) {
            // Marcar como paga
            mysqli_query($conexion, "UPDATE ventas SET estado_facturacion = 1 WHERE id_venta = $idVenta");
        } else {
            // Marcar como pendiente
            mysqli_query($conexion, "UPDATE ventas SET estado_facturacion = 2 WHERE id_venta = $idVenta");
        }
    }
}
?>
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
    $tipoVenta = $_GET['tipo_venta'] ?? 'pagas';
    ?>

    <link rel="stylesheet" href="/Olimpiadas/Truway/css/ventas.css">
    <div class="cont-titulo-btn">
        <h2 class="subtitulo">Consultar ventas</h2>
    </div>
    <div class="seleccionar-tipo-venta">
        <a href="ventas.php?tipo_venta=pagas<?= isset($_GET['buscar']) ? '&buscar=' . urlencode($_GET['buscar']) : '' ?><?= isset($_GET['fecha_venta']) ? '&fecha_venta=' . urlencode($_GET['fecha_venta']) : '' ?>" class="tipo-venta pagas <?php echo ($tipoVenta === 'pagas') ? 'seleccionado' : ''; ?>">Pagas y Entregadas</a>
        <a href="ventas.php?tipo_venta=pendientes<?= isset($_GET['buscar']) ? '&buscar=' . urlencode($_GET['buscar']) : '' ?><?= isset($_GET['fecha_venta']) ? '&fecha_venta=' . urlencode($_GET['fecha_venta']) : '' ?>" class="tipo-venta pendientes <?php echo ($tipoVenta === 'pendientes') ? 'seleccionado' : ''; ?>">Pendientes de pago</a>
    </div>

    <?php
    $estado = ($tipoVenta === 'pendientes') ? 2 : 1;

    // Filtro de búsqueda y fecha
    $busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
    $fechaVentaFiltro = isset($_GET['fecha_venta']) ? trim($_GET['fecha_venta']) : '';
    $where = "";

    if ($busqueda !== '') {
        $busquedaEsc = mysqli_real_escape_string($conexion, $busqueda);
        $where .= " AND (u.nombre LIKE '%$busquedaEsc%' OR u.email LIKE '%$busquedaEsc%')";
    }
    if ($fechaVentaFiltro !== '') {
        $fechaVentaEsc = mysqli_real_escape_string($conexion, $fechaVentaFiltro);
        $where .= " AND v.fecha_venta = '$fechaVentaEsc'";
    }

    // Obtener fechas únicas para el filtro
    $fechasQuery = "SELECT DISTINCT v.fecha_venta FROM ventas v ORDER BY v.fecha_venta DESC";
    $fechasResult = mysqli_query($conexion, $fechasQuery);

    $query = "SELECT 
                v.id_pedido, 
                v.id_venta, 
                u.nombre AS nombre_usuario, 
                u.email AS email_usuario, 
                v.fecha_venta, 
                ef.estado AS estado_facturacion
            FROM ventas v
            JOIN estado_facturacion ef ON v.estado_facturacion = ef.id_estado
            JOIN pedidos p ON v.id_pedido = p.id_pedido
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            WHERE v.estado_facturacion = $estado $where
            ORDER BY v.id_venta DESC";
    $result = mysqli_query($conexion, $query);
    ?>

    <div class="cont-filtros">
        <form method="get" action="" class="form-filtros">
            <input type="hidden" name="tipo_venta" value="<?= htmlspecialchars($tipoVenta) ?>">
            <select class="select-filtro" name="fecha_venta" onchange="this.form.submit()">
                <option value="">Todas las fechas</option>
                <?php while ($fechaRow = mysqli_fetch_assoc($fechasResult)) { 
                    $fechaVal = $fechaRow['fecha_venta'];
                ?>
                    <option value="<?= htmlspecialchars($fechaVal) ?>" <?= ($fechaVentaFiltro === $fechaVal) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($fechaVal) ?>
                    </option>
                <?php } ?>
            </select>
            <div class="barra-buscar">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0s.41-1.08 0-1.49zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14"/></svg>
                <input type="search" name="buscar" class="input-buscar" placeholder="Nombre o email de usuario" value="<?= htmlspecialchars($busqueda) ?>">
            </div>
            <button class="btn-filtrar" name="buscar_btn" type="submit">Buscar</button>
        </form>
    </div>
    
    <section class="section-tabla-productos">
        <article class="producto">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion">ID PEDIDO</span>
                    <span class="lbl-informacion">ID VENTA</span>
                    <span class="lbl-informacion">NOMBRE USUARIO</span>
                    <span class="lbl-informacion">EMAIL USUARIO</span>
                    <span class="lbl-informacion">FECHA VENTA</span>
                    <span class="lbl-informacion">ESTADO FACTURACION</span>
                </div>
            </div>
        </article>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <article class='producto'>
                <div class='informacion-principal'>
                    <div class='informacion'>
                        <span class='lbl-informacion'><?= $row['id_pedido']; ?></span>
                        <span class='lbl-informacion'><?= $row['id_venta']; ?></span>
                        <span class='lbl-informacion'><?= htmlspecialchars($row['nombre_usuario']); ?></span>
                        <span class='lbl-informacion'><?= htmlspecialchars($row['email_usuario']); ?></span>
                        <span class='lbl-informacion'><?= $row['fecha_venta']; ?></span>
                        <span class='lbl-informacion'><?= ucfirst($row['estado_facturacion']); ?></span>
                    </div>
                </div>
            </article>
        <?php } ?>
    </section>
</main>
</body>
</html>