
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="facility_list_status_bar"><strong>Records found:</strong> (Counting...)</div>
<?php
if($active_user_roles[3]){
	?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_facility_details(0);change_window_size('item_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>

<?php
}
?>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="facility_header"><div style="width:130px;height:20px;float:left;margin-right:3px;">Title</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div>
<div style="width:120px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Mother facility</div><div style="width:40px;height:20px;float:left;margin-right:3px;">Agents</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Started</div><div style="width:50px;height:20px;float:left;margin-right:3px;">Grading</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Code</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Site type</div></div>
<div style="width:100%;hight:auto;float:left;" id="general_list_holder"></div>

<script>
fetch_facility_list_code();
freeze_header('facility_header');

</script>