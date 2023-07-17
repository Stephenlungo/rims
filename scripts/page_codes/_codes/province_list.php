<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddf;"><div style="width:190px;height:20px;float:left;margin-right:3px;">Title</div><div style="width:190px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hubs</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Sites</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Agents</div></div>

<?php

$provinces = mysqli_query($connect,"select * from provinces where company_id = $company_id order by title")or die(mysqli_error($connect));

for($p=0;$p<mysqli_num_rows($provinces);$p++){
	$provinces_results = mysqli_fetch_array($provinces,MYSQLI_ASSOC);
	
	$province_id = $provinces_results['id'];
	
	$region_id = $provinces_results['region_id'];
	$this_region = mysqli_query($connect,"select * from regions where id = $region_id")or die(mysqli_error($connect));
	$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);

	$province_hubs = mysqli_query($connect,"select * from hubs where province_id = $province_id")or die(mysqli_error($connect));
	$province_sites = mysqli_query($connect,"select * from sites where province_id = $province_id")or die(mysqli_error($connect));
	
	$province_agents = mysqli_query($connect,"select * from agents where province_id = $province_id")or die(mysqli_error($connect));
	?>
	
	<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><div style="width:190px;height:20px;float:left;margin-right:3px;"><?php print($provinces_results['title']);?></div><div style="width:190px;height:20px;float:left;margin-right:3px;"><?php print($this_region_results['title']);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($province_hubs));?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($province_sites));?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(mysqli_num_rows($province_agents));?></div></div>
	
	<?php
	
}
	
	?>