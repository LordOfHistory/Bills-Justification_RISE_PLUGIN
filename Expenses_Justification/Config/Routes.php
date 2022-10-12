<?php

namespace Config;

$routes = Services::routes();

$routes->get('exjus_myexpenses', 'Myexpenses::index', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_myexpenses/(:any)', 'Myexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_myexpenses/(:any)', 'Myexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_myexpenses/(:any)/(:any)', 'Myexpenses::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_myexpenses/(:any)/(:any)', 'Myexpenses::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);