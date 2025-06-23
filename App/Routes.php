<?php

use App\Controllers\ApiController;
use App\Controllers\MainController;
use App\Router;

/**
 * 
 * Rutas de la app
 * 
 */

Router::get('/', MainController::class, 'ajust');
Router::get('/app/dashboard', MainController::class, 'Dashboard');
Router::get('/app/create/voucher', MainController::class, 'createVoucher');
Router::get('/app/vouchers', MainController::class, 'Vouchers');
Router::get('/app/vouchers/{page}', MainController::class, 'Vouchers');
Router::post('/app/voucher/create', MainController::class, 'VouchersCreate');
Router::get('/app/profiles', MainController::class, 'listProfiles');
Router::get('/app/servers', MainController::class, 'listServers');
Router::get('/app/voucher/create', MainController::class, 'VouchersCreate');

/**
 * 
 * Rutas de la api
 * 
 */
Router::get('/api/{query}', ApiController::class, 'getQuery');
// Router::get('/api/{query}/{search}', ApiController::class, 'getQuery');
// Router::get('/api/users/{key}/{value}', ApiController::class, 'getUsers');
// Router::get('/api/plans', ApiController::class, 'getPlans');
// Router::get('/api/plans/{key}/{value}', ApiController::class, 'getPlans');
// Router::get('/api/users/actives', ApiController::class, 'getUsersActives');
Router::get('/api/servers', ApiController::class, 'getServers');

// Router::App();