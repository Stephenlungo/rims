<?php

$folder_content_array = fetch_db_table('connect','payment_folders',$company_id,'title',$filter_string);
$folder_content_all_array = fetch_db_table('connect','payment_folders',$company_id,'title','');


		
for($f=0;$f<count($folder_content_array['id']);$f++){
	$region_title =  'Unknown region';
	$province_title =  'Unknown province';
	$hub_title =  'Unknown hub';
	$site_title =  'Unknown site';
	
	if($folder_content_array['region_id'][$f]){
		$region_index = array_keys($regions['id'],$folder_content_array['region_id'][$f]);
		
		if(isset($region_index[0])){
			$region_title = $regions['title'][$region_index[0]];
		}
	}
	
	if($folder_content_array['province_id'][$f]){
		$province_index = array_keys($provinces['id'],$folder_content_array['province_id'][$f]);
		
		if(isset($province_index[0])){
			$province_title = $provinces['title'][$province_index[0]];
		}
	}
	
	if($folder_content_array['hub_id'][$f]){
		$hub_index = array_keys($hubs['id'],$folder_content_array['hub_id'][$f]);
		
		if(isset($hub_index[0])){
			$hub_title = $hubs['title'][$hub_index[0]];
		}
	}
	
	if($folder_content_array['site_id'][$f]){
		$site_index = array_keys($sites['id'],$folder_content_array['site_id'][$f]);
		
		if(isset($site_index[0])){
			$site_title = $sites['title'][$site_index[0]];
		}
	}
	
	
	$items = 0;
	
	$content_children_index = array_keys($folder_content_all_array['parent_id'],$folder_content_array['id'][$f]);
	if(isset($content_children_index[0])){
		$items = count($content_children_index);
	}
	
	if($folder_content_array['agent_entries'][$f] != ''){
		$this_folder_agents_array = explode(',',$folder_content_array['agent_entries'][$f]);
		
		$items += count($this_folder_agents_array);
	}
	
	?>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;"><div style="width:20px;height:20px;float:left;"><input type="checkbox" style="display:none;"></div><div style="width:auto;float:left;" onclick="fetch_payment_folder_content(<?php print($folder_content_array['id'][$f]);?>,(Number($('#folder_level').val())+1))" onmouseover="this.style.backgroundColor='#eee';"  onmouseout="this.style.backgroundColor='';" title="Click to view folder content"><div style="width:20px;height:20px;float:left;"><img src="<?php print($code_url);?>/imgs/folder.png" style="width:100%;height:100%;"></div><div style="width:250px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($folder_content_array['title'][$f]);?></div>
		<div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($region_title);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($site_title);?></div><div style="width:60px;height:20px;float:left;margin-right:3px;"><?php print($items);?></div>
		</div>
	</div>
	<?php
}
$agent_count = 0;
if(!count($folder_content_array['id']) and $folder_agents ==''){
	?>	
	<div style="width:100%;height:20px;line-height:20px;font-weight:bold;color:red;text-align:center;margin-top:30px;">This folder is empty</div>
	<?php
}else if($folder_agents != ''){
	$folder_agent_array = explode(',',$folder_agents);
	$agent_count = count($folder_agent_array);
	
	$this_default_agents_partition_name = $default_partition_names[2][1][0];
	$this_default_phone_partition_name = $default_partition_names[2][1][1];
	
	$start_date = mktime(0,0,0,1,1,2015);
	$end_date = time();
	
	$agent_types = fetch_db_table('connect','agent_types',$company_id,'id','');

	$partitions = fetch_database_partitions(2,$start_date,$end_date);
	
	for($pat=0;$pat<count($partitions);$pat++){
		
		$agents_table = $this_default_agents_partition_name.'_partition_'.$partitions[$pat];
		$phone_number_table = $this_default_phone_partition_name.'_partition_'.$partitions[$pat];
		
		$phone_number_array = fetch_db_table('connect',$phone_number_table,$company_id,'id','');
		$agent_array = fetch_db_table('connect',$agents_table,$company_id,'id','');
		
		for($a=0;$a<count($folder_agent_array);$a++){
			$agent_index = array_keys($agent_array['_date'],$folder_agent_array[$a]);
			
			if(isset($agent_index[0])){
				
				$region_title = 'Unspecified';
				$province_title = 'Unspecified';
				$hub_title = 'Unspecified';
				$site_title = 'Unspecified';
				
				$agent_date = $agent_array['_date'][$agent_index[0]];
				$agent_id = $agent_array['id'][$agent_index[0]];
				
				$phone_index = array_keys($phone_number_array['agent_date'],$agent_date);
				
				$phone_number = 'Phone number not found';
				if(isset($phone_index[0])){
					$phone_number = $phone_number_array['phone_number'][$phone_index[0]];
				}
				
				$region_index = array_keys($regions['id'],$agent_array['region_id'][$agent_index[0]]);
				
				if(isset($region_index[0])){
					$region_title = $regions['title'][$region_index[0]];
				}
				
				$province_index = array_keys($provinces['id'],$agent_array['province_id'][$agent_index[0]]);
				
				if(isset($province_index[0])){
					$province_title = $provinces['title'][$province_index[0]];
				}
				
				$hub_index = array_keys($hubs['id'],$agent_array['hub_id'][$agent_index[0]]);
				
				if(isset($hub_index[0])){
					$hub_title = $hubs['title'][$hub_index[0]];
				}
				
				$site_index = array_keys($sites['id'],$agent_array['site_id'][$agent_index[0]]);
				
				if(isset($site_index[0])){
					$site_title = $sites['title'][$site_index[0]];
				}
				
				$agent_group_names = 'None';
				$color = 'brown';
				if($agent_array['agent_type_id'][$agent_index[0]] != ''){
					$folder_agent_types_array = explode(',',$current_folder['claim_type_string'][0]);
					
					$this_agent_types_array = explode(',',$agent_array['agent_type_id'][$agent_index[0]]);
					
					for($ag=0;$ag<count($folder_agent_types_array);$ag++){
						$this_folder_group_array = explode('-',$folder_agent_types_array[$ag]);
						
						$this_folder_group_id = $this_folder_group_array[0];
						
						$this_agent_type_index = array_keys($this_agent_types_array,$this_folder_group_id);
						
						if(isset($this_agent_type_index[0])){
							$agent_type_index = array_keys($agent_types['id'],$this_folder_group_id);
							
							if(isset($agent_type_index[0])){
								if($agent_group_names == 'None'){
									$agent_group_names = $agent_types['title'][$agent_type_index[0]];
									
									$color = '#000';
									
								}else{
									$agent_group_names .= ', '.$agent_types['title'][$agent_type_index[0]];
									
									$color = '#88f';
								}
								
								
							}
						}
					}
				}
				
				
				?>
				<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;color:<?php print($color);?>"  title="<?php print($phone_number.', Agent groups: '.$agent_group_names);?>" onclick="fetch_agent_details(<?php print($agent_id.',1,'.$agent_date);?>)" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor=''"><div style="width:20px;height:20px;float:left;"></div><div style="width:20px;height:20px;float:left;"><img src="<?php print($code_url);?>/imgs/male_user_icon.jpg" style="width:100%;height:100%;"></div><div style="width:250px;height:20px;float:left;margin-right:3px;"><?php print($agent_array['_name'][$agent_index[0]].' ('.$agent_array['id_number'][$agent_index[0]].')');?></div>
				<div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($region_title);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($site_title);?></div><div style="width:60px;height:20px;float:left;margin-right:3px;">N/A</div></div>
				
				<?php
			}
		}
	}
}

?>

<input type="hidden" id="allow_agents" value="<?php print($allow_agents);?>">
<script>
	$('#folder_list_status_bar').html('<strong>Records found: </strong><?php print(count($folder_content_array['id'])+$agent_count);?>');
</script>