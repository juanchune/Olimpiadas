<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');


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
            <a href="ventas.php?tipo_venta=pagas" class="tipo-venta pagas <?php echo ($tipo_venta === 'pagas') ? 'seleccionado' : ''; ?>">Pagas</a>
            <a href="ventas.php?tipo_venta=pendientes" class="tipo-venta pendientes <?php echo ($tipo_venta === 'pendientes') ? 'seleccionado' : ''; ?>">Pendientes de pago</a>
        </div>

        <?php
            $estado = ($tipo_venta === 'pendientes') ? 2 : 1;
            $query = "SELECT * FROM `ventas` WHERE estado_facturacion = $estado";
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
                            <span class='lbl-informacion'>". $row['estado_facturacion']. "</span>
                        </div>
                    </div>
                 </article>";
                    }?>
        </section>
</main>

</body>
</html>