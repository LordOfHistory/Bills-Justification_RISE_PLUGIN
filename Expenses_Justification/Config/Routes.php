<?php

namespace Config;

$routes = Services::routes();

$routes->get('exjus_myexpenses', 'Myexpenses::index', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_myexpenses/(:any)', 'Myexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_myexpenses/(:any)', 'Myexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_myexpenses/(:any)/(:any)', 'Myexpenses::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_myexpenses/(:any)/(:any)', 'Myexpenses::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_myexpenses/(:any)/(:any)/(:any)', 'Myexpenses::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_myexpenses/(:any)/(:any)/(:any)', 'Myexpenses::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);

$routes->get('exjus_juanma_expenses', 'Juanmaexpenses::index', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_juanma_expenses/(:any)', 'Juanmaexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_juanma_expenses/(:any)', 'Juanmaexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_juanma_expenses/(:any)/(:any)', 'Juanmaexpenses::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_juanma_expenses/(:any)/(:any)', 'Juanmaexpenses::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_juanma_expenses/(:any)/(:any)/(:any)', 'Juanmaexpenses::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_juanma_expenses/(:any)/(:any)/(:any)', 'Juanmaexpenses::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);

$routes->get('exjus_finnances', 'Finnances::index', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_finnances/(:any)', 'Finnances::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_finnances/(:any)', 'Finnances::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_finnances/(:any)/(:any)', 'Finnances::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_finnances/(:any)/(:any)', 'Finnances::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_finnances/(:any)/(:any)/(:any)', 'Finnances::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_finnances/(:any)/(:any)/(:any)', 'Finnances::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);

$routes->get('exjus_juanma', 'Juanmagestion::index', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_juanma/(:any)', 'Juanmagestion::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_juanma/(:any)', 'Juanmagestion::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_juanma/(:any)/(:any)', 'Juanmagestion::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_juanma/(:any)/(:any)', 'Juanmagestion::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_juanma/(:any)/(:any)/(:any)', 'Juanmagestion::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_juanma/(:any)/(:any)/(:any)', 'Juanmagestion::$1/$2/$3', ['namespace' => 'Expenses_Justification\Controllers']);

$routes->get('expenses_justification_settings', 'Settings::index', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('expenses_justification_settings/(:any)', 'Settings::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('expenses_justification_settings/(:any)', 'Settings::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('expenses_justification_settings/(:any)/(:any)', 'Settings::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('expenses_justification_settings/(:any)/(:any)', 'Settings::$1/$2', ['namespace' => 'Expenses_Justification\Controllers']);