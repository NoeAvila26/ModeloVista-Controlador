<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');
$routes->get('inicio', 'Home::index');

// Rutas de usuarios
$routes->get('usuarios', 'Usuarios::index');

// Mostrar formulario de creación
$routes->get('usuarios/crear', 'Usuarios::crear');

// Procesar registro de usuario
$routes->post('usuarios/guardar', 'Usuarios::guardar');

// Mostrar formulario de edición
$routes->get('usuarios/editar/(:segment)', 'Usuarios::editar/$1');

// Procesar actualización de usuario
$routes->post('usuarios/actualizar/(:segment)', 'Usuarios::actualizar/$1');

// Procesar eliminación de usuario
$routes->post('usuarios/eliminar/(:segment)', 'Usuarios::eliminar/$1');


// Rutas de autenticación
$routes->get('login', 'Auth::login');
$routes->post('autenticar', 'Auth::autenticar');
$routes->post('salir', 'Auth::salir');
