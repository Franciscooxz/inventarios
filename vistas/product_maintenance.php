<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Mantenimiento de productos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";
    $id = (isset($_GET['product_id'])) ? $_GET['product_id'] : 0;
    $id = limpiar_cadena($id);

    /*== Verificando producto ==*/
    $check_producto = conexion();
    $check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

    if ($check_producto->rowCount() > 0) {
        $datos = $check_producto->fetch();
        require_once "./php/productomantenimiento.php";
    } else {
        echo '<div class="notification is-warning is-light">
                <strong>No hay mantenimientos disponibles</strong><br>
                En este momento no se han registrado mantenimientos para este producto.
              </div>';
    }
    $check_producto = null;
    ?>
</div>