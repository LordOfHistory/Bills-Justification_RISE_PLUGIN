<div id="page-content" class="page-wrapper clearfix">
    <div class="card">
        <div class="page-title clearfix">
            <h1 id="table-title"> <?php echo app_lang("myexpenses_h1") ?></h1>
            <div class="title-button-group">
                <!-- Button -->
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
            source: '<?php echo_uri("exjus_myexpenses/list_data") ?>',
            order: [[6, 'desc']],
            columns: [
                {title: 'Name', "class": "w100"},
                {title: 'Author', "class": "w200"},
                {title: 'Type', "class": "w100"},
                {title: 'Comments', "class": "w300"},
                {visible: false, searchable: false},
                {title: 'Date', "iDataSort": 2},
                {title: 'Status', "class": "text-center option w100"},
                {title: "<i data-feather='info' class='icon-16'></i>", "class": "text-center option w100"}
            ],
        });  
    });

</script>