<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { // solo administradores pueden acceder
    header('Location: /Olimpiadas/Truway/php/cliente/perfil.php');
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');


// verificar si se envio el id del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // si se envio por POST
    $id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;  // obtener id del producto
} else { // si se envio por GET
    $id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0; // obtener id del producto
}
if ($id_producto <= 0) { // si no se envio el id del producto
    echo "<p>ID de producto inválido.</p>"; // mostrar mensaje de error
    exit; 
}


$sql = "SELECT * FROM productos WHERE id_producto = $id_producto"; // consulta para obtener el producto
$res = mysqli_query($conexion, $sql); // ejecutar consulta
$producto = mysqli_fetch_assoc($res); // obtener producto

// si no se encontro el producto
if (!$producto) {
    echo "<p>Producto no encontrado.</p>"; // mostrar mensaje de error
    exit;
}

// obtener tipo de producto
$tipo_producto = strtolower($producto['tipo_producto']); 
$msg = "";


// si el tipo de producto no es valido
$tipos = []; // inicializar array de tipos
$resTipos = mysqli_query($conexion, "SELECT DISTINCT tipo_producto FROM productos WHERE tipo_producto IS NOT NULL ORDER BY tipo_producto"); // obtener tipos de productos
while ($row = mysqli_fetch_assoc($resTipos)) { // recorrer resultados
    $tipos[] = $row['tipo_producto']; // agregar tipo al array
}

$productos_incluidos = []; // inicializar array de productos incluidos
$productos_disponibles = []; // inicializar array de productos disponibles
if ($tipo_producto === 'paquete') { // si el tipo de producto es paquete
    $respaq = mysqli_query($conexion, "SELECT id_paquete FROM paquetes WHERE id_producto = $id_producto"); // obtener id del paquete
    $paq = mysqli_fetch_assoc($respaq); // obtener datos del paquete
    $id_paquete = $paq['id_paquete']; // obtener id del paquete
    $resIncluidos = mysqli_query($conexion, "SELECT id_producto FROM detalle_paquete WHERE id_paquete = $id_paquete"); // obtener productos del paquete
    while ($row = mysqli_fetch_assoc($resIncluidos)) { // recorrer productos incluidos
        $productos_incluidos[] = $row['id_producto']; // agregar id del producto incluido al array
    }
    // obtener productos disponibles
    $resTodos = mysqli_query($conexion, "SELECT id_producto, nombre, tipo_producto FROM productos WHERE tipo_producto != 'paquete' AND id_producto != $id_producto"); // obtener todos los productos excepto el paquete actual
    while ($row = mysqli_fetch_assoc($resTodos)) { 
        $productos_disponibles[] = $row; // agregar producto al array de productos disponibles
    }
}

// si el tipo de producto es excursion, estadia, pasaje o vehiculo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // si se envio el formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']); // obtener nombre del producto
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']); // obtener descripcion del producto
    $precio = floatval($_POST['precio']); // obtener precio del producto
    $tipo_producto_post = mysqli_real_escape_string($conexion, $_POST['tipo_producto']); // obtener tipo de producto del formulario

    // validar tipo de producto
    $update = "UPDATE productos SET 
        nombre = '$nombre',
        descripcion = '$descripcion',
        precio = $precio,
        tipo_producto = '$tipo_producto_post'
        WHERE id_producto = $id_producto";
    mysqli_query($conexion, $update); // ejecutar consulta de actualizacion


    if ($tipo_producto === 'excursion' || $tipo_producto === 'excursión') { //Excursion

        $ubicacion = mysqli_real_escape_string($conexion, $_POST['ubicacion_salida']); // obtener ubicacion de salida
        $duracion = intval($_POST['duracion']); // obtener duracion
        $guia = isset($_POST['guia']) ? 1 : 0; // obtener guia
        $dificultad = mysqli_real_escape_string($conexion, $_POST['dificultad']); // obtener dificultad

        mysqli_query($conexion, "UPDATE excursiones SET ubicacion_salida='$ubicacion', duracion=$duracion, guia=$guia, dificultad='$dificultad' WHERE id_producto=$id_producto"); // ejecutar consulta de actualizacion
    }
    if ($tipo_producto === 'estadia' || $tipo_producto === 'estadía') { // Estadia

        $localidad = mysqli_real_escape_string($conexion, $_POST['localidad']); // obtener localidad
        $nombre_hotel = mysqli_real_escape_string($conexion, $_POST['nombre_hotel']); // obtener nombre del hotel
        $servicios = mysqli_real_escape_string($conexion, $_POST['servicios']);     // obtener servicios
        $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']); // obtener categoria

        mysqli_query($conexion, "UPDATE estadias SET localidad='$localidad', nombre_hotel='$nombre_hotel', servicios='$servicios', categoria='$categoria' WHERE id_producto=$id_producto"); // ejecutar consulta 
    }
    if ($tipo_producto === 'pasaje') { // Pasaje

        $origen = mysqli_real_escape_string($conexion, $_POST['origen']); // obtener origen
        $destino = mysqli_real_escape_string($conexion, $_POST['destino']); // obtener destino
        $aerolinea = mysqli_real_escape_string($conexion, $_POST['aerolinea']); // obtener aerolinea
        $tipo_pasaje = mysqli_real_escape_string($conexion, $_POST['tipo_pasaje']); // obtener tipo de pasaje

        mysqli_query($conexion, "UPDATE pasajes SET origen='$origen', destino='$destino', aerolinea='$aerolinea', tipo_pasaje='$tipo_pasaje' WHERE id_producto=$id_producto"); // ejecutar consulta 
    }
    if ($tipo_producto === 'vehiculo' || $tipo_producto === 'vehículo' || $tipo_producto === 'alquiler de vehículo') { // Vehiculo

        $marca = mysqli_real_escape_string($conexion, $_POST['marca']); // obtener marca
        $modelo = mysqli_real_escape_string($conexion, $_POST['modelo']); // obtener modelo
        $capacidad = intval($_POST['capacidad']); // obtener capacidad
        $empresa = mysqli_real_escape_string($conexion, $_POST['empresa_rentadora']); // obtener empresa rentadora
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']); // obtener tipo


        mysqli_query($conexion, "UPDATE vehiculos SET marca='$marca', modelo='$modelo', capacidad=$capacidad, empresa_rentadora='$empresa', tipo='$tipo' WHERE id_producto=$id_producto"); // ejecutar consulta
    }
    if ($tipo_producto === 'paquete') { // Paquete

        $respaq = mysqli_query($conexion, "SELECT id_paquete FROM paquetes WHERE id_producto = $id_producto"); // obtener id del paquete
        $paq = mysqli_fetch_assoc($respaq); // obtener datos del paquete
        $id_paquete = $paq['id_paquete']; // obtener id del paquete
        mysqli_query($conexion, "DELETE FROM detalle_paquete WHERE id_paquete = $id_paquete"); // eliminar productos del paquete

        $ids = []; // inicializar array de ids de productos
        if (!empty($_POST['excursion'])) $ids[] = intval($_POST['excursion']); // agregar id de excursion
        if (!empty($_POST['pasaje'])) $ids[] = intval($_POST['pasaje']); // agregar id de pasaje
        if (!empty($_POST['estadia'])) $ids[] = intval($_POST['estadia']); // agregar id de estadia
        if (!empty($_POST['vehiculo'])) $ids[] = intval($_POST['vehiculo']); // agregar id de vehiculo
        foreach ($ids as $id_prod) {  // recorrer ids de productos
            mysqli_query($conexion, "INSERT INTO detalle_paquete (id_paquete, id_producto) VALUES ($id_paquete, $id_prod)"); // insertar producto en paquete
        }
    }


    if ($tipo_producto === 'paquete') { // si el tipo de producto es paquete
        header("Location: consultar-producto.php?tabla_seleccionada=paquetes"); // redirigir a consultar paquetes

    } elseif ($tipo_producto === 'excursion' || $tipo_producto === 'excursión') { // si el tipo de producto es excursion
        header("Location: consultar-producto.php?tabla_seleccionada=excursiones"); // redirigir a consultar excursiones

    } elseif ($tipo_producto === 'estadia' || $tipo_producto === 'estadía') { // si el tipo de producto es estadia
        header("Location: consultar-producto.php?tabla_seleccionada=estadias"); // redirigir a consultar estadias

    } elseif ($tipo_producto === 'pasaje') { // si el tipo de producto es pasaje
        header("Location: consultar-producto.php?tabla_seleccionada=boletos_avion"); // redirigir a consultar boletos de avion

    } elseif ($tipo_producto === 'vehiculo' || $tipo_producto === 'vehículo' || $tipo_producto === 'alquiler de vehículo') { // si el tipo de producto es vehiculo
        header("Location: consultar-producto.php?tabla_seleccionada=alquiler_vehiculos"); // redirigir a consultar vehiculos

    } else { 
        header("Location: consultar-producto.php?tabla_seleccionada=productos");
    }
    exit;
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
    <main>
        <link rel="stylesheet" href="/Olimpiadas/Truway/css/editar-producto.css">
        <section class="section-editar-productos">
            <div class="cont-titulo-btns">
                <h2 class="subtitulo" >Editar <?= ucfirst($tipo_producto) ?></h2>
                <div class="btns-acciones">
                    <button type="submit" form="form-editar-producto" class="btn guardar">Guardar cambios</button>
                    <a href="consultar-producto.php" class="btn volver">Volver</a>
                </div>
            </div>

            <?php if ($msg) { echo "<p>$msg</p>"; } ?>
            <form method="post" class="form-editar-producto" id="form-editar-producto">
                <input type="hidden" name="id_producto" value="<?= $id_producto ?>">
                <div class="seccion-informacion-general">
                    <h3 class="subtitulo">Datos de generales</h3>
                    <div class="cont-input">
                        <label for="nombre" class="lbl">Nombre:</label>
                        <input class="input-producto" type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                    </div>
                    <div class="cont-input">
                        <label for="descripcion" class="lbl">Descripción:</label>
                        <textarea class="input-producto" name="descripcion" id="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                    </div>
                    <div class="cont-input">
                        <label for="precio" class="lbl">Precio:</label>
                        <input class="input-producto" type="number" name="precio" id="precio" step="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required>
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
                </div>

                <?php if ($tipo_producto === 'excursion' || $tipo_producto === 'excursión'):
                    $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM excursiones WHERE id_producto = $id_producto"));
                ?>
                <div class="seccion-informacion-especifica excursion oculto">
                        <h3 class="subtitulo">Datos de la excursión</h3>

                        <div class="cont-input">
                            <label for="ubicacion_salida" class="lbl" >Ubicación salida:</label> 
                            <input class="input-producto" type="text" name="ubicacion_salida" value="<?= htmlspecialchars($info['ubicacion_salida']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label for="duracion" class="lbl">Duración (horas):</label>
                            <input class="input-producto" type="number" name="duracion" value="<?= htmlspecialchars($info['duracion']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label for="guia" class="lbl">Guía:</label> 
                            <div class="cont-input-checkbox">
                                <input type="checkbox" name="guia" value="1" <?= $info['guia'] ? 'checked' : '' ?>>
                            </div>
                        </div>
                        <div class="cont-input">
                            <label for="dificultad" class="lbl">Dificultad:</label>
                            <select name="dificultad" required class="input-producto">
                                <option value="baja" <?= $info['dificultad']=='baja'?'selected':'' ?>>Baja</option>
                                <option value="media" <?= $info['dificultad']=='media'?'selected':'' ?>>Media</option>
                                <option value="alta" <?= $info['dificultad']=='alta'?'selected':'' ?>>Alta</option>
                            </select>
                        </div>
                </div>

                <?php elseif ($tipo_producto === 'estadia' || $tipo_producto === 'estadía'):
                    $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM estadias WHERE id_producto = $id_producto"));
                ?>

                <div class="seccion-informacion-especifica estadia oculto"> 
                        <h3>Datos de la estadía</h3>

                        <div class="cont-input">
                            <label class="lbl" for="localidad">Localidad:</label>
                            <input class="input-producto" type="text" name="localidad" value="<?= htmlspecialchars($info['localidad']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label class="lbl" for="nombre_hotel">Nombre hotel:</label> 
                            <input type="text" name="nombre_hotel" value="<?= htmlspecialchars($info['nombre_hotel']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label class="lbl" for="servicios" >Servicios:</label>
                            <input type="text" name="servicios" value="<?= htmlspecialchars($info['servicios']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label class="lbl" for="categoria">Categoría:</label>
                            <select name="categoria" required>
                                <option value="1" <?= $info['categoria']=='1'?'selected':'' ?>>1</option>
                                <option value="2" <?= $info['categoria']=='2'?'selected':'' ?>>2</option>
                                <option value="3" <?= $info['categoria']=='3'?'selected':'' ?>>3</option>
                                <option value="4" <?= $info['categoria']=='4'?'selected':'' ?>>4</option>
                                <option value="5" <?= $info['categoria']=='5'?'selected':'' ?>>5</option>
                            </select>
                        </div>
                </div>

                <?php elseif ($tipo_producto === 'pasaje'):
                    $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM pasajes WHERE id_producto = $id_producto"));
                ?>
                <div class="seccion-informacion-especifica pasaje oculto">

                        <h3 class="subtitulo"> Datos del pasaje</h3>

                        <div class="cont-input">
                            <label for="origen" class="lbl">Origen:</label>
                            <input class="input-producto" type="text" name="origen" value="<?= htmlspecialchars($info['origen']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label for="destino" class="lbl">Destino:</label>
                            <input class="input-producto" type="text" name="destino" value="<?= htmlspecialchars($info['destino']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label for="aereolinea" class="lbl" >Aerolínea:</label>
                            <input class="input-producto" type="text" name="aerolinea" value="<?= htmlspecialchars($info['aerolinea']) ?>" required>
                        </div>

                        <div class="cont-input">
                            <label for="tipo_pasaje" class="lbl" >Tipo pasaje:</label>
                            <select class="input-producto" name="tipo_pasaje" required>
                                <option value="solo_ida" <?= $info['tipo_pasaje']=='solo_ida'?'selected':'' ?>>Solo ida</option>
                                <option value="ida_y_vuelta" <?= $info['tipo_pasaje']=='ida_y_vuelta'?'selected':'' ?>>Ida y vuelta</option>
                            </select>
                        </div>
                </div>

                <?php elseif ($tipo_producto === 'vehiculo' || $tipo_producto === 'vehículo' || $tipo_producto === 'alquiler de vehículo'):
                    $info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM vehiculos WHERE id_producto = $id_producto"));
                ?>
                <div class="seccion-informacion-especifica vehiculo oculto">

                        <h3>Datos del vehículo</h3>

                        <div class="cont-input">
                            <label for="marca" class="lbl" >Marca:</label> 
                            <input class="input-producto" type="text" name="marca" value="<?= htmlspecialchars($info['marca']) ?>" required>
                        </div>
                        <div class="cont-input">
                            <label for="modelo" class="lbl" >Modelo:<label>
                            <input class="input-producto" type="text" name="modelo" value="<?= htmlspecialchars($info['modelo']) ?>" required>
                        </div>
                        <div class="cont-input">
                            <label for="capacidad" class="lbl" >Capacidad:</label>
                            <input class="input-producto" type="number" name="capacidad" value="<?= htmlspecialchars($info['capacidad']) ?>" required>
                        </div>
                        <div class="cont-input">
                            <label for="empresa_rentadora" class="lbl" >Empresa rentadora:</label> 
                            <input class="input-producto" type="text" name="empresa_rentadora" value="<?= htmlspecialchars($info['empresa_rentadora']) ?>" required>
                        </div>
                        <div class="cont-input">
                            <label for="tipo" class="lbl">Tipo:</label> 
                            <input class="input-producto" type="text" name="tipo" value="<?= htmlspecialchars($info['tipo']) ?>" required>
                        </div>
                </div>
                <?php elseif ($tipo_producto === 'paquete'):
        
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
                <div class="seccion-informacion-especifica paquete oculto">
                        <h3>Productos incluidos en el paquete</h3>

                        <div class="cont-input">
                            <label for="excursion" clas="lbl">Excursión (obligatoria):</label>
                            <select name="excursion" class="input-producto" required>
                                <?php foreach ($excursiones as $prod) { ?>
                                    <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_excursion) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prod['nombre']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="cont-input">           
                            <label for="pasaje" clas="lbl">Pasaje (opcional):</label>
                            <select name="pasaje" class="input-producto">
                                <option value="">Sin pasaje</option>
                                <?php foreach ($pasajes as $prod) { ?>
                                    <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_pasaje) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prod['nombre']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="cont-input">
                            <label for="estadia" clas="lbl">Estadía (opcional):</label>
                            <select name="estadia" class="input-producto">
                                <option value="">Sin estadía</option>
                                <?php foreach ($estadias as $prod) { ?>
                                    <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_estadia) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prod['nombre']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="cont-input">
                            <label for="vehiculo" clas="lbl">Alquiler de vehículo (opcional):</label>
                            <select name="vehiculo" class="input-producto">
                                <option value="">Sin vehículo</option>
                                <?php foreach ($vehiculos as $prod) { ?>
                                    <option value="<?= $prod['id_producto'] ?>" <?= ($prod['id_producto'] == $id_vehiculo) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prod['nombre']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                </div>
                <?php endif; ?>
            </form>
        </section>
    </main>

     <script>
        document.addEventListener('DOMContentLoaded', function () {
        const valor = "<?= strtolower($tipo_producto) ?>";
        const formularios = document.querySelectorAll('.seccion-informacion-especifica');

        formularios.forEach(form => form.classList.add('oculto'));

        if (valor === 'excursion' || valor === 'excursión') {
            document.querySelector('.seccion-informacion-especifica.excursion')?.classList.remove('oculto');
        } else if (valor === 'estadia' || valor === 'estadía') {
            document.querySelector('.seccion-informacion-especifica.estadia')?.classList.remove('oculto');
        } else if (valor === 'pasaje') {
            document.querySelector('.seccion-informacion-especifica.pasaje')?.classList.remove('oculto');
        } else if (valor === 'vehiculo' || valor === 'vehículo' || valor === 'alquiler de vehículo') {
            document.querySelector('.seccion-informacion-especifica.vehiculo')?.classList.remove('oculto');
        } else if (valor === 'paquete') {
            document.querySelector('.seccion-informacion-especifica.paquete')?.classList.remove('oculto');
        }
    });
</script>

</body>
</html>