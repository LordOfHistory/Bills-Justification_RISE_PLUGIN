<div id="page-content" class="page-wrapper clearfix">
    <div class="card">
        <div class="page-title clearfix">
            <h1 id="table-title"><?php echo app_lang("estimate_submission_message");?></h1>
        </div>
        <div style="text-align:center" class="scale-up-ver-center">
            <i data-feather='smile' style="color:green; width:auto; height:150px; margin:25px"></i>
        </div>
    </div>
</div>

<script>
setTimeout(function () {
   window.location.href= '<?php echo_uri($redirect);?>';
},3000);
</script>

<style>
.scale-up-ver-center {
	-webkit-animation: scale-up-ver-center 1.5s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
	        animation: scale-up-ver-center 1.5s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
}
@-webkit-keyframes scale-up-ver-center{0%{-webkit-transform:scaleY(.4);transform:scaleY(.4)}100%{-webkit-transform:scaleY(1);transform:scaleY(1)}}@keyframes scale-up-ver-center{0%{-webkit-transform:scaleY(.4);transform:scaleY(.4)}100%{-webkit-transform:scaleY(1);transform:scaleY(1)}}

