<?php
require_once "main.php";

session_start(); // Inicio de sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = (isset($_GET['product_id'])) ? $_GET['product_id'] : 0;
    $productId = limpiar_cadena($productId);
    $nuevaFechaMantenimiento = limpiar_cadena($_POST['nueva_fecha_mantenimiento']);

    // Verificar que se haya seleccionado un producto válido
    $checkProducto = conexion();
    $checkProducto = $checkProducto->query("SELECT * FROM producto WHERE producto_id='$productId'");

    if ($checkProducto->rowCount() > 0) {
        // Actualizar la fecha de mantenimiento en la base de datos
        $actualizarMantenimiento = conexion();
        $actualizarMantenimiento = $actualizarMantenimiento->prepare("UPDATE producto SET proxima_fecha_mantenimiento = :nuevaFecha WHERE producto_id = :productId");
        $actualizarMantenimiento->bindParam(':nuevaFecha', $nuevaFechaMantenimiento);
        $actualizarMantenimiento->bindParam(':productId', $productId);
        $actualizarMantenimiento->execute();

        if ($actualizarMantenimiento->rowCount() > 0) {
            $_SESSION['mensaje'] = 'Fecha de mantenimiento actualizada correctamente.';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar la fecha de mantenimiento.';
        }
    } else {
        $_SESSION['mensaje'] = 'Producto no encontrado.';
    }

    // Redirigir a la página anterior después de la actualización
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
    exit();
}
?>