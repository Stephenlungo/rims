<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#c79a2c;cursor:pointer;" onclick="$('#filter_options').slideToggle('fast');" title="Click to open filter options" onmouseover="this.style.backgroundColor='#d6b054';" onmouseout="this.style.backgroundColor='#c79a2c';">USSD Manager</div>

<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none;" id="filter_options">

	
</div>

<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_filter_options('ussd_access_log','ussd_activity_log()','ussd_holder');tab_item_change(0);active_ussd_manager_menu='tab_0';">USSD Access Log</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_script('_codes/ussd_menu.php?a=1','ussd_holder');tab_item_change(1);active_ussd_manager_menu='tab_1';$('#filter_options').html('');">USSD Menu</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_script('_codes/ussd_settings.php?a=2','ussd_holder');tab_item_change(2);active_ussd_manager_menu='tab_2';$('#filter_options').html('');">USSD Global</div>



<div class="tab" style="width:140px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_script('_codes/prep_message_scheduler.php?a=0','ussd_holder');tab_item_change(3);$('#filter_options').html('');">SMS Scheduler</div>

<div class="tab" style="width:150px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="fetch_filter_options('sms_queue','fetch_sms_queue()','ussd_holder');tab_item_change(4);">SMS Queue</div>

<div class="tab" style="width:140px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_5" onclick="fetch_filter_options('sms_client_group','fetch_sms_client_groups()','ussd_holder');tab_item_change(5);">SMS Client Databases</div>

<div class="tab" style="width:140px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_6" onclick="fetch_filter_options('sms_client','fetch_sms_clients()','ussd_holder');tab_item_change(6);">SMS Clients</div>




</div>

<div class="general_holder" id="ussd_holder">


</div>

</div>

<script>
$('#tab_1').click();

var active_ussd_manager_menu = 'tab_1';


</script>