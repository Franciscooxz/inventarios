<?php
require_once "main.php";

$conexion = conexion();
$fecha_actual = date('Y-m-d');
$fecha_limite = date('Y-m-d', strtotime('+7 days'));

$consulta = "SELECT producto_nombre, proxima_fecha_mantenimiento 
             FROM producto 
             WHERE proxima_fecha_mantenimiento BETWEEN '$fecha_actual' AND '$fecha_limite'";

$resultado = $conexion->query($consulta);

if ($resultado->rowCount() > 0) {
    echo '<div class="notification is-warning">
            <h3 class="title is-4">Próximos mantenimientos</h3>';

    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<p><strong>' . $fila['producto_nombre'] . '</strong> - Mantenimiento requerido el: ' . $fila['proxima_fecha_mantenimiento'] . '</p>';
    }

    echo '</div>';
} else {
    echo '<div class="notification is-info">
            <p>No hay mantenimientos próximos en este momento.</p>
          </div>';
}