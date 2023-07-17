<?php

function approve_level($company_id,$memo_date,$action_type,$level,$user_date,$status,$attachments,$comment,$_date){
	$add_approval = mysqli_query($GLOBALS['connect'],"insert into approvals (company_id,memo_date,user_date,level,status,action_type,attachments,comment,_date) VALUES($company_id,'$memo_date','$user_date',$level,$status,$action_type,'$attachments','$comment','$_date')")or die(mysqli_error($connect));
	
	$prev_level = $level - 1;
	
	$check_last_approval = mysqli_query($GLOBALS['connect'],"select * from approvals where level = $prev_level and company_id = $company_id order by _date desc")or die(mysqli_error($GLOBALS['connect']));
	
	if(!mysqli_num_rows($check_last_approval)){
		$check_last_approval = mysqli_query($GLOBALS['connect'],"select * from approvals where jump_level = $level and company_id = $company_id order by _date desc")or die(mysqli_error($GLOBALS['connect']));
		
	}
	
	if(mysqli_num_rows($check_last_approval)){
		$check_last_approval_results = mysqli_fetch_array($check_last_approval,MYSQLI_ASSOC);
		
		$time_difference = $_date - $check_last_approval_results['_date'];
		
	}else{
		$time_difference = $_date - $memo_date;
		
	}
	
	$add_level_delay = mysqli_query($GLOBALS['connect'],"insert into level_approval_delays (level, time_difference, approver_date,memo_date,_date,company_id) VALUES($level,'$time_difference','$user_date','$memo_date','$_date',$company_id)")or die(mysqli_error($GLOBALS['connect']));
	
	return $add_approval;
}

function check_approval_users($claim_type_date,$position,$company_id){
	$this_type = mysqli_query($GLOBALS['claims_connect'],"select * from claim_types where _date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($GLOBALS['connect']));
	$this_type_results = mysqli_fetch_array($this_type,MYSQLI_ASSOC);
	
	$approval_rules = explode(",",$this_type_results['stage_approvers']);
	
	$this_approver_rules = explode(":",$approval_rules[$position]);
	
	if($this_approver_rules[2] == 0){
		$unit_search = '';
		
	}else{
		$unit_search = ' and unit_id = '.$this_approver_rules[2].' or unit_id = 0';
		
	}
	
	if($this_approver_rules[0] == 's'){
		$approver_title = 'Site-level approvers';
		if($this_approver_rules[1] == 0){
			$location_search = '';
			
		}else{
			$location_search = ' and site_id = '.$this_approver_rules[1].' or site_id = 0';
			
		}
		
	}else if($this_approver_rules[0] == 'h'){
		$approver_title = 'Hub-level approvers';
		if($this_approver_rules[1] == 0){
			$location_search = ' and site_id = 0';
		}else{
			$location_search = ' and (hub_id = '.$this_approver_rules[1].' and site_id = 0) or hub_id = 0';
		}
		
	}else if($this_approver_rules[0] == 'p'){
		$approver_title = 'Province-level approvers';
		
		if($this_approver_rules[1] == 0){
			$location_search = ' and hub_id = 0 and site_id = 0';
		}else{
			$location_search = ' and province_id = '.$this_approver_rules[1].' and hub_id = 0 and site_id = 0 or province_id = 0';
		}
		
	}else if($this_approver_rules[0] == 'r'){
		$approver_title = 'Region-level approvers';
		
		if($this_approver_rules[1] == 0){
			$location_search = ' and province_id = 0 and hub_id = 0 and site_id = 0';
		}else{
			$location_search = ' and region_id = '.$this_approver_rules[1].' and province_id = 0 and hub_id = 0 and site_id = 0 or region_id = 0';
		}
		
	}else if($this_approver_rules[0] == 'u'){
		$approver_title = 'Specific approver';
		
		if($this_approver_rules[1] == 0){
			$location_search = '';
		}else{
			$location_search = ' and _date = '.$this_approver_rules[1];
		}
	}
	
	$this_users = mysqli_query($GLOBALS['connect'],"select * from users where company_id = $company_id $location_search $unit_search")or die(mysqli_error($GLOBALS['connect']));
	
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



function check_approvers($company_id,$user_id,$code,$target_value){
	$code_array = explode(":",$code);
	
	if($code_array[0] == 's' || $code_array[0] == 'h' || $code_array[0] == 'p' || $code_array[0] == 'r'){
		$code_result = create_standard_approval_code($code);
		
	}else{
		$approval_code = explode('-',$code_array[0]);
		
		if($approval_code[0] == 'u'){
			$code_result = create_standard_approval_code($code);

		}else{
			$approval_group_date = $approval_code[1];
			
			$approval_group = mysqli_query($GLOBALS['connect'],"select * from approval_thresholds where _date = '$approval_group_date' and company_id = $company_id")or die(mysqli_error($GLOBALS['connect']));
			
			$approval_group_results = mysqli_fetch_array($approval_group,MYSQLI_ASSOC);
			
			$approvers = explode(',',$approval_group_results['approvers']);
			$limitations = explode(',',$approval_group_results['limitation_amounts']);
			
			$lower_approver = 0;
			$tmp_code_out = '';
			$tmp_unit_out = '';
			for($a=0;$a<count($approvers);$a++){
				$approver_code = explode("~}",$approvers[$a]);
				
				if(($approval_group_results['approval_type'] == 0 and $limitations[$a] == 0 or ((($target_value <= $limitations[$a] and $approver_code[1] == 1) or ($target_value <= $limitations[$a] and ($approver_code[1] == 0 and $lower_approver == 0))) or ($target_value >= $limitations[$a] and ($approver_code[2] == 1)))) or ($approval_group_results['approval_type'] == 1 and ($limitations[$a] == 0 or $target_value <= $limitations[$a]))){
					$code_result = create_standard_approval_code($approver_code[0]);
					$lower_approver = 1;
					
					if($tmp_code_out == ''){
						$tmp_code_out = $code_result[0];
						
						
					}else{
						$tmp_code_out .= ' or '.str_replace('and','',$code_result[0]);
	
					}
					
					if($tmp_unit_out == ''){
						$tmp_unit_out = $code_result[1];
						
					}else{
						$tmp_unit_out .= str_replace('and','or',$code_result[1]);//' or '.str_replace('and','',$code_result[1]);
						
					}
					
					//print($tmp_unit_out);
				}				
			}
			
			
			
			if($tmp_code_out == ''){
				$code_result[0] = ' and id = 0';
				
			}else{
				$code_result[0] = $tmp_code_out;
			}
			
			$code_result[1] = $tmp_unit_out;			
		}		
	}
	
	
	$code_search = $code_result[0];
	$unit_search = $code_result[1];
	
	
	$users = mysqli_query($GLOBALS['claims_connect'],"select * from users where companyID = $company_id $code_search $unit_search")or die(mysqli_error($GLOBALS['claims_connect']));
	
	//print($code.'-'.$unit_search.',');
	//print(mysqli_num_rows($users).$code_search);
	$approver_list = '';
	$approver_names = '';
	$approver_phones = '';
	$approver_emails = '';
	$email_send_rules = '';
	$prev_email_send_rules = '';
	for($u=0;$u<mysqli_num_rows($users);$u++){
		$user_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
		
		if($approver_list == ''){
			$approver_list = $user_results['id'];
			$approver_names = $user_results['_name'];
			$approver_phones = $user_results['phone'];
			$approver_emails = $user_results['email'];
			$email_send_rules = $user_results['email_send_rule'];
			$prev_email_send_rules = $user_results['notify_on_previous'];
			
		}else{
			$approver_list .= ','.$user_results['id'];
			$approver_names .= ','.$user_results['_name'];
			$approver_phones .= ','.$user_results['phone'];
			$approver_emails .= ','.$user_results['email'];
			$email_send_rules .= ','.$user_results['email_send_rule'];
			$prev_email_send_rules .= ','.$user_results['notify_on_previous'];
			
		}
	}
	//print($approver_list);
	$user_on_list = check_item_in_list($user_id,$approver_list,0,",");
	
	$return_array[0] = $user_on_list;
	$return_array[1] = $approver_list;
	$return_array[2] = $approver_names;
	$return_array[3] = $approver_phones;
	$return_array[4] = $approver_emails;
	$return_array[5] = $email_send_rules;
	$return_array[6] = $prev_email_send_rules;
	
	
	return $return_array;
}

function create_standard_approval_code($code){
	$code = explode(":",$code);
	
	if($code[0] == 's'){
		if($code[1] == 0){
			$code_search = ' and site_id >= 0';
		
		}else{
			$code_search = ' and site_id = '.$code[1];
			
		}
		
	}else if($code[0] == 'h'){
		if($code[1] == 0){
			$code_search = ' and hub_id >= 0 and site_id = 0';
		
		}else{
			$code_search = ' and hub_id = '.$code[1].' and site_id = 0';
			//print($code[1].',');
		}
		
	}else if($code[0] == 'p'){
		if($code[1] == 0){
			$code_search = ' and province_id >= 0 and hub_id = 0 and site_id = 0';
		
		}else{
			$code_search = ' and province_id = '.$code[1].' and hub_id = 0 and site_id = 0';
			
		}
		
	}else if($code[0] == 'r'){
		if($code[1] == 0){
			$code_search = ' and region_id >= 0 and province_id = 0 and hub_id = 0 and site_id = 0';
		
		}else{
			$code_search = ' and region_id = '.$code[1].' and province_id = 0 and hub_id = 0 and site_id = 0';
			
		}
		
	}else{
		$approval_code = explode('-',$code[0]);
		
		if($approval_code[0] == 'u'){
			$code_search = " and _date = '".$approval_code[1]."'";

		}
	}
	
	if($code[2] == 0){
		$unit_search = '';
		
	}else{
		$unit_search = ' and unit_id = '.$code[2];
		
	}
	
	if(!isset($code_search)){
		//print($code[0]);
	}
	
	$output_array[0] = $code_search;
	$output_array[1] = $unit_search;
	
	return $output_array;
}
/*function check_approvers($company_id,$user_id,$code){
	$code = explode(":",$code);
	
	if($code[0] == 's'){
		if($code[1] == 0){
			$code_search = ' and site_id >= 0';
		
		}else{
			$code_search = ' and site_id = '.$code[1];
			
		}
		
	}else if($code[0] == 'h'){
		if($code[1] == 0){
			$code_search = ' and hub_id >= 0 and site_id = 0';
		
		}else{
			$code_search = ' and hub_id = '.$code[1].' and site_id = 0';
			
		}
		
	}else if($code[0] == 'p'){
		if($code[1] == 0){
			$code_search = ' and province_id >= 0 and hub_id = 0 and site_id = 0';
		
		}else{
			$code_search = ' and province_id = '.$code[1].'and hub_id = 0 and site_id = 0';
			
		}
		
	}else if($code[0] == 'r'){
		if($code[1] == 0){
			$code_search = ' and region_id >= 0 and province_id = 0 and hub_id = 0 and site_id = 0';
		
		}else{
			$code_search = ' and region_id = '.$code[1].' and province_id = 0 and hub_id = 0 and site_id = 0';
			
		}
		
	}else{
		$code_search = ' and _date = '.$code[0];		
	}
	
	if($code[2] == 0){
		$unit_search = '';
		
	}else{
		$unit_search = ' and unit_id = '.$code[2];
		
	}
	
	$users = mysqli_query($GLOBALS['claims_connect'],"select * from users where companyID = $company_id $code_search $unit_search")or die(mysqli_error($GLOBALS['claims_connect']));
	
	$approver_list = '';
	$approver_names = '';
	$approver_phones = '';
	$approver_emails = '';
	for($u=0;$u<mysqli_num_rows($users);$u++){
		$user_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
		
		if($approver_list == ''){
			$approver_list = $user_results['id'];
			$approver_names = $user_results['_name'];
			$approver_phones = $user_results['phone'];
			$approver_emails = $user_results['email'];
			
		}else{
			$approver_list .= ','.$user_results['id'];
			$approver_names .= ','.$user_results['_name'];
			$approver_phones .= ','.$user_results['phone'];
			$approver_emails .= ','.$user_results['email'];
		}
	}
	//print($approver_list);
	$user_on_list = check_item_in_list($user_id,$approver_list,0,",");
	
	$return_array[0] = $user_on_list;
	$return_array[1] = $approver_list;
	$return_array[2] = $approver_names;
	$return_array[3] = $approver_phones;
	$return_array[4] = $approver_emails;
	
	return $return_array;
}*/
?>