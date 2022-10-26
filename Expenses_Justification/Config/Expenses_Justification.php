<?php

/* Don't change or add any new config in this file */

namespace Expenses_Justification\Config;

use CodeIgniter\Config\BaseConfig;
use Expenses_Justification\Models\Expenses_settings_model;

class Expenses_Justification extends BaseConfig {

    public $app_settings_array = array();

    public function __construct() {
        $expenses_settings_model = new Expenses_settings_model();

        $settings = $expenses_settings_model->get_all_settings()->getResult();
        foreach ($settings as $setting) {
            $this->app_settings_array[$setting->setting_name] = $setting->setting_value;
        }
    }

}
