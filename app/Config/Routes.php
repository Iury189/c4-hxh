<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\{Home,HunterController,RecompensaController,RecompensadoController,TipoHunterController};

/**
 * @var RouteCollection $routes
 */

 $routes->setDefaultNamespace('App\Controllers');

 //$routes->get('/', [Home::class, 'index']);

// API Restful (Address)
// GET: localhost:8080/tipo-hunter
// POST: localhost:8080/tipo-hunter
// GET: localhost:8080/tipo-hunter/{:num}
// PATCH: localhost:8080/tipo-hunter/{:num}
// DELETE: localhost:8080/tipo-hunter/{:num}
//$routes->resource('tipo-hunter', ['controller' => TipoHunterController::class]);
$routes->get('tipo-hunter', [TipoHunterController::class, 'index']);  
$routes->post('tipo-hunter', [TipoHunterController::class, 'create']);
$routes->get('tipo-hunter/(:num)', [TipoHunterController::class, 'show']);
$routes->patch('tipo-hunter/(:num)', [TipoHunterController::class, 'update']);
$routes->delete('tipo-hunter/(:num)', [TipoHunterController::class, 'delete']);

$routes->get('/', [HunterController::class, 'index'], ['as' => 'indexHunter']);
$routes->get('hunter/create', [HunterController::class, 'create']);
$routes->get('hunter/search', [HunterController::class, 'search']);
$routes->post('hunter/store', [HunterController::class, 'store']);
$routes->get('hunter/view/(:num)', [HunterController::class, 'view']);
$routes->get('hunter/edit/(:num)', [HunterController::class, 'edit']);
$routes->patch('hunter/update/(:num)', [HunterController::class, 'update']);
$routes->delete('hunter/delete/(:num)', [HunterController::class, 'delete']);
$routes->get('hunter/trash', [HunterController::class, 'onlyDeleted'], ['as' => 'trashHunter']);
$routes->get('hunter/search-trash', [HunterController::class, 'searchTrash']);
$routes->get('hunter/restore/(:num)', [HunterController::class, 'restoreDeleted']);
$routes->delete('hunter/delete-permantently/(:num)', [HunterController::class, 'deletePermanently']);
$routes->get('logs', [HunterController::class, 'logsView']);

$routes->get('recompensa/index', [RecompensaController::class, 'index'], ['as' => 'indexRecompensa']);
$routes->get('recompensa/create', [RecompensaController::class, 'create']);
$routes->get('recompensa/search', [RecompensaController::class, 'search']);
$routes->get('recompensa/search-trash', [RecompensaController::class, 'searchTrash']);
$routes->post('recompensa/store', [RecompensaController::class, 'store']);
$routes->get('recompensa/view/(:num)', [RecompensaController::class, 'view']);
$routes->get('recompensa/edit/(:num)', [RecompensaController::class, 'edit']);
$routes->patch('recompensa/update/(:num)', [RecompensaController::class, 'update']);
$routes->delete('recompensa/delete/(:num)', [RecompensaController::class, 'delete']);
$routes->get('recompensa/trash', [RecompensaController::class, 'onlyDeleted'], ['as' => 'trashRecompensa']);
$routes->get('recompensa/restore/(:num)', [RecompensaController::class, 'restoreDeleted']);
$routes->delete('recompensa/delete-permantently/(:num)', [RecompensaController::class, 'deletePermanently']);

$routes->get('recompensado/index', [RecompensadoController::class, 'index'], ['as' => 'indexRecompensado']);
$routes->get('recompensado/create', [RecompensadoController::class, 'create']);
$routes->get('recompensado/search', [RecompensadoController::class, 'search']);
$routes->post('recompensado/store', [RecompensadoController::class, 'store']);
$routes->get('recompensado/view/(:num)', [RecompensadoController::class, 'view']);
$routes->get('recompensado/edit/(:num)', [RecompensadoController::class, 'edit']);
$routes->patch('recompensado/update/(:num)', [RecompensadoController::class, 'update']);
$routes->delete('recompensado/delete/(:num)', [RecompensadoController::class, 'delete']);
$routes->get('recompensado/trash', [RecompensadoController::class, 'onlyDeleted'], ['as' => 'trashRecompensado']);
$routes->get('recompensado/search-trash', [RecompensadoController::class, 'searchTrash']);
$routes->get('recompensado/restore/(:num)', [RecompensadoController::class, 'restoreDeleted']);
$routes->delete('recompensado/delete-permantently/(:num)', [RecompensadoController::class, 'deletePermanently']);