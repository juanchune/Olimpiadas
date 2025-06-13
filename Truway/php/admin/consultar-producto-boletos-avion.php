<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Consulta inicial para obtener todos los boletos de avión
$query = "SELECT * FROM pasaje";
$filters = [];

// Aplicar filtros si se envían por GET
if (isset($_GET['tipo-pasaje']) && $_GET['tipo-pasaje'] !== '') {
    $filters[] = "tipo_pasaje = '" . mysqli_real_escape_string($conexion, $_GET['tipo-pasaje']) . "'";
}
if (isset($_GET['aereolinea']) && $_GET['aereolinea'] !== '') {
    $filters[] = "aerolinea = '" . mysqli_real_escape_string($conexion, $_GET['aereolinea']) . "'";
}

// Si hay filtros, añadirlos a la consulta
if (!empty($filters)) {
    $query .= " WHERE " . implode(" AND ", $filters);
}

$result = mysqli_query($conexion, $query);

// Obtener valores únicos para los filtros
$tipoPasajeQuery = "SELECT DISTINCT tipo_pasaje FROM pasaje ORDER BY tipo_pasaje ASC";
$tipoPasajeResult = mysqli_query($conexion, $tipoPasajeQuery);

$aerolineaQuery = "SELECT DISTINCT aerolinea FROM pasaje ORDER BY aerolinea ASC";
$aerolineaResult = mysqli_query($conexion, $aerolineaQuery);
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; ?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-productos-boletos-avion.css">
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
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-alquiler-autos.php" class="tabla">Alquiler vehiculos</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-estadias.php" class="tabla">Estadías</a>
        <a href="/Olimpiadas/Truway/php/admin/consultar-producto-boletos-avion.php" class="tabla seleccionado">Boletos de avión</a>
    </div>

    <div class="cont-filtros">
        <form method="get" action="" class="form-filtros">
            <div class="filtros">
                <select class="select-filtro" name="tipo-pasaje">
                    <option value="" disabled selected>Seleccione un tipo de boleto</option>
                    <?php while ($tipoPasajeRow = mysqli_fetch_assoc($tipoPasajeResult)) { ?>
                        <option value="<?= $tipoPasajeRow['tipo_pasaje'] ?>"><?= $tipoPasajeRow['tipo_pasaje'] ?></option>
                    <?php } ?>
                </select>

                <select class="select-filtro" name="aereolinea">
                    <option value="" disabled selected>Seleccione una aerolínea</option>
                    <?php while ($aerolineaRow = mysqli_fetch_assoc($aerolineaResult)) { ?>
                        <option value="<?= $aerolineaRow['aerolinea'] ?>"><?= $aerolineaRow['aerolinea'] ?></option>
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
                    <span class="lbl-informacion">ID PASAJE</span>
                    <span class="lbl-informacion">ID PRODUCTO</span>
                    <span class="lbl-informacion">ORIGEN</span>
                    <span class="lbl-informacion">DESTINO</span>
                    <span class="lbl-informacion">AEROLÍNEA</span>
                    <span class="lbl-informacion">TIPO PASAJE</span>
                </div>
            </div>
        </article>

        <!-- Boletos dinámicos -->
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <article class="producto">
                <div class="informacion-principal">
                    <div class="informacion">
                        <span class="lbl-informacion"><?= $row['id_pasaje'] ?></span>
                        <span class="lbl-informacion"><?= $row['id_producto'] ?></span>
                        <span class="lbl-informacion"><?= $row['origen'] ?></span>
                        <span class="lbl-informacion"><?= $row['destino'] ?></span>
                        <span class="lbl-informacion"><?= $row['aerolinea'] ?></span>
                        <span class="lbl-informacion"><?= $row['tipo_pasaje'] ?></span>
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
            </article>
        <?php } ?>
    </section>
</main>
</body>
</html>