<?php

namespace Config;

$routes = Services::routes();

$routes->get('exjus_myexpenses', 'Myexpenses::index', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->get('exjus_myexpenses/(:any)', 'Myexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);
$routes->post('exjus_myexpenses/(:any)', 'Myexpenses::$1', ['namespace' => 'Expenses_Justification\Controllers']);

/*
$routes->get('banner_manager_settings', 'Banner_Manager_settings::index', ['namespace' => 'Banner_Manager\Controllers']);
$routes->get('banner_manager_settings/(:any)', 'Banner_Manager_settings::$1', ['namespace' => 'Banner_Manager\Controllers']);
$routes->post('banner_manager_settings/(:any)', 'Banner_Manager_settings::$1', ['namespace' => 'Banner_Manager\Controllers']);

$routes->get('banner_manager_updates', 'Banner_Manager_Updates::index', ['namespace' => 'Banner_Manager\Controllers']);
$routes->get('banner_manager_updates/(:any)', 'Banner_Manager_Updates::$1', ['namespace' => 'Banner_Manager\Controllers']);
*/