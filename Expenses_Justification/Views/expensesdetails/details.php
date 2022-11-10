<div id="page-content" class="page-wrapper clearfix">
    <div class="card">
        <div class="page-title clearfix">
            <h1 id="table-title"> <?php echo app_lang("myexpenses_details") ?></h1>
            <div class="title-button-group">
                <?php echo anchor(get_uri("$prev_page"), 
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
                <h5 class="item"><?php  echo app_lang($model_info->status);?></h5>
            </div>
            <?php if ($model_info->comments != ""):?>   
                <div class="container">
                    <p class="item"><?php echo app_lang('comments'); ?>:</p>
                    <h5 class="item"><?php  echo $model_info->comments;?></h5>
                </div> 
            <?php endif;?>

            <!--Gestión del grueso de los datos-->
            <?php foreach (json_decode($model_info->data) as $clave => $valor): ?>
                <?php if ($clave=="expenses"): ?>
                    <hr/>
                    <div id="form-title" style="text-align:center">
                        <h3 style="color:#304FC6">Expenses uploaded</h3>
                    </div>
                    <?php foreach ($valor as $clave2 => $valor2): ?>
                        <?php $var = array(
                            "comida",
                            "transporte-publico",
                            "kilometraje",
                            "alojamiento",
                            "otros")?>
                        <div id="form-title" style="text-align:center">
                            <h4 style="color:#304FC6"><u><?php echo app_lang($var[$valor2->category]) ?></u></h4>
                        </div>
                        <div class="container">
                            <?php foreach ($valor2 as $clave3 => $valor3):?>
                                <?php if ($clave3 != "category"): ?>
                                    <div class="container-3">
                                        <p class="item"><?php echo app_lang($clave3); ?>:</p>
                                        <?php if (is_object($valor3) || is_array($valor3)):?>
                                            <div class="container-2">
                                                <?php foreach ($valor3 as $clave4 => $valor4): ?>
                                                    <div class="item" style='text-align:center'>
                                                        <?php  
                                                            if (is_image_file($valor4)){
                                                                echo "<img style='max-width:200px; max-height:200px; height:auto; weight:auto;' src='".base_url('plugins/Expenses_Justification/files/upload_form_files/'.$model_info->route.'/'.$valor4)."'/><br/>";
                                                            }
                                                            else{
                                                                echo "<i data-feather='file'></i><br/>";
                                                            }
                                                            echo anchor(get_uri("$prev_page/download/$model_info->route/$valor4"), "$valor4", array("class" => "download"));
                                                        ?>
                                                    </div>
                                                <?php endforeach;?>
                                            </div>
                                        <?php else:?>
                                            <h5 class="item">
                                                <?php 
                                                if ($clave3=="rentacar")
                                                    echo app_lang($valor3?"yes":"no");
                                                else
                                                    echo $valor3;
                                                if ($clave3 == "price" || $clave3 == "carprice"){
                                                    echo " €";
                                                }
                                                if ($clave3 == "km")
                                                    echo " km";
                                                ?></h5>
                                        <?php endif;?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach;?>
                    
                <?php else: ?>
                    <div class="container">
                        <p class="item"><?php echo app_lang($clave); ?>:</p>
                        <?php if (is_object($valor) || is_array($valor)):?>
                            <div class="container-2">
                                <?php foreach ($valor as $clave2 => $valor2): ?>
                                    <div class="item" style='text-align:center'>
                                        <?php  
                                            if (is_image_file($valor2)){
                                                echo "<img style='max-width:400px; max-height:400px; height:auto; weight:auto;' src='".base_url('plugins/Expenses_Justification/files/upload_form_files/'.$model_info->route.'/'.$valor2)."'/><br/>";
                                            }
                                            else{
                                                echo "<i data-feather='file'></i><br/>";
                                            }
                                            echo anchor(get_uri("$prev_page/download/$model_info->route/$valor2"), "$valor2", array("class" => "download"));
                                        ?>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        <?php else:?>
                            <h5 class="item">
                                <?php  
                                    echo $valor;
                                ?>
                            </h5>
                        <?php endif;?>
                    </div> 
                <?php endif; ?> 
            <?php endforeach;?>
            <hr/>
            <div id="form-title" style="text-align:center">
                <h3 style="color:#304FC6">Total expense</h3>
            </div>
            <div class="container">
                <h4 class="item"><b><?php echo $model_info->total?> €</b></h4>
            </div>
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
 .container-3{
    width:fit-content;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-wrap: nowrap;
 }

 .item{
    margin:10px;
 }
</style>