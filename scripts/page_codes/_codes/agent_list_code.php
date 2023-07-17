
<?php
	$area_id = $a;

	$this_default_agents_partition_name = $default_partition_names[2][1][0];
	$this_default_phone_partition_name = $default_partition_names[2][1][1];

	$start_date = $database_date;
	$end_date = $database_date;

	if($database_date == 0){
		$start_date = mktime(0,0,0,1,1,2015);
		$end_date = time();
	}

	$partitions = fetch_database_partitions(2,$start_date,$end_date);
	
	$max_records = 500;
	$total_records = 0;
	$max_display_output = '. Showing '.number_format($max_records,0).' records only';
	
	$region_array = fetch_db_table('connect','regions',$company_id,'title','');
	$province_array = fetch_db_table('connect','provinces',$company_id,'title','');
	$hub_array = fetch_db_table('connect','hubs',$company_id,'title','');
	$mother_facility_array = fetch_db_table('connect','mother_facilities',$company_id,'title','');
	$site_array = fetch_db_table('connect','sites',$company_id,'title','');
	
for($pat=0;$pat<count($partitions);$pat++){
	if($total_records >= $max_records){
		break;
	}

	$agents_table = $this_default_agents_partition_name.'_partition_'.$partitions[$pat];
	$phone_number_table = $this_default_phone_partition_name.'_partition_'.$partitions[$pat];

	$agents = mysqli_query($connect,"select * from $agents_table where company_id = $company_id and status = $area_id $search_string order by id desc, id")or die(mysqli_error($connect));


	$phone_number_array = fetch_db_table('connect',$phone_number_table,$company_id,'id','');

	for($a=0;$a<mysqli_num_rows($agents);$a++){
		$agent_results = mysqli_fetch_array($agents,MYSQLI_ASSOC);
		
		$agent_date = $agent_results['_date'];
		
		if(!count($phone_number_array['id'])){
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
	
		$bg_color = '';
		$hover_color = '#eee';
		if($agent_results['agent_type'] == 1){
			$bg_color = '#f2ddf2';
			$hover_color = '#e8c1e7';
		}
		
		
		if($agent_results['validation_request']){
			$bg_color = '#fdf1d9';
			$hover_color = '#f6ead2';
		}
	
		?>
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;background-color:<?php print($bg_color);?>" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($bg_color);?>';" title="Click to view more details" onclick="fetch_agent_details(<?php print($agent_results['id'].','.$area_id.','.$agent_results['_date']);?>)" id="agent_<?php print($agent_results['id']);?>"><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_results['id']);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_results['_name']);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($this_phone_number);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($id_number);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($site_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_results['responsibility']);?></div></div>
		
		
		<?php
		$total_records++;
		if($total_records >= $max_records){
			break;
		}
	}
}


$max_display_output = '';
if(!$total_records){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
}
?>

<script>
$('#agent_list_status_bar').html("<strong>Records found: </strong><?php print(number_format($total_records).$max_display_output);?>");

</script>