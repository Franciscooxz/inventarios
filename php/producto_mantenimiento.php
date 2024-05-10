<?php
require_once "main.php";

// Obtener conexión a la base de datos
$conexion = conexion();

try {
    /*== Almacenando id ==*/
    $id = limpiar_cadena($_GET['product_id_up']);

    /*== Verificando producto ==*/
    $sentencia = $conexion->prepare("SELECT * FROM producto WHERE producto_id=:id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    if ($sentencia->rowCount() <= 0) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El producto no existe en el sistema
        </div>
        ';
        exit();
    }

    $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

    /*== Actualizando fechas de mantenimiento ==*/
    $fecha_mantenimiento = date('Y-m-d'); // Obtener la fecha actual
    $proxima_fecha_mantenimiento = date('Y-m-d', strtotime('+6 months', strtotime($fecha_mantenimiento)));

    $sentencia = $conexion->prepare("UPDATE producto SET ultima_fecha_mantenimiento=:fecha_mantenimiento, proxima_fecha_mantenimiento=:proxima_fecha_mantenimiento WHERE producto_id=:id");
    $sentencia->bindParam(':fecha_mantenimiento', $fecha_mantenimiento);
    $sentencia->bindParam(':proxima_fecha_mantenimiento', $proxima_fecha_mantenimiento);
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    echo '
    <div class="notification is-info is-light">
        <strong>¡FECHA DE MANTENIMIENTO ACTUALIZADA!</strong><br>
        La fecha de mantenimiento se actualizó correctamente
    </div>
    ';

    /*== Mostrando información del producto ==*/
    echo '
    <div class="card">
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-128x128">';
    if (is_file("./img/producto/" . $datos['producto_foto'])) {
        echo '<img src="./img/producto/' . $datos['producto_foto'] . '">';
    } else {
        echo '<img src="./img/producto.png">';
    }
    echo '
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title is-4">' . $datos['producto_nombre'] . '</p>
                    <p class="subtitle is-6"><strong>Código:</strong> ' . $datos['producto_codigo'] . '</p>
                    <p class="subtitle is-6"><strong>Precio:</strong> $' . $datos['producto_precio'] . '</p>
                    <p class="subtitle is-6"><strong>Stock:</strong> ' . $datos['producto_stock'] . '</p>
                    <p class="subtitle is-6"><strong>Categoría:</strong> ' . obtener_categoria($conexion, $datos['categoria_id']) . '</p>
                    <p class="subtitle is-6"><strong>Última fecha de mantenimiento:</strong> ' . $datos['ultima_fecha_mantenimiento'] . '</p>
                    <p class="subtitle is-6"><strong>Próxima fecha de mantenimiento:</strong> ' . $proxima_fecha_mantenimiento . '</p>
                </div>
            </div>
        </div>
    </div>';

} catch (PDOException $e) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        ' . $e->getMessage() . '
    </div>
    ';
}

/*== Función para obtener el nombre de la categoría ==*/
function obtener_categoria($conexion, $categoria_id) {
    $sentencia = $conexion->prepare("SELECT categoria_nombre FROM categoria WHERE categoria_id=:categoria_id");
    $sentencia->bindParam(':categoria_id', $categoria_id);
    $sentencia->execute();
    $categoria = $sentencia->fetch(PDO::FETCH_ASSOC);
    return $categoria['categoria_nombre'];
}

?>