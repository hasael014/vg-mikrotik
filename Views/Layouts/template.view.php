<?php

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
</head>

<body>
    <header>
        <a href="/">
            Visel-Isp
        </a>
        <nav>
            <a href="/app/dashboard">Panel de control</a>
            <a href="/app/servers">Hotspots</a>
            <a href="/app/profiles">Planes</a>
            <a href="/app/vouchers">Vouchers</a>
        </nav>
    </header>
    <main>

        <?php

        include_once $file;

        ?>
    </main>
    <footer>
        &copy - asaelhb
    </footer>

    <script>
        $(document).ready(() => {
            $test = $('nav a')
            console.log($test.text())
        })

    </script>

</body>

</html>