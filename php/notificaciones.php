<?php
require_once "main.php";

try {
    $conexion = conexion();
    $fecha_actual = date('Y-m-d');
    $fecha_limite = date('Y-m-d', strtotime('+7 days'));

    // Verificar si se han generado reportes de mantenimiento en el rango de fechas
    $consulta_reportes = "SELECT COUNT(*) AS total_reportes FROM mantenimiento_reporte WHERE fecha_reporte BETWEEN :fecha_actual AND :fecha_limite";
    $sentencia_reportes = $conexion->prepare($consulta_reportes);
    $sentencia_reportes->bindParam(':fecha_actual', $fecha_actual);
    $sentencia_reportes->bindParam(':fecha_limite', $fecha_limite);
    $sentencia_reportes->execute();
    $total_reportes = $sentencia_reportes->fetchColumn();

    if ($total_reportes > 0) {
        echo '<div class="notification is-info">';
        echo '<h3 class="title is-4">Reportes de mantenimiento generados</h3>';
        echo '<p>Se han generado reportes de mantenimiento en los últimos 7 días. Revisa los detalles para más información.</p>';
        echo '</div>';
    }

    // Verificar próximos mantenimientos
    $consulta_mantenimientos = "SELECT producto_nombre, proxima_fecha_mantenimiento FROM producto WHERE proxima_fecha_mantenimiento BETWEEN :fecha_actual AND :fecha_limite";
    $sentencia_mantenimientos = $conexion->prepare($consulta_mantenimientos);
    $sentencia_mantenimientos->bindParam(':fecha_actual', $fecha_actual);
    $sentencia_mantenimientos->bindParam(':fecha_limite', $fecha_limite);
    $sentencia_mantenimientos->execute();
    $resultados = $sentencia_mantenimientos->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) > 0) {
        echo '<div class="notification is-warning">';
        echo '<h3 class="title is-4">Próximos mantenimientos</h3>';
        foreach ($resultados as $fila) {
            $fecha_formateada = date('d/m/Y', strtotime($fila['proxima_fecha_mantenimiento']));
            echo '<p><strong>' . $fila['producto_nombre'] . '</strong> - Mantenimiento requerido el: ' . $fecha_formateada . '</p>';
        }
        echo '</div>';
    } else {
        echo '<div class="notification is-info">';
        echo '<p>No hay mantenimientos próximos en este momento.</p>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo '<div class="notification is-danger">';
    echo '<p>Error al obtener datos de la base de datos: ' . $e->getMessage() . '</p>';
    echo '</div>';
}
?>