<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/general/tags.php';
include('conexion.php');

?>
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';
    $tipo_producto = "";
    ?>
    
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/catalogo.css">
    <section class="section-catalogo">
        <div class=cont-filtros>
            <h2 class="subtitulo">Tipo de producto</h2>
            <div class="seleccionar-tipo-producto">
                <a href="catalogo.php?tipo_producto=" class="tipo-producto todos">
                    <?php filtrarTags("Todos");?>
                    Todos</a>
                <a href="catalogo.php?tipo_producto=Paquete" class="tipo-producto paquetes">
                    <?php filtrarTags("Paquete");?>
                    Paquetes</a>
                <a href="catalogo.php?tipo_producto=Excursion" class="tipo-producto excursiones">
                    <?php filtrarTags("Excursión");?>
                    Excrusiones
                </a>
                <a href="catalogo.php?tipo_producto=Estadia" class="tipo-producto estadias">
                    <?php filtrarTags("Estadía");?>
                    Estadias</a>
                <a href="catalogo.php?tipo_producto=Pasaje" class="tipo-producto boletos_avion">
                    <?php filtrarTags("Pasaje");?>
                    Boletos de avion
                </a>
                <a href="catalogo.php?tipo_producto=Alquiler de Vehiculo" class="tipo-producto vehiculos"> 
                    <?php filtrarTags("Alquiler de Vehículo");?>
                    Vehiculos
                </a>
            </div>
        </div>
        <div class="productos-grid">
            <?php
                $tipo_producto = isset($_GET['tipo_producto']) ? $_GET['tipo_producto'] : "";

                if ($tipo_producto === "") {
                    $productos_query = "SELECT * FROM `productos`";
                } else {
                    $productos_query = "SELECT * FROM `productos` WHERE tipo_producto='$tipo_producto'";
                }

                $productos_result = mysqli_query($conexion, $productos_query);

                if (mysqli_num_rows($productos_result) > 0) {

                    while ($fila = mysqli_fetch_assoc($productos_result)) {
                        //Buscar la duracion
                        $duracion="";
                        if($fila['tipo_producto']=="Excursión"){
                            $id_producto=$fila['id_producto'];
                            $buscarDuracion_query="SELECT duracion FROM `excursiones` WHERE id_producto='$id_producto'";
                            $buscarDuracion_result= mysqli_query($conexion, $buscarDuracion_query);
                            if(mysqli_num_rows($buscarDuracion_result)>0){
                                $row = mysqli_fetch_assoc($buscarDuracion_result);
                                $duracion = $row['duracion'];
                            }
                        }
                        ?>
                    <article class="producto">
                        <h5 class="nombre-producto"><?php echo $fila['nombre']?></h5>
                        <div class="cont-categoria-precio">
                            <div class="categoria">
                                <?php filtrarTags($fila['tipo_producto'])?>
                                <span><?php echo $fila ['tipo_producto']?></span>
                            </div>
                            <span class="precio">$<?php echo $fila['precio']?></span>
                        </div>

                        <p class="descripcion-producto"><?php echo $fila['descripcion']?></p>
                        <div class="cont-tiempo-btn">
                            <?php
                                if (!empty($duracion)) {?>
                                     <div class="cont-tiempo">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="svg-icon" fill="currentColor" d="M11.5 3a9.5 9.5 0 0 1 9.5 9.5a9.5 9.5 0 0 1-9.5 9.5A9.5 9.5 0 0 1 2 12.5A9.5 9.5 0 0 1 11.5 3m0 1A8.5 8.5 0 0 0 3 12.5a8.5 8.5 0 0 0 8.5 8.5a8.5 8.5 0 0 0 8.5-8.5A8.5 8.5 0 0 0 11.5 4M11 7h1v5.42l4.7 2.71l-.5.87l-5.2-3z"/></svg>
                                        <span class="tiempo"><?php echo $duracion?></span>
                                    </div>
                               <?php }
                            ?>
                            <form method="get" action="producto-especifico.php" class="frm-btn-envar">
                                <input type="hidden" name="id" id="id" value="<?php echo $fila['id_producto']; ?>">
                                <button class="btn-ver-mas">Ver más</button>
                            </form>
                        </div>
                    </article>
                    <?php
                    }
                }
            ?>
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

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php';
?>