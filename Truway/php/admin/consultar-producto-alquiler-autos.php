<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
<main>
     <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-productos-alquiler-autos.css">
        <div class="cont-titulo-btn">
            <h2 class="subtitulo">Consultar productos</h2>
            
            <div class="cont-btns">
                 <a href="/Olimpiadas/Truway/php/admin/agregar-producto.php" class="btn-agregar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                        <path fill="currentColor" class="icon"
                            d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z" />
                    </svg>
                    Agregar
                </a>
            </div>
        </div>
        <div class="seleccionar-tipo-tabla">
            <a href="/Olimpiadas/Truway/php/admin/consultar-producto.php" class="tabla">Productos general</a>
            <a href="/Olimpiadas/Truway/php/admin/consultar-producto-paquetes.php" class="tabla">Paquetes</a>
            <a href="/Olimpiadas/Truway/php/admin/consultar-producto-excursiones.php" class="tabla">Excursiones</a>
            <a href="/Olimpiadas/Truway/php/admin/consultar-producto-alquiler-autos.php" class="tabla seleccionado">Alquiler vehiculos</a>
            <a href="/Olimpiadas/Truway/php/admin/consultar-producto-estadias.php" class="tabla">Estadías</a>
            <a href="/Olimpiadas/Truway/php/admin/consultar-producto-boletos-avion.php" class="tabla">Boletos de avión</a>
        </div>

        <div class="cont-filtros">
            <form method="get" action="" class="form-filtros">
                <div class=filtros>
                    <select class="select-filtro" name="capidad">
                         <option value="" disabled selected>Seleccione una capacidad</option>
                        <option value=""></option>
                    </select>

                    <select class="select-filtro" name="tipo">
                        <option value="" disabled selected>Seleccione un tipo</option>
                        <option value="" name=""></option>
                    </select>
                </div>

               <button class="btn-filtrar" name="filtar">Filtrar</button>
            </form>
        </div>

            <section class="section-tabla-productos">
                <article class="producto">
                    <div class="informacion-principal">
                        <div class="informacion">
                            <span class="lbl-informacion">ID VEHICULO</span>
                            <span class="lbl-informacion">ID PRODUCTO</span>
                            <span class="lbl-informacion">MARCA</span>
                            <span class="lbl-informacion">MODELO</span>
                            <span class="lbl-informacion">CAPACIDAD</span>
                            <span class="lbl-informacion">EMPRESA_RENTADORA</span>
                            <span class="lbl-informacion">TIPO</span>
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

                </article>
        </section>
    </main>
</script>
</body>
</html>