<?php
// Verifica el estado de la sesión antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Regenera la sesión para evitar ataques de fijación de sesión
session_regenerate_id(true);

// Verifica si hay una sesión activa
if (!isset($_SESSION['id'])) {
    // Si no hay sesión activa, redirigir al inicio de sesión
    header("Location: index.php?vista=login");
    exit();
}

// ... resto del código ...

$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];
$categoria_id = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : 0;

$consulta = "SELECT p.producto_nombre, p.producto_codigo, c.categoria_nombre, r.fecha_anterior, r.fecha_nueva, u.usuario_nombre, u.usuario_apellido
             FROM producto p
             JOIN categoria c ON p.categoria_id = c.categoria_id
             JOIN reporte r ON r.producto_id = p.producto_id
             JOIN usuario u ON r.usuario_id = u.usuario_id
             WHERE r.fecha_nueva BETWEEN :fecha_inicio AND :fecha_fin";

// Agregar filtro por categoría si es necesario
if ($categoria_id > 0) {
    $consulta .= " AND p.categoria_id = :categoria_id";
    $marcadores[":categoria_id"] = $categoria_id;
}

$marcadores[":fecha_inicio"] = $fecha_inicio;
$marcadores[":fecha_fin"] = $fecha_fin;

$stmt = $conexion->prepare($consulta);
$stmt->execute($marcadores);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($resultados) > 0) {
    echo '<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">';
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
        echo '<td>' . $row['usuario_nombre'] . ' ' . $row['usuario_apellido'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}