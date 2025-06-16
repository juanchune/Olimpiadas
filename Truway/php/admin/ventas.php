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
        
         <section class="section-tabla-productos">
                <article class="producto">
                    <div class="informacion-principal">
                        <div class="informacion">
                            <span class="lbl-informacion">ID PEDIDO</span>
                            <span class="lbl-informacion">ID VENTA</span>
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