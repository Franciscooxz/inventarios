<div class="container is-fluid mb-6">
        <h1 class="title">Productos</h1>
        <h2 class="subtitle">Mantenimiento de productos(En proceso)</h2>
    </div>

<?php
require_once "./php/main.php";

$id = (isset($_GET['product_id'])) ? $_GET['product_id'] : 0;
$id = limpiar_cadena($id);

// Verificando producto
$check_producto = conexion();
$check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

if ($check_producto->rowCount() > 0) {
    $datos = $check_producto->fetch();
    ?>
    <div class="container pb-6 pt-6">
        <div class="card">
            <div class="card-content">
                <div class="media">
                    <div class="media-left">
                        <figure class="image is-128x128">
                            <?php
                            if (is_file("./img/producto/" . $datos['producto_foto'])) {
                                echo '<img src="./img/producto/' . $datos['producto_foto'] . '">';
                            } else {
                                echo '<img src="./img/producto.png">';
                            }
                            ?>
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4"><?php echo $datos['producto_nombre']; ?></p>
                        <p class="subtitle is-6"><strong>Código:</strong> <?php echo $datos['producto_codigo']; ?></p>
                        <p class="subtitle is-6"><strong>Próxima fecha de mantenimiento:</strong> <?php echo $datos['proxima_fecha_mantenimiento']; ?></p>
                    </div>
                </div>
                <form method="post" action="./php/producto_mantenimiento_update.php?product_id=<?php echo $id; ?>">
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
        </div>
    </div>
    <?php
} else {
    echo '<div class="notification is-warning is-light">
            <strong>No hay mantenimientos disponibles</strong><br>
            En este momento no se han registrado mantenimientos.
          </div>';
}

$check_producto = null;
?>