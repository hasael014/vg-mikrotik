<?php

namespace App\Controllers;

use App\Helpers\Functions;

class ApiController
{
    public function getUsers($arr = [])
    {
        $where = [];

        if (!empty($arr)) {

            $where['?' . $arr['key']] = $arr['value'];

            // $res = Functions::_getUsers($where);
        }

        $res = Functions::_getUsers($where);

        echo Functions::_hapi($res);
    }

    public function getPlans()
    {
        $res = Functions::_getPlans();

        echo Functions::_hapi($res);

    }

    public function getUsersActives()
    {
        $res = Functions::_getUsersActive();
        echo Functions::_hapi($res);
    }

    public function getServers()
    {
        $res = Functions::_getServer();
        echo Functions::_hapi($res);
    }

    public function forVoucher()
    {

        $datos = [
            "server" => Functions::_getServer(),
            "plan" => Functions::_getPlans()
        ];

        return $datos;
    }

    // public function getQuery($params)
    // {

    //     $help = [
    //         "users" => "_getUsers",
    //         "plans"=>"_getPlans",
    //         "actives"=>"_getUsersActive",
    //         "profiles"=>"_getServer"
    //     ];

    //     $func = $help[$params['query']];


    //     $method = Functions::$func();

    //     echo Functions::_hapi(Functions::_table($method));
    //     // print_r($params);
    // }




    // .id
// name
// address-pool
// session-timeout
// idle-timeout
// status-autorefresh
// shared-users
// add-mac-cookie
// mac-cookie-timeout
// rate-limit
// parent-queue
// address-list
// transparent-proxy





    // public function getQuery()
    // {
    //     $array = Functions::_getPlans();

    //     foreach ($array as $objeto) {
    //         // print_r($objeto);
    //         foreach ($objeto as $key => $val) {
    //             echo $key . "=>" . $val . "</br>";
    //         }
    //         echo "<br><br>";
    //     }

    //     // print_R($array);

    // }

    public function getQuery($params)
    {
        $help = [
            "users" => "_getUsers",
            "plans" => "_getPlans",
            "actives" => "_getUsersActive",
            "profiles" => "_getServer"
        ];

        $func = $help[$params['query']] ?? null; // Asegúrate de que la clave existe

        if ($func) {
            $method = Functions::{$func}();
        } else {
            // Manejo de error si la función no existe
            echo "Función no válida.";
            return;
        }

        $perPage = 10;
        $totalItems = count($method);
        $totalPages = ceil($totalItems / $perPage);

        $page = $_GET['pagina'] ?? 1;
        $filter = $_GET['search'] ?? '';

        /**
         * mi idea es que en la funcion reciba en un array los parametros o los datos que se mostraran en la tabla y que con base al array al momento de hacer una 
         * busqueda o filtrar los datos busque en todo los parametros que se mostraran ahciendo en un foreach el array y dentro del foreach que se ejecute en 
         * fltrador que esta abajo
         */

        // Filtrar los datos
        $filteredMethod = $filter ? array_filter($method, fn($item) => stripos($item['name'], $filter) !== false) : $method;

        $totalItems = count($filteredMethod);
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($page - 1) * $perPage;
        $method = array_slice($filteredMethod, $offset, $perPage);

        $table = '<table><tr><th>Datos</th></tr>';
        foreach ($method as $item) {
            if (isset($item['name'])) { // Verificar si 'name' existe
                $table .= "<tr><td>" . htmlspecialchars($item['name']) . "</td></tr>";
            }
        }
        $table .= '</table>';

        $pagination = '<div>';
        for ($i = 1; $i <= $totalPages; $i++) { // Cambiado < a <= para incluir la última página
            $active = ($i == $page) ? 'style="font-weight:bold;"' : '';
            $pagination .= "<span class='page-link' data-page='$i' $active>$i</span>";
        }
        $pagination .= "</div>";

        echo Functions::_hapi(["tabla" => $table, "pagination" => $pagination]);
    }


}