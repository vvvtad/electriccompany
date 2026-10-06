<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');
$routes->match(['get', 'post'], '/contact', 'Contact::index');

$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::create');

$routes->get('/accounts', 'CustomerAccounts::index');
$routes->get('/account/(:num)', 'CustomerAccounts::viewAccount/$1');

$routes->get('/account/edit/(:num)', 'CustomerAccounts::edit/$1');
$routes->post('/account/update/(:num)', 'CustomerAccounts::update/$1');

$routes->post('/account/delete/(:num)', 'CustomerAccounts::delete/$1');

$routes->get('/login', 'Login::index');
$routes->post('/login', 'Login::authenticate');

$routes->get('/logout', 'Login::logout');