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
            <input type="file" id="agenda_files" name="agenda_files[]" multiple required="true" onchange="preview_names('agenda_files','display-agenda')"/>
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
            <input type="file" id="images" name="images[]" multiple required="true" onchange="preview('images','display-images')"/>
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
            <input type="file" id="receipts" name="receipts[]" multiple required="true" onchange="preview('receipts','display-receipts')"/>
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
            <input type="number" id="total" name="total" min="0" step="any" required="true" placeholder="0.00" /> €
        </div>
    </div>
</div>

