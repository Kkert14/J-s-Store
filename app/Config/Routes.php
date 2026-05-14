<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
| AUTH ROUTES
*/
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::auth');
$routes->get('/logout', 'Auth::logout');
$routes->get('/unauthorized', 'Error::unauthorized');

/*
| DASHBOARD (ALL LOGGED IN USERS)
*/
$routes->get('/dashboard', 'Dashboard::index');


/*
| ADMIN ONLY ROUTES
*/
$routes->group('', ['filter' => 'rolefilter:admin'], function ($routes) {

    // Users / Accounts
    $routes->get('/users', 'Users::index');
    $routes->post('users/save', 'Users::save');
    $routes->get('users/edit/(:segment)', 'Users::edit/$1');
    $routes->post('users/update', 'Users::update');
    $routes->delete('users/delete/(:num)', 'Users::delete/$1');
    $routes->post('users/delete/(:num)', 'Users::delete/$1');
    $routes->post('users/fetchRecords', 'Users::fetchRecords');

    // Logs
    $routes->get('/log', 'Logs::log');

    // Categories
    $routes->get('/category', 'Category::index');
    $routes->post('category/save', 'Category::save');
    $routes->get('category/edit/(:segment)', 'Category::edit/$1');
    $routes->post('category/update', 'Category::update');
    $routes->delete('category/delete/(:num)', 'Category::delete/$1');
    $routes->post('category/fetchRecords', 'Category::fetchRecords');

    // Products
    $routes->get('/product', 'Product::index');
    $routes->post('product/save', 'Product::save');
    $routes->get('product/edit/(:segment)', 'Product::edit/$1');
    $routes->post('product/update', 'Product::update');
    $routes->delete('product/delete/(:num)', 'Product::delete/$1');
    $routes->post('product/fetchRecords', 'Product::fetchRecords');
});
    $routes->post('product/adjustStock', 'Product::adjustStock');


/*
| CASHIER + ADMIN
*/
$routes->group('', ['filter' => 'rolefilter:admin,cashier'], function ($routes) {
    $routes->get('/pos', 'Pos::index');
    $routes->get('pos/searchProducts', 'Pos::searchProducts');
    $routes->post('pos/checkout', 'Pos::checkout');

    $routes->get('/sales', 'Sales::index');
    $routes->post('sales/fetchRecords', 'Sales::fetchRecords');
    $routes->get('sales/receipt/(:num)', 'Sales::receipt/$1');
    $routes->post('sales/void/(:num)', 'Sales::void/$1');
});
