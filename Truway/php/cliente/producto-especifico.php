<?php
session_start(); 
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');

$tipoProducto = 'paquete';

if($tipoProducto == 'paquete'){
    $incluyePasaje = true;
    $incluyeVehiculo = false;
    $incluyeEstadia = true;
}
?>
<link rel="stylesheet" href="/Olimpiadas/Truway/css/producto-especifico.css">
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
    <section class="producto-especifico">
        <div class="cont-general">
                <h2 class="nombre">
                    Paquete Cataratas Del Iguazu Clásico - Descubre La Maravilla Natural En Iguazu Ar Con Tangol Tours
                </h2>
                <span class="descripcion">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laboriosam, fuga alias sed corrupti cumque architecto atque quidem explicabo exercitationem necessitatibus earum at tempora? Beatae in enim exercitationem impedit, ea dignissimos!</span>
                <h6 class=precio-unitario>ARS $1000.00000.00000.000000</h6>
                <a href="#reserva" class=btn-realizar-reserva>
                    Realizar reserva
                </a>
        </div>
        <div class="informacion-especifica <?php echo 'info-' . $tipoProducto; ?>">

    <?php if ($tipoProducto === 'pasaje'): ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Origen</span>
            <span class="dato">Perú</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Destino</span>
            <span class="dato">Argentina</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Aerolínea</span>
            <span class="dato">LATAM Airlines</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Tipo pasaje</span>
            <span class="dato">Ida y vuelta</span>
        </div>
    <?php elseif ($tipoProducto === 'vehiculo'): ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Marca</span>
            <span class="dato">Toyota</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Capacidad</span>
            <span class="dato">5</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Empresa rentadora</span>
            <span class="dato">Masharrda-SRL</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Tipo</span>
            <span class="dato">4x4</span>
        </div>
    <?php elseif ($tipoProducto === 'excursion'): ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Ubicacion salida</span>
            <span class="dato">Neochea</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Duracion</span>
            <span class="dato">2 horas</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Guia</span>
            <span class="dato">Si</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Dificultad</span>
            <span class="dato">Baja</span>
        </div>
     <?php elseif ($tipoProducto === 'estadia'): ?>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Localidad</span>
            <span class="dato">Quequen</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Nombre hotel</span>
            <span class="dato">Francis sonrisas</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Servicios</span>
            <span class="dato">Desayuno, wifi, estacionamiento y abrazos</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Categoria</span>
            <span class="dato">5 estrellas</span>
        </div>

    <?php elseif ($tipoProducto === 'paquete'): ?>
    <h4 class="subtitulo">Excursión</h4>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Ubicación salida</span>
        <span class="dato">Necochea</span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Duración</span>
        <span class="dato">2 horas</span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Guía</span>
        <span class="dato">Sí</span>
    </div>
    <div class="informacion-producto">
        <span class="lbl-tipo-dato">Dificultad</span>
        <span class="dato">Baja</span>
    </div>

    <!--Pasajes -->
    <?php if (!empty($incluyePasaje)): ?>
        <h4 class="subtitulo">Pasajes</h4>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Origen</span>
            <span class="dato">Perú</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Destino</span>
            <span class="dato">Argentina</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Aerolínea</span>
            <span class="dato">LATAM Airlines</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Tipo pasaje</span>
            <span class="dato">Ida y vuelta</span>
        </div>
    <?php endif; ?>

    <!--Vehculo -->
    <?php if (!empty($incluyeVehiculo)): ?>
        <h4 class="subtitulo">Vehículo</h4>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Marca</span>
            <span class="dato">Toyota</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Capacidad</span>
            <span class="dato">5</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Empresa rentadora</span>
            <span class="dato">Masharrda-SRL</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Tipo</span>
            <span class="dato">4x4</span>
        </div>
    <?php endif; ?>

    <!--Estadia -->
    <?php if (!empty($incluyeEstadia)): ?>
        <h4 class="subtitulo" class="subtitulo">Estadía</h4>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Localidad</span>
            <span class="dato">Quequén</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Nombre hotel</span>
            <span class="dato">Francis Sonrisas</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Servicios</span>
            <span class="dato">Desayuno, wifi, estacionamiento y abrazos</span>
        </div>
        <div class="informacion-producto">
            <span class="lbl-tipo-dato">Categoría</span>
            <span class="dato">5 estrellas</span>
        </div>
    <?php endif; ?>
<?php endif; ?>
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
        </form>

        </div>
    </section>

</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const enlaceReserva = document.querySelector('.btn-realizar-reserva');
    const seccionReserva = document.getElementById('reserva');

    enlaceReserva.addEventListener('click', function () {
      seccionReserva.classList.add('resaltar');

      // Remover la clase despues de que termine la animacion
      setTimeout(() => {
        seccionReserva.classList.remove('resaltar');
      }, 1500);
    });
  });
</script>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php'; ?>