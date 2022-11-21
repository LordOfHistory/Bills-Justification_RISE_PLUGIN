<?php

namespace Expenses_Justification\Controllers;

use App\Controllers\Security_Controller;

class Juanmaexpenses extends Security_Controller {

    protected $Expenses_model;

    function __construct() {
        parent::__construct();
        $this->Expenses_model = new \Expenses_Justification\Models\Expenses_model();
    }

    function index() {
        $data = array("title"=>"juanma_expenses", "uri_chunk"=>"exjus_juanma_expenses");
        return $this->template->rander('Expenses_Justification\Views\myexpenses\index',$data);
    }

    //Función para comprobar que tiene acceso a esta pestaña
    private function have_access(){
        if (!can_manage_juanma_expenses() && !is_admin()) {
            app_redirect("forbidden");
        }
    }

    //Función que devuelve la tabla de datos completa de la base de datos
    function list_data() {    
        $this->have_access();
        $options = array("profileid"=>get_exjus_setting("juanma_profile"));
        $list_data = $this->Expenses_model->get_details($options)->getResult();

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

        $status = "<div style='background-color:".getStatusColor($data->status)."; border-radius:10px; color:white; padding:5px'><span>".app_lang($data->status)."</span></div>";

        $info = anchor(get_uri("exjus_myexpenses/expense_details/$data->id/exjus_juanma_expenses"), "<i data-feather='eye' class='icon-16'></i>", array("class"=>"details", "title"=>app_lang("view_details")));
        if ($data->justificant!="" && $data->justificant!=null && $data->justificant){
            $info .= anchor(get_uri("exjus_myexpenses/download/$data->route/$data->justificant"), "<i data-feather='download' class='icon-16'></i>", array("class" => "download", "title"=>app_lang("download_pay")));
        }

        $comments = $data->comments;
        if (explode(">",$data->comments)[0] == "<b"){
            $comments = "";
        }

        $action = "-";
        if ($data->status == "w_for_finnances"){
            $action = modal_anchor(get_uri("exjus_myexpenses/delete_form"), "<i data-feather='x' class='icon-16'></i>", array("class" => "delete", "title" => app_lang("delete"), "data-post-id" => $data->id));
        }
        if ($data->status == "rej_by_finnances"){
            $action = anchor(get_uri("exjus_myexpenses/edit_form/$data->id/exjus_juanma_expenses"), "<i data-feather='edit-3' class='icon-16'></i>", array("class" => "edit", "title" => app_lang("edit")));
        }

        $row_data = array(
            $data->id,
            $data->name,
            get_team_member_profile_link($data->profileid, $user),
            $data->type,
            $comments,
            $data->date,
            format_to_date($data->date, false),
            $status,
            $info,
            $action,
        );

        return $row_data;
    }
}
