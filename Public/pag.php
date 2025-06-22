<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginador y Buscador Dinámico</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Tabla de Datos</h1>
<input type="text" id="search" placeholder="Buscar...">
<div id="table-container"></div>
<div id="pagination"></div>

<script>
$(document).ready(function() {
    loadData(1); // Cargar la primera página al inicio

    // Función para cargar datos
    function loadData(page, query = '') {
        $.ajax({
            url: 'pag-back.php',
            type: 'GET',
            data: { page: page, search: query },
            success: function(data) {
                const result = JSON.parse(data);
                $('#table-container').html(result.table);
                $('#pagination').html(result.pagination);
            }
        });
    }

    // Evento de búsqueda
    $('#search').on('keyup', function() {
        const query = $(this).val();
        loadData(1, query); // Cargar la primera página con la búsqueda
    });

    // Delegar evento de paginación
    $(document).on('click', '.page-link', function() {
        const page = $(this).data('page');
        const query = $('#search').val();
        loadData(page, query);
    });
});
</script>

</body>
</html>