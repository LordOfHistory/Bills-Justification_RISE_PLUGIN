<?php

ini_set('max_execution_time', 300); //300 seconds 

$product = "Expenses_Justification";

$db = db_connect('default');

//Comprueba que esté el archivo database.sql
if (!is_file(PLUGINPATH . "$product/install/database.sql")) {
    echo json_encode(array("success" => false, "message" => "The database.sql file could not found in install folder!"));
    exit();
}

//start installation
$sql = file_get_contents(PLUGINPATH . "$product/install/database.sql");

$dbprefix = get_db_prefix();

//set database prefix
$sql = str_replace('CREATE TABLE IF NOT EXISTS `', 'CREATE TABLE IF NOT EXISTS `' . $dbprefix, $sql);
$sql = str_replace('INSERT INTO `', 'INSERT INTO `' . $dbprefix, $sql);
$sql = str_replace('ALTER TABLE `', 'ALTER TABLE `' . $dbprefix, $sql);

$sql_explode = explode('#', $sql);
foreach ($sql_explode as $sql_query) {
    $sql_query = trim($sql_query);
    if ($sql_query) {
        $db->query($sql_query);
    }
}

