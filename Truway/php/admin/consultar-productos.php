<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
<main>
     <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-productos.css">
        <div class="cont-titulo-btn">
            <h2 class="subtitulo">Consultar productos</h2>
            
            <div class="cont-btns">
                <button class="btn-agregar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                        <path fill="currentColor" class="icon"
                            d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z" />
                    </svg>
                    Agregar
                </button>
            </div>
        </div>
        <div class="seleccionar-tipo-tabla">
                <a href="consultar-pedidos-entregados.html" class="tabla paquetes">Tabla paquetes</a>
                <a href="consultar-pedidos-pendientes.html"  class="tabla exursiones">Tabla exursiones</a></span>
                <a href="consultar-pedidos-rechazados.html" class="tabla aqluiler-autos">Tabla alquiler autos</a></span>
                <a href="consultar-pedidos-rechazados.html" class="tabla estadias">Tabla estadias</a></span>
                <a href="consultar-pedidos-rechazados.html" class="tabla boletos-avion">Tabla boleteos de avion</a></span>
            </div>
        <div class="cont-filtros">
            <form method="get" action="" class="form-filtros">
                <div class=filtros>
                    <select class="select-filtro" name="tipo-producto">
                        <option value="" disabled selected>Seleccione un tipo de producto</option>
                        <option value="paquetes" name="paquetes">Paquetes</option>
                        <option value="excursion" name="excursion">Excursion</option>
                        <option value="pasaje-avion" name="pasaje-avion">Pasajes de avion</option>
                        <option value="estaida" name="estadia" >Estadia</option>
                        <option value="vehiculo" name="vehiculo" >Vehiculo</option>
                    </select>

                    <select class="select-filtro" name="precio">
                        <option value="" disabled selected>Seleccion un rango de precio</option>
                        <option value="" name=""></option>
                    </select>
                </div>

               <button class="btn-filtrar" name="filtar">Filtrar</button>
            </form>
        </div>

            <section class="section-tabla-productos">
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