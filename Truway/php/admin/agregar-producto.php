<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/agregar-productos.css">
    <div class="cont-titulo-btn">
            <h2 class="subtitulo">Agregar productos</h2>
            <div class="cont-btns">
                <button class="btn agregar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                        <path fill="currentColor" class="icon"
                            d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z" />
                    </svg>
                    Agregar
                </button>
                <button class="btn borrar">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="svg-icon" viewBox="0 0 24 24"><path class="icon" fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
                    Eliminar
                </button>
            </div>
        </div>
   <section class="section-agregar-productos">
    <div class="cont-formulario-general-producto">
        <h2 class="subtitulo">Informacion general</h2>
        <form method="post" action="" class="frm-productos">
            <div class="cont-input">
                <label for="tipo-producto" class="lbl">Tipo de producto:</label>
                <select id="tipo-producto" name="tipo-producto" class="input-producto">
                    <option value="excursion">Excursión</option>
                    <option value="hotel">Estadia</option>
                    <option value="vuelo">Boleto de avión</option>
                    <option value="vehiculo">Vehículo</option>
                    <option value="paquete">Paquetes</option>
                </select>           
            </div>
            <div class="cont-input">
                <label for="nombre-producto" class="lbl">Nombre del producto</label>
                <input type="text" name="nombre-producto" id="nombre-producto" class="input-producto" maxlength=50 require>
            </div> 
            <div class="cont-input">
                <label for="descripcion" class="lbl">Descripción</label>
                <textarea class="input-producto" name="descripcion" id="descripcion" rows="3" maxlength="150"
                placeholder="Escribe una breve descripción" required></textarea>
            </div>
            <div class="cont-input">
                <label for="precio" class="lbl">Precio</label>
                <input class="input-producto"name="precio-total" type="number" required min="1" max="9999999999" step="0.01">
            </div>
        </form>
    </div>
    <div class="cont-formulario-especifico-producto excursiones oculto">
        <h2 class="subtitulo">Informacion de la excursion</h2>
        <form method="post" action="" class=frm-productos>
            <div class="cont-input">
                <label for="ubicacion-producto" class="lbl">Ubicacion de salida</label>
                <input type="text" name="ubicacion-producto" id="ubicacion-producto" class="input-producto" maxlength=70 require>
            </div> 
            <div class="cont-input">
                <label for="duracion-producto" class="lbl">Duracion (EN HORAS)</label>
                <input class="input-producto" name="duracion" type="number" required min="1" max="99999">
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
        <h2 class="subtitulo">Informacion de la estadia</h2>
        <form method="post" action="" class=frm-productos>
            <div class="cont-input">
                <label for="nombre-hotel" class="lbl">Nombre del hotel</label>
                <input type="text" name="nombre-hotel" id="nombre-hotel" class="input-producto" maxlength=70 require>
            </div> 
            <div class="cont-input">
                <label for="localidad-producto" class="lbl">Localidad</label>
                <input type="text" name="localidad-producto" id="localidad-producto" class="input-producto" maxlength=70 require>
            </div> 

              <div class="cont-input">
                <label for="servicios" class="lbl">Servicios</label>
                <textarea class="input-producto" name="servicios" id="servicios" rows="3" maxlength="150"
                placeholder="Servicios que se incluyen" required></textarea>
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
        <h2 class="subtitulo">Informacion del botelo de avion</h2>
        <form method="post" action="" class=frm-productos>
            <div class="cont-input">
                <label for="origen-boleto" class="lbl">Origen</label>
                <input type="text" name="origen-boleto" id="origen-boleto" class="input-producto" maxlength=70 require>
            </div> 
            <div class="cont-input">
                <label for="destino-boleto" class="lbl">Destino</label>
                <input type="text" name="destino-boleto" id="destino-boleto" class="input-producto" maxlength=70 require>
            </div> 

            <div class="cont-input">
                <label for="aereolina-boleto" class="lbl">Aereolinea</label>
                <input type="text" name="aereolina-boleto" id="aereolina-boleto" class="input-producto" maxlength=70 require>
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
        <h2 class="subtitulo">Informacion del vehiculo</h2>
        <form method="post" action="" class=frm-productos>
            <div class="cont-input">
                <label for="marca-vehiculo" class="lbl">Marca</label>
                <input type="text" name="marca-vehiculo" id="marca-vehiculo" class="input-producto" maxlength=70 require>
            </div> 
            <div class="cont-input">
                <label for="modelo-vehiculo" class="lbl">Modelo</label>
                <input type="text" name="modelo-vehiculo" id="modelo-vehiculo" class="input-producto" maxlength=50 require>
            </div> 

            <div class="cont-input">
                <label for="capacidad-vehiculo" class="lbl">Capacidad</label>
                <input class="input-producto" name="capacidad-vehiculo" type="number" required min="1" max="99">
            </div> 

            <div class="cont-input">
                <label for="empresa-rentadora-vehiculo" class="lbl">Empresa rentadora</label>
                <input type="text" name="empresa-rentadora-vehiculo"  id="empresa-rentadora-vehiculo" class="input-producto" maxlength=50 require>
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

<div class="cont-formulario-especifico-producto paquete">
    <h2 class="subtitulo">Información del paquete</h2>
    <form method="post" action="" class="frm-productos">

    <!-- Excursiones (siempre visible) -->
    <div class="grupo-producto">
        <label class="lbl">Excursiones incluidas</label>
        <div class="contenedor-selecciones" id="productos-excursiones">
            <div class="seleccion-producto">
            <select name="excursion" class="input-producto input-total" required>
                <option value="">Seleccionar excursión</option>
                <option value="1">Tour por Cataratas</option>
                <option value="2">Excursión al Glaciar</option>
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
                    <option value="1">Hotel Plaza - 3 noches</option>
                    <option value="2">Hostel Sur - 2 noches</option>
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
                    <option value="1">Avión - Buenos Aires → Madrid</option>
                    <option value="2">Bus - Mendoza → Córdoba</option>
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
                    <option value="1">Auto - Toyota Corolla</option>
                    <option value="2">Camioneta - Ford Ranger</option>
                </select>
            </div>
        </div>
    </div>

    </form>
</div>




    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Excursiones siempre visibles, no toca nada ahí

  // Obtengo todos los checkboxes que controlan los selects
  const toggles = document.querySelectorAll('.toggle-producto');

  toggles.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
      const tipo = checkbox.dataset.target;
      const contenedor = document.getElementById('productos-' + tipo);

      if (checkbox.checked) {
        contenedor.style.display = 'block';
      } else {
        contenedor.style.display = 'none';

        // Limpio el select correspondiente al ocultar
        const select = contenedor.querySelector('select');
        if (select) {
          select.selectedIndex = 0; // vuelve a la opción vacía
        }
      }
    });
  });

  // Al cargar la página, aplico el estado inicial (por si están marcados algunos)
  toggles.forEach(checkbox => {
    const tipo = checkbox.dataset.target;
    const contenedor = document.getElementById('productos-' + tipo);

    if (checkbox.checked) {
      contenedor.style.display = 'block';
    } else {
      contenedor.style.display = 'none';

      const select = contenedor.querySelector('select');
      if (select) {
        select.selectedIndex = 0;
      }
    }
  });
});
</script>

<script>

  // Mostrar formulario específico según el select
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

</script>



    

</body>
</html>