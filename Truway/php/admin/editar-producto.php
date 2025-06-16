<?php

include('conexion.php');
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;
} else {
    $id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;
}
if ($id_producto <= 0) {
    echo "<p>ID de producto inválido.</p>";
    exit;
}

// Obtener datos del producto
$sql = "SELECT * FROM productos WHERE id_producto = $id_producto";
$res = mysqli_query($conexion, $sql);
$producto = mysqli_fetch_assoc($res);

if (!$producto) {
    echo "<p>Producto no encontrado.</p>";
    exit;
}

$tipo_producto = strtolower($producto['tipo_producto']);
$msg = "";

// Obtener tipos de producto para el select
$tipos = [];
$resTipos = mysqli_query($conexion, "SELECT DISTINCT tipo_producto FROM productos WHERE tipo_producto IS NOT NULL ORDER BY tipo_producto");
while ($row = mysqli_fetch_assoc($resTipos)) {
    $tipos[] = $row['tipo_producto'];
}

// Si es paquete obtener productos
$productos_incluidos = [];
$productos_disponibles = [];
if ($tipo_producto === 'paquete') {
    $respaq = mysqli_query($conexion, "SELECT id_paquete FROM paquetes WHERE id_producto = $id_producto");
    $paq = mysqli_fetch_assoc($respaq);
    $id_paquete = $paq['id_paquete'];
    $resIncluidos = mysqli_query($conexion, "SELECT id_producto FROM detalle_paquete WHERE id_paquete = $id_paquete");
    while ($row = mysqli_fetch_assoc($resIncluidos)) {
        $productos_incluidos[] = $row['id_producto'];
    }
    // Todos los productos
    $resTodos = mysqli_query($conexion, "SELECT id_producto, nombre, tipo_producto FROM productos WHERE tipo_producto != 'paquete' AND id_producto != $id_producto");
    while ($row = mysqli_fetch_assoc($resTodos)) {
        $productos_disponibles[] = $row;
    }
}

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $tipo_producto_post = mysqli_real_escape_string($conexion, $_POST['tipo_producto']);

    $update = "UPDATE productos SET 
        nombre = '$nombre',
        descripcion = '$descripcion',
        precio = $precio,
        tipo_producto = '$tipo_producto_post'
        WHERE id_producto = $id_producto";
    mysqli_query($conexion, $update);

    // Guardar datos especificos 
    if ($tipo_producto === 'excursion' || $tipo_producto === 'excursión') { //Excursion
        $ubicacion = mysqli_real_escape_string($conexion, $_POST['ubicacion_salida']);
        $duracion = intval($_POST['duracion']);
        $guia = isset($_POST['guia']) ? 1 : 0;
        $dificultad = mysqli_real_escape_string($conexion, $_POST['dificultad']);
        mysqli_query($conexion, "UPDATE excursiones SET ubicacion_salida='$ubicacion', duracion=$duracion, guia=$guia, dificultad='$dificultad' WHERE id_producto=$id_producto");
    }
    if ($tipo_producto === 'estadia' || $tipo_producto === 'estadía') { // Estadia
        $localidad = mysqli_real_escape_string($conexion, $_POST['localidad']);
        $nombre_hotel = mysqli_real_escape_string($conexion, $_POST['nombre_hotel']);
        $servicios = mysqli_real_escape_string($conexion, $_POST['servicios']);
        $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
        mysqli_query($conexion, "UPDATE estadias SET localidad='$localidad', nombre_hotel='$nombre_hotel', servicios='$servicios', categoria='$categoria' WHERE id_producto=$id_producto");
    }
    if ($tipo_producto === 'pasaje') { // Pasaje
        $origen = mysqli_real_escape_string($conexion, $_POST['origen']);
        $destino = mysqli_real_escape_string($conexion, $_POST['destino']);
        $aerolinea = mysqli_real_escape_string($conexion, $_POST['aerolinea']);
        $tipo_pasaje = mysqli_real_escape_string($conexion, $_POST['tipo_pasaje']);
        mysqli_query($conexion, "UPDATE pasajes SET origen='$origen', destino='$destino', aerolinea='$aerolinea', tipo_pasaje='$tipo_pasaje' WHERE id_producto=$id_producto");
    }
    if ($tipo_producto === 'vehiculo' || $tipo_producto === 'vehículo' || $tipo_producto === 'alquiler de vehículo') { // Vehiculo
        $marca = mysqli_real_escape_string($conexion, $_POST['marca']);
        $modelo = mysqli_real_escape_string($conexion, $_POST['modelo']);
        $capacidad = intval($_POST['capacidad']);
        $empresa = mysqli_real_escape_string($conexion, $_POST['empresa_rentadora']);
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
        mysqli_query($conexion, "UPDATE vehiculos SET marca='$marca', modelo='$modelo', capacidad=$capacidad, empresa_rentadora='$empresa', tipo='$tipo' WHERE id_producto=$id_producto");
    }
    if ($tipo_producto === 'paquete') { // Paquete
        $respaq = mysqli_query($conexion, "SELECT id_paquete FROM paquetes WHERE id_producto = $id_producto");
        $paq = mysqli_fetch_assoc($respaq);
        $id_paquete = $paq['id_paquete'];
        mysqli_query($conexion, "DELETE FROM detalle_paquete WHERE id_paquete = $id_paquete");
        $ids = [];
        if (!empty($_POST['excursion'])) $ids[] = intval($_POST['excursion']);
        if (!empty($_POST['pasaje'])) $ids[] = intval($_POST['pasaje']);
        if (!empty($_POST['estadia'])) $ids[] = intval($_POST['estadia']);
        if (!empty($_POST['vehiculo'])) $ids[] = intval($_POST['vehiculo']);
        foreach ($ids as $id_prod) {
            mysqli_query($conexion, "INSERT INTO detalle_paquete (id_paquete, id_producto) VALUES ($id_paquete, $id_prod)");
        }
    }

    // Redirigir a la lista
    if ($tipo_producto === 'paquete') {
        header("Location: paquetes.php");
    } elseif ($tipo_producto === 'excursion' || $tipo_producto === 'excursión') {
        header("Location: excursiones.php");
    } elseif ($tipo_producto === 'estadia' || $tipo_producto === 'estadía') {
        header("Location: estadias.php");
    } elseif ($tipo_producto === 'pasaje') {
        header("Location: boletos_avion.php");
    } elseif ($tipo_producto === 'vehiculo' || $tipo_producto === 'vehículo' || $tipo_producto === 'alquiler de vehículo') {
        header("Location: vehiculos.php");
    } else {
        header("Location: productos.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/editar-producto.css">
</head>
<body>
    <main>
        <h2>Editar <?= ucfirst($tipo_producto) ?></h2>
        <?php if ($msg) { echo "<p>$msg</p>"; } ?>
        <form method="post" class="form-editar-producto">
            <input type="hidden" name="id_producto" value="<?= $id_producto ?>">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" step="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required>
            </div>
            <div style="display:none;">
                <label for="tipo_producto">Tipo de producto:</label>
                <select name="tipo_producto" id="tipo_producto" required>
                    <?php foreach ($tipos as $tipo) { ?>
                        <option value="<?= htmlspecialchars($tipo) ?>" <?= ($producto['tipo_producto'] == $tipo) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <?php if ($tipo_producto === 'excursion' || $tipo_producto === 'excursión'):
                $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM excursiones WHERE id_producto = $id_producto"));
            ?>
            <div class="grupo-campos">
                <h3>Datos de la excursión</h3>
                <label>Ubicación salida: <input type="text" name="ubicacion_salida" value="<?= htmlspecialchars($info['ubicacion_salida']) ?>" required></label>
                <label>Duración (horas): <input type="number" name="duracion" value="<?= htmlspecialchars($info['duracion']) ?>" required></label>
                <label>Guía: <input type="checkbox" name="guia" value="1" <?= $info['guia'] ? 'checked' : '' ?>></label>
                <label>Dificultad:
                    <select name="dificultad" required>
                        <option value="baja" <?= $info['dificultad']=='baja'?'selected':'' ?>>Baja</option>
                        <option value="media" <?= $info['dificultad']=='media'?'selected':'' ?>>Media</option>
                        <option value="alta" <?= $info['dificultad']=='alta'?'selected':'' ?>>Alta</option>
                    </select>
                </label>
            </div>
            <?php elseif ($tipo_producto === 'estadia' || $tipo_producto === 'estadía'):
                $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM estadias WHERE id_producto = $id_producto"));
            ?>
            <div class="grupo-campos">
                <h3>Datos de la estadía</h3>
                <label>Localidad: <input type="text" name="localidad" value="<?= htmlspecialchars($info['localidad']) ?>" required></label>
                <label>Nombre hotel: <input type="text" name="nombre_hotel" value="<?= htmlspecialchars($info['nombre_hotel']) ?>" required></label>
                <label>Servicios: <input type="text" name="servicios" value="<?= htmlspecialchars($info['servicios']) ?>" required></label>
                <label>Categoría:
                    <select name="categoria" required>
                        <option value="1" <?= $info['categoria']=='1'?'selected':'' ?>>1</option>
                        <option value="2" <?= $info['categoria']=='2'?'selected':'' ?>>2</option>
                        <option value="3" <?= $info['categoria']=='3'?'selected':'' ?>>3</option>
                        <option value="4" <?= $info['categoria']=='4'?'selected':'' ?>>4</option>
                        <option value="5" <?= $info['categoria']=='5'?'selected':'' ?>>5</option>
                    </select>
                </label>
            </div>
            <?php elseif ($tipo_producto === 'pasaje'):
                $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM pasajes WHERE id_producto = $id_producto"));
            ?>
            <div class="grupo-campos">
                <h3>Datos del pasaje</h3>
                <label>Origen: <input type="text" name="origen" value="<?= htmlspecialchars($info['origen']) ?>" required></label>
                <label>Destino: <input type="text" name="destino" value="<?= htmlspecialchars($info['destino']) ?>" required></label>
                <label>Aerolínea: <input type="text" name="aerolinea" value="<?= htmlspecialchars($info['aerolinea']) ?>" required></label>
                <label>Tipo pasaje:
                    <select name="tipo_pasaje" required>
                        <option value="solo_ida" <?= $info['tipo_pasaje']=='solo_ida'?'selected':'' ?>>Solo ida</option>
                        <option value="ida_y_vuelta" <?= $info['tipo_pasaje']=='ida_y_vuelta'?'selected':'' ?>>Ida y vuelta</option>
                    </select>
                </label>
            </div>
            <?php elseif ($tipo_producto === 'vehiculo' || $tipo_producto === 'vehículo' || $tipo_producto === 'alquiler de vehículo'):
                $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM vehiculos WHERE id_producto = $id_producto"));
            ?>
            <div class="grupo-campos">
                <h3>Datos del vehículo</h3>
                <label>Marca: <input type="text" name="marca" value="<?= htmlspecialchars($info['marca']) ?>" required></label>
                <label>Modelo: <input type="text" name="modelo" value="<?= htmlspecialchars($info['modelo']) ?>" required></label>
                <label>Capacidad: <input type="number" name="capacidad" value="<?= htmlspecialchars($info['capacidad']) ?>" required></label>
                <label>Empresa rentadora: <input type="text" name="empresa_rentadora" value="<?= htmlspecialchars($info['empresa_rentadora']) ?>" required></label>
                <label>Tipo: <input type="text" name="tipo" value="<?= htmlspecialchars($info['tipo']) ?>" required></label>
            </div>
            <?php elseif ($tipo_producto === 'paquete'):
                // Obtener productos disponibles por tipo
                $excursiones = [];
                $pasajes = [];
                $estadias = [];
                $vehiculos = [];
                foreach ($productos_disponibles as $prod) {
                    $tipo = strtolower($prod['tipo_producto']);
                    if ($tipo === 'excursion' || $tipo === 'excursión') $excursiones[] = $prod;
                    if ($tipo === 'pasaje') $pasajes[] = $prod;
                    if ($tipo === 'estadia' || $tipo === 'estadía') $estadias[] = $prod;
                    if ($tipo === 'vehiculo' || $tipo === 'vehículo' || $tipo === 'alquiler de vehículo') $vehiculos[] = $prod;
                }
                // Buscar los productos ya incluidos
                $id_excursion = $id_pasaje = $id_estadia = $id_vehiculo = '';
                foreach ($productos_incluidos as $id_prod) {
                    $tipo = '';
                    foreach ($productos_disponibles as $prod) {
                        if ($prod['id_producto'] == $id_prod) {
                            $tipo = strtolower($prod['tipo_producto']);
                            break;
                        }
                    }
                    if ($tipo === 'excursion' || $tipo === 'excursión') $id_excursion = $id_prod;
                    if ($tipo === 'pasaje') $id_pasaje = $id_prod;
                    if ($tipo === 'estadia' || $tipo === 'estadía') $id_estadia = $id_prod;
                    if ($tipo === 'vehiculo' || $tipo === 'vehículo' || $tipo === 'alquiler de vehículo') $id_vehiculo = $id_prod;
                }
            ?>
            <div class="grupo-campos">
                <h3>Productos incluidos en el paquete</h3>
                <label>Excursión (obligatoria):</label>
                <select name="excursion" required>
                    <option value="">Seleccione una excursión</option>
                    <?php foreach ($excursiones as $prod) { ?>
                        <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_excursion) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prod['nombre']) ?>
                        </option>
                    <?php } ?>
                </select>
                <br><br>
                <label>Pasaje (opcional):</label>
                <select name="pasaje">
                    <option value="">Sin pasaje</option>
                    <?php foreach ($pasajes as $prod) { ?>
                        <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_pasaje) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prod['nombre']) ?>
                        </option>
                    <?php } ?>
                </select>
                <br><br>
                <label>Estadía (opcional):</label>
                <select name="estadia">
                    <option value="">Sin estadía</option>
                    <?php foreach ($estadias as $prod) { ?>
                        <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_estadia) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prod['nombre']) ?>
                        </option>
                    <?php } ?>
                </select>
                <br><br>
                <label>Alquiler de vehículo (opcional):</label>
                <select name="vehiculo">
                    <option value="">Sin vehículo</option>
                    <?php foreach ($vehiculos as $prod) { ?>
                        <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_vehiculo) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prod['nombre']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <?php endif; ?>

            <button type="submit">Guardar cambios</button>
            <a href="javascript:history.back()" class="btn-volver">Volver</a>
        </form>
    </main>
</body>
</html>