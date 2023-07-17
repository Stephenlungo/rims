<?php
include '_codes/item_details.php';
?>

<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#c79a2c;cursor:pointer;" onclick="$('#filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#c7ad6d'" onmouseout="this.style.backgroundColor='#c79a2c'">Facilities and Units</div>


<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none" id="filter_options">

</div>


<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_filter_options('facility','fetch_facility_list()','locations');tab_item_change(0);$('#hub_holder').slideDown('fast');$('#province_holder').slideDown('fast');$('#region_holder').slideDown('fast');$('#active_location_code').val('facility_list');">Facilities</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="fetch_script('_codes/mother_facility_list.php?a=4','locations');tab_item_change(4);$('#mother_facility_holder').slideUp('fast');$('#hub_holder').slideDown('fast');$('#province_holder').slideDown('fast');$('#region_holder').slideDown('fast');$('#active_location_code').val('mother_facility_list');">Mother Facilities</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_script('_codes/hub_list.php?a=1','locations');tab_item_change(1);$('#hub_holder').slideUp('fast');$('#province_holder').slideDown('fast');$('#region_holder').slideDown('fast');$('#active_location_code').val('hub_list');">Hubs</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_script('_codes/province_list.php?a=1','locations');tab_item_change(3);$('#hub_holder').slideUp('fast');$('#province_holder').slideUp('fast');$('#region_holder').slideDown('fast');$('#active_location_code').val('province_list');">Provinces</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_script('_codes/region_list.php?a=1','locations');tab_item_change(2);$('#hub_holder').slideUp('fast');$('#province_holder').slideUp('fast');$('#region_holder').slideUp('fast');$('#active_location_code').val('region_list');">Regions</div>

<div class="tab" style="float:right;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_5" onclick="fetch_filter_options('unit','fetch_unit_list()','locations');tab_item_change(5);$('#hub_holder').slideDown('fast');$('#province_holder').slideDown('fast');$('#region_holder').slideDown('fast');$('#active_location_code').val('unit_list');">Units</div>

<div class="tab" style="float:right;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_6" onclick="fetch_filter_options('activities','fetch_activity_list()','locations');tab_item_change(6);$('#hub_holder').slideDown('fast');$('#province_holder').slideDown('fast');$('#region_holder').slideDown('fast');$('#active_location_code').val('activity_list');">Activities</div>
</div>

<input type="hidden" id="active_location_code" value="facility_list">

<div class="general_holder" id="locations">
</div>

</div>

<script>
fetch_filter_options('facility','fetch_facility_list()','locations');
//fetch_script('_codes/facility_list.php?a=0','locations');
tab_item_change(0);
</script>