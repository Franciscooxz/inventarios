<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando datos ==*/
$nombre = limpiar_cadena($_POST['producto_nombre']);
$modelo = limpiar_cadena($_POST['producto_modelo']);
$serial = limpiar_cadena($_POST['producto_serial']);
$descripcion = limpiar_cadena($_POST['producto_descripcion']);
$categoria = limpiar_cadena($_POST['producto_categoria']);

/*== Verificando campos obligatorios ==*/
if ($nombre == "" || $modelo == "" || $serial == "" || $descripcion == "" || $categoria == "") {
    echo ' <div class="notification is-danger is-light"> <strong>¡Ocurrio un error inesperado!</strong><br> No has llenado todos los campos que son obligatorios </div> ';
    exit();
}

/*== Verificando integridad de los datos ==*/
// ... (el código de verificación de datos permanece igual) ...

/*== Insertando datos en la base de datos ==*/
$conexion = conexion(); // Establecer conexión a la base de datos

try {
    // Preparar la consulta SQL para insertar datos
    $sql = "INSERT INTO producto (producto_nombre, producto_modelo, producto_serial, producto_descripcion, categoria_id) VALUES (:nombre, :modelo, :serial, :descripcion, :categoria)";
    $stmt = $conexion->prepare($sql);

    // Vincular los valores a los parámetros de la consulta preparada  
    $stmt->bindParam(':producto_nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':producto_modelo', $modelo, PDO::PARAM_STR);
    $stmt->bindParam(':producto_serial', $serial, PDO::PARAM_STR);
    $stmt->bindParam(':producto_descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(':producto_categoria', $categoria, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt->execute();

    echo '<div class="notification is-success is-light">
            <strong>¡Producto guardado correctamente!</strong>
        </div>';
} catch (PDOException $e) {
    echo '<div class="notification is-danger is-light">
            <strong>¡Error al guardar el producto!</strong><br>' . $e->getMessage() . '
        </div>';
}

// Cerrar el statement
$stmt = null;
