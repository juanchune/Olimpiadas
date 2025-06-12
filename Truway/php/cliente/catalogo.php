<?php
session_start();
?><link rel="stylesheet" href="/Olimpiadas/Truway/css/carrito.css"><?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>
<main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php';?>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/catalogo.css">
    <section class="section-catalogo">
        <div class=cont-filtros>
            <h2 class="subtitulo">Tipo de producto</h2>
            <form class="filtros" method="get" action="">
                <div class="input-filtro">
                    <label for="tipo-proudcto" class=lbl>Todos los productos</label>
                    <input type=checkbox name="tipo-producto" value="toodos"> 
                </div>
                <div class="input-filtro">
                    <label for="tipo-proudcto" class=lbl>Paquetes</label>
                    <input type=checkbox name="tipo-producto" value="paquetes"> 
                </div>
                <div class="input-filtro">
                    <label for="tipo-proudcto" class=lbl>Excursiones</label>
                    <input type=checkbox name="tipo-producto" value="excursiones"> 
                </div>
                <div class="input-filtro">
                    <label for="tipo-proudcto" class=lbl>Estadias</label>
                    <input type=checkbox name="tipo-producto" value="estadias"> 
                </div>
                <div class="input-filtro">
                    <label for="tipo-proudcto" class=lbl>Vehiculos</label>
                    <input type=checkbox name="tipo-producto" value="vehiculos"> 
                </div>
                <div class="input-filtro">
                    <label for="tipo-proudcto" class=lbl>Boletos de avion</label>
                    <input type=checkbox name="tipo-producto" value="boletos_avion"> 
                </div>
            </form>
        </div>
        <div class="productos-grid">
            <article class="producto">
                <h5 class="nombre-producto">Nose muchas cosas jaja tengo sueño</h5>
                <div class="cont-categoria-precio">
                    <div class="categoria">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path class="icon" d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path class="icon" fill="currentColor" d="M15.764 4a3 3 0 0 1 2.683 1.658l1.386 2.771q.366-.15.72-.324a1 1 0 0 1 .894 1.79a32 32 0 0 1-.725.312l.961 1.923A3 3 0 0 1 22 13.473V16a3 3 0 0 1-1 2.236V19.5a1.5 1.5 0 0 1-3 0V19H6v.5a1.5 1.5 0 0 1-3 0v-1.264c-.614-.55-1-1.348-1-2.236v-2.528a3 3 0 0 1 .317-1.341l.953-1.908q-.362-.152-.715-.327a1.01 1.01 0 0 1-.45-1.343a1 1 0 0 1 1.342-.448q.355.175.72.324l1.386-2.77A3 3 0 0 1 8.236 4zM7.5 13a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m9 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m-.736-7H8.236a1 1 0 0 0-.832.445l-.062.108l-1.27 2.538C7.62 9.555 9.706 10 12 10c2.142 0 4.101-.388 5.61-.817l.317-.092l-1.269-2.538a1 1 0 0 0-.77-.545L15.765 6Z"/></g></svg>
                        
                        <span>Vehiculo</span>
                    </div>
                    <span class="precio">$1.090.000,00</span>
                </div>

                <p class="descripcion-producto">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Autem dolorem, minima, earum quaerat totam ipsa ducimus, quae vitae doloremque officia tenetur corrupti nostrum sunt facilis exercitationem adipisci fugit. Deleniti, dolores.</p>
                <div class="cont-tiempo-btn">
                    <div class="cont-tiempo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="svg-icon" fill="currentColor" d="M11.5 3a9.5 9.5 0 0 1 9.5 9.5a9.5 9.5 0 0 1-9.5 9.5A9.5 9.5 0 0 1 2 12.5A9.5 9.5 0 0 1 11.5 3m0 1A8.5 8.5 0 0 0 3 12.5a8.5 8.5 0 0 0 8.5 8.5a8.5 8.5 0 0 0 8.5-8.5A8.5 8.5 0 0 0 11.5 4M11 7h1v5.42l4.7 2.71l-.5.87l-5.2-3z"/></svg>
                        <span class="tiempo">4 dias</span>
                    </div>
                    <button class="btn-ver-mas">Ver más</button>
                </div>
            </article>

            <article class="producto">
                <h5 class="nombre-producto">Nose muchas cosas jaja tengo sueño</h5>
                <div class="cont-categoria-precio">
                    <div class="categoria">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path class="icon" d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path class="icon" fill="currentColor" d="M15.764 4a3 3 0 0 1 2.683 1.658l1.386 2.771q.366-.15.72-.324a1 1 0 0 1 .894 1.79a32 32 0 0 1-.725.312l.961 1.923A3 3 0 0 1 22 13.473V16a3 3 0 0 1-1 2.236V19.5a1.5 1.5 0 0 1-3 0V19H6v.5a1.5 1.5 0 0 1-3 0v-1.264c-.614-.55-1-1.348-1-2.236v-2.528a3 3 0 0 1 .317-1.341l.953-1.908q-.362-.152-.715-.327a1.01 1.01 0 0 1-.45-1.343a1 1 0 0 1 1.342-.448q.355.175.72.324l1.386-2.77A3 3 0 0 1 8.236 4zM7.5 13a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m9 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m-.736-7H8.236a1 1 0 0 0-.832.445l-.062.108l-1.27 2.538C7.62 9.555 9.706 10 12 10c2.142 0 4.101-.388 5.61-.817l.317-.092l-1.269-2.538a1 1 0 0 0-.77-.545L15.765 6Z"/></g></svg>
                        
                        <span>Vehiculo</span>
                    </div>
                    <span class="precio">$1.090.000,00</span>
                </div>

                <p class="descripcion-producto">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Autem dolorem, minima, earum quaerat totam ipsa ducimus, quae vitae doloremque officia tenetur corrupti nostrum sunt facilis exercitationem adipisci fugit. Deleniti, dolores.</p>
                <div class="cont-tiempo-btn">
                    <div class="cont-tiempo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="svg-icon" fill="currentColor" d="M11.5 3a9.5 9.5 0 0 1 9.5 9.5a9.5 9.5 0 0 1-9.5 9.5A9.5 9.5 0 0 1 2 12.5A9.5 9.5 0 0 1 11.5 3m0 1A8.5 8.5 0 0 0 3 12.5a8.5 8.5 0 0 0 8.5 8.5a8.5 8.5 0 0 0 8.5-8.5A8.5 8.5 0 0 0 11.5 4M11 7h1v5.42l4.7 2.71l-.5.87l-5.2-3z"/></svg>
                        <span class="tiempo">4 dias</span>
                    </div>
                    <button class="btn-ver-mas">Ver más</button>
                </div>
            </article>

            <article class="producto">
                <h5 class="nombre-producto">Nose muchas cosas jaja tengo sueño</h5>
                <div class="cont-categoria-precio">
                    <div class="categoria">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path class="icon" d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path class="icon" fill="currentColor" d="M15.764 4a3 3 0 0 1 2.683 1.658l1.386 2.771q.366-.15.72-.324a1 1 0 0 1 .894 1.79a32 32 0 0 1-.725.312l.961 1.923A3 3 0 0 1 22 13.473V16a3 3 0 0 1-1 2.236V19.5a1.5 1.5 0 0 1-3 0V19H6v.5a1.5 1.5 0 0 1-3 0v-1.264c-.614-.55-1-1.348-1-2.236v-2.528a3 3 0 0 1 .317-1.341l.953-1.908q-.362-.152-.715-.327a1.01 1.01 0 0 1-.45-1.343a1 1 0 0 1 1.342-.448q.355.175.72.324l1.386-2.77A3 3 0 0 1 8.236 4zM7.5 13a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m9 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3m-.736-7H8.236a1 1 0 0 0-.832.445l-.062.108l-1.27 2.538C7.62 9.555 9.706 10 12 10c2.142 0 4.101-.388 5.61-.817l.317-.092l-1.269-2.538a1 1 0 0 0-.77-.545L15.765 6Z"/></g></svg>
                        
                        <span>Vehiculo</span>
                    </div>
                    <span class="precio">$1.090.000,00</span>
                </div>

                <p class="descripcion-producto">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Autem dolorem, minima, earum quaerat totam ipsa ducimus, quae vitae doloremque officia tenetur corrupti nostrum sunt facilis exercitationem adipisci fugit. Deleniti, dolores.</p>
                <div class="cont-tiempo-btn">
                    <div class="cont-tiempo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24"><path class="svg-icon" fill="currentColor" d="M11.5 3a9.5 9.5 0 0 1 9.5 9.5a9.5 9.5 0 0 1-9.5 9.5A9.5 9.5 0 0 1 2 12.5A9.5 9.5 0 0 1 11.5 3m0 1A8.5 8.5 0 0 0 3 12.5a8.5 8.5 0 0 0 8.5 8.5a8.5 8.5 0 0 0 8.5-8.5A8.5 8.5 0 0 0 11.5 4M11 7h1v5.42l4.7 2.71l-.5.87l-5.2-3z"/></svg>
                        <span class="tiempo">4 dias</span>
                    </div>
                    <button class="btn-ver-mas">Ver más</button>
                </div>
            </article>
        <div>
    </section>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/footer.php';
?>