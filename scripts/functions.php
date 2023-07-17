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
function post_pipat_entry($text_message,$phone_number,$posting_date_stamp,$input_type){
	$error_code = 0;
	$minor_error_codes = '';
	$error_message = '';
	$minor_error_messages = '';
	
	if(!$input_type){
		$trackEmail = str_replace("SMS From : ","",$text_message);
		$trackEmail = str_replace("Sent by Auto SMStoMail","",$trackEmail);
		$trackEmail = str_replace("if you like this app.","",$trackEmail);
		$trackEmail = str_replace("Please download pro version: http://play.google.com/store/apps/details?id=com.Rainbow.smstoemailPro","",$trackEmail);			
		$first_part = substr($trackEmail,0,strpos($trackEmail,"SMS contents:"));
		$text_message = trim(str_replace("SMS contents:","",substr($trackEmail,strpos($trackEmail,"SMS contents:"))));
		$phone_number = trim(substr($first_part,0,strpos($first_part,"Date : ")));
		$posting_date_time = trim(str_replace("Date : ","",substr($first_part,strpos($first_part,'Date : '))));	$posting_date = substr($posting_date_time,0,strpos($posting_date_time,", "));
		$posting_time = str_replace(", ","",substr($posting_date_time,strpos($posting_date_time,", ")));	$posting_date_array = explode(' ',$posting_date);
		$posting_time_array = explode(':',$posting_time);
			
			
		if($posting_date_array[1] == 'Jan'){
			$posting_date_month = 1;
			
		}elseif($posting_date_array[1] == 'Feb'){
			$posting_date_month = 2;
				
		}else if($posting_date_array[1] == 'Mar'){									
			$posting_date_month = 3;
			
		}else if($posting_date_array[1] == 'Apr'){
			$posting_date_month = 4;
			
		}else if($posting_date_array[1] == 'May'){
			$posting_date_month = 5;
			
		}else if($posting_date_array[1] == 'Jun'){												
			$posting_date_month = 6;
			
		}else if($posting_date_array[1] == 'Jul'){
			$posting_date_month = 7;
			
		}else if($posting_date_array[1] == 'Aug'){
			$posting_date_month = 8;
		
		}else if($posting_date_array[1] == 'Sep'){
			$posting_date_month = 9;
			
		}else if($posting_date_array[1] == 'Oct'){
			$posting_date_month = 10;
		
		}else if($posting_date_array[1] == 'Nov'){
			$posting_date_month = 11;
		
		}else if($posting_date_array[1] == 'Dec'){
			$posting_date_month = 12;
		
		}
		
		if(trim($posting_date_array[0]) < 10){
			$posting_date_day = '0'.$posting_date_array[0];
		
		}
		
		$posting_date_stamp = mktime(trim($posting_time_array[0]),trim($posting_time_array[1]),00,$posting_date_month,trim($posting_date_array[0]),trim($posting_date_array[2]));
	}
	
	if(strlen($text_message) > 100){
		$message_with_error = $text_message;
		$company_id = 0;
		$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Message too long...','$message_with_error','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
		
		$error_code = 1;
		$error_message = 'Message too long';

	}else{
		$phone_numbers = mysqli_query($GLOBALS['connect'],"select * from phone_numbers where phone_number = '$phone_number'")or die(mysqli_error($GLOBALS['connect']));

		if(mysqli_num_rows($phone_numbers)){
			//Booking and service message
			
			
			
			$add_agent_entry = post_pipat_agent_entry($phone_number,$text_message,$posting_date_stamp);
			
			$error_code = $add_agent_entry[0];
			$error_message = $add_agent_entry[1];
			
			$minor_error_codes .= ','.$add_agent_entry[2];			
			$minor_error_messages .= ','.$add_agent_entry[3];
	
		}else{
			$check_driver = mysqli_query($GLOBALS['connect_logistics'],"select * from drivers where driver_contact = '$phone_number'")or die(mysqli_error($GLOBALS['connect_logistics']));
			
			if(mysqli_num_rows($check_driver)){
				$add_driver_entry = post_pipat_logistic_entry($phone_number,$text_message,$posting_date_stamp);
				
				$error_code = $add_driver_entry[0];
				$error_message = $add_driver_entry[1];
				
				$minor_error_codes .= ','.$add_driver_entry[2];			
				$minor_error_messages .= ','.$add_driver_entry[3];
				
			}else{
				$add_affiliate_entry = post_affiliate_message($phone_number,$text_message,$posting_date_stamp);
				
				$error_code = $add_affiliate_entry[0];
				$error_message = $add_affiliate_entry[1];
				
				$minor_error_codes .= ','.$add_affiliate_entry[2];			
				$minor_error_messages .= ','.$add_affiliate_entry[3];
			}
		}
	}
	
	$output_code[0] = $error_code;
	$output_code[1] = $error_message;
	$output_code[2] = $minor_error_codes;
	$output_code[3] = $minor_error_messages;
	
	return $output_code;
}

function post_pipat_agent_entry($phone_number,$text_message,$posting_date_stamp){		
	$error_code = 0;
	$minor_error_codes = '';
	$error_message = '';
	$minor_error_messages = '';
	
	$phone_numbers = mysqli_query($GLOBALS['connect'],"select * from phone_numbers where phone_number = '$phone_number'")or die(mysqli_error($GLOBALS['connect']));
	$phone_number_resuts = mysqli_fetch_array($phone_numbers,MYSQLI_ASSOC);
	$company_id = $phone_number_resuts['company_id'];
	$agent_date = $phone_number_resuts['agent_date'];
	
	$agent = mysqli_query($GLOBALS['connect'],"select * from agents where _date = '$agent_date' and company_id = $company_id")or die(mysqli_error($GLOBALS['connect']));
	
	$agent_results = mysqli_fetch_array($agent,MYSQLI_ASSOC);
	$agent_id = $agent_results['id'];
	$region_id = $agent_results['region_id'];
	$province_id = $agent_results['province_id'];
	$hub_id = $agent_results['hub_id'];
	$site_id = $agent_results['site_id'];
	$agent_status = $agent_results['status'];
	$text_message = str_replace(" ","",$text_message);
	$site_code = '';
	
	if(!$agent_results['status']){
		$message_with_error = $text_message;
		$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Agent not allowed to report','$message_with_error','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
		
		$error_code = 1;
		$error_message = 'Agent not allowed';

	}else{
		$company_id = $agent_results['company_id'];
		
		if($site_id == 0){
			$text_message_array = explode(",",$text_message);
			
			if(!isset($text_message_array[1])){
				$text_message_array = explode(".",$text_message);
				
			}
			
			$site_code = $text_message_array[0];			
			$site = mysqli_query($GLOBALS['connect'],"select * from sites where gsm_code = '$site_code'")or die(mysql_error($GLOBALS['connect']));					
						
			if(mysqli_num_rows($site)){
				$site_results = mysqli_fetch_array($site,MYSQLI_ASSOC);						
				$region_id = $site_results['region_id'];
				$province_id = $site_results['province_id'];
				$hub_id = $site_results['hub_id'];
				$site_id = $site_results['id'];
				$text_message = str_replace($site_code.',','',$text_message);
				
			}else{
				$message_with_error = $text_message;
				$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Wrong site code','$message_with_error','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
				
				$error_code = 1;
				$error_message = 'Site code incorrect';
				
			}				
		}
	}
	
	if(!$error_code){
		$text_message_array = explode(",",$text_message);
		if(!isset($text_message_array[1])){
			$text_message_array = explode(".",$text_message);
			
		}
		
		for($t=0;$t<count($text_message_array);$t++){
			$activity_gsm_codes = decode_gsm_code($text_message_array[$t]);
			
			if($activity_gsm_codes[0]){
				$unit_code = $activity_gsm_codes[1];
				$activity_code = $activity_gsm_codes[2];
				$intervention_number = $activity_gsm_codes[3];
				
				$this_unit = mysqli_query($GLOBALS['connect'],"select * from units where company_id = $company_id and gsm_code = '$unit_code'")or die(mysqli_error($GLOBALS['connect']));
				
				
				if(!mysqli_num_rows($this_unit)){
					if($site_code != ''){
						$message_with_error = $site_code.','.$text_message_array[$t];
					
					}else{
						$message_with_error = $text_message_array[$t];
					}
					
					$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Unrecognized unit code','$message_with_error','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
					
					$minor_error_codes .= ',2';
					$minor_error_messages .= ',Unrecognized unit code';
					
				}else{					
					$this_activity = mysqli_query($GLOBALS['connect'],"select * from activities where company_id = $company_id and gsm_code = '$activity_code'")or die(mysqli_error($GLOBALS['connect']));
					
					if(!mysqli_num_rows($this_activity)){
						if($site_code != ''){
							$message_with_error = $site_code.','.$text_message_array[$t];
					
						}else{
							$message_with_error = $text_message_array[$t];
						}
					
						$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Unrecognized activity code','$message_with_error','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
						
						$minor_error_codes .= ',3';
						$minor_error_messages .= ',Unrecognized activity code';
						
					}else{
						$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
						$this_activity_results = mysqli_fetch_array($this_activity,MYSQLI_ASSOC);
						
						$unit_id = $this_unit_results['id'];
						$activity_id = $this_activity_results['id'];
						
						$today_month = date('m',time());
						$today_year = date('Y',time());										
						$today_day = date('j',time());
						$today_start_stamp = mktime(00,00,00,$today_month,$today_day,$today_year);
						$today_end_stamp = mktime(23,59,59,$today_month,$today_day,$today_year);
						
						$check_double_entry = mysqli_query($GLOBALS['connect'],"select * from _data where unit_id = $unit_id and activity_id = $activity_id and site_id = $site_id and agent_id = $agent_id and _date >= '$today_start_stamp' and _date <= '$today_end_stamp'")or die(mysqli_error($GLOBALS['connect']));
						
						if(mysqli_num_rows($check_double_entry)){
							if($site_code != ''){
								$message_with_error = $site_code.','.$text_message_array[$t];
						
							}else{
								$message_with_error = $text_message_array[$t];
							}
							
							$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Double entry detected','$message_with_error','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
							
							$minor_error_codes .= '4';
							$minor_error_messages .= ',Double entry detected';
							
						}else{
							$add_service_operation = mysqli_query($GLOBALS['connect'],"insert into _data (unit_id,activity_id,_value,agent_id,site_id,hub_id,province_id,region_id,company_id,_date,img_src) VALUES($unit_id,$activity_id,'$intervention_number',$agent_id,$site_id,$hub_id,$province_id,$region_id,$company_id,'$posting_date_stamp','')")or die(mysqli_error($GLOBALS['connect']));
						}
					}
				}
				
			}else{
				if($site_code != ''){
					$message_with_error = $site_code.','.$text_message_array[$t];
					
				}else{
					$message_with_error = $text_message_array[$t];
				}
				
				$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Wrong code format','$message_with_error','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
				
				$minor_error_codes .= ',1';
				$error_message .= ',Code format incorrect';
				break;
			}			
		}
	}
	
	
	$output_code[0] = $error_code;
	$output_code[1] = $error_message;
	$output_code[2] = $minor_error_codes;
	$output_code[3] = $minor_error_messages;
	
	return $output_code;
}


function decode_gsm_code($inputed_code){
	$output_string = str_split($inputed_code);
	$unit_code = $output_string[0];
	$activity_code = '';
	$intervention_number = '';
	
	for($o=1;$o<count($output_string);$o++){
		if(!is_numeric($output_string[$o])){
			if($activity_code == ''){
				$activity_code = $output_string[$o];
			
			}else{
				$activity_code .= $output_string[$o];
				
			}
		}else{
			if($intervention_number ==''){
				$intervention_number = $output_string[$o];
				
			}else{
				$intervention_number .= $output_string[$o];
				
			}
		}
	}
	
	if($unit_code != '' and $activity_code != '' and $intervention_number != ''){
		$output_array[0] = 1;
		
	}else{
		$output_array[0] = 0;
	}
	
	$output_array[1] = $unit_code;
	$output_array[2] = $activity_code;
	$output_array[3] = $intervention_number;
	
	return $output_array;
}

function post_pipat_logistic_entry($phone_number,$text_message,$posting_date_stamp){
	$check_driver = mysqli_query($GLOBALS['connect_logistics'],"select * from drivers where driver_contact = '$phone_number'")or die(mysqli_error($GLOBALS['connect_logistics']));
	
	$check_driver_results = mysqli_fetch_array($check_driver,MYSQLI_ASSOC);
	$driver_date = $check_driver_results['_date'];
	$company_id = $check_driver_results['company_id'];
	
	$driver_trip = mysqli_query($GLOBALS['connect_logistics'],"select * from trips where driver_date = '$driver_date' and status = 1")or die(mysqli_error($GLOBALS['connect_logistics']));
	
	if(mysqli_num_rows($driver_trip)){
		$driver_trip_results = mysqli_fetch_array($driver_trip,MYSQLI_ASSOC);
		$trip_date = $driver_trip_results['_date'];
		
		$message_string_array = explode(',',$text_message);
		$mileage = $message_string_array[0];
		$fuel_added = $message_string_array[1];
		$amount = $message_string_array[2];
		$remaining_fuel = $message_string_array[3];
		
		$location = '';
		for($l=4;$l<count($message_string_array);$l++){
			if($location == ''){
				$location = $message_string_array[$l];
				
			}else{
				$location .= ','.$message_string_array[$l];
			}
		}
		
		if($mileage != '' and $mileage != '-' and $mileage != 0 and is_numeric($mileage)){
			if($fuel_added == '-' or !is_numeric($fuel_added)){
				$fuel_added = '';
			}
			
			if($amount == '-' or !is_numeric($amount)){
				$amount = '';
				
			}
			
			if($remaining_fuel == '-' or !is_numeric($remaining_fuel)){
				$remaining_fuel = '';
				
			}
			
			$add_waypoint = mysqli_query($GLOBALS['connect_logistics'],"insert into waypoints (company_id,trip_date,waypoint_date,location,mileage,remaining_fuel,fuel,fuel_amount,passengers,details,user_date,_date) VALUES($company_id,'$trip_date','$posting_date_stamp','$location','$mileage','$remaining_fuel','$fuel_added','$amount','','$location','',$today)")or die(mysqli_error($GLOBALS['connect']));
			
		}else{
			$error_message = 'Driver by the name of '.$check_driver_results['_name'].' sent a code for a trip with a wrong mileage standad';
			$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES(0,'$error_message','$text_message','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));							
			//break;
		}
	}else{
		$error_message = 'Driver by the name of '.$check_driver_results['_name'].' sent a code for a trip which is either ended or does not exit' ;
		$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES(0,'$error_message','$text_message','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));							
		//break;
	}
}

function post_affiliate_message($phone_number,$text_message,$posting_date_stamp){
	
	$text_message_array = str_split($text_message,1);						
	//var_dump($text_message_array);
	$agent_code = $text_message_array[0].$text_message_array[1];
	$question_id = $text_message_array[2].$text_message_array[3];
	$age = $text_message_array[4].$text_message_array[5];
	$sex = $text_message_array[6];
	$hub_id = $text_message_array[7].$text_message_array[8];
	$answer = $text_message_array[9].$text_message_array[10];
	
	//print();
	
	if(isset($text_message_array[11])){
		$answer .= $text_message_array[11];
		
	}
	
	if($sex == 'F' || $sex == 'f'){
		$sex = 1;
		
	}else if($sex == 'M' || $sex == 'm'){
		$sex = 0;
		
	}else{
		$sex = 2;
		
	}
	
	$this_agent = mysqli_query($GLOBALS['connect'],"select * from agents where user_code = '$agent_code'")or die(mysqli_error($GLOBALS['connect']));						
	if(!mysqli_num_rows($this_agent)){
		$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES(0,'Unregistered phone number','$text_message','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));							
		//break;
		
	}else{
		$this_agent_results = mysqli_fetch_array($this_agent,MYSQLI_ASSOC);
		$this_agent_id = $this_agent_results['id'];
		$company_id = $this_agent_results['company_id'];
	}
		
	$district = mysqli_query($GLOBALS['connect'],"select * from districts where id = '$hub_id'")or die(mysqli_error($GLOBALS['connect']));						
	if(!mysqli_num_rows($district)){
		$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Message was sent for an unregistered district','$text_message','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
		//$break;
		
	}else{
		$this_district_results = mysqli_fetch_array($district,MYSQLI_ASSOC);				$this_hub_id = $this_district_results['id'];
		$this_province_id = $this_district_results['province_id'];
		$this_province = mysqli_query($GLOBALS['connect'],"select * from provinces where id = $this_province_id")or die(mysqli_error($GLOBALS['connect']));
		
		$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);				$this_region_id = $this_province_results['region_id'];
		
	}
	
	//print($phone_number);
	$question = mysqli_query($GLOBALS['connect'],"select * from affiliate_questions where gsm_code = $question_id")or die(mysqli_error($GLOBALS['connect']));								
	
	if(!mysqli_num_rows($question)){
		$add_erro = mysqli_query($GLOBALS['connect'],"insert into bin (company_id,error_msg, message_sent, _date, phone_number) VALUES($company_id,'Message was sent for an unregistered question','$text_message','$posting_date_stamp','$phone_number')")or die(mysqli_error($GLOBALS['connect']));
		//$break;
		
	}else{
		$this_question = mysqli_fetch_array($question,MYSQLI_ASSOC);
		$this_question_id = $this_question['id'];
	}
	
	$add_affiliate = mysqli_query($GLOBALS['connect'],"insert into affiliates (company_id,agent_id,region_id,province_id,hub_id,site_id,group_id,contact_number,question_id,question_answer,gender,age,msg_text,_date) VALUES($company_id,$this_agent_id,$this_region_id,$this_province_id,$this_hub_id,0,0,'$phone_number',$this_question_id,'$answer','$sex','$age','$text_message','$posting_date_stamp')")or die(mysqli_error($GLOBALS['connect']));
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

function new_excel_export($column_names,$rows,$formating,$file_name=NULL){
    if($file_name == NULL){
		$file_name =  'files/'.time().'.xlsx';
	}
    
	require_once dirname(__FILE__) . '/classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	
	$objPHPExcel->getProperties()->setCreator("Francis Kasonde")
							 ->setLastModifiedBy("PIPAT System")
							 ->setTitle("PIPAT Data Export")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Data export file.")
							 ->setKeywords("PIPAT Excel")
							->setCategory("PIPAT Export File");
	
	$alphabet_0 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$alphabet = array();
	for($al=0;$al<27;$al++){
		for($al1=0;$al1<27;$al1++){
			for($al2=0;$al2<26;$al2++){
				if($al==0 and $al1==0){
					$alphabet[count($alphabet)] = $alphabet_0[$al2];
					
				}else if($al==0){
					$alphabet[count($alphabet)] = $alphabet_0[$al1-1].$alphabet_0[$al2];
					
				}else{
					if($al1 <26){
						$alphabet[count($alphabet)] = $alphabet_0[$al-1].$alphabet_0[$al1].$alphabet_0[$al2];
					}
				}
			}		
		}		
	}
	
	
	$alphabets = ceil(count($column_names)/52);
	
	
	$objPHPExcel->setActiveSheetIndex(0);
		
		for($c=0;$c<count($column_names);$c++){			
			$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$c].'1', $column_names[$c]);
			
			for($r=0;$r<count($rows);$r++){
				if(!isset($rows[$r][$c])){
					$row_value = '';
					
				}else{
					$row_value = $rows[$r][$c];
				}
				
				$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$c].($r+2), $row_value);
				
				/*if($formating[$c] == 1){
					$conditional = new PHPExcel_Style_Conditional();
					$conditional->setConditionType(PHPExcel_Style_Conditional::CONDITION_DUPLICATEVALUES);
					$conditional->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

					$style = $objPHPExcel->getStyle($alpha.$alphabet[$c].($r+2));

					$conditionalStyles = $style->getConditionalStyles();

					array_push($conditionalStyles, $conditional);
					$style->setConditionalStyles($conditionalStyles);
					$objPHPExcel->getActiveSheet()->getStyle($alpha.$alphabet[$c].($r+2))->setConditionalStyles($conditionalStyles);
				}*/				
			}
		}
			
	
							 
	
							 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$today = time();
    $objWriter->save('./'.$file_name);
	return $file_name;
}

function new_excel_export_2($sheet_titles,$column_names,$rows,$formating){
	require_once dirname(__FILE__) . '/classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	
	$objPHPExcel->getProperties()->setCreator("Francis Kasonde")
							 ->setLastModifiedBy("PIPAT System")
							 ->setTitle("PIPAT Data Export")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Data export file.")
							 ->setKeywords("PIPAT Excel")
							->setCategory("PIPAT Export File");
	
	$alphabet_0 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$alphabet = array();
	for($al=0;$al<27;$al++){
		for($al1=0;$al1<27;$al1++){
			for($al2=0;$al2<26;$al2++){
				if($al==0 and $al1==0){
					$alphabet[count($alphabet)] = $alphabet_0[$al2];
					
				}else if($al==0){
					$alphabet[count($alphabet)] = $alphabet_0[$al1-1].$alphabet_0[$al2];
					
				}else{
					if($al1 <26){
						$alphabet[count($alphabet)] = $alphabet_0[$al-1].$alphabet_0[$al1].$alphabet_0[$al2];
					}
				}
			}		
		}		
	}
	
	
	$alphabets = ceil(count($column_names)/52);
	
	//print(count($rows));
	
	for($w=0;$w<count($rows);$w++){
		
		if($w>0){
			$objWorkSheet = $objPHPExcel->createSheet($w);

		}
		
		
		$objPHPExcel->setActiveSheetIndex($w);
		
		//$sheet = $objPHPExcel->getActiveSheet();
		
		if(strlen($sheet_titles[$w]) > 31){
			$sheet_title = substr($sheet_titles[$w],0,28).'...';
			
		}else{
			$sheet_title = $sheet_titles[$w];
		}
		
		$objPHPExcel->getActiveSheet()-> setTitle($sheet_title);
			
		for($c=0;$c<count($column_names);$c++){
					
			$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$c].'1', $column_names[$c]);
			
			
			for($r=0;$r<count($rows[$w]);$r++){
				if(isset($rows[$w][$r][$c])){	
					if(!isset($rows[$w][$r][$c])){
						$row_value = '';
						
					}else{
						$row_value = $rows[$w][$r][$c];
					}
					
					$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$c].($r+2), $row_value);
					
					if(!isset($formating[$c])){
						$formating[$c] = 0;
						
					}
					
					if($formating[$c] == 1){
						$conditional = new PHPExcel_Style_Conditional();
						$conditional->setConditionType(PHPExcel_Style_Conditional::CONDITION_DUPLICATEVALUES);
						$conditional->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

						$style = $objPHPExcel->getStyle($alpha.$alphabet[$c].($r+2));

						$conditionalStyles = $style->getConditionalStyles();

						array_push($conditionalStyles, $conditional);
						$style->setConditionalStyles($conditionalStyles);
						$objPHPExcel->getActiveSheet()->getStyle($alpha.$alphabet[$c].($r+2))->setConditionalStyles($conditionalStyles);
					}				
				}
			}
		}
	}
	
	$objPHPExcel->setActiveSheetIndex(0);
							 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$today = time();
	$objWriter->save('./files/'.$today.'.xlsx');
	return 'files/'.$today.'.xlsx';
}

function fetch_excel_spreadsheet($file_src){
	/** Include path **/
	set_include_path(get_include_path() . PATH_SEPARATOR . 'scripts/classes/');

	/** PHPExcel_IOFactory */
    if(!class_exists('PHPExcel_IOFactory')){
		include 'PHPExcel/IOFactory.php';
	}
	//print('hi');
	$inputFileType = PHPExcel_IOFactory::identify($file_src);;
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objReader->setReadDataOnly(true);
	
	$objReader->setLoadAllSheets();
	$objPHPExcel = $objReader->load($file_src);
	
	$loadedSheetNames = $objPHPExcel->getSheetNames();
	foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
		$objPHPExcel -> setActiveSheetIndex($sheetIndex);
		
		$sheet_names[$sheetIndex] = $loadedSheetName;
		$sheetData[$loadedSheetName] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
	}
	
	$output_array[0] = $sheet_names;
	$output_array[1] = $sheetData;
	
	return($output_array);
}




function rutime($type) {
	if($type == 0){
		$index = 'utime';
		
	}else{
		$index = 'stime';
	}
	
	$ru = getrusage();
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($GLOBALS['processing_start']["ru_$index.tv_sec"]*1000 + intval($GLOBALS['processing_start']["ru_$index.tv_usec"]/1000));
}

function check_execution_time(){
	
	return (time() - $GLOBALS['processing_start_time']);
	
}

function merge_excel_files($file_array,$file_name,$display_option,$file_format){
	$entry_alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$alphabet = array();
	
	for($fa=-1;$fa<26;$fa++){
		for($sa=0;$sa<26;$sa++){
			if($fa==-1){
				$alphabet[count($alphabet)] = $entry_alphabet[$sa];
				
			}else{
				$alphabet[count($alphabet)] = $entry_alphabet[$fa].$entry_alphabet[$sa];
				
			}		
		}
	}
	//include 'classes/PHPExcel/IOFactory.php';
	
	$first_file_last_row = 1;
	for($i=0;$i<count($file_array);$i++){
		$file_src = $file_array[$i];

		$inputFileType = PHPExcel_IOFactory::identify($file_src);;
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(false);

		$objReader->setLoadAllSheets();
		$excel[$i] = $objReader->load($file_src);

		$excel[$i]->setActiveSheetIndex(0);	
		
		if($i != 0){
			$file_data = $excel[$i]->getActiveSheet()->toArray(null,true,true,true);
			if($i==2){
				//var_dump($file_data[2]);
			}
			
			if(!isset($file_data[1])){
				//print($i.' - ');
			}
			if($i==1){
				//print(count($file_data).'<br>');
				//var_dump($file_data);
				
			}
			$total_rows = count($file_data);
			
			for($r=1;$r<$total_rows;$r++){
				if(isset($file_data[$r])){
					for($c=0;$c<count($file_data[$r]);$c++){				
						$excel[0]->getActiveSheet()->setCellValue($alphabet[$c].($first_file_last_row+$r), $file_data[$r+1][$alphabet[$c]]);	
						
					}	
				}
			}
			
			if($display_option){
				$first_file_last_row = $first_file_last_row+($total_rows);
				
			}else{
				$first_file_last_row = $first_file_last_row+($total_rows-1);
				
			}
			//unlink($file_src);
		}else{
			$first_file_data = $excel[0]->getActiveSheet()->toArray(null,true,true,true);
			
			$first_file_last_row = count($first_file_data);
		}
		
		if($i==count($file_array)-1){
			//unlink('files/'.$file_array[0]);
		}
	}
	
	if($file_format == 0){
		$file_name = $file_name.'.xlsx';
		$objWriter = PHPExcel_IOFactory::createWriter($excel[0], 'Excel2007');
		
	}else{
		$file_name = $file_name.'.csv';
		$objWriter = PHPExcel_IOFactory::createWriter($excel[0], 'csv');
	}
	
	
	$objWriter->save('files/'.$file_name);
	
	return 'files/'.$file_name;
}

function fetch_database_partitions($partition_type,$period_from_date,$period_to_date){
	$default_partition_names = $GLOBALS['default_partition_names'];
		
	$partitions_array = new_fetch_db_table('connect','table_partitions',$GLOBALS['company_id'],'period_from',"((period_from >= '".$period_from_date."' and period_to <= '".$period_to_date."') || (period_from <= '".$period_from_date."'  and period_to >= '".$period_to_date."') || (period_from >= '".$period_from_date."' and period_from <= '".$period_to_date."') || (period_to <= '".$period_to_date."' and period_to >= '".$period_from_date."'))  and _type = ".$partition_type);
	
	$check_from_partiition_array = new_fetch_db_table('connect','table_partitions',$GLOBALS['company_id'],'id',"period_from <= '".$period_from_date."' and _type = ".$partition_type);
	
	$data_partition_string = '';
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

function calculate_days_worked($agent_id_string,$_from,$_to,$validation){
	$company_id = $GLOBALS['company_id'];
	$agent_id_array = explode(',',$agent_id_string);
	$agent_id_filter = "(agent_id = ".str_replace(","," or agent_id = ",$agent_id_string).")";
	
	$validation_filter = '';
	if($validation){
		$validation_filter = ' and validation_status = 1 ';
		
	}
	
	$data_1 = fetch_db_table('connect','_data',$company_id,'id',$agent_id_filter." and _date >= '".$_from."' and _date <= '".$_to."'".$validation_filter);
	
	$data_2 = fetch_db_table('connect','_data_new',$company_id,'id',$agent_id_filter." and _date >= '".$_from."' and _date <= '".$_to."'".$validation_filter);
	
	$days = ceil(($_to-$_from/86400));
	
	for($a=0;$a<count($agent_id_array);$a++){
		
		$data_index_1 = array_keys($data_1['agent_id'],$agent_id_array[$a]);
		$data_index_2 = array_keys($data_2['agent_id'],$agent_id_array[$a]);
		
		$this_agent_days = 0;
		$output_array[$agent_id_array[$a]] = $this_agent_days;
		if(isset($data_index_1[0]) || isset($data_index_2[0])){
			for($day=0;$day<$days;$day++){
				$day_from = $_from+($day*86400);
				$day_to = $day_from + 86399;
				
				if($day_to > $_to){
					$day_to = $_to;
				}
				
				$day_found = 0;
				if(isset($data_index_1[0])){
					for($d=0;$d<count($data_index_1);$d++){
						
						if($data_1['_date'][$data_index_1[$d]] >= $day_from and $data_1['_date'][$data_index_1[$d]] <= $day_to){
							
							$this_agent_days++;
							$day_found = 1;
							break;
						}
					}
				}
				
				if(!$day_found){
					if(isset($data_index_2[0])){
						for($d=0;$d<count($data_index_2);$d++){
							
							if($data_2['_date'][$data_index_2[$d]] >= $day_from and $data_2['_date'][$data_index_2[$d]] <= $day_to){
								
								$this_agent_days++;
								break;
							}
						}
					}
				}
			}
		}
		
		$output_array[$agent_id_array[$a]] = $this_agent_days;
	}
	
	return $output_array;
}
?>