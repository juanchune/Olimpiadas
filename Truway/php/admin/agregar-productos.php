<?php
session_start();
include("conexion.php");

// Función para validar campos
function validarCampos($campos) {
    $errores = [];
    foreach ($campos as $campo => $valor) {
        if (empty($valor)) {
            $errores[] = "El campo $campo es obligatorio.";
        }
    }
    return $errores;
}

// Función para obtener productos existentes
function obtenerProductos($conexion, $tabla) {
    $sql = "SELECT p.id_producto, p.nombre 
            FROM productos p
            INNER JOIN $tabla t ON p.id_producto = t.id_producto";
    $resultado = mysqli_query($conexion, $sql);
    $productos = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $productos[] = $fila;
    }
    return $productos;
}

// Obtener listas de productos existentes
$estadias = obtenerProductos($conexion, 'estadia');
$pasajes = obtenerProductos($conexion, 'pasaje');
$vehiculos = obtenerProductos($conexion, 'vehiculo');
$excursiones = obtenerProductos($conexion, 'excursiones');

$errores = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'producto') {
        // Agregar producto individual
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $tipo_producto = $_POST['tipo_producto'] ?? 0;

        $errores = validarCampos([
            'Nombre' => $nombre,
            'Descripción' => $descripcion,
            'Precio' => $precio,
            'Tipo de Producto' => $tipo_producto
        ]);

        if (empty($errores)) {
            $productoDatos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'tipo_producto' => $tipo_producto
            ];

            if (insertarDatos($conexion, 'productos', $productoDatos)) {
                echo "Producto agregado correctamente.";
            } else {
                $errores[] = "Error al agregar el producto: " . mysqli_error($conexion);
            }
        }
    } elseif ($accion === 'paquete') {
        // Agregar paquete
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? 0;

        $errores = validarCampos([
            'Nombre' => $nombre,
            'Descripción' => $descripcion,
            'Precio' => $precio
        ]);

        if (empty($errores)) {
            $productoDatos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'tipo_producto' => 1 // Tipo de producto paquete
            ];

            if (insertarDatos($conexion, 'productos', $productoDatos)) {
                $id_producto = mysqli_insert_id($conexion);

                // Insertar paquete y asociar productos seleccionados
                $id_estadia = $_POST['id_estadia'] ?? null;
                $id_pasaje = $_POST['id_pasaje'] ?? null;
                $id_vehiculo = $_POST['id_vehiculo'] ?? null;
                $id_excursion = $_POST['id_excursion'] ?? null;

                $datosPaquete = [
                    'id_producto' => $id_producto,
                    'id_estadia' => $id_estadia,
                    'id_pasaje' => $id_pasaje,
                    'id_vehiculo' => $id_vehiculo,
                    'id_excursion' => $id_excursion
                ];

                if (!insertarDatos($conexion, 'paquetes', $datosPaquete)) {
                    $errores[] = "Error al asociar productos al paquete: " . mysqli_error($conexion);
                } else {
                    echo "Paquete agregado correctamente.";
                }
            } else {
                $errores[] = "Error al agregar el paquete: " . mysqli_error($conexion);
            }
        }
    }
}
?>
<body>
    <h1>Agregar Producto o Paquete</h1>
    <?php if (!empty($errores)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST">
        <label>¿Qué desea agregar?</label>
        <select name="accion" id="accion" required>
            <option value="">Seleccione una opción</option>
            <option value="producto">Producto Individual</option>
            <option value="paquete">Paquete</option>
        </select><br>

        <!-- Formulario para agregar producto individual -->
        <div id="form-producto" style="display: none;">
            <h3>Agregar Producto Individual</h3>
            <label>Nombre:</label>
            <input type="text" name="nombre"><br>

            <label>Descripción:</label>
            <textarea name="descripcion"></textarea><br>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio"><br>

            <label>Tipo de Producto:</label>
            <select name="tipo_producto" id="tipo_producto">
                <option value="">Seleccione un tipo</option>
                <option value="2">Excursión</option>
                <option value="3">Pasaje</option>
                <option value="4">Alquiler de Vehículo</option>
                <option value="5">Estadía</option>
            </select><br>

            <!-- Contenedor para los campos adicionales según el tipo de producto -->
            <div id="campos-adicionales"></div>
        </div>

        <!-- Formulario para agregar paquete -->
        <div id="form-paquete" style="display: none;">
            <h3>Agregar Paquete</h3>
            <label>Nombre:</label>
            <input type="text" name="nombre"><br>

            <label>Descripción:</label>
            <textarea name="descripcion"></textarea><br>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio"><br>

            <h3>Seleccionar Productos Existentes</h3>

            <label>Estadía:</label>
            <select name="id_estadia">
                <option value="">No incluir</option>
                <?php foreach ($estadias as $estadia): ?>
                    <option value="<?= $estadia['id_producto'] ?>"><?= htmlspecialchars($estadia['nombre']) ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Pasaje:</label>
            <select name="id_pasaje">
                <option value="">No incluir</option>
                <?php foreach ($pasajes as $pasaje): ?>
                    <option value="<?= $pasaje['id_producto'] ?>"><?= htmlspecialchars($pasaje['nombre']) ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Vehículo:</label>
            <select name="id_vehiculo">
                <option value="">No incluir</option>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <option value="<?= $vehiculo['id_producto'] ?>"><?= htmlspecialchars($vehiculo['nombre']) ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Excursión:</label>
            <select name="id_excursion">
                <option value="">No incluir</option>
                <?php foreach ($excursiones as $excursion): ?>
                    <option value="<?= $excursion['id_producto'] ?>"><?= htmlspecialchars($excursion['nombre']) ?></option>
                <?php endforeach; ?>
            </select><br>
        </div>

        <button type="submit">Agregar</button>
    </form>

    <script>
        document.getElementById('accion').addEventListener('change', function () {
            const accion = this.value;
            document.getElementById('form-producto').style.display = accion === 'producto' ? 'block' : 'none';
            document.getElementById('form-paquete').style.display = accion === 'paquete' ? 'block' : 'none';
        });

        document.getElementById('tipo_producto').addEventListener('change', function () {
            const tipo = this.value;
            const camposAdicionales = document.getElementById('campos-adicionales');
            let campos = '';

            switch (tipo) {
                case '2': // Excursión
                    campos = `
                        <label>Ubicación de Salida:</label>
                        <input type="text" name="ubicacion_salida" required><br>
                        <label>Duración:</label>
                        <input type="time" name="duracion" required><br>
                        <label>Guía:</label>
                        <input type="checkbox" name="guia"><br>
                        <label>Dificultad:</label>
                        <select name="dificultad" required>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select><br>
                    `;
                    break;
                case '3': // Pasaje
                    campos = `
                        <label>Origen:</label>
                        <input type="text" name="origen" required><br>
                        <label>Destino:</label>
                        <input type="text" name="destino" required><br>
                        <label>Aerolínea:</label>
                        <input type="text" name="aerolinea" required><br>
                        <label>Tipo de Pasaje:</label>
                        <select name="tipo_pasaje" required>
                            <option value="ida">Ida</option>
                            <option value="ida_vuelta">Ida y Vuelta</option>
                        </select><br>
                    `;
                    break;
                case '4': // Alquiler de Vehículo
                    campos = `
                        <label>Marca:</label>
                        <input type="text" name="marca" required><br>
                        <label>Modelo:</label>
                        <input type="text" name="modelo" required><br>
                        <label>Capacidad:</label>
                        <input type="number" name="capacidad" required><br>
                        <label>Empresa Rentadora:</label>
                        <input type="text" name="empresa_rentadora" required><br>
                        <label>Tipo:</label>
                        <input type="text" name="tipo" required><br>
                    `;
                    break;
                case '5': // Estadía
                    campos = `
                        <label>Localidad:</label>
                        <input type="text" name="localidad" required><br>
                        <label>Nombre del Hotel:</label>
                        <input type="text" name="nombre_hotel" required><br>
                        <label>Servicios:</label>
                        <textarea name="servicios" required></textarea><br>
                        <label>Categoría:</label>
                        <select name="categoria" required>
                            <option value="1">1 Estrella</option>
                            <option value="2">2 Estrellas</option>
                            <option value="3">3 Estrellas</option>
                            <option value="4">4 Estrellas</option>
                            <option value="5">5 Estrellas</option>
                        </select><br>
                    `;
                    break;
                default:
                    campos = ''; // Si no se selecciona un tipo válido, no mostrar nada
            }

            camposAdicionales.innerHTML = campos;
        });
    </script>
</body>