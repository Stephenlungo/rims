<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:brown;cursor:pointer;line-height:20px;" title="Click to hide/show filter options" onclick="$('#filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#c34f4f';" onmouseout="this.style.backgroundColor='brown';">Virtual Community Mobilization</div>

<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none" id="filter_options"></div>

<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_filter_options('hiv_clients','fetch_hiv_client_list(0)','clients');tab_item_change(0);active_client_tab=0;" style="width:150px;">For HIV Testing</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_filter_options('hiv_clients','fetch_hiv_client_list(1)','clients');tab_item_change(1);active_client_tab=1">For ART</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_filter_options('hiv_clients','fetch_hiv_client_list(2)','clients');tab_item_change(2);active_client_tab=2" style="width:190px;">On ART (Needing Support)</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="$('#filter_options').html('');fetch_script('_codes/dynamic_forms.php?a=7','clients');tab_item_change(3);active_client_tab=3" style="float:right;border-left:solid 1px #ddd;">Dynamic Forms</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="$('#filter_options').html('');fetch_script('_codes/questionnaire_list.php?a=7','clients');tab_item_change(4);active_client_tab=4" style="float:right;border-left:solid 1px #ddd;">USSD Screening</div>
</div>

<div class="general_holder" id="clients"></div>
<input type="hidden" id="module_id" value="7">
</div>
<?php
include '_codes/item_details.php';
include '_codes/item_details_1.php';
?>
<script>
var active_client_tab = 0;
tab_item_change(0);
fetch_filter_options('hiv_clients','fetch_hiv_client_list(0)','clients');
</script>