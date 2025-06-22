<?php

namespace App\Helpers;

use App\Helpers\Mikrotik;

/**
 * 
 * para eviar parametros a mikrotik: ['?name'=>'2648']
 * 
 */

class Functions
{

    public static function _getPlans($arr = [])
    {
        return Mikrotik::connect()->comm('/ip/hotspot/user/profile/print');

    }

    public static function _getUsersActive($arr = [])
    {
        return Mikrotik::connect()->comm('/ip/hotspot/active/print');
    }

    public static function _getUsers($arr = [])
    {
        if (!empty($arr)) {
            return Mikrotik::connect()->comm('/ip/hotspot/user/print', $arr);
        } else {
            return Mikrotik::connect()->comm('/ip/hotspot/user/print');
        }

    }

    public static function _getServer()
    {
        return Mikrotik::connect()->comm('/ip/hotspot/profile/print');
    }

    public static function _addVoucher($newUser)
    {
        // $API->comm('/ip/hotspot/user/add', $newUser );
        return Mikrotik::connect()->comm('/ip/hotspot/user/add', $newUser);
    }

    // public static function _getVoucher($arr = [])
    // {
    //     return Mikrotik::connect()->comm('/ip/hotspot/user/print');
    // }

    public static function sendResponse($statusCode, $data = null)
    {
        http_response_code($statusCode);
        if (isset($data)) {
            echo json_encode($data);
        } else {
            switch ($statusCode) {
                /**
                 * Cuando un methodo sea incorrecto
                 */
                case '405':
                    echo json_encode(["status" => "error", "message" => "Method Not Allowed"]);
                    break;
                /**
                 * Cuando el usuario envia datos invalidos o malformados
                 */
                case '422':
                    echo json_encode(["status" => "error", "message" => "Unprocessable Entity"]);
                    break;
                /**
                 * Tras borrar un recurso
                 */
                case '204':
                    /**
                     * si la eliminacion fue exitosa
                     */
                    echo json_encode(["status" => "error", "message" => "Not Content"]);
                    break;
                case '404':
                    /**
                     * si el recurso no existía
                     */
                    echo json_encode(["status" => "error", "message" => "Not Found"]);
                    break;
                /**
                 * Cuando la base de datos no responde, (o en general, en cualquier servicio)
                 */
                case '503':
                    echo json_encode(["status" => "error", "message" => "Service Unavailable"]);
                    break;
                /**
                 * Si un consumidor hace una solicitud a una ruta protegida, pero no se ha autenticado
                 */
                case '401':
                    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
                    break;
                /**
                 * en solicitudes autenticadas pero sin permisos suficientes
                 */
                case '403':
                    echo json_encode(["status" => "error", "message" => "Forbidden"]);
                    break;
                /**
                 * Si un consumidor va a crear un recurso que ya existe, un duplicado
                 */
                case '409':
                    echo json_encode(["status" => "error", "message" => "Conflict"]);
                    break;
                /**
                 * para ok
                 */
                // case '200':
                //     echo json_encode(["status" => "success", "message" => "Request Received"]);
                //     break;
                default:
                    echo json_encode(["status" => "error", "message" => "Not Found"]);
                    break;
            }
        }
        exit;
    }

    public static function view($view, $params = [])
    {
        $file = __DIR__ . "/../../Views/" . $view . ".view.php";

        if (file_exists($file)) {

            $params['title'] = $view;

            if (!empty($params)) {
                foreach ($params as $var => $val) {
                    $$var = $val;
                }
            }

            // include_once $file;
            include_once __DIR__ . "/../../Views/Layouts/template.view.php";
        } else {
            echo "El sitio no exites";
        }

    }

    public static function redirect($path, $mess = [])
    {

        if (!empty($mess)) {
            foreach ($mess as $name => $val) {
                $_SESSION[$name] = $val;
            }
        }

        header("Location: {$path}");

    }

    public static function _hapi($data)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // Permitir métodos HTTP necesarios (GET, POST, etc.)
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        return json_encode($data);

    }

    // public static function _table($data, $fil){
    //     $perPage = 10;
    //     $totalItems = count($data);
    //     $totalPages = ceil($totalItems / $perPage);

    //     $page = $_GET['pagina'] ?? 1;
    //     $filter = $fil ?? '';

    //     // $data = $filter ? array_filter($data, fn($item) => stripos($item, $filter) !== false) : $data;


    //     $data = $filter ? array_filter($data, fn($item) => stripos($item, $filter) ) : $data;

    //     $totalItems = count($data);
    //     $totalPages = ceil($totalItems/$perPage);
    //     $offset = ($page-1)*$perPage;
    //     $data = array_slice($data, $offset, $perPage);

    //     $table = '<table><tr><th>Datos</th></tr>';
    //     foreach($data as $item){
    //         $table .= "<tr><td>".$item['name']."</td></tr>";
    //     }
    //     $table .= '</table>';

    //     $pagination = '<div>';

    //     for($i = 0; $i < $totalPages; $i++){
    //         $active = ($i == $page) ? 'style="font-weight:bold;"' : '';
    //         $pagination .= "<span class='page-link' data-page='$i' $active>$i</span>";
    //     }
    //     $pagination .= "</div>";

    //     return json_encode(["tabla"=>$table, "pagination"=>$pagination]);

    // }

    /*** 
     * Funcio que creamos>>>>
     public static function _table($array, $params, $path, $perPage = 10)
    {
        $totalItems = count($array);
        $totalPages = ceil($totalItems / $perPage);

        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $perPage;
        $data = array_slice($array, $offset, $perPage);

        $param = [];
        foreach ($params as $itm) {
            $param[] = $itm;
        }

        $table = '<div class="dataTable"><table class="table"><thead><tr>';
        foreach ($params as $key => $val) {
            $table .= "<th>$key</th>";
        }
        $table .= '</tr>
        </thead>
        <tbody class="tbody">';

        foreach ($data as $item) {
            $table .= "<tr>";
            foreach ($param as $par) {
                $table .= "<td>";
                if ($par === "bytes-in" || $par === "bytes-out") {
                    $datos = $item[$par];
                    if ($datos > 1024) {
                        $datos /= 1024;
                        if ($datos > 1024) {
                            $datos /= 1024;
                            if ($datos > 1024) {
                                $datos /= 1024;
                                $table .= number_format($datos, 2) . " Gb";
                            } else {
                                $table .= number_format($datos, 2) . " Mb";
                            }// Mb
                        } else {
                            $table .= number_format($datos, 2) . " Kb";
                        }// Kb
                    } else {
                        $table .= number_format($datos, 2) . " B";
                    }// B
                } else {
                    $table .= $item[$par] ?? '------';
                }
                $table .= "</td>";
            }
            $table .= "</tr>";
        }

        $table .= "</tbody></table>";

        $left = "<a href='$path?page=" . ($page - 1) . "'>Ant.</a>";
        $right = "<a href='$path?page=" . ($page + 1) . "'>Sig.</a>";
        $separ = "<span>...</span>";

        $pagination = '';
        if ($totalPages > 1) {
            $pagination .= '<div class="paginador">';

            $pagination .= ($page > 1) ? $left : '';

            $pagination .= ($page > 4) ? "<a href='$path?page=1'>01</a>$separ" : '';

            if (($page - 2) < 1 || $page < 5) {
                $i = 1;
            } else {
                $i = $page - 2;
            }

            if (($page + 3) > $totalPages || $totalPages - 3 <= $page) {
                $length = $totalPages;
                $length++;
            } else {
                $length = $page + 3;
            }

            for ($i; $i < $length; $i++) {
                $front = $i < 10 ? "0$i" : $i;
                $active = ($i == $page) ? 'class="active"' : '';
                $pagination .= "<a href='$path?page=$i' $active>$front</a>";
            }


            $pagination .= ($page < $totalPages - 3) ? "$separ<a href='$path?page=$totalPages'>$totalPages</a>" : '';
            $pagination .= ($page < $totalPages) ? $right : '';

            $pagination .= "</div>";
        }

        echo $table;

        echo $pagination;
        echo "</div>";
    }*/

    public static function _table($array, $params, $path, $perPage = 10)
    {
        $totalItems = count($array);
        $totalPages = ceil($totalItems / $perPage);

        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $perPage;
        $data = array_slice($array, $offset, $perPage);

        $param = array_values($params); // Usar array_values para obtener solo los valores

        $tableRows = [];
        foreach ($data as $item) {
            $row = "<tr>";
            foreach ($param as $par) {
                $row .= "<td>";
                if ($par === "bytes-in" || $par === "bytes-out") {
                    $datos = $item[$par] ?? 0; // Usar 0 si no existe
                    $row .= self::formatBytes($datos);
                } else {
                    $row .= $item[$par] ?? '------';
                }
                $row .= "</td>";
            }
            $row .= "</tr>";
            $tableRows[] = $row; // Almacenar la fila en un array
        }

        $table = '<div class="dataTable"><table class="table"><thead><tr>';
        foreach ($params as $key => $val) {
            $table .= "<th>$key</th>";
        }
        $table .= '</tr></thead><tbody class="tbody">' . implode('', $tableRows) . "</tbody></table>";

        $pagination = self::generatePagination($page, $totalPages, $path);

        echo $table;
        echo $pagination;
        echo "</div>";
    }

    private static function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . " Gb";
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . " Mb";
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . " Kb";
        } else {
            return number_format($bytes, 2) . " B";
        }
    }

    private static function generatePagination($page, $totalPages, $path)
    {
        $pagination = '';
        if ($totalPages > 1) {
            $pagination .= '<div class="paginador">';
            $pagination .= ($page > 1) ? "<a href='$path?page=" . ($page - 1) . "'>Ant.</a>" : '';

            if ($page > 4) {
                $pagination .= "<a href='$path?page=1'>01</a><span>...</span>";
            }

            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);

            for ($i = $start; $i <= $end; $i++) {
                $active = ($i == $page) ? 'class="active"' : '';
                $pagination .= "<a href='$path?page=$i' $active>" . str_pad($i, 2, '0', STR_PAD_LEFT) . "</a>";
            }

            if ($page < $totalPages - 2) {
                $pagination .= "<span>...</span><a href='$path?page=$totalPages'>$totalPages</a>";
            }
            $pagination .= ($page < $totalPages) ? "<a href='$path?page=" . ($page + 1) . "'>Sig.</a>" : '';
            $pagination .= "</div>";
        }
        return $pagination;
    }


}