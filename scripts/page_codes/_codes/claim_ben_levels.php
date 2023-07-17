
<div style="width:975px;min-height:300px;max-height:500px;float:left;overflow:auto;background-color:#fff">
	<?php
	
	if($this_claim_results['status_change_user'] != 0){
		$status_change_user = $this_claim_results['status_change_user'];
		
		$change_user = mysqli_query($connect,"select * from users where _date = '$status_change_user' and company_id = $company_id")or die(mysqlI_error($connect));
		
		if(mysqli_num_rows($change_user)){
			$change_user_results = mysqli_fetch_array($change_user,MYSQLI_ASSOC);
			$change_user_name = $change_user_results['_name'];
			
		}else{
			$change_user_name = '"<i>Unknown user</i>"';
			
		}
		
		if($this_claim_results['claim_old_status'] == 0){
			$old_claim_status = 'Disabled';
			
		}else if($this_claim_results['claim_old_status'] == 1){
			$old_claim_status = 'Pending';
			
		}else if($this_claim_results['claim_old_status'] == 2){
			$old_claim_status = 'Paid';
			
		}else if($this_claim_results['claim_old_status'] == 3){
			$old_claim_status = 'Rejected';
			
		}
		
		?>
		<div style="width:100%;min-height:20px;height:auto;float:left;background-color:#eff2d2;margin-bottom:5px;">Claim status changed from "<?php print($old_claim_status);?>" by <?php print($change_user_name.' on '.date('jS M, Y',$this_claim_results['status_change_date']).', at '.date('H:i:s',$this_claim_results['status_change_date']));?><br>Comment: <?php print($this_claim_results['status_change_comment']);?></div>
		<?php
	}
	
	$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Z');
	
	$claim_type_array = explode(',',$this_claim_results['claim_type_date']);

	$total_levels = 0;
	$claim_type_titles = array();
	$claim_rule_string_array = array();
	
	for($c=0;$c<count($claim_type_array);$c++){
		$this_claim_type_date = $claim_type_array[$c];
		
		$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
		
		
		if(!$this_claim_type_results['billing_type']){
			$claim_type_rate = ' (K'.number_format($this_claim_type_results['daily_rate']).' per day)';
			
		}else{
			$claim_type_rate = ' (K'.number_format($this_claim_type_results['fixed_amount']).' fixed)';
			
		}
		
		$claim_type_titles[$c] = $this_claim_type_results['title'].$claim_type_rate;
		
		$claim_levels = explode(']',$this_claim_type_results['rule_string']);
		$claim_rule_string_array[$c] = $this_claim_type_results['rule_string'];
		
		
		if($total_levels < count($claim_levels)){
			$total_levels = count($claim_levels);
			
		}
	}
	$cell_width = 100;
	$level_area_width = ($total_levels * $cell_width);
	$agent_area_width = 510;
	$total_claim_width = $level_area_width+$agent_area_width+($cell_width-($cell_width/3));
	
	$check_approval = mysqli_query($$module_connect,"select * from claim_approvals where claim_date = '$this_claim_date' and company_id = $company_id order by id desc")or die(mysqlI_error($$module_connect));
	
	$approval_beneficiary_date_array = array();
	$approval_claim_type_date_array = array();
	$approval_user_date_array = array();
	$approval_status_array = array();
	$approval_file_src_array = array();
	$approval_level_array = array();
	$approval_goto_level_array = array();
	$approval_date_array = array();
	$approval_validity_array = array();
	$approval_approval_type_array = array();

	for($a=0;$a<mysqli_num_rows($check_approval);$a++){
		$check_approval_results = mysqli_fetch_array($check_approval,MYSQLI_ASSOC);
		
		$approval_beneficiary_date_array[$a] = $check_approval_results['beneficiary_date'];
		$approval_claim_type_date_array[$a] = $check_approval_results['type_date'];
		$approval_user_date_array[$a] = $check_approval_results['user_date'];
		$approval_status_array[$a] = $check_approval_results['status'];
		$approval_comment_array[$a] = $check_approval_results['comment'];
		$approval_file_src_array[$a] = $check_approval_results['file_src'];
		$approval_level_array[$a] = $check_approval_results['level'];
		$approval_goto_level_array[$a] = $check_approval_results['goto_level'];
		$approval_date_array[$a] = $check_approval_results['_date'];
		$approval_validity_array[$a] = $check_approval_results['validity'];
		$approval_validity_user_date_array[$a] = $check_approval_results['validity_change_user'];
		$approval_validity_date_array[$a] = $check_approval_results['validity_change_date'];
		$approval_approval_type_array[$a] = $check_approval_results['approval_type'];
	}
	
	$users = mysqli_query($connect,"select * from users where company_id = $company_id")or die(mysqli_error($connect));
	
	$user_name_array = array();
	$user_date_array = array();
	$user_phone_array = array();
	$user_region_array = array();
	$user_province_array = array();
	$user_hub_array = array();
	$user_site_array = array();
	
	for($u=0;$u<mysqli_num_rows($users);$u++){
		$this_user_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
		
		$user_name_array[$u] = $this_user_results['_name'];
		$user_date_array[$u] = $this_user_results['_date'];
		$user_phone_array[$u] = $this_user_results['phone'];
		$user_region_array[$u] = $this_user_results['region_id'];
		$user_province_array[$u] = $this_user_results['province_id'];
		$user_hub_array[$u] = $this_user_results['hub_id'];
		$user_site_array[$u] = $this_user_results['site_id'];
	}
	
	
	?>



	<div style="min-width:100%;width:<?php print($total_claim_width);?>px;min-height:30px;height:auto;float:left;">		
		<?php
		$claim_beneficiaries = mysqli_query($$module_connect,"select * from claim_beneficiaries where claim_date = '$this_claim_date' and company_id = $company_id")or die(mysqlI_error($$module_connect));
		
		$beneficiary_type_date_array = array();
		$beneficiary_name_array = array();
		$beneficiary_phone_array = array();
		$beneficiary_nrc_array = array();
		$beneficiary_days_array = array();
		$beneficiary_paid_days_array = array();
		$beneficiary_rate_array = array();
		$beneficiary_amount_array = array();
		$beneficiary_comment_array = array();
		$beneficiary_from_array = array();
		$beneficiary_to_array = array();
		$beneficiary_level_array = array();		
		$beneficiary_date_array = array();
		$beneficiary_id_array = array();
		
		for($b=0;$b<mysqli_num_rows($claim_beneficiaries);$b++){
			$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
			
			$beneficiary_type_date_array[$b] = $claim_beneficiary_results['type_date'];
			$beneficiary_name_array[$b] = $claim_beneficiary_results['_name'];
			$beneficiary_phone_array[$b] = $claim_beneficiary_results['phone'];
			$beneficiary_nrc_array[$b] = $claim_beneficiary_results['nrc'];
			$beneficiary_days_array[$b] = $claim_beneficiary_results['days'];
			$beneficiary_paid_days_array[$b] = $claim_beneficiary_results['paid_days'];
			$beneficiary_rate_array[$b] = $claim_beneficiary_results['rate'];
			$beneficiary_amount_array[$b] = $claim_beneficiary_results['amount'];
			$beneficiary_comment_array[$b] = $claim_beneficiary_results['comment'];
			$beneficiary_from_array[$b] = $claim_beneficiary_results['_from'];
			$beneficiary_to_array[$b] = $claim_beneficiary_results['_to'];
			$beneficiary_level_array[$b] = $claim_beneficiary_results['level'];
			$beneficiary_date_array[$b] = $claim_beneficiary_results['agent_date'];
			$beneficiary_id_array[$b] = $claim_beneficiary_results['id'];
			$beneficiary_status_array[$b] = $claim_beneficiary_results['status'];
		}
		
		$phone_numbers = mysqli_query($connect,"select * from phone_numbers where company_id = $company_id")or die(mysqli_error($connect));
		
		$phone_number_array = array();
		$phone_agent_array = array();
		for($p=0;$p<mysqli_num_rows($phone_numbers);$p++){
			$phone_number_results = mysqli_fetch_array($phone_numbers,MYSQLI_ASSOC);
			
			$phone_number_array[$p] = $phone_number_results['phone_number'];
			$phone_agent_array[$p] = $phone_number_results['agent_date'];
		}
		
		$agents = mysqli_query($connect,"select * from agents where company_id = $company_id")or die(mysqli_error($connect));
		
		$agent_name_array = array();
		$agent_id_array = array();
		$agent_nrc_array = array();
		$agent_gender_array = array();
		$agent_position_array = array();
		$agent_qualification_array = array();
		$agent_region_id_array = array();
		$agent_province_id_array = array();
		$agent_hub_id_array = array();
		$agent_site_id_array = array();
		$agent_date_array = array();
		$agent_unit_id_array = array();
	
		for($a=0;$a<mysqli_num_rows($agents);$a++){
			$agent_results = mysqli_fetch_array($agents,MYSQLI_ASSOC);
			
			$agent_name_array[$a] = $agent_results['_name'];
			$agent_id_array[$a] = $agent_results['id'];
			$agent_nrc_array[$a] = $agent_results['id_number'];
			$agent_gender_array[$a] = $agent_results['gender'];
			$agent_position_array[$a] = $agent_results['responsibility'];
			$agent_qualification_array[$a] = $agent_results['qualification'];
			$agent_region_id_array[$a] = $agent_results['region_id'];
			$agent_province_id_array[$a] = $agent_results['province_id'];
			$agent_hub_id_array[$a] = $agent_results['hub_id'];
			$agent_site_id_array[$a] = $agent_results['site_id'];
			$agent_date_array[$a] = $agent_results['_date'];
			$agent_unit_id_array[$a] = $agent_results['unit_id'];
		}
		
		$regions = mysqli_query($connect,"select * from regions where company_id = $company_id")or die(mysqli_error($connect));
		$region_id_array = array();
		$region_name_array = array();
		for($r=0;$r<mysqli_num_rows($regions);$r++){
			$region_results = mysqli_fetch_array($regions,MYSQLI_ASSOC);
			
			$region_id_array[$r] = $region_results['id'];
			$region_name_array[$r] = $region_results['title'];
		}
			
		$provinces = mysqli_query($connect,"select * from provinces where company_id = $company_id")or die(mysqli_error($connect));
		$province_id_array = array();
		$province_name_array = array();
		for($p=0;$p<mysqli_num_rows($provinces);$p++){
			$province_results = mysqli_fetch_array($provinces,MYSQLI_ASSOC);
			
			$province_id_array[$p] = $province_results['id'];
			$province_name_array[$p] = $province_results['title'];
		}
		
		$hubs = mysqli_query($connect,"select * from hubs where company_id = $company_id")or die(mysqli_error($connect));
		$hub_id_array = array();
		$hub_name_array = array();
		for($h=0;$h<mysqli_num_rows($hubs);$h++){
			$hub_results = mysqli_fetch_array($hubs,MYSQLI_ASSOC);
			
			$hub_id_array[$h] = $hub_results['id'];
			$hub_name_array[$h] = $hub_results['title'];
		}
		
		$sites = mysqli_query($connect,"select * from sites where company_id = $company_id")or die(mysqli_error($connect));
		$site_id_array = array();
		$site_name_array = array();
		for($s=0;$s<mysqli_num_rows($sites);$s++){
			$site_results = mysqli_fetch_array($sites,MYSQLI_ASSOC);
			
			$site_id_array[$s] = $site_results['id'];
			$site_name_array[$s] = $site_results['title'];
		}
		
		$other_claims = mysqli_query($$module_connect,"select * from payment_claims where company_id = $company_id and _date != '$this_claim_date'")or die(mysqli_error($$module_connect));
		
		$other_claim_id_array = array();
		$other_claim_date_array = array();
		
		for($oc=0;$oc<mysqli_num_rows($other_claims);$oc++){
			$other_claim_results = mysqli_fetch_array($other_claims,MYSQLI_ASSOC);
			
			$other_claim_id_array[$oc] = $other_claim_results['claim_id'];
			$other_claim_date_array[$oc] = $other_claim_results['_date'];
		}
		
		$other_beneficiaries = mysqli_query($$module_connect,"select * from claim_beneficiaries where company_id = $company_id and claim_date != '$claim_date'")or die(mysqli_error($$module_connect));
		
		$other_beneficiary_claim_date_array = array();
		$other_beneficiary_agent_date_array = array();
		$other_beneficiary_from_array = array();
		$other_beneficiary_to_array = array();
		for($ob=0;$ob<mysqli_num_rows($other_beneficiaries);$ob++){
			$other_beneficiary_results = mysqli_fetch_array($other_beneficiaries,MYSQLI_ASSOC);
			
			$other_beneficiary_claim_date_array[$ob] = $other_beneficiary_results['claim_date'];
			$other_beneficiary_agent_date_array[$ob] = $other_beneficiary_results['agent_date'];
			
			$other_beneficiary_from_array[$ob] = $other_beneficiary_results['_from'];
			$other_beneficiary_to_array[$ob] = $other_beneficiary_results['_to'];
		}
		
		$ascension_beneficiaries = mysqli_query($$module_connect,"select * from ascension_beneficiaries where claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		$asc_agent_date_array = array();
		$asc_type_date_array = array();
		$asc_ind_array = array();
		$asc_date_array = array();
		$asc_status_array = array();
		
		for($a=0;$a<mysqli_num_rows($ascension_beneficiaries);$a++){
			$acsension_beneficiaties = mysqli_fetch_array($ascension_beneficiaries,MYSQLI_ASSOC);
			
			$asc_agent_date_array[$a] = $acsension_beneficiaties['agent_date'];
			$asc_type_date_array[$a] = $acsension_beneficiaties['type_date'];
			$asc_ind_array[$a] = $acsension_beneficiaties['ascension_ind'];
			$asc_date_array[$a] = $acsension_beneficiaties['_date'];
			$asc_status_array[$a] = $acsension_beneficiaties['status'];
		}
		
	
		for($c=0;$c<count($claim_type_array);$c++){
			$this_claim_type_level_array = explode(']',$claim_rule_string_array[$c]);
			$this_claim_type_date = $claim_type_array[$c];
			$has_beneficiaries = 0;
			
			$selected_beneficiaries = '';
			$all_beneficiaries = '';
			
			
			?>
			<div style="height:20px;line-height:20px;width:100%;float:left;background-color:#dff8ce;font-weight:bold;cursor:pointer;<?php if($c){print('margin-top:5px');}?>" onmouseover="this.style.backgroundColor='#cdd7bd';" onmouseout="this.style.backgroundColor='#dff8ce';" title="Click to expand / collapse claim type beneficiaries" onclick="$('#claim_beneficiaries_holder_<?php print($this_claim_type_date);?>').slideToggle('fast');"><?php print($claim_type_titles[$c]);?></div>
			<div style="width:100%;height:auto;float:left;" id="claim_beneficiaries_holder_<?php print($this_claim_type_date);?>">
			<div style="width:<?php print($agent_area_width);?>px;height:auto;float:left;">
				<div style="width:100%;float:left;height:20px;background-color:#f3fced">
					<div style="width:20px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"></div>							
					<div style="width:140px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Name</div>
					<div style="width:80px;height:20px;line-height:20px;float:left;text-align:left;">Days</div>
					<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;">From</div>
					<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;">To</div>
					<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;">Amount(K)</div>
				</div>
				<?php
				$total_amount = 0;
				for($b=0;$b<count($beneficiary_name_array);$b++){
					
					if($beneficiary_type_date_array[$b] == $this_claim_type_date){
						$has_beneficiaries = 1;
						$this_beneficiary_name = $beneficiary_name_array[$b];
						$this_beneficiary_phone = $beneficiary_phone_array[$b];
						$this_beneficiary_nrc = $beneficiary_nrc_array[$b];
						$this_beneficiary_days = $beneficiary_days_array[$b];
						$this_beneficiary_paid_days = $beneficiary_paid_days_array[$b];
						$this_beneficiary_rate = $beneficiary_rate_array[$b];
						$this_beneficiary_amount = $beneficiary_amount_array[$b];
						$this_beneficiary_comment = $beneficiary_comment_array[$b];
						$this_beneficiary_from = $beneficiary_from_array[$b];
						$this_beneficiary_to = $beneficiary_to_array[$b];
						$this_beneficiary_level = $beneficiary_level_array[$b];
						$this_beneficiary_id = $beneficiary_id_array[$b];
						$this_beneficiary_agent_date = $beneficiary_date_array[$b];
						
						$other_beneficiary_set_index = array_keys($other_beneficiary_agent_date_array,$this_beneficiary_agent_date);
						
						$this_other_numbers = 'No other claims found';
						if(isset($other_beneficiary_set_index[0])){
							$this_other_numbers = 'No other claims found';
							for($ob=0;$ob<count($other_beneficiary_set_index);$ob++){
								
								$this_other_claim_set_index = array_keys($other_claim_date_array,$other_beneficiary_claim_date_array[$other_beneficiary_set_index[$ob]]);
								
								
								$this_claim_number = $other_claim_id_array[$this_other_claim_set_index[0]];
								
								if(!isset($other_claim_numbers[$this_claim_number])){
									
									
									if((($this_beneficiary_from <= $other_beneficiary_from_array[$other_beneficiary_set_index[$ob]] and $this_beneficiary_to >= $other_beneficiary_from_array[$other_beneficiary_set_index[$ob]]) || ($this_beneficiary_from <= $other_beneficiary_to_array[$other_beneficiary_set_index[$ob]] and $this_beneficiary_to >= $other_beneficiary_to_array[$other_beneficiary_set_index[$ob]]) || ($this_beneficiary_from >= $other_beneficiary_from_array[$other_beneficiary_set_index[$ob]] and $this_beneficiary_to <= $other_beneficiary_to_array[$other_beneficiary_set_index[$ob]]))){
										
										$claim_id_color = 'red';
										
									}else{
										$claim_id_color = 'black';
										
									}
									
									
									if($this_other_numbers == 'No other claims found'){
										$this_other_numbers = '<font color="'.$claim_id_color.'">'.$this_claim_number.'</font>';
										
									}else{
										$this_other_numbers .= ', <font color="'.$claim_id_color.'">'.$this_claim_number.'</font>';

									}	
									$other_claim_numbers[$this_claim_number] = 1;
								}								
							}							
						}
						
						
						$this_beneficiary_agent_index = array_keys($agent_date_array,$this_beneficiary_agent_date);
						$this_beneficiary_phone_index = array_keys($phone_agent_array,$agent_date_array[$this_beneficiary_agent_index[0]]);
						
						$this_beneficiary_region_index = array_keys($region_id_array,$agent_region_id_array[$this_beneficiary_agent_index[0]]);
						
						$this_beneficiary_province_index = array_keys($province_id_array,$agent_province_id_array[$this_beneficiary_agent_index[0]]);
						
						$this_beneficiary_hub_index = array_keys($hub_id_array,$agent_hub_id_array[$this_beneficiary_agent_index[0]]);
						
						$this_beneficiary_site_index = array_keys($site_id_array,$agent_site_id_array[$this_beneficiary_agent_index[0]]);
						
						if(!isset($this_beneficiary_site_index[0])){
							$this_beneficiary_site = 'All sites';
							
						}else{
							$this_beneficiary_site = $site_name_array[$this_beneficiary_site_index[0]];
							
						}
						
						if(!isset($this_beneficiary_hub_index[0])){
							$this_beneficiary_hub = 'All hubs';
							
						}else{
							$this_beneficiary_hub = $hub_name_array[$this_beneficiary_hub_index[0]];
							
						}
						
						if(!isset($this_beneficiary_province_index[0])){
							$this_beneficiary_province = 'All provinces';
							
						}else{
							$this_beneficiary_province = $province_name_array[$this_beneficiary_province_index[0]];
							
						}
						
						if(!isset($this_beneficiary_region_index[0])){
							$this_beneficiary_region = 'All regions';
							
						}else{
							$this_beneficiary_region = $region_name_array[$this_beneficiary_region_index[0]];
							
						}
						
						$beneficiary_active = 1;
						for($a=0;$a<count($approval_beneficiary_date_array);$a++){
							if($approval_beneficiary_date_array[$a] == $beneficiary_date_array[$b] and !$approval_status_array[$a] and $approval_claim_type_date_array[$a] == $this_claim_type_date and $approval_validity_array[$a] ==1){
								
								$beneficiary_active = 0;
								break;							
							}								
						}
						
						$check_ascension_beneficiaries = mysqli_query($$module_connect,"select * from ascension_beneficiaries where agent_date = '$this_beneficiary_agent_date' and claim_date = '$this_claim_date' and type_date = '$this_claim_type_date' and status = 1")or die(mysqli_error($$module_connect));

						
						
						if(mysqli_num_rows($check_ascension_beneficiaries)){
							$check_disabled = 1;
							$check_ascension_beneficiar_results = mysqli_fetch_array($check_ascension_beneficiaries,MYSQLI_ASSOC);
							$spreadsheet_number = $this_claim_results['claim_id'].$alphabet[$check_ascension_beneficiar_results['ascension_ind']];
							
						}else{
							
							$check_disabled = 0;
							$spreadsheet_number = '';
						}
						
						if($beneficiary_active and !$check_disabled){
							if($selected_beneficiaries == ''){
								$selected_beneficiaries = $beneficiary_date_array[$b];
								
							}else{
								$selected_beneficiaries .= ','.$beneficiary_date_array[$b];
							}
						}
						
						if($all_beneficiaries == ''){
							$all_beneficiaries = $beneficiary_date_array[$b];
							
						}else{
							$all_beneficiaries .= ','.$beneficiary_date_array[$b];
						}
						
						
							
						?>	
						<div style="width:100%;float:left;height:20px;border-bottom:solid 1px #eee;position:relative" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
							<div style="width:20px;height:15px;line-height:20px;float:left;text-align:left;margin-left:2px;"><input type="checkbox" id="beneficiary_checkbox_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$this_beneficiary_agent_date);?>" onchange="if(this.checked){add_to_selection(<?php print($this_beneficiary_agent_date);?>,'selected_beneficiaries_<?php print($this_claim_date.'_'.$this_claim_type_date);?>');}else{remove_from_selection(<?php print($this_beneficiary_agent_date);?>,'selected_beneficiaries_<?php print($this_claim_date.'_'.$this_claim_type_date);?>');}" <?php if($beneficiary_active and $check_disabled == 0){print(' checked ');}else{print(' disabled ');} ?>></div>						
							<div style="width:auto;float:left;height:auto;cursor:pointer;" onclick="$('#beneficiary_details_<?php print($this_claim_date.'_'.$this_beneficiary_id);?>').slideToggle('fast');">
							<div style="width:140px;height:15px;line-height:20px;float:left;text-align:left;margin-left:2px;" title="<?php print($this_beneficiary_name.' ('.$this_beneficiary_phone.')');?>. Click for more details" ><?php 
							
							if(strlen($this_beneficiary_name) > 17){
								$beneficiary_name = substr($this_beneficiary_name,0,17).'...';								
								
							}else{
								$beneficiary_name = $this_beneficiary_name;
								
							}
							print($beneficiary_name);?></div>
							<div style="width:80px;height:20px;line-height:20px;float:left;text-align:left;"><?php print($this_beneficiary_paid_days.' of '.$this_beneficiary_days);?></div>
							<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;"><?php print(date('jS M, Y',$this_beneficiary_from));?></div>
							<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;"><?php print(date('jS M, Y',$this_beneficiary_to));?></div>
							<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;"><?php print(number_format($this_beneficiary_amount,2));?></div>
							</div>
							
							<div style="width:<?php print($agent_area_width);?>px;padding:2px;z-index:10;display:none;min-height:70px;height:auto;margin-top:20px;background-color:#eee;position:absolute;border:solid 1px #ddd;float:left;" id="beneficiary_details_<?php print($this_claim_date.'_'.$this_beneficiary_id);?>" ondblclick="$(this).slideToggle('fast');"><div style="width:100%;height:20px;float:left;background-color:#ddd;font-weight:bold;" ><?php print($beneficiary_name);?><div style="width:20px;float:right;height:20px;background-color:#ccc;cursor:pointer;text-align:center;line-height:20px;" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#ccc';" title="Click to close this beneficiary details holder" onclick="$('#beneficiary_details_<?php print($this_claim_date.'_'.$this_beneficiary_id);?>').slideUp('fast');">X</div></div>
							
							Level: <?php print($this_beneficiary_level+1);?><br>
							
							<?php
							if($beneficiary_status_array[$b] == 0){
								$beneficiary_status = 'Disabled';
								
							}else if($beneficiary_status_array[$b] == 1){
								$beneficiary_status = 'Pending';
								
							}else if($beneficiary_status_array[$b] == 2){
								$beneficiary_status = 'Completed';
								
							}else if($beneficiary_status_array[$b] == 3){
								$beneficiary_status = 'Rejected';
								
							}else{
								$beneficiary_status = $beneficiary_status_array[$b];								
							}
							?>
							Status: <?php print($beneficiary_status.'<br>'); 
								?>
							Phone: 
							
							<?php 
							$agent_phones = '';
							for($p=0;$p<count($this_beneficiary_phone_index);$p++){
								if($agent_phones == ''){
									$agent_phones = $phone_number_array[$this_beneficiary_phone_index[$p]];
									
								}else{
									$agent_phones .= ', '.$phone_number_array[$this_beneficiary_phone_index[$p]];
									
								}
							}
							
							print($agent_phones.'<br>');
								?>
							Phone on claim: <?php print($this_beneficiary_phone.'<br>');?>
							
							NRC: <?php print($agent_nrc_array[$this_beneficiary_agent_index[0]]);?>, NRC on claim: <?php print($this_beneficiary_nrc.'<br>');?>
							
							PIPAT ID: <?php print($agent_id_array[$this_beneficiary_agent_index[0]]);?><br>
							
							<?php print('Region: '.$this_beneficiary_region.', Province: '.$this_beneficiary_province.', Hub: '.$this_beneficiary_hub.', Site: '.$this_beneficiary_site);?><br>
							
							<?php
							if($this_beneficiary_comment != '' and $this_beneficiary_comment != 'Enter comment here'){
								?>
							<font color="brown">Comment: <?php print($this_beneficiary_comment.'<br></font>');
							}
							
							if($spreadsheet_number != ''){
								print('<br><font color="006bb3">Spreadsheet claim number: '.$spreadsheet_number.'</font><br>');
							}
							?>
							
							Other claims: <?php print($this_other_numbers);?><br>
							</div>
							
						</div>
						<?php
						
						$total_amount += $this_beneficiary_amount;
					}
				}
			
				if($has_beneficiaries){
					?>
					<div style="width:100%;float:left;height:20px;">							
						<div style="width:140px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"></div>
						<div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;"></div>
						<div style="width:45px;height:20px;line-height:20px;float:left;text-align:left;"></div>
						<div style="width:45px;height:20px;line-height:20px;float:left;text-align:left;"></div>
						<div style="width:170px;height:20px;line-height:20px;float:left;text-align:right;color:#006bb3">Sub-Total: K<?php print(number_format($total_amount,2));?></div>
					</div>
					<?php
				}
				?>
			</div>
			
			<?php
			if($has_beneficiaries){?>				
				<div style="min-width:465px;width:<?php print($level_area_width);?>px;height:auto;float:left;">
				<?php
				
				for($l=0;$l<count($this_claim_type_level_array);$l++){
					$this_level_rule_array = explode(',',$this_claim_type_level_array[$l]);						
					$this_level_action_type = $this_level_rule_array[2];

					
					
					?>
					<div style="width:<?php print($cell_width);?>px;height:auto;float:left;">
						<div style="width:<?php print($cell_width);?>px;height:20px;line-height:20px;float:left;text-align:center;background-color:#eef"><?php print($this_level_rule_array[0]);?></div>
						
						<?php
						if(!$this_level_action_type){
							for($b=0;$b<count($beneficiary_name_array);$b++){
								$this_beneficiary_agent_date = $beneficiary_date_array[$b];
								if($beneficiary_type_date_array[$b] == $this_claim_type_date){
									
									$level_waiting = 0;
									for($a=0;$a<count($approval_beneficiary_date_array);$a++){
										if($approval_beneficiary_date_array[$a] == $beneficiary_date_array[$b] and 	$approval_level_array[$a] == $l and $approval_claim_type_date_array[$a] == $this_claim_type_date and $approval_validity_array[$a] ==2){
											$level_waiting = 1;
											
										}
										
										if($approval_beneficiary_date_array[$a] == $beneficiary_date_array[$b] and $approval_level_array[$a] == $l and $approval_claim_type_date_array[$a] == $this_claim_type_date and $approval_validity_array[$a] ==1){
											
											if($approval_status_array[$a]){
												$level_text = 'Approved';
												$level_text_color = 'green';
												
												$level_active = 1;
												
												
											}else{
												$level_text = 'Sent to level '.($approval_goto_level_array[$a]+1);
												$level_text_color = 'brown';
												$level_active = 0;
											}
											
											$alt_text = 'Click for more details';
											
											?>
												<div style="width:<?php print($cell_width);?>px;height:20px;line-height:20px;height:auto;float:left;border-bottom:solid 1px #eee;position:relative;"  onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" ><div style="width:100%;height:20px;float:left;cursor:pointer;text-align:center;color:<?php print($level_text_color);?>" onclick="$('#approval_detail_<?php print($this_claim_type_date.'_'.$c.'_'.$this_beneficiary_agent_date.'_'.$l);?>').slideToggle('fast');" title="<?php print($alt_text);?>" id="level_<?php print($this_claim_type_date.'_'.$c.'_'.$b.'_'.$l);?>"><?php print($level_text);?></div>
												<input type="hidden" id="z_index_<?php print($this_claim_type_date.'_'.$c.'_'.$b.'_'.$l);?>" value="10">
												<div style="width:<?php print($cell_width+80);?>px;height:150px;height:auto;border-bottom:solid 1px #fdd;margin-top:20px;position:absolute;display:none;background-color:#fff;z-index:10;border:solid 1px #ddd;padding:2px;" id="approval_detail_<?php print($this_claim_type_date.'_'.$c.'_'.$this_beneficiary_agent_date.'_'.$l);?>" ondblclick="$(this).slideUp('fast');">
													<div style="width:100%;background-color:#fdd;min-height:20px;height:auto;line-height:20px;float:left;font-weight:bold;text-align:center;"><?php print($beneficiary_name_array[$b].' (Level '.($l+1).')');?></div>
													<div style="width:100%;min-height:150px;max-height:200px;float:left;overflow:auto;font-size:0.9em;line-height:15px;">
													<?php
													
													$this_beneficiary_approval_index = array_keys($approval_beneficiary_date_array,$beneficiary_date_array[$b]);
													
													$first_entry = 0;
													for($tb=0;$tb<count($this_beneficiary_approval_index);$tb++){
														if($approval_level_array[$this_beneficiary_approval_index[$tb]] == $l and $approval_claim_type_date_array[$this_beneficiary_approval_index[$tb]] == $this_claim_type_date){
															
															$this_approval_user_index = array_keys($user_date_array,$approval_user_date_array[$this_beneficiary_approval_index[$tb]]);
															
															$approver_name = $user_name_array[$this_approval_user_index[0]];
															$approver_phone = $user_phone_array[$this_approval_user_index[0]];
															
															$approver_date = $approval_date_array[$this_beneficiary_approval_index[$tb]];
															
															
															
															if(!$approval_validity_array[$this_beneficiary_approval_index[$tb]]){
																$font_color = '#777';
																
															}else{
																$font_color = '#000';
																
															}
															
															if(!$approval_approval_type_array[$this_beneficiary_approval_index[$tb]]){
																$approval_type = 'Manual';
																
															}else{
																$approval_type = 'Automatic';
																
															}
															
															?>
															<div style="color:<?php print($font_color);?>;width:100%;height:auto;float:left;">
																Approval Type: <?php	print($approval_type.'<br>');?>
																Approver: <?php	print($approver_name.'<br>');?>
																Phone: <?php	print($approver_phone.'<br>');?>
																Date: <?php print(date('jS M, Y',$approver_date).'<br>');?>
																Time: <?php print(date('H:i:s',$approver_date).'<br>');
																
																if(!$approval_validity_array[$this_beneficiary_approval_index[$tb]]){
																	$invalidation_date = $approval_validity_date_array[$this_beneficiary_approval_index[$tb]];
																
																	$invalidation_user_date = $approval_validity_user_date_array[$this_beneficiary_approval_index[$tb]];
																	
																	$this_invalidation_user_index = array_keys($user_date_array,$invalidation_user_date);
															
																	$invalidation_name = $user_name_array[$this_invalidation_user_index[0]];
																	$invalidation_phone = $user_phone_array[$this_invalidation_user_index[0]];
																	
																	?>
																	
																	
																	Rejected on: <?php print(date('jS M, Y',$invalidation_date).'<br>');
																	?>
																	
																	Rejected by: <?php print($invalidation_name.'<br>');?>
																	Phone: <?php print($invalidation_phone.'<br>');
																	
																}
																
																if($approval_comment_array[$this_beneficiary_approval_index[$tb]] != ''){
																	?>
																	<strong>Comment: <?php print($approval_comment_array[$this_beneficiary_approval_index[$tb]].'</strong><br>');
																	
																}
																?>
															<br>
															</div>
															
															<?php
															if(!$first_entry){
																?>
																<div style="background-color:#eee;width:100%;height:20px;line-height:20px;float:left;text-align:center;">Past approvals</div>
																<?php
															}
															
															if($first_entry){
																?>
																<script>$('#level_<?php print($this_claim_type_date.'_'.$c.'_'.$b.'_'.$l);?>').css('color','purple');</script>
																
																<?php
															}
															
															$first_entry = 1;
														}
													}
													
													
													?>
													
													</div>
												</div>
												<input type="hidden" id="level_approved_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$this_beneficiary_agent_date.'_'.$l);?>" value="<?php print($level_active);?>">
												</div>
												
												
												
											<?php
											break;
											
										}else if($a == count($approval_beneficiary_date_array) -1){
											
											if($level_waiting){
												?>
												<div style="width:100%;height:20px;float:left;cursor:pointer;text-align:center;color:orange">Waiting...</div>
												
												<?php
												
											}else{
												$this_beneficiary_agent_date = $beneficiary_date_array[$b];
												$alt_text = 'Awaiting approval';
												?>
													<div style="width:<?php print($cell_width);?>px;height:20px;line-height:20px;height:auto;float:left;text-align:center;border-bottom:solid 1px #eee;" title="<?php print($alt_text);?>"><?php 
													
													include 'approve_code.php';
														
												?>
												</div>
												<?php
													
											}
											?><input type="hidden" id="level_approved_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$this_beneficiary_agent_date.'_'.$l);?>" value="0">			
												<?php
										}									
										
									}
								}
							}
							?>
							
							
							<input type="hidden" id="file_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>" value="">
							<input type="hidden" id="level_action_type_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>" value="0">
							<?php
						
						}else{
							?>
							<div style="position:relative;width:<?php print($cell_width);?>px;height:auto;float:left;font-size:0.9em;" id="claim_file_holder_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>">
								<?php
								$approved = 0;
								$document_string = array();
								for($a=0;$a<count($approval_beneficiary_date_array);$a++){
									if(!$approval_beneficiary_date_array[$a] and $approval_claim_type_date_array[$a] == $this_claim_type_date and $approval_level_array[$a] == $l and $approval_validity_array[$a] ==1 and $approval_approval_type_array[$a] == 0){

										$document_string = explode(',',$approval_file_src_array[$a]);
										$approval_status  = $approval_status_array[$a];
										$approval_goto_to = $approval_goto_level_array[$a];
										$approved = 1;
										break;
										
									}else{
										$document_string = explode('|',$this_level_rule_array[11]);

									}									
								}
								
								
								for($d=0;$d<count($document_string);$d++){
									if(!$approved){
										$level_aproved = 0;	
										
										?>
										<div style="width:100%;height:auto;float:left;display:none;" id="added_file_holder_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>">
										
										
										</div>
										
										<div style="width:100%;height:auto;float:left;" id="add_file_holder_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>">
										<?php

										if(!$d){
											?>
											<div style="padding-left:4px;width:99%;height:auto;float:left;margin-top:5px;">Add files: </div>
											<?php
										}										
										?>
										
										<div style="width:100%;height:auto;float:left;margin-top:3px;font-size:0.9em;" >
											<div style="margin-left:4px;padding:2px;cursor:pointer;width:70%;max-width:100%;min-height:25px;height:auto;line-height:25px;float:left;background-color:orange;border-bottom:solid 1px #eee;color:#fff;text-align:center;" onmouseover="this.style.backgroundColor='#ffc354';" onmouseout="this.style.backgroundColor='orange';" title="Click to upload file" onclick="add_approval_file(<?php print($this_claim_date.','.$this_claim_type_date.','.$l);?>);"><?php print($document_string[$d]);?></div>
										</div>
										
										</div>
									
										
										<input type="hidden" id="file_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>" value="">
										<?php

									}else{
										
										if(!$approval_status){
											$level_aproved = 0;
											print('<font style="color:brown;text-align:center;">Sent to level '.($approval_goto_to+1).'</font>');
										}else{
											$level_aproved = 1;											
											if(!$d){
												?>
												<div style="font-weight:bold;padding-left:4px;width:99%;height:auto;float:left;margin-top:5px;margin-bottom:15px;">Uploaded files: </div>
												<?php
											}										
											
											$file_name = $document_string[$d];
											
											if(strlen($file_name)>10){
												$file_name =  substr($file_name,0,10).'...';
												
											}
											
											print('<a title="Click to open file" style="cursor:pointer;" onmouseover="this.style.color=\'orange\'" onmouseout="this.style.color=\'\'" onclick="window.open(\''.$url.'/imgs/'.$document_string[$d].'\',\'file_download_'.$d.'\')">'.($d+1).'. '.$file_name.'</a><br><br>');
										
										}
									}
								}
								
								
								if(!$approved){
									if($this_claim_results['status'] != 0){
										
								?>
								
								<div style="width:auto;float:left;margin-left:5px;text-align:left;margin-top:4px;" id="file_approver_bottons_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>">
									<div style="width:30px;margin-left:3px;float:left;height:20px;text-align:center;background-color:#898;color:#fff;cursor:pointer;" onmouseout="this.style.backgroundColor='#898';" onmouseover="this.style.backgroundColor='#8d8';" onclick="confirm_level(<?php print($this_claim_date.','.$this_claim_type_date.',0,'.$c.','.$l.',0,1,1');?>);" title="Click to approve">&#10004;</div> <div style="width:30px;margin-left:3px;float:left;height:20px;text-align:center;background-color:#e88;color:#fff;cursor:pointer;" onmouseout="this.style.backgroundColor='#e88';"onmouseover="this.style.backgroundColor='brown';" onclick="reject_level(<?php print($this_claim_date.','.$this_claim_type_date.',0,'.$c.','.$l.',1,1');?>);" title="Click to deny approval">&#10005; </div>
									
								</div>
								<?php
									}else{
										print('N/A');
									}
									
								}else{
									?>
									<div style="width:95%;height:20px;line-height:20px;text-align:center;float:left;background-color:#eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" title="Click to view approvers" onclick="$('#approval_detail_<?php print($this_claim_type_date.'_'.$c.'_'.$this_beneficiary_agent_date.'_'.$l);?>').slideToggle('fast');">Approvers</div><div style="font-size:1.1em;width:<?php print($cell_width+80);?>px;height:auto;border-bottom:solid 1px #fdd;margin-top:20px;position:absolute;display:none;background-color:#fff;z-index:10;border:solid 1px #ddd;padding:2px;" id="approval_detail_<?php print($this_claim_type_date.'_'.$c.'_'.$this_beneficiary_agent_date.'_'.$l);?>" ondblclick="$(this).slideUp('fast');">
										<div style="width:100%;background-color:#fdd;min-height:20px;height:auto;line-height:20px;float:left;font-weight:bold;text-align:center;"><?php print('Level '.($l+1).' file upload');?></div>
											<div style="width:100%;min-height:150px;max-height:200px;float:left;overflow:auto;font-size:0.9em;line-height:15px;">
													<?php
													
													$this_beneficiary_approval_index = array_keys($approval_beneficiary_date_array,0);
													
													$first_entry = 0;
													for($tb=0;$tb<count($this_beneficiary_approval_index);$tb++){
														if($approval_level_array[$this_beneficiary_approval_index[$tb]] == $l and $approval_claim_type_date_array[$this_beneficiary_approval_index[$tb]] == $this_claim_type_date){
															
															$this_approval_user_index = array_keys($user_date_array,$approval_user_date_array[$this_beneficiary_approval_index[$tb]]);
															
															$approver_name = $user_name_array[$this_approval_user_index[0]];
															$approver_phone = $user_phone_array[$this_approval_user_index[0]];
															
															$approver_date = $approval_date_array[$this_beneficiary_approval_index[$tb]];
															
															
															
															if(!$approval_validity_array[$this_beneficiary_approval_index[$tb]]){
																$font_color = '#777';
																
															}else{
																$font_color = '#000';
																
															}
															
															if(!$approval_approval_type_array[$this_beneficiary_approval_index[$tb]]){
																$approval_type = 'Manual';
																
															}else{
																$approval_type = 'Auto';
																
															}
															
															?>
															<div style="color:<?php print($font_color);?>;width:100%;height:auto;float:left;">
																Approver type: <?php	print($approval_type.'<br>');?>
																Approver: <?php	print($approver_name.'<br>');?>
																Phone: <?php	print($approver_phone.'<br>');?>
																Date: <?php print(date('jS M, Y',$approver_date).'<br>');?>
																Time: <?php print(date('H:i:s',$approver_date).'<br>');
																
																if(!$approval_validity_array[$this_beneficiary_approval_index[$tb]]){
																	$invalidation_date = $approval_validity_date_array[$this_beneficiary_approval_index[$tb]];
																
																	$invalidation_user_date = $approval_validity_user_date_array[$this_beneficiary_approval_index[$tb]];
																	
																	$this_invalidation_user_index = array_keys($user_date_array,$invalidation_user_date);
															
																	$invalidation_name = $user_name_array[$this_invalidation_user_index[0]];
																	$invalidation_phone = $user_phone_array[$this_invalidation_user_index[0]];
																	
																	?>
																	
																	
																	Rejected on: <?php print(date('jS M, Y',$invalidation_date).'<br>');
																	?>
																	
																	Rejected by: <?php print($invalidation_name.'<br>');?>
																	Phone: <?php print($invalidation_phone.'<br>');
																	
																}
																
																if($approval_comment_array[$this_beneficiary_approval_index[$tb]] != ''){
																	?>
																	<strong>Comment: <?php print($approval_comment_array[$this_beneficiary_approval_index[$tb]].'</strong><br>');
																	
																}
																
																
																if($approval_file_src_array[$this_beneficiary_approval_index[$tb]] != ''){
																	
																	$approval_files = explode(',',$approval_file_src_array[$this_beneficiary_approval_index[$tb]]);
																	
																	$approval_file_string = '';
																	for($f2=0;$f2<count($approval_files);$f2++){
																		$this_file_name = $approval_files[$f2];
											
																		if(strlen($this_file_name)>10){
																			$this_file_name =  substr($file_name,0,10).'...';
																			
																		}
																		
																		if($approval_file_string == ''){
																			$approval_file_string = '<a title="Click to open file" style="cursor:pointer;" onmouseover="this.style.color=\'orange\'" onmouseout="this.style.color=\'\'" onclick="window.open(\''.$url.'/imgs/'.$approval_files[$f2].'\',\'file_download\')">'.($f2+1).'. '.$this_file_name.'</a><br>';
																		
																		}else{
																			$approval_file_string .= '<a title="Click to open file" style="cursor:pointer;" onmouseover="this.style.color=\'orange\'" onmouseout="this.style.color=\'\'" onclick="window.open(\''.$url.'/imgs/'.$approval_files[$f2].'\',\'file_download\')">'.($f2+1).'. '.$this_file_name.'</a><br>';
																			
																		}		
																	}
																?>
																Files: <?php print($approval_file_string.'<br>');
																	
																}
																?>
															<br>
															</div>
															
															<?php
															if(!$first_entry){
																?>
																<div style="background-color:#eee;width:100%;height:20px;line-height:20px;float:left;text-align:center;">Past approvals</div>
																<?php
															}
															
															$first_entry = 1;
														}													
													}
													
													
													?>
													
													</div>
										</div>
										
										
									<?php	
									
								}
								?>
								<input type="hidden" id="level_approved_<?php print($this_claim_date.'_'.$this_claim_type_date.'_0_'.$l);?>" value="<?php print($level_aproved);?>">
								<input type="hidden" id="total_confirm_files_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>" value="<?php print(count($document_string));?>">
								
								<input type="hidden" id="level_action_type_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>" value="1">
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
				</div>
			
			<?php
			}else{
				?>				
				<div style="width:100%;height:30px;line-height:30px;text-align:center;font-size:1.3em;color:#777;float:left;">No beneficiaries were added to this claim type</div>					
				<?php
			}
			
			?>
			</div>
			<input type="hidden" id="selected_beneficiaries_<?php print($this_claim_date.'_'.$this_claim_type_date);?>" value="<?php print($selected_beneficiaries);?>">
			<input type="hidden" id="all_beneficiaries_<?php print($this_claim_date.'_'.$this_claim_type_date);?>" value="<?php print($all_beneficiaries);?>">
			
			<?php
		}
		?>
		<input type="hidden" value="<?php print($this_claim_results['claim_type_date']);?>" id="claim_type_date_string_<?php print($this_claim_date);?>">
	</div>


<div style="width:100%;min-height:40px;height:auto;float:left;background-color:#fff;border-bottom:solid 1px #eee;">
	<?php
		if($this_claim_results['file_src'] != ''){
			$attachments = explode(',',$this_claim_results['file_src']);
			
			for($f=0;$f<count($attachments);$f++){
				$file_array = explode('.',$attachments[$f]);
				
				if(!file_exists('../imgs/'.$file_array[1].'_icon.png')){
					$file_icon = 'unknown_icon.png';
					
				}else{
					$file_icon = $file_array[1].'_icon.png';
				}
				
				if($this_claim_results['claim_id'] > 5290){
					
					$file_location = $url.'imgs/attachments/'.$attachments[$f];
					
				}else{
					$file_location = 'https://www.pipatzambia.org/claims/imgs/'.$attachments[$f];
					
				}
				
				?>
			<div style="margin:5px;width:auto;height:30px;color:#000;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#efe';" onmouseout="this.style.backgroundColor='';" onclick="window.open('<?php print($file_location);?>','attachment_<?php print($attachments[$f]);?>');" id="download_attachment_<?php print($this_claim_results['_date']);?>"><div style="margin:2px;width:25px;height:25x;color:#000;text-align:center;float:left;"><img src="../imgs/<?php print($file_icon);?>" style="height:25px"></div><div style="width:auto;height:30x;color:#000;text-align:center;float:left;padding-right:5px;"><?php print($attachments[$f]);?></div></div>
			
			<?php
			}
		}else{
			?>
			<div style="width:100%;float:left;min-height:40px;height:auto;line-height:40px;color:#888;background-color:#fff;text-align:center;font-size:1.5em;" id="attachments_holder">No attachments were added</div>
			<?php
		}
		?>
	</div>
	
	<div style="width:100%;min-height:110px;float:left;">
	
	<div style="width:100px;height:auto;float:left;margin-top:5px;position:relative">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#spreadsheet_menu_<?php print($this_claim_date);?>').toggle('fast');" id="active_spreadsheet_<?php print($this_claim_date);?>" onmouseover="this.style.backgroundColor='#8cb7d4';" onmouseout="this.style.backgroundColor='#006bb3';" style="color:#fff;background-color:#006bb3;">Spreadsheet</div>


			<div class="option_menu" id="spreadsheet_menu_<?php print($this_claim_date);?>" style="display:none;min-width:160px;color:#fff;background-color:#006bb3;">
				<div class="option_menu_item" onmouseover="this.style.backgroundColor='#8cb7d4';" onmouseout="this.style.backgroundColor='#006bb3';" title="Claim spreadsheet will not have signing options and claim number" onclick="$('#spreadsheet_menu_<?php print($this_claim_date);?>').toggle('fast');open_spreadsheet(<?php print($this_claim_date.','.$user_date.','.$company_id.',0,'.$this_claim_results['ascensions']);?>,'','')">For Preview</div>
				
				<?php
					if($this_claim_results['status'] == 3 or $this_claim_results['status'] == 1){
						
						?>
				
				<div class="option_menu_item" onmouseover="this.style.backgroundColor='#8cb7d4';" onmouseout="this.style.backgroundColor='#006bb3';" title="Claim spreadsheet will have letter ascensions next to claim number, except the first one." onclick="var c = confirm('This will assign a new ascension code to the claim number. Are you sure you wish to proceed?');if(c){$('#spreadsheet_menu_<?php print($this_claim_date);?>').toggle('fast');open_spreadsheet(<?php print($this_claim_date.','.$user_date.','.$company_id.',1,'.$this_claim_results['ascensions']);?>,'','');}">For Finance Processing</div>
				
				<?php
					}
					?>


			</div>
		</div>
	</div>
	
	<div style="width:100px;height:auto;float:left;margin-top:5px;position:relative">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#claim_form_menu_<?php print($this_claim_date);?>').toggle('fast');" id="active_claim_form_<?php print($this_claim_date);?>" onmouseover="this.style.backgroundColor='#56cfd8';" onmouseout="this.style.backgroundColor='#35bcc7';" style="color:#fff;background-color:#35bcc7">Claim Forms</div>


			<div class="option_menu" id="claim_form_menu_<?php print($this_claim_date);?>" style="display:none;min-width:160px;color:#fff;background-color:#35bcc7;">
				<div class="option_menu_item" onmouseover="this.style.backgroundColor='#56cfd8';" onmouseout="this.style.backgroundColor='#35bcc7';" title="Click to download claim form for signing" onclick="$('#claim_form_menu_<?php print($this_claim_date);?>').toggle('fast');open_spreadsheet(<?php print($this_claim_date.','.$user_date.','.$company_id);?>,3,0,'','')">For CHWs</div>
				
				
				<div class="option_menu_item" onmouseover="this.style.backgroundColor='#56cfd8';" onmouseout="this.style.backgroundColor='#35bcc7';" title="Click to download claim form for signing" onclick="$('#claim_form_menu_<?php print($this_claim_date);?>').toggle('fast');open_spreadsheet(<?php print($this_claim_date.','.$user_date.','.$company_id);?>,4,0,'','')">For Service Providers</div>
				
				


			</div>
		</div>
	</div>
	
	<div style="width:100px;height:auto;float:left;margin-top:5px;position:relative">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to download CSV files" onclick="<?php if($this_claim_results['ascensions'] == 0){?> alert('You first need to export the claim spreadsheet');<?php }else{?>$('#csv_form_menu_<?php print($this_claim_date);?>').toggle('fast');<?php }?>" id="active_csv_form_<?php print($this_claim_date);?>" onmouseover="this.style.backgroundColor='#faa4ff';" onmouseout="this.style.backgroundColor='#d697ee';" style="color:#fff;background-color:#d697ee;width:100px;">CSV for ZOONA</div>
			
			
			<div class="option_menu" id="csv_form_menu_<?php print($this_claim_date);?>" style="display:none;min-width:130px;color:#fff;background-color:#d697ee;">
			<?php
			for($a=0;$a<$this_claim_results['ascensions'];$a++){
				?>
				<div class="option_menu_item" onmouseover="this.style.backgroundColor='#faa4ff';" onmouseout="this.style.backgroundColor='#d697ee';" title="Click to download CSV for this group of beneficiaries" onclick="$('#csv_form_menu_<?php print($this_claim_date);?>').slideUp('fast');generate_claim_csv(<?php print($this_claim_results['_date'].','."'".$this_claim_results['claim_id'].$alphabet[$a]."',".$a);?>);">Spreadsheet <?php print($this_claim_results['claim_id'].$alphabet[$a]);?></div>
				<?php
			}
			?>
			</div>
		</div>
	</div>
	
	<?php
	if((($this_claim_results['status'] == 3 or $this_claim_results['status'] == 1) and $this_claim_results['user_date'] == $user_results['_date']) or $active_user_roles[8] == 1){
	?>
		<div style="background-color:#b0b679;width:110px;color:#fff;cursor:pointer;height:30px;margin:5px;float:right;text-align:center;line-height:30px;border:solid 1px #fff;" onmouseover="this.style.backgroundColor='#c0c782';" onmouseout="this.style.backgroundColor='#b0b679';" onclick="change_claim_status(<?php print($this_claim_results['_date']);?>);"  title="Click to change claim status">Change status</div>
		
		<div style="display:none;background-color:brown;width:70px;color:#fff;cursor:pointer;height:30px;margin:5px;float:right;text-align:center;line-height:30px;border:solid 1px #fff;" onmouseover="this.style.backgroundColor='#bf1a1a';" onmouseout="this.style.backgroundColor='brown';" onclick="disable_claim(<?php print($this_claim_results['_date']);?>)" id="claim_disable_button_<?php print($this_claim_results['id']);?>">Disable</div>
	
	<?php
	
	}else if(($this_claim_results['status'] == 0 and $this_claim_results['user_date'] == $user_results['_date']) or $active_user_roles[8] == 1){
		?>
		<div style="background-color:#7bae7b;width:70px;color:#fff;cursor:pointer;height:30px;margin:5px;float:right;text-align:center;line-height:30px;border:solid 1px #fff;" onmouseover="this.style.backgroundColor='#99ba99';" onmouseout="this.style.backgroundColor='#7bae7b';" onclick="enable_claim(<?php print($this_claim_results['_date']);?>)" id="claim_enable_button_<?php print($this_claim_results['id']);?>">Enable</div>
		
		<?php
		
	}
	if(($this_claim_results['status'] == 3 and $this_claim_results['user_date'] == $user_results['_date']) or $active_user_roles[8] == 1){
	?>
		
	
		<div style="background-color:orange;width:70px;color:#fff;cursor:pointer;height:30px;margin:5px;float:right;text-align:center;line-height:30px;border:solid 1px #fff;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="fetch_claim_details(<?php print($this_claim_results['id']);?>);">Edit</div>
		
		<?php
		}
		?>
		
		<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
		<?php
		$ascension_date_array = explode(',',$this_claim_results['ascension_dates']);
		$ascension_user_date_array = explode(',',$this_claim_results['ascension_user_dates']);
	for($a=0;$a<$this_claim_results['ascensions'];$a++){
		
		$this_user_date = $ascension_user_date_array[$a];
		
		$this_user_index = array_keys($user_date_array,$this_user_date);
		
		$this_user_name = 'Unknown user';
		if(isset($this_user_index[0])){
			$this_user_name = $user_name_array[$this_user_index[0]];
			
		}
		
		?>
		<div style="cursor:pointer;width:100%;height:20px;line-height:20px;margin-top:2px;float:left;background-color:#ddf" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';" title="Click to view beneficiaries" onclick="$('#spreadsheet_agent_holder_<?php print($claim_date.'_'.$a);?>').slideToggle('fast');">Spreadsheet <?php print($this_claim_results['claim_id'].$alphabet[$a].' - '.date('jS M, Y',$ascension_date_array[$a]).' - '.date('H:i:s',$ascension_date_array[$a]).', By '.$this_user_name);?></div>
		
		<div style="width:100%;height:auto;float:left;margin-bottom:20px;display:none;" id="spreadsheet_agent_holder_<?php print($claim_date.'_'.$a);?>">
			<div style="width:100%;height:20px;float:left;background-color:#eef"><div style="width:20px;height:20px;float:left;margin-right:3px;"></div><div style="width:250px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:250px;height:20px;float:left;margin-right:3px;">Claim type</div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div></div>
			<input type="hidden" id="spreadsheet_beneficiary_remove_queue_<?php print($claim_date.'_'.$a);?>" value="">
			<?php
			$spreadsheet_claim_types = '';
				for($a1=0;$a1<count($asc_date_array);$a1++){
					
					if($asc_ind_array[$a1] == $a){
						
						for($b=0;$b<count($beneficiary_name_array);$b++){
							if($beneficiary_type_date_array[$b] == $asc_type_date_array[$a1] and $beneficiary_date_array[$b] == $asc_agent_date_array[$a1]){
								$this_asc_ben_name = $beneficiary_name_array[$b];
							
								$this_claim_type_date = $asc_type_date_array[$a1];
								
								$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
			
								$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);			
							
								if($asc_status_array[$a1] == 1){
									if(isset($spreadsheet_beneficiary[$this_claim_results['claim_id'].$alphabet[$a]][$this_claim_type_date])){
										$spreadsheet_beneficiary[$this_claim_results['claim_id'].$alphabet[$a]][$this_claim_type_date] .= ','.$asc_agent_date_array[$a1];
										
									}else{
										$spreadsheet_beneficiary[$this_claim_results['claim_id'].$alphabet[$a]][$this_claim_type_date] = $asc_agent_date_array[$a1];
									}
								}
								
								if($spreadsheet_claim_types == ''){
									
									$spreadsheet_claim_types = $this_claim_type_date;
									
								}else if(!search_item_in_list($this_claim_type_date,$spreadsheet_claim_types,0)){
									$spreadsheet_claim_types .= ','.$this_claim_type_date;

								}
								
								
								
								?>
								<div style="width:100%;min-height:25px;height:auto;float:left;border-bottom:solid 1px #eee;line-height:25px;<?php if($asc_status_array[$a1] == 0){print('color:#aaa;');}?>" id="ascension_beneficiary_holder_<?php print($claim_date.'_'.$a.'_'.$beneficiary_date_array[$b].'_'.$this_claim_type_results['_date']);?>"> <div style="width:auto;height:25px;float:left;"><?php if($user_date == $this_user_date || $active_user_roles[8] == 1){?><div style="cursor:pointer;color:#fff;margin-top:2px;margin-right:5px;width:20px;height:20px;float:left;background-color:#74b474;text-align:center;line-height:20px;<?php if($asc_status_array[$a1] != 0){?>display:none;<?php }?>" onmouseover="this.style.backgroundColor='#9ec39e'" onmouseout="this.style.backgroundColor='#74b474';" onclick="change_status_spreadsheet_beneficiary(<?php print($claim_date.','.$a.','.$beneficiary_date_array[$b].','.$this_claim_type_results['_date'].',1,\''.$this_claim_results['claim_id'].$alphabet[$a].'\'');?>);" id="ascension_beneficiary_add_<?php print($claim_date.'_'.$a.'_'.$beneficiary_date_array[$b].'_'.$this_claim_type_results['_date']);?>">&#10003;</div> <div style="cursor:pointer;color:#fff;margin-top:2px;margin-right:5px;width:20px;height:20px;float:left;background-color:brown;text-align:center;line-height:20px;<?php if($asc_status_array[$a1] == 0){?>display:none;<?php }?>" onmouseover="this.style.backgroundColor='#b83f3f'" onmouseout="this.style.backgroundColor='brown';" onclick="change_status_spreadsheet_beneficiary(<?php print($claim_date.','.$a.','.$beneficiary_date_array[$b].','.$this_claim_type_results['_date'].',0,\''.$this_claim_results['claim_id'].$alphabet[$a].'\'');?>);" id="ascension_beneficiary_remove_<?php print($claim_date.'_'.$a.'_'.$beneficiary_date_array[$b].'_'.$this_claim_type_results['_date']);?>">X</div><?php }?></div><div style="width:250px;min-height:25px;height:auto;float:left;margin-right:3px;"><?php print($this_asc_ben_name);?></div><div style="width:250px;min-height:25px;height:auto;float:left;margin-right:3px;"><?php print($this_claim_type_results['title']);?></div><div style="width:200px;min-height:25px;height:auto;float:left;margin-right:3px;" id="ascension_beneficiary_status_<?php print($claim_date.'_'.$a.'_'.$beneficiary_date_array[$b].'_'.$this_claim_type_results['_date']);?>"></div></div>
								
								<?php
								break;
							}
						}
					}
				}			
			?>
			<div style="width:85px;height:25px;background-color:#aaf;float:left;line-height:25px;margin-top:2px;text-align:center;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#aaf';" title="Click to open spreadsheet for this entry" onclick="open_spreadsheet(<?php print($this_claim_date.','.$user_date.','.$company_id.',1,'.$a.',1');?>,'<?php print('spreadsheet_'.$this_claim_results['claim_id'].$alphabet[$a]);?>');">Open</div>
		<input type="hidden" id="spreadsheet_<?php print($this_claim_results['claim_id'].$alphabet[$a]);?>_claim_types" value="<?php print($spreadsheet_claim_types);?>">
		
		<?php
			$spreadsheet_claim_type_array = explode(',',$spreadsheet_claim_types);
			
			for($sc=0;$sc<count($spreadsheet_claim_type_array);$sc++){
				if(isset($spreadsheet_beneficiary[$this_claim_results['claim_id'].$alphabet[$a]][$spreadsheet_claim_type_array[$sc]])){
					$spreadsheet_beneficiary_string = $spreadsheet_beneficiary[$this_claim_results['claim_id'].$alphabet[$a]][$spreadsheet_claim_type_array[$sc]];
					
				}else{
					$spreadsheet_beneficiary_string = '';
					
				}
				?>
				<input type="hidden" id="spreadsheet_<?php print($this_claim_results['claim_id'].$alphabet[$a].'_'.$spreadsheet_claim_type_array[$sc]);?>" value="<?php print($spreadsheet_beneficiary_string);?>">
				<?php
			}
		
		?>
		
		</div>
		
		<?php
	}
	?>
	</div>
	</div>
	
	
	
	
	</div>