<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddf;"><div style="width:190px;height:20px;float:left;margin-right:3px;">Title</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Provinces</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Hubs</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Sites</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Agents</div></div>

<?php

$regions = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

for($r=0;$r<mysqli_num_rows($regions);$r++){
	$regions_results = mysqli_fetch_array($regions,MYSQLI_ASSOC);
	
	$region_id = $regions_results['id'];
	
	$region_provinces = mysqli_query($connect,"select * from provinces where region_id = $region_id")or die(mysqli_error($connect));
	$region_hubs = mysqli_query($connect,"select * from hubs where region_id = $region_id")or die(mysqli_error($connect));
	$region_sites = mysqli_query($connect,"select * from sites where region_id = $region_id")or die(mysqli_error($connect));
	
	$region_agents = mysqli_query($connect,"select * from agents where region_id = $region_id")or die(mysqli_error($connect));
	?>
	
	<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><div style="width:190px;height:20px;float:left;margin-right:3px;"><?php print($regions_results['title']);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($region_provinces));?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($region_hubs));?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($region_sites));?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($region_agents));?></div></div>
	
	<?php
	
}
	
	?>