    <div class="cont-filtros">
        <form method="get" action="" class="form-filtros">
            <input type="hidden" name="tabla_seleccionada" value="<?= htmlspecialchars($tabla_seleccionada) ?>">
            <div class="filtros">
                <select class="select-filtro" name="dificultad">
                    <option value="" disabled selected>Seleccione una dificultad</option>
                    <option value="baja">Baja</option>
                    <option value="media">Media</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <button class="btn-filtrar" name="filtrar">Filtrar</button>
        </form>
    </div>

    <section class="section-tabla-productos excursiones">
        <!-- Información principal fija como guía -->
        <article class="producto guia">
            <div class="informacion-principal">
                <div class="informacion">
                    <span class="lbl-informacion">ID EXCURSION</span>
                    <span class="lbl-informacion">ID PRODUCTO</span>
                    <span class="lbl-informacion">UBICACIÓN SALIDA</span>
                    <span class="lbl-informacion">DURACIÓN</span>
                    <span class="lbl-informacion">GUÍA</span>
                    <span class="lbl-informacion">DIFICULTAD</span>
                    <span class="lbl-informacion">ACCIONES</span>
                </div>
            </div>
        </article>

        <!-- Excursiones dinámicas -->
        <?php while ($dato = mysqli_fetch_assoc($result)) { ?>
            <article class="producto">
                <div class="informacion-principal">
                    <div class="informacion">
                        <span class="lbl-informacion"><?= $dato['id_excursion'] ?></span>
                        <span class="lbl-informacion"><?= $dato['id_producto'] ?></span>
                        <span class="lbl-informacion"><?= $dato['ubicacion_salida'] ?></span>
                        <span class="lbl-informacion"><?= $dato['duracion'] ?></span>
                        <span class="lbl-informacion"><?= $dato['guia'] ? 'Sí' : 'No' ?></span>
                        <span class="lbl-informacion"><?= $dato['dificultad'] ?></span>
                         <div class="btns">
                        <button class="btn-modificar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path stroke="currentColor" class="icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0z" />
                                    <path class="icon" fill="currentColor" d="m5 16l-1 4l4-1L18 9l-3-3z" />
                                    <path class="icon" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m15 6l3 3m-5 11h8" />
                                </g>
                            </svg>
                        </button>
                        <button class="btn-eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path class="icon" fill="currentColor"
                                    d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zm3-4q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17" />
                            </svg>
                        </button>
                    </div>
                    </div>
                </div>
            </article>
        <?php } ?>
    </section>