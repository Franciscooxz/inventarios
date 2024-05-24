<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Actualizar producto</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";

        require_once "./php/main.php";

        $id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0;
        $id = limpiar_cadena($id);

        /*== Verificando producto ==*/
        $check_producto = conexion();
        $check_producto = $check_producto->query("SELECT p.*, c.categoria_nombre
                                                   FROM producto p
                                                   JOIN categoria c ON p.categoria_id = c.categoria_id
                                                   WHERE p.producto_id = '$id'");

        if ($check_producto->rowCount() > 0) {
            $datos = $check_producto->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <h2 class="title has-text-centered"><?php echo $datos['producto_nombre']; ?></h2>

    <form action="./php/producto_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

        <input type="hidden" name="producto_id" value="<?php echo $datos['producto_id']; ?>" required>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Codigo de Barras</label>
                    <input class="input" type="text" name="producto_codigo" pattern="^[a-zA-Z0-9- ]{1,70}$" maxlength="70" required value="<?php echo $datos['producto_codigo']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="producto_nombre" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,70}$" maxlength="70" required value="<?php echo $datos['producto_nombre']; ?>">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Modelo</label>
                    <input class="input" type="text" name="producto_modelo" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,70}$" maxlength="70" required value="<?php echo $datos['producto_modelo']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Serial</label>
                    <input class="input" type="text" name="producto_serial" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,70}$" maxlength="70" required value="<?php echo $datos['producto_serial']; ?>">
                </div>
            </div>
            <div class="column">
                <label>Categoría</label><br>
                <div class="select is-rounded">
                    <select name="producto_categoria">
                        <?php
                            $categorias = conexion();
                            $categorias = $categorias->query("SELECT * FROM categoria");
                            if ($categorias->rowCount() > 0) {
                                $categorias = $categorias->fetchAll();
                                foreach ($categorias as $row) {
                                    if ($datos['categoria_id'] == $row['categoria_id']) {
                                        echo '<option value="' . $row['categoria_id'] . '" selected>' . $row['categoria_nombre'] . ' (Actual)</option>';
                                    } else {
                                        echo '<option value="' . $row['categoria_id'] . '">' . $row['categoria_nombre'] . '</option>';
                                    }
                                }
                            }
                            $categorias = null;
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Descripción</label>
                    <textarea class="textarea" name="producto_descripcion" maxlength="500" required><?php echo $datos['producto_descripcion']; ?></textarea>
                </div>
            </div>
            <div class="column">
                <label>Ubicación</label><br>
                <div class="select is-rounded">
                    <select name="producto_ubicacion">
                        <option value="" selected>Seleccione una opción</option>
                        <?php
                        $ciudades = conexion();
                        $ciudades = $ciudades->query("SELECT * FROM ciudades");
                        if ($ciudades->rowCount() > 0) {
                            $ciudades = $ciudades->fetchAll();
                            foreach ($ciudades as $row) {
                                echo '<option value="' . $row['ciudad_id'] . '">' . $row['ciudad_nombre'] . '</option>';
                            }
                        }
                        $ciudades = null;
                        ?>
                    </select>
                </div>
            </div>
            </div>
            <div class="columns">
            <div class="column">
                <label>Estado</label><br>
                <div class="select is-rounded">
                    <select name="producto_estado">
                        <option value="" selected>Seleccione una opción</option>
                        <option value="Buen estado">Buen estado</option>
                        <option value="Mal estado">Mal estado</option>
                        <option value="En mantenimiento">En mantenimiento</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Última fecha de mantenimiento</label>
                    <input class="input" type="date" name="ultima_fecha_mantenimiento" value="<?php echo isset($datos['ultima_fecha_mantenimiento']) ? $datos['ultima_fecha_mantenimiento'] : ''; ?>">
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>
    <?php
        } else {
            include "./inc/error_alert.php";
        }
        $check_producto = null;
    ?>
</div>