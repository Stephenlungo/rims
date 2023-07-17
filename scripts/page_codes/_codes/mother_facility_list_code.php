<?php

$mother_facilities = mysqli_query($connect,"select * from mother_facilities where company_id = $company_id $search_string order by title")or die(mysqli_error($connect));

if(!mysqli_num_rows($mother_facilities)){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
	
}else{
	for($m=0;$m<mysqli_num_rows($mother_facilities);$m++){
		$mother_facility_results = mysqli_fetch_array($mother_facilities,MYSQLI_ASSOC);
		$mother_facility_id = $mother_facility_results['id'];
		
		$region_index = array_keys($region_array['id'],$mother_facility_results['region_id']);
		
		if(!isset($region_index[0])){
			$region_title = 'Region not found';
			
		}else{
			$region_title = $region_array['title'][$region_index[0]];
			
		}
		
		$province_index = array_keys($province_array['id'],$mother_facility_results['province_id']);
		
		if(!isset($province_index[0])){
			$province_title = 'Province not found';
			
		}else{
			$province_title = $province_array['title'][$province_index[0]];
			
		}
		
		$hub_index = array_keys($hub_array['id'],$mother_facility_results['hub_id']);
		if(!isset($hub_index[0])){
			$hub_title = 'Hub not found';
			
		}else{
			$hub_title = $hub_array['title'][$hub_index[0]];
			
		}
		
		$sites_index = array_keys($site_array['mother_facility_id'],$mother_facility_results['id']);
		
		if($mother_facility_results['active_status']){
			$txt_color = '#000';
			
		}else{
			$txt_color = '#aaa';
			
		}
		
		?>
		<div style="width:100%;color:<?php print($txt_color);?>;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_mother_facility_details(<?php print($mother_facility_id);?>);" id="mother_facility_<?php print($mother_facility_results['id']);?>"><div style="width:200px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($mother_facility_results['title']);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_title);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:40px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print(count($sites_index));?></div></div>
		<?php
	}
}
?>

<script>
display_infor('mother_facility_list_status_bar','<strong>Records found:</strong> <?php print(number_format(mysqli_num_rows($mother_facilities)));?>');

</script>