<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando datos ==*/
$codigo = limpiar_cadena($_POST['producto_codigo']);
$nombre = limpiar_cadena($_POST['producto_nombre']);
$modelo = limpiar_cadena($_POST['producto_modelo']);
$serial = limpiar_cadena($_POST['producto_serial']);
$descripcion = limpiar_cadena($_POST['producto_descripcion']);
$categoria = limpiar_cadena($_POST['producto_categoria']);
$ubicacion = isset($_POST['producto_ubicacion']) ? limpiar_cadena($_POST['producto_ubicacion']) : "";
$estado = limpiar_cadena($_POST['producto_estado']);

/*== Verificando campos obligatorios ==*/
if ($codigo == "" || $nombre == "" || $modelo == "" || $serial == "" || $descripcion == "" || $categoria == "" || $ubicacion == "" || $estado == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}

/*== Verificando integridad de los datos ==*/
if (verificar_datos("[a-zA-Z0-9- ]{1,70}", $codigo)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El CODIGO de BARRAS no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

// Agrega aquí las validaciones para los nuevos campos: modelo, serial, descripcion, estado

/*== Verificando codigo ==*/
$check_codigo = conexion();
$check_codigo = $check_codigo->query("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
if ($check_codigo->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El CODIGO de BARRAS ingresado ya se encuentra registrado, por favor elija otro
        </div>
    ';
    exit();
}
$check_codigo = null;

/*== Verificando categoria ==*/
$check_categoria = conexion();
$check_categoria = $check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
if ($check_categoria->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La categoría seleccionada no existe
        </div>
    ';
    exit();
}
$check_categoria = null;

/*== Verificando ubicacion ==*/
$check_ubicacion = conexion();
$check_ubicacion = $check_ubicacion->query("SELECT ciudad_id FROM ciudades WHERE ciudad_id='$ubicacion'");
if ($check_ubicacion->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La ubicación seleccionada no existe
        </div>
    ';
    exit();
}
$check_ubicacion = null;

/* Directorios de imagenes */
$img_dir = '../img/producto/';

/*== Comprobando si se ha seleccionado una imagen ==*/
$foto = '';  // Inicializar $foto como una cadena vacía
if ($_FILES['producto_foto']['name'] != "" && $_FILES['producto_foto']['size'] > 0) {
    // Código para manejar la imagen
    // ...
    // Asignar el nombre de la imagen a $foto después de subirla
}

/*== Guardando datos ==*/
$guardar_producto = conexion();
$guardar_producto = $guardar_producto->prepare("INSERT INTO producto (producto_codigo, producto_nombre, producto_descripcion, producto_modelo, producto_serial, producto_foto, categoria_id, usuario_id, producto_ubicacion, producto_estado) VALUES (:codigo, :nombre, :descripcion, :modelo, :serial, :foto, :categoria, :usuario, :ubicacion, :estado)");

$marcadores = [
    ":codigo" => $codigo,
    ":nombre" => $nombre,
    ":descripcion" => $descripcion,
    ":modelo" => $modelo,
    ":serial" => $serial,
    ":foto" => $foto,
    ":categoria" => $categoria,
    ":usuario" => $_SESSION['id'],
    ":ubicacion" => $ubicacion,
    ":estado" => $estado
];

$guardar_producto->execute($marcadores);

if ($guardar_producto->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡PRODUCTO REGISTRADO!</strong><br>
            El producto se registro con exito
        </div>
    ';
} else {
    if (!empty($foto) && is_file($img_dir . $foto)) {
        chmod($img_dir . $foto, 0777);
        unlink($img_dir . $foto);
    }

    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el producto, por favor intente nuevamente
        </div>
    ';
}
$guardar_producto = null;