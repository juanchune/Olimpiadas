<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

$query = "SELECT * FROM `pedidos` WHERE pedidos.estado_facturacion = 2";

include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
$result = mysqli_query($conexion, $query);
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/ventas.css">
        <div class="cont-titulo-btn">
            <h2 class="subtitulo">Consultar ventas</h2>
        </div>
        <div class="seleccionar-tipo-venta">
            <a href="/Olimpiadas/Truway/php/admin/ventas-pagas.php" class="tipo-venta pagas seleccionado">Pagas</a>
            <a href="/Olimpiadas/Truway/php/admin/ventas-pendientes.php" class="tipo-venta pendientes">Pendientes de pago</a></span>
        </div>

         <section class="section-tabla-productos">
                <article class="producto">
                    <div class="informacion-principal">
                        <div class="informacion">
                            <span class="lbl-informacion">ID PEDIDO</span>
                            <span class="lbl-informacion">ID USUARIO</span>
                            <span class="lbl-informacion">FECHA</span>
                            <span class="lbl-informacion">PRECIO_TOTAL</span>
                            <span class="lbl-informacion">METODO_PAGO</span>
                            <span class="lbl-informacion">CANTIDAD</span>
                        </div>
                    </div>
                </article>

                <?php while ($row = mysqli_fetch_assoc($result)) {
            echo "<article class='producto'>
                    <div class='informacion-principal'>
                        <div class='informacion'>
                            <span class='lbl-informacion'>". $row['id_pedido']. "</span>
                            <span class='lbl-informacion'>". $row['id_usuario']. "</span>
                            <span class='lbl-informacion'>". $row['fecha']. "</span>
                            <span class='lbl-informacion'>". $row['precio_total']. "</span>
                            <span class='lbl-informacion'>". $row['metodo_pago']. "</span>
                            <span class='lbl-informacion'>". $row['cantidad']. "</span>
                        </div>
                    </div>";
                    }?>
                </article>
        </section>
</main>

</body>
</html>