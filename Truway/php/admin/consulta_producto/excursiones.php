<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { // solo administradores pueden acceder
    header('Location: /Olimpiadas/Truway/php/cliente/perfil.php');
    exit();
}
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $id_producto = intval($_POST['eliminar_id']);
    mysqli_query($conexion, "DELETE FROM excursiones WHERE id_producto = $id_producto");
    mysqli_query($conexion, "DELETE FROM productos WHERE id_producto = $id_producto");
}

$tabla_seleccionada = 'excursiones';

// Filtros
$where = [];
if (!empty($_GET['dificultad'])) {
    $dificultad = mysqli_real_escape_string($conexion, $_GET['dificultad']);
    $where[] = "e.dificultad = '$dificultad'";
}
if (!empty($_GET['buscar'])) {
    $buscar = mysqli_real_escape_string($conexion, $_GET['buscar']);
    $where[] = "(e.ubicacion_salida LIKE '%$buscar%' OR e.duracion LIKE '%$buscar%' OR e.dificultad LIKE '%$buscar%')";
}
$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT e.*, p.descripcion
        FROM excursiones e
        JOIN productos p ON e.id_producto = p.id_producto
        $whereSQL
        ORDER BY e.id_excursion DESC";
$result = mysqli_query($conexion, $sql);
?>

<div class="cont-filtros">
    <form method="get" action="" class="form-filtros">
        <input type="hidden" name="tabla_seleccionada" value="<?= htmlspecialchars($tabla_seleccionada) ?>">
        <div class="filtros">
            <select class="select-filtro" name="dificultad">
                <option value="" <?= !isset($_GET['dificultad']) || $_GET['dificultad'] === '' ? 'selected' : '' ?>>Seleccione una dificultad</option>
                <option value="baja" <?= (isset($_GET['dificultad']) && $_GET['dificultad'] == 'baja') ? 'selected' : '' ?>>Baja</option>
                <option value="media" <?= (isset($_GET['dificultad']) && $_GET['dificultad'] == 'media') ? 'selected' : '' ?>>Media</option>
                <option value="alta" <?= (isset($_GET['dificultad']) && $_GET['dificultad'] == 'alta') ? 'selected' : '' ?>>Alta</option>
            </select>
            <div class="barra-buscar">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0s.41-1.08 0-1.49zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14"/></svg>
                <input type="search" name="buscar" class="input-buscar" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
            </div>
        </div>
        <button class="btn-filtrar" name="filtrar" type="submit">Filtrar</button>
    </form>
</div>

<section class="section-tabla-productos excursiones">
    <article class="producto guia">
        <div class="informacion-principal">
            <div class="informacion">
                <span class="lbl-informacion">ID EXCURSION</span>
                <span class="lbl-informacion">ID PRODUCTO</span>
                <span class="lbl-informacion">UBICACIÓN SALIDA</span>
                <span class="lbl-informacion">DURACIÓN</span>
                <span class="lbl-informacion">GUÍA</span>
                <span class="lbl-informacion">DIFICULTAD</span>
                <span class="lbl-informacion">ACCIONES</span>
            </div>
        </div>
    </article>

    <?php while ($dato = mysqli_fetch_assoc($result)) { ?>
        <article class="producto">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion"><?= $dato['id_excursion'] ?></span>
                    <span class="lbl-informacion"><?= $dato['id_producto'] ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['ubicacion_salida']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['duracion']) ?></span>
                    <span class="lbl-informacion"><?= $dato['guia'] ? 'Sí' : 'No' ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['dificultad']) ?></span>
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
                    <span class="lbl-informacion" colspan="7">No se encontraron resultados.</span>
                </div>
            </div>
        </article>
    <?php } ?>
</section>