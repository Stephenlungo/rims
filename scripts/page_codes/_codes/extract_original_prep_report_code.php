<?php
	$clinical_visits[$client_results['id']] = array();			
	$check_reasons_for_stopping_index = array_keys($reason_for_stoppoing_client_id_array,$client_results['id']);
	
	$reasons_for_stopping_prep_follow_up_title = '';
	$reasons_for_stopping_prep_adherence_title = '';
	if(!isset($check_reasons_for_stopping_index[0])){
		$reasons_for_stopping_prep_follow_up_title = '';
		$reasons_for_stopping_prep_adherence_title = '';
		
	}else{
		if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 69){
			$reasons_for_stopping_prep_follow_up_title = 'No longer at risk';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 68){
			$reasons_for_stopping_prep_follow_up_title = 'Sero-conversion (HIV positive)';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 71){
			$reasons_for_stopping_prep_follow_up_title = $reason_for_stoppoing_value_array[$check_reasons_for_stopping_index[0]];
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 70){
			$reasons_for_stopping_title = 'Poor adherence';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 303){
			$reasons_for_stopping_title = 'Contraindication to PrEP';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 304){
			$reasons_for_stopping_title = 'Partner on ART VL suppressed';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 305){
			$reasons_for_stopping_title = 'Client has one consistent sexual partner';
			
		}
		
		
		
		if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 277){
			$reasons_for_stopping_prep_adherence_title = 'No longer at risk';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 278){
			$reasons_for_stopping_prep_adherence_title = 'Sero-conversion (HIV positive)';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 279){
			$reasons_for_stopping_prep_adherence_title = 'If HIV Positive - link to treatment';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 280){
			$reasons_for_stopping_prep_adherence_title = 'Side Effects';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 281){
			$reasons_for_stopping_prep_adherence_title = 'Burden of taking pills';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 282){
			$reasons_for_stopping_prep_adherence_title = 'Lack of support by friends/ family';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 283){
			$reasons_for_stopping_prep_adherence_title = 'Travel';
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 338){
			$reasons_for_stopping_prep_adherence_title = $reason_for_stoppoing_value_array[$check_reasons_for_stopping_index[0]];
			
		}else if($reason_for_stoppoing_id_array[$check_reasons_for_stopping_index[0]] == 388){
			$reasons_for_stopping_prep_adherence_title = 'Forgetfulness';
			
		}
		
	}
	
	if($authorised){				
		if($client_results['region_id']){					
			$region_index = array_keys($region_array['id'],$client_results['region_id']);
			if(isset($region_index[0])){
				
				$region_title = $region_array['title'][$region_index[0]];
				
			}else{
				$region_title = 'Region not found';
				
			}
			
		}else{
			$region_title = 'Unspecified';
			
		}
		
		if($client_results['province_id']){					
			$province_index = array_keys($province_array['id'],$client_results['province_id']);
			if(isset($region_index[0])){
				
				$province_title = $province_array['title'][$province_index[0]];
				
			}else{
				$province_title = 'Province not found';
				
			}
			
		}else{
			$province_title = 'Unspecified';
			
		}
		
		if($client_results['hub_id']){					
			$hub_index = array_keys($hub_array['id'],$client_results['hub_id']);
			if(isset($region_index[0])){
				
				$hub_title = $hub_array['title'][$hub_index[0]];
				
			}else{
				$hub_title = 'Hub not found';
				
			}
			
		}else{
			$hub_title = 'Unspecified';
			
		}
		
		if($client_results['site_id']){					
			$site_index = array_keys($site_array['id'],$client_results['site_id']);
			if(isset($region_index[0])){
				
				$site_title = $site_array['title'][$site_index[0]];
				
			}else{
				$site_title = 'Site not found';
				
			}
			
		}else{
			$site_title = 'Unspecified';
			
		}
		
		if($client_results['user_id']){
			
			$user_index = array_keys($user_array['id'],$client_results['user_id']);
		
			if(isset($user_index[0])){
				$user_title = $user_array['_name'][$user_index[0]];
				
			}else{
				$user_title = 'User not found';
				
			}
			
		}else{
			$user_title = 'Unknown';
			
		}
		
		if($client_results['risk_level'] == 0){
			$risk_status = 'No risk';
			
		}else if ($client_results['risk_level'] == 1){
			$risk_status = 'Low risk';
			
		}else if($client_results['risk_level'] == 2){
			$risk_status = 'Medium risk';
			
		}else if($client_results['risk_level'] > 2){
			$risk_status = 'High risk';
		}
		
		$risk_level = $client_results['risk_level'];
		
		$gender_id = $client_results['sex'];
		
		$gender_index = array_keys($gender_array['id'],$gender_id);
		
		if(isset($gender_index[0])){
			$client_gender = $gender_array['title'][$gender_index[0]];
			
		}else{
			$client_gender = 'Unknown';
			
		}
		
		$client_name = $client_results['_name'];
		$client_phone = $client_results['phone'];
		$client_age = $client_results['age'];
		
	}else{
		$region_title = 'Locked';
		$province_title = 'Locked';
		$hub_title = 'Locked';
		$site_title = 'Locked';
		$user_title = 'Unknown';
		$risk_status = 'Locked';
		$risk_level = 'Locked';
		$client_gender = 'Locked';				
		$client_name = 'Locked';
		$client_phone = 'Locked';
		$client_age = 'Locked';
	}
	
	if(!$client_results['prep_id']){
			$prep_id_title = 'Unset';
			
		}else{
			$prep_id_title = $client_results['prep_id'];
			
		}
	
		
	if($client_results['agent_id']){
		$agent_index = array_keys($agent_array['id'],$client_results['agent_id']);
		
		if(isset($agent_index[0])){
			$agent_title = $agent_array['_name'][$agent_index[0]];
			
		}else{
			$agent_title = 'Agent not found';
			
		}

	}else{
		$agent_title = 'Unknown';
		
	}
	
	if($client_results['status'] == 0){
		$status_title = 'Mobilized';
		$successive_categorisation_title = 'Not Initiated';
		
	}else if($client_results['status'] == 1){
		$status_title = 'Screened';
		$successive_categorisation_title = 'Not Initiated';
		
	}else if($client_results['status'] == 2){
		$status_title = 'Initiated';
		$successive_categorisation_title = 'Initiated';
		
	}else if($client_results['status'] == 3){
		$status_title = 'Re-Started';
		$successive_categorisation_title = 'Initiated';
		
	}else if($client_results['status'] == 4){
		$status_title = 'Defaulted';
		$successive_categorisation_title = 'Initiated';
		
	}else if($client_results['status'] == 5){
		$status_title = 'Stopped';
		$successive_categorisation_title = 'Initiated';
		
	}else if($client_results['status'] == 6){
		$status_title = 'No risk (stopped)';
		$successive_categorisation_title = 'Initiated';
		
	}
	
	if($client_results['population_category_id'] == 0){
		$population_category = 'General';
		
	}else if($client_results['population_category_id'] == 1){
		$population_category = 'MSM';
		
	}else if($client_results['population_category_id'] == 2){
		$population_category = 'DC';
		
	}else if($client_results['population_category_id'] == 3){
		$population_category = 'FSW';
		
	}else if($client_results['population_category_id'] == 4){
		$population_category = 'PLM';
		
	}else if($client_results['population_category_id'] == 5){
		$population_category = 'AG/YW';
		
	}else if($client_results['population_category_id'] == 6){
		$population_category = 'Police Officer';
		
	}else if($client_results['population_category_id'] == 7){
		$population_category = 'Inmates';
		
	}else if($client_results['population_category_id'] == 8){
		$population_category = 'Prison Officer';
		
	}else if($client_results['population_category_id'] == 9){
		$population_category = 'Young Males';
		
	}else if($client_results['population_category_id'] == 10){
		$population_category = 'TG';
		
	}else if($client_results['population_category_id'] == 11){
		$population_category = 'PWID';
		
	}
	
	if($client_results['implementing_partner_id'] == 0){
		$implementing_partner = 'Unknown';
		
	}else if($client_results['implementing_partner_id'] == 1){
		$implementing_partner = 'USAID DISCOVER-Health';
		
	}else if($client_results['implementing_partner_id'] == 2){
		$implementing_partner = 'DREAMS';
		
	}else if($client_results['implementing_partner_id'] == 3){
		$implementing_partner = 'Open Doors';
		
	}else if($client_results['implementing_partner_id'] == 4){
		$implementing_partner = 'Self-Referral';
		
	}else if($client_results['implementing_partner_id'] == 5){
		$implementing_partner = 'Other';
		
	}
	
	if($client_results['knowledge_source_id'] == 0){
		$knowladge_source = 'Unknown';
		
	}else if($client_results['knowledge_source_id'] == 1){
		$knowladge_source = 'USAID DISCOVER-Health Staff';
		
	}else if($client_results['knowledge_source_id'] == 2){
		$knowladge_source = 'DREAMS';
		
	}else if($client_results['knowledge_source_id'] == 3){
		$knowladge_source = 'Open Doors';
		
	}else if($client_results['knowledge_source_id'] == 4){
		$knowladge_source = 'TV';
		
	}else if($client_results['knowledge_source_id'] == 5){
		$knowladge_source = 'Radio';
		
	}else if($client_results['knowledge_source_id'] == 6){
		$knowladge_source = 'Print Media';
		
	}else if($client_results['knowledge_source_id'] == 7){
		$knowladge_source = 'Social Media';
		
	}else if($client_results['knowledge_source_id'] == 8){
		$knowladge_source = 'Other';
		
	}
	
	$inter_departmental_referal = 'None';
	if($client_results['inter_departmental_referal_id'] == 1){
		$inter_departmental_referal = 'FP';
		
	}else if($client_results['inter_departmental_referal_id'] == 2){
		$inter_departmental_referal = 'ANC';
		
	}else if($client_results['inter_departmental_referal_id'] == 3){
		$inter_departmental_referal = 'VMMC';
		
	}else if($client_results['inter_departmental_referal_id'] == 4){
		$inter_departmental_referal = 'Index Case Testing';
		
	}else if($client_results['inter_departmental_referal_id'] == 5){
		$inter_departmental_referal = 'OPD';
		
	}
	
	if($client_results['account_status'] == 0){
		$account_status = 'Account disabled';
		
	}else{
		$account_status = 'Account enabled';
		
	}
	
	$form_value_index = array_keys($form_values_array['client_id'],$this_client_id);

	$follow_up_date[$this_client_id] = 'Not initiated';
	$this_prep_plan = 'Not set';
	$next_visit_date = 'Not set';
	$next_visit_pharmacy_date = 'Not set';
	$initiation_date = 'Not initiated';
	$urethral_screening = '';
	$lower_abdomen_screening = '';
	$dysuria_screening = '';
	$genital_sores_screening = '';
	$dyspareunia = '';
	$chlamydia_screening = '';
	$other_screening = '';
	$ln_swelling_screening = '';
	$gential_pain_screening = '';
	
	$condom_referal = '';
	$risk_reduction_referal = '';
	$partner_referal = '';
	$adherence_referal = '';
	$psychosocial_support_referal = '';
	$cacx_referal = '';
	$vmmc_referal = '';
	$fp_referal = '';
	$art_referal = '';
	$other_referal = '';
	$sti_referal = '';
	$nutrition_referal = '';
	
	$obstetric_lmp_date = '';
	$obstetric_edd_date = '';
	$obstetric_breastfeeding = '';
	$obstetric_child_positive = '';
	$obstetric_screened_for_cacx = '';
	$obstetric_pregnant = 'No';
	
	$dreams_intervention = 'No';
	
	$original_initiation_date = 0;
	if(isset($form_value_index[0])){
		
		for($i=0;$i<count($form_value_index);$i++){
			//initiation date
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 340){
				if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
					$initiation_date = 'Not provided';
					
				}else{
					$initiation_date = date('j/m/Y',$form_values_array['_value'][$form_value_index[$i]]);
					
					$original_initiation_date = $form_values_array['_value'][$form_value_index[$i]];
					
					$clinical_visits[$this_client_id][count($clinical_visits[$this_client_id])] = $form_values_array['_value'][$form_value_index[$i]];
					
				}
			}else if($initiation_date == 'Not initiated' and $i == count($form_value_index)-1){
				if($client_results['status'] > 1){
					$initiation_date = 'Not provided';
				}
			}
			
			//Next follow up date
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 341){
				
				if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
					
					if($follow_up_date[$this_client_id] ==''){
						$follow_up_date[$this_client_id] = 'Not provided1';
					
					}
					
				}else{
					if($follow_up_date[$this_client_id] == ''){
						$follow_up_date[$this_client_id] = date('jS M, Y',$form_values_array['_value'][$form_value_index[$i]]);
					}
					
					$clinical_visits[$this_client_id][count($clinical_visits[$this_client_id])] = $form_values_array['_value'][$form_value_index[$i]];
					
				}

			}else if($follow_up_date[$this_client_id] == 'Not initiated' and $i == count($form_value_index)-1){
				if($client_results['status'] >1){
					$follow_up_date[$this_client_id] = 'Not provided2';
				}
			}
			
			//PrEP plan
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 65){
				$this_prep_plan = 'Re-Start';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 66){
				$this_prep_plan = 'Continue';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 67){
				$this_prep_plan = 'Stop';
			}
			
			//PrEP current population category
			$current_population_category = 'Unspecified';
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 768){
				if($form_values_array['_value'][$form_value_index[$i]] == 0){
					$current_population_category = 'General';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 1){
					$current_population_category = 'MSM';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 2){
					$current_population_category = 'DC';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 3){
					$current_population_category = 'FSW';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 4){
					$current_population_category = 'PLM';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 5){
					$current_population_category = 'AG/YW';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 6){
					$current_population_category = 'Police officer';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 7){
					$current_population_category = 'Inmates';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 8){
					$current_population_category = 'Prison officer';
					
				}else if($form_values_array['_value'][$form_value_index[$i]] == 9){
					$current_population_category = 'Young males';
				}
			}
			
			//PrEP plan from initiation form
			if($this_prep_plan == 'Not set'){
				if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 194){
					$this_prep_plan = 'Client eligible but not starting PrEP';
					
				}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 292){
					$this_prep_plan = 'Client not eligible for PrEP';
					
				}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 195){
					$this_prep_plan = 'Start PrEP';
				}
			}
			
			//Next visit date
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 320){
				if($next_visit_date == 'Not set' || $next_visit_date == 'Not provided' || $next_visit_date < $form_values_array['_value'][$form_value_index[$i]]){
					if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
						$next_visit_date = 'Not provided';
						
					}else{
						$next_visit_date = $form_values_array['_value'][$form_value_index[$i]];
						
					}
				}
			}
			
			//Next visit date from initiation
			if($next_visit_date == 'Not set' || $next_visit_date == 'Not provided' || $next_visit_date < $form_values_array['_value'][$form_value_index[$i]]){
				if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 222){
					if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
						$next_visit_date = 'Not provided';
						
					}else{
						$next_visit_date = $form_values_array['_value'][$form_value_index[$i]];
						
					}
				}
			}
			
			//Next pharmacy visit date
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 319){
				if($next_visit_pharmacy_date == 'Not set' || $next_visit_pharmacy_date == 'Not provided' || $next_visit_pharmacy_date < $form_values_array['_value'][$form_value_index[$i]]){
					if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
						$next_visit_pharmacy_date = 'Not provided';
						
					}else{
						$next_visit_pharmacy_date = $form_values_array['_value'][$form_value_index[$i]];
						
					}
				}
			}
			
			//Next pharmacy visit date from initiation
			if($next_visit_pharmacy_date == 'Not set'  || $next_visit_pharmacy_date == 'Not provided' || $next_visit_pharmacy_date < $form_values_array['_value'][$form_value_index[$i]]){
				if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 221){
					if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
						$next_visit_pharmacy_date = 'Not provided';
						
					}else{
						$next_visit_pharmacy_date = $form_values_array['_value'][$form_value_index[$i]];
						
					}
				}
			}
			
			
			//STI screening
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 12){
				$urethral_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 13){
				$lower_abdomen_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 14){
				$dysuria_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 15){
				$genital_sores_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 16){
				$dyspareunia = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 17){
				$chlamydia_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 331){
				$other_screening = $form_values_array['_value'][$form_value_index[$i]];
				
			}
			
			
			//STI screening from initiation
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 131 and $urethral_screening == ''){
				$urethral_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 132 and $lower_abdomen_screening == ''){
				$lower_abdomen_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 133 and $genital_sores_screening == ''){
				$genital_sores_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 134){
				$ln_swelling_screening = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 135){
				$gential_pain_screening = 'Done';
				
			}
			
			//Referrals
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 82){
				$condom_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 83){
				$risk_reduction_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 84){
				$partner_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 85){
				$adherence_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 86){
				$psychosocial_support_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 87){
				$cacx_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 88){
				$vmmc_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 308){
				$fp_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 309){
				$art_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 335){
				$other_referal = $form_values_array['_value'][$form_value_index[$i]];
				
			}
			
			//Referrals from initiation
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 212){
				$sti_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 213){
				$nutrition_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 211 and $adherence_referal = ''){
				$adherence_referal = 'Done';
				
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 214 and$cacx_referal == ''){
				$cacx_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 210 and $vmmc_referal == ''){
				$vmmc_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 209 and $fp_referal==''){
				$fp_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 215 and $art_referal == ''){
				$art_referal = 'Done';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 327 and $other_referal  = ''){
				$other_referal = $form_values_array['_value'][$form_value_index[$i]];
				
			}
			
			//Obstetric history
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 32){
				if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
					$obstetric_lmp_date = 'Not provided';
					
				}else{
					$obstetric_lmp_date = date('j/m/Y',$form_values_array['_value'][$form_value_index[$i]]);
					
				}
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 33){
				if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
					$obstetric_edd_date = 'Not provided';
					
				}else{
					$obstetric_edd_date = date('j/m/Y',$form_values_array['_value'][$form_value_index[$i]]);
					
				}
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 34){
				$obstetric_breastfeeding = 'Yes';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 36){
				$obstetric_child_positive = 'Yes';
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 38){
				$obstetric_screened_for_cacx = 'Yes';
				
			}
			
			//Obstetric history from initiation
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 136){
				if($form_values_array['_value'][$form_value_index[$i]] == '-1'){
					$obstetric_pregnant = 'No';
				
				}else{
					$obstetric_pregnant = 'Yes';
				}
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 137 and $obstetric_lmp_date == ''){
				if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
					$obstetric_lmp_date = 'Not provided';
					
				}else{
					$obstetric_lmp_date = date('j/m/Y',$form_values_array['_value'][$form_value_index[$i]]);
					
				}
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 138 and $obstetric_edd_date == ''){
				if($form_values_array['_value'][$form_value_index[$i]] == '' || $form_values_array['_value'][$form_value_index[$i]] == 0){
					$obstetric_edd_date = 'Not provided';
					
				}else{
					$obstetric_edd_date = date('j/m/Y',$form_values_array['_value'][$form_value_index[$i]]);
					
				}
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 139 and $obstetric_breastfeeding == ''){
				if($form_values_array['_value'][$form_value_index[$i]] == '-1'){
					$obstetric_breastfeeding = 'No';
					
				}else{
					$obstetric_breastfeeding = 'Yes';
				}
				
			}else if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 140 and $obstetric_screened_for_cacx == ''){
				$obstetric_screened_for_cacx = 'Yes';
				
			}
			
			//Dreams intervention					
			if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$i]] == 767){
				$dreams_intervention = 'Yes';
				
			}
		}
	}
	
	
	
	
	if($next_visit_date == 'Not set' || $next_visit_date == '' || $next_visit_date == 'Not provided'){
		$client_activity_status = 'Determining forms not completed';
		
		$next_visit_day = 'Not found';
		$next_visit_month = 'Not found';
		$next_visit_year = 'Not found';
		
		$full_next_visit_date = 'Not found';
		
	}else{	
		if($next_visit_date < (time() - 2592000)){
			$client_activity_status = 'Inactive';
	
		}else{
			if($next_visit_date > time()){
				$client_activity_status = 'Active';
				
			}else{
				$client_activity_status = 'Active (Missed appointment)';
				
			}					
		}
		//print($next_visit_date.'-');
		$next_visit_day = date('j',$next_visit_date);
		$next_visit_month = date('M',$next_visit_date);
		$next_visit_year = date('Y',$next_visit_date);
		
		$full_next_visit_date = date('j/m/Y',$next_visit_date);
	}
	
	
	if($next_visit_pharmacy_date == 'Not set' || $next_visit_pharmacy_date == '' || $next_visit_pharmacy_date == 'Not provided'){
		//$client_activity_status = 'Determining forms not completed';
		
		$next_visit_pharmacy_day = 'Not found';
		$next_visit_pharmacy_month = 'Not found';
		$next_visit_pharmacy_year = 'Not found';
		
		$full_next_visit_pharmacy_date = 'Not found';
		
	}else{	
		if($next_visit_pharmacy_date < (time() - 2592000)){
			//$client_activity_status = 'Inactive';
	
		}else{
			if($next_visit_pharmacy_date > time()){
			   // $client_activity_status = 'Active';
				
			}else{
			   // $client_activity_status = 'Active (Missed appointment)';
				
			}					
		}
		//print($next_visit_date.'-');
		$next_visit_pharmacy_day = date('j',$next_visit_pharmacy_date);
		$next_visit_pharmacy_month = date('M',$next_visit_pharmacy_date);
		$next_visit_pharmacy_year = date('Y',$next_visit_pharmacy_date);
		
		$full_next_visit_pharmacy_date = date('j/m/Y',$next_visit_pharmacy_date);
	}
	
	$screening_index = array_keys($screening_array['client_id'],$this_client_id);
	
	if(isset($screening_index[0])){
		if($screening_array['answer'][$screening_index[0]] == 43){
			$had_sti = 'Yes';
			
		}else if($screening_array['answer'][$screening_index[0]] == 44){
			$had_sti = 'No';
			
		}else if($screening_array['answer'][$screening_index[0]] == 45){
			$had_sti = 'Don\'t know';
			
		}else{
			$had_sti = 'Unknown response';
			
		}
		
	}else{
		$had_sti = 'No response provided';

	}
	
	$show_entry = 1;
	
	
	if($show_entry){
		sort($clinical_visits[$this_client_id]);
		
		if(count($clinical_visits[$this_client_id]) > 1){
			$last_follow_up_visit = date('j/m/Y',$clinical_visits[$this_client_id][count($clinical_visits[$this_client_id])-1]);
			
		}else{
			$last_follow_up_visit = 'N/A';
			
		}
		
		$rows[count($rows)] = array($client_results['id'],date('j/m/Y',$client_results['_date']),$prep_id_title,$status_title,$client_name,$client_phone,$client_gender,$client_age,$population_category,$current_population_category,$knowladge_source,$inter_departmental_referal,$province_title,$hub_title,$site_title,$agent_title,$user_title,$dreams_intervention,$obstetric_pregnant,$obstetric_breastfeeding,$initiation_date,$last_follow_up_visit,$full_next_visit_pharmacy_date,$full_next_visit_date,$this_prep_plan,$client_activity_status,$reasons_for_stopping_prep_follow_up_title,$reasons_for_stopping_prep_adherence_title,$client_name.$site_title.$initiation_date);
		
		$hub_rows[count($hub_rows)] = array($client_results['id'],date('j/m/Y',$client_results['_date']),$prep_id_title,$status_title,$client_name,$client_phone,$client_gender,$client_age,$population_category,$current_population_category,$knowladge_source,$inter_departmental_referal,$province_title,$hub_title,$site_title,$agent_title,$user_title,$dreams_intervention,$obstetric_pregnant,$obstetric_breastfeeding,$initiation_date,$last_follow_up_visit,$full_next_visit_pharmacy_date,$full_next_visit_date,$this_prep_plan,$client_activity_status,$reasons_for_stopping_prep_follow_up_title,$reasons_for_stopping_prep_adherence_title,$client_name.$site_title.$initiation_date);
		
		for($cv=0;$cv<count($clinical_visits[$this_client_id]);$cv++){
			if(is_numeric($clinical_visits[$this_client_id][$cv])){
				$rows[count($rows)-1][count($rows[count($rows)-1])] = date('j/m/Y',$clinical_visits[$this_client_id][$cv]);$hub_rows[count($hub_rows)-1][count($hub_rows[count($hub_rows)-1])] = date('j/m/Y',$clinical_visits[$this_client_id][$cv]);
				
			}else{
				$rows[count($rows)-1][count($rows[count($rows)-1])] = $clinical_visits[$this_client_id][$cv];
				$hub_rows[count($hub_rows)-1][count($hub_rows[count($hub_rows)-1])] = $clinical_visits[$this_client_id][$cv];
			}
		}

		if($total_visits < count($clinical_visits[$this_client_id])){
			$total_visits = count($clinical_visits[$this_client_id]);				
		}
	}
?>