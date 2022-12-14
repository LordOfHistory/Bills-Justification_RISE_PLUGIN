<?php

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
  Plugin Name: Expenses Justification
  Description: RISE CRM plugin to manage all the workflow to justificate expenses.
  Version: 0.5
  Requires at least: 3.0
  Author: JMCandilejo
  Author URL: https://github.com/LordOfHistory/Bills-Justification_RISE_PLUGIN
 */

//add menu item to left menu
app_hooks()->add_filter('app_filter_staff_left_menu', 'expenses_justification');

if (!function_exists('expenses_justification')) {

    function expenses_justification($sidebar_menu) {
        $have_expenses = false;
        if (is_admin() || can_manage_myexpenses()){
            $have_expenses = true;
            $sidebar_submenu["myexpenses"] = array(
                "name" => "myexpenses",
                "url" => "exjus_myexpenses",
            );
        }
        if (is_admin() || can_manage_juanma_expenses()){
            $have_expenses = true;
            $sidebar_submenu["juanma_expenses"] = array(
                "name" => "juanma_expenses",
                "url" => "exjus_juanma_expenses",
            );
        }
        if (is_finnances()){
            $have_expenses = true;
            $sidebar_submenu["finnances"] = array(
                "name" => "finnances",
                "url" => "exjus_finnances",
            );
        }
        if (is_juanma()){
            $have_expenses = true;
            $sidebar_submenu["juanma"] = array(
                "name" => "juanma",
                "url" => "exjus_juanma",
            );
        }
        if ($have_expenses){
            $sidebar_menu["exjus"] = array(
                "name" => "exjus",
                "url" => "",
                "class" => "dollar-sign",
                "position" => 4,
                "submenu" => $sidebar_submenu
            );
        }
        return $sidebar_menu;
    }

}

//install dependencies
register_installation_hook("Expenses_Justification", function ($item_purchase_code) {
    include PLUGINPATH . "Expenses_Justification/install/do_install.php";
});

//add admin setting menu item
app_hooks()->add_filter('app_filter_admin_settings_menu', function ($settings_menu) {
    $settings_menu["setup"][] = array("name" => "exjus_settings", "url" => "expenses_justification_settings");
    return $settings_menu;
});

//add setting link to the plugin setting
app_hooks()->add_filter('app_filter_action_links_of_Expenses_Justification', function ($action_links_array) {
    $action_links_array = array(
        anchor(get_uri("expenses_justification_settings"), app_lang("settings")),
    );

    return $action_links_array;
});


//uninstallation: remove data from database
register_uninstallation_hook("Expenses Justification", function () {
    $dbprefix = get_db_prefix();
    $db = db_connect('default');

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "expenses_justification_settings`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "expenses_list`;";
    $db->query($sql_query);
});

