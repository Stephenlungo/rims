<?php

$sites = mysqli_query($connect,"select * from sites where region_id != 0 and company_id = $company_id $search_string order by title")or die(mysqli_error($connect));

if(!mysqli_num_rows($sites)){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
	
}else{
	$region_array = fetch_db_table('connect','regions',1,'title','');
	$province_array = fetch_db_table('connect','provinces',1,'title','');
	$hub_array = fetch_db_table('connect','hubs',1,'title','');
	$mother_facility_array = fetch_db_table('connect','mother_facilities',1,'title','');
	$agent_array = fetch_db_table('connect','agents',1,'id','');	
	
	for($s=0;$s<mysqli_num_rows($sites);$s++){
		$site_results = mysqli_fetch_array($sites,MYSQLI_ASSOC);
		$site_id = $site_results['id'];
		
		
		$region_index = array_keys($region_array['id'],$site_results['region_id']);
		
		if(!isset($region_index[0])){
			$region_title = 'Region not found';
			
		}else{
			$region_title = $region_array['title'][$region_index[0]];
			
		}
		
		$province_index = array_keys($province_array['id'],$site_results['province_id']);
		
		if(!isset($province_index[0])){
			$province_title = 'Province not found';
			
		}else{
			$province_title = $province_array['title'][$province_index[0]];
			
		}
		
		$hub_index = array_keys($hub_array['id'],$site_results['hub_id']);
		if(!isset($hub_index[0])){
			$hub_title = 'Hub not found';
			
		}else{
			$hub_title = $hub_array['title'][$hub_index[0]];
			
		}
		
		if(!$site_results['mother_facility_id']){
			$mother_facility_title = 'Unspecified';
			
		}else{
			$mother_facility_index = array_keys($mother_facility_array['id'],$site_results['mother_facility_id']);
			if(!isset($mother_facility_index[0])){
				$mother_facility_title = 'Mother facility found';
				
			}else{
				$mother_facility_title = $mother_facility_array['title'][$mother_facility_index[0]];
			}
		}
		
		$agent_index = array_keys($agent_array['site_id'],$site_results['id']);
		
		if($site_results['started'] == ''){
			$started = '<i>Not set</i>';
			
		}else{
			$started = date('jS M, y',$site_results['started']);
		}
		
		if($site_results['grading'] == 0){
			$grading = '<i>Not set</i>';
			
		}else if($site_results['grading'] == 1){
			$grading = 'Low';
			
		}else if($site_results['grading'] == 2){
			$grading = 'Medium';
			
		}else if($site_results['grading'] == 3){
			$grading = 'High';
			
		}
		
		if($site_results['active_status']){
			$txt_color = '#000';
			
		}else{
			$txt_color = '#999';
			
		}
		
		?>
		<div style="width:100%;color:<?php print($txt_color);?>;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_facility_details(<?php print($site_id);?>);" id="facility_<?php print($site_results['id']);?>"><div style="width:130px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($site_results['title']);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_title);?></div>
	<div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($mother_facility_title);?></div><div style="width:40px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print(count($agent_index));?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($started);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($site_results['gsm_code']);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($site_results['status']);?></div></div>
		
		<?php
	}
}
?>

<script>
display_infor('facility_list_status_bar','<strong>Records found:</strong> <?php print(number_format(mysqli_num_rows($sites)));?>');

</script>