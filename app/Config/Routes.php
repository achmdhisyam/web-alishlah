<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('akun_pendaftar', 'Akun_pendaftar::index');
    $routes->get('akun_pendaftar/tambah', 'Akun_pendaftar::tambah');
    $routes->post('akun_pendaftar/store', 'Akun_pendaftar::store');
    $routes->get('akun_pendaftar/edit/(:num)', 'Akun_pendaftar::edit/$1');
    $routes->post('akun_pendaftar/update/(:num)', 'Akun_pendaftar::update/$1');
    $routes->get('akun_pendaftar/delete/(:num)', 'Akun_pendaftar::delete/$1');
    $routes->post('admin/akun_pendaftar/proses', 'Admin\Akun_pendaftar::proses');
    

});
//lupa pendaftar
$routes->match(['get', 'post'], 'signin/password/(:any)', 'Signin::password/$1');

//lupa admin
$routes->get('login', 'Login::index');
$routes->post('login', 'Login::index');

$routes->get('login/lupa', 'Login::lupa');
$routes->post('login/lupa', 'Login::lupa');

$routes->get('login/reset/(:any)', 'Login::reset/$1');
$routes->post('login/reset/(:any)', 'Login::reset/$1');

$routes->get('logout', 'Login::logout');

// Google Auth Routes
$routes->get('googleauth/login/(:any)', 'GoogleAuth::login/$1');
$routes->get('googleauth/callback', 'GoogleAuth::callback');
