<div style="width:975px;min-height:300px;max-height:500px;float:left;overflow:auto;background-color:#fff">
	<?php

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



	<div style="min-width:100%;width:100%;min-height:30px;height:auto;float:left;background-color:#fff9f9;">		
		<?php
		$claim_beneficiaries = mysqli_query($$module_connect,"select * from tmp_claim_beneficiaries where claim_date = '$this_claim_date' and company_id = $company_id")or die(mysqlI_error($$module_connect));
		
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
		
		$other_beneficiaries = mysqli_query($$module_connect,"select * from tmp_claim_beneficiaries where company_id = $company_id and claim_date != '$claim_date'")or die(mysqli_error($$module_connect));
		
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
		
		for($a=0;$a<mysqli_num_rows($ascension_beneficiaries);$a++){
			$acsension_beneficiaties = mysqli_fetch_array($ascension_beneficiaries,MYSQLI_ASSOC);
			
			$asc_agent_date_array[$a] = $acsension_beneficiaties['agent_date'];
			$asc_type_date_array[$a] = $acsension_beneficiaties['type_date'];
			$asc_ind_array[$a] = $acsension_beneficiaties['ascension_ind'];
			$asc_date_array[$a] = $acsension_beneficiaties['_date'];
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
			<div style="width:100%;height:auto;float:left;">
				<div style="width:100%;float:left;height:20px;background-color:#f3fced">						
					<div style="width:180px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Name</div>
					<div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Region</div>
					<div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Province</div>
					<div style="width:130px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Hub</div>
					<div style="width:140px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Mother facility</div>
					<div style="width:130px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Site</div>
					<div style="width:40px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;">Days</div>
					<div style="width:50px;height:20px;line-height:20px;float:left;text-align:right;">P.days</div>
					
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
						
						if($this_beneficiary_amount == 0){
							$this_color = '#aaa';
							
						}else{
							$this_color = '#000';
							
						}
						
						
							
						?>	
						<div style="color:<?php print($this_color);?>;width:100%;float:left;min-height:20px;height:auto;border-bottom:solid 1px #eee;position:relative" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
							<div style="width:auto;float:left;height:auto;cursor:pointer;" onclick="$('#beneficiary_details_<?php print($this_claim_date.'_'.$this_beneficiary_id);?>').slideToggle('fast');">
							<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;text-align:left;margin-left:2px;" title="<?php print($this_beneficiary_name.' ('.$this_beneficiary_phone.')');?>. Click for more details" ><?php 
							
							
							$beneficiary_name = $this_beneficiary_name;
								
							
							print($beneficiary_name);?></div>
							<div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print($this_beneficiary_region);?></div>
							<div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print($this_beneficiary_province);?></div>
							<div style="width:130px;min-height:20px;height:auto;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print($this_beneficiary_hub);?></div>
							<div style="width:140px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"></div>
							<div style="width:130px;min-height:20px;height:auto;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print($this_beneficiary_site);?></div>
							<div style="width:40px;min-height:20px;height:auto;line-height:20px;float:left;text-align:right;"><?php print($this_beneficiary_days);?></div>
							<div style="width:50px;min-height:20px;height:auto;line-height:20px;float:left;text-align:right;"><?php print($this_beneficiary_paid_days);?></div>
							
							<div style="width:60px;min-height:20px;height:auto;line-height:20px;float:left;text-align:right;"><?php print(number_format($this_beneficiary_amount,2));?></div>
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
					<div style="width:943px;float:left;height:20px;text-align:right;color:#006bb3;">							
						Sub-Total: K<?php print(number_format($total_amount,2));?>
					</div>
					<?php
				}
				?>
			</div>
			</div>
			<?php
		}
		?>
		<input type="hidden" value="<?php print($this_claim_results['claim_type_date']);?>" id="claim_type_date_string_<?php print($this_claim_date);?>">
	</div>
	
		<div style="width:100%;height:auto;float:left;margin-bottom:20px;">
			<div style="width:85px;height:25px;background-color:brown;float:right;margin-right:5px;line-height:25px;margin-top:2px;text-align:center;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#c98a8a';" onmouseout="this.style.backgroundColor='brown';" title="Click to delete this entry" onclick="delete_awaiting_claim(<?php print($claim_date);?>);" id="delete_awaiting_claim_button_<?php print($claim_date);?>">Delete entry</div>
			
			<div style="width:85px;height:25px;background-color:#a3b678;float:right;margin-right:5px;line-height:25px;margin-top:2px;text-align:center;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#bdd092';" onmouseout="this.style.backgroundColor='#a3b678';" title="Click to create claim" onclick="create_claim_from_awaiting(<?php print($claim_date);?>);" id="create_awaiting_claim_button_<?php print($claim_date);?>">Create claim</div>
		</div>
	</div>