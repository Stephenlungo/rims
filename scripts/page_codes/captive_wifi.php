<?php
include '_codes/item_details.php';
	//include '_codes/item_details_1.php';
	?>

<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#c79a2c"  onclick="$('#filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#c7ad6d'" onmouseout="this.style.backgroundColor='#c79a2c'">Captive WI-FI</div>

<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none" id="filter_options">

</div>


<input type="hidden" value="4" id ="module_id">
<div class="general_menu_holder">
<div class="tab" style="width:140px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_filter_options('captive_dashboard','fetch_general_dashboard(\'captive_wifi\')','captive_wifi');tab_item_change(0);">Dashboards</div>

<div class="tab" style="width:150px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="fetch_filter_options('captive_client_access_log','fetch_captive_client_access_log()','captive_wifi');tab_item_change(4);">Client Access Log</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_script('_codes/survey_list.php?a=1','captive_wifi');tab_item_change(1);">Survey Questions</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_script('_codes/wifis.php?a=2','captive_wifi');tab_item_change(2);">WI-FIs</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_script('_codes/wifi_users.php?a=3','captive_wifi');tab_item_change(3);">WI-FI Users</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_5" onclick="fetch_script('_codes/dynamic_forms.php?a=5','captive_wifi');tab_item_change(5);">Client White-list</div>
</div>

<div class="general_holder" id="captive_wifi">


</div>

</div>

<script>
$('#tab_0').click();
</script>