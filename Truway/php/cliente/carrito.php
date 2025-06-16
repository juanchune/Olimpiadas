<?php
session_start();
?><link rel="stylesheet" href="/Olimpiadas/Truway/css/carrito.css"><?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Obtener el carrito del usuario
$id_usuario = $_SESSION['id'];
$consulta_carrito = "SELECT * FROM carrito WHERE id_usuario = '$id_usuario'";
$resultado_carrito = mysqli_query($conexion, $consulta_carrito);
$carrito = mysqli_fetch_assoc($resultado_carrito);

if (!$carrito) {
    ?>
    <main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
    echo "<p>No hay productos en el carrito.</p>"; ?>
    <?php
    exit();
}

// Obtener los productos del carrito
$id_carrito = $carrito['id_carrito'];
$consulta_detalle = "SELECT dc.*, p.nombre, p.descripcion, p.precio, p.tipo_producto
    FROM detalle_carrito dc
    JOIN productos p ON dc.id_producto = p.id_producto
    WHERE dc.id_carrito = '$id_carrito'";
$resultado_detalle = mysqli_query($conexion, $consulta_detalle);

$productos = [];
$cantidad_paquetes = 0;
$subtotal = 0;
$precio_final = 0;

while ($fila = mysqli_fetch_assoc($resultado_detalle)) {
    $productos[] = $fila;
    $cantidad_paquetes += $fila['cantidad'];
    $subtotal += $fila['precio_carrito'] * $fila['cantidad'];
}
$precio_final = $subtotal;

// Vaciar carrito
function vaciar_carrito($conexion, $id_carrito) {
    $consulta = "DELETE FROM detalle_carrito WHERE id_carrito = '$id_carrito'";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado) {
        die("Error al vaciar el carrito: " . mysqli_error($conexion));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vaciar_carrito'])) {
    vaciar_carrito($conexion, $id_carrito);
    header('Location: carrito.php');
    exit();
}
?>
<main>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
  <section class="section-carrito">
    <div class="grid-productos">
      <h2 class="subtitulo">Mis reservas</h2>
      <?php foreach ($productos as $producto): ?>
      <article class="producto">
        <div class="cont-superior">
          <div class="cont-tag">
            <div class="tag">
              <!-- Icono -->
              <span class="nombre-tag"><?php echo htmlspecialchars($producto['tipo_producto']); ?></span>
            </div>
          </div>
          <div class="cont-grid-titulo-btns">
            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
            <div class="cont-btns">
              <a class="btn modificar" href="/Olimpiadas/truway/php/general/producto-especifico.php?id_producto=<?php echo $producto['id_producto']; ?>">
                Modificar
              </a>
              <!-- Aquí podrías agregar funcionalidad para eliminar un producto específico -->
            </div>
          </div>
        </div>
        <div class="cont-inferior">
          <div class="cont-datos-especificos">
            <div class="cont-lbls">
              <span class="lbl-nombre">Cantidad:</span>
            </div>
            <div class="cont-informacion">
              <span class="informacion personas"><?php echo $producto['cantidad']; ?></span>
            </div>
          </div>
          <div class="cont-importe">
            <span class="importe">$<?php echo number_format($producto['precio_carrito'], 2, ',', '.'); ?></span>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="pre-factura">
      <h2 class="subtitulo">Resumen de pedido</h2>
      <article class="resumen-pedido">
        <div class="cont-precios-generales">
          <div class="cont-precios">
            <div class="cont-resumen">
              <span class="lbl">Productos</span>
              <span class="lbl-informacion cant-paquetes"><?php echo $cantidad_paquetes; ?></span>
            </div>
            <div class="cont-resumen">
              <span class="lbl">Subtotal:</span>
              <span class="lbl-informacion sub-1">$<?php echo number_format($subtotal, 2, ',', '.'); ?></span>
            </div>
          </div>
          <div class="cont-total-pagar">
            <span class="lbl">Total:</span>
            <span class="lbl-informacion sub-1">$<?php echo number_format($precio_final, 2, ',', '.'); ?></span>
          </div>
        </div>
        <form method="post" class="cont-btns">
          <a class="btn siguiente" href="/Olimpiadas/Truway/php/cliente/facturacion.php">Siguiente</a>
          <button class="btn borrar" name="vaciar_carrito" type="submit">Vaciar carrito</button>
        </form>
      </article>
    </div>
  </section>
</main>