<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando id ==*/
$id = limpiar_cadena($_POST['producto_id']);

/*== Verificando producto ==*/
$check_producto = conexion();
$check_producto = $check_producto->prepare("SELECT * FROM producto WHERE producto_id=:id");
$check_producto->bindParam(':id', $id, PDO::PARAM_INT);
$check_producto->execute();

if ($check_producto->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El producto no existe en el sistema
        </div>
    ';
    exit();
} else {
    $datos = $check_producto->fetch();
}
$check_producto = null;

/*== Almacenando datos ==*/
$codigo = limpiar_cadena($_POST['producto_codigo']);
$nombre = limpiar_cadena($_POST['producto_nombre']);
$modelo = limpiar_cadena($_POST['producto_modelo']);
$serial = limpiar_cadena($_POST['producto_serial']);
$descripcion = limpiar_cadena($_POST['producto_descripcion']);
$categoria = limpiar_cadena($_POST['producto_categoria']);
$ubicacion = limpiar_cadena($_POST['producto_ubicacion']);
$estado = limpiar_cadena($_POST['producto_estado']);
$ultima_fecha_mantenimiento = limpiar_cadena($_POST['ultima_fecha_mantenimiento']);

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
if (verificar_datos("/^[a-zA-Z0-9- ]{1,70}$/", $codigo)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El CODIGO de BARRAS no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,70}$/", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,70}$/", $modelo)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El MODELO no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,70}$/", $serial)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El SERIAL no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,500}$/", $descripcion)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La DESCRIPCIÓN no coincide con el formato solicitado
        </div>
    ';
    exit();
}

// Validar categoría
$check_categoria = conexion();
$check_categoria = $check_categoria->prepare("SELECT * FROM categoria WHERE categoria_id=:categoria");
$check_categoria->bindParam(':categoria', $categoria, PDO::PARAM_INT);
$check_categoria->execute();
if ($check_categoria->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La categoría seleccionada no es válida
        </div>
    ';
    exit();
}
$check_categoria = null;

// Validar ubicación
$check_ubicacion = conexion();
$check_ubicacion = $check_ubicacion->prepare("SELECT * FROM ciudades WHERE ciudad_id=:ubicacion");
$check_ubicacion->bindParam(':ubicacion', $ubicacion, PDO::PARAM_INT);
$check_ubicacion->execute();
if ($check_ubicacion->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La ubicación seleccionada no es válida
        </div>
    ';
    exit();
}
$check_ubicacion = null;

// Validar esta