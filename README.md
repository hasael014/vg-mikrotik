# vg-mikrotik

Este es un sistema web que permite crear y gestionar vouchers para routers MikroTik, así como imprimir los vouchers en tamaño carta.

## Creación del archivo Config.php

Para configurar la aplicación, crea el archivo `Config.php` en el directorio `./App/Config.php` con el siguiente contenido:

```php
<?php

$variables = [
    "ip_router" => "ip_del_router",
    "user_router" => "nombre_de_usuario",
    "passwd_router" => "contraseña" // Dejar en blanco si no tiene
];

foreach ($variables as $key => $value) {
    define($key, $value);
}

?>
```

## Ejecutar el sistema web
Para poder utilizar el esistema, ,puedes utilizar `xampp` o levantar un servidor de desarrollo local desde la terminal.

```bash
php -S localhost:8000 -t "Public"
```
