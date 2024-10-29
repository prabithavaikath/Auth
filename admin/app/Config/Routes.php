<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('register', 'UserController::register');
$routes->post('login', 'AuthController::login');
$routes->post('logout', 'AuthController::logout');
$routes->get('fetch-data', 'DashboardController::fetchDataBasedOnRole');

$routes->group('admin', ['filter' => 'auth:Admin'], function($routes) {
    $routes->get('view', 'AdminController::view');
    $routes->delete('delete/(:num)', 'AdminController::delete/$1');
});

$routes->group('superadmin', ['filter' => 'auth:SuperAdmin'], function($routes) {
    $routes->post('add', 'SuperAdminController::add');
    $routes->put('update/(:num)', 'SuperAdminController::update/$1');
    $routes->delete('delete/(:num)', 'SuperAdminController::delete/$1');
});
