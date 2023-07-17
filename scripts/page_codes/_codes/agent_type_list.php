<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="agent_type_list_status_bar"><strong>Records found:</strong> (Counting...)</div>
<?php
if($active_user_roles[3]){
	?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_item_details('agent_type','0','','','Agent Group Details','',1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>

<?php
}
?>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="agent_type_header"><div style="width:250px;height:20px;float:left;margin-right:3px;">Title</div><div style="width:250px;height:20px;float:left;margin-right:3px;">Cluster</div><div style="width:70px;height:20px;float:left;margin-left:5px;margin-right:5px;">Agents</div><div style="width:350px;height:20px;float:left;margin-right:3px;">Description</div></div>
<div style="width:100%;hight:auto;float:left;" id="general_list_holder"></div>

<script>
fetch_agent_type_list_code();
freeze_header('facility_type_header');

</script>