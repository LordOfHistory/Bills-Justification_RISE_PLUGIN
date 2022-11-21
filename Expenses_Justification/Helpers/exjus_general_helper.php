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
 * check if the user can manage expenses
 * 
 * @param none
 * @return boolean true if it is
 */
if (!function_exists('can_manage_myexpenses')) {

    function can_manage_myexpenses() {
        $canjustify_users = get_exjus_setting("canjustify_users");
        $exjus_users = explode(',', $canjustify_users);
        $instance = new Security_Controller();

        if (in_array($instance->login_user->id, $exjus_users)) {
            return true;
        }
    }
}

/**
 * check if the user can manage juanma expenses
 * 
 * @param none
 * @return boolean true if it is
 */
if (!function_exists('can_manage_juanma_expenses')) {

    function can_manage_juanma_expenses() {
        $exjus_users = get_exjus_setting("canjustifyjuanma_users");
        $exjus_users = explode(',', $exjus_users);
        $instance = new Security_Controller();

        if (in_array($instance->login_user->id, $exjus_users)) {
            return true;
        }
    }
}

/**
 * check if the user is from finnances
 * 
 * @param none
 * @return boolean true if it is
 */
if (!function_exists('is_finnances')) {

    function is_finnances() {
        $exjus_users = get_exjus_setting("finances_users");
        $exjus_users = explode(',', $exjus_users);
        $instance = new Security_Controller();

        if (in_array($instance->login_user->id, $exjus_users)) {
            return true;
        }
    }
}

/**
 * check if the user is juanma
 * @param none
 * @return boolean true if it is
 */
if (!function_exists('is_juanma')) {

    function is_juanma() {
        $exjus_users = get_exjus_setting("juanma_profile");
        $exjus_users = explode(',', $exjus_users);
        $instance = new Security_Controller();

        if (in_array($instance->login_user->id, $exjus_users)) {
            return true;
        }
    }
}

/**
 * check if the user is juanma
 * @param none
 * @return boolean true if it is
 */
if (!function_exists('is_admin')) {

    function is_admin() {
        $instance = new Security_Controller();

        if ($instance->login_user->is_admin) {
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

/**
 * indicata if there is a selected juanma profile or not 
 * 
 * @param none
 * @return boolean
 */
if (!function_exists('juanma_profile_selected')) {
    function juanma_profile_selected(){
        $result = false;
        $profileid = get_exjus_setting("juanma_profile");
        if ($profileid != "" && $profileid!= null){
            $result = true;
        }
        return $result;
    }
}

/**
 * Return a color code acording to de the status pass as parameter 
 * 
 * @param string
 * @return string
 */
if (!function_exists('getStatusColor')) {
    function getStatusColor($status){
        $color = "#474747";
        if ($status == "w_for_finnances"){
            $color = "#E8930F";
        }
        if ($status == "w_for_juanma"){
            $color = "#E8930F";
        }
        if ($status == "w_for_payment"){
            $color = "#0F7CE8";
        }
        if ($status =="payed"){
            $color = "#1CBF30";
        }
        if ($status =="rej_by_finnances"){
            $color = "#ECB734";
        }
        if ($status == "killed"){
            $color = "#E02727";
        }
        return $color;
    }
}