<div style="width:100%;height:20px;line-height:20px;float:left;">
	
	<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="export_tempreture_scanner();" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry" id="tempreture_export_button">Export</div>
	
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddf" id="agent_header"><div style="width:30px;height:20px;float:left;margin-right:3px;">ID</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:120px;height:20px;float:left;margin-right:3px;">NRC</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Client type</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Site</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Checked today</div></div>


<?php
$covid_users = mysqli_query($connect,"select * from users where company_id = $company_id")or die(mysqli_error($connect));

for($c=0;$c<mysqli_num_rows($covid_users);$c++){
	$covid_user_results = mysqli_fetch_array($covid_users,MYSQLI_ASSOC);
	
	?>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;">
		<div style="width:30px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($covid_user_results['id']);?></div>
		<div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($covid_user_results['_name']);?></div><div style="width:120px;height:20px;float:left;margin-right:3px;"><?php print($covid_user_results['id_number']);?></div>
		<div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;">Staff</div>
		<div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;">Region</div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;">Province</div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;">Hub</div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;">Site</div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;">Undetermined</div>
	</div>
	<?php
	
}