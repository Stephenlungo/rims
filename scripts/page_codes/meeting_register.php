<?php
include '_codes/item_details.php';
include '_codes/image_uploader.php';
?>

<div style="width:99.5%;height:auto;float:left;padding:2px;">
	<div class="page_title" style="background-color:#77a8ca;cursor:pointer;line-height:20px;" title="Click to hide/show filter options" onclick="$('#filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#8bbbdb';" onmouseout="this.style.backgroundColor='#77a8ca';">Meeting participant register</div> 

	<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none" id="filter_options"></div>
</div>

<input type="hidden" id="selected_meetings" value="">
<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="tab_item_change(1);active_client_tab=1;fetch_meeting_participants()" style="display:none;">Participants</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="fetch_filter_options('payment_batches','fetch_meeting_batches()','meeting_holder');tab_item_change(4);active_client_tab=4;" style="float:right;border-left:solid 1px #ddd;">Payment batches</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_filter_options('meetings','fetch_meetings()','meeting_holder');tab_item_change(3);active_client_tab=3;" style="float:right;border-left:solid 1px #ddd;">Meetings</div>


</div>


</div>

<div class="general_holder" id="meeting_holder"><div style="width:100%;height:30px;line-height:30px;margin-top:60px;font-size:1.4em;float:left;text-align:center;">Select location above and click "Fetch"</div></div>

<script>
$('#tab_3').click();
</script>