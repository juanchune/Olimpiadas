<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') { // solo clientes pueden acceder
        header('Location: /Olimpiadas/Truway/index.php');
    exit();
}
include('conexion.php');
// si no hay id_pedido muestro mensaje y salgo
if (!isset($_GET['id_pedido'])) {
    echo "<p>Pedido no especificado.</p>";
    exit();
}

// guardo el id del pedido
$id_pedido = intval($_GET['id_pedido']);

// traigo los productos del pedido
$consulta_detalle = "SELECT dp.*, p.nombre, p.descripcion, p.precio, p.tipo_producto, dp.fecha
    FROM detalle_pedido dp
    JOIN productos p ON dp.id_producto = p.id_producto
    WHERE dp.id_pedido = '$id_pedido'";
$resultado_detalle = mysqli_query($conexion, $consulta_detalle);

$productos = [];
while ($fila = mysqli_fetch_assoc($resultado_detalle)) {
  $productos[] = $fila;
}

// si se envia el formulario para modificar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_producto'])) {
    $id_detalle_pedido = intval($_POST['id_detalle_pedido']); // obtener id del detalle del pedido
    $nueva_cantidad = max(1, intval($_POST['nueva_cantidad'])); // obtener nueva cantidad
    $nueva_fecha = $_POST['nueva_fecha']; // obtener nueva fecha
    $hoy = date('Y-m-d'); // obtener fecha actual
    if ($nueva_fecha >= $hoy) { // verificar que la nueva fecha no sea anterior a hoy
        $consulta = "UPDATE detalle_pedido SET cantidad = $nueva_cantidad, fecha = '$nueva_fecha' WHERE id_detalle_pedido = $id_detalle_pedido"; // actualizar el detalle del pedido
        mysqli_query($conexion, $consulta);
        header("Location: modificar-pedido.php?id_pedido=$id_pedido");
        exit();
    } else {
        $error_modificar = "La fecha seleccionada no puede ser anterior a hoy.";
    }
}

// si se envia el formulario para eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])) {
    $id_detalle_pedido = intval($_POST['id_detalle_pedido']);
    $consulta = "DELETE FROM detalle_pedido WHERE id_detalle_pedido = $id_detalle_pedido";
    mysqli_query($conexion, $consulta);

    // reviso si ya no quedan productos en el pedido
    $consulta_check = "SELECT COUNT(*) as total FROM detalle_pedido WHERE id_pedido = $id_pedido";
    $res_check = mysqli_query($conexion, $consulta_check);
    $row_check = mysqli_fetch_assoc($res_check);
    if ($row_check['total'] == 0) {
        // borro el pedido de pedidos_pendientes
        $consulta_del_pend = "DELETE FROM pedidos_pendientes WHERE id_pedido = $id_pedido";
        mysqli_query($conexion, $consulta_del_pend);
        // borro el pedido de pedidos
        $consulta_del_ped = "DELETE FROM pedidos WHERE id_pedido = $id_pedido";
        mysqli_query($conexion, $consulta_del_ped);
        // redirijo al perfil o donde quieras
        header("Location: perfil.php");
        exit();
    } else {
        // si quedan productos recargo la pagina
        header("Location: modificar-pedido.php?id_pedido=$id_pedido");
        exit();
    }
}

// si se envia el formulario para confirmar el pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pedido'])) {
    $consulta_detalle = "SELECT cantidad, precio FROM detalle_pedido dp JOIN productos p ON dp.id_producto = p.id_producto WHERE dp.id_pedido = '$id_pedido'";
    $resultado_detalle = mysqli_query($conexion, $consulta_detalle);
    $cantidad_total = 0;
    $precio_total = 0;
    while ($fila = mysqli_fetch_assoc($resultado_detalle)) {
        $cantidad_total += $fila['cantidad'];
        $precio_total += $fila['cantidad'] * $fila['precio'];
    }
    $consulta_update = "UPDATE pedidos SET cantidad = $cantidad_total, precio_total = $precio_total WHERE id_pedido = $id_pedido";
    mysqli_query($conexion, $consulta_update);
    header("Location: perfil.php");
    exit();
}

// calculo los totales para mostrar en el resumen
$cantidad_total = 0;
$subtotal = 0;
$resumen_tipos = [];
foreach ($productos as $fila) {
    $cantidad_total += $fila['cantidad'];
    $subtotal += $fila['precio'] * $fila['cantidad'];
    $tipo = $fila['tipo_producto'];
    if (!isset($resumen_tipos[$tipo])) {
        $resumen_tipos[$tipo] = [
            'cantidad' => 0,
            'subtotal' => 0
        ];
    }
    $resumen_tipos[$tipo]['cantidad'] += $fila['cantidad'];
    $resumen_tipos[$tipo]['subtotal'] += $fila['precio'] * $fila['cantidad'];
}
$precio_final = $subtotal;
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/carrito.css">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php'; ?>
<main>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
  <section class="section-carrito">
    <div class="grid-productos">
      <h2 class="subtitulo">Modificar pedido #<?= $id_pedido ?></h2>
      <?php if (empty($productos)): ?>
        <div class="cont-mensaje">
          <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g fill="none"> <path class="icon" d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path class="icon"  fill="currentColor" d="m13.299 3.148l8.634 14.954a1.5 1.5 0 0 1-1.299 2.25H3.366a1.5 1.5 0 0 1-1.299-2.25l8.634-14.954c.577-1 2.02-1 2.598 0M12 15a1 1 0 1 0 0 2a1 1 0 0 0 0-2m0-7a1 1 0 0 0-.993.883L11 9v4a1 1 0 0 0 1.993.117L13 13V9a1 1 0 0 0-1-1"/></g></svg>
          <p>No hay productos en este pedido.</p>
        </div>
      <?php endif; ?>
      <?php foreach ($productos as $producto): ?>
      <article class="producto">
        <div class="cont-superior">
          <div class="cont-tag">
            <div class="tag">
              <?php 
                include_once($_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/Truway/php/general/tags.php'); FiltrarTags($producto['tipo_producto']);
              ?>
              <span class="nombre-tag"><?php echo htmlspecialchars($producto['tipo_producto']); ?></span>
            </div>
          </div>
          <div class="cont-grid-titulo-btns"> 
            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
            <div class="cont-btns">
              <button class="btn modificar" type="button" data-modificar-id="<?php echo $producto['id_detalle_pedido']; ?>">
                 <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M20.71 7.04c-.34.34-.67.67-.68 1c-.03.32.31.65.63.96c.48.5.95.95.93 1.44s-.53 1-1.04 1.5l-4.13 4.14L15 14.66l4.25-4.24l-.96-.96l-1.42 1.41l-3.75-3.75l3.84-3.83c.39-.39 1.04-.39 1.41 0l2.34 2.34c.39.37.39 1.02 0 1.41M3 17.25l9.56-9.57l3.75 3.75L6.75 21H3z"/></svg>
              </button>
              <form method="post">
                <input type="hidden" name="id_detalle_pedido" value="<?php echo $producto['id_detalle_pedido']; ?>">
                  <button class="btn borrar" name="eliminar_producto" type="submit" title="Eliminar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
              </button>
            </form>
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
            <div class="cont-lbls">
              <span class="lbl-nombre">Fecha:</span>
            </div>
            <div class="cont-informacion">
              <span class="informacion fecha"><?php echo htmlspecialchars($producto['fecha']); ?></span>
            </div>
          </div>
          <div class="cont-importe">
            <span class="importe">$<?php echo number_format($producto['precio'], 2, ',', '.'); ?></span>
          </div>
        </div>
        <form class="form-modificar" id="modificar-<?php echo $producto['id_detalle_pedido']; ?>" method="post" style="display:none;">
          <input type="hidden" name="id_detalle_pedido" value="<?php echo $producto['id_detalle_pedido']; ?>">
          <div class="cont-inputs-modificar">
            <div class="cont-input">
              <label>Cantidad: </label>
              <input class="input-modificar" type="number" name="nueva_cantidad" min="1" value="<?php echo $producto['cantidad']; ?>" required>
            </div>
            <div class="cont-input">
              <label>Fecha: </label>
              <input class="input-modificar" type="date" name="nueva_fecha" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($producto['fecha']); ?>" required>
            </div>
            <button type="submit" name="modificar_producto" class="btn guardar">Guardar</button>
            <button type="button" class="btn cancelar" onclick="document.getElementById('modificar-<?php echo $producto['id_detalle_pedido']; ?>').style.display='none';return false;">Cancelar</button>
          </div>
          <?php if (isset($error_modificar) && isset($_POST['id_detalle_pedido']) && $_POST['id_detalle_pedido'] == $producto['id_detalle_pedido']) echo '<p style="color:red;">' . htmlspecialchars($error_modificar) . '</p>'; ?>
        </form>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="pre-factura">
      <h2 class="subtitulo">Resumen de pedido</h2>
      <article class="resumen-pedido">
        <div class="cont-precios-generales">
          <div class="cont-precios">
            <?php foreach ($resumen_tipos as $tipo => $info): ?>
              <div class="cont-resumen">
                <span class="lbl"><?php echo htmlspecialchars($tipo); ?>:</span>
                <span class="lbl-informacion cant-paquetes"><?php echo $info['cantidad']; ?></span>
              </div>
              <div class="cont-resumen" style="margin-bottom: 8px;">
                <span class="lbl" style="font-size: 0.95em; color: #555;">Subtotal <?php echo htmlspecialchars($tipo); ?>:</span>
                <span class="lbl-informacion sub-1" style="font-size: 0.95em;">$<?php echo number_format($info['subtotal'], 2, ',', '.'); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="cont-total-pagar">
            <span class="lbl">Total:</span>
            <span class="lbl-informacion sub-1">$<?php echo number_format($precio_final, 2, ',', '.'); ?></span>
          </div>
        </div>
        <form method="post" class="cont-btns">
          <button class="btn siguiente" name="confirmar_pedido" type="submit">Confirmar</button>
        </form>
      </article>
    </div>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('button[data-modificar-id]').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var id = btn.getAttribute('data-modificar-id');
      var form = document.getElementById('modificar-' + id);
      if (form) form.style.display = 'block';
    });
  });
});
</script>