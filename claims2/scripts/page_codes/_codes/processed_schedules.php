<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;cursor:pointer;" id="claim_list_status_bar" onclick="$('#claim_number_holder').slideToggle('fast');" title="Click to view claim numbers"><strong>Records found:</strong> (Counting...)</div>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="claims_header"><div style="width:95px;height:20px;float:left;margin-right:3px;">Date scheduled</div>
<div style="width:180px;height:20px;float:left;margin-right:3px;">Date executed</div>
<div style="width:150px;height:20px;float:left;margin-right:3px;">Claim types</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Creator</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">M. Facility</div></div>

<?php


	$claim_types = fetch_db_table('claims_connect','request_types',1,'id','');
	$schedules = fetch_db_table('claims_connect','request_type_scheduler',1,'id','');
	$regions = fetch_db_table('connect','regions',1,'id','');
	$provinces = fetch_db_table('connect','provinces',1,'id','');
	$hubs = fetch_db_table('connect','hubs',1,'id','');
	$mother_facilities = fetch_db_table('connect','mother_facilities',1,'id','');

	$processed_schedules = mysqli_query($$module_connect,"select * from executed_schedules where company_id = $company_id")or die(mysqlI_error($$module_connect));
	
	for($a=0;$a<mysqlI_num_rows($processed_schedules);$a++){
		$processed_schedules_results = mysqli_fetch_array($processed_schedules,MYSQLI_ASSOC);
		
		$schedule_index = array_keys($schedules['id'],$processed_schedules_results['schedule_id']);
		
		
		
		if(!$schedules['region_id'][$schedule_index[0]]){
			$region_name = '<i>All</i>';
			
		}else{
			$region_index = array_keys($regions['id'],$schedules['region_id'][$schedule_index[0]]);
			
			if(isset($region_index[0])){
				$region_name = $regions['title'][$region_index[0]];
				
			}else{
				$region_name = 'Not found';
				
			}
		}
		
		if(!$schedules['province_id'][$schedule_index[0]]){
			$province_name = '<i>All</i>';
			
		}else{
			$province_index = array_keys($provinces['id'],$schedules['province_id'][$schedule_index[0]]);
			
			if(isset($province_index[0])){
				$province_name = $provinces['title'][$province_index[0]];
				
			}else{
				$province_name = 'Not found';
				
			}
		}
		
		if(!$schedules['hub_id'][$schedule_index[0]]){
			$hub_name = '<i>All</i>';
			
		}else{
			$hub_index = array_keys($hubs['id'],$schedules['hub_id'][$schedule_index[0]]);
			
			if(isset($hub_index[0])){
				$hub_name = $hubs['title'][$hub_index[0]];
				
			}else{
				$hub_name = 'Not found';				
			}
		}
		
		if(!$schedules['mother_facility_id'][$schedule_index[0]]){
			$mother_facility_name = '<i>All</i>';
			
		}else{
			$mother_facility_index = array_keys($mother_facilities['id'],$schedules['mother_facility_id'][$schedule_index[0]]);
			
			if(isset($mother_facility_index[0])){
				$mother_facility_name = $mother_facilities['title'][$mother_facility_index[0]];
				
			}else{
				$mother_facility_name = 'Not found';				
			}
		}
		
		
		$claim_type_date = explode(',',$schedules['request_type_dates'][$schedule_index[0]]);
		
		$claim_type_names = '';
		for($c=0;$c<count($claim_type_date);$c++){
			
			$this_claim_type_date = $claim_type_date[$c];
			$claim_type_index = array_keys($claim_types['_date'],$this_claim_type_date);
		
			if($claim_type_names == ''){
				$claim_type_names = $claim_types['title'][$claim_type_index[0]];
				
			}else{
				$claim_type_names .= ', '.$claim_types['title'][$claim_type_index[0]];
				
			}
		}
		
		if($schedules['_type'][$schedule_index[0]] == 0){
			$creator_name = '<i>System</i>';
			
		}else{
				
			$user_date = $schedules['user_date'][$schedule_index[0]];
			$this_schedule_user = mysqli_query($connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($connect));
			$this_schedule_user_results = mysqli_fetch_array($this_schedule_user,MYSQLI_ASSOC);
			
			$creator_name = $this_schedule_user_results['_name'];
		
			
		}
		
		?>
		
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;color:green" id="claims_header" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view beneficiaries"><div style="width:95px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$processed_schedules_results['scheduled_date']));?></div>
<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$processed_schedules_results['_date']));?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($claim_type_names);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print($creator_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($mother_facility_name);?></div>
</div>
		<?php
	}
?>