<?php

use App\Helpers\Functions;
// print_r($_POST);

/*function generateNumericVouchers($totlaVouchers, $lenght)
{
    $characters = '0123456789';
    $charactersLenght = strlen($characters);
    $vouchers = [];
    $users = Functions::_getUsers();
    $exist = [];

    foreach ($users as $user) {
        $exist[] = $user['name'];
    }

    for ($gg = 0; $gg < $totlaVouchers; $gg++) {

        do {

            $voucherCode = '';
            // Generar el codigó del voucher 
            for ($is = 0; $is < $lenght; $is++) {
                $voucherCode .= $characters[rand(0, $charactersLenght - 1)];
            }
            // Esto asignará true a $unique si $voucherCode no está en ninguno de los dos arrays, y false en caso contrario.
            $unique = !(in_array($voucherCode, $vouchers) || in_array($voucherCode, $exist));

        } while ($unique);

        $vouchers[] = $voucherCode;

    }

    return $vouchers;

}*/

//     switch (charType) {
//         case 'numero':
//             characters = '0123456789';
//             break;
//         case 'letras':
//             characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
//             break;
//         case 'alfanumerico':
//             characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
//             break;
//         // case 'custom':
//         //     characters = customChars.toLowerCase();
//         //     break;
//         default:
//             characters = '0123456789';
//     }

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Vouchers</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        @page {
            size: letter landscape;
            margin: 0.13in
        }

        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            box-sizing: border-box;
        }

        body {
            /* max-width: 11in; */
            /* min-height: 8.5in; */
            /* border: solid 1px red; */
            background: none;
            color: black;
            font-size: 12pt;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            /* flex-direction: row; */
            /* flex-wrap: wrap; */
            /* align-items: center; */
            /* align-content: center; */
            /* justify-content: center; */
        }

        .voucher {
            /* width: 1.75in; */
            /* max-width: max-content; */
            /* height: 0.78in; */
            page-break-inside: avoid;
            border: 1px solid black;
            display: inline-block;
            text-align: center;
        }

        .url {
            background-color: #000000;
            color: white;
            padding: 0 4px
        }

        .code {
            display: grid;
            gap: 2px;
            justify-items: center;
        }

        .code>b {
            max-width: max-content;
            color: white;
            background-color: grey;
            padding: 2px 5px;
            border-radius: 9999px
        }
    </style>
</head>

<body>


    <?php

    foreach (generateNumericVouchers($_POST['cantidad'], $_POST['formato'], $_POST['longitud']) as $voucher) {
        $newVoucher = [
            'name' => $voucher, // Nombre del usuario
            'comment' => 'Usuario por visel-isp', // Comentario (opcional)
            'limit-uptime' => $_POST['duracion'], // Límite de tiempo de conexión (opcional)
            'profile' => $_POST['profile'], // Perfil del usuario (opcional)
            'server' => $_POST['server'] // Servidor al que puede acceder (opcional)
        ];
        Functions::_addVoucher($newVoucher);
        echo "<div class='voucher'>
    <p class='url'>" . $_POST['ssl'] . "://" . $_POST['host'] . "</p>
    <p class='code'>Código: <b>" . $voucher . "</b></p>
    <p class='precio'>$ " . $_POST['precio'] . " MXN</p>
    </div>";
    }

    // print_r($Users);
    
    // for ($cant = 0; $cant < $_POST['cantidad']; $cant++){
// }
    
    ?>
</body>

</html>