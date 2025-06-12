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
</html>