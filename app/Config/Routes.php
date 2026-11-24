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


// Rutas de administración de archivos
$routes->get('archivos', 'Archivos::index');
$routes->post('archivos/subir', 'Archivos::subir');
$routes->get('archivos/descargar/(:segment)', 'Archivos::descargar/$1');
$routes->post('archivos/eliminar/(:segment)', 'Archivos::eliminar/$1');

// Rutas de generación de documentos
$routes->get('documentos', 'Documentos::index');
$routes->post('documentos/word', 'Documentos::word');
$routes->post('documentos/excel', 'Documentos::excel');
$routes->post('documentos/pdf', 'Documentos::pdf');

// Rutas de administración de imágenes
$routes->get('imagenes', 'Imagenes::index');
$routes->post('imagenes/subir', 'Imagenes::subir');
$routes->post('imagenes/eliminar/(:segment)', 'Imagenes::eliminar/$1');
$routes->get('imagenes/ver/(:segment)', 'Imagenes::ver/$1');
