<?php

namespace Expenses_Justification\Controllers;

use App\Controllers\Security_Controller;

class Finnances extends Security_Controller {

    protected $Expenses_model;

    function __construct() {
        parent::__construct();
        $this->Expenses_model = new \Expenses_Justification\Models\Expenses_model();
    }

    function index() {
        $data = array("title"=>"finnances", "uri_chunk"=>"exjus_finnances");
        return $this->template->rander('Expenses_Justification\Views\finnances\index',$data);
    }

    //Función para comprobar que tiene acceso a esta pestaña
    private function have_access(){
        if (!is_finnances()) {
            app_redirect("forbidden");
        }
    }

    //Función que devuelve la tabla de datos completa de la base de datos
    function list_data() {    
        $this->have_access();
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
        $status = "<div style='background-color:".getStatusColor($data->status)."; border-radius:10px; color:white; padding:5px'><span>".app_lang($data->status)."</span></div>";
        $buttons = "-";
        if ($data->status == "w_for_finnances"){
            $buttons = (
                modal_anchor(get_uri("exjus_finnances/accept_form"), "<i data-feather='check' class='icon-16'></i>", array("title" => app_lang("accept"), "data-post-id" => $data->id)).
                modal_anchor(get_uri("exjus_finnances/reject_form"), "<i data-feather='search' class='icon-16'></i>", array("class" => "reject", "title" =>  app_lang("reject").", ".app_lang("suggest_changes"), "data-post-id" => $data->id)).
                modal_anchor(get_uri("exjus_finnances/deny_form"), "<i data-feather='x' class='icon-16'></i>", array("class" => "delete", "title" => app_lang("deny"), "data-post-id" => $data->id))
            );
        }
        if ($data->status == "w_for_payment"){
            $buttons = modal_anchor(get_uri("exjus_finnances/payment_form"), "<i data-feather='upload' class='icon-16'></i>", array("class"=>"details", "title" => app_lang("upload_pay"), "data-post-id" => $data->id));
        }

        $info = anchor(get_uri("exjus_finnances/expense_details/".$data->id), "<i data-feather='eye' class='icon-16'></i>", array("class"=>"details", "title"=>app_lang("view_details")));
        if ($data->justificant!="" && $data->justificant!=null && $data->justificant){
            $info .= anchor(get_uri("exjus_finnances/download/$data->route/$data->justificant"), "<i data-feather='download' class='icon-16'></i>", array("class" => "download", "title"=>app_lang("download_pay")));
        }

        $row_data = array(
            $data->name,
            get_team_member_profile_link($data->profileid, $user),
            $data->type,
            $data->comments,
            $data->date,
            format_to_date($data->date, false),
            $status,
            $info,
            $buttons,
        );

        return $row_data;
    }

    //Función que actúa cuando un usuario de finanzas va a justificar el pago una solicitud
    function payment_form(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $model_info = $this->Expenses_model->get_one($id); 
        $view_data['model_info'] = $model_info;
        $view_data['submit_url'] = "exjus_finnances/payed";
        return $this->template->view('Expenses_Justification\Views\usefull\payment_form', $view_data);
    }

    //Función que guarda en bd que una solicitud a sido aceptada
    function payed(){
        $this->have_access();
        $id = $this->request->getPost("id");

        $route = $this->request->getPost("route");
        $justificant = $this->savefiles("file",$route);
        
        if ($this->Expenses_model->updateDb($id,"status","payed") && $this->Expenses_model->updateDb($id,"justificant",$justificant[0])) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($id), 'id' => $id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
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

    //Función que actúa cuando un usuario de finanzas va a aceptar una solicitud
    function accept_form(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $model_info = $this->Expenses_model->get_one($id); 
        $view_data['model_info'] = $model_info;
        $view_data['submit_url'] = "exjus_finnances/accept";
        return $this->template->view('Expenses_Justification\Views\usefull\accept_form', $view_data);
    }
 
    //Función que guarda en bd que una solicitud a sido aceptada
    function accept(){
        $this->have_access();
        $id = $this->request->getPost("id");
        
        if ($this->Expenses_model->updateDb($id,"status","w_for_juanma")&& $this->Expenses_model->updateDb($id,"comments","")) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($id), 'id' => $id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //Función que actúa cuando un usuario de finanzas va a rechazar una solicitud
    function reject_form(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $model_info = $this->Expenses_model->get_one($id); 
        $view_data['model_info'] = $model_info;
        $view_data['submit_url'] = "exjus_finnances/reject";
        return $this->template->view('Expenses_Justification\Views\usefull\reject_form', $view_data);
    }

    //Función que guarda en bd que una solicitud a sido rechazada
    function reject(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $comments = $this->request->getPost("comments");
        
        if ($this->Expenses_model->updateDb($id,"status","rej_by_finnances") && $this->Expenses_model->updateDb($id,"comments",$comments)) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($id), 'id' => $id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //Función que actúa cuando un usuario de finanzas va a denegar una solicitud
    function deny_form(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $model_info = $this->Expenses_model->get_one($id); 
        $view_data['model_info'] = $model_info;
        $view_data['submit_url'] = "exjus_finnances/deny";
        return $this->template->view('Expenses_Justification\Views\usefull\deny_form', $view_data);
    }

    //Función que guarda en bd que una solicitud a sido rechazada
    function deny(){
        $this->have_access();
        $id = $this->request->getPost("id");
        $comments = $this->request->getPost("comments");

        if ($this->Expenses_model->updateDb($id,"status","killed") && $this->Expenses_model->updateDb($id,"comments",$comments)) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($id), 'id' => $id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Expenses_model->get_details($options)->getRow();

        return $this->_make_row($data);
    }

    //Expense details: devuelve la vista detallada de un gasto:
    function expense_details($id=0){
        $this->have_access();
        $model_info = $this->Expenses_model->get_one($id);

        $userdb = $this->Users_model->get_one($model_info->profileid);
        $image_url = get_avatar($userdb->image);
        $user_photo = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $userdb->first_name $userdb->last_name";
        $user = get_team_member_profile_link($model_info->profileid, $user_photo);

        $view_data['model_info'] = $model_info;
        $view_data['user'] = $user;
        $view_data["prev_page"] = "exjus_finnances";
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
