<?php
  session_start(); 
  ?>

  <link rel="stylesheet" href="/Olimpiadas/Truway/css/carrito.css">

  <?php
  include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php'; 
  include('conexion.php'); 

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

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])) {
      $id_detalle_carrito = intval($_POST['id_detalle_carrito']);
      $consulta = "DELETE FROM detalle_carrito WHERE id_detalle_carrito = $id_detalle_carrito";
      mysqli_query($conexion, $consulta);
      header('Location: carrito.php');
      exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_producto'])) {
      $id_detalle_carrito = intval($_POST['id_detalle_carrito']);
      $nueva_cantidad = max(1, intval($_POST['nueva_cantidad']));
      $nueva_fecha = $_POST['nueva_fecha'];
      $hoy = new DateTime(date('Y-m-d'));
      $fecha_usuario = DateTime::createFromFormat('Y-m-d', $nueva_fecha);

      if ($fecha_usuario && $fecha_usuario >= $hoy) {
          $consulta = "UPDATE detalle_carrito SET cantidad = $nueva_cantidad, fecha_reserva = '$nueva_fecha' WHERE id_detalle_carrito = $id_detalle_carrito";
          mysqli_query($conexion, $consulta);
          header('Location: carrito.php');
          exit();
      } else {
          $error_modificar = "La fecha seleccionada no puede ser anterior a hoy.";
      }
  }

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
  $resumen_tipos = [];

  while ($fila = mysqli_fetch_assoc($resultado_detalle)) {
      $productos[] = $fila;
      $cantidad_paquetes += $fila['cantidad'];
      $subtotal += $fila['precio_carrito'] * $fila['cantidad'];
      $tipo = $fila['tipo_producto'];
      if (!isset($resumen_tipos[$tipo])) {
          $resumen_tipos[$tipo] = [
              'cantidad' => 0,
              'subtotal' => 0
          ];
      }
      $resumen_tipos[$tipo]['cantidad'] += $fila['cantidad'];
      $resumen_tipos[$tipo]['subtotal'] += $fila['precio_carrito'] * $fila['cantidad'];
  }
  $precio_final = $subtotal;

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
              <?php 
                include_once($_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/Truway/php/general/tags.php'); FiltrarTags($producto['tipo_producto']);
              ?>
              <span class="nombre-tag"><?php echo htmlspecialchars($producto['tipo_producto']); ?></span>
            </div>
          </div>
          <div class="cont-grid-titulo-btns"> 
            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
            <div class="cont-btns">
              <!-- boton para modificar producto -->
              <button class="btn modificar" type="button" data-modificar-id="<?php echo $producto['id_detalle_carrito']; ?>">
                 <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M20.71 7.04c-.34.34-.67.67-.68 1c-.03.32.31.65.63.96c.48.5.95.95.93 1.44s-.53 1-1.04 1.5l-4.13 4.14L15 14.66l4.25-4.24l-.96-.96l-1.42 1.41l-3.75-3.75l3.84-3.83c.39-.39 1.04-.39 1.41 0l2.34 2.34c.39.37.39 1.02 0 1.41M3 17.25l9.56-9.57l3.75 3.75L6.75 21H3z"/></svg>
              </button>
              <!-- formulario para eliminar producto -->
              <form method="post">
                <input type="hidden" name="id_detalle_carrito" value="<?php echo $producto['id_detalle_carrito']; ?>">
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
              <span class="informacion fecha"><?php echo htmlspecialchars($producto['fecha_reserva']); ?></span>
            </div>
          </div>
          <div class="cont-importe">
            <span class="importe">$<?php echo number_format($producto['precio_carrito'], 2, ',', '.'); ?></span>
          </div>
        </div>
        <!-- formulario modificar -->
        <form id="modificar-<?php echo $producto['id_detalle_carrito']; ?>" method="post" style="display:none; margin-top:10px;">
          <input type="hidden" name="id_detalle_carrito" value="<?php echo $producto['id_detalle_carrito']; ?>">
          <label>Cantidad: <input type="number" name="nueva_cantidad" min="1" value="<?php echo $producto['cantidad']; ?>" required></label>
          <label>Fecha: <input type="date" name="nueva_fecha" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($producto['fecha_reserva']); ?>" required></label>
          <button type="submit" name="modificar_producto" class="btn guardar">Guardar</button>
          <button type="button" class="btn cancelar" onclick="document.getElementById('modificar-<?php echo $producto['id_detalle_carrito']; ?>').style.display='none';return false;">Cancelar</button>
          <?php if (isset($error_modificar) && isset($_POST['id_detalle_carrito']) && $_POST['id_detalle_carrito'] == $producto['id_detalle_carrito']) echo '<p style="color:red;">' . htmlspecialchars($error_modificar) . '</p>'; ?>
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
          <a class="btn siguiente" href="/Olimpiadas/Truway/php/cliente/facturacion.php">Siguiente</a>
          <button class="btn borrar" name="vaciar_carrito" type="submit">Vaciar carrito</button>
        </form>
      </article>
    </div>
  </section>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>
</main>
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