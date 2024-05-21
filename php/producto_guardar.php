<?php
    require_once "../inc/session_start.php";

    require_once "main.php";

    /*== Almacenando datos ==*/
    $codigo = limpiar_cadena($_POST['producto_codigo']);
    $nombre = limpiar_cadena($_POST['producto_nombre']);
    $modelo = limpiar_cadena($_POST['producto_modelo']);
    $serial = limpiar_cadena($_POST['producto_serial']);
    $descripcion = limpiar_cadena($_POST['producto_descripcion']);
    $precio = limpiar_cadena($_POST['producto_precio']);
    $stock = limpiar_cadena($_POST['producto_stock']);
    $categoria = limpiar_cadena($_POST['producto_categoria']);

    /*== Verificando campos obligatorios ==*/
    if ($codigo == "" || $nombre == "" || $modelo == "" || $serial == "" || $descripcion == "" || $precio == "" || $stock == "" || $categoria == "") {
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

    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $modelo)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El MODELO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $serial)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El SERIAL no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,500}", $descripcion)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La DESCRIPCIÓN no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $precio)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRECIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[0-9]{1,25}", $stock)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El STOCK no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando codigo ==*/
    // ... (el resto del código permanece igual) ...