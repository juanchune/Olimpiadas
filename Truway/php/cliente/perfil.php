<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo "Debes iniciar sesión para ver tus pedidos.";
    exit;
}

$id_usuario = $_SESSION['id'];

// Consultar los pedidos del usuario
$query = "SELECT * FROM pedidos WHERE id_usuario = $id_usuario ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error al consultar los pedidos: " . mysqli_error($conexion));
}

// Inicializar listas de pedidos
$pendientes = [];
$aprobados = [];
$rechazados = [];

// Clasificar los pedidos según su estado
while ($pedido = mysqli_fetch_assoc($resultado)) {
    switch ($pedido['estado']) {
        case 'pendiente':
            $pendientes[] = $pedido;
            break;
        case 'aprobado':
            $aprobados[] = $pedido;
            break;
        case 'rechazado':
            $rechazados[] = $pedido;
            break;
    }
}
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/perfil.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; ?>
    <section class="perfil-pedidos">
        <h2>Mis Pedidos</h2>

        <div class="lista-pedidos">
            <h3>Pendientes</h3>
            <?php if (empty($pendientes)): ?>
                <p>No tienes pedidos pendientes.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($pendientes as $pedido): ?>
                        <li>
                            Pedido #<?php echo $pedido['id_pedido']; ?> - Fecha: <?php echo $pedido['fecha']; ?> - Total: $<?php echo number_format($pedido['precio_total'], 2); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="lista-pedidos">
            <h3>Aprobados</h3>
            <?php if (empty($aprobados)): ?>
                <p>No tienes pedidos aprobados.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($aprobados as $pedido): ?>
                        <li>
                            Pedido #<?php echo $pedido['id_pedido']; ?> - Fecha: <?php echo $pedido['fecha']; ?> - Total: $<?php echo number_format($pedido['precio_total'], 2); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="lista-pedidos">
            <h3>Rechazados</h3>
            <?php if (empty($rechazados)): ?>
                <p>No tienes pedidos rechazados.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($rechazados as $pedido): ?>
                        <li>
                            Pedido #<?php echo $pedido['id_pedido']; ?> - Fecha: <?php echo $pedido['fecha']; ?> - Total: $<?php echo number_format($pedido['precio_total'], 2); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>