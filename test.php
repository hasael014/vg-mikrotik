<?php
// establecer la zona horaria de mexico
// date_default_timezone_set("Mexico");
date_default_timezone_set("America/Mexico_City");
// echo date_default_timezone_get();
$fecha = date("Y-M-d_H:i:s");
echo $fecha;