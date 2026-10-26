<?php
//config/imagenes.php


//CONFIGURACION DE CARPETA DE IMAGENES DE PRODUCTOS
const IMG_PRODUCTOS_DIR = __DIR__ . '/../public/img/productos/';
const IMG_MAX_BYTES = 2 * 1024 * 1024; //2MB

// Valida y guarda una imagen de producto.
function guardarImagenProducto($archivo) {
    //Eligieron algun archivo?
    if (!isset($archivo) || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => true, 'nombre' => null];
    }
    
    //Llego bien al servidor?
    if ($archivo['error'] === UPLOAD_ERR_INI_SIZE || $archivo['error'] === UPLOAD_ERR_FORM_SIZE) {
        return ['ok' => false, 'error' => 'El archivo excede el tamaño máximo permitido'];
    }

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'No se pudo subir la imagen. Intenta de nuevo.'];
    }

    //Tamaño
    if($archivo['size'] > IMG_MAX_BYTES) {
        return ['ok' => false, 'error' => 'El archivo excede el tamaño máximo de 2MB'];
    }

    //3) Tipo REAL: getimagesize() lee el contenido del archivo.
    $info = @getimagesize($archivo['tmp_name']); 
    $permitidos=[
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_WEBP => 'webp'
    ];

    if ($info===false || !isset($permitidos[$info[2]])) {
        return ['ok' => false, 'error' => 'El archivo tiene que ser una imagen JPG, PNG o WEBP.'];
    }

    //Nombre nuevo y aleatorio
    $nombre = bin2hex(random_bytes(8)) . '.' . $permitidos[$info[2]];

    if(!move_uploaded_file($archivo['tmp_name'], IMG_PRODUCTOS_DIR . $nombre)){
        return ['ok' => false, 'error' => 'No se pudo guardar la imagen en el servidor'];
    }
    return ['ok' => true, 'nombre' => $nombre];
}

//Borrar una imagen de la carpeta productos
function borrarImagenProducto($nombre) {
    if (!$nombre) {
        return;
    }

    //basename() se queda solo con el nombre y elimina cualquier ruta  
    $ruta = IMG_PRODUCTOS_DIR . basename($nombre);
    
    if (is_file($ruta)) {
        unlink($ruta);
    }
}
