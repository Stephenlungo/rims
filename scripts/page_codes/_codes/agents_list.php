<?php

if($a){
	$bg_color = '#eef';
	
}else{
	$bg_color = '#fee';
}
?>
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="agent_list_status_bar"><strong>Records found:</strong> (Counting...)</div>
<?php
if($a and $active_user_roles[2]){
	?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_agent_details(0,0,0);change_window_size('agent_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bf97bf;color:#fff;" onclick="export_agent_list();change_window_size('agent_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ceacce';" onmouseout="this.style.backgroundColor = '#bf97bf';" id="export_button">Export</div>

<?php
}
?>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:<?php print($bg_color);?>;" id="agent_header"><div style="width:100px;height:20px;float:left;margin-right:3px;">Agent ID</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Phone</div><div style="width:80px;height:20px;float:left;margin-right:3px;">NRC</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Site</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Job title</div></div>

<div style="width:100%;hight:auto;float:left;" id="agent_list_holder"></div>

<script>

fetch_agent_list_code(<?php print($a);?>);

freeze_header('agent_header');


</script>