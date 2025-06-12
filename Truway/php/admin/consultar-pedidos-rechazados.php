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
            <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-pendientes.php"  class="tipo-pedido pendientes">Pendientes</a></span>
            <a href="/Olimpiadas/Truway/php/admin/consultar-pedidos-rechazados.php" class="tipo-pedido rechazados seleccionado">Rechazados</a></span>
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
                <article class="producto">
                    <div class="informacion-principal">
                        <button class="btn-desplegable">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M4 18q-.425 0-.712-.288T3 17t.288-.712T4 16h16q.425 0 .713.288T21 17t-.288.713T20 18zm0-5q-.425 0-.712-.288T3 12t.288-.712T4 11h16q.425 0 .713.288T21 12t-.288.713T20 13zm0-5q-.425 0-.712-.288T3 7t.288-.712T4 6h16q.425 0 .713.288T21 7t-.288.713T20 8z"/></svg>
                        </button>
                        <div class="informacion">
                            <span class="lbl-informacion">IaaaaaaD</span>
                            <span class="lbl-informacion">Nomaaaaaaaaaaaaaaaaaaaaaaaaaabre</span>
                            <span class="lbl-informacion">Tipo aaaaao</span>
                            <span class="lbl-informacion">Preciaaaaaaaaaaao</span>
                        </div>

                        <div class="btns">
                            <button class="btn-modificar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path stroke="currentColor" class="icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0z"/><path class="icon" fill="currentColor" d="m5 16l-1 4l4-1L18 9l-3-3z"/><path class="icon" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 6l3 3m-5 11h8"/></g></svg>
                            </button>
                            <button class="btn-eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zm3-4q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="detalles-producto oculto">
                        <div class="cont-descripcion">
                            <h5>Descripcion</h5>
                            <p class="descripcion">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum aliquid ex repudiandae veritatis quibusdam eligendi a, ea officiis, aspernatur consectetur porro maxime dolorem voluptate rerum cum perspiciatis non. Quaerat, sit.</p>
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