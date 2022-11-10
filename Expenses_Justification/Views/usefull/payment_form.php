<?php echo form_open(get_uri($submit_url), array("id" => "payment-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix post-dropzone">
    <div class="container-fluid">
        <input type="hidden" name="id" value=<?php echo $model_info->id ?> />
        <input type="hidden" name="route" value=<?php echo $model_info->route ?> />
        <div class="page-title clearfix">
            <h1 id="table-title"><?php echo app_lang("payment_expense_q");?></h1>
        </div>
        <br/>
        <div style="text-align:center">
            <h3><i data-feather='arrow-right' style="color:#6690F4"></i> <span style="color:#6690F4"><?php echo $model_info->name;?></span> <i data-feather='arrow-left' style="color:#6690F4"></i></h3>
        </div>
        <div style="padding:20px">
            <p><?php echo app_lang("upload_pay")?>:</p>
            <div style="text-align:center">
                <input type="file" id="file" name="file[]" required="true"/>
            </div>
        </div>
        <br/>
        
    </div>
</div>

<div class="modal-footer">
    <p><?php echo app_lang("sure_undone")?></p>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('no'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('yes'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#payment-form").appForm({
            onSuccess: function (result) {
                $("#myexpenses-table").appTable({newData: result.data, dataId: result.id});
            }
        });
    });
</script>