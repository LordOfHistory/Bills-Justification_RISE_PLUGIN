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
        $data = array("title"=>"myexpenses_h1", "uri_chunk"=>"exjus_myexpenses");
        return $this->template->rander('Expenses_Justification\Views\myexpenses\index',$data);
    }

    //Función para comprobar que tiene acceso a esta pestaña
    private function have_access(){
        if (!can_manage_myexpenses() && !is_admin()) {
            app_redirect("forbidden");
        }
    }

    //Función que devuelve la tabla de datos completa de la base de datos
    function list_data() {    
        $this->have_access();
        $options = array("profileid"=>$this->login_user->id);
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

        $info = anchor(get_uri("exjus_myexpenses/expense_details/".$data->id), "<i data-feather='eye' class='icon-16'></i>", array("class"=>"details", "title"=>app_lang("view_details")));
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

    //Función que actúa cuando un usuario cancela una solicitud
    function delete_form(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $model_info = $this->Expenses_model->get_one($id); 
        $view_data['model_info'] = $model_info;
        $view_data['submit_url'] = "exjus_myexpenses/deleted";
        return $this->template->view('Expenses_Justification\Views\usefull\delete_form', $view_data);
    }

    //Función que guarda en bd que una solicitud a sido cancelada
    function deleted(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $route = $this->request->getPost("route");
        
        if ($this->Expenses_model->fullDelete($id,$route)) {
            echo json_encode(array("success" => true, 'id' => $id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //New expenses web redirect
    function new_expense($path,$form=NULL){
        $this->have_access();
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
        $view_data['prev_page'] = $path;
        return $this->template->rander('Expenses_Justification\Views\newexpense\index',$view_data);
    }

    //Funcion que guarda los datos introducidos en el formulario correspondiente.
    function save($prev_page="exjus_myexpenses") {
        $this->have_access();
        //Parte común:
        $now = new \DateTime();
        $now_sql = $now->format('Y-m-d');

        //Comprobamos si venimos de la pestaña de juanma poner el profileId adecuado
        if ($prev_page == "exjus_juanma_expenses"){
            $profileid = get_exjus_setting("juanma_profile");
        }
        else{
            $profileid = $this->login_user->id;
        }

        $data = array(
            "type" => $this->request->getPost("type"),
            "code" => $this->request->getPost("code"),
            "route" => uniqid(),
            "profileid" => $profileid,
            "date" => $now_sql,
            "status" => "w_for_finnances",
            "name" => $this->request->getPost("name"),
            "total" => $this->request->getPost("total"),
        );

        $all_data = null;
        //Para formulario general
        if ($this->request->getPost("type")=="General"){
            $all_form_data = $this->request->getPost();
            $expenses = array();
            foreach ($all_form_data as $clave => $valor){
                $string = explode("-",$clave);
                if ($string[0]=="category"){
                    $id = $string[1];
                    $expense = array();
                    $expense["category"]=$this->request->getPost("category-".$id);
                    $expense["name"]=$this->request->getPost("name-".$id);
                    if ($this->request->getPost("from-".$id)!="")
                        $expense["from"]=$this->request->getPost("from-".$id);
                    if ($this->request->getPost("to-".$id)!="")
                        $expense["to"]=$this->request->getPost("to-".$id);
                    if ($this->request->getPost("date-".$id)!="")    
                        $expense["date"]=$this->request->getPost("date-".$id);
                    if ($this->request->getPost("rentacar-".$id)!="")    
                        $expense["rentacar"]=$this->request->getPost("rentacar-".$id);
                    if ($this->request->getPost("carprice-".$id)!="")    
                        $expense["carprice"]=$this->request->getPost("carprice-".$id);
                    if ($this->request->getPost("km-".$id)!="")    
                        $expense["km"]=$this->request->getPost("km-".$id);
                    if ($this->request->getPost("price-".$id)!="")    
                        $expense["price"]=$this->request->getPost("price-".$id);
                    if ($this->request->getPost("description-".$id)!="")    
                        $expense["description"]=$this->request->getPost("description-".$id);                                
                    $expense["files"]=$this->savefiles("files-".$id,$data["route"]);  
                    $expenses[] = $expense;
                }
            }
    
            $all_data = array(
                "location" => $this->request->getPost("location"),
                "code"  => $this->request->getPost("project-code"),
                "start_date" => $this->request->getPost("end_date"),
                "description" => $this->request->getPost("description"),
                "expenses" => $expenses, 
            );
        }
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
            );
        }

        //Añadimos en el campo correspondiente la data completa del formulario concreto
        $data["data"] = json_encode($all_data);
        $data = clean_data($data);
        $save_id = $this->Expenses_model->ci_save($data);
        if ($save_id) {
            $view_data['redirect'] = "$prev_page/index";
            return $this->template->rander('Expenses_Justification\Views\usefull\success',$view_data);
        } else {
            $view_data['redirect'] = "$prev_page/index";
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
    function expense_details($id=0,$prev_page="exjus_myexpenses"){
        $this->have_access();
        $model_info = $this->Expenses_model->get_one($id);

        $userdb = $this->Users_model->get_one($model_info->profileid);
        $image_url = get_avatar($userdb->image);
        $user_photo = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $userdb->first_name $userdb->last_name";
        $user = get_team_member_profile_link($model_info->profileid, $user_photo);

        $view_data['model_info'] = $model_info;
        $view_data['user'] = $user;
        $view_data["prev_page"] = $prev_page;
        return $this->template->rander('Expenses_Justification\Views\expensesdetails\details', $view_data);

    }

    function download($route=null,$file=null){
        $this->have_access();
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
