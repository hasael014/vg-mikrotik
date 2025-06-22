<?php

use App\Router;


date_default_timezone_set('America/Mexico_City');

session_start();
/**
 * 
 * 
 * header("Access-Control-Allow-Origin: *");
 * header("Content-Type: application/json; charset=UTF-8");
 * 
 *  // Permitir métodos HTTP necesarios (GET, POST, etc.)
 * header("Access-Control-Allow-Methods: GET, POST");
 * header("Access-Control-Allow-Headers: Content-Type, Authorization");
 * 
 * 
 */


include_once __DIR__.'/../autoload.php';

include_once __DIR__ . "/../App/Routes.php";

// include_once __DIR__."/../Views/Layouts/template.view.php";

Router::App();