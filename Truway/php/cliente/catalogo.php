<?php
    session_start();
    include("conexion.php");

    // Función para obtener productos al azar
    function obtenerProductos($tabla, $campos, $limite = 5) {
        global $conexion; // Usar la conexión global definida en conexion.php
        $sql = "SELECT $campos FROM $tabla ORDER BY RAND() LIMIT $limite";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener 5 productos al azar de cada tipo
    $paquetes = obtenerProductos("paquetes p JOIN productos pr ON p.id_producto = pr.id_producto", "pr.nombre, pr.descripcion, pr.precio");
    $excursiones = obtenerProductos("excursiones e JOIN productos pr ON e.id_producto = pr.id_producto", "pr.nombre, pr.descripcion, pr.precio");
    $pasajes = obtenerProductos("pasaje pa JOIN productos pr ON pa.id_producto = pr.id_producto", "pr.nombre, pr.descripcion, pr.precio");
    $vehiculos = obtenerProductos("vehiculo v JOIN productos pr ON v.id_producto = pr.id_producto", "pr.nombre, pr.descripcion, pr.precio");
    $estadias = obtenerProductos("estadia es JOIN productos pr ON es.id_producto = pr.id_producto", "pr.nombre, pr.descripcion, pr.precio");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .categoria { margin-bottom: 40px; }
        .producto { margin-bottom: 10px; }
        h2 { color: #333; }
        .mostrar-todas { margin-top: 10px; display: inline-block; padding: 5px 10px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px; }
        .mostrar-todas:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Catálogo de Productos</h1>

    <div class="categoria">
        <h2>Paquetes de Viaje</h2>
        <?php foreach ($paquetes as $paquete): ?>
            <div class="producto">
                <strong><?= htmlspecialchars($paquete['nombre']) ?></strong><br>
                <?= htmlspecialchars($paquete['descripcion']) ?><br>
                Precio: $<?= number_format($paquete['precio'], 2) ?>
            </div>
        <?php endforeach; ?>
        <a href="paquetes.php" class="mostrar-todas">Mostrar todas</a>
    </div>

    <div class="categoria">
        <h2>Excursiones</h2>
        <?php foreach ($excursiones as $excursion): ?>
            <div class="producto">
                <strong><?= htmlspecialchars($excursion['nombre']) ?></strong><br>
                <?= htmlspecialchars($excursion['descripcion']) ?><br>
                Precio: $<?= number_format($excursion['precio'], 2) ?>
            </div>
        <?php endforeach; ?>
        <a href="excursiones.php" class="mostrar-todas">Mostrar todas</a>
    </div>

    <div class="categoria">
        <h2>Pasajes</h2>
        <?php foreach ($pasajes as $pasaje): ?>
            <div class="producto">
                <strong><?= htmlspecialchars($pasaje['nombre']) ?></strong><br>
                <?= htmlspecialchars($pasaje['descripcion']) ?><br>
                Precio: $<?= number_format($pasaje['precio'], 2) ?>
            </div>
        <?php endforeach; ?>
        <a href="pasajes.php" class="mostrar-todas">Mostrar todas</a>
    </div>

    <div class="categoria">
        <h2>Alquiler de Vehículos</h2>
        <?php foreach ($vehiculos as $vehiculo): ?>
            <div class="producto">
                <strong><?= htmlspecialchars($vehiculo['nombre']) ?></strong><br>
                <?= htmlspecialchars($vehiculo['descripcion']) ?><br>
                Precio: $<?= number_format($vehiculo['precio'], 2) ?>
            </div>
        <?php endforeach; ?>
        <a href="vehiculos.php" class="mostrar-todas">Mostrar todas</a>
    </div>

    <div class="categoria">
        <h2>Estadías</h2>
        <?php foreach ($estadias as $estadia): ?>
            <div class="producto">
                <strong><?= htmlspecialchars($estadia['nombre']) ?></strong><br>
                <?= htmlspecialchars($estadia['descripcion']) ?><br>
                Precio: $<?= number_format($estadia['precio'], 2) ?>
            </div>
        <?php endforeach; ?>
        <a href="estadias.php" class="mostrar-todas">Mostrar todas</a>
    </div>
</body>
</html>