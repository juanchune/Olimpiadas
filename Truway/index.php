<?php
session_start(); 
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/general/tags.php';
include('conexion.php');
?>
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/index.css">
    <header>
        <div class="capa-oscura"></div>
        <div class="contenido">
            <h2 class="titulo">Truway</h2>
            <p class="descripcion">Diseñá tu viaje perfecto eligiendo entre múltiples<br>experiencias y servicios turísticos</p>
        </div>
    </header>

    <section class="por-que-elegirnos">
        <div class="beneficios-grid">

            <div class="beneficio">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M9 5a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c2.67 0 8 1.34 8 4v2H1v-2c0-2.66 5.33-4 8-4m7.76-9.64c2.02 2.2 2.02 5.25 0 7.27l-1.68-1.69c.84-1.18.84-2.71 0-3.89zM20.07 2c3.93 4.05 3.9 10.11 0 14l-1.63-1.63c2.77-3.18 2.77-7.72 0-10.74z"/></svg>
                <h3>Soporte personalizado en todo momento</h3>
                <p>Te acompañamos antes, durante y después de tu viaje. Estamos disponibles por chat, WhatsApp y teléfono cuando nos necesites.</p>
            </div>

            <div class="beneficio">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon"  viewBox="0 0 24 24"><path class="icon"fill="currentColor" d="m12 17.275l-4.15 2.5q-.275.175-.575.15t-.525-.2t-.35-.437t-.05-.588l1.1-4.725L3.775 10.8q-.25-.225-.312-.513t.037-.562t.3-.45t.55-.225l4.85-.425l1.875-4.45q.125-.3.388-.45t.537-.15t.537.15t.388.45l1.875 4.45l4.85.425q.35.05.55.225t.3.45t.038.563t-.313.512l-3.675 3.175l1.1 4.725q.075.325-.05.588t-.35.437t-.525.2t-.575-.15z"/></svg>
                <h3>Confianza respaldada por viajeros</h3>
                <p>Somos recomendados por miles de usuarios satisfechos y reconocidos por plataformas de turismo y medios especializados.</p>
            </div>

            <div class="beneficio">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="icon"fill="currentColor" d="M7.75 2.5a.75.75 0 0 0-1.5 0v1.58c-1.44.115-2.384.397-3.078 1.092c-.695.694-.977 1.639-1.093 3.078h19.842c-.116-1.44-.398-2.384-1.093-3.078c-.694-.695-1.639-.977-3.078-1.093V2.5a.75.75 0 0 0-1.5 0v1.513C15.585 4 14.839 4 14 4h-4c-.839 0-1.585 0-2.25.013z"/><path class="icon" fill="currentColor" fill-rule="evenodd" d="M2 12c0-.839 0-1.585.013-2.25h19.974C22 10.415 22 11.161 22 12v2c0 3.771 0 5.657-1.172 6.828S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172S2 17.771 2 14zm15 2a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2m-4-5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m0 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-6-3a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2" clip-rule="evenodd"/></svg>
                <h3>Reservas simples y sin complicaciones</h3>
                <p>Confirmá tu experiencia en pocos pasos. Métodos de pago seguros y gestión 100% online desde cualquier dispositivo.</p>
            </div>

            <div class="beneficio">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="svg-icon" fill="currentColor" d="M13.5 16a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0"/><path class="icon" fill="currentColor" d="m14.347.66l3.18 4.456l2.097-.715L21.538 10h.962v12h-21V10h.51v-.01l.648.006zM9.397 10h10.028l-1.037-3.033l-1.522.487zM7.839 8.417L15.55 5.79l-1.604-2.25zM5.5 12h-2v2a2 2 0 0 0 2-2m10 4a3.5 3.5 0 1 0-7 0a3.5 3.5 0 0 0 7 0m5 4v-2a2 2 0 0 0-2 2zm-2-8a2 2 0 0 0 2 2v-2zm-15 8h2a2 2 0 0 0-2-2z"/></svg>

                <h3>Calidad al mejor precio</h3>
                <p>Ofrecemos tarifas competitivas sin sacrificar la calidad. Controlamos nuestros precios para darte siempre la mejor opción.</p>
            </div>

        </div>
    </section>

    <section class="nuestras-propuestas">
        <h2>Explorá nuestras propuestas</h2>
        <div class="productos-grid">
           <?php
                $productos_query = "SELECT * FROM `productos`";
                $productos_result = mysqli_query($conexion, $productos_query);

                $contador = 0;

                if (mysqli_num_rows($productos_result) > 0) {
                    while ($fila = mysqli_fetch_assoc($productos_result)) {
                        if ($contador >= 6) break; 

                        // Buscar la duración
                        $duracion = "";
                        if ($fila['tipo_producto'] == "Excursión") {
                            $id_producto = $fila['id_producto'];
                            $buscarDuracion_query = "SELECT duracion FROM `excursiones` WHERE id_producto='$id_producto'";
                            $buscarDuracion_result = mysqli_query($conexion, $buscarDuracion_query);
                            if (mysqli_num_rows($buscarDuracion_result) > 0) {
                                $row = mysqli_fetch_assoc($buscarDuracion_result);
                                $duracion = $row['duracion'];
                            }
                        }
                        ?>
                        <article class="producto">
                            <h5 class="nombre-producto"><?php echo $fila['nombre'] ?></h5>
                            <div class="cont-categoria-precio">
                                <div class="categoria">
                                    <?php filtrarTags($fila['tipo_producto']) ?>
                                    <span><?php echo $fila['tipo_producto'] ?></span>
                                </div>
                                <span class="precio">$<?php echo $fila['precio'] ?></span>
                            </div>

                            <p class="descripcion-producto"><?php echo $fila['descripcion'] ?></p>
                            <div class="cont-tiempo-btn">
                                <?php if (!empty($duracion)) { ?>
                                    <div class="cont-tiempo">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                                            <path class="svg-icon" fill="currentColor"
                                                d="M11.5 3a9.5 9.5 0 0 1 9.5 9.5a9.5 9.5 0 0 1-9.5 9.5A9.5 9.5 0 0 1 2 12.5A9.5 9.5 0 0 1 11.5 3m0 1A8.5 8.5 0 0 0 3 12.5a8.5 8.5 0 0 0 8.5 8.5a8.5 8.5 0 0 0 8.5-8.5A8.5 8.5 0 0 0 11.5 4M11 7h1v5.42l4.7 2.71l-.5.87l-5.2-3z"/>
                                        </svg>
                                        <span class="tiempo"><?php echo $duracion ?></span>
                                    </div>
                                <?php } ?>
                                <button class="btn-ver-mas">Ver más</button>
                            </div>
                        </article>
                        <?php
                        $contador++; 
                    }
                }
            ?>
        </div>
        <div class="cont-btn">
            <a href="php/cliente/catalogo.php" class="btn-explorar-mas">Explorar mas opciones</a>
        </div>
    </section>
    </main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php';
?>