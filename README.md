# vg-mikrotik
sistema web con la que se puede crear vouchers para routers de mikrotik y tambien imprimir los vouchers en tamaño carta.


### Creacion del archivo Config.php
Crea el archivo Config.php en el directorio ./App/Config.php
```

<?php

$variables = [
    "ip_router"=>"ip",
    "user_router"=>"username",
    "passwd_router"=>"contraseña (si tiene una)"
];

foreach($variables as $key => $value){
 define($key, $value);
}

```