<?php

    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
    include('conexion.php');

    // Obtener productos por tipo para paquetes
    function getProductosPorTipo($conexion, $tipo) {
        $arr = [];
        $res = mysqli_query($conexion, "SELECT id_producto, nombre FROM productos WHERE tipo_producto = '$tipo'");
        while ($row = mysqli_fetch_assoc($res)) $arr[] = $row;
        return $arr;
    }
    $excursiones = getProductosPorTipo($conexion, 'Excursión');
    $estadias = getProductosPorTipo($conexion, 'Estadía');
    $boletos = getProductosPorTipo($conexion, 'Pasaje');
    $vehiculos = getProductosPorTipo($conexion, 'Alquiler de Vehículo');

    // Procesar formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre-producto']);
        $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
        $precio = floatval($_POST['precio-total']);
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo-producto']);

    
        $tipo_map = [
            'excursion' => 'Excursión',
            'hotel' => 'Estadía',
            'vuelo' => 'Pasaje',
            'vehiculo' => 'Alquiler de Vehículo',
            'paquete' => 'Paquete'
        ];
        $tipo_producto = isset($tipo_map[$tipo]) ? $tipo_map[$tipo] : $tipo;

        // Insertar en productos
        mysqli_query($conexion, "INSERT INTO productos (nombre, descripcion, precio, tipo_producto) VALUES ('$nombre', '$descripcion', $precio, '$tipo_producto')");
        $id_producto = mysqli_insert_id($conexion);

        // Insertar en tabla específica
        if ($tipo === 'excursion') {
            $ubicacion = mysqli_real_escape_string($conexion, $_POST['ubicacion-producto']);
            $duracion = intval($_POST['duracion']);
            $guia = isset($_POST['incluye_guia']) ? intval($_POST['incluye_guia']) : 0;
            $dificultad = mysqli_real_escape_string($conexion, $_POST['tipo-dificultad']);
            mysqli_query($conexion, "INSERT INTO excursiones (id_producto, ubicacion_salida, duracion, guia, dificultad) VALUES ($id_producto, '$ubicacion', $duracion, $guia, '$dificultad')");
        } elseif ($tipo === 'hotel') {
            $nombre_hotel = mysqli_real_escape_string($conexion, $_POST['nombre-hotel']);
            $localidad = mysqli_real_escape_string($conexion, $_POST['localidad-producto']);
            $servicios = mysqli_real_escape_string($conexion, $_POST['servicios']);
            $categoria = mysqli_real_escape_string($conexion, $_POST['tipo-categoria']);
            mysqli_query($conexion, "INSERT INTO estadias (id_producto, localidad, nombre_hotel, servicios, categoria) VALUES ($id_producto, '$localidad', '$nombre_hotel', '$servicios', '$categoria')");
        } elseif ($tipo === 'vuelo') {
            $origen = mysqli_real_escape_string($conexion, $_POST['origen-boleto']);
            $destino = mysqli_real_escape_string($conexion, $_POST['destino-boleto']);
            $aerolinea = mysqli_real_escape_string($conexion, $_POST['aereolina-boleto']);
            $tipo_pasaje = mysqli_real_escape_string($conexion, $_POST['tipo-boleto']);
            mysqli_query($conexion, "INSERT INTO pasajes (id_producto, origen, destino, aerolinea, tipo_pasaje) VALUES ($id_producto, '$origen', '$destino', '$aerolinea', '$tipo_pasaje')");
        } elseif ($tipo === 'vehiculo') {
            $marca = mysqli_real_escape_string($conexion, $_POST['marca-vehiculo']);
            $modelo = mysqli_real_escape_string($conexion, $_POST['modelo-vehiculo']);
            $capacidad = intval($_POST['capacidad-vehiculo']);
            $empresa = mysqli_real_escape_string($conexion, $_POST['empresa-rentadora-vehiculo']);
            $tipo_vehiculo = mysqli_real_escape_string($conexion, $_POST['tipo-vehiculo']);
            mysqli_query($conexion, "INSERT INTO vehiculos (id_producto, marca, modelo, capacidad, empresa_rentadora, tipo) VALUES ($id_producto, '$marca', '$modelo', $capacidad, '$empresa', '$tipo_vehiculo')");
        } elseif ($tipo === 'paquete') {
            // Insertar en paquetes
            mysqli_query($conexion, "INSERT INTO paquetes (id_producto) VALUES ($id_producto)");
            $id_paquete = mysqli_insert_id($conexion);

            // Insertar productos incluidos en detalle_paquete
            $productos_incluidos = [];
            if (!empty($_POST['excursion'])) $productos_incluidos[] = intval($_POST['excursion']);
            if (!empty($_POST['estadias'])) $productos_incluidos[] = intval($_POST['estadias']);
            if (!empty($_POST['boletos'])) $productos_incluidos[] = intval($_POST['boletos']);
            if (!empty($_POST['vehiculo'])) $productos_incluidos[] = intval($_POST['vehiculo']);
            foreach ($productos_incluidos as $id_prod) {
                mysqli_query($conexion, "INSERT INTO detalle_paquete (id_paquete, id_producto) VALUES ($id_paquete, $id_prod)");
            }
        }
        echo "<script>alert('Producto agregado correctamente');window.location.href='agregar-producto.php';</script>";
        exit;
    }
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>

<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/agregar-productos.css">

    <div class="cont-titulo-btn">
        <h2 class="subtitulo">Agregar productos</h2>
        <div class="cont-btns">
                <button class="btn agregar" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                        <path fill="currentColor" class="icon"
                            d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z" />
                    </svg>
                    Agregar
                </button>
                <button class="btn borrar" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
                    Eliminar
                </button>
        </div>
        </form>
    </div>
    
    <section class="section-agregar-productos">
        <div class="cont-formulario-general-producto">
            <form method="post" action="" class="frm-productos">
            <h2 class="subtitulo">Informacion general</h2>
            <div class="cont-input">
                <label for="tipo-producto" class="lbl">Tipo de producto:</label>
                <select id="tipo-producto" name="tipo-producto" class="input-producto">
                    <option value="excursion">Excursión</option>
                    <option value="hotel">Estadía</option>
                    <option value="vuelo">Pasaje</option>
                    <option value="vehiculo">Alquiler de Vehículo</option>
                    <option value="paquete">Paquete</option>
                </select>           
            </div>
            <div class="cont-input">
                <label for="nombre-producto" class="lbl">Nombre del producto</label>
                <input type="text" name="nombre-producto" id="nombre-producto" class="input-producto" maxlength=50 required>
            </div> 
            <div class="cont-input">
                <label for="descripcion" class="lbl">Descripción</label>
                <textarea class="input-producto" name="descripcion" id="descripcion" rows="3" maxlength="150"
                placeholder="Escribe una breve descripción" required></textarea>
            </div>
            <div class="cont-input">
                <label for="precio" class="lbl">Precio</label>
                <input class="input-producto" name="precio-total" type="number" required min="1" max="9999999999" step="0.01">
            </div>
            </form>
        </div>

        <div class="cont-formulario-especifico-producto excursiones oculto">
            <form method="post" action="" class="frm-productos">
            <h2 class="subtitulo">Informacion de la excursion</h2>
            <form method="post" action="" class="frm-productos">
            <div class="cont-input">
                <label for="ubicacion-producto" class="lbl">Ubicacion de salida</label>
                <input type="text" name="ubicacion-producto" id="ubicacion-producto" class="input-producto" maxlength=70>
            </div> 
            <div class="cont-input">
                <label for="duracion-producto" class="lbl">Duracion (EN HORAS)</label>
                <input class="input-producto" name="duracion" type="number" min="1" max="99999">
            </div> 
            <div class="cont-input">
                <label for="incluye_guia" class="lbl">¿Incluye guía?</label>
                <div class="seleccion-guia">
                    <label>
                        <input type="radio" name="incluye_guia" value="1"> Sí
                    </label>
                    <label>
                        <input type="radio" name="incluye_guia" value="0"> No     
                    </label>
                </div>
            </div>
            <div class="cont-input">
                <label for="tipo-dificultar" class="lbl" >Dificultar</label>
                <select id="tipo-dificultad" name="tipo-dificultad"  class="input-producto">
                    <option value="baja">Baja</option>
                    <option value="media">Media</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            </form>
        </div>

        <div class="cont-formulario-especifico-producto estadias oculto">
                    <form method="post" action="" class="frm-productos">
            <h2 class="subtitulo">Informacion de la estadia</h2>
            <div class="cont-input">
                <label for="nombre-hotel" class="lbl">Nombre del hotel</label>
                <input type="text" name="nombre-hotel" id="nombre-hotel" class="input-producto" maxlength=70>
            </div> 
            <div class="cont-input">
                <label for="localidad-producto" class="lbl">Localidad</label>
                <input type="text" name="localidad-producto" id="localidad-producto" class="input-producto" maxlength=70>
            </div> 
            <div class="cont-input">
                <label for="servicios" class="lbl">Servicios</label>
                <textarea class="input-producto" name="servicios" id="servicios" rows="3" maxlength="150"
                placeholder="Servicios que se incluyen"></textarea>
            </div>
            <div class="cont-input">
                <label for="tipo-categoria" class="lbl" >Categoria</label>
                <select id="tipo-categoria" name="tipo-categoria"  class="input-producto">
                    <option value="1">1 estrella</option>
                    <option value="2">2 estrellas</option>
                    <option value="3">3 estrellas</option>
                    <option value="4">4 estrellas</option>
                    <option value="5">5 estrellas</option>
                </select>
            </div>
            </form>
        </div>

        <div class="cont-formulario-especifico-producto boletos-avion oculto">
            <form method="post" action="" class="frm-productos">
            <h2 class="subtitulo">Informacion del botelo de avion</h2>
            <div class="cont-input">
                <label for="origen-boleto" class="lbl">Origen</label>
                <input type="text" name="origen-boleto" id="origen-boleto" class="input-producto" maxlength=70>
            </div> 
            <div class="cont-input">
                <label for="destino-boleto" class="lbl">Destino</label>
                <input type="text" name="destino-boleto" id="destino-boleto" class="input-producto" maxlength=70>
            </div> 
            <div class="cont-input">
                <label for="aereolina-boleto" class="lbl">Aereolinea</label>
                <input type="text" name="aereolina-boleto" id="aereolina-boleto" class="input-producto" maxlength=70>
            </div> 
            <div class="cont-input">
                <label for="tipo-boleto" class="lbl" >Tipo de boleto</label>
                <select id="tipo-boleto" name="tipo-boleto"  class="input-producto">
                    <option value="solo_ida">Solo ida</option>
                    <option value="ida_y_vuelta">Ida y vuelta</option>
                </select>
            </div>
            </form>
        </div>

        <div class="cont-formulario-especifico-producto vehiculo oculto">
            <form method="post" action="" class="frm-productos">
            <h2 class="subtitulo">Informacion del vehiculo</h2>
            <div class="cont-input">
                <label for="marca-vehiculo" class="lbl">Marca</label>
                <input type="text" name="marca-vehiculo" id="marca-vehiculo" class="input-producto" maxlength=70>
            </div> 
            <div class="cont-input">
                <label for="modelo-vehiculo" class="lbl">Modelo</label>
                <input type="text" name="modelo-vehiculo" id="modelo-vehiculo" class="input-producto" maxlength=50>
            </div> 
            <div class="cont-input">
                <label for="capacidad-vehiculo" class="lbl">Capacidad</label>
                <input class="input-producto" name="capacidad-vehiculo" type="number" min="1" max="99">
            </div> 
            <div class="cont-input">
                <label for="empresa-rentadora-vehiculo" class="lbl">Empresa rentadora</label>
                <input type="text" name="empresa-rentadora-vehiculo"  id="empresa-rentadora-vehiculo" class="input-producto" maxlength=50>
            </div> 
            <div class="cont-input">
                <label for="tipo-vehiculo" class="lbl">Tipo de vehículo</label>
                <select id="tipo-vehiculo" name="tipo-vehiculo" class="input-producto">
                    <option value="auto">Auto</option>
                    <option value="camioneta">Camioneta</option>
                    <option value="moto">Moto</option>
                    <option value="bus">Bus</option>
                    <option value="minibus">Minibús</option>
                    <option value="combi">Combi</option>
                    <option value="motorhome">Motorhome</option>
                    <option value="4x4">4x4</option>
                    <option value="cuatriciclo">Cuatriciclo</option>
                </select>
            </div>
            </form>
        </div>

        <div class="cont-formulario-especifico-producto paquete oculto">
            <form method="post" action="" class="frm-productos">
                <h2 class="subtitulo">Información del paquete</h2>
                <!-- Excursiones -->
                <div class="grupo-producto">
                    <label class="lbl">Excursiones incluidas</label>
                    <div class="contenedor-selecciones" id="productos-excursiones">
                        <div class="seleccion-producto">
                            <select name="excursion" class="input-producto input-total">
                                <option value="">Seleccionar excursión</option>
                                <?php foreach($excursiones as $ex): ?>
                                    <option value="<?= $ex['id_producto'] ?>"><?= htmlspecialchars($ex['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Estadías -->
                <div class="grupo-producto">
                    <label class="lbl">¿Incluir estadías?</label>
                    <div class="cont-checkbox">
                        <input type="checkbox" id="incluir-estadias" class="toggle-producto" data-target="estadias">
                        <label for="incluir-estadias">Sí</label>
                    </div>
                    <div class="contenedor-selecciones" id="productos-estadias">
                        <div class="seleccion-producto">
                            <select name="estadias" class="input-producto input-total">
                                <option value="">Seleccionar estadía</option>
                                <?php foreach($estadias as $es): ?>
                                    <option value="<?= $es['id_producto'] ?>"><?= htmlspecialchars($es['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Boletos -->
                <div class="grupo-producto">
                    <label class="lbl">¿Incluir boletos?</label>
                    <div class="cont-checkbox">
                        <input type="checkbox" id="incluir-boletos" class="toggle-producto" data-target="boletos">
                        <label for="incluir-boletos">Sí</label>
                    </div>
                    <div class="contenedor-selecciones" id="productos-boletos">
                        <div class="seleccion-producto">
                            <select name="boletos" class="input-producto input-total">
                                <option value="">Seleccionar boleto</option>
                                <?php foreach($boletos as $bo): ?>
                                    <option value="<?= $bo['id_producto'] ?>"><?= htmlspecialchars($bo['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Vehículos -->
                <div class="grupo-producto">
                    <label class="lbl">¿Incluir vehículos?</label>
                    <div class="cont-checkbox">
                        <input type="checkbox" id="incluir-vehiculos" class="toggle-producto" data-target="vehiculos">
                        <label for="incluir-vehiculos">Sí</label>
                    </div>
                    <div class="contenedor-selecciones" id="productos-vehiculos">
                        <div class="seleccion-producto">
                            <select name="vehiculo" class="input-producto input-total">
                                <option value="">Seleccionar vehículo</option>
                                <?php foreach($vehiculos as $ve): ?>
                                    <option value="<?= $ve['id_producto'] ?>"><?= htmlspecialchars($ve['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div style="visibility: hidden; height: 0; overflow: hidden;">
            <form method="post" action="" class="frm-productos">
                <button type="submit" class="btn agregar">Guardar producto</button>
            </form>
        </div>

    </section>


</main>

<script>
    
    document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.toggle-producto');

    const actualizarContenedor = (checkbox) => {
        const tipo = checkbox.dataset.target;
        const contenedor = document.getElementById('productos-' + tipo);

        if (checkbox.checked) {
            contenedor.style.display = 'block';
        } else {
            contenedor.style.display = 'none';
            const select = contenedor.querySelector('select');
            if (select) select.selectedIndex = 0;
        }
    };

    // Asigna eventos y aplica el estado inicial
    toggles.forEach(checkbox => {
        checkbox.addEventListener('change', () => actualizarContenedor(checkbox));
        actualizarContenedor(checkbox); // Estado inicial al cargar la página
    });
})
        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('tipo-producto');
        const formularios = document.querySelectorAll('.cont-formulario-especifico-producto');

        function mostrarFormularioSeleccionado() {
            const valor = select.value;
            formularios.forEach(form => form.classList.add('oculto'));
            if (valor === 'excursion') {
                document.querySelector('.cont-formulario-especifico-producto.excursiones').classList.remove('oculto');
            } else if (valor === 'hotel') {
                document.querySelector('.cont-formulario-especifico-producto.estadias').classList.remove('oculto');
            } else if (valor === 'vuelo') {
                document.querySelector('.cont-formulario-especifico-producto.boletos-avion').classList.remove('oculto');
            } else if (valor === 'vehiculo') {
                document.querySelector('.cont-formulario-especifico-producto.vehiculo').classList.remove('oculto');
            } else if (valor === 'paquete') {
                document.querySelector('.cont-formulario-especifico-producto.paquete').classList.remove('oculto');
            }
        }
        mostrarFormularioSeleccionado();
        select.addEventListener('change', mostrarFormularioSeleccionado);
        });

    document.addEventListener('DOMContentLoaded', function () {
        const btnGuardar = document.querySelector('form.frm-productos button[type="submit"]');
        const formGuardar = btnGuardar.closest('form');
        const selectTipo = document.getElementById('tipo-producto');
        const formularios = document.querySelectorAll('.frm-productos');

        formGuardar.addEventListener('submit', function (e) {
            // Elimina inputs ocultos previos para evitar duplicados en envíos múltiples
            Array.from(formGuardar.querySelectorAll('input[type="hidden"].copiado')).forEach(el => el.remove());

            // Solo copia los campos del formulario general y del formulario específico visible
            formularios.forEach(f => {
                // Solo el formulario general y el específico visible
                if (
                    f !== formGuardar &&
                    (
                        f.closest('.cont-formulario-general-producto') ||
                        (!f.closest('.oculto') && f.closest('.cont-formulario-especifico-producto'))
                    )
                ) {
                    Array.from(f.elements).forEach(el => {
                        if (!el.name || el.disabled) return;

                        // Evita duplicados
                        if (!formGuardar.querySelector(`[name="${el.name}"]`)) {
                            if (el.type === 'radio') {
                                // Solo el radio seleccionado
                                if (el.checked) {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = el.name;
                                    input.value = el.value;
                                    input.classList.add('copiado');
                                    formGuardar.appendChild(input);
                                }
                            } else if (el.type === 'checkbox') {
                                // Solo el checkbox seleccionado
                                if (el.checked) {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = el.name;
                                    input.value = el.value;
                                    input.classList.add('copiado');
                                    formGuardar.appendChild(input);
                                }
                            } else if (el.tagName === 'SELECT') {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = el.name;
                                input.value = el.value;
                                input.classList.add('copiado');
                                formGuardar.appendChild(input);
                            } else {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = el.name;
                                input.value = el.value;
                                input.classList.add('copiado');
                                formGuardar.appendChild(input);
                            }
                        }
                    });
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Botones de la cabecera
        const btnAgregar = document.querySelector('.cont-titulo-btn .btn.agregar');
        const btnEliminar = document.querySelector('.cont-titulo-btn .btn.borrar');
        const formGuardar = document.querySelector('form.frm-productos button[type="submit"]').closest('form');
        const formularios = document.querySelectorAll('.frm-productos');

        // Función para validar campos requeridos
        function validarCampos() {
            // Formularios a validar: general + específico visible
            const formulariosAValidar = [];
            formularios.forEach(f => {
                if (
                    f.closest('.cont-formulario-general-producto') ||
                    (!f.closest('.oculto') && f.closest('.cont-formulario-especifico-producto'))
                ) {
                    formulariosAValidar.push(f);
                }
            });

            for (const form of formulariosAValidar) {
                for (const el of form.elements) {
                    // Solo valida campos visibles y requeridos
                    if (
                        el.hasAttribute('required') &&
                        !el.disabled &&
                        el.offsetParent !== null // visible
                    ) {
                        if (el.type === 'checkbox' || el.type === 'radio') {
                            // Al menos uno debe estar seleccionado por grupo
                            const group = form.querySelectorAll(`[name="${el.name}"]`);
                            const checked = Array.from(group).some(e => e.checked);
                            if (!checked) {
                                el.focus();
                                return false;
                            }
                        } else if (el.tagName === 'SELECT') {
                            if (!el.value || el.value === '') {
                                el.focus();
                                return false;
                            }
                        } else if (!el.value || el.value.trim() === '') {
                            el.focus();
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        // AGREGAR: valida antes de enviar
        btnAgregar.addEventListener('click', function () {
            if (validarCampos()) {
                formGuardar.requestSubmit();
            } else {
                alert('Por favor, complete todos los campos obligatorios.');
            }
        });

        // ELIMINAR: limpia todos los inputs de todos los formularios
        btnEliminar.addEventListener('click', function () {
            formularios.forEach(form => {
                Array.from(form.elements).forEach(el => {
                    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                        if (el.type === 'checkbox' || el.type === 'radio') {
                            el.checked = false;
                        } else if (el.type === 'number' || el.type === 'text' || el.type === 'textarea') {
                            el.value = '';
                        }
                    } else if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    }
                });
            });
        });

        // También valida al enviar con el botón "Guardar producto"
        formGuardar.addEventListener('submit', function (e) {
            if (!validarCampos()) {
                e.preventDefault();
                alert('Por favor, complete todos los campos obligatorios.');
            }
        });
    });


</script>

</body>
</html>