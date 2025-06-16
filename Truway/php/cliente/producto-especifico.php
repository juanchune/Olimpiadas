<?php

session_start(); 
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_usuario = $_SESSION['id'] ?? 0;
    $id_producto = intval($_POST['id_producto']);
    $personas = intval($_POST['personas'] ?? 1);
    $fecha_pedido = $_POST['fecha-pedido'] ?? date('Y-m-d');

    // Obtener precio actual 
    $res_precio = mysqli_query($conexion, "SELECT precio FROM productos WHERE id_producto = $id_producto");
    $row_precio = mysqli_fetch_assoc($res_precio);
    $precio = $row_precio ? floatval($row_precio['precio']) : 0;

    if ($id_usuario && $id_producto && $precio > 0) {
        // Buscar si el usuario ya tiene un carrito
        $res_carrito = mysqli_query($conexion, "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario");
        if ($row_carrito = mysqli_fetch_assoc($res_carrito)) {
            $id_carrito = $row_carrito['id_carrito'];
        } else {
            // Crear carrito si no existe
            mysqli_query($conexion, "INSERT INTO carrito (id_usuario) VALUES ($id_usuario)");
            $id_carrito = mysqli_insert_id($conexion);
        }

        // Verificar si el producto ya está 
        $res_detalle = mysqli_query($conexion, "SELECT id_detalle_carrito, cantidad FROM detalle_carrito WHERE id_carrito = $id_carrito AND id_producto = $id_producto");
        if ($row_detalle = mysqli_fetch_assoc($res_detalle)) {
            
            $nueva_cantidad = $row_detalle['cantidad'] + $personas;
            $id_detalle_carrito = $row_detalle['id_detalle_carrito'];
            mysqli_query($conexion, "UPDATE detalle_carrito SET cantidad = $nueva_cantidad, fecha_reserva = '$fecha_pedido' WHERE id_detalle_carrito = $id_detalle_carrito");
        } else {
            
            mysqli_query($conexion, "INSERT INTO detalle_carrito (id_carrito, id_producto, cantidad, precio_carrito, fecha_reserva) VALUES ($id_carrito, $id_producto, $personas, $precio, '$fecha_pedido')");
        }

        // Redirigir 
        header("Location: producto-especifico.php?id=$id_producto&agregado=1");
        exit;
    } else {
        $error = "Debe iniciar sesión para agregar productos al carrito.";
    }
}

// Verificar si el usuario está autenticado
$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_producto <= 0) {
    echo "<p>Producto no encontrado.</p>";
    include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php';
    exit;
}

// Verificar si el producto existe
$res = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto = $id_producto");
$producto = mysqli_fetch_assoc($res);

if (!$producto) {
    echo "<p>Producto no encontrado.</p>";
    include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php';
    exit;
}

// Obtener información del producto
$tipoProducto = strtolower($producto['tipo_producto']);
$nombre = $producto['nombre'];
$descripcion = $producto['descripcion'];
$precio = $producto['precio'];

// Verificar si el producto es parte de un paquete
$incluyePasaje = false;
$incluyeVehiculo = false;
$incluyeEstadia = false;

// Si es un paquete, obtener los productos incluidos
if($tipoProducto == 'paquete'){
    $res_paquete = mysqli_query($conexion, "SELECT id_paquete FROM paquetes WHERE id_producto = $id_producto");
    if ($paquete = mysqli_fetch_assoc($res_paquete)) {
        $id_paquete = $paquete['id_paquete'];
        $res_detalle = mysqli_query($conexion, "SELECT p.tipo_producto FROM detalle_paquete dp JOIN productos p ON dp.id_producto = p.id_producto WHERE dp.id_paquete = $id_paquete");
        while ($row = mysqli_fetch_assoc($res_detalle)) {
            $tipo = strtolower($row['tipo_producto']);
            if ($tipo == 'pasaje') $incluyePasaje = true;
            if ($tipo == 'alquiler de vehículo' || $tipo == 'vehiculo' || $tipo == 'vehículo') $incluyeVehiculo = true;
            if ($tipo == 'estadía' || $tipo == 'estadia') $incluyeEstadia = true;
        }
    }
}
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/producto-especifico.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
    <section class="producto-especifico">
        <div class="cont-general">
                <h2 class="nombre">
                    <?php echo htmlspecialchars($nombre); ?>
                </h2>
                <span class="descripcion"><?php echo htmlspecialchars($descripcion); ?></span>
                <h6 class=precio-unitario>ARS $<?php echo number_format($precio, 2, ',', '.'); ?></h6>
                <a href="#reserva" class=btn-realizar-reserva>
                    Realizar reserva
                </a>
        </div>
        <div class="informacion-especifica <?php echo 'info-' . $tipoProducto; ?>">

    <?php if ($tipoProducto === 'pasaje'): 
        $res = mysqli_query($conexion, "SELECT * FROM pasajes WHERE id_producto = $id_producto");
        $info = mysqli_fetch_assoc($res);
    ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Origen</span>
            <span class="dato"><?php echo htmlspecialchars($info['origen']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Destino</span>
            <span class="dato"><?php echo htmlspecialchars($info['destino']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Aerolínea</span>
            <span class="dato"><?php echo htmlspecialchars($info['aerolinea']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Tipo pasaje</span>
            <span class="dato"><?php echo str_replace('_', ' ', ucfirst($info['tipo_pasaje'])); ?></span>
        </div>
    <?php elseif ($tipoProducto === 'vehiculo' || $tipoProducto === 'vehículo' || $tipoProducto === 'alquiler de vehículo'): 
        $res = mysqli_query($conexion, "SELECT * FROM vehiculos WHERE id_producto = $id_producto");
        $info = mysqli_fetch_assoc($res);
    ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Marca</span>
            <span class="dato"><?php echo htmlspecialchars($info['marca']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Capacidad</span>
            <span class="dato"><?php echo htmlspecialchars($info['capacidad']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Empresa rentadora</span>
            <span class="dato"><?php echo htmlspecialchars($info['empresa_rentadora']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Tipo</span>
            <span class="dato"><?php echo htmlspecialchars($info['tipo']); ?></span>
        </div>
    <?php elseif ($tipoProducto === 'excursion' || $tipoProducto === 'excursión'): 
        $res = mysqli_query($conexion, "SELECT * FROM excursiones WHERE id_producto = $id_producto");
        $info = mysqli_fetch_assoc($res);
    ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Ubicacion salida</span>
            <span class="dato"><?php echo htmlspecialchars($info['ubicacion_salida']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Duracion</span>
            <span class="dato"><?php echo htmlspecialchars($info['duracion']); ?> horas</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Guia</span>
            <span class="dato"><?php echo ($info['guia'] ? 'Sí' : 'No'); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Dificultad</span>
            <span class="dato"><?php echo ucfirst($info['dificultad']); ?></span>
        </div>
     <?php elseif ($tipoProducto === 'estadia' || $tipoProducto === 'estadía'): 
        $res = mysqli_query($conexion, "SELECT * FROM estadias WHERE id_producto = $id_producto");
        $info = mysqli_fetch_assoc($res);
    ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Localidad</span>
            <span class="dato"><?php echo htmlspecialchars($info['localidad']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Nombre hotel</span>
            <span class="dato"><?php echo htmlspecialchars($info['nombre_hotel']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Servicios</span>
            <span class="dato"><?php echo htmlspecialchars($info['servicios']); ?></span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Categoria</span>
            <span class="dato"><?php echo htmlspecialchars($info['categoria']); ?> estrellas</span>
        </div>

    <?php elseif ($tipoProducto === 'paquete'): 

        $res_paquete = mysqli_query($conexion, "SELECT id_paquete FROM paquetes WHERE id_producto = $id_producto");
        $paquete = mysqli_fetch_assoc($res_paquete);
        $id_paquete = $paquete ? $paquete['id_paquete'] : 0;

        $res_detalle = mysqli_query($conexion, "SELECT p.*, dp.id_producto as id_prod_incluido FROM detalle_paquete dp JOIN productos p ON dp.id_producto = p.id_producto WHERE dp.id_paquete = $id_paquete");
        while ($prod = mysqli_fetch_assoc($res_detalle)):
            $tipo = strtolower($prod['tipo_producto']);
            if ($tipo == 'excursion' || $tipo == 'excursión'):
                $res_info = mysqli_query($conexion, "SELECT * FROM excursiones WHERE id_producto = {$prod['id_producto']}");
                $info = mysqli_fetch_assoc($res_info);
    ?>
    <h4 class="subtitulo">Excursión</h4>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Ubicación salida</span>
        <span class="dato"><?php echo htmlspecialchars($info['ubicacion_salida']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Duración</span>
        <span class="dato"><?php echo htmlspecialchars($info['duracion']); ?> horas</span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Guía</span>
        <span class="dato"><?php echo ($info['guia'] ? 'Sí' : 'No'); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Dificultad</span>
        <span class="dato"><?php echo ucfirst($info['dificultad']); ?></span>
    </div>
    <?php
            elseif ($tipo == 'pasaje'):
                $res_info = mysqli_query($conexion, "SELECT * FROM pasajes WHERE id_producto = {$prod['id_producto']}");
                $info = mysqli_fetch_assoc($res_info);
    ?>
    <h4 class="subtitulo">Pasajes</h4>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Origen</span>
        <span class="dato"><?php echo htmlspecialchars($info['origen']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Destino</span>
        <span class="dato"><?php echo htmlspecialchars($info['destino']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Aerolínea</span>
        <span class="dato"><?php echo htmlspecialchars($info['aerolinea']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Tipo pasaje</span>
        <span class="dato"><?php echo str_replace('_', ' ', ucfirst($info['tipo_pasaje'])); ?></span>
    </div>
    <?php
            elseif ($tipo == 'alquiler de vehículo' || $tipo == 'vehiculo' || $tipo == 'vehículo'):
                $res_info = mysqli_query($conexion, "SELECT * FROM vehiculos WHERE id_producto = {$prod['id_producto']}");
                $info = mysqli_fetch_assoc($res_info);
    ?>
    <h4 class="subtitulo">Vehículo</h4>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Marca</span>
        <span class="dato"><?php echo htmlspecialchars($info['marca']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Capacidad</span>
        <span class="dato"><?php echo htmlspecialchars($info['capacidad']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Empresa rentadora</span>
        <span class="dato"><?php echo htmlspecialchars($info['empresa_rentadora']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Tipo</span>
        <span class="dato"><?php echo htmlspecialchars($info['tipo']); ?></span>
    </div>
    <?php
            elseif ($tipo == 'estadía' || $tipo == 'estadia'):
                $res_info = mysqli_query($conexion, "SELECT * FROM estadias WHERE id_producto = {$prod['id_producto']}");
                $info = mysqli_fetch_assoc($res_info);
    ?>
    <h4 class="subtitulo">Estadía</h4>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Localidad</span>
        <span class="dato"><?php echo htmlspecialchars($info['localidad']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Nombre hotel</span>
        <span class="dato"><?php echo htmlspecialchars($info['nombre_hotel']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Servicios</span>
        <span class="dato"><?php echo htmlspecialchars($info['servicios']); ?></span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Categoría</span>
        <span class="dato"><?php echo htmlspecialchars($info['categoria']); ?> estrellas</span>
    </div>
    <?php
            endif;
        endwhile;
    endif; ?>
        </div>
    </section>
    <section class="section-frm-datos" id=reserva>
        <form class="formulario-fecha-cant" action="" method="post">
            <div class="cont-input">
                <label class="lbl-frm" for="personas">Cantidad de personas</label>
                <input class="input-frm" id="personas" name="personas" type="number" min="1" max="9999" required>
            </div>
            <div class="cont-input">
                <label class="lbl-frm" for="fecha">Fecha</label>
                <input class="input-frm" id="fecha" name="fecha-pedido" type="date" required>
            </div>
            <div class="cont-input">
                <button class="btn-agregar" type="submit">Agregar al carrito</button>
            </div>
            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
        </form>
        <?php if (isset($error)) { echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>'; } ?>
        <?php if (isset($_GET['agregado']) && $_GET['agregado'] == 1) { echo '<p style="color:green;">Producto agregado al carrito.</p>'; } ?>
    </section>

</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const enlaceReserva = document.querySelector('.btn-realizar-reserva');
    const seccionReserva = document.getElementById('reserva');

    enlaceReserva.addEventListener('click', function () {
      seccionReserva.classList.add('resaltar');


      setTimeout(() => {
        seccionReserva.classList.remove('resaltar');
      }, 1500);
    });
  });
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>