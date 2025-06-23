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
    <link rel="stylesheet" href="/css/vouchers.css">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <style>
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
            font-family: 'Arial', sans-serif;
            background: none;
            color: black;
            font-size: 12pt;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
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
            border: 1px solid #e2e8f0;
            display: inline-block;
            text-align: center;
        }

        .cut-line {
            border-top: 1px dashed #cbd5e0;
            margin: 8px 0;
        }

        .plan-basic {
            background-color: #ebf8ff;
            border-left: 4px solid #3182ce;
        }

        .plan-standard {
            background-color: #f0fff4;
            border-left: 4px solid #38a169;
        }

        .plan-premium {
            background-color: #fffaf0;
            border-left: 4px solid #dd6b20;
        }

        .plan-unlimited {
            background-color: #faf5ff;
            border-left: 4px solid #9f7aea;
        }
    </style> -->
</head>

<body>

    <!-- <div class='voucher plan-basic'>
  -- <div class='voucher plan-basic p-3 flex flex-col justify-between'> --
    <div>
      <h2 class='text-xl font-bold text-blue-800'>PLAN BÁSICO</h2>
      <p class='text-sm text-gray-600'>1 hora de conexión</p>
      <div class='my-2'>
        <span class='text-3xl font-bold text-blue-600'>$1.00</span>
      </div>
    </div>
    <div>
      <p class='text-xs font-mono bg-white p-1 border border-gray-300'>Código: W1H-<span class='font-bold'>X3F9K2</span>
      </p>
      !-- <p class='text-xs mt-1'>Velocidad: 6Mbps</p> --
    </div>
    <div>
      <div class='cut-line'></div>
      <p class='text-xs text-center'>Portal: <span class='font-mono'>wifi.example.com/auth</span></p>
    </div>
  </div> -->


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
        // $newVoucher = [
        //     'name' => $voucher, // Nombre del usuario
        //     'comment' => date("Y-M-d_H:i:s"), // Comentario (opcional)
        //     'limit-uptime' => $_POST['duracion'], // Límite de tiempo de conexión (opcional)
        //     'profile' => $_POST['profile'], // Perfil del usuario (opcional)
        //     'server' => $_POST['server'] // Servidor al que puede acceder (opcional)
        // ];
        // Functions::_addVoucher($newVoucher);
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

    // print_r($Users);
    
    // for ($cant = 0; $cant < $_POST['cantidad']; $cant++){
// }
    
    ?>
</body>

</html>