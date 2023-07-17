<?php

//Invoicing function

function validate_claim_rules($company_id,$user_id,$claim_type_id,$position,$amount){
	
	if(!isset($amount)){
		$amount = 0;
		
	}
	
	$this_user = mysqli_query($GLOBALS['connect'],"select * from users where id = '$user_id'")or die(mysqli_error($GLOBALS['claims_connect']));
	$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
	
	$this_claim = mysqli_query($GLOBALS['claims_connect'],"select * from request_types where _date = '$claim_type_id' and company_id = $company_id")or die(mysqli_error($GLOBALS['claims_connect']));
	$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
	//print($claim_type_id);
	$claim_rules = explode(']',$this_claim_results['rule_string']);
	
	$position_rules = explode(",",$claim_rules[$position]);
	
	$output_result = 0;
	if($position_rules[3] == 0){
		if($position_rules[4] == 0){
			if(($this_user_results['region_id'] == $position_rules[5] and $this_user_results['province_id'] == 0)|| $this_user_results['region_id'] == 0 and ($position_rules[5] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[5] == $this_user_results['unit_id'])){
				$output_result = 1;
				
				
			}
			
		}else if($position_rules[4] == 1){
			if(($this_user_results['province_id'] == $position_rules[5] and $this_user_results['hub_id'] == 0)|| $this_user_results['province_id'] == 0 and ($position_rules[5] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[5] == $this_user_results['unit_id'])){
				$output_result = 1;
			}
			
		}else if($position_rules[4] == 2){
			if(($this_user_results['hub_id'] == $position_rules[5] and $this_user_results['site_id'] == 0)|| $this_user_results['hub_id'] == 0 and ($position_rules[5] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[5] == $this_user_results['unit_id'])){
				$output_result = 1;
			}
			
		}else if($position_rules[4] == 3){
			if($this_user_results['site_id'] == $position_rules[5]|| $this_user_results['site_id'] == 0 and ($position_rules[5] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[5] == $this_user_results['unit_id'])){
				$output_result = 1;
			}
		}
		
	}else if($position_rules[3] == 1){
		$group_id = $position_rules[7];
		if(validate_threshold_appover($user_id,$group_id,$amount)){
			
			$output_result = 1;
		}
			
	}else if($position_rules[3] == 2){
		if($position_rules[8] == $user_id){
			$output_result = 1;
		}
	}
	
	return $output_result;
	$output_result = 0;
}

function validate_threshold_appover($user_id,$group_id,$amount){
	$this_user = mysqli_query($GLOBALS['connect'],"select * from users where id = '$user_id'")or die(mysqli_error($GLOBALS['claims_connect']));
	$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
	
	$this_threshold = mysqli_query($GLOBALS['claims_connect'],"select * from approval_thresholds where id = '$group_id'")or die(mysqli_error($GLOBALS['claims_connect']));
	$this_threshold_results = mysqli_fetch_array($this_threshold,MYSQLI_ASSOC);
	
	$threshold_rules = explode(']',$this_threshold_results['rule_string']);
	
	for($a=0;$a<count($threshold_rules);$a++){
		$position_rules = explode(",",$threshold_rules[$a]);
		
		$output_result = 0;
		
		if($position_rules[4] == 0){
			
			if($position_rules[5] == 0){
				
				if(($this_user_results['region_id'] == $position_rules[6] and $this_user_results['province_id'] == 0)|| $this_user_results['region_id'] == 0 and ($position_rules[7] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[7] == $this_user_results['unit_id'])){
					if(!$position_rules[0]){
						$output_result = 1;
						break;
						
					}else{
						if($amount == $position_rules[1]){
							$output_result = 1;
							
						}else if($amount < $position_rules[1]){
							if($position_rules[2] == 1){
								$output_result = 1;
								break;
								
							}else{
								for($a2=0;$a2<count($threshold_rules);$a2++){
									if($a2 != $a){
										$position_rules2 = explode(",",$threshold_rules[$a2]);
										
										if($position_rules2[0] and $position_rules2[1] < $position_rules[1]){
											break;
											
										}else if($position_rules2[0] and $position_rules2[1] >= $position_rules[1] and $a2 == (count($threshold_rules)-1)){
											$output_result = 1;
											break;
										}
									}									
								}								
							}							
						}else if($amount > $position_rules[1]){
							if(!$position_rules[3]){
								break;
								
							}else{
								$output_result = 1;
								break;
								
							}
						}						
					}
				}
				
			}else if($position_rules[5] == 1){
				if(($this_user_results['province_id'] == $position_rules[6] and $this_user_results['hub_id'] == 0)|| $this_user_results['province_id'] == 0 and ($position_rules[7] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[7] == $this_user_results['unit_id'])){
					
					if(!$position_rules[0]){
						$output_result = 1;
						break;
						
					}else{
						if($amount == $position_rules[1]){
							$output_result = 1;
							
						}else if($amount < $position_rules[1]){
							if($position_rules[2] == 1){
								$output_result = 1;
								break;
								
							}else{
								for($a2=0;$a2<count($threshold_rules);$a2++){
									if($a2 != $a){
										$position_rules2 = explode(",",$threshold_rules[$a2]);
										
										if($position_rules2[0] and $position_rules2[1] < $position_rules[1]){
											break;
											
										}else if($position_rules2[0] and $position_rules2[1] >= $position_rules[1] and $a2 == (count($threshold_rules)-1)){
											$output_result = 1;
											break;
										}
									}									
								}								
							}							
						}else if($amount > $position_rules[1]){
							if(!$position_rules[3]){
								break;
								
							}else{
								$output_result = 1;
								break;
								
							}
						}						
					}
				}
				
			}else if($position_rules[5] == 2){
				
				if(($this_user_results['hub_id'] == $position_rules[6] and $this_user_results['site_id'] == 0)|| $this_user_results['hub_id'] == 0 and ($position_rules[7] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[7] == $this_user_results['unit_id'])){
					if(!$position_rules[0]){
						$output_result = 1;
						break;
						
					}else{
						if($amount == $position_rules[1]){
							$output_result = 1;
							
						}else if($amount < $position_rules[1]){
							if($position_rules[2] == 1){
								$output_result = 1;
								break;
								
							}else{
								for($a2=0;$a2<count($threshold_rules);$a2++){
									if($a2 != $a){
										$position_rules2 = explode(",",$threshold_rules[$a2]);
										
										if($position_rules2[0] and $position_rules2[1] < $position_rules[1]){
											
											break;
											
										}else if($position_rules2[0] and $position_rules2[1] >= $position_rules[1] and $a2 == (count($threshold_rules)-1)){
											
											$output_result = 1;
											break;
										}
									}									
								}								
							}							
						}else if($amount > $position_rules[1]){
							if(!$position_rules[3]){
								break;
								
							}else{
								$output_result = 1;
								break;
								
							}
						}						
					}					
				}
				
			}else if($position_rules[5] == 3){
				if($this_user_results['site_id'] == $position_rules[6]|| $this_user_results['site_id'] == 0 and ($position_rules[7] == 0 || $this_user_results['unit_id'] == 0 || $position_rules[7] == $this_user_results['unit_id'])){
					
					if(!$position_rules[0]){
						$output_result = 1;
						break;
						
					}else{
						if($amount == $position_rules[1]){
							$output_result = 1;
							
						}else if($amount < $position_rules[1]){
							if($position_rules[2] == 1){
								$output_result = 1;
								break;
								
							}else{
								for($a2=0;$a2<count($threshold_rules);$a2++){
									if($a2 != $a){
										$position_rules2 = explode(",",$threshold_rules[$a2]);
										
										if($position_rules2[0] and $position_rules2[1] < $position_rules[1]){
											break;
											
										}else if($position_rules2[0] and $position_rules2[1] >= $position_rules[1] and $a2 == (count($threshold_rules)-1)){
											$output_result = 1;
											break;
										}
									}									
								}								
							}

						}else if($amount > $position_rules[1]){
							if(!$position_rules[3]){
								break;
								
							}else{
								$output_result = 1;
								break;
								
							}
						}								
					}				
				}
				
			}
			
		}else if($position_rules[4] == 1){
			
			if($position_rules[9] == $user_id){
				
				if(!$position_rules[0]){
					$output_result = 1;
					break;
					
				}else{
					
					if($amount == $position_rules[1]){
						$output_result = 1;
						
					}else if($amount < $position_rules[1]){
						
						if($position_rules[2] == 1){
							$output_result = 1;
							break;

						}else{
							
							$confirm_skip = 0;
							for($a2=0;$a2<count($threshold_rules);$a2++){

								if($a2 != $a){
									$position_rules2 = explode(",",$threshold_rules[$a2]);
									
									if(!$position_rules2[0] or ($position_rules2[0] and $position_rules2[1] < $position_rules[1])){
										
										if($amount <= $position_rules2[1] or ($amount > $position_rules2[1] and $position_rules2[3])){
											$confirm_skip = 1;
											break;									
										}
									}
								}
							}

							if(!$confirm_skip){
								
								$output_result = 1;
								break;
							}
						}

					}else if($amount > $position_rules[1]){
						
						if(!$position_rules[3]){
							break;

						}else{
							$output_result = 1;
							break;

						}
					}					
				}
			}
			
		}		
	}
	
	return $output_result;
	$output_result = 0;
}

function check_approval_users($claim_type_date,$position,$company_id){
	$this_type = mysqli_query($GLOBALS['claims_connect'],"select * from request_types where _date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($GLOBALS['claims_connect']));
	$this_type_results = mysqli_fetch_array($this_type,MYSQLI_ASSOC);
	
	$approval_rules = explode("]",$this_type_results['rule_string']);
	
	$this_approver_rules = explode(",",$approval_rules[$position]);
	
	if($this_approver_rules[2] == 0){
		$unit_search = '';
		
	}else{
		$unit_search = ' and unit_id = '.$this_approver_rules[6].' or unit_id = 0';
		
	}
	
	if(!$this_approver_rules[3]){
		if($this_approver_rules[4] == 3){
			$approver_title = 'Site-level approvers';
			if($this_approver_rules[5] == 0){
				$location_search = '';
				
			}else{
				$this_site = $this_approver_rules[5];
				$this_site = mysqli_query($GLOBALS['connect'],"select * from sites where id = $this_site_id")or die(mysqli_error($GLOBALS['connect']));
				$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
				$this_site_hub = $this_site_results['hub_id'];
				$this_site_region = $this_site_results['region_id'];
				
				$location_search = ' and site_id = '.$this_approver_rules[5].' or (site_id = 0 and region_id = $this_site_region and (hub_id = $this_site_hub or hub_id = 0))';				
			}
			
		}else if($this_approver_rules[4] == 2){
			$approver_title = 'Hub-level approvers';
			if($this_approver_rules[5] == 0){
				$location_search = ' and site_id = 0';
				
			}else{
				$this_hub_id = $this_approver_rules[5];
				$this_hub = mysqli_query($GLOBALS['connect'],"select * from hubs where id = $this_hub_id")or die(mysqli_error($GLOBALS['connect']));
				$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
				$hub_region = $this_hub_results['region_id'];
				$location_search = ' and (hub_id = '.$this_approver_rules[5].' and ((region_id = 0 or region_id = $hub_region) and site_id = 0)) or ((region_id = 0 or region_id = $hub_region) and hub_id = 0)';
			}
			
		}else if($this_approver_rules[4] == 1){
			$approver_title = 'Province-level approvers';
			
			if($this_approver_rules[5] == 0){
				$location_search = ' and hub_id = 0 and site_id = 0';
			}else{
				$this_province_id = $this_approver_rules[5];
				$this_province = mysqli_query($GLOBALS['connect'],"select * from provinces where id = $this_province_id")or die(mysqli_error($GLOBALS['connect']));
				$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
				$this_province_region = $this_province_results['region_results'];
				
				$location_search = ' and province_id = '.$this_approver_rules[5].' and hub_id = 0 and site_id = 0 or ((region_id = $this_province_region or region_id = 0) and province_id = 0)';
			}
			
		}else if($this_approver_rules[4] == 0){
			$approver_title = 'Region-level approvers';
			
			if($this_approver_rules[5] == 0){
				$location_search = ' and province_id = 0 and hub_id = 0 and site_id = 0';
				
			}else{
				$location_search = ' and ((region_id = '.$this_approver_rules[5].' and province_id = 0 and hub_id = 0 and site_id = 0) or region_id = 0)';
			}
			
		}
		
		if($this_approver_rules[6] != 0){
			$location_search .= ' and (unit_id = '.$this_approver_rules[6].' or unit_id = 0)';
		}
		
	}else if($this_approver_rules[3] == 1){
		
		$group_id = $this_approver_rules[7];
		$this_group = mysqli_query($GLOBALS['claims_connect'],"select * from approval_thresholds where id = $group_id")or die(mysqli_error($GLOBALS['claims_connect']));
		$this_group_results = mysqli_fetch_array($this_group,MYSQLI_ASSOC);
		$approver_title = $this_group_results['title'].' (Group)';
		
		$rule_string = explode(']',$this_group_results['rule_string']);
		
		$location_search = '';
		for($r=0;$r<count($rule_string);$r++){
			$this_rule_string = explode(',',$rule_string[$r]);
			

			
			if($this_rule_string[4] == 0){
							
				if($this_rule_string[6] == 3){
					
					if($this_rule_string[6] == 0){
						$location_search .= '';
						
					}else{
						$this_site = $this_rule_string[6];
						$this_site = mysqli_query($GLOBALS['connect'],"select * from sites where id = $this_site_id")or die(mysqli_error($GLOBALS['connect']));
						$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
						$this_site_hub = $this_site_results['hub_id'];
						$this_site_region = $this_site_results['region_id'];
						
						$location_search .= ' and site_id = '.$this_rule_string[6].' or (site_id = 0 and region_id = $this_site_region and (hub_id = $this_site_hub or hub_id = 0))';				
					}
					
				}else if($this_rule_string[5] == 2){
					
					if($this_rule_string[6] == 0){
						$location_search .= ' and site_id = 0';
						
					}else{
						$this_hub_id = $this_rule_string[6];
						$this_hub = mysqli_query($GLOBALS['connect'],"select * from hubs where id = $this_hub_id")or die(mysqli_error($GLOBALS['connect']));
						$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
						$hub_region = $this_hub_results['region_id'];
						$location_search .= ' and (hub_id = '.$this_rule_string[6].' and ((region_id = 0 or region_id = $hub_region) and site_id = 0)) or ((region_id = 0 or region_id = $hub_region) and hub_id = 0)';
					}
					
				}else if($this_rule_string[5] == 1){
					
					if($this_rule_string[6] == 0){
						$location_search .= ' and hub_id = 0 and site_id = 0';
						
					}else{
						$this_province_id = $this_rule_string[6];
						$this_province = mysqli_query($GLOBALS['connect'],"select * from provinces where id = $this_province_id")or die(mysqli_error($GLOBALS['connect']));
						$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
						$this_province_region = $this_province_results['region_results'];
						
						$location_search .= ' and province_id = '.$this_rule_string[6].' and hub_id = 0 and site_id = 0 or ((region_id = $this_province_region or region_id = 0) and province_id = 0)';
					}
					
				}else if($this_rule_string[5] == 0){
					
					if($this_rule_string[6] == 0){
						$location_search .= ' and province_id = 0 and hub_id = 0 and site_id = 0';
						
					}else{
						$location_search .= ' and ((region_id = '.$this_rule_string[6].' and province_id = 0 and hub_id = 0 and site_id = 0) or region_id = 0)';
					}					
				}
				
				if($this_rule_string[7] != 0){
					$location_search .= ' and (unit_id = '.$this_rule_string[7].' or unit_id = 0)';
					
				}
				
			}else if($this_rule_string[4] == 1){
				//print($location_search.'<br>');
				
				if($location_search == ''){
					$location_search .= ' and (id = '.$this_rule_string[9].')';
					
				}else{
					$location_search .= ' or (id = '.$this_rule_string[9].')';
					
				}

			}
		}
		
	}else if($this_approver_rules[3] == 2){
		$location_search .= ' and (id = '.$this_approver_rules[8].')';
		
	}
	
	
	$this_users = mysqli_query($GLOBALS['connect'],"select * from users where company_id = $company_id $location_search")or die(mysqli_error($GLOBALS['connect']));
	
	$output_result[0] = '';
	
	for($u=0;$u<mysqli_num_rows($this_users);$u++){
		$this_users_results = mysqli_fetch_array($this_users,MYSQLI_ASSOC);
		
		$this_result[0] = $this_users_results['_date'];
		$this_result[1] = $this_users_results['email'];
		$this_result[2] = $this_users_results['_name'];
		$this_result[3] = $this_users_results['phone'];
		$this_result[4] = $approver_title;
		
		
		if($this_users_results['email_send_rule'] == 0){
			$this_result[5] = 0;
			
		}else if($this_users_results['email_send_rule'] == 1){
			$this_result[5] = 1;
			
		}else if($this_users_results['email_send_rule'] == 3){
			if($this_approver_rules[0] == 'u'){
				$this_result[5] = 1;
				
			}else{
				$this_result[5] = 0;
			}
			
		}else if($this_users_results['email_send_rule'] == 2){
			if($this_approver_rules[0] == 's'){
				if($this_users_results['site_id'] == 0){
					$this_result[5] = 0;
					
				}else{
					$this_result[5] = 1;
				}
				
			}else if($this_approver_rules[0] == 'h'){
				if($this_users_results['hub_id'] == 0){
					$this_result[5] = 0;
					
				}else{
					$this_result[5] = 1;
				}
				
			}else if($this_approver_rules[0] == 'p'){
				if($this_users_results['province_id'] == 0){
					$this_result[5] = 0;
					
				}else{
					$this_result[5] = 1;
				}
			}else if($this_approver_rules[0] == 'r'){
				if($this_users_results['region_id'] == 0){
					$this_result[5] = 0;
					
				}else{
					$this_result[5] = 1;
				}
			}
		}
		
		$this_result[6] = $this_approver_rules[0];
		$this_result[7] = $this_users_results['email_send_rule'];
		
		$this_result[8] = 0;
		
		$output_result[$u] = $this_result;
	}

	return $output_result;
}

function check_agent_activity_days($agent_id,$unit_id,$operation_id,$start_date,$end_date,$agent_data,$company_id){	
	if($operation_id == 0){
		$operation_search = '';
		
	}else{
		$operation_search = ' and activity_id = '.$operation_id;
		
	}
	
	if($unit_id == 0){
		$unit_search = '';
		
	}else{
		$unit_search = ' and unit_id = '.$unit_id;
	}
	
	$total_days = ($end_date - $start_date) / 86400;
	
	$j_start = $start_date;
	$j_end = $j_start+86400;
	$day_output = 0;
	
	$agent_index = array_keys($agent_data['agent_id'],$agent_id);
		
	
	//$unit_operations = mysqli_query($GLOBALS['connect'],"select * from _data where agent_id = $agent_id $unit_search and _date >= '$start_date' and _date <= '$end_date' and company_id = $company_id $operation_search order by _date")or die(mysqli_error($GLOBALS['connect']));
	
	$prev_day = 0;
	if(isset($agent_index[0])){
		for($u=0;$u<count($agent_index);$u++){
			if((($unit_id == 0 or ($agent_data['unit_id'][$agent_index[$u]] == $unit_id)) and ($operation_id == 0 || ($agent_data['activity_id'][$agent_index[$u]] == $operation_id))) and $agent_data['_date'][$agent_index[$u]] >= $start_date and $agent_data['_date'][$agent_index[$u]] <= $end_date){
				if($prev_day != date('j',$agent_data['_date'][$agent_index[$u]])){
					$day_output++;
					
				}
				$prev_day = date('j',$agent_data['_date'][$agent_index[$u]]);
			}
		}
	}
	
	return $day_output;
}

function search_item_in_list($item,$list,$ignore){
	if($ignore === ''){
		$found = 1;
		
	}else if($ignore == $item){
		$found = 1;
		
	}else{
		$found = 0;
		$list_to_array = explode(',',$list);
		
		for($l=0;$l<count($list_to_array);$l++){
			if($list_to_array[$l] == $item){
				$found = 1;
			}
		}
	}
	return $found;
}

function check_beneficiary_level($beneficiary_date,$company_id){
	$claim_approvals = mysqli_query($GLOBALS['claims_connect'],"select * from claim_approvals where beneficiary_date = '$beneficiary_date' and company_id = $company_id and status = 1 order by level desc")or die(mysqli_error($GLOBALS['claims_connect']));
	
	$claim_approval_results = mysqli_fetch_array($claim_approvals,MYSQLI_ASSOC);
	
	return $claim_approval_results['level'];
}

function export_to_excel($table_columns,$columns_types,$info_array,$show_id){	
	$query_string = '';
	$column_string = '';
	$drop_string = '';
	for($c=0;$c<count($table_columns);$c++){
		if($columns_types[$c] == 0){
			$this_type = 'INT(10) NOT NULL';
			
		}else if($columns_types[$c] == 1){
			$this_type = 'VARCHAR(200) NOT NULL';
			
		}else if($columns_types[$c] == 2){
			$this_type = 'TEXT NOT NULL';
			
		}
		
		if($query_string == ''){
			$query_string = " add `".$table_columns[$c]."` ".$this_type;
			
		}else{
			$query_string .= ", add `".$table_columns[$c]."` ".$this_type;
			
		}
		
		if($column_string == ''){
			$column_string = ' ('.$table_columns[$c];
			
		}else{
			$column_string .= ', '.$table_columns[$c];
		}
		
		if($drop_string == ''){
			$drop_string = " DROP `".$table_columns[$c]."`";
			
		}else{
			$drop_string .= ", DROP `".$table_columns[$c]."`";
			
		}
	}
	
	$column_string .= ')';
	
	
	
	mysqli_query($GLOBALS['connect'],"ALTER TABLE `excel_output` $query_string")or die(mysqli_error($GLOBALS['connect']));

	for($i=0;$i<count($info_array);$i++){
		
		$value_string = '';
		for($i2=0;$i2<count($info_array[$i]);$i2++){
			if($columns_types[$i2] != 0){
				$info_array[$i][$i2] = "'".$info_array[$i][$i2]."'";
			}
			
			if($value_string == ''){
				$value_string = ' VALUES ('.$info_array[$i][$i2];
				
			}else{
				$value_string .= ', '.$info_array[$i][$i2];
			}
		}
		$value_string .= ')';
		//print($column_string.$value_string.'<br>');
		mysqli_query($GLOBALS['connect'],"insert into excel_output $column_string $value_string")or die(mysqli_error($GLOBALS['connect']));
		
		
	}
	
	if(!$show_id){
		mysqli_query($GLOBALS['connect'],"ALTER TABLE `excel_output` DROP `id`")or die(mysqli_error($GLOBALS['connect']));
		
	}
	
	create_csv_output('excel_output');
	
	mysqli_query($GLOBALS['connect'],"TRUNCATE TABLE `excel_output`")or die(mysqli_error($GLOBALS['connect']));
	
	if(!$show_id){
		mysqli_query($GLOBALS['connect'],"ALTER TABLE `excel_output` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);")or die(mysqli_error($GLOBALS['connect']));
	
	}
	
	mysqli_query($GLOBALS['connect'],"ALTER TABLE `excel_output` $drop_string")or die(mysqli_error($GLOBALS['connect']));
}


function create_csv_output($tab){	
	$result = mysqli_query($GLOBALS['connect'],'SELECT * FROM '.$tab)or die(mysqli_error($GLOBALS['connect']));
	
	if (!$result) die(mysqli_error($GLOBALS['connect']));
	$num_fields = mysqli_num_fields($result);
	$headers = array();
	
	for ($i = 0; $i < $num_fields; $i++) {
		
		$headers[] = mysqli_fetch_field_direct($result , $i)->name;
	}
	
	$fp = fopen('php://output', 'W');
	
	if ($fp && $result){
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="output_file.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');
		fputcsv($fp, $headers);
		
		
		while ($row = $result->fetch_array(MYSQLI_NUM)) {	
			fputcsv($fp, array_values($row));
		}
	}
	
	
}

function check_level_claims($level,$company_id){
	
	if($level == -1){
		
		return '';
		
	}else{
		$claims = mysqli_query($GLOBALS['claims_connect'],"select * from payment_claims where company_id = $company_id")or die(mysqli_error($GLOBALS['claims_connect']));
			
		$level_claim_dates = 0;
		for($c=0;$c<mysqli_num_rows($claims);$c++){
			$claims_results = mysqli_fetch_array($claims,MYSQLI_ASSOC);
			
			$this_claim_date = $claims_results['_date'];
			$claim_last_level = mysqli_query($GLOBALS['claims_connect'],"select * from claim_approvals where claim_date = '$this_claim_date' order by level desc")or die(mysqli_error($GLOBALS['claims_connect']));
			
			if(!mysqli_num_rows($claim_last_level) and $level == 0){
				if($level_claim_dates == ''){
					$level_claim_dates = $claims_results['_date'];
					
				}else{
					$level_claim_dates .= ','.$claims_results['_date'];
				}
				
			}else{
				$claim_last_level_results = mysqli_fetch_array($claim_last_level,MYSQLI_ASSOC);
				if($claim_last_level_results['level'] == $level){
					if($level_claim_dates == ''){
						$level_claim_dates = $claims_results['_date'];
						
					}else{
						$level_claim_dates .= ','.$claims_results['_date'];
					}
				}
			}
		}
		
		return $level_claim_dates;
	}
}

function queue_email_sender($company_id){
	$email_queue = mysqli_query($GLOBALS['connect'],"select * from mail_queue where company_id = $company_id")or die(mysqli_error($GLOBALS['connect']));
	
	for($e=0;$e<mysqli_num_rows($email_queue);$e++){
		$email_queue_results = mysqli_fetch_array($email_queue,MYSQLI_ASSOC);
		$email_queue_id = $email_queue_results['id'];
		
		$email_sent = emailUser($email_queue_results['receipient'],'pipatzambia@gmail.com','PIPAT Claims Tracker',$email_queue_results['subject'],$email_queue_results['message'],'pipatzambia@gmail.com','');
		
		
		if($email_sent[0]){
			$delete_item = mysqli_query($GLOBALS['connect'],"delete from mail_queue where id = $email_queue_id")or die(mysqli_error($GLOBALS['connect']));
		}
	}
}

function new_excel_export($column_names,$rows,$formating){
	
	include '../scripts/classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	
	$objPHPExcel->getProperties()->setCreator("Francis Kasonde")
							 ->setLastModifiedBy("PIPAT System")
							 ->setTitle("PIPAT Data Export")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Data export file.")
							 ->setKeywords("PIPAT Excel")
							 ->setCategory("PIPAT Export File");
							 
	$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ','EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ','FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ','GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ','HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ');
	$alphabets = ceil(count($column_names)/52);
	
	
	$objPHPExcel->setActiveSheetIndex(0);

	for($c=0;$c<count($alphabet);$c++){			
		if(isset($column_names[$c])){
			$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$c].'1', $column_names[$c]);
			
			 $objPHPExcel->getActiveSheet()->getStyle($alphabet[$c].'1')->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					 'rgb' => 'e1f5fe'
				)
			));
			
			if($formating[$c] == 1){
				 $objPHPExcel->getActiveSheet()->getStyle($alphabet[$c].'1')->getFill()->applyFromArray(array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						 'rgb' => 'cfcfcf'
					)
				));
				
				 $objPHPExcel->getActiveSheet()->getStyle($alphabet[$c].'1')->getFont()->setBold(true);
			}

			
			
			for($r=0;$r<count($rows);$r++){
				$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$c].($r+2), $rows[$r][$c]);
				
				if($formating[$c] == 1){
					 $objPHPExcel->getActiveSheet()->getStyle($alphabet[$c].($r+2))->getFill()->applyFromArray(array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							 'rgb' => 'f2f2f2'
						)
					));
					
					 $objPHPExcel->getActiveSheet()->getStyle($alphabet[$c].($r+2))->getFont()->setBold(true);
				}				
			}
		}
	}		
					 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$today = time();
	$objWriter->save('./files/'.$today.'.xlsx');
	return 'files/'.$today.'.xlsx';
}


function get_item_from_db_results($db_result,$search_column,$search_value,$output_format,$not_found_response){
	$item_index = array_keys($$db_result[$search_column],$search_value);
	
	
	if(!isset($item_index[0])){
		if($output_format){			
			$return_value[0] = $not_found_response;
			
		}else{
			$return_value[0] = $not_found_response;
			
		}		
	}else{
		
		
	}
}

function calculate_execution_date($schedule_id){
	$this_schedule = mysqli_query($GLOBALS['claims_connect'],"select * from request_type_scheduler where id = $schedule_id")or die(mysqli_error($GLOBALS['claims_connect']));
	$this_schedule_results = mysqli_fetch_array($this_schedule,MYSQLI_ASSOC);
	
	$time_passed = 0;
	$passed_execution_date = 0;
	
	if($this_schedule_results['trigger_type_id'] == 1){
		$week_day_array = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
		
		if($this_schedule_results['specific_day_trigger'] == '0'){
			$exec_month = date('m',time())+1;
			
			$exec_year = date('Y',time());
			if($exec_month > 12){
				$exec_month = $exec_month-12;
				$exec_year = date('Y',time())+1;
			}
			
			$exec_time_stamp = mktime(0,0,0,$exec_month,1,$exec_year);

			$time_passed = 1;
			$passed_execution_date = $exec_time_stamp;
			
		}else{
			$exec_month = date('m',time());
			$exec_year = date('Y',time());
			
			$exec_time_stamp = mktime(0,0,0,$exec_month,1,$exec_year);
			
			$exec_spec_day = $this_schedule_results['specific_day_trigger'];
			$this_spec_day = date('D',$exec_time_stamp);
			
			$current_day = 1;
			for($d=0;$d<7;$d++){
				if(date('D',$exec_time_stamp) != $exec_spec_day){
					$current_day++;
					$exec_time_stamp = mktime(0,0,0,$exec_month,($current_day),$exec_year);
					
				}else{
					break;					
				}
			}
			
			$exec_date = date('jS M, Y',$exec_time_stamp);
			
			if($exec_time_stamp < time()){
				$time_passed = 1;
				$passed_execution_date = $exec_time_stamp;
				
				$exec_month = date('m',time())+1;
				$exec_year = date('Y',time());
				
				if($exec_month > 12){
					$exec_month = $exec_month-12;
					$exec_year = date('Y',time())+1;
				}
				
				$exec_time_stamp = mktime(0,0,0,$exec_month,1,$exec_year);
				
				$exec_spec_day = $this_schedule_results['specific_day_trigger'];
				$this_spec_day = date('D',$exec_time_stamp);
				
				$current_day = 1;
				for($d=0;$d<7;$d++){
					if(date('D',$exec_time_stamp) != $exec_spec_day){
						$current_day++;
						$exec_time_stamp = mktime(0,0,0,$exec_month,($current_day),$exec_year);
						
					}else{
						break;					
					}
				}
				
				$exec_date = date('jS M, Y',$exec_time_stamp);
			}
		}
		
	}else if($this_schedule_results['trigger_type_id'] == 2){
		if($this_schedule_results['specific_day_trigger'] == '0'){
			$exec_month = date('m',time());
			$exec_year = date('Y',time());
			$exec_day = date('t',time());
			
			$exec_time_stamp = mktime(0,0,0,$exec_month,$exec_day,$exec_year);
			
			if($exec_time_stamp<time()){
				$time_passed = 1;
				$passed_execution_date = $exec_time_stamp;
				
				$exec_month = date('m',time())+1;
				$exec_year = date('Y',time());
				
				if($exec_month > 12){
					$exec_month = $exec_month-12;
					$exec_year = date('Y',time())+1;
				}
				
				$temp_time_stamp = mktime(0,0,0,$exec_month,1,$exec_year);				
				$exec_day = date('t',$temp_time_stamp);
				
				$exec_time_stamp = mktime(0,0,0,$exec_month,$exec_day,$exec_year);
			}
			
			$exec_date = date('jS M, Y',$exec_time_stamp);
			
		}else{
			$exec_month = date('m',time());
			$exec_year = date('Y',time());
			$exec_day = date('t',time());
			
			$exec_time_stamp = mktime(0,0,0,$exec_month,$exec_day,$exec_year);
			
			$exec_spec_day = $this_schedule_results['specific_day_trigger'];
			
			$current_day = $exec_day;
			for($d=0;$d<7;$d++){
				if(date('D',$exec_time_stamp) != $exec_spec_day){
					$current_day--;
					$exec_time_stamp = mktime(0,0,0,$exec_month,($current_day),$exec_year);
					
				}else{
					break;					
				}
			}
			
			$exec_date = date('jS M, Y',$exec_time_stamp);
			
			if($exec_time_stamp < time()){
				$time_passed = 1;
				$passed_execution_date = $exec_time_stamp;
				
				$exec_month = date('m',time())+1;
				$exec_year = date('Y',time());
				
				if($exec_month > 12){
					$exec_month = $exec_month-12;
					$exec_year = date('Y',time())+1;
				}
				
				$temp_time_stamp = mktime(0,0,0,$exec_month,1,$exec_year);				
				$exec_day = date('t',$temp_time_stamp);
				
				
				$exec_time_stamp = mktime(0,0,0,$exec_month,$exec_day,$exec_year);
				$exec_spec_day = $this_schedule_results['specific_day_trigger'];
				
				$current_day = $exec_day;
				for($d=0;$d<7;$d++){
					if(date('D',$exec_time_stamp) != $exec_spec_day){
						$current_day--;
						$exec_time_stamp = mktime(0,0,0,$exec_month,($current_day),$exec_year);
						
					}else{
						break;					
					}
				}
				
				$exec_date = date('jS M, Y',$exec_time_stamp);
			}
		}
	}else if($this_schedule_results['trigger_type_id'] == 3){
		$exec_month = date('m',time());
		$exec_year = date('Y',time());
		$exec_day = $this_schedule_results['trigger_month_day'];
		
		$exec_time_stamp = mktime(0,0,0,$exec_month,$exec_day,$exec_year);
		
		if($exec_time_stamp<time()){
			$time_passed = 1;
			$passed_execution_date = $exec_time_stamp;
			
			$exec_month = date('m',time())+1;
			
			if($exec_month > 12){
				$exec_month = $exec_month-12;
				$exec_year = date('Y',time())+1;
			}
			
			
			$exec_time_stamp = mktime(0,0,0,$exec_month,$exec_day,$exec_year);
		}
		
		$exec_date = date('jS M, Y',$exec_time_stamp);
	}
	$return_array = array($time_passed,$passed_execution_date,$exec_time_stamp);
	return $return_array;
}

function fetch_database_partitions($partition_type,$period_from_date,$period_to_date){
	$default_partition_names = $GLOBALS['default_partition_names'];
	
	$partitions_array = new_fetch_db_table('connect','table_partitions',$GLOBALS['company_id'],'period_from',"((period_from >= '".$period_from_date."' and period_to <= '".$period_to_date."') || (period_from <= '".$period_from_date."'  and period_to >= '".$period_to_date."') || (period_from >= '".$period_from_date."' and period_from <= '".$period_to_date."') || (period_to <= '".$period_to_date."' and period_to >= '".$period_from_date."'))  and _type = ".$partition_type);
	
	$check_from_partiition_array = new_fetch_db_table('connect','table_partitions',$GLOBALS['company_id'],'id',"period_from <= '".$period_from_date."' and _type = ".$partition_type);
	
	$data_partition_string = ''; 
	$partitioned_string = '';
	if(!count($check_from_partiition_array[1]['id'])){
		$data_partition_string = implode(',',$default_partition_names[$partition_type][1]);
			
	}else{
		$check_to_partiition_array = new_fetch_db_table('connect','table_partitions',$GLOBALS['company_id'],'id',"period_to >= '".$period_to_date."'");
		
		if(!count($check_from_partiition_array[1]['id'])){
			$data_partition_string = implode(',',$default_partition_names[$partition_type][1]);
		}
	}
	
	if(count($partitions_array[1]['id'])){
		$partitioned_string = implode(',',$partitions_array[1]['partition_code']);
	}
	
	if($data_partition_string == ''){
		$data_partition_string = $partitioned_string;
		
	}else if($partitioned_string != ''){
		$data_partition_string .= ','.$partitioned_string;
	}

	$data_partition_array = explode(',',$data_partition_string);	
	return($data_partition_array);
}
?>