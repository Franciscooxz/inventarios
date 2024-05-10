<?php
require_once "main.php";

/*== Almacenando id ==*/
$id = limpiar_cadena($_GET['product_id_up']);

/*== Verificando producto ==*/
$check_producto = conexion();
$check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

if ($check_producto->rowCount() <= 0) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El producto no existe en el sistema
    </div>
    ';
    exit();
}

$datos = $check_producto->fetch();
$check_producto = null;

/*== Actualizando fecha de mantenimiento ==*/
$fecha_mantenimiento = date('Y-m-d'); // Obtener la fecha actual

$actualizar_mantenimiento = conexion();
$actualizar_mantenimiento = $actualizar_mantenimiento->prepare("UPDATE producto SET ultima_fecha_mantenimiento=:fecha_mantenimiento WHERE producto_id=:id");

$marcadores = [
    ":fecha_mantenimiento" => $fecha_mantenimiento,
    ":id" => $id
];

if ($actualizar_mantenimiento->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
        <strong>¡FECHA DE MANTENIMIENTO ACTUALIZADA!</strong><br>
        La fecha de mantenimiento se actualizó correctamente
    </div>
    ';
} else {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se pudo actualizar la fecha de mantenimiento
    </div>
    ';
}

// Calcular y guardar la próxima fecha de mantenimiento
$proxima_fecha_mantenimiento = date('Y-m-d', strtotime('+6 months', strtotime($fecha_mantenimiento)));
$actualizar_mantenimiento = $actualizar_mantenimiento->prepare("UPDATE producto SET proxima_fecha_mantenimiento=:proxima_fecha_mantenimiento WHERE producto_id=:id");
$marcadores[":proxima_fecha_mantenimiento"] = $proxima_fecha_mantenimiento;
$actualizar_mantenimiento->execute($marcadores);

$actualizar_mantenimiento = null; // Cerramos la conexión

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
echo '          </figure>
            </div>
            <div class="media-content">
                <p class="title is-4">' . $datos['producto_nombre'] . '</p>
                <p class="subtitle is-6"><strong>Código:</strong> ' . $datos['producto_codigo'] . '</p>
                <p class="subtitle is-6"><strong>Precio:</strong> $' . $datos['producto_precio'] . '</p>
                <p class="subtitle is-6"><strong>Stock:</strong> ' . $datos['producto_stock'] . '</p>
                <p class="subtitle is-6"><strong>Categoría:</strong> ' . obtener_categoria($datos['categoria_id']) . '</p>
                <p class="subtitle is-6"><strong>Última fecha de mantenimiento:</strong> ' . $datos['ultima_fecha_mantenimiento'] . '</p>
                <p class="subtitle is-6"><strong>Próxima fecha de mantenimiento:</strong> ' . $proxima_fecha_mantenimiento . '</p>
            </div>
        </div>
    </div>
</div>
';

/*== Función para obtener el nombre de la categoría ==*/
function obtener_categoria($categoria_id)
{
    $conexion = conexion();
    $categoria = $conexion->query("SELECT categoria_nombre FROM categoria WHERE categoria_id='$categoria_id'");
    $categoria = $categoria->fetch();
    $conexion = null;
    return $categoria['categoria_nombre'];
}