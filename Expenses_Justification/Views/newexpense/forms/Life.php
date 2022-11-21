<?php //Preparamos los datos del modelo, para en caso de edición ponerlos en los campos correspondientes
$datos = json_decode($model_info->data);?>
<div id="form-title" style="text-align:center">
    <h2 style="color:#304FC6">EXPENDITURE SETTLEMENT REPORT</h2>
</div>
<div class="clearfix">
    <div class="row">
        <label for="name" class="col-md-3"><?php echo app_lang('title'); ?></label>
        <div class="form-group col-md-9">
            <?php
            echo form_input(array(
                "id" => "name",
                "name" => "name",
                "value" => $model_info->name,
                "class" => "form-control",
                "placeholder" => "Name",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <label for="location" class="col-md-3"><?php echo app_lang('location'); ?></label>
        <div class="form-group col-md-9">
            <?php
            echo form_input(array(
                "id" => "location",
                "name" => "location",
                "value" => isset($datos->location)?$datos->location:null,
                "class" => "form-control",
                "placeholder" => "City, country",
                "autocomplete" => "off",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>   
    </div>
    <div class="row">
        <label for="start_date" class="col-md-3"><?php echo app_lang('start_date'); ?></label>
        <div class="form-group col-md-3">
            <?php
            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "value" => isset($datos->start_date)?$datos->start_date:null,
                "class" => "form-control datepicker",
                "placeholder" => "MM/DD/YYYY",
                "autocomplete" => "off",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>

        <label for="end_date" class="col-md-3"><?php echo app_lang('end_date'); ?></label>
        <div class="form-group col-md-3">
            <?php
            echo form_input(array(
                "id" => "end_date",
                "name" => "end_date",
                "value" => isset($datos->end_date)?$datos->end_date:null,
                "class" => "form-control datepicker",
                "placeholder" => "MM/DD/YYYY",
                "autocomplete" => "off",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
                "data-rule-greaterThanOrEqual" => "#start_date",
                "data-msg-greaterThanOrEqual" => app_lang("end_date_must_be_equal_or_greater_than_start_date")
            ));
            ?>
        </div>
    </div>
</div>
<div id="form2-title">
    <h4 style="color:#304FC6">I – JUSTIFICATION AND SETTLEMENT OF TRAVEL EXPENSES</h4>
</div>
<!-- Description -->
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <?php
            echo form_textarea(array(
                "id" => "description",
                "name" => "description",
                "value" => isset($datos->description)?$datos->description:null,
                "class" => "form-control",
                "placeholder" => app_lang('description'),
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
            ));
            ?>
        </div>
    </div>
</div>

<div id="form2-title">
    <h4 style="color:#304FC6">II – AGENDA</h4>
</div>
<div class="form-group">
    <div class="row">
        <label for="agenda_files" class="col-md-3"><i data-feather='upload' class='icon-16'></i> Upload event agenda with all details</label>
        <div class="col-md-3">
            <input type="hidden" id="old_agenda" name="old_agenda_files" value="<?php echo isset($datos->agenda_files)?implode("::",$datos->agenda_files):""?>"/>
            <input type="file" id="agenda_files" name="agenda_files[]" multiple <?php echo isset($datos->agenda_files)?"":"required"?> onchange="preview_names('agenda_files','display-agenda')"/>
        </div>
    </div>
    <div class="row" id="display-agenda" style="padding:10px">
    </div>
</div>

<div id="form2-title">
    <h4 style="color:#304FC6">III – PHOTOS</h4>
</div>
<div class="form-group">
    <div class="row">
        <label for="images" class="col-md-3"><i data-feather='upload' class='icon-16'></i> Upload images of the event</label>
        <div class="col-md-3">
            <input type="hidden" id="old_images" name="old_images" value="<?php echo isset($datos->images)?implode("::",$datos->images):""?>"/>
            <input type="file" id="images" name="images[]" multiple <?php echo isset($datos->images)?"":"required"?> onchange="preview('images','display-images')"/>
        </div>
    </div>
    <div class="row" id="display-images" style="padding:10px">
    </div>
</div>

<div id="form2-title">
    <h4 style="color:#304FC6">IV – RECEIPTS</h4>
</div>
<div class="form-group">
    <div class="row">
        <label for="receipts" class="col-md-3"><i data-feather='upload' class='icon-16'></i> Upload all the receipts generated during the event</label>
        <div class="col-md-3">
            <input type="hidden" id="old_receipts" name="old_receipts" value="<?php echo isset($datos->receipts)?implode("::",$datos->receipts):""?>"/>
            <input type="file" id="receipts" name="receipts[]" multiple <?php echo isset($datos->receipts)?"":"required"?> onchange="preview('receipts','display-receipts')"/>
        </div>
    </div>
    <div class="row" id="display-receipts" style="padding:10px">
    </div>
</div>
<div id="form2-title">
    <h4 style="color:#304FC6">V – TOTAL</h4>
</div>
<div class="form-group">
    <div class="row">
        <label for="total" class="col-md-3">Total expense justified</label>
        <div class="col-md-3">
            <input type="number" id="total" value="<?php echo $model_info->total?>" name="total" min="0" step="any" required="true" placeholder="0.00" /> €
        </div>
    </div>
</div>

