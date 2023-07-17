<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#c79a2c;cursor:pointer" title="Click to hide/show filter options" onclick="$('#filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#c7bf6c';" onmouseout="this.style.backgroundColor='#c79a2c';">Agents (Community Mobilization Agents and Service Providers)</div>

<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none" id="filter_options"></div>

<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="if(active_agent_tab > 1){fetch_filter_options('agents','fetch_agent_list(1)','agents');}else{fetch_agent_list_code(1);}tab_item_change(1);active_agent_tab=1;">Active</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="if(active_agent_tab > 1){fetch_filter_options('agents','fetch_agent_list(0)','agents');}else{fetch_agent_list_code(0);}tab_item_change(0);active_agent_tab=0">Disabled</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="fetch_filter_options('payment_folders','fetch_payment_folders()','agents');tab_item_change(4);active_agent_tab=4">Payment folders</div>


<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_filter_options('agent_types','fetch_agent_type_list(0)','agents');tab_item_change(2);active_agent_tab=2" style="float:right;border-left:solid 1px #ddd;">Agent Groups</div>

<div class="tab" style="float:right;border-left:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="if(active_agent_tab!=3){fetch_filter_options('validation_list','fetch_agent_validation_list()','agents');}else{fetch_agent_validation_list();}tab_item_change(3);active_agent_tab=3">Validation requests</div>
</div>

<div class="general_holder" id="agents"></div>

</div>
<?php

include 'scripts/page_codes/_codes/agent_details.php';
include '_codes/item_details.php';
include '_codes/image_uploader.php';
?>
<script>
<?php
if($active_user_roles[20]){
	?>
	tab_item_change(3);
	active_agent_tab=3;
	fetch_filter_options('validation_list','fetch_agent_validation_list()','agents');
	<?php
}else{
	?>
	tab_item_change(1);
	active_agent_tab=1;
	fetch_filter_options('agents','fetch_agent_list(1)','agents');
<?php
}
?>
</script>