<div style="width:100%;height:auto;float:left;overflow:auto;max-height:340px;">

<?php

$this_default_agents_partition_name = $default_partition_names[2][1][0];

$records_found = 0;
for($pat=0;$pat<count($partitions);$pat++){
	$agents_table = $this_default_agents_partition_name.'_partition_'.$partitions[$pat];
	
	$agents = mysqli_query($connect,"select * from $agents_table where (company_id = $company_id) $search_key_string order by _name asc, id")or die(mysqli_error($connect));
	
	if(!$phone_number_searched){
		$this_phone_number_table = $this_default_phone_partition_name.'_partition_'.$partitions[$pat];
		$this_phone_number_array = fetch_db_table('connect',$this_phone_number_table,$company_id,'id','');
	}
	
	if(mysqli_num_rows($agents)){
		$records_found += mysqli_num_rows($agents);
		
		$start_date = mktime(0,0,0,date('m',time()),01,date('Y',time()));
		$end_date = time();
		
		if($search_with_days == 1){
			$agent_data = fetch_db_table('connect','_data',$company_id,'_date','validation_status = 1 and _date >= '.$start_date.' and _date <= '.$end_date);
		}
		
		for($a=0;$a<mysqli_num_rows($agents);$a++){
			$agent_results = mysqli_fetch_array($agents,MYSQLI_ASSOC);
			
			$ben_checked = '';
			for($ben=0;$ben<count($selected_beneficiaries_array);$ben++){
				if($agent_results['_date'] == $selected_beneficiaries_array[$ben]){
					$ben_checked = ' checked ';
					break;
				}		
			}
			
			$agent_date = $agent_results['_date'];
			$phone_number_found = 0;
			
			if($phone_number_searched==1){
				if(!isset($phone_number_array[$agent_date])){
					$this_phone_number = '<i style="color:red;">Unset</i>';
					
				}else{
					$this_phone_number = implode(',',$phone_number_array[$agent_date]);
					$phone_number_found = 1;
				}
			}else{
				$phone_number_index = array_keys($this_phone_number_array['agent_date'],$agent_date);
				
				$this_phone_number = '';
				if(isset($phone_number_index[0])){
					for($ph=0;$ph<count($phone_number_index);$ph++){
						if($this_phone_number == ''){
							$this_phone_number = $this_phone_number_array['phone_number'][$phone_number_index[$ph]];
							
						}else{
							$this_phone_number .= ','.$this_phone_number_array['phone_number'][$phone_number_index[$ph]];
							
						}
					}
					$phone_number_found = 1;
				}
			}
			
			if($agent_results['id_number'] == '' || $agent_results['agent_type'] == 0 || !$phone_number_found || $agent_results['site_id'] == 0 || $agent_results['status'] == 0){
				
				$check_active = 'disabled title="This agent is either blocked by finance, has no facility specified, has no phone number or NRC or has been disabled. Contact finance for more details."';
				
			}else{
				$check_active = '';
			}
			
			if($agent_results['id_number'] == ''){
				$id_number = '<i style="color:red;">Unset</i>';
				
			}else{
				$id_number = $agent_results['id_number'];
			}
			
			$region_title = '<i>Not set</i>';
			$region_id = 0;
			$region_index = array_keys($region_id_array,$agent_results['region_id']);
			if(isset($region_index[0])){
				$region_title = $region_name_array[$region_index[0]];
				$region_id = $region_id_array[$region_index[0]];
			}
			
			$province_title = '<i>Not set</i>';
			$province_index = array_keys($province_id_array,$agent_results['province_id']);
			if(isset($province_index[0])){
				$province_title = $province_name_array[$province_index[0]];
				$province_id = $province_id_array[$province_index[0]];
			}
			
			$hub_title = '<i>Not set</i>';
			$hub_index = array_keys($hub_id_array,$agent_results['hub_id']);
			if(isset($hub_index[0])){
				$hub_title = $hub_name_array[$hub_index[0]];
				$hub_id = $hub_id_array[$hub_index[0]];
			}
			
			$site_title = '<i>Not set</i>';
			$site_index = array_keys($site_id_array,$agent_results['site_id']);
			if(isset($site_index[0])){
				$site_title = $site_name_array[$site_index[0]];
				$site_id = $site_id_array[$site_index[0]];
			}
			
			 $txt_color = 'brown';
			if($agent_results['agent_type'] == 1){
				$txt_color = 'green';
			}
			
			?>
			<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;color:<?php print($txt_color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><div style="width:20px;min-height:20px;height:auto;float:left;margin-right:3px;"><input <?php print($ben_checked);?> type="checkbox" <?php print($check_active);?> onclick="if(this.checked){add_to_selection('<?php print($agent_results['_date']);?>','selected_beneficiaries');$('#default_agent_holder').append($('#agent_default_item_holder_<?php print($agent_results['_date']);?>').html());include_beneficiary('<?php print($agent_results['_date']);?>');}else{remove_from_selection('<?php print($agent_results['_date']);?>','selected_beneficiaries');$('#agent_default_item_<?php print($agent_results['_date']);?>').remove();remove_beneficiary('<?php print($agent_results['_date']);?>');}"></div><div style="width:auto;float:left;cursor:pointer;" onclick="$('#agent_details_title_bar').css('background-color','#38bbce');alert('Please edit agents from PIPAT main')"><div style="width:125px;min-height:20px;height:auto;float:left;margin-right:3px;" ><?php print($agent_results['_name']);?></div><div style="width:90px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($this_phone_number);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($id_number);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($site_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_results['responsibility']);?></div></div></div>
			
			<div style="width:100%;height:auto;float:left;display:none;" id="agent_default_item_holder_<?php print($agent_results['_date']);?>">
			
				<div style="width:100%;min-height:25px;height:auto;line-height:25px;display:none;" id="agent_default_item_<?php print($agent_results['_date']);?>">
				<div style="width:135px;min-height:20px;height:auto;float:left;margin-right:3px;" id="claim_agent_name_c_0" ondblclick="$('#agent_c_0comment').slideToggle('fast');" title="Double-click to view/hide comment"><?php print($agent_results['_name']);?></div>
				
				<div style="width:120px;min-height:20px;height:auto;float:left;margin-right:3px;">
				<select id="claim_agent_phone_c_0" style="width:100%;height:20px;margin-top:3px;">
				<?php
					
					if($phone_number_found){
						$this_agent_phone_number_array = explode(',',$this_phone_number);
						for($ph=0;$ph<count($this_agent_phone_number_array);$ph++){
							?>
							<option><?php print($this_agent_phone_number_array[$ph]);?></option>
							<?php
						}
					}
					
					$days = 0;
					
					$search_day_check = '';
					if($search_with_days){
						$days = check_agent_activity_days($agent_results['id'],0,0,$start_date,$end_date,$company_id,$agent_data);
						
						$search_day_check = "include_fetch_agent_days('_c','_0',".$agent_results['id'].");";
					}
					
					if($days == 0){
						$day_color = 'red';
						$comment = 'Agent not required to report';
						
					}else{
						$day_color = 'black';
						$comment = 'Enter comment here';
					}
				?>
				</select>
				<input type="hidden" id="claim_agent_nrc_c_0" value="<?php print($agent_results['id_number']);?>">
				</div>
				
				<div style="width:100px;min-height:25px;height:auto;float:left;margin-right:3px;" id="claim_agent_nrc_c_0"><?php print($agent_results['id_number']);?></div><div style="width:100px;height:25px;float:left;margin-right:3px;"><input type="text" style="height:20px;width:90%;margin-top:3px;" value="<?php print(date('m/01/Y',$start_date));?>" id="agent_start_date_c_0" onchange="<?php print($search_day_check);?>"></div><div style="width:100px;height:25px;float:left;margin-right:3px;"><input type="text" style="height:20px;width:90%;margin-top:3px;" value="<?php print(date('m/j/Y',$end_date));?>" id="agent_end_date_c_0" onchange="<?php print($search_day_check);?>"></div><div style="width:60px;height:25px;float:left;margin-right:3px;text-align:right;color:<?php print($day_color);?>" id="claim_days_worked_c_0"><?php print($days);?></div><div style="width:60px;height:25px;float:left;margin-right:3px;text-align:right;"><input type="text" style="height:20px;width:90%;margin-top:3px;text-align:right;" value="<?php print($days);?>" id="claim_days_payable_c_0" onchange="if(Number(this.value) > Number($('#claim_max_days_c').val())){this.value=$('#claim_max_days_c').val();alert('Maximum payable days for this claim type is '+$('#claim_max_days_c').val());}recalculate_newclaim_total();" onfocusout="if(this.value!=<?php print($days);?>){$('#agent_c_0comment').slideDown('fast');$('#agent_c_0comment_input').css('borderColor','red');}else{$('#agent_c_0comment').slideUp('fast');};"><input type="hidden" style="height:20px;width:90%;margin-top:3px;text-align:right;" value="<?php print($days);?>" id="claim_days_original_payable_c_0"></div><div style="width:70px;height:25px;float:left;margin-right:3px;text-align:right;" id="claim_agent_rate_c_0">0.00</div><div style="width:70px;height:25px;float:left;margin-right:3px;text-align:right;" id="claim_agent_total_c_0">0.00</div>
					<div style="width:15px;cursor:pointer;margin-left:2px;float:left;height:15px;margin-top:2px;line-height:15px;background-color:#8b8;color:#fff;border:solid 1px #eee;text-align:center;display:none;" onmouseout="this.style.backgroundColor='#8b8';" onmouseover="this.style.backgroundColor='#8d8';" id="enable_beneficiary_button_c_0" onclick="change_beneficiary_status('_c','_0',1);" title="Click to include this beneficiary in this claim">&#10004;</div><div style="width:15px;float:left;height:15px;margin-top:2px;line-height:15px;background-color:brown;color:#fff;border:solid 1px #eee;text-align:center;cursor:pointer" onmouseout="this.style.backgroundColor='brown';"onmouseover="this.style.backgroundColor='brown';" id="disable_beneficiary_button_c_0" onclick="change_beneficiary_status('_c','_0',0);" title="Click to exclude this beneficiary">&#10005;</div>
				<div style="width:100%;height:25px;float:left;display:none;" id="agent_c_0comment"><textarea id="agent_c_0comment_input" style="min-width:100%;max-width:100%;min-height:20px;max-height:20;color:#aaa;font-family:arial;font-size:0.9em;border:solid 1px #eee;" onfocus="if(this.value=='<?php print($comment);?>'){this.value='';this.style.color='#444';this.style.borderColor='#eee';}" onfocusout="if(this.value==''){this.value='<?php print($comment);?>';this.style.color='#aaa';}" ><?php print($comment);?></textarea></div>
				
				<div style="width:100%;min-height:25px;line-height:15px;height:auto;float:left;display:none;margin-bottom:10px;" id="beneficiary_date_error_c_0"></div>
		
				<input type="hidden" id="beneficiary_active_c_0" value="1">
				<input type="hidden" id="beneficiary_region_c_0" value="<?php print($region_id);?>">
				<input type="hidden" id="beneficiary_province_c_0" value="<?php print($province_id);?>">
				<input type="hidden" id="beneficiary_hub_c_0" value="<?php print($hub_id);?>">
				<input type="hidden" id="beneficiary_site_c_0" value="<?php print($site_id);?>">
				<input type="hidden" id="beneficiary_name_c_0" value="<?php print($agent_results['_name']);?>">
				
				</div>
				
			</div>
			
			<?php
		}
	}
}

if(!$records_found){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php	
}
?>
</div>

<div style="width:100%;height:30px;float:left;"><div style="width:60px;height:25px;margin: 0 auto;margin-top:2px;background-color:#aaf;color:#fff;text-align:center;line-height:25px;cursor:pointer;" onmouseout="this.style.backgroundColor='#aaf';" onmouseover="this.style.backgroundColor='#9595e5';"  id="report_fetch_button" onclick="$('#claim_agent_search_holder').slideUp('fast');" title="Click to fetch report with specified options">Done</div></div>