<?php

namespace App\Helpers;

use Exception;
use RouterosAPI;

include 'routeros_api.class.php';

class Mikrotik
{
    public static function connect()
    {

        $rb = new RouterosAPI;
        try {
            if ($rb->connect('ip', 'usernanme', 'password')) {
                return $rb;
            } else {
                new Exception("Error Processing Request", 1);
            }
        } catch (Exception $e) {
            echo "error:" . $e;
            exit();
        }
    }
}