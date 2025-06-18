<?php
    include('conexion.php');

    $mensaje="";

    if(isset($_POST['btn_accion'])){
        switch($_POST['btn_accion']){
            case('modificar'):
                if(isset($_POST['id_pedido'])){
                    $id_pedido=($_POST['id_pedido']);
                    $verificarId_query="SELECT id_pedido FROM pedidos WHERE id_pedido = '$id_pedido'";
                    $verificarIdresult = mysqli_query($conexion, $verificarId_query);

                    if ($verificarIdresult && mysqli_num_rows($verificarIdresult) > 0) {

                        header("Location: modificar-pedido.php?id_pedido=$id_pedido");
                        exit;
                    }else{
                        $mensaje="No se encontro su pedido. :(";
                    }
                }else{
                    $mensaje="No se encontro su pedido,";
                }

            break;
            case('borrar_pedido'):
                if(isset($_POST['id_pedido'])){
                    $id_pedido=($_POST['id_pedido']);
                    $verificarId_query="SELECT id_pedido FROM pedidos WHERE id_pedido = '$id_pedido'";
                    $verificarIdresult = mysqli_query($conexion, $verificarId_query);

                    if ($verificarIdresult && mysqli_num_rows($verificarIdresult) > 0) {

                        $borrarDetalle = "DELETE FROM detalle_pedido WHERE id_pedido = '$id_pedido'";
                        mysqli_query($conexion, $borrarDetalle);
                        
                        $borrarPedidoPendiente= "DELETE FROM pedidos_pendientes WHERE id_pedido = '$id_pedido'";
                        mysqli_query($conexion, $borrarPedidoPendiente);

                        $borrarPedido = "DELETE FROM pedidos WHERE id_pedido = '$id_pedido'";
                        mysqli_query($conexion, $borrarPedido);

                    }else{
                        $mensaje="No se encontro su pedido. :(";
                    }
                }else{
                    $mensaje="No se encontro su pedido,";
                }

            break;
            
        }
    }else{
    }
?>