<?php


session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Actualizar estado_facturacion de pendiente a pago si falta un día o menos para la fecha del pedido
$hoy = date('Y-m-d');
$query_pendientes = "SELECT v.id_venta, v.id_pedido, v.estado_facturacion, p.fecha 
                    FROM ventas v 
                    JOIN pedidos p ON v.id_pedido = p.id_pedido 
                    WHERE v.estado_facturacion = 2";
$res_pendientes = mysqli_query($conexion, $query_pendientes);
while ($venta = mysqli_fetch_assoc($res_pendientes)) {
    $fecha_pedido = $venta['fecha'];
    $un_dia_antes = date('Y-m-d', strtotime($fecha_pedido . ' -1 day'));
    if ($hoy >= $un_dia_antes) {
        $id_venta = $venta['id_venta'];
        mysqli_query($conexion, "UPDATE ventas SET estado_facturacion = 1 WHERE id_venta = $id_venta");
    }
}
?>
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
    $tipo_venta= $_GET['tipo_venta'] ?? 'pagas';
    ?>

    <link rel="stylesheet" href="/Olimpiadas/Truway/css/ventas.css">
        <div class="cont-titulo-btn">
            <h2 class="subtitulo">Consultar ventas</h2>
        </div>
          <div class="seleccionar-tipo-venta">
            <a href="ventas.php?tipo_venta=pagas" class="tipo-venta pagas <?php echo ($tipo_venta === 'pagas') ? 'seleccionado' : ''; ?>">Pagas y Entregadas</a>
            <a href="ventas.php?tipo_venta=pendientes" class="tipo-venta pendientes <?php echo ($tipo_venta === 'pendientes') ? 'seleccionado' : ''; ?>">Pendientes de pago</a>
        </div>

        <?php
            $estado = ($tipo_venta === 'pendientes') ? 2 : 1;
            $query = "SELECT v.*, ef.estado 
                      FROM ventas v 
                      JOIN estado_facturacion ef ON v.estado_facturacion = ef.id_estado
                      WHERE v.estado_facturacion = $estado";
            $result = mysqli_query($conexion, $query);
        ?>

        <div class="cont-filtros">
            <form method="get" action="" class="form-filtros">
            <select class="select-filtro" name="tipo">
                <option value="">Seleccione una fecha</option>
                </option>

            </select>

                <div class="barra-buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0s.41-1.08 0-1.49zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14"/></svg>
                    <input type="search" name="buscar" class="input-buscar" placeholder="Nombre o email de usuario" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
                </div>
            <button class="btn-filtrar" name="buscar" type="submit">Buscar</button>
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

                <?php while ($row = mysqli_fetch_assoc($result)) {
            echo "<article class='producto'>
                    <div class='informacion-principal'>
                        <div class='informacion'>
                            <span class='lbl-informacion'>". $row['id_pedido']. "</span>
                            <span class='lbl-informacion'>". $row['id_venta']. "</span>
                            <span class='lbl-informacion'>". $row['fecha_venta']. "</span>
                            <span class='lbl-informacion'>". ucfirst($row['estado']). "</span>
                        </div>
                    </div>
                 </article>";
                    }?>
        </section>
</main>

</body>
</html>