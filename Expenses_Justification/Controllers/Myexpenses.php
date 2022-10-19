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
            anchor(get_uri("exjus_myexpenses/expense_details/".$data->id), "<i data-feather='eye' class='icon-16'></i>"),
            //. modal_anchor(get_uri("form_maker_left_menu/delete_form"), "<i data-feather='x' class='icon-16'></i>", array("class" => "delete", "title" => 'Deleting entry', "data-post-id" => $data->id)),
        );

        return $row_data;
    }

    //New expenses web redirect
    function new_expense($form=NULL){
        //$this->can_manage_form_maker();
        $formtype = NULL;
        if ($form!=NULL)
            $formtype = $form;
        $view_data['formtype'] = $formtype;

        //Prepara la lista de distintos forms que hay
        $ruta = PLUGINPATH . "Expenses_Justification/Views/newexpense/forms";
        $gestor = opendir($ruta);
        $forms_dropdown = array();
        while (($archivo = readdir($gestor)) !== false)  {
            if ($archivo != "." && $archivo != ".."){
                $forms_dropdown[] = array("id" => explode(".",$archivo)[0], "text" => explode(".",$archivo)[0]);
            }
        }
        $view_data['forms_dropdown'] = json_encode($forms_dropdown);

        return $this->template->rander('Expenses_Justification\Views\newexpense\index',$view_data);
    }

    //Funcion que guarda los datos introducidos en el formulario correspondiente.
    function save() {
        //$this->can_manage_form_maker();
        //Parte común:
        $now = new \DateTime();
        $now_sql = $now->format('Y-m-d');

        $data = array(
            "type" => $this->request->getPost("type"),
            "route" => uniqid(),
            "profileid" => $this->login_user->id,
            "date" => $now_sql,
            "status" => "Requested",
            "name" => $this->request->getPost("name"),
        );

        $all_data = null;
        //Para formularios tipo Life
        if ($this->request->getPost("type")=="Life"){
            $all_data = array(
                "location" => $this->request->getPost("location"),
                "start_date" => $this->request->getPost("start_date"),
                "end_date" => $this->request->getPost("end_date"),
                "description" => $this->request->getPost("description"),
                "agenda_files" => $this->savefiles("agenda_files",$data["route"]),
                "images" => $this->savefiles("images",$data["route"]),
                "receipts" => $this->savefiles("receipts",$data["route"]),
                "total" => $this->request->getPost("total"),
            );
        }

        //Añadimos en el campo correspondiente la data completa del formulario concreto
        $data["data"] = json_encode($all_data);
        $data = clean_data($data);
        $save_id = $this->Expenses_model->ci_save($data);
        if ($save_id) {
            $view_data['redirect'] = "exjus_myexpenses/index";
            return $this->template->rander('Expenses_Justification\Views\usefull\success',$view_data);
        } else {
            $view_data['redirect'] = "exjus_myexpenses/index";
            return $this->template->rander('Expenses_Justification\Views\usefull\fail',$view_data);
        }   
    }

    //Guarda ficheros 
    function savefiles($postvar,$formid){
        $data = array(); 
        $errorUploadType = $statusMsg = ''; 

        if(!empty($_FILES[$postvar]['name']) && count(array_filter($_FILES[$postvar]['name'])) > 0){ 
            $filesCount = count($_FILES[$postvar]['name']);
            for($i = 0; $i < $filesCount; $i++){             
                $tmpFilePath = $_FILES[$postvar]['tmp_name'][$i];
                //Make sure we have a file path
                if ($tmpFilePath != ""){
                    //Setup our new file path
                    $dir = "plugins/Expenses_Justification/files/upload_form_files/".$formid."/";
                    if (!file_exists($dir)){
                        mkdir($dir);
                    }
                    $newFilePath = $dir. $_FILES[$postvar]['name'][$i];
                    if (file_exists($newFilePath)){
                        unlink($newFilePath);
                    }
     
                    //Upload the file into the temp dir
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $data[] = $_FILES[$postvar]['name'][$i];
                    }
                }
            }
        }
        return $data;
    } 

    //Expense details: devuelve la vista detallada de un gasto:
    function expense_details($id=0){
        //$this->can_manage_banner_manager();
        $model_info = $this->Expenses_model->get_one($id);

        $userdb = $this->Users_model->get_one($model_info->profileid);
        $image_url = get_avatar($userdb->image);
        $user_photo = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $userdb->first_name $userdb->last_name";
        $user = get_team_member_profile_link($model_info->profileid, $user_photo);

        $view_data['model_info'] = $model_info;
        $view_data['user'] = $user;
        return $this->template->rander('Expenses_Justification\Views\myexpenses\details', $view_data);

    }

    function download($route=null,$file=null){
        //$this->can_manage_form_maker();
        if ($route != null){
            $filename = "plugins/Expenses_Justification/files/upload_form_files/$route/$file";
            //Check the file exists or not
            if(file_exists($filename)) {
                //Define header information
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header("Cache-Control: no-cache, must-revalidate");
                header("Expires: 0");
                header('Content-Disposition: attachment; filename="'.$file.'"');
                header('Content-Length: ' . filesize($filename));
                header('Pragma: public');
                //Clear system output buffer
                flush();
                //Read the size of the file
                readfile($filename);
                //Terminate from the script
                die();
            }
            else{
                echo "File does not exist.";
            }
        }
    }
}
