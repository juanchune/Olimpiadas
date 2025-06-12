<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/ventas.css">
        <div class="cont-titulo-btn">
            <h2 class="subtitulo">Consultar ventas</h2>
        </div>
        <div class="seleccionar-tipo-venta">
            <a href="/Olimpiadas/Truway/php/admin/ventas-pagas.php" class="tipo-venta pagas seleccionado">Pagas</a>
            <a href="/Olimpiadas/Truway/php/admin/ventas-pendientes.php" class="tipo-venta pendientes">Pendites de pago</a></span>
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
        </section>
</main>

</body>
</html>