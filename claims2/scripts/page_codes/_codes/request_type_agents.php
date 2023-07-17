<?php		
	if($search_key != 'Enter agent name, ID or phone number'){
		$search_key_array = explode(',',$search_key);
		
		$search_key_string = '';
		for($sk=0;$sk<count($search_key_array);$sk++){
			$this_phone_number = $search_key_array[$sk];
			
			if(is_numeric($this_phone_number)){
				$phone_numbers = mysqli_query($connect,"select * from phone_numbers where phone_number LIKE '%$this_phone_number%'")or die(mysqli_error($connect));
				
				
				for($pn=0;$pn<mysqli_num_rows($phone_numbers);$pn++){
					$phone_number_results = mysqli_fetch_array($phone_numbers,MYSQLI_ASSOC);
					
					if($search_key_string == ''){
						$search_key_string = " _date = '".$phone_number_results['agent_date']."'";
						
					}else{
						$search_key_string .= " or _date = '".$phone_number_results['agent_date']."'";
						
					}
				}
			}
		}
		
		for($sk=0;$sk<count($search_key_array);$sk++){
			$this_id = $search_key_array[$sk];
			
			if(is_numeric($this_id)){
				if($search_key_string == ''){
					$search_key_string = " id= ".$this_id;
					
				}else{
					$search_key_string .= " or id = ".$this_id;
					
				}
			}
		}
		
		for($sk=0;$sk<count($search_key_array);$sk++){
			$this_name = $search_key_array[$sk];
			if(!is_numeric($this_id)){
				if($search_key_string == ''){
					$search_key_string = " _name LIKE '%".$this_name."%'";
					
				}else{
					$search_key_string .= " or _name LIKE '%".$this_name."%'";
					
				}
			}
		}

		if($search_key_string != ''){
			$search_key_string = ' and ('.$search_key_string.')';
		}
			
		}else{
			$search_key_string = '';
		}
		
		
		if($branch_id == 0){
			$branch_search_key = '';
			
			
		}else{
			$branch_search_key = ' and branch_id = '.$branch_id;
			
		}
		
		$clusters = fetch_db_table('connect','branches',$company_id);
		$regions = fetch_db_table('connect','regions',$company_id);
		$provinces = fetch_db_table('connect','provinces',$company_id);
		$hubs = fetch_db_table('connect','hubs',$company_id);
		$site = fetch_db_table('connect','sites',$company_id);
		$phone_numbers = fetch_db_table('connect','phone_numbers',$company_id);

	$agents = mysqlI_query($connect,"select * from agents where company_id = $company_id and status = 1 $branch_search_key $search_key_string")or die(mysqli_error($connect));

	for($a=0;$a<mysqli_num_rows($agents);$a++){
		$agent_results = mysqli_fetch_array($agents,MYSQLI_ASSOC);
		
		$cluster_index = array_keys($clusters['id'],$agent_results['branch_id']);
		
		$cluster_name = '<i>Unslecified</i>';
		if($cluster_index[0]){
			$cluster_name = $cluster_index['title'][$cluster_index[0]];
			
		}
		
		
		$region_index = array_keys($regions['id'],$agent_results['region_id']);
		
		$region_title = '<i>Unspecified</i>';
		if($region_index[0]){
			$region_title = $regions['title'][$region_index[0]];
		}
		
		$province_index = array_keys($provinces['id'],$agent_results['province_id']);
		
		$province_title = '<i>Unspecified</i>';
		if($province_index[0]){
			$province_title = $provinces['title'][$province_index[0]];
		}
		
		$hub_index = array_keys($hubs['id'],$agent_results['hub_id']);
		
		$hub_title = '<i>Unspecified</i>';
		if($hub_index[0]){
			$hub_title = $hubs['title'][$hub_index[0]];
		}
		
		$agent_date = $agent_results['_date'];
		$phone_number_index = array_keys($phone_numbers['agent_date'],$agent_date);
		
		$agent_phone_numbers = '<i>Not provided</i>';
		
		if(isset($phone_number_index[0])){
			for($p=0;$p<count($phone_number_index);$p++){
				
				if($agent_phone_numbers == '<i>Not provided</i>'){
					$agent_phone_numbers = $phone_numbers['phone_number'][$phone_number_index[$p]];
					
				}else{
					$agent_phone_numbers .= ', '.$phone_numbers['phone_number'][$phone_number_index[$p]];

				}				
			}
		}
		
		
		
		?>
		<div style="width:99.5%;min-height:20px;height:auto;float:left;border-bottom:solid 1px #eee;" ><div style="width:20px;height:20px;float:left;margin-right:3px;"><input id="agent_<?php print($agent_results['id']);?>_checkbox" type="checkbox" onclick="if(this.checked){add_to_request_type_agent(<?php print($agent_results['id']);?>,'<?php print($agent_results['_name']);?>','<?php print($agent_phone_numbers);?>','<?php print($agent_results['id_number']);?>');}else{remove_from_request_type_agent(<?php print($agent_results['id']);?>);}"></div>
			<div style="width:96.6%;;min-height:20px;height:auto;line-height:20px;float:left;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="$('#agent_<?php print($agent_results['id']);?>').slideToggle('fast');"><div style="width:130px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($cluster_name);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_results['_name']);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_title );?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_title );?></div><div style="width:120px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_title );?></div><div style="width:117px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_results['responsibility']);?></div></div>
		</div>
		
		<div style="width:100%;height:auto;float:left;border-bottom:solid 2px #ccc;margin-bottom:10px;background-color:#eee;display:none;" id="agent_<?php print($agent_results['id']);?>"><?php print('Phone: '.$agent_phone_numbers.', NRC: '.$agent_results['id_number']);?></div>
		
		<script>
			if(search_item_in_list('selected_request_type_agents',<?php print($agent_results['id']);?>,',')){
				document.getElementById('agent_<?php print($agent_results['id']);?>_checkbox').checked = true;
			}
		
		</script>
		
		<?php
	}

?>