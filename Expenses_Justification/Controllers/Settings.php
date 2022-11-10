<?php

namespace Expenses_Justification\Controllers;

use App\Controllers\Security_Controller;

class Settings extends Security_Controller {

    protected $Expenses_settings_model;

    function __construct() {
        parent::__construct();
        $this->Expenses_settings_model = new \Expenses_Justification\Models\Expenses_settings_model();
    }

    function index() {
        $team_members = $this->Users_model->get_all_where(array("deleted" => 0, "user_type" => "staff"))->getResult();
        $members_dropdown = array();
        foreach ($team_members as $team_member) {
            $members_dropdown[] = array("id" => $team_member->id, "text" => $team_member->first_name . " " . $team_member->last_name);
        }
        $view_data['members_dropdown'] = json_encode($members_dropdown);

        return $this->template->rander('Expenses_Justification\Views\settings\index', $view_data);
    }
    
    function save_settings() {
        $settings = array(
            "canjustify_users",
            "canjustifyjuanma_users",
            "finances_users",
            "juanma_profile",
        );

        foreach ($settings as $setting) {
            $value = $this->request->getPost($setting);
            if (is_null($value)) {
                $value = "";
            }
            $this->Expenses_settings_model->save_setting($setting, $value);
        }
        echo json_encode(array("success" => true, 'message' => app_lang('settings_updated')));
    }


}
