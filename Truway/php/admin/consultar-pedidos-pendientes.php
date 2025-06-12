<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-pedidos.css">
        <div class="cont-titulo-btn">
            <h2 class="subtitulo">Consultar pedidos</h2>
        </div>
        <div class="seleccionar-tipo-pedido">
            <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-entregados.php" class="tipo-pedido entregados">Entregados</a>
            <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-pendientes.php"  class="tipo-pedido pendientes seleccionado">Pendientes</a></span>
            <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-rechazados.php" class="tipo-pedido rechazados">Rechazados</a></span>
        </div>
   <section class="section-tabla-productos">
                <article class="producto">
                    <div class="informacion-principal">
                        <button class="btn-desplegable">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M4 18q-.425 0-.712-.288T3 17t.288-.712T4 16h16q.425 0 .713.288T21 17t-.288.713T20 18zm0-5q-.425 0-.712-.288T3 12t.288-.712T4 11h16q.425 0 .713.288T21 12t-.288.713T20 13zm0-5q-.425 0-.712-.288T3 7t.288-.712T4 6h16q.425 0 .713.288T21 7t-.288.713T20 8z"/></svg>
                        </button>
                        <div class="informacion">
                            <span class="lbl-informacion">ID PEDIDO</span>
                            <span class="lbl-informacion">ID USUARIO</span>
                            <span class="lbl-informacion">FECHA PEDIDO</span>
                            <span class="lbl-informacion">PRECIO TOTAL</span>
                            <span class="lbl-informacion">METODO_PAGO</span>
                            <span class="lbl-informacion">CANTIDAD</span>
                        </div>
                        <div class="btns">
                            <button class="btn-aprovar">
                               <svg xmlns="http://www.w3.org/2000/svg"class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M9 16.17L5.53 12.7a.996.996 0 1 0-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 1 0-1.41-1.41z"/></svg>
                            </button>
                            <button class="btn-rechazar">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M5.47 5.47a.75.75 0 0 1 1.06 0l12 12a.75.75 0 1 1-1.06 1.06l-12-12a.75.75 0 0 1 0-1.06"/><path d="M18.53 5.47a.75.75 0 0 1 0 1.06l-12 12a.75.75 0 0 1-1.06-1.06l12-12a.75.75 0 0 1 1.06 0"/></g></svg>
                            </button>
                        </div>
                    </div>

                    <div class="detalles-producto oculto">
                        <div class="grupo-productos">
                            <div class="informacion-secundaria">
                                <div class="informacion">
                                    <span class="lbl-informacion">ID PRODUCTO</span>
                                    <span class="lbl-informacion">NOMBRE PRODUCTO</span>
                                    <span class="lbl-informacion">TIPO</span>
                                    <span class="lbl-informacion">FEHCA</span>
                                    <span class="lbl-informacion">DESTINO</span>
                                    <span class="lbl-informacion">CANTIDAD PER</span>
                                    <span class="lbl-informacion">PRECIO</span>
                                </div>
                            </div>
                            <div class="informacion-secundaria">
                                <div class="informacion">
                                    <span class="lbl-informacion">ID PRODUCTO</span>
                                    <span class="lbl-informacion">NOMBRE PRODUCTO</span>
                                    <span class="lbl-informacion">TIPO</span>
                                    <span class="lbl-informacion">FEHCA</span>
                                    <span class="lbl-informacion">DESTINO</span>
                                    <span class="lbl-informacion">CANTIDAD PER</span>
                                    <span class="lbl-informacion">PRECIO</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
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
</html>