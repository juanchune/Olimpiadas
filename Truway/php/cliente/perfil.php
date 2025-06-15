<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/general/tags.php';
include('conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header("Location: /Olimpiadas/Truway/php/general/iniciar-sesion.php");
exit();
}
/*Obtiene nombre y apellido para mostrarlos*/
$id_usuario = (int)$_SESSION['id'];
$query_usuario = "SELECT nombre, apellido FROM usuarios WHERE id_usuario = $id_usuario";
$resultado_usuario = mysqli_query($conexion, $query_usuario);

if ($resultado_usuario) {
    $fila = mysqli_fetch_assoc($resultado_usuario);
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
}

// Consultar los pedidos del usuario
// // Inicializar listas de pedidos
// $pendientes = [];
// $aprobados = [];
// $rechazados = [];

// // Clasificar los pedidos según su estado
// while ($pedido = mysqli_fetch_assoc($resultado)) {
//     switch ($pedido['estado']) {
//         case 'pendiente':
//             $pendientes[] = $pedido;
//             break;
//         case 'aprobado':
//             $aprobados[] = $pedido;
//             break;
//         case 'rechazado':
//             $rechazados[] = $pedido;
//             break;
//     }
// }
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/perfil.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
    $tipo_pedido=""; 
    ?>

    <section class="section-informacion-user">
        <span class="nombre-apellido"><?php echo $nombre ?> <?php echo $apellido ?></span>
    </section>
    <h2 class="subtitulo">Mis pedidos</h2>
    <section class="section-pedidos-realizados">
        <div class=cont-filtros>
                <h2 class="subtitulo">Tipo de pedido</h2>
                <div class="seleccionar-tipo-pedido">
                    <a href="perfil.php?tipo_pedido=" class="tipo-pedido todos">Todos</a>
                    <a href="perfil.php?tipo_pedido=aprobados" class="tipo-pedido aprobados">Aprobados</a>
                    <a href="perfil.php?tipo_pedido=pendientes" class="tipo-pedido pendientes">Pendientes
                    </a>
                    <a href="perfil.php?tipo_pedido=rechazados" class="tipo-pedido rechazados">Rechazados</a>
                </div>
        </div>

        <div class="pedidos">
            <?php
                $tipo_pedido = isset($_GET['tipo_pedido']) ? $_GET['tipo_pedido'] : "";
                $pedidos_result = null;

                if ($tipo_pedido === "") {
                    //Sin filtros
                    $pedidos_query = "SELECT * FROM `pedidos` WHERE id_usuario='$id_usuario' ORDER BY fecha DESC";
                    $pedidos_result = mysqli_query($conexion, $pedidos_query);

                } else {
                    //Si tiene filtros seleciconamos la tabla
                    $tabla_filtro = "";
                    if ($tipo_pedido === "aprobados") {
                        $tabla_filtro = "pedidos_aprobados";

                    } elseif ($tipo_pedido === "pendientes") {
                        $tabla_filtro = "pedidos_pendientes";
                        
                    }elseif ($tipo_pedido === "rechazados") {
                        $tabla_filtro = "pedidos_rechazados";
                    }

                    if ($tabla_filtro !== "") {
                        //Sacamos los ids de pedidos desde la tabla de filtro
                        $filtro_query = "SELECT id_pedido FROM `$tabla_filtro`";
                        $filtro_result = mysqli_query($conexion, $filtro_query);

                        if (mysqli_num_rows($filtro_result) > 0) {
                            $ids = [];

                            while ($row = mysqli_fetch_assoc($filtro_result)) {
                                $ids[] = $row['id_pedido'];
                            }

                            //Juntamos los valor obtenidos en una cadena de texto y los separo por ,. Ademas convertimos los ids en enteros
                            $ids_lista = implode(",", array_map('intval', $ids)); 

                            //Traemos los pedidos que correspondan 
                            $pedidos_query = "SELECT * FROM `pedidos` WHERE id_usuario='$id_usuario' AND id_pedido IN ($ids_lista) ORDER BY fecha DESC";
                            $pedidos_result = mysqli_query($conexion, $pedidos_query);
                        }
                    }
                }
            if ($pedidos_result && mysqli_num_rows($pedidos_result) > 0) {

                $ids_pendientes = [];
                $ids_aprobados = [];
                $ids_rechazados = [];

                $consulta_pendientes = mysqli_query($conexion, "SELECT id_pedido FROM pedidos_pendientes");
                while ($row = mysqli_fetch_assoc($consulta_pendientes)) {
                    $ids_pendientes[] = $row['id_pedido'];
                }

                $consulta_aprobados = mysqli_query($conexion, "SELECT id_pedido FROM pedidos_aprobados");
                while ($row = mysqli_fetch_assoc($consulta_aprobados)) {
                    $ids_aprobados[] = $row['id_pedido'];
                }

                $consulta_rechazados = mysqli_query($conexion, "SELECT id_pedido FROM pedidos_rechazados");
                while ($row = mysqli_fetch_assoc($consulta_rechazados)) {
                    $ids_rechazados[] = $row['id_pedido'];
                }
                
                ?><div class="grid-pedidos"> <?php 
                //todos los resultados y los guardamos en al array
                while ($pedido = mysqli_fetch_assoc($pedidos_result)) {
                    $id_pedido = $pedido['id_pedido'];
                    $estado = "Indefinido"; //

                    if (in_array($id_pedido, $ids_pendientes)) {
                        $estado = "Pendiente";
                            } elseif (in_array($id_pedido, $ids_aprobados)) {
                                $estado = "Aprobado";
                            } elseif (in_array($id_pedido, $ids_rechazados)) {
                                $estado = "Rechazado";
                            }?>

                        <article class="tarjeta-pedido pendiente">
                            <div class="cont-datos-pedido">
                                <div class="cont-informacion">
                                    <span class="lbl">ID Orden</span>
                                    <span class="lbl-informacion id"><?php echo $pedido['id_pedido']?></span>
                                </div>
                                <div class="cont-informacion">
                                    <span class="lbl">Total</span>
                                    <span class="lbl-informacion total"><?php echo $pedido['precio_total']?></span>
                                </div>
                                <div class="cont-informacion">
                                    <span class="lbl">Tipo de pago</span>
                                    <span class="lbl-informacion pago"><?php echo $pedido['metodo_pago']?></span>
                                </div>
                                <div class="cont-informacion">
                                    <span class="lbl">Fecha pedido</span>
                                    <span class="lbl-informacion fecha"><?php echo $pedido['fecha']?></span>
                                </div>
                                <div class="cont-informacion">
                                    <span class="lbl">Cantidad de productos</span>
                                    <span class="lbl-informacion catn-productos"><?php echo $pedido['cantidad']?></span>
                                </div>
                                <div class="cont-informacion">
                                    <span class="lbl">Estado</span>
                                <span class="lbl-informacion"><?php echo $estado; ?></span>
                                </div>
                            </div>

                            <div class="grid-productos">
                                <?php
                                    //En entero para asegurar :o
                                    $id_pedido = intval($id_pedido);

                                    $query = "
                                        SELECT dp.id_producto, dp.fecha, dp.cantidad, p.nombre, p.precio, p.tipo_producto
                                        FROM detalle_pedido dp
                                        JOIN productos p ON dp.id_producto = p.id_producto
                                        WHERE dp.id_pedido = $id_pedido
                                    ";

                                    $result = mysqli_query($conexion, $query);

                                    while ($producto = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <article class="producto">
                                            <div class="cont-superior">
                                                <div class="cont-tag">
                                                    <div class="tag">
                                                        <?php filtrarTags($producto['tipo_producto']);?>
                                                        <span class="nombre-tag"><?php echo $producto['tipo_producto']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="cont-grid-titulo-btns">
                                                    <h3><?php echo $producto['nombre']; ?></h3>
                                                    <div class="cont-btns">
                                                        <?php if($estado == "Pendientes")?>
                                                        <button class="btn modificar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M20.71 7.04c-.34.34-.67.67-.68 1c-.03.32.31.65.63.96c.48.5.95.95.93 1.44s-.53 1-1.04 1.5l-4.13 4.14L15 14.66l4.25-4.24l-.96-.96l-1.42 1.41l-3.75-3.75l3.84-3.83c.39-.39 1.04-.39 1.41 0l2.34 2.34c.39.37.39 1.02 0 1.41M3 17.25l9.56-9.57l3.75 3.75L6.75 21H3z"/></svg>
                                                        </button>
                                                        <button class="btn borrar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cont-inferior">
                                                <div class="cont-datos-especificos">
                                                    <div class="cont-lbls">
                                                        <span class="lbl-nombre">Fecha:</span>
                                                        <span class="lbl-nombre">Personas:</span>
                                                    </div>
                                                    <div class="cont-informacion">
                                                        <span class="informacion fecha"><?php echo $producto['fecha']; ?></span>
                                                        <span class="informacion personas"><?php echo $producto['cantidad']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="cont-importe">
                                                    <span class="importe">$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2, ',', '.'); ?></span>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                ?>
                                </div>
                        </article>
                <?php } ?>
            <?php }?>
        </div> 
    </section>
</main>
<script>
    // Envía automáticamente el formulario cuando se hace click en un checkbox
    document.querySelectorAll('.filtros input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>