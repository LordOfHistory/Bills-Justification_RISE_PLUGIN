<div id="page-content" class="page-wrapper clearfix">
    <div class="card">
        <div class="page-title clearfix">
            <h1 id="table-title"> <?php echo app_lang("$title") ?></h1>
            <div class="title-button-group">
                <?php echo anchor(get_uri("exjus_myexpenses/new_expense/$uri_chunk/"), 
                                        "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_expense'), 
                                        array("class" => "btn btn-default", "title" => app_lang('add_expense')));
                ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="myexpenses-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    "use strict";

    $(document).ready(function () {
        $("#myexpenses-table").appTable({
            source: '<?php echo_uri("$uri_chunk/list_data") ?>',
            order: [[0, 'desc']],
            columns: [
                {visible: false, searchable: false},
                {title: 'Name', "class": "w100"},
                {title: 'Author', "class": "w200"},
                {title: 'Type', "class": "w100"},
                {title: 'Comments', "class": "w200"},
                {visible: false, searchable: false},
                {title: 'Date', "iDataSort": 2, "class":"w100"},
                {title: 'Status', "class": "text-center option w200"},
                {title: "<i data-feather='info' class='icon-16'></i> Info", "class": "text-center option w100"},
                {title: "<i data-feather='feather' class='icon-16'></i> Action", "class": "text-center option w100"}
            ],
        });  
    });

</script>

<style>
td.option a.details:hover{
    background-color: #6690F4;
    color: #fff;
    border: 1px solid #6690F4;
}

td.option a.download:hover{
    background-color: #9200df;
    color: #fff;
    border: 1px solid #9200df;
}

td.option a.reject:hover{
    background-color: #E6C80D;
    color: #fff;
    border: 1px solid #E6C80D;
}
</style>