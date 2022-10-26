<?php

use App\Controllers\Security_Controller;

/**
 * get the defined config value by a key
 * @param string $key
 * @return config value
 */
if (!function_exists('get_exjus_setting')) {

    function get_exjus_setting($key = "") {
        $config = new Expenses_Justification\Config\Expenses_Justification();

        $setting_value = get_array_value($config->app_settings_array, $key);
        if ($setting_value !== NULL) {
            return $setting_value;
        } else {
            return "";
        }
    }

}

/**
 * check if the user is save as an administrator for the plugin
 * 
 * @param none
 * @return boolean true if it is administrator
 */
if (!function_exists('can_manage_form_maker')) {

    function can_manage_form_maker() {
        $form_maker_users = get_form_maker_setting("form_maker_users");
        $form_maker_users = explode(',', $form_maker_users);
        $instance = new Security_Controller();

        if ($instance->login_user->is_admin || in_array($instance->login_user->id, $form_maker_users)) {
            return true;
        }
    }
}

/**
 * link the css files 
 * 
 * @param array $array
 * @return print css links
 */
if (!function_exists('exjus_load_css')) {

    function exjus_load_css(array $array) {
        foreach ($array as $uri) {
            
            $full_url = PLUGIN_URL_PATH . "Form_Maker/$uri";
            echo "<link rel='stylesheet' type='text/css' href='" . base_url($full_url) . "'/>";
        }
    }

}

