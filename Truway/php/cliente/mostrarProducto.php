<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Verificar si se ha proporcionado un ID de producto
if (!isset($_GET['id_producto'])) {
    echo "No se ha proporcionado un ID de producto.";
    exit;
}

$id_producto = intval($_GET['id_producto']);

// Consultar los detalles del producto
$query = "SELECT p.nombre, p.descripcion, p.precio, tp.tipo 
          FROM productos p 
          INNER JOIN tipo_producto tp ON p.tipo_producto = tp.id_tipo 
          WHERE p.id_producto = $id_producto";
$resultado = mysqli_query($conexion, $query);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = mysqli_fetch_assoc($resultado);
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/producto.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; ?>
    <section class="producto-detalle">
        <h2 class="titulo"><?php echo htmlspecialchars($producto['nombre']); ?></h2>
        <p class="descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
        <p class="tipo">Tipo: <?php echo htmlspecialchars($producto['tipo']); ?></p>
        <p class="precio">Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
        <form method="post" action="carrito.php">
            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
            <button type="submit" class="btn-agregar">Agregar al carrito</button>
        </form>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>