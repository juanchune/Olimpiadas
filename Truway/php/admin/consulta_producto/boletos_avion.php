<?php
include('conexion.php');

// Eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $id_producto = intval($_POST['eliminar_id']);
    mysqli_query($conexion, "DELETE FROM pasajes WHERE id_producto = $id_producto");
    mysqli_query($conexion, "DELETE FROM productos WHERE id_producto = $id_producto");
}

// Variables para filtros
$tabla_seleccionada = 'boletos_avion';
$tipoPasajeResult = mysqli_query($conexion, "SELECT DISTINCT tipo_pasaje FROM pasajes ORDER BY tipo_pasaje");
$aerolineaResult = mysqli_query($conexion, "SELECT DISTINCT aerolinea FROM pasajes ORDER BY aerolinea");

// Filtros
$where = [];
if (!empty($_GET['tipo-pasaje'])) {
    $tipo_pasaje = mysqli_real_escape_string($conexion, $_GET['tipo-pasaje']);
    $where[] = "p.tipo_pasaje = '$tipo_pasaje'";
}
if (!empty($_GET['aereolinea'])) {
    $aerolinea = mysqli_real_escape_string($conexion, $_GET['aereolinea']);
    $where[] = "p.aerolinea = '$aerolinea'";
}
if (!empty($_GET['buscar'])) {
    $buscar = mysqli_real_escape_string($conexion, $_GET['buscar']);
    $where[] = "(p.origen LIKE '%$buscar%' OR p.destino LIKE '%$buscar%')";
}
$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT p.*, pr.descripcion 
        FROM pasajes p
        JOIN productos pr ON p.id_producto = pr.id_producto
        $whereSQL
        ORDER BY p.id_pasaje DESC";
$result = mysqli_query($conexion, $sql);
?>
<div class="cont-filtros">
    <form method="get" action="" class="form-filtros">
        <input type="hidden" name="tabla_seleccionada" value="<?= htmlspecialchars($tabla_seleccionada) ?>">
        <div class="filtros">
            <select class="select-filtro" name="tipo-pasaje">
                <option value="" <?= !isset($_GET['tipo-pasaje']) || $_GET['tipo-pasaje'] === '' ? 'selected' : '' ?>>Seleccione un tipo de boleto</option>
                <?php mysqli_data_seek($tipoPasajeResult, 0); while ($tipoPasajeRow = mysqli_fetch_assoc($tipoPasajeResult)) { ?>
                    <option value="<?= $tipoPasajeRow['tipo_pasaje'] ?>" <?= (isset($_GET['tipo-pasaje']) && $_GET['tipo-pasaje'] == $tipoPasajeRow['tipo_pasaje']) ? 'selected' : '' ?>>
                        <?= $tipoPasajeRow['tipo_pasaje'] ?>
                    </option>
                <?php } ?>
            </select>
            <select class="select-filtro" name="aereolinea">
                <option value="" <?= !isset($_GET['aereolinea']) || $_GET['aereolinea'] === '' ? 'selected' : '' ?>>Seleccione una aerolínea</option>
                <?php mysqli_data_seek($aerolineaResult, 0); while ($aerolineaRow = mysqli_fetch_assoc($aerolineaResult)) { ?>
                    <option value="<?= $aerolineaRow['aerolinea'] ?>" <?= (isset($_GET['aereolinea']) && $_GET['aereolinea'] == $aerolineaRow['aerolinea']) ? 'selected' : '' ?>>
                        <?= $aerolineaRow['aerolinea'] ?>
                    </option>
                <?php } ?>
            </select>
            <div class="barra-buscar">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0s.41-1.08 0-1.49zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14"/></svg>
                <input type="search" name="buscar" class="input-buscar" placeholder="Buscar por origen o destino" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
            </div>
        </div>
        <button class="btn-filtrar" name="filtrar" type="submit">Filtrar</button>
    </form>
</div>

<section class="section-tabla-productos boletos-avion">
    <article class="producto guia">
        <div class="informacion-principal">
            <div class="informacion">
                <span class="lbl-informacion">ID PASAJE</span>
                <span class="lbl-informacion">ID PRODUCTO</span>
                <span class="lbl-informacion">ORIGEN</span>
                <span class="lbl-informacion">DESTINO</span>
                <span class="lbl-informacion">AEROLÍNEA</span>
                <span class="lbl-informacion">TIPO PASAJE</span>
                <span class="lbl-informacion">ACCIONES</span>
            </div>
        </div>
    </article>

    <?php while ($dato = mysqli_fetch_assoc($result)) { ?>
        <article class="producto">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion"><?= $dato['id_pasaje'] ?></span>
                    <span class="lbl-informacion"><?= $dato['id_producto'] ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['origen']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['destino']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['aerolinea']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['tipo_pasaje']) ?></span>
                    <div class="btns">
                        <button class="btn modificar">
                            <a href="editar-producto.php?id=<?= $dato['id_producto'] ?>" class="btn-modificar" title="Editar">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path stroke="currentColor" class="icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0z" />
                                    <path class="icon" fill="currentColor" d="m5 16l-1 4l4-1L18 9l-3-3z" />
                                    <path class="icon" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m15 6l3 3m-5 11h8" />
                                </g>
                            </svg>
                            </a>
                        </button>
                        <form method="post" style="display:inline;" onsubmit="return confirm('¿Seguro que desea eliminar este producto?');">
                            <input type="hidden" name="eliminar_id" value="<?= $dato['id_producto'] ?>">
                            <button type="submit" class="btn-eliminar" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path class="icon" fill="currentColor"
                                        d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zm3-4q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    <?php }
    if (mysqli_num_rows($result) === 0) { ?>
        <article class="producto">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion">No se encontraron resultados.</span>
                </div>
            </div>
        </article>
    <?php } ?>
</section>