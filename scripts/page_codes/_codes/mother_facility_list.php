
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="mother_facility_list_status_bar"><strong>Records found:</strong> (Counting...)</div>
<?php
if($active_user_roles[3]){
	?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_mother_facility_details(0);change_window_size('item_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>

<?php
}
?>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="mother_facility_header"><div style="width:200px;height:20px;float:left;margin-right:3px;">Title</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Region</div>
<div style="width:150px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:40px;height:20px;float:left;margin-right:3px;">Sites</div></div>
<div style="width:100%;hight:auto;float:left;" id="general_list_holder"></div>

<script>
fetch_mother_facility_list_code();
freeze_header('mother_facility_header');

</script>