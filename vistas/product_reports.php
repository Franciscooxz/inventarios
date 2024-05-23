<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Reportes de mantenimiento</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    // Verifica el estado de la sesión antes de intentar iniciarla
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Verifica si hay una sesión activa
    if (!isset($_SESSION['id'])) {
        // Si no hay sesión activa, redirigir al inicio de sesión
        header("Location: index.php?vista=login");
        exit();
    }

    require_once "./php/main.php";
    ?>

    <div class="columns">
        <div class="column">
            <h3 class="title is-4">Filtros de reporte</h3>
            <form action="" method="GET">
                <div class="field">
                    <label class="label">Rango de fechas</label>
                    <div class="control">
                        <input class="input" type="date" name="fecha_inicio" required>
                        <input class="input" type="date" name="fecha_fin" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Producto</label>
                    <div class="control">
                        <div class="select is-rounded">
                            <select name="producto_id">
                                <option value="">Todos los productos</option>
                                <?php
                                $productos = conexion();
                                $productos = $productos->query("SELECT * FROM producto");
                                if ($productos->rowCount() > 0) {
                                    $productos = $productos->fetchAll();
                                    foreach ($productos as $row) {
                                        echo '<option value="' . $row['producto_id'] . '">' . $row['producto_nombre'] . '</option>';
                                    }
                                }
                                $productos = null;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link is-rounded">Generar reporte</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="column">
            <?php
            if (isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin'])) {
                $fecha_inicio = $_GET['fecha_inicio'];
                $fecha_fin = $_GET['fecha_fin'];
                $producto_id = isset($_GET['producto_id']) ? $_GET['producto_id'] : 0;
                require_once "./php/producto_reporte.php";
            }
            ?>
        </div>
    </div>
</div>