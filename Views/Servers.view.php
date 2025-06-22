<?php

use App\Helpers\Functions;

?>
<section>
    <div class="header">
        <h2>Lista de Usuarios</h2>
        <div class="nav">
            <a href="/app/create/voucher">Generar voucher</a>
        </div>
    </div>
    <input type="search" name="filter" id="filter" placeholder="Buscar...">
    <?php
    $params = [
        "Id" => ".id",
        "Nombre" => "name",
        "Ip"=>"hotspot-address",
        "Dns"=>"dns-name",
        "Acceso"=>"login-by"
    ];
    Functions::_table(Functions::_getServer(), $params, "/app/vouchers");
    ?>
</section>