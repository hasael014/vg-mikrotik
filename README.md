# vg-mikrotik
sistema web con la que se puede crear vouchers para routers de mikrotik y tambien imprimir los vouchers en tamaño carta.


### Creacion del archivo Config.php
Crea el archivo Config.php en el directorio ./App/Config.php
```

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