<?php

include ('conexion.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $id_producto = intval($_POST['eliminar_id']);
    // Primero elimina de la tabla específica
    mysqli_query($conexion, "DELETE FROM vehiculos WHERE id_producto = $id_producto");
    // Luego elimina de productos
    mysqli_query($conexion, "DELETE FROM productos WHERE id_producto = $id_producto");
}

$tabla_seleccionada = 'vehiculos';


$capacidadResult = mysqli_query($conexion, "SELECT DISTINCT capacidad FROM vehiculos ORDER BY capacidad");
$tipoResult = mysqli_query($conexion, "SELECT DISTINCT tipo FROM vehiculos ORDER BY tipo");

// Filtros
$where = [];
if (!empty($_GET['capacidad'])) {
    $capacidad = intval($_GET['capacidad']);
    $where[] = "v.capacidad = $capacidad";
}
if (!empty($_GET['tipo'])) {
    $tipo = mysqli_real_escape_string($conexion, $_GET['tipo']);
    $where[] = "v.tipo = '$tipo'";
}
$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';


$sql = "SELECT v.*, p.descripcion 
        FROM vehiculos v
        JOIN productos p ON v.id_producto = p.id_producto
        $whereSQL
        ORDER BY v.id_vehiculo DESC";
$result = mysqli_query($conexion, $sql);
?>

<div class="cont-filtros">
    <form method="get" action="" class="form-filtros">
        <input type="hidden" name="tabla_seleccionada" value="<?= htmlspecialchars($tabla_seleccionada) ?>">
        <div class="filtros">
            <select class="select-filtro" name="capacidad">
                <option value="" disabled selected>Seleccione una capacidad</option>
                <?php while ($capacidadRow = mysqli_fetch_assoc($capacidadResult)) { ?>
                    <option value="<?= $capacidadRow['capacidad'] ?>" <?= (isset($_GET['capacidad']) && $_GET['capacidad'] == $capacidadRow['capacidad']) ? 'selected' : '' ?>>
                        <?= $capacidadRow['capacidad'] ?>
                    </option>
                <?php } ?>
            </select>
            <select class="select-filtro" name="tipo">
                <option value="" disabled selected>Seleccione un tipo</option>
                <?php while ($tipoRow = mysqli_fetch_assoc($tipoResult)) { ?>
                    <option value="<?= $tipoRow['tipo'] ?>" <?= (isset($_GET['tipo']) && $_GET['tipo'] == $tipoRow['tipo']) ? 'selected' : '' ?>>
                        <?= $tipoRow['tipo'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button class="btn-filtrar" name="filtrar">Filtrar</button>
    </form>
</div>

<section class="section-tabla-productos vehiculos">
    <article class="producto guia">
        <div class="informacion-principal">
            <div class="informacion">
                <span class="lbl-informacion">ID VEHICULO</span>
                <span class="lbl-informacion">ID PRODUCTO</span>
                <span class="lbl-informacion">MARCA</span>
                <span class="lbl-informacion">MODELO</span>
                <span class="lbl-informacion">CAPACIDAD</span>
                <span class="lbl-informacion">EMPRESA RENTADORA</span>
                <span class="lbl-informacion">TIPO</span>
                <span class="lbl-informacion">ACCIONES</span>
            </div>
        </div>
    </article>

    <?php while ($dato = mysqli_fetch_assoc($result)) { ?>
        <article class="producto" data-id="<?= $dato['id_producto'] ?>" data-tipo="vehiculos">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion"><?= $dato['id_vehiculo'] ?></span>
                    <span class="lbl-informacion"><?= $dato['id_producto'] ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['marca']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['modelo']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['capacidad']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['empresa_rentadora']) ?></span>
                    <span class="lbl-informacion"><?= htmlspecialchars($dato['tipo']) ?></span>
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
    <?php } ?>
</section>