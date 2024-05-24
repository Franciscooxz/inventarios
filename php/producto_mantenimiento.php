<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Mantenimiento de productos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";

    /*== Obteniendo productos con próximas fechas de mantenimiento ==*/
    $conexion = conexion();
    $sentencia = $conexion->query("SELECT * FROM producto WHERE proxima_fecha_mantenimiento IS NOT NULL ORDER BY proxima_fecha_mantenimiento ASC");

    if ($sentencia->rowCount() > 0) {
        while ($datos = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $id = $datos['producto_id'];
    ?>
            <div class="card mb-4">
                <div class="card-content">
                    <div class="media">
                        <div class="media-left">
                            <figure class="image is-128x128">
                                <?php
                                if (is_file("./img/producto/" . $datos['producto_foto'])) {
                                    echo '<img src="./img/producto/' . $datos['producto_foto'] . '">';
                                } else {
                                    echo '<img src="./img/producto.png">';
                                }
                                ?>
                            </figure>
                        </div>
                        <div class="media-content">
                            <p class="title is-4"><?php echo $datos['producto_nombre']; ?></p>
                            <p class="subtitle is-6"><strong>Código:</strong> <?php echo $datos['producto_codigo']; ?></p>
                            <p class="subtitle is-6"><strong>Próxima fecha de mantenimiento:</strong> <?php echo $datos['proxima_fecha_mantenimiento']; ?></p>
                        </div>
                    </div>
                    <a href="producto_mantenimiento.php?product_id=<?php echo $id; ?>" class="button is-primary">Actualizar mantenimiento</a>
                </div>
            </div>
    <?php
        }
    } else {
        echo '<div class="notification is-warning is-light"> <strong>No hay mantenimientos disponibles</strong><br> En este momento no se han registrado mantenimientos. </div>';
    }
    ?>
</div>