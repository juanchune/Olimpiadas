<?php
session_start();
?><link rel="stylesheet" href="/Olimpiadas/Truway/css/carrito.css"><?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/catalogo.css">
    <section class=section-catalogo>
        <div class=filtros>

        </div>
        <article class="grid-productos">
            <article>
    </section>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php';
?>