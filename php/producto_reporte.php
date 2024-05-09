<?php
$conexion = conexion();

$consulta = "SELECT p.producto_id, p.producto_nombre, p.producto_codigo, c.categoria_nombre, phm.fecha_anterior, phm.fecha_nueva, u.usuario_nombre, u.usuario_apellido
             FROM producto p
             INNER JOIN categoria c ON p.categoria_id = c.categoria_id
             INNER JOIN producto_historial_mantenimiento phm ON p.producto_id = phm.producto_id
             INNER JOIN usuario u ON phm.usuario_id = u.usuario_id
             WHERE phm.fecha_nueva BETWEEN :fecha_inicio AND :fecha_fin";

$marcadores = [
    ":fecha_inicio" => $fecha_inicio,
    ":fecha_fin" => $fecha_fin
];

if ($categoria_id > 0) {
    $consulta .= " AND p.categoria_id = :categoria_id";
    $marcadores[":categoria_id"] = $categoria_id;
}

$stmt = $conexion->prepare($consulta);
$stmt->execute($marcadores);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($resultados) > 0) {
    echo '<table class="table is-striped is-bordered is-hoverable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Producto</th>';
    echo '<th>Código</th>';
    echo '<th>Categoría</th>';
    echo '<th>Fecha anterior</th>';
    echo '<th>Nueva fecha</th>';
    echo '<th>Usuario</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($resultados as $row) {
        echo '<tr>';
        echo '<td>' . $row['producto_nombre'] . '</td>';
        echo '<td>' . $row['producto_codigo'] . '</td>';
        echo '<td>' . $row['categoria_nombre'] . '</td>';
        echo '<td>' . $row['fecha_anterior'] . '</td>';
        echo '<td>' . $row['fecha_nueva'] . '</td>';
        echo '<td>' . $row['usuario_nombre'] . $row['usuario_apellido'] . '</td>';
        echo '</tr>'; // Se agregó el cierre de la etiqueta </tr>
    }
    
}