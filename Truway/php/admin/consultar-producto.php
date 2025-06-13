<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Consulta inicial para obtener todos los productos
$query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, tp.tipo 
          FROM productos p
          JOIN tipo_producto tp ON p.tipo_producto = tp.id_tipo";
$filters = [];

// Aplicar filtros si se envían por GET
if (isset($_GET['tipo-producto']) && $_GET['tipo-producto'] !== '') {
    $filters[] = "tp.tipo = '" . mysqli_real_escape_string($conexion, $_GET['tipo-producto']) . "'";
}
if (isset($_GET['precio']) && $_GET['precio'] !== '') {
    $filters[] = "p.precio <= " . intval($_GET['precio']);
}

// Si hay filtros, añadirlos a la consulta
if (!empty($filters)) {
    $query .= " WHERE " . implode(" AND ", $filters);
}

$result = mysqli_query($conexion, $query);

// Obtener valores únicos para los filtros
$tipoProductoQuery = "SELECT DISTINCT tipo FROM tipo_producto ORDER BY tipo ASC";
$tipoProductoResult = mysqli_query($conexion, $tipoProductoQuery);

$precioQuery = "SELECT DISTINCT precio FROM productos ORDER BY precio ASC";
$precioResult = mysqli_query($conexion, $precioQuery);
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; ?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-productos.css">
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
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto.php" class="tabla seleccionado">Productos general</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-paquetes.php" class="tabla">Paquetes</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-excursiones.php" class="tabla">Excursiones</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-alquiler-autos.php" class="tabla">Alquiler autos</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-estadias.php" class="tabla">Estadías</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-boletos-avion.php" class="tabla">Boletos de avión</a>
    </div>

    <div class="cont-filtros">
        <form method="get" action="" class="form-filtros">
            <div class="filtros">
                <select class="select-filtro" name="tipo-producto">
                    <option value="" disabled selected>Seleccione un tipo de producto</option>
                    <?php while ($tipoRow = mysqli_fetch_assoc($tipoProductoResult)) { ?>
                        <option value="<?= $tipoRow['tipo'] ?>"><?= $tipoRow['tipo'] ?></option>
                    <?php } ?>
                </select>

                <select class="select-filtro" name="precio">
                    <option value="" disabled selected>Seleccione un rango de precio</option>
                    <?php while ($precioRow = mysqli_fetch_assoc($precioResult)) { ?>
                        <option value="<?= $precioRow['precio'] ?>">Hasta $<?= $precioRow['precio'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <button class="btn-filtrar" name="filtrar">Filtrar</button>
        </form>
    </div>

    <section class="section-tabla-productos">
        <!-- Información principal fija como guía -->
        <article class="producto guia">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion">ID PRODUCTO</span>
                    <span class="lbl-informacion">NOMBRE</span>
                    <span class="lbl-informacion">TIPO</span>
                    <span class="lbl-informacion">PRECIO</span>
                </div>
            </div>
        </article>

        <!-- Productos dinámicos -->
        <?php while ($dato = mysqli_fetch_assoc($result)) { ?>
            <article class="producto">
                <div class="informacion-principal">
                    <div class="informacion">
                        <span class="lbl-informacion"><?= $dato['id_producto'] ?></span>
                        <span class="lbl-informacion"><?= $dato['nombre'] ?></span>
                        <span class="lbl-informacion"><?= $dato['tipo'] ?></span>
                        <span class="lbl-informacion">$<?= $dato['precio'] ?></span>
                    </div>
                    <div class="btns">
                        <button class="btn-modificar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path stroke="currentColor" class="icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0z" />
                                    <path class="icon" fill="currentColor" d="m5 16l-1 4l4-1L18 9l-3-3z" />
                                    <path class="icon" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m15 6l3 3m-5 11h8" />
                                </g>
                            </svg>
                        </button>
                        <button class="btn-eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path class="icon" fill="currentColor"
                                    d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zm3-4q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="detalles-producto oculto">
                    <div class="cont-descripcion">
                        <h5>Descripción</h5>
                        <p class="descripcion"><?= $dato['descripcion'] ?></p>
                    </div>
                </div>
            </article>
        <?php } ?>
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