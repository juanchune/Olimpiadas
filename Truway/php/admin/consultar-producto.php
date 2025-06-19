<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/header.php';
include('conexion.php');
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/Olimpiadas/truway/php/componentes/navegador.php'; 
$tabla_seleccionada= $_GET['tabla_seleccionada'] ?? 'productos';
?>
<main>
    <link rel="stylesheet" href="/Olimpiadas/Truway/css/consultar-productos.css">
    <div class="cont-titulo-btn">
        <h2 class="subtitulo">Consultar productos</h2>
        <div class="cont-btns">
            <a href="/Olimpiadas/Truway/php/admin/agregar-producto.php" class="btn-agregar">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24">
                    <path fill="currentColor" class="icon"
                        d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z" />
                </svg>
                Agregar
            </a>
        </div>
    </div>
   <div class="seleccionar-tipo-tabla">
        <a href="consultar-producto.php?tabla_seleccionada=productos" class="tabla <?php echo ($tabla_seleccionada === 'productos') ? 'seleccionado' : ''; ?>">Productos general</a>
        <a href="consultar-producto.php?tabla_seleccionada=paquetes" class="tabla <?php echo ($tabla_seleccionada === 'paquetes') ? 'seleccionado' : ''; ?>">Paquetes</a>
        <a href="consultar-producto.php?tabla_seleccionada=excursiones" class="tabla  <?php echo ($tabla_seleccionada === 'excursiones') ? 'seleccionado' : ''; ?>">Excursiones</a>
        <a href="consultar-producto.php?tabla_seleccionada=alquiler_vehiculos" class="tabla  <?php echo ($tabla_seleccionada === 'alquiler_vehiculos') ? 'seleccionado' : ''; ?>">Alquiler vehiculos</a>
        <a href="consultar-producto.php?tabla_seleccionada=estadias" class="tabla  <?php echo ($tabla_seleccionada === 'estadias') ? 'seleccionado' : ''; ?>">Estadías</a>
        <a href="consultar-producto.php?tabla_seleccionada=boletos_avion" class="tabla  <?php echo ($tabla_seleccionada === 'boletos_avion') ? 'seleccionado' : ''; ?>">Boletos de avión</a>
    </div>

    <?php

    if (isset($_GET['tabla_seleccionada'])) {
    $tabla_seleccionada = $_GET['tabla_seleccionada'];
      switch ($tabla_seleccionada) {
        case('productos'):
           
            $query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, tp.tipo 
                    FROM productos p
                    JOIN tipo_producto tp ON p.tipo_producto = tp.id_tipo";
            $filters = [];

           
            if (isset($_GET['tipo-producto']) && $_GET['tipo-producto'] !== '') {
                $filters[] = "tp.tipo = '" . mysqli_real_escape_string($conexion, $_GET['tipo-producto']) . "'";
            }

            if (isset($_GET['precio']) && $_GET['precio'] !== '') {
                $filters[] = "p.precio <= " . intval($_GET['precio']);
            }

            
            if (!empty($filters)) {
                $query .= " WHERE " . implode(" AND ", $filters);
            }

            $result = mysqli_query($conexion, $query);

           
            $tipoProductoQuery = "SELECT DISTINCT tipo FROM tipo_producto ORDER BY tipo ASC";
            $tipoProductoResult = mysqli_query($conexion, $tipoProductoQuery);

            $precioQuery = "SELECT DISTINCT precio FROM productos ORDER BY precio ASC";
            $precioResult = mysqli_query($conexion, $precioQuery);

            include 'consulta_producto/productos.php';
            break;
        case('paquetes'):
           
            $query = "SELECT p.id_producto, p.id_paquete, pr.nombre, pr.descripcion, pr.precio 
                    FROM paquetes p
                    JOIN productos pr ON p.id_producto = pr.id_producto";
            $filters = [];

           
            if (isset($_GET['pais']) && $_GET['pais'] !== '') {
                $filters[] = "pr.descripcion LIKE '%" . mysqli_real_escape_string($conexion, $_GET['pais']) . "%'";
            }
            if (isset($_GET['precio']) && $_GET['precio'] !== '') {
                $filters[] = "pr.precio <= " . intval($_GET['precio']);
            }

           
            if (!empty($filters)) {
                $query .= " WHERE " . implode(" AND ", $filters);
            }

            $result = mysqli_query($conexion, $query);

            
            include 'consulta_producto/paquetes.php';
            break;

        case('excursiones'):
           
            $query = "SELECT * FROM excursiones";
            $filters = [];

           
            if (isset($_GET['dificultad']) && $_GET['dificultad'] !== '') {
                $filters[] = "dificultad = '" . mysqli_real_escape_string($conexion, $_GET['dificultad']) . "'";
            }

           
            if (!empty($filters)) {
                $query .= " WHERE " . implode(" AND ", $filters);
            }

            $result = mysqli_query($conexion, $query);

            
            include 'consulta_producto/excursiones.php';
            break;

        case('alquiler_vehiculos'):
          
            $query = "SELECT * FROM vehiculos";
            $filters = [];

     
            if (isset($_GET['capacidad']) && $_GET['capacidad'] !== '') {
                $filters[] = "capacidad = " . intval($_GET['capacidad']);
            }
            if (isset($_GET['tipo']) && $_GET['tipo'] !== '') {
                $filters[] = "tipo = '" . mysqli_real_escape_string($conexion, $_GET['tipo']) . "'";
            }

            
            if (!empty($filters)) {
                $query .= " WHERE " . implode(" AND ", $filters);
            }

            $result = mysqli_query($conexion, $query);

        
            $capacidadQuery = "SELECT DISTINCT capacidad FROM vehiculos ORDER BY capacidad ASC";
            $capacidadResult = mysqli_query($conexion, $capacidadQuery);

            $tipoQuery = "SELECT DISTINCT tipo FROM vehiculos ORDER BY tipo ASC";
            $tipoResult = mysqli_query($conexion, $tipoQuery);

            
            include 'consulta_producto/vehiculos.php';
            break;
        
        case('estadias'):
       
            $query = "SELECT * FROM estadias";
            $filters = [];

 
            if (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
                $filters[] = "categoria = '" . mysqli_real_escape_string($conexion, $_GET['categoria']) . "'";
            }
            if (isset($_GET['localidad']) && $_GET['localidad'] !== '') {
                $filters[] = "localidad = '" . mysqli_real_escape_string($conexion, $_GET['localidad']) . "'";
            }

     
            if (!empty($filters)) {
                $query .= " WHERE " . implode(" AND ", $filters);
            }

            $result = mysqli_query($conexion, $query);

  
            $categoriaQuery = "SELECT DISTINCT categoria FROM estadias ORDER BY categoria ASC";
            $categoriaResult = mysqli_query($conexion, $categoriaQuery);

            $localidadQuery = "SELECT DISTINCT localidad FROM estadias ORDER BY localidad ASC";
            $localidadResult = mysqli_query($conexion, $localidadQuery);

            
            include 'consulta_producto/estadias.php';
            break;

        case('boletos_avion'):
           
            $query = "SELECT * FROM pasajes";
            $filters = [];


            if (isset($_GET['tipo-pasaje']) && $_GET['tipo-pasaje'] !== '') {
                $filters[] = "tipo_pasaje = '" . mysqli_real_escape_string($conexion, $_GET['tipo-pasaje']) . "'";
            }
            if (isset($_GET['aereolinea']) && $_GET['aereolinea'] !== '') {
                $filters[] = "aerolinea = '" . mysqli_real_escape_string($conexion, $_GET['aereolinea']) . "'";
            }

       
            if (!empty($filters)) {
                $query .= " WHERE " . implode(" AND ", $filters);
            }

            $result = mysqli_query($conexion, $query);

   
            $tipoPasajeQuery = "SELECT DISTINCT tipo_pasaje FROM pasajes ORDER BY tipo_pasaje ASC";
            $tipoPasajeResult = mysqli_query($conexion, $tipoPasajeQuery);

            $aerolineaQuery = "SELECT DISTINCT aerolinea FROM pasajes ORDER BY aerolinea ASC";
            $aerolineaResult = mysqli_query($conexion, $aerolineaQuery);

            
            include 'consulta_producto/boletos_avion.php';
            break;

        }
    
    }else{
    
            $query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, tp.tipo 
                    FROM productos p
                    JOIN tipo_producto tp ON p.tipo_producto = tp.id_tipo";
            $filters = [];

     
            if (isset($_GET['tipo-producto']) && $_GET['tipo-producto'] !== '') {
                $filters[] = "tp.tipo = '" . mysqli_real_escape_string($conexion, $_GET['tipo-producto']) . "'";
            }

            if (isset($_GET['precio']) && $_GET['precio'] !== '') {
                $filters[] = "p.precio <= " . intval($_GET['precio']);
            }

   
            if (!empty($filters)) {
                $query .= " WHERE " . implode(" AND ", $filters);
            }

            $result = mysqli_query($conexion, $query);

        
            $tipoProductoQuery = "SELECT DISTINCT tipo FROM tipo_producto ORDER BY tipo ASC";
            $tipoProductoResult = mysqli_query($conexion, $tipoProductoQuery);

            $precioQuery = "SELECT DISTINCT precio FROM productos ORDER BY precio ASC";
            $precioResult = mysqli_query($conexion, $precioQuery);

            include 'consulta_producto/productos.php';
    }?>
 
</main>


</body>
</html>