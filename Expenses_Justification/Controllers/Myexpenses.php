<?php

namespace Expenses_Justification\Controllers;

use App\Controllers\Security_Controller;

class Myexpenses extends Security_Controller {

    protected $Expenses_model;

    function __construct() {
        parent::__construct();
        $this->Expenses_model = new \Expenses_Justification\Models\Expenses_model();
    }

    function index() {
        return $this->template->rander('Expenses_Justification\Views\myexpenses\index');
    }

    //Función que devuelve la tabla de datos completa de la base de datos
    function list_data() {    
        //$this->can_manage_form_maker();
        $list_data = $this->Expenses_model->get_details()->getResult();

        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //Prepara una fila de la tabla final que se muestra, usad por list_data()
    private function _make_row($data) {
        $image_url = get_avatar($data->profile_avatar);
        $user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $data->profile_name";

        $row_data = array(
            $data->name,
            get_team_member_profile_link($data->profileid, $user),
            $data->type,
            $data->comments,
            $data->date,
            format_to_date($data->date, false),
            $data->status,
            "UwU",
            //modal_anchor(get_uri("form_maker_left_menu/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('form_maker_edit_scholar'), "data-post-id" => $data->id))
            //. modal_anchor(get_uri("form_maker_left_menu/delete_form"), "<i data-feather='x' class='icon-16'></i>", array("class" => "delete", "title" => 'Deleting entry', "data-post-id" => $data->id)),
        );

        return $row_data;
    }
}
