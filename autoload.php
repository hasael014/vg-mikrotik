<?php
/**
 * Archivo de Autoload para cargar clases automáticamente sin Composer.
 * 
 * Este autoloader soporta namespaces. 
 * Por ejemplo, si tienes la clase App\Models\User, 
 * el archivo debe estar en la ruta: classes/App/Models/User.php
 */

spl_autoload_register(function ($className) {
    // Reemplaza el namespace por la ruta de la carpeta
    $baseDir = __DIR__ . '/';
    
    // Convierte el namespace en una ruta de archivo
    $file = $baseDir . str_replace('\\', '/', $className) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});