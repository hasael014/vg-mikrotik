<?php
// Simulación de datos (en un caso real, esto vendría de una base de datos)
$data = [];
for ($i = 1; $i <= 100; $i++) {
    $data[] = "Elemento $i";
}

$itemsPerPage = 10;
$totalItems = count($data);
$totalPages = ceil($totalItems / $itemsPerPage);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Filtrar datos según la búsqueda
if ($search) {
    $data = array_filter($data, function($item) use ($search) {
        return stripos($item, $search) !== false;
    });
}

$totalItems = count($data);
$totalPages = ceil($totalItems / $itemsPerPage);
$offset = ($page - 1) * $itemsPerPage;
$data = array_slice($data, $offset, $itemsPerPage);

// Generar tabla
$table = '<table><tr><th>Datos</th></tr>';
foreach ($data as $item) {
    $table .= "<tr><td>$item</td></tr>";
}
$table .= '</table>';

// Generar paginación
$pagination = '<div>';
for ($i = 1; $i <= $totalPages; $i++) {
    $active = ($i == $page) ? 'style="font-weight:bold;"' : '';
    $pagination .= "<span class='page-link' data-page='$i' $active>$i</span> ";
}
$pagination .= '</div>';

// Devolver resultados como JSON
echo json_encode(['table' => $table, 'pagination' => $pagination]);