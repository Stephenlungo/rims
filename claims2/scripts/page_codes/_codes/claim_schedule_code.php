<?php
$claim_schedules = mysqli_query($$module_connect,"select * from request_type_scheduler where company_id = $company_id and  	trigger_type_id != 0 $search_string order by _date desc")or die(mysqli_error($connect));

$regions = fetch_db_table('connect','regions',1,'id','');
$provinces = fetch_db_table('connect','provinces',1,'id','');
$hubs = fetch_db_table('connect','hubs',1,'id','');
$mother_facilities = fetch_db_table('connect','mother_facilities',1,'id','');
$sites = fetch_db_table('connect','sites',1,'id','');

for($s=0;$s<mysqli_num_rows($claim_schedules);$s++){
	$claim_schedule_results = mysqli_fetch_array($claim_schedules,MYSQLI_ASSOC);
	
	$claim_type_date = explode(',',$claim_schedule_results['request_type_dates']);
	
	$request_type_title = '';
	for($ct=0;$ct<count($claim_type_date);$ct++){
		$this_claim_type = $claim_type_date[$ct];
		
		$request_types = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$request_type_results = mysqli_fetch_array($request_types,MYSQLI_ASSOC);
		
		
		if($request_type_title == ''){
			$request_type_title = $request_type_results['title'];
			
		}else{
			$request_type_title .= ', '.$request_type_results['title'];
		}
	}
	
	if($claim_schedule_results['region_id'] == 0){
		$region_title = '<i>All regions</i>';
		
	}else{
		$region_index = array_keys($regions['id'],$claim_schedule_results['region_id']);
		
		if(isset($region_index[0])){
			$region_title = $regions['title'][$region_index[0]];
			
		}else{
			$region_title = '<i>Region not found</i>';
		}		
	}
	
	if($claim_schedule_results['province_id'] == 0){
		$province_title = '<i>All provinces</i>';
		
	}else{
		$province_index = array_keys($provinces['id'],$claim_schedule_results['province_id']);
		
		if(isset($province_index[0])){
			$province_title = $regions['title'][$province_index[0]];
			
		}else{
			$province_title = '<i>Province not found</i>';
		}		
	}
	
	
	if($claim_schedule_results['hub_id'] == 0){
		$hub_title = '<i>All hubs</i>';
		
		
	}else{
		$hub_index = array_keys($hubs['id'],$claim_schedule_results['hub_id']);
		
		if(isset($hub_index[0])){
			$hub_title = $hubs['title'][$hub_index[0]];
			
		}else{
			$hub_title = '<i>Hub not found</i>';
		}		
	}
	
	if($claim_schedule_results['mother_facility_id'] == 0){
		$mother_facility_title  = '<i>All mother facilities</i>';
		
		
	}else{
		$mother_facility_index = array_keys($mother_facilities['id'],$claim_schedule_results['mother_facility_id']);
		
		if(isset($mother_facility_index[0])){
			$mother_facility_title = $mother_facilities['title'][$mother_facility_index[0]];
			
		}else{
			$mother_facility_title = '<i>Mother facility not found</i>';
		}		
	}
	
	if($claim_schedule_results['site_id'] == 0){
		$site_title  = '<i>All sites</i>';
		
		
	}else{
		$site_index = array_keys($sites['id'],$claim_schedule_results['site_id']);
		
		if(isset($site_index[0])){
			$site_title = $sites['title'][$site_index[0]];
			
		}else{
			$site_title = '<i>Site facility not found</i>';
		}		
	}
	
	$location = $region_title.' - '.$province_title.' - '.$hub_title.' - '.$mother_facility_title.' - '.$site_title;
	
	if($claim_schedule_results['_type'] == 0){
		$creator_name = '<i>System</i>';
		
	}else{
		$user_date = $claim_schedule_results['user_date'];
		$this_schedule_user = mysqli_query($connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($connect));
		$this_schedule_user_results = mysqli_fetch_array($this_schedule_user,MYSQLI_ASSOC);
		
		$creator_name = $this_schedule_user_results['_name'];
	}
	
	if($claim_schedule_results['schedule_type'] == 0){
		$schedule_type = 'Place reminder';
		
	}else{
		$schedule_type = 'Create claim';
		
	}
	
	if($claim_schedule_results['recurrence'] == 0){
		$recurrence = 'Run once';
		
	}else{
		$recurrence = 'Recurring';
		
	}
	
	if(!$claim_schedule_results['_type']){
		$color = 'brown';
		
	}else{
		$color = '#000';
		
	}
	
	$execution_date = calculate_execution_date($claim_schedule_results['id']);
	?>
	
	<div style="color:<?php print($color);?>;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_claim_schedule_details(<?php print($claim_schedule_results['id']);?>)"><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$claim_schedule_results['_date']));?></div>
<div style="width:160px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($request_type_title);?></div><div style="width:260px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($location);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($creator_name);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print($schedule_type);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$execution_date[2]));?></div><div style="width:60px;height:20px;float:left;margin-right:3px;text-align:right;"><?php print($recurrence);?></div>
</div>
	
	<?php
}
?>