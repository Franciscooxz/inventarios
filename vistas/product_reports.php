<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Reportes de mantenimiento</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
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
                    <label class="label">Categoría</label>
                    <div class="control">
                        <div class="select is-rounded">
                            <select name="categoria_id">
                                <option value="">Todas las categorías</option>
                                <?php
                                    $categorias = conexion();
                                    $categorias = $categorias->query("SELECT * FROM categoria");
                                    if ($categorias->rowCount() > 0) {
                                        $categorias = $categorias->fetchAll();
                                        foreach ($categorias as $row) {
                                            echo '<option value="' . $row['categoria_id'] . '">' . $row['categoria_nombre'] . '</option>';
                                        }
                                    }
                                    $categorias = null;
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
                    $categoria_id = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : 0;

                    require_once "./php/producto_reporte.php";
                }
            ?>
        </div>
    </div>
</div>