<div id="page-content" class="page-wrapper clearfix">
    <div class="card">
        <div class="page-title clearfix">
            <h1 id="table-title"><?php echo app_lang("add_expense");?></h1>
        </div>
    </div>
    <?php echo form_open(get_uri("exjus_myexpenses/save/$prev_page"), array("id" => "expenses-form", "class" => "general-form", "role" => "form", "enctype"=>"multipart/form-data")); ?>
    <div class="modal-body clearfix post-dropzone">
        <div class="container-fluid" style="visibility:<?php echo $edit?'hidden':'visible'?>">
            <div class="form-group">
                <div class="row">
                    <label for="type" class=" col-md-3"><?php echo app_lang('type'); ?></label>
                    <div class=" col-md-9">
                        <?php echo form_input(array(
                            "id" => "type",
                            "name" => "type",
                            "value" => $formtype,
                            "class" => "form-control",
                            "required" => "true",
                            "placeholder" => app_lang('type'),));?>
                    </div>
                </div>
            </div>       
        </div>
        <input type="hidden" name="id" id="id-input" value="<?php echo $model_info->id?>"/>
        <input type="hidden" name="route" id="route-input" value="<?php echo $model_info->route?>"/>
        <?php 
        if ($formtype!= null && $formtype!=""){
            echo ("<hr/>");
            include PLUGINPATH . "Expenses_Justification/Views/newexpense/forms/".$formtype.".php";
        }
        ?>
        <div class="modal-footer">
            <?php echo anchor(get_uri("$prev_page"), 
                        "<i data-feather='x-circle' class='icon-16'></i> " . app_lang('cancel'), 
                        array("class" => "btn btn-default", "title" => app_lang('cancel')));?>
            <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    "use strict";

    function ajaxRequest(controller,method,data) {
        let uri = '<?php echo_uri("")?>'+controller+'/'+method+'<?php echo("//$prev_page//")?>'+data;
        let http = new XMLHttpRequest();
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                //alert(http.responseText);
            }
        }
        http.open("GET",uri);
        http.send();
    }

    $(document).ready(function () {
        $("#type").select2({
            data: <?php echo ($forms_dropdown); ?>
        });
        $("#type").on('change.select2', function(){
            window.location.href = '<?php echo_uri("exjus_myexpenses/new_expense/$prev_page")?>'+'/'+this.value;
        });
        //Preparing text areas
        $("textarea").each(function () {
            this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
        }).on("input", function () {
            this.style.height = 0;
            this.style.height = (this.scrollHeight) + "px";
        });

        //Preparing datepickers
        $(".datepicker").datepicker({
            orientation: "bottom left"
        });

    });

    function preview(fileInputid, containerid){
        let fileInput = document.getElementById(fileInputid);
        let imageContainer = document.getElementById(containerid);
        imageContainer.innerHTML =  "";

        for(let i of fileInput.files){
            let reader = new FileReader();
            let figure = document.createElement("figure");
            let figCap = document.createElement("figcaption");
            figCap.innerText = i.name;
            figure.appendChild(figCap);
            reader.onload=()=>{
                let img = document.createElement("img");
                img.setAttribute("src",reader.result);
                img.classList.add("mw-100");
                img.style.height="auto";
                figure.insertBefore(img,figCap);
            }
            figure.classList.add("col-md-2");
            imageContainer.appendChild(figure);
            reader.readAsDataURL(i);
        }
    }

    function preview_names(fileInputid, containerid){
        let fileInput = document.getElementById(fileInputid);
        let textContainer = document.getElementById(containerid);
        textContainer.innerHTML =  "";

        for(let i of fileInput.files){
            let text = document.createElement("p");
            text.innerHTML = "<i data-feather='minus' class='icon-16'></i> "+i.name;
            text.classList.add("col-md-12");
            textContainer.appendChild(text);
        }
    }
</script>