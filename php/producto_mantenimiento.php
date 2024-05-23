<?php
require_once "main.php";
require_once "../inc/session_start.php";

// Obtener conexión a la base de datos
$conexion = conexion();

try {
    /*== Almacenando id ==*/
    $id = limpiar_cadena($_GET['product_id']);

    /*== Verificando producto ==*/
    $sentencia = $conexion->prepare("SELECT * FROM producto WHERE producto_id = :id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    if ($sentencia->rowCount() <= 0) {
        echo '<div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El producto no existe en el sistema
              </div>';
        exit();
    }

    $datos = $sentencia->fetch(PDO::FETCH_ASSOC);

    /*== Actualizando fecha de mantenimiento ==*/
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nueva_fecha_mantenimiento = limpiar_cadena($_POST['nueva_fecha_mantenimiento']);

        $sentencia = $conexion->prepare("UPDATE producto SET proxima_fecha_mantenimiento = :nueva_fecha_mantenimiento WHERE producto_id = :id");
        $sentencia->bindParam(':nueva_fecha_mantenimiento', $nueva_fecha_mantenimiento);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();

        echo '<div class="notification is-info is-light">
                <strong>¡FECHA DE MANTENIMIENTO ACTUALIZADA!</strong><br>
                La fecha de mantenimiento se actualizó correctamente
              </div>';
    }

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
                    <p class="subtitle is-6"><strong>Próxima fecha de mantenimiento:</strong> ' . $datos['proxima_fecha_mantenimiento'] . '</p>
                </div>
            </div>
            <form method="post" action="' . $_SERVER['PHP_SELF'] . '?product_id=' . $id . '">
                <div class="field">
                    <label class="label">Nueva fecha de mantenimiento</label>
                    <div class="control">
                        <input class="input" type="date" name="nueva_fecha_mantenimiento" required>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-primary" type="submit">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>';
} catch (PDOException $e) {
    echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            ' . $e->getMessage() . '
          </div>';
}
?>