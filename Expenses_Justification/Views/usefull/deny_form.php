<?php echo form_open(get_uri($submit_url), array("id" => "deny-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix post-dropzone">
    <div class="container-fluid">
        <input type="hidden" name="id" value=<?php echo $model_info->id ?> />
        <div class="page-title clearfix">
            <h1 id="table-title"><?php echo app_lang("deny_expense_q");?></h1>
        </div>
        <br/>
        <div style="text-align:center">
            <h3><i data-feather='arrow-right' style="color:#FD1361"></i> <span style="color:#FD1361"><?php echo $model_info->name;?></span> <i data-feather='arrow-left' style="color:#FD1361"></i></h3>
        </div>
        <div style="padding:20px">
            <p><?php echo app_lang("deny_motives")?></p>
                <textarea name="comments" class="form-control textarea" placeholder="<?php echo app_lang("comments")?>" required="true"></textarea>
        </div>
        <br/>
        
    </div>
</div>

<div class="modal-footer">
    <p><?php echo app_lang("sure_undone")?></p>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('no'); ?></button>
    <button type="submit" class="btn btn-danger"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('yes'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#deny-form").appForm({
            onSuccess: function (result) {
                $("#myexpenses-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        $(".textarea").each(function () {
                this.setAttribute("style", "height:70px;overflow-y:hidden;");
            }).on("input", function () {
                this.style.height = 0;
                this.style.height = (this.scrollHeight) + "px";
            });
    });
</script>