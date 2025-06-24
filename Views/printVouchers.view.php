<?php

use App\Helpers\Functions;

function generateNumericVouchers($totalVouchers, $type, $length)
{
    switch ($type) {
        case 'numero':
            $characters = '0123456789';
            break;
        case 'letras':
            $characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
            break;
        case 'alfanumerico':
            $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
            break;
        default:
            $characters = '0123456789';
    }
    $charactersLength = strlen($characters);
    $vouchers = [];
    $users = Functions::_getUsers();
    $exist = [];

    // Usar un conjunto para verificar unicidad
    $existingVouchers = array_flip($exist);

    foreach ($users as $user) {
        $existingVouchers[$user['name']] = true;
    }

    // Generar todos los códigos posibles
    $maxVouchers = pow(10, $length);
    if ($totalVouchers > $maxVouchers - count($existingVouchers)) {
        throw new Exception("No hay suficientes códigos únicos disponibles.");
    }

    while (count($vouchers) < $totalVouchers) {
        // Generar un código de voucher aleatorio
        $voucherCode = '';
        for ($i = 0; $i < $length; $i++) {
            $voucherCode .= $characters[rand(0, $charactersLength - 1)];
        }

        // Verificar unicidad
        if (!isset($existingVouchers[$voucherCode])) {
            $vouchers[] = $voucherCode;
            $existingVouchers[$voucherCode] = true; // Marcar como existente
        }
    }

    return $vouchers;
}


// $newUser = [
//     'name' => 'nuevo_usuario', // Nombre del usuario
//     'password' => 'contraseña_segura', // Contraseña del usuario
//     'address' => '192.168.1.100', // Dirección IP estática (opcional)
//     'mac-address' => '00:11:22:33:44:55', // Dirección MAC estática (opcional)
//     'comment' => 'Usuario de prueba', // Comentario (opcional)
//     'limit-bytes-in' => '10000000', // Límite de subida en bytes (opcional)
//     'limit-bytes-out' => '10000000', // Límite de bajada en bytes (opcional)
//     'limit-uptime' => '1h', // Límite de tiempo de conexión (opcional)
//     'profile' => 'default', // Perfil del usuario (opcional)
//     'server' => 'hotspot1' // Servidor al que puede acceder (opcional)
// ];

$Users = [];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Vouchers</title>
    <link rel="stylesheet" href="/css/vouchers.css">
</head>

<body>

    <?php

    // print_r($_POST);
    switch ($_POST['duracion']) {
        case '1h':
            $header = "<div class='voucher plan-basic'>";
            $title = "<h2 class='text-xl font-bold text-blue-800'>PLAN BÁSICO</h2>";
            $duration = "<p class='text-sm text-gray-600'>" . $_POST['duracion'] . " de conexión</p>";
            $desc = "";
            break;
        case '3h':
            $header = "<div class='voucher plan-standard'>";
            $title = "<h2 class='text-xl font-bold text-green-800'>PLAN ESTÁNDAR</h2>";
            $duration = "<p class='text-sm text-gray-600'>" . $_POST['duracion'] . " de conexión</p>";
            $desc = "";
            break;
        case '1d':
            $header = "<div class='voucher plan-premium'>";
            $title = "<h2 class='text-xl font-bold text-orange-800'>PLAN PREMIUM</h2>";
            $duration = "<p class='text-sm text-gray-600'>" . $_POST['duracion'] . " de conexión</p>";
            $desc = "";
            break;
        default:
            $header = "<div class='voucher plan-unlimited'>";
            $title = "<h2 class='text-xl font-bold text-purple-800'>PLAN FLEX</h2>";
            $duration = "<p class='text-sm text-gray-600'>" . $_POST['duracion'] . " pausables</p>";
            $desc = "<p class='text-xs mt-1'>*Uso pausable cuando no estés conectado</p>";
            break;
    }

    // foreach (generateNumericVouchers(63, "numero", 6) as $voucher) {
    foreach (generateNumericVouchers($_POST['cantidad'], $_POST['formato'], $_POST['longitud']) as $voucher) {
        $newVoucher = [
            'name' => $voucher, // Nombre del usuario
            'comment' => date("Y-M-d_H:i:s"), // Comentario (opcional)
            'limit-uptime' => $_POST['duracion'], // Límite de tiempo de conexión (opcional)
            'profile' => $_POST['profile'], // Perfil del usuario (opcional)
            'server' => $_POST['server'] // Servidor al que puede acceder (opcional)
        ];
        Functions::_addVoucher($newVoucher);
        echo "$header
        <div>
            $title
            $duration
            <div class='my-2'>
                <span class='text-3xl font-bold text-blue-600'>$ " . $_POST['precio'] . ".00</span>
            </div>
        </div>
        <div>
            <p class='text-xs font-mono bg-white p-1 border border-gray-300'>Código: <span class='font-bold'>" . $voucher . "</span>
            </p>
            $desc
        </div>
        <div>
            <div class='cut-line'></div>
            <p class='text-xs text-center'>Portal: <span class='font-mono'>" . $_POST['host'] . "</span></p>
        </div>
    </div>";
    }

    ?>
</body>

</html>