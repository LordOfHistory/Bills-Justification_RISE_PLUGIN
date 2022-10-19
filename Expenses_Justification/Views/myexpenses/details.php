<div id="page-content" class="page-wrapper clearfix">
    <div class="card">
        <div class="page-title clearfix">
            <h1 id="table-title"> <?php echo app_lang("myexpenses_details") ?></h1>
            <div class="title-button-group">
                <?php echo anchor(get_uri("exjus_myexpenses"), 
                                        "<i data-feather='x-circle' class='icon-16'></i> " . app_lang('close'), 
                                        array("class" => "btn btn-default", "title" => app_lang('close')));
                ?>
            </div>
        </div>
        <div class="modal-body clearfix post-dropzone">
            <div id="form-title" style="text-align:center">
                <h2 style="color:#304FC6">Expense from project <b><?php echo strtoupper($model_info->type); ?></b></h2>
            </div>
            <br/>
            <?php if ($model_info->name != ""):?>   
                <div class="container">
                    <p class="item"><?php echo app_lang('title'); ?>:</p>
                    <h5 class="item"><?php  echo $model_info->name;?></h5>
                </div> 
            <?php endif;?>
            <div class="container">
                <p class="item"><?php echo app_lang('user'); ?>:</p>
                <h5 class="item"><?php  echo $user;?></h5>

                <p class="item"><?php echo app_lang('date'); ?>:</p>
                <h5 class="item"><?php  echo $model_info->date;?></h5>

                <p class="item"><?php echo app_lang('status'); ?>:</p>
                <h5 class="item"><?php  echo $model_info->status;?></h5>
            </div>
            <?php if ($model_info->comments != ""):?>   
                <div class="container">
                    <p class="item"><?php echo app_lang('comments'); ?>:</p>
                    <h5 class="item"><?php  echo $model_info->comments;?></h5>
                </div> 
            <?php endif;?>

            <!--Gestión del grueso de los datos, variable en función de la encuesta realizada-->
            <?php foreach (json_decode($model_info->data) as $clave => $valor): ?>
                <div class="container">
                    <p class="item"><?php echo app_lang($clave); ?>:</p>
                    <?php if (is_array($valor)):?>
                        <div class="container-2">
                            <?php foreach ($valor as $clave2 => $valor2): ?>
                                <div class="item" style='text-align:center'>
                                    <?php  
                                        $array = $valor2;
                                        if (is_image_file($valor2)){
                                            echo "<img style='max-width:400px; max-height:400px; height:auto; weight:auto;' src='".base_url('plugins/Expenses_Justification/files/upload_form_files/'.$model_info->route.'/'.$valor2)."'/><br/>";
                                        }
                                        else{
                                            echo "<i data-feather='file'></i><br/>";
                                        }
                                        echo anchor(get_uri("exjus_myexpenses/download/$model_info->route/$valor2"), "$valor2", array("class" => "download"));
                                    ?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php else:?>
                        <h5 class="item">
                            <?php  
                                echo $valor;
                                if ($clave=="total"){
                                    echo" €";
                                }
                            ?>
                        </h5>
                    <?php endif;?>
                </div> 
            <?php endforeach;?>
        </div>
    </div>
</div>

<style>
 .container{
    background-color: #FAFAFA;
    margin-bottom: 10px;
    border-radius: 7px;
    width:fit-content;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-wrap: wrap;
 }

 .container-2{
    width:fit-content;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-wrap: wrap;
 }

 .item{
    margin:10px;
 }
</style>