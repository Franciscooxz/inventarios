<?php

require_once "main.php";

try {
    $conexion = conexion();

    $fecha_actual = date('Y-m-d');
    $fecha_limite = date('Y-m-d', strtotime('+7 days'));

    $consulta = "SELECT producto_nombre, proxima_fecha_mantenimiento
                  FROM producto
                  WHERE proxima_fecha_mantenimiento BETWEEN :fecha_actual AND :fecha_limite";

    $sentencia = $conexion->prepare($consulta);
    $sentencia->bindParam(':fecha_actual', $fecha_actual);
    $sentencia->bindParam(':fecha_limite', $fecha_limite);
    $sentencia->execute();

    $resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) > 0) {
        echo '<div class="notification is-warning">';
        echo '    <h3 class="title is-4">Próximos mantenimientos</h3>';

        foreach ($resultados as $fila) {
            $fecha_formateada = date('d/m/Y', strtotime($fila['proxima_fecha_mantenimiento']));
            echo '<p><strong>' . $fila['producto_nombre'] . '</strong> - Mantenimiento requerido el: ' . $fecha_formateada . '</p>';
        }

        echo '</div>';
    } else {
        echo '<div class="notification is-info">';
        echo '    <p>No hay mantenimientos próximos en este momento.</p>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo '<div class="notification is-danger">';
    echo '    <p>Error al obtener datos de la base de datos: ' . $e->getMessage() . '</p>';
    echo '</div>';
}

?>