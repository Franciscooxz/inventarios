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
    $datos = $check_producto->fetch(PDO::FETCH_ASSOC);
}
$check_producto = null;

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
if (verificar_datos('/^[a-zA-Z0-9- ]{1,70}$/', $codigo)) {
    // ...
}

if (verificar_datos('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\\/ ]{1,70}$/', $nombre)) {
    // ...
}

// ... y así sucesivamentexit();

// ... (resto de las validaciones)

/*== Verificando codigo ==*/
$check_codigo = conexion();
$check_codigo = $check_codigo->prepare("SELECT producto_codigo FROM producto WHERE producto_codigo=:codigo AND producto_id!=:id");
$check_codigo->bindParam(':codigo', $codigo, PDO::PARAM_STR);
$check_codigo->bindParam(':id', $id, PDO::PARAM_INT);
$check_codigo->execute();
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

// ... (resto de las validaciones)

/* Directorios de imagenes */
$img_dir = '../img/producto/';

/*== Comprobando si se ha seleccionado una nueva imagen ==*/
$foto = '';
if (is_array($datos) && array_key_exists('producto_foto', $datos)) {
    $foto = $datos['producto_foto'];
}

/*== Actualizando datos ==*/
$actualizar_producto = conexion();
$actualizar_producto = $actualizar_producto->prepare("UPDATE producto SET
    producto_codigo=:codigo,
    producto_nombre=:nombre,
    producto_descripcion=:descripcion,
    producto_modelo=:modelo,
    producto_serial=:serial,
    producto_foto=:foto,
    categoria_id=:categoria,
    producto_ubicacion=:ubicacion,
    producto_estado=:estado
    WHERE producto_id=:id");

$marcadores = [
    ":codigo" => $codigo,
    ":nombre" => $nombre,
    ":descripcion" => $descripcion,
    ":modelo" => $modelo,
    ":serial" => $serial,
    ":foto" => $foto,
    ":categoria" => $categoria,
    ":ubicacion" => $ubicacion,
    ":estado" => $estado,
    ":id" => $id
];

$actualizar_producto->execute($marcadores);

if ($actualizar_producto->rowCount() == 1) {
    echo '
        <div class="notification is-success is-light">
            <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
            El producto se actualizó con éxito
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo actualizar el producto
        </div>
    ';
}
$actualizar_producto = null;