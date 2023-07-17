<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#dfd;" id="hub_header"><div style="width:190px;height:20px;float:left;margin-right:3px;">Title</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Sites</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Agents</div></div>

<?php

$hubs = mysqli_query($connect,"select * from hubs where company_id = $company_id order by title")or die(mysqli_error($connect));

for($d=0;$d<mysqli_num_rows($hubs);$d++){
	$hub_results = mysqli_fetch_array($hubs,MYSQLI_ASSOC);
	$hub_id = $hub_results['id'];
	
	$region_id = $hub_results['region_id'];
	$this_region = mysqli_query($connect,"select * from regions where id = $region_id")or die(mysqli_error($connect));
	$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
	
	$province_id = $hub_results['province_id'];
	$this_province = mysqli_query($connect,"select * from provinces where id = $province_id")or die(mysqli_error($connect));
	$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
	
	$hub_sites = mysqli_query($connect,"select * from sites where hub_id = $hub_id")or die(mysqli_error($connect));
	
	$hub_agents = mysqli_query($connect,"select * from agents where hub_id = $hub_id")or die(mysqli_error($connect));
	?>
	
	<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><div style="width:190px;height:20px;float:left;margin-right:3px;"><?php print($hub_results['title']);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($this_region_results['title']);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($this_province_results['title']);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($hub_sites));?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($hub_agents));?></div></div>
	
	<?php
	
}
	
	?>
	<script>
freeze_header('hub_header');

</script>