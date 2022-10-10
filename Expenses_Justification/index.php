<?php

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
  Plugin Name: Expenses Justification
  Description: RISE CRM plugin to manage all the workflow to justificate expenses.
  Version: 0.1
  Requires at least: 3.0
  Author: JMCandilejo
  Author URL: https://github.com/LordOfHistory/Bills-Justification_RISE_PLUGIN
 */

//add menu item to left menu
app_hooks()->add_filter('app_filter_staff_left_menu', 'expenses_justification');

if (!function_exists('expenses_justification')) {

    function expenses_justification($sidebar_menu) {
        $sidebar_menu["expenses"] = array(
            "name" => "myexpenses",
            "url" => "exjus_myexpenses",
            "class" => "dollar-sign",
            "position" => 1,
        );
        return $sidebar_menu;
    }

}

//install dependencies
register_installation_hook("Expenses Justification", function ($item_purchase_code) {
});

//add setting link to the plugin setting
/*
app_hooks()->add_filter('app_filter_action_links_of_Banner_Manager', function ($action_links_array) {
    $action_links_array = array(
        anchor(get_uri("banner_manager_settings"), app_lang("settings")),
        anchor(get_uri("banner_manager"), app_lang("banner_manager_banners")),
    );

    return $action_links_array;
});


//update plugin
use Banner_Manager\Controllers\Banner_Manager_Updates;

register_update_hook("Banner_Manager", function () {
    $update = new Banner_Manager_Updates();
    return $update->index();
});
*/

//uninstallation: remove data from database
register_uninstallation_hook("Expenses Justification", function () {
    /*
    $dbprefix = get_db_prefix();
    $db = db_connect('default');

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "banner_manager_settings`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "banner_manager`;";
    $db->query($sql_query);
    */
});

/*
//show banners
use App\Controllers\Security_Controller;

app_hooks()->add_action('app_hook_dashboard_announcement_extension', function () {
    $instance = new Security_Controller(false);

    $is_client = false;
    if ($instance->login_user->user_type === "client") {
        $is_client = true;
    }

    $options = array(
        "user_id" => $instance->login_user->id,
        "team_ids" => $instance->login_user->team_ids,
        "is_client" => $is_client,
        "is_alert" => true,
    );

    //check if there has any banner id in the link
    //if has that, show only that banner
    if (isset($_GET["banner"]) && $_GET["banner"] && can_manage_banner_manager()) {
        $banner_id = $_GET["banner"];
        $options = array("id" => $banner_id);
    }

    $Banner_Manager_model = new \Banner_Manager\Models\Banner_Manager_model();
    $banners = $Banner_Manager_model->get_details($options)->getResult();
    $view_data["banners"] = $banners;

    echo view("Banner_Manager\Views\banner_manager\banners_alert", $view_data);
    
});
*/
