
<?php

$colors = array('#eae5cc','#ccedbb','#96d4ca','#a2b0d7','#ccafde','#eaebc6','#e5cdb8','#abaca5','#d09a9c','#4fc44a','','','','','','','','','','');

$hover_colors = array('#e4dfc8','#e2f1da','#b1e2da','#bac4de','#dfcde9','#e5e6c7','#e8d8ca','#bcbcb8','#e1bcbd','#7cce78');
$open_colors = array('#eeebdd','#d8f0cc','#b7e1da','#d8deee','#ebdef2','#edeed8','#f2e7de','#cfcfcf','#e9cecf','#95d392');
$open_hover_colors = array('#f2f0e3','#e7f5e0','#daf1ed','#e5e9f5','#f2e9f7','#f4f5e5','#f9f4f0','#cfcfcf','#f1e0e0','#afdcac');

$color_index = 0;
$legend_user_ids = array();
$legent_user_qty = array();
$legend = '';

$agents = mysqli_query($connect,"select * from agents where company_id = $company_id and validation_request = 1 $search_string order by validation_request_date asc")or die(mysqli_error($connect));

if(!mysqli_num_rows($agents)){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
}else{
	$region_array = fetch_db_table('connect','regions',1,'title','');
	$province_array = fetch_db_table('connect','provinces',1,'title','');
	$hub_array = fetch_db_table('connect','hubs',1,'title','');
	$mother_facility_array = fetch_db_table('connect','mother_facilities',1,'title','');
	$site_array = fetch_db_table('connect','sites',1,'title','');
	$phone_number_array = fetch_db_table('connect','phone_numbers',1,'id','');	
	$user_array = fetch_db_table('connect','users',1,'id','');	
	
	for($a=0;$a<mysqli_num_rows($agents);$a++){
		$agent_results = mysqli_fetch_array($agents,MYSQLI_ASSOC);
		
		$agent_date = $agent_results['_date'];
		
		if(!count($phone_number_array)){
			$this_phone_number = '<i style="color:red;">Unset</i>';
			
		}else{
			$phone_number_index = array_keys($phone_number_array['agent_date'],$agent_results['_date']);
			
			if(!isset($phone_number_index[0])){
				$this_phone_number = '<i style="color:red;">Unset</i>';
				
			}else{
				$this_phone_number = '';
				for($p=0;$p<count($phone_number_index);$p++){
					if($this_phone_number == ''){
						$this_phone_number = $phone_number_array['phone_number'][$phone_number_index[$p]];
						
					}else{
						$this_phone_number .= ', '.$phone_number_array['phone_number'][$phone_number_index[$p]];
					}					
				}				
			}			
		}
			
			
		if($agent_results['id_number'] == ''){
			$id_number = '<i style="color:red;">Unset</i>';
			
		}else{
			$id_number = $agent_results['id_number'];
			
		}
		
		$requester_title = '<i>Unknown</i>';
		
		if($agent_results['validation_request_user']){
			$user_index = array_keys($user_array['id'],$agent_results['validation_request_user']);
			
			if(!isset($user_index[0])){
				$requester_title = '<i>Not found</i>';
				
			}else{
				$requester_title = $user_array['_name'][$user_index[0]];
				
			}
		}
		
		$region_title = '<i>Unknown</i>';
		
		if($agent_results['region_id']){
			$region_index = array_keys($region_array['id'],$agent_results['region_id']);
			
			if(!isset($region_index[0])){
				$region_title = '<i>Not found</i>';
				
			}else{
				$region_title = $region_array['title'][$region_index[0]];
				
			}
		}
		
		$province_title = '<i>Unknown</i>';
		if($agent_results['province_id']){
			$province_index = array_keys($province_array['id'],$agent_results['province_id']);
			
			if(!isset($province_index[0])){
				$province_title = '<i>Not found</i>';
				
			}else{
				$province_title = $province_array['title'][$province_index[0]];
				
			}
		}
		
		$hub_title = '<i>Unknown</i>';
		if($agent_results['hub_id']){
			$hub_index = array_keys($hub_array['id'],$agent_results['hub_id']);
			if(!isset($hub_index[0])){
				$hub_title = '<i>Not found</i>';
				
			}else{
				$hub_title = $hub_array['title'][$hub_index[0]];
				
			}
		}
		
		$mother_facility_title = '<i>Unknown</i>';
		if($agent_results['mother_facility_id']){
			$mother_facility_index = array_keys($mother_facility_array['id'],$agent_results['mother_facility_id']);
			if(!isset($mother_facility_index[0])){
				$mother_facility_title = '<i>Not found</i>';
				
			}else{
				$mother_facility_title = $mother_facility_array['title'][$mother_facility_index[0]];
			}
		}
		
		$site_title = '<i>Unknown</i>';
		if($agent_results['site_id']){
			$site_index = array_keys($site_array['id'],$agent_results['site_id']);
			if(!isset($site_index[0])){
				$site_title = '<i>Not found</i>';
				
			}else{
				$site_title = $site_array['title'][$site_index[0]];
			}			
		}
	
		//$bg_color = '#fdf1d9';
		//$hover_color = '#f6ead2';
		//if($agent_results['validation_allocation_user_id'] != 0){
			$bg_color = '';
			$hover_color = '#eee';
		//}
		//print('hi');
		if($agent_results['validation_allocation_user_id'] != 0){
			
			if(!isset($allocation_color[$agent_results['validation_allocation_user_id']])){
				$allocation_color[$agent_results['validation_allocation_user_id']] = $color_index;
				$this_user_index = array_keys($user_array['id'],$agent_results['validation_allocation_user_id']);			

				if(isset($this_user_index[0])){
					$legend .= '<div style="width:auto;float:left;margin-right:5px;"><div style="float:left;width:10px;height:15px;background-color:'.$colors[$allocation_color[$agent_results['validation_allocation_user_id']]].';border:solid 1px #ddd;"></div><div style="width:auto;height:15px;line-height:15px;font-size:0.8em;margin-left:5px;float:left;">'.$user_array['_name'][$this_user_index[0]].'</div><div style="width:15px;height:15px;line-height:15px;float:left;font-size:0.8em;margin-left:2px;" id="legent_user_'.$agent_results['validation_allocation_user_id'].'">0</div></div>';
				}			

				$color_index++;
			}
		
			$bg_color = $colors[$allocation_color[$agent_results['validation_allocation_user_id']]];
			$hover_color = $hover_colors[$allocation_color[$agent_results['validation_allocation_user_id']]];
			$open_color = $open_colors[$allocation_color[$agent_results['validation_allocation_user_id']]];
			$hover_open_color = $open_hover_colors[$allocation_color[$agent_results['validation_allocation_user_id']]];	

			if($agent_results['validation_date'] == 0){
				$legend_user_index = array_keys($legend_user_ids,$agent_results['validation_allocation_user_id']);
				
				if(isset($legend_user_index[0])){
					$legent_user_qty[$agent_results['validation_allocation_user_id']]++;

				}else{
					$legend_user_ids[count($legend_user_ids)] = $agent_results['validation_allocation_user_id'];

					$legent_user_qty[$agent_results['validation_allocation_user_id']] = 1;

				}
			}
		}
		
		?>
		
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #fff;cursor:pointer;background-color:<?php print($bg_color);?>" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($bg_color);?>';" title="Click to view more details" id="agent_<?php print($agent_results['id']);?>"><div style="width:20px;height:20px;float:left;"><input type="checkbox" onchange="if(this.checked){add_to_selection(<?php print($agent_results['id']);?>,'selected_agent_validations');}else{remove_from_selection(<?php print($agent_results['id']);?>,'selected_agent_validations');}"></div><div style="width:auto;float:left;height:auto;"   onclick="fetch_agent_details(<?php print($agent_results['id'].',2,'.$agent_results['_date']);?>)"><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('dS M, Y',$agent_results['validation_request_date']));?></div>
			<div style="width:130px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_results['_name']);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($this_phone_number);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($id_number);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:90px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:90px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($site_title);?></div>
			<div style="width:130px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($requester_title);?></div>
			</div>
		</div>
				
		<?php
	}
}
?>
<input type="hidden" id="selected_agent_validations" value="">

<script>
$('#agent_list_status_bar').html("<strong>Records found: </strong><?php print(number_format(mysqli_num_rows($agents)));?>");



$('#legend_holder').slideDown();
$('#legend_holder').html('<?php print($legend);?>');

	<?php
	for($u=0;$u<count($legend_user_ids);$u++){		
		?>
		$('#legent_user_'+<?php print($legend_user_ids[$u]);?>).html('(<?php print($legent_user_qty[$legend_user_ids[$u]]);?>)');
		<?php
	}
	?>
</script>