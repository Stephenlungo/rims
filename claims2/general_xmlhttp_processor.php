<?php	
	include 'scripts/short_connector.php';
if(!isset($_COOKIE['session_active']) and !isset($_POST['sign_in_user'])){
		print('session_expired~');
		
}else{
	include '../common_xmlhttp_processor.php';
	
	if(isset($_POST['create_or_update_request_type'])){
		$title = $_POST['title'];
		$billing_type = $_POST['billing_type'];
		$daily_rate = $_POST['daily_rate'];
		$limit_days = $_POST['limit_days'];
		$max_days = $_POST['max_days'];
		$day_adjustment = $_POST['day_adjustment'];
		$fixed_amount = $_POST['request_type_amount'];
		$urgency = $_POST['urgency'];
		$color_code = $_POST['color'];
		$levels = $_POST['levels'];
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		$site_id = $_POST['site_id'];
		$request_type_id = $_POST['request_type_id'];
		
		$scheduler_trigger = $_POST['scheduler_trigger'];
		$trigger_day = $_POST['trigger_day'];
		$trigger_month_day = $_POST['trigger_month_day'];
		$scheduler_payment_from_date_day = $_POST['scheduler_payment_from_date_day'];
		$scheduler_payment_from_date_month = $_POST['scheduler_payment_from_date_month'];
		$scheduler_payment_from_date_month_operator = $_POST['scheduler_payment_from_date_month_operator'];
		$scheduler_payment_from_date_month_addition = $_POST['scheduler_payment_from_date_month_addition'];
		
		$scheduler_payment_to_date_day = $_POST['scheduler_payment_to_date_day'];
		$scheduler_payment_to_date_month = $_POST['scheduler_payment_to_date_month'];
		$scheduler_payment_to_date_month_operator = $_POST['scheduler_payment_to_date_month_operator'];
		$scheduler_payment_to_date_month_addition = $_POST['scheduler_payment_to_date_month_addition'];
		
		$claim_payment_dates = $scheduler_payment_from_date_day.']'.$scheduler_payment_from_date_month.']'.$scheduler_payment_from_date_month_operator.']'.$scheduler_payment_from_date_month_addition.'|'.$scheduler_payment_to_date_day.']'.$scheduler_payment_to_date_month.']'.$scheduler_payment_to_date_month_operator.']'.$scheduler_payment_to_date_month_addition;
		
		$scheduler_recurrence = $_POST['scheduler_recurrence'];
		$scheduler_schedule_type = $_POST['scheduler_schedule_type'];
		$scheduler_location_depth = $_POST['scheduler_location_depth'];
		$scheduler_unknown_locations = $_POST['scheduler_unknown_locations'];
		$scheduler_days_worked_id = $_POST['scheduler_days_worked_id'];
		$scheduler_force_days = $_POST['scheduler_force_days'];
		$scheduler_force_days_justification = str_replace("'","''",$_POST['scheduler_force_days_justification']);
		$scheduler_schedule_rule = $_POST['scheduler_schedule_rule'];
		$scheduler_beneficiary_type = $_POST['scheduler_beneficiary_type'];
		$scheduler_agent_groups = $_POST['scheduler_agent_groups'];
		$scheduler_agent_units = $_POST['scheduler_agent_units'];
		$scheduler_custom_agent = $_POST['scheduler_custom_agents'];
		$scheduler_execution_notification = $_POST['scheduler_execution_notification'];
		
		$approver_string = '';
		$delay_monitor_string = '';
		for($l=0;$l<$levels;$l++){
			$this_level_title = str_replace("]","",str_replace("|","",str_replace(",","",str_replace("'","''",$_POST['level_title_'.$l]))));
			$this_action_title = str_replace(",","",str_replace("'","''",$_POST['action_title_'.$l]));
			$this_action_type = $_POST['action_type_'.$l];
			$this_approver_type = $_POST['approver_type_'.$l];
			$this_location_level = $_POST['approver_location_level_'.$l];
			$this_approver_location = $_POST['approver_location_'.$l];
			$this_unit = $_POST['approver_unit_'.$l];
			$this_group_id = $_POST['approver_group_'.$l];
			$this_approver_user = $_POST['approver_user_'.$l];
			$this_notify_creator = $_POST['notify_creator_'.$l];
			$this_notify_levels = str_replace(",","}",$_POST['notify_levels_'.$l]);
			
		//	print($this_notify_levels);
			
			if($approver_string == ''){
				$approver_string = $this_level_title.','.$this_action_title.','.$this_action_type.','.$this_approver_type.','.$this_location_level.','.$this_approver_location.','.$this_unit.','.$this_group_id.','.$this_approver_user.','.$this_notify_creator.','.$this_notify_levels;
				
			}else{
				$approver_string .= ']'.$this_level_title.','.$this_action_title.','.$this_action_type.','.$this_approver_type.','.$this_location_level.','.$this_approver_location.','.$this_unit.','.$this_group_id.','.$this_approver_user.','.$this_notify_creator.','.$this_notify_levels;
				
			}
			
			$total_documents = $_POST['total_documents_'.$l];
			
			$document_string = '';
			for($d=0;$d<$total_documents;$d++){
				
				if($_POST['document_active_'.$l.'_'.$d]){
					
					if($document_string == ''){						
						$document_string = str_replace("]","",str_replace("|","",str_replace("'","''",$_POST['document_'.$l.'_'.$d])));
						
					}else{
						$document_string .= '|'.str_replace("]","",str_replace("|","",str_replace("'","''",$_POST['document_'.$l.'_'.$d])));
					}
				}
			}
			
			$approver_string .= ','.$document_string;
			
			if($delay_monitor_string == ''){
				$delay_monitor_string = $_POST['delay_monitor_switch_'.$l].']'.$_POST['delay_length_'.$l].']'.$_POST['delay_flag_claim_'.$l].']'.$_POST['delay_notify_creator_'.$l].']'.$_POST['delay_notify_levels_'.$l].']'.$_POST['delay_notify_user_'.$l].']'.$_POST['delay_notify_user_group_'.$l];				
				
			}else{
				$delay_monitor_string .= '|'.$_POST['delay_monitor_switch_'.$l].']'.str_replace("'","''",str_replace("|","",str_replace("]","",$_POST['delay_length_'.$l]))).']'.$_POST['delay_flag_claim_'.$l].']'.$_POST['delay_notify_creator_'.$l].']'.str_replace("'","''",str_replace("|","",str_replace("]","",$_POST['delay_notify_levels_'.$l]))).']'.$_POST['delay_notify_user_'.$l].']'.$_POST['delay_notify_user_group_'.$l];
			}			
		}
		
		
		if(!$request_type_id || $_POST['new_copy']){
			$add_request_type = mysqli_query($$module_connect,"insert into request_types (company_id,branch_id,region_id,province_id,hub_id,site_id,title,billing_type,daily_rate,fixed_amount,limit_days,max_days,urgency,rule_string,delay_monitor_rule_string,day_adjustment,color_code,status,user_date,_date) VALUES($company_id,0,$region_id,$province_id,$hub_id,$site_id,'$title',$billing_type,'$daily_rate','$fixed_amount',$limit_days,'$max_days',$urgency,'$approver_string','$delay_monitor_string',$day_adjustment,'$color_code',1,'$user_date','$today')")or die(mysqli_error($$module_connect));

			if($scheduler_trigger){
				$this_request_type = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id order by id desc")or die(mysqli_error($module_connect));
				$this_request_type_results = mysqli_fetch_array($this_request_type,MYSQLI_ASSOC);
				
				$this_request_type_date = $this_request_type_results['_date'];
			
				$add_request_type_scheduler = mysqli_query($$module_connect,"insert into request_type_scheduler (company_id,_type,request_type_dates,claim_payment_dates,trigger_type_id,trigger_month_day,recurrence,schedule_type,location_depth,unspecified_locations,specific_day_trigger,force_days_worked,days_worked,justification_message,schedule_rule,beneficiary_type,beneficiary_group_id,beneficiary_unit_id,specific_agent_ids,email_on_exec,user_date,_date) VALUES($company_id,0,'$this_request_type_date','$claim_payment_dates',$scheduler_trigger,'$trigger_day',$trigger_month_day,$scheduler_recurrence,$scheduler_schedule_type,$scheduler_location_depth,$scheduler_unknown_locations,$scheduler_days_worked_id,$scheduler_force_days,'$scheduler_force_days_justification',$scheduler_schedule_rule,$scheduler_beneficiary_type,'$scheduler_agent_groups',$scheduler_agent_units,'$scheduler_custom_agent',$scheduler_execution_notification,'$user_date','$today')")or die(mysqli_error($$module_connect));
			}
			
		}else{
			
			$update_request_type = mysqli_query($$module_connect,"update request_types set region_id = $region_id,province_id = $province_id,hub_id = $hub_id,site_id = $site_id,title = '$title',billing_type = $billing_type,daily_rate = '$daily_rate',fixed_amount = '$fixed_amount',limit_days = $limit_days,max_days = '$max_days',urgency = $urgency,rule_string = '$approver_string',delay_monitor_rule_string = '$delay_monitor_string',day_adjustment = $day_adjustment,color_code = '$color_code' where id = $request_type_id")or die(mysqli_error($$module_connect));
			
			$this_request_type = mysqli_query($$module_connect,"select * from request_types where id = $request_type_id")or die(mysqli_error($$module_connect));
			$this_request_type_results = mysqli_fetch_array($this_request_type,MYSQLI_ASSOC);
			
			$this_request_type_date = $this_request_type_results['_date'];
			
			$check_request_type_scheduler = mysqlI_query($$module_connect,"select * from request_type_scheduler where request_type_dates =  '$this_request_type_date' and company_id = $company_id and _type = 0")or die(mysqli_error($$module_connect));
			
			if(mysqli_num_rows($check_request_type_scheduler)){
				$update_request_type_scheduler = mysqli_query($$module_connect,"update request_type_scheduler set claim_payment_dates = '$claim_payment_dates',trigger_type_id = $scheduler_trigger,specific_day_trigger = '$trigger_day',trigger_month_day = $trigger_month_day,recurrence = $scheduler_recurrence,schedule_type = $scheduler_schedule_type,location_depth = $scheduler_location_depth,unspecified_locations = $scheduler_unknown_locations,force_days_worked = $scheduler_days_worked_id,days_worked = $scheduler_force_days,justification_message = '$scheduler_force_days_justification',schedule_rule = $scheduler_schedule_rule,beneficiary_type = $scheduler_beneficiary_type,beneficiary_group_id = '$scheduler_agent_groups',beneficiary_unit_id = $scheduler_agent_units,specific_agent_ids = '$scheduler_custom_agent',email_on_exec = $scheduler_execution_notification where request_type_dates =  '$this_request_type_date' and company_id = $company_id and _type = 0")or die(mysqli_error($$module_connect));
				
			}else if($scheduler_trigger){
				$update_request_type_scheduler = mysqli_query($$module_connect,"insert into request_type_scheduler (company_id,_type,request_type_dates,claim_payment_dates,trigger_type_id,location_depth,unspecified_locations,specific_day_trigger,trigger_month_day,recurrence,schedule_type,	force_days_worked,days_worked,justification_message,schedule_rule,beneficiary_type,beneficiary_group_id,beneficiary_unit_id,specific_agent_ids,email_on_exec,user_date,_date) VALUES($company_id,0,'$this_request_type_date','$claim_payment_dates',$scheduler_trigger,'$trigger_day',$trigger_month_day,$scheduler_recurrence,$scheduler_schedule_type,$scheduler_location_depth,$scheduler_unknown_locations,$scheduler_days_worked_id,$scheduler_force_days,'$scheduler_force_days_justification',$scheduler_schedule_rule,$scheduler_beneficiary_type,'$scheduler_agent_groups',$scheduler_agent_units,'$scheduler_custom_agent',$scheduler_execution_notification,'$user_date','$today')")or die(mysqli_error($$module_connect));				
			}
		}
		
		print('create_or_update_request_type~'.$request_type_id);
	}
	
	if(isset($_POST['fetch_claim_type_list_code'])){
		$status = $_POST['status'];
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		$site_id = $_POST['site_id'];
		
		$filter_string = '';
		
		if($site_id){
			$filter_string .= ' and site_id ='.$site_id;
			
		}else if($hub_id){
			$filter_string .= ' and hub_id ='.$hub_id;
			
		}else if($province_id){
			$filter_string .= ' and province_id ='.$province_id;
			
		}else if($region_id){
			$filter_string .= ' and region_id ='.$region_id;
			
		}
		
		if($status != -1){
			$filter_string .=  ' and status = '.$status;
		}
		
		$filter_string .= $filter_string;
		
		if($user_results['branch_id']){
			$filter_string .= ' and branch_id = '.$user_results['branch_id'];
		}
		
		print('fetch_claim_type_list_code~');
		include 'scripts/page_codes/_codes/approval_settings_code.php';
	}

	
	if(isset($_POST['fetch_request_type_details'])){	
		$request_type_id = $_POST['request_type_id'];		
		print('fetch_request_type_details~');
	
		include 'scripts/page_codes/_codes/request_type_details_code.php';
	}
	
	
	if(isset($_POST['enable_or_disable_request_type'])){
		$action_type = $_POST['action_type'];
		$request_type_id = $_POST['request_type_id'];
	
		$update_request_type = mysqli_query($claims_connect,"update request_types set status = $action_type where id = '$request_type_id'")or die(mysqli_error($claims_connect));
		print('enable_or_disable_request_type~');
	}
	
	
	
	if(isset($_POST['create_or_update_threshold'])){
		$threshold_id = $_POST['threshold_id'];
		$title  = str_replace("'","''",$_POST['title']);
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		$site_id = $_POST['site_id'];
		$branch_id = $user_results['branch_id'];
		
		$total_approvers = $_POST['total_approvers'];
		
		$rule_string = '';
		for($a=0;$a<$total_approvers;$a++){
			if(isset($_POST['approver_active_'.$a])){
				if($rule_string == ''){
					$rule_string = $_POST['value_limitation_'.$a].','.$_POST['limit_value_'.$a].','.$_POST['lower_amounts_'.$a].','.$_POST['high_amounts_'.$a].','.$_POST['approver_type_'.$a].','.$_POST['approver_level_'.$a].','.$_POST['approver_location_'.$a].','.$_POST['approver_unit_'.$a].','.$_POST['approver_group_'.$a].','.$_POST['approver_user_'.$a].','.$_POST['user_allocation_'.$a].','.$_POST['approver_active_'.$a];
					
				}else{
					$rule_string .= ']'.$_POST['value_limitation_'.$a].','.$_POST['limit_value_'.$a].','.$_POST['lower_amounts_'.$a].','.$_POST['high_amounts_'.$a].','.$_POST['approver_type_'.$a].','.$_POST['approver_level_'.$a].','.$_POST['approver_location_'.$a].','.$_POST['approver_unit_'.$a].','.$_POST['approver_group_'.$a].','.$_POST['approver_user_'.$a].','.$_POST['user_allocation_'.$a].','.$_POST['approver_active_'.$a];
				}
			}
		}
		
		if(!$threshold_id){
			$add_threshold = mysqli_query($$module_connect,"insert into approval_thresholds (company_id,branch_id,region_id,province_id,hub_id,site_id,title,rule_string,status,user_date,_date) VALUES($company_id,$branch_id,$region_id,$province_id,$hub_id,$site_id,'$title','$rule_string',1,'$user_date','$today')")or die(mysqli_error($$module_connect));
			
		}else{
			$update_threshold = mysqli_query($$module_connect,"update approval_thresholds set region_id = $region_id,province_id = $province_id,hub_id = $hub_id,site_id = $site_id,title = '$title',rule_string = '$rule_string' where id = $threshold_id")or die(mysqli_error($$module_connect));
		}
		
		print('create_or_update_threshold~');
	}
	
	if(isset($_POST['enable_or_disable_threshold'])){
		$action_type = $_POST['action_type'];
		$threshold_id = $_POST['threshold_id'];
	
		$update_threshold = mysqli_query($claims_connect,"update approval_thresholds set status = $action_type where id = '$threshold_id'")or die(mysqli_error($claims_connect));
		print('enable_or_disable_threshold~');
	}
	
	
	if(isset($_POST['fetch_request_threshold'])){
		$threshold_id = $_POST['threshold_id'];
		
		$this_threshold = mysqli_query($claims_connect,"select * from approval_thresholds where id = '$threshold_id'")or die(mysqli_error($claims_connect));
		$this_threshold_results = mysqli_fetch_array($this_threshold,MYSQLI_ASSOC);		
		
		print('fetch_request_threshold~');
		
		include 'scripts/page_codes/_codes/approval_group_code.php';
		
	}
	
	if(isset($_POST['delete_request_threshold'])){
		$threshold_date = $_POST['threshold_date'];
		
		$check_request_types = mysqli_query($claims_connect,"select * from request_types where company_id = $company_id")or die(mysqli_error($claims_connect));
		
		for($c=0;$c<mysqli_num_rows($check_request_types);$c++){
			$check_request_type_results = mysqli_fetch_array($check_request_types,MYSQLI_ASSOC);
			$request_date = $check_request_type_results['_date'];
			
			$action_types = explode(',',$check_request_type_results['action_type']);
			$stage_approvers = explode(',',$check_request_type_results['stage_approvers']);
			
			$stage_approver_string = '';
			$action_type_string = '';
			for($a=0;$a<count($action_types);$a++){
				if($action_types[$a] == 1 and ($stage_approvers[$a] == $threshold_date)){
					if($stage_approver_string == ''){
						$stage_approver_string = 's:0:0';
						$action_type_string = '0';
						
					}else{
						$stage_approver_string .= ',s:0:0';
						$action_type_string .= ',0';
					}

				}else{
					if($stage_approver_string == ''){
						$stage_approver_string = $stage_approvers[$a];
						$action_type_string = $action_types[$a];
						
					}else{
						$stage_approver_string .= ','.$stage_approvers[$a];
						$action_type_string .= ','.$action_types[$a];
						
					}
				}
			}

			$update_request_type = mysqli_query($claims_connect,"update request_types set stage_approvers = '$stage_approver_string',action_type = '$action_type_string' where _date = '$request_date' and company_id = $company_id")or die(mysqli_error($claims_connect));
		}
		
		$delete_approval_threshold = mysqli_query($claims_connect,"delete from approval_thresholds where _date = '$threshold_date' and company_id = $company_id")or die(mysqli_error($claims_connect));
		
		print('delete_request_threshold~');
	}
	

	
	
	if(isset($_POST['fetch_claim_beneficiaries'])){
		
		$claim_date = $_POST['claim_date'];
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$this_default_ascensions_partition_name = $default_partition_names[7][1][2];
		$this_default_approvals_partition_name = $default_partition_names[8][1][0];

		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		$claim_ascension_table = $this_default_ascensions_partition_name.'_partition_'.$partitions[0];
		
		$approval_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
		$claim_approvals_table = $this_default_approvals_partition_name.'_partition_'.$approval_partitions[0];
		
		$this_default_agents_partition_name = $default_partition_names[2][1][0];
		$this_default_phone_partition_name = $default_partition_names[2][1][1];

		$agents_partitions = fetch_database_partitions(2,$claim_date,$claim_date);

		$agents_table = $this_default_agents_partition_name.'_partition_'.$agents_partitions[0];
		$phone_number_table = $this_default_phone_partition_name.'_partition_'.$agents_partitions[0];
		
		$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = $claim_date")or die(mysqli_error($$module_connect));
		$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
		$this_claim_date = $this_claim_results['_date'];
		//print(mysqli_num_rows($this_claim));
		
		print('fetch_claim_beneficiaries[]');
		//print('hi');
		include 'scripts/page_codes/_codes/claim_ben_levels.php';
	}
	
	if(isset($_POST['fetch_payment_claims'])){
		include '../common_data_loop.php';
		
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		
		$site_id = 0;
		if(isset($_POST['site_id'])){
			$site_id = $_POST['site_id'];
		}
		
		$creator_id = 0;
		if(isset($_POST['creator_id'])){
			$creator_id = $_POST['creator_id'];
		}
		
		$finance_processed = '-1';
		if(isset($_POST['finance_processed'])){
			$finance_processed = $_POST['finance_processed'];
			
		}
		
		$creation_method = 0;
		if(isset($_POST['creation_method'])){
			$creation_method = $_POST['creation_method'];
		}
		
		$creation_method_filter = '';
		if($creation_method == 1){
			$creation_method_filter = ' and creation_method = 1';
			
		}else if($creation_method == 2){
			$creation_method_filter = ' and creation_method = 0';
			
		}
		
		$unit_id = $_POST['unit_id'];
		$level = $_POST['level'];
		$level_consideration = $_POST['level_consideration'];
		
		$claim_type_id = $_POST['claim_type_id'];
		
		$from_date = explode('/',$_POST['date_from']);
		$to_date = explode('/',$_POST['date_to']);
		
		$from_date = mktime(0,0,0,$from_date[0],$from_date[1],$from_date[2]);
		$to_date = mktime(23,59,59,$to_date[0],$to_date[1],$to_date[2]);
		
		
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$claims_partitions = fetch_database_partitions(7,$from_date,$to_date);
		
	
		$search_key = str_replace("'","''",$_POST['search_key']);
		$strictness_id = $_POST['strictness_id'];
		
		$ordering = $_POST['ordering'];
		$user_allocation = $_POST['user_allocation'];
		$allocation_colors = $_POST['allocation_colors'];
		
		$claim_id_search_key_string = '';
		$search_key_string = '';
		$ignore_dates = 0;
		if($_POST['search_key'] != 'Enter beneficiary name, phone number or Claim ID'){
			$search_key_array = explode(',',$search_key);
			
			$found = 0;
			if($strictness_id == 0 || $strictness_id == 1) {
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_id = str_replace(" ","",$search_key_array[$sk]);
					if(is_numeric($this_id)){
						if($claim_id_search_key_string == ''){
							$claim_id_search_key_string = $this_id;
							
						}else{
							$claim_id_search_key_string .= " or claim_id = ".$this_id;
							
						}
						
						$found = 1;
						
					}
				}
				
				if($claim_id_search_key_string != ''){
					$claim_id_search_key_string = ' and (company_id = '.$company_id.' and claim_id = '.$claim_id_search_key_string.')';
					
				}
				
				if(!$found){
					$claim_id_search_key_string = ' and id = 0';
				}
				
				$ignore_dates = 1;
			}
			
			if($strictness_id == 0 || $strictness_id == 5) {
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_id = str_replace(" ","",$search_key_array[$sk]);
					$this_id = str_replace("B","",$search_key_array[$sk]);
					$this_id = str_replace("b","",$search_key_array[$sk]);
					if(is_numeric($this_id)){
						if($claim_id_search_key_string == ''){
							$claim_id_search_key_string = $this_id;
							
						}else{
							$claim_id_search_key_string .= " or batch_number = ".$this_id;
							
						}
						
						$found = 1;
					}
				}
				
				if($claim_id_search_key_string != ''){
					$claim_id_search_key_string = ' and (company_id = '.$company_id.' and batch_number = '.$claim_id_search_key_string.')';
					
				}
				
				if(!$found){
					$claim_id_search_key_string = ' id = 0';
				}
				
				$ignore_dates = 1;
			}
			
			if($strictness_id == 0 || $strictness_id == 6) {
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_id = str_replace(" ","",$search_key_array[$sk]);
					
						if($claim_id_search_key_string == ''){
							$claim_id_search_key_string = "'%".$this_id."%'";
							
						}else{
							$claim_id_search_key_string .= " or title LIKE '%".$this_id."%'";
							
						}
						
						$found = 1;
				}
				
				if($claim_id_search_key_string != ''){
					$claim_id_search_key_string = " and (company_id = ".$company_id." and title LIKE ".$claim_id_search_key_string.")";
					
				}
				
				if(!$found){
					$claim_id_search_key_string = ' id = 0';
				}
				//print($claim_id_search_key_string);
				$ignore_dates = 1;
			}
			
				
			
			if($strictness_id == 0 || $strictness_id == 2){
				$found = 0;
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_name = $search_key_array[$sk];

					for($pat=0;$pat<count($claims_partitions);$pat++){
					
						$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
					
						$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where _name LIKE '%$this_name%' and company_id = $company_id")or die(mysqli_error($$module_connect));
						
						for($cb=0;$cb<mysqli_num_rows($claim_beneficiaries);$cb++){
							$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
							
							if($search_key_string == ''){
								$search_key_string .= ' _date = '.$claim_beneficiary_results['claim_date'];
								
							}else{
								$search_key_string .= ' or _date = '.$claim_beneficiary_results['claim_date'];
								
							}
							
							$found = 1;
						}
					}
				}
				
				if(!$found){
					$search_key_string .= ' _date = 0 ';
				}
		
				if($search_key_string != ''){
					$search_key_string = ' and ('.$search_key_string.')';
				}
			}
			
			if($strictness_id == 0 || $strictness_id == 3){
				$found = 0;
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_name = $search_key_array[$sk];					
					
					for($pat=0;$pat<count($claims_partitions);$pat++){
					
						$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
					
						$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where phone LIKE '%$this_name%' and company_id = $company_id")or die(mysqli_error($$module_connect));
								
						for($cb=0;$cb<mysqli_num_rows($claim_beneficiaries);$cb++){
							$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
							
							if($search_key_string == ''){
								$search_key_string .= ' _date = '.$claim_beneficiary_results['claim_date'];
								
							}else{
								$search_key_string .= ' or _date = '.$claim_beneficiary_results['claim_date'];
							}
							
							$found = 1;
						}
					}
				}
		
				if($search_key_string != ''){
					$search_key_string = ' and ('.$search_key_string.')';
				}
				
				if(!$found){
					$search_key_string .= ' and _date = 0';
				}
			}
			
			if($strictness_id == 0 || $strictness_id == 4){
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_name = $search_key_array[$sk];					
					
					$claim_users = mysqli_query($connect,"select * from users where _name LIKE '%$this_name%' and company_id = $company_id")or die(mysqli_error($connect));
					
					if(!mysqli_num_rows($claim_users) and $strictness_id == 4){
						$search_key_string .= ' user_date = 0';
						
					}else{					
						for($cb=0;$cb<mysqli_num_rows($claim_users);$cb++){
							$claim_users_results = mysqli_fetch_array($claim_users,MYSQLI_ASSOC);
							
							if($search_key_string == ''){
								$search_key_string .= 'user_date = '.$claim_users_results['_date'];
								
							}else{
								$search_key_string .= ' or user_date = '.$claim_users_results['_date'];
							}
						}
					}
				}
		
				if($search_key_string != ''){
					$search_key_string = ' and ('.$search_key_string.')';
				}
			}
		}
		
		$search_string = ' and (claim_date >= '.$from_date.' and claim_date <= '.$to_date.')';
		
		if($region_id != 0){
			$search_string .= ' and region_id = '.$region_id;
			
		}
				
		if($province_id != 0){
			$search_string .= ' and province_id = '.$province_id;
			
		}
		
		if($hub_id != 0){
			$search_string .= ' and hub_id = '.$hub_id;
			
		}
		
		if($site_id != 0){
			$search_string .= ' and site_id = '.$site_id;
			
		}
		
		if($unit_id != -1){
			$search_string .= ' and unit_id = '.$unit_id;
			
		}
		
		if($creator_id != 0){
			$search_string .= ' and user_date = '.$creator_id;
			
		}
		
		if($finance_processed != '-1'){
			if($finance_processed == 1){
				$search_string .= ' and ascensions != 0';
			
			}else if($finance_processed == 0){
				$search_string .= ' and ascensions = 0';
				
			}
		}
		
		if($claim_type_id != 0){
			$search_string .= " and claim_type_date LIKE '%".$claim_type_id."'";
			
		}
		
		
		
		if($level != -1){
			
			if($level_consideration == 1){
				$search_string .= " and level =".$_POST['level'];
				
			}else{
				$level_search_string = '';	
				for($pat=0;$pat<count($claims_partitions);$pat++){
					$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
				
					$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where level = $level and company_id = $company_id")or die(mysqli_error($$module_connect));
									
					for($cb=0;$cb<mysqli_num_rows($claim_beneficiaries);$cb++){
						$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
						
						if($level_search_string == ''){
							$level_search_string = ' and (_date = '.$claim_beneficiary_results['claim_date'];

						}else{
							$level_search_string .= ' or _date = '.$claim_beneficiary_results['claim_date'];

						}
					}			
				}
				
				if($level_search_string != ''){
					$level_search_string .= ')';
					$search_string .= $level_search_string;
					
				}else{
					if($strictness == 3){
						$search_string .= ' and _date = 0';
					}
				}
			}
		}
	
		if($_POST['status'] == ''){
			$status_string = '';
			
		}else{
			$status_string = ' and (status = '.$_POST['status'].')';
			
		}
		
		$search_string = $search_string.$search_key_string;
		
		$claim_types = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id")or die(mysqli_error($$module_connect));
		
		for($c=0;$c<mysqli_num_rows($claim_types);$c++){
			$claim_type_results = mysqli_fetch_array($claim_types,MYSQLI_ASSOC);
			
			$claim_type_id_array[$c] = $claim_type_results['id'];
			$claim_type_title_array[$c] = $claim_type_results['title'];
			$claim_type_date_array[$c] = $claim_type_results['_date'];	
			
			$levels_array = explode(']',$claim_type_results['rule_string']);
			$claim_type_total_levels_array[$c] = count($levels_array);				
		}
		
		print('fetch_payment_claims~');
		include 'scripts/page_codes/_codes/payment_claims_code.php';	
		
	}
	
	if(isset($_POST['fetch_claim_details'])){
		
		$claim_date = $_POST['claim_id'];
		$claim_id = 0;
		
		$start_date = time();
		$end_date = time();
		if($claim_date){
			$start_date = $claim_date;
			$end_date = $claim_date;
		}
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$this_default_ascensions_partition_name = $default_partition_names[7][1][2];
		$this_default_approvals_partition_name = $default_partition_names[8][1][0];

		$partitions = fetch_database_partitions(7,$start_date,$end_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$this_default_agents_partition_name = $default_partition_names[2][1][0];
		$this_default_phone_partition_name = $default_partition_names[2][1][1];

		$agent_partitions = fetch_database_partitions(2,$start_date,$end_date);

		$agents_table = $this_default_agents_partition_name.'_partition_'.$agent_partitions[0];
		$phone_number_table = $this_default_phone_partition_name.'_partition_'.$agent_partitions[0];
		
		
		if($claim_date){
			$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
			$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
			
			$claim_id = $this_claim_results['id'];
			
			
		}
		
		print('fetch_claim_details~');
		include 'scripts/page_codes/_codes/claim_edit_code.php';
	}
	
	if(isset($_POST['search_claim_agents'])){
		
		$database = 'undefined';
		if(isset($_POST['database'])){
			$database = $_POST['database'];
		}
		
		$search_with_days = 0;
		if(isset($_POST['search_with_days'])){
			$search_with_days = $_POST['search_with_days'];
		}
		
		$search_key = str_replace("'","''",$_POST['search_key']);
		
		$this_default_phone_partition_name = $default_partition_names[2][1][1];
		
		$start_date = time();
		$end_date = time();
		
		if($database != 'undefined'){
			if($database == 0){
				$start_date = mktime(0,0,0,01,01,2015);
				$end_date = time();
				
			}else{
				$start_date = $database;
				$end_date = $database;
			}
		}
		
		$partitions = fetch_database_partitions(2,$start_date,$end_date);
		
		$phone_number_array = array();
		$phone_number_searched = 0;
		
		if($_POST['search_key'] != 'Enter agent name or phone number' and $_POST['search_key'] != ''){
			$search_key_array = explode(',',$search_key);
			$search_key_string = '';
			
			$phone_number_search = '';
			
			for($sk=0;$sk<count($search_key_array);$sk++){
				$this_phone_number = $search_key_array[$sk];
				
				if(is_numeric($this_phone_number)){
					$phone_number_searched = 1;
					if($phone_number_search == ''){
						$phone_number_search = " phone_number LIKE '%$this_phone_number%'";
						
					}else{
						$phone_number_search .= " or phone_number LIKE '%$this_phone_number%'";
					}
				}
			}
			
			if($phone_number_search != ''){
				for($pat=0;$pat<count($partitions);$pat++){
					$this_phone_number_table = $this_default_phone_partition_name.'_partition_'.$partitions[$pat];
					
					$phone_numbers = mysqli_query($connect,"select * from $this_phone_number_table where $phone_number_search")or die(mysqli_error($connect));
						
					for($pn=0;$pn<mysqli_num_rows($phone_numbers);$pn++){
						$phone_number_results = mysqli_fetch_array($phone_numbers,MYSQLI_ASSOC);
						
						if($search_key_string == ''){
							$search_key_string = " _date = '".$phone_number_results['agent_date']."'";
							
						}else{
							$search_key_string .= " or _date = '".$phone_number_results['agent_date']."'";
							
						}
						
						if(!isset($phone_number_array[$phone_number_results['agent_date']])){
							$phone_number_array[$phone_number_results['agent_date']][0] = $phone_number_results['phone_number'];
							
						}else{
							$phone_number_array[$phone_number_results['agent_date']][count($phone_number_array[$phone_number_results['agent_date']])] = $phone_number_results['phone_number'];
						}
					}
				}
			}
						
			for($sk=0;$sk<count($search_key_array);$sk++){
				$this_name = $search_key_array[$sk];
				if(!is_numeric($this_name)){
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
		
		if($search_key_string == ''){
			$search_key_string = ' and (id < 0)';
			
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
		
		$selected_beneficiaries_array = explode(",",$_POST['selected_beneficiaries']);
		
		print('search_claim_agents~');
		include 'scripts/page_codes/_codes/search_claim_agents_code.php';
	}
	
	if(isset($_POST['fetch_agent_days'])){
		$start_date_array = explode('/',$_POST['date_from']);
		$end_date_array = explode('/',$_POST['date_to']);
		
		$start_date = mktime(0,0,0,$start_date_array[0],$start_date_array[1],$start_date_array[2]);
		$end_date = mktime(23,59,59,$end_date_array[0],$end_date_array[1],$end_date_array[2]);
		
		$agent_data = fetch_db_table('connect','_data',$company_id,'_date','validation_status = 1 and agent_id = '.$_POST['agent_id']);
		
		$agent_days = check_agent_activity_days($_POST['agent_id'],$_POST['unit_id'],0,$start_date,$end_date,$agent_data,$company_id);
		
		print('fetch_agent_days~'.$agent_days.'~'.$_POST['claim_type_date'].'~'.$_POST['agent_date'].'~'.$_POST['agent_id']);
	}
	
	if(isset($_POST['process_claim_images'])){
		$uploaded_files = explode(',',$_POST['uploaded_files']);
		
		$file_types = '';
		for($f=0;$f<count($uploaded_files);$f++){
			if(file_exists('imgs/'.$uploaded_files[$f])){
				rename('imgs/'.$uploaded_files[$f],'imgs/attachments/'.$uploaded_files[$f]);
			}
			
			$this_file_name = explode('.',$uploaded_files[$f]);
			
			if($file_types == ''){
				$file_types = $this_file_name[1];
				
			}else{
				$file_types .= ','.$this_file_name[1];
			}
		}
		print('process_claim_images~'.$file_types);
	}
		
	if(isset($_POST['create_or_update_claim'])){
		$uploaded_files = $_POST['uploaded_files'];
		$claim_types = $_POST['claim_types'];
		$claim_beneficiaries = $_POST['claim_beneficiaries'];
		$claim_total = $_POST['claim_total'];
		
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		$site_id = $_POST['site_id'];
		$unit_id = $_POST['unit_id'];
		
		$this_claim_date = $_POST['claim_id'];
		
		$claim_creation_date =  mktime(date('H',time()),date('i',time()),date('s',time()),date('m',time()),date('j',time()),date('Y',time()));
		
		$claim_date = time();
		if($this_claim_date){
			$claim_date = $this_claim_date;
			
		}
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		
		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$this_default_approvals_partition_name = $default_partition_names[8][1][0];
		
		$approvals_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
		
		$approvals_table = $this_default_approvals_partition_name.'_partition_'.$approvals_partitions[0];
		
		$this_default_agents_partition_name = $default_partition_names[2][1][0];
		$this_default_phone_partition_name = $default_partition_names[2][1][1];

		$agent_partitions = fetch_database_partitions(2,$claim_date,$claim_date);

		$agents_table = $this_default_agents_partition_name.'_partition_'.$agent_partitions[0];
		$phone_number_table = $this_default_phone_partition_name.'_partition_'.$agent_partitions[0];
		
		if($user_id != 1031){
			$agents = mysqli_query($connect,"select * from $agents_table where company_id = $company_id")or die(mysqli_error($connect));
			for($a=0;$a<mysqli_num_rows($agents);$a++){
				$agent_results = mysqli_fetch_array($agents,MYSQLI_ASSOC);
				
				$agent_id_array[$a] = $agent_results['id'];
				$agent_date_array[$a] = $agent_results['_date'];
				$agent_region_array[$a] = $agent_results['region_id'];
				$agent_province_array[$a] = $agent_results['province_id'];
				$agent_hub_array[$a] = $agent_results['hub_id'];
				$agent_site_array[$a] = $agent_results['site_id'];
				
				$agent_name_array[$a] = $agent_results['_name'];
			}
		}
		
		
		
		
		if(!$this_claim_date){
			$claim_id_check = mysqli_query($$module_connect,"select * from $payment_claims_table where company_id = $company_id order by claim_id desc")or die(mysqli_error($$module_connect));
			$claim_id_check_results = mysqli_fetch_array($claim_id_check,MYSQLI_ASSOC);
			
			$new_claim_id = $claim_id_check_results['claim_id'] + 1;
			
			$add_new_claim = mysqli_query($$module_connect,"insert into $payment_claims_table (company_id,claim_date,title,region_id,province_id,hub_id,site_id,unit_id,claim_type_date,amount,paid,level,beneficiaries,user_date,file_src,_date,status,claim_id,ascensions,ascension_dates,ascension_user_dates,status_change_user,claim_old_status,status_change_date,status_change_comment) VALUES($company_id,'$today','',$region_id,$province_id,$hub_id,$site_id,$unit_id,'$claim_types','$claim_total','',0,'$claim_beneficiaries','$user_date','$uploaded_files','$today',1,$new_claim_id,0,'','','',0,'','')")or die(mysqli_error($$module_connect));
			
			$added_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where claim_id = $new_claim_id")or die(mysqli_error($$module_connect));
			
			$added_claim_results = mysqli_fetch_array($added_claim,MYSQLI_ASSOC);
			
			$this_claim_id = $added_claim_results['id'];
			$this_claim_date = $added_claim_results['_date'];
			
		}else{
			$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$this_claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
			$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
			
			$this_claim_id = $this_claim_results['id'];
		
			$update_claim = mysqli_query($$module_connect,"update $payment_claims_table set unit_id = $unit_id,claim_type_date = '$claim_types',amount = '$claim_total',paid = '',beneficiaries = '$claim_beneficiaries',file_src = '$uploaded_files',region_id = $region_id,province_id = $province_id,hub_id = $hub_id, site_id = $site_id where id = $this_claim_id")or die(mysqli_error($$module_connect));
			
				
			
		}
		
		$claim_type_array = explode(',',$claim_types);
		$claim_beneficiary_array = explode(',',$claim_beneficiaries);
		
		$sql_string = '';
		$approval_string = '';
		for($c=0;$c<count($claim_type_array);$c++){
			
			$this_claim_type_date = $claim_type_array[$c];
			
			$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
			$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
			
			
			$claim_rule_string = explode(']',$this_claim_type_results['rule_string']);
			
			$beneficiary_rule_string = $claim_rule_string[0];
			
			for($b=0;$b<count($claim_beneficiary_array);$b++){
				$this_beneficiary_date = $claim_beneficiary_array[$b];
				$this_beneficiary_phone = $_POST['phone_number_'.$this_claim_type_date.'_'.$this_beneficiary_date];
				$this_beneficiary_nrc = $_POST['nrc_number_'.$this_claim_type_date.'_'.$this_beneficiary_date];
				
				$this_beneficiary_days_worked = $_POST['days_worked_'.$this_claim_type_date.'_'.$this_beneficiary_date];
				
				if(!$this_claim_type_results['billing_type']){
					$this_beneficiary_days_payable = $_POST['days_payable_'.$this_claim_type_date.'_'.$this_beneficiary_date];
					$this_beneficiary_rate = $_POST['rate_'.$this_claim_type_date.'_'.$this_beneficiary_date];
					$this_beneficiary_amount = $this_beneficiary_rate * $this_beneficiary_days_payable;
				
				}else{
					$this_beneficiary_days_payable = $_POST['days_worked_'.$this_claim_type_date.'_'.$this_beneficiary_date];
					$this_beneficiary_rate = 0;
					$this_beneficiary_amount = $this_claim_type_results['fixed_amount'];
					
				}
				
				
				
				if(!$_POST['beneficiary_active_'.$this_claim_type_date.'_'.$this_beneficiary_date] or !$this_beneficiary_amount){
					$delete_beneficiaries = mysqli_query($$module_connect,"delete from $claim_beneficiaries_table where claim_date = '$this_claim_date' and company_id = $company_id and type_date = '$this_claim_type_date' and agent_date = '$this_beneficiary_date'")or die(mysqli_error($$module_connect));
		
					$delete_approvals = mysqli_query($$module_connect,"delete from $approvals_table where claim_date = '$this_claim_date' and company_id = $company_id and type_date = '$this_claim_type_date' and beneficiary_date = '$this_beneficiary_date'")or die(mysqli_error($$module_connect));
					
				
				}else{
					$this_beneficiary_from_array = explode('/',$_POST['date_from_'.$this_claim_type_date.'_'.$this_beneficiary_date]);
					$this_beneficiary_from = mktime(0,0,0,$this_beneficiary_from_array[0],$this_beneficiary_from_array[1],$this_beneficiary_from_array[2]);
					
					$this_beneficiary_to_array = explode('/',$_POST['date_to_'.$this_claim_type_date.'_'.$this_beneficiary_date]);
					$this_beneficiary_to = mktime(23,59,59,$this_beneficiary_to_array[0],$this_beneficiary_to_array[1],$this_beneficiary_to_array[2]);
					
					$this_claim_beneficiary = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where agent_date = '$this_beneficiary_date' and type_date = '$this_claim_type_date' and claim_date = '$this_claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
					
					if(mysqli_num_rows($this_claim_beneficiary)){
						$this_claim_beneficiary_results = mysqli_fetch_array($this_claim_beneficiary,MYSQLI_ASSOC);
						
						if(($this_claim_beneficiary_results['amount'] != $this_beneficiary_amount or $this_claim_beneficiary_results['phone'] != $this_beneficiary_phone or $this_claim_beneficiary_results['nrc'] != $this_beneficiary_nrc or $this_claim_beneficiary_results['paid_days'] != $this_beneficiary_days_payable or $this_claim_beneficiary_results['rate'] != $this_beneficiary_rate or $this_claim_beneficiary_results['days'] != $this_beneficiary_days_worked or $this_claim_beneficiary_results['_from'] != $this_beneficiary_from or $this_claim_beneficiary_results['_to'] != $this_beneficiary_to) and $this_claim_beneficiary_results['status'] == 3){
							
							
							$delete_beneficiaries = mysqli_query($$module_connect,"update $claim_beneficiaries_table set amount = '$this_beneficiary_amount', phone = '$this_beneficiary_phone', nrc = '$this_beneficiary_nrc', paid_days = '$this_beneficiary_days_payable', days = '$this_beneficiary_days_worked', _from = '$this_beneficiary_from', _to = '$this_beneficiary_to' where claim_date = '$this_claim_date' and company_id = $company_id and type_date = '$this_claim_type_date' and agent_date = '$this_beneficiary_date'")or die(mysqli_error($$module_connect));

						}
					}
					
					if(!mysqli_num_rows($this_claim_beneficiary)){
						
						if($_POST['comment_'.$this_claim_type_date.'_'.$this_beneficiary_date] == ''){
							$this_beneficiary_comment = '';
							
						}else{
							$this_beneficiary_comment = str_replace("'","''",$_POST['comment_'.$this_claim_type_date.'_'.$this_beneficiary_date]);
						}
						
						
						$this_beneficiary_region_id = $_POST['beneficiary_region_'.$this_claim_type_date.'_'.$this_beneficiary_date];
						$this_beneficiary_province_id = $_POST['beneficiary_province_'.$this_claim_type_date.'_'.$this_beneficiary_date];
						$this_beneficiary_hub_id = $_POST['beneficiary_hub_'.$this_claim_type_date.'_'.$this_beneficiary_date];
						$this_beneficiary_site_id = $_POST['beneficiary_site_'.$this_claim_type_date.'_'.$this_beneficiary_date];;
						$this_beneficiary_name = str_replace("'","''",$_POST['beneficiary_name_'.$this_claim_type_date.'_'.$this_beneficiary_date]);
						
						$claim_beneficiary_date = $today.$c.$b;
						
						if($sql_string == ''){
							$sql_string = "(".$company_id.",'".$this_claim_date."',".$this_beneficiary_region_id.",".$this_beneficiary_province_id.",".$this_beneficiary_hub_id.",".$this_beneficiary_site_id.",'".$this_claim_type_date."','".$this_beneficiary_date."','".$this_beneficiary_name."','".$this_beneficiary_phone."','".$this_beneficiary_nrc."','".$beneficiary_rule_string."',".$this_beneficiary_days_worked.",'".$this_beneficiary_days_payable."','".$this_beneficiary_rate."','".$this_beneficiary_amount."','".$this_beneficiary_comment."','".$this_beneficiary_from."','".$this_beneficiary_to."',0,0,'".$claim_beneficiary_date."','".$claim_creation_date."',1)";
							
						}else{
							$sql_string .= ",(".$company_id.",'".$this_claim_date."',".$this_beneficiary_region_id.",".$this_beneficiary_province_id.",".$this_beneficiary_hub_id.",".$this_beneficiary_site_id.",'".$this_claim_type_date."','".$this_beneficiary_date."','".$this_beneficiary_name."','".$this_beneficiary_phone."','".$this_beneficiary_nrc."','".$beneficiary_rule_string."',".$this_beneficiary_days_worked.",'".$this_beneficiary_days_payable."','".$this_beneficiary_rate."','".$this_beneficiary_amount."','".$this_beneficiary_comment."','".$this_beneficiary_from."','".$this_beneficiary_to."',0,0,'".$claim_beneficiary_date."','".$claim_creation_date."',1)";
						
						}
						
						if($approval_string == ''){
							$approval_string = "($company_id,'".$this_claim_date."','".$this_claim_type_date."','".$this_beneficiary_date."','".$user_date."',0,1,'','','".$claim_creation_date."')";
							
						}else{
							$approval_string .= ",($company_id,'".$this_claim_date."','".$this_claim_type_date."','".$this_beneficiary_date."','".$user_date."',0,1,'','','".$claim_creation_date."')";
						}
					}					
				}
			}
		}
		
		if($sql_string != ''){
			$add_beneficiaries = mysqli_query($$module_connect,"insert into $claim_beneficiaries_table(company_id,claim_date,region_id,province_id,hub_id,site_id,type_date,agent_date,_name,phone,nrc,approval_rule_string,days,paid_days,rate,amount,comment,_from,_to,level,denied,_date,creation_date,status) VALUES $sql_string")or die(mysqli_error($$module_connect));
			
		}
		
		if($approval_string != ''){
			$add_approvals = mysqli_query($$module_connect,"insert into $approvals_table(company_id,claim_date,type_date,beneficiary_date,user_date,level,status,comment,file_src,_date) VALUES $approval_string")or die(mysqli_error($$module_connect));
		}
		
		print('create_or_update_claim~'.$_POST['claim_id']);
	}
	
	if(isset($_POST['fetch_edit_beneficiary_data'])){
		$claim_date = $_POST['claim_date'];
		$claim_type_date = $_POST['claim_type_date'];
		$agent_date = $_POST['agent_date'];
		$phone_number = $_POST['phone_number'];		
		
		
		$this_default_agents_partition_name = $default_partition_names[2][1][0];
		$this_default_phone_partition_name = $default_partition_names[2][1][1];
		
		$partitions = fetch_database_partitions(2,$agent_date,$agent_date);
		
		$agents_table = $this_default_agents_partition_name.'_partition_'.$partitions[0];
		$phone_number_table = $this_default_phone_partition_name.'_partition_'.$partitions[0];
		
		$phone_number_array = fetch_db_table('connect',$phone_number_table,$company_id,'id'," agent_date = '".$agent_date."'");
		
		$agents_table_array = fetch_db_table('connect',$agents_table,$company_id,'id'," _date = '".$agent_date."'");
		
		$phone_string = '';
		for($p=0;$p<count($phone_number_array['id']);$p++){
			
			$option_select = '';
			if($phone_number_array['phone_number'][$p] == $phone_number){
				$option_select = ' selected ';
			}
			
			if($phone_string == ''){
				$phone_string = '<option '.$option_select.'> '.$phone_number_array['phone_number'][$p].'</option>';
				
			}else{
				$phone_string .= '<option '.$option_select.'>'.$phone_number_array['phone_number'][$p].'</option>';
				
			}
		}
		$agent_name = str_replace("'","",$agents_table_array['_name'][0]);
		$agent_nrc = $agents_table_array['id_number'][0];
		$agent_id = $agents_table_array['id'][0];
		
		print('fetch_edit_beneficiary_data~'.$claim_date.'~'.$claim_type_date.'~'.$agent_date.'~'.$agent_id.'~'.$agent_name.'~'.$agent_nrc.'~'.$phone_string);
	}
	
	if(isset($_POST['process_change_claim_status'])){
		$claim_date = $_POST['claim_date'];
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];

		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$claim_date' and company_id = $company_id")or die(mysqlI_error($$module_connect));
		$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
		$old_status = $this_claim_results['status'];
		
		$new_status = $_POST['new_status'];
		$comment = str_replace("'","''",$_POST['comment']);
	
		$update_claim = mysqli_query($$module_connect,"update $payment_claims_table set status = $new_status, status_change_user = '$user_date', status_change_date = '$today', claim_old_status = $old_status, status_change_comment = '$comment' where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		if($new_status == 0){
			$update_claim_beneficiaries = mysqli_query($$module_connect,"update $claim_beneficiaries_table set status = 0 where claim_date = '$claim_date' and company_id = $company_id")or die(mysqlI_error($$module_connect));
			
		}
		
		print('process_change_claim_status~'.$claim_date);
	}
	
	if(isset($_POST['enable_claim'])){
		$claim_date = $_POST['claim_date'];
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];

		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$this_default_approval_partition_name = $default_partition_names[8][1][0];
		
		$approval_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
		
		$approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[0];
		
		$update_claim = mysqli_query($$module_connect,"update $payment_claims_table set status = 1 where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		$update_claim_beneficiaries = mysqli_query($$module_connect,"update $claim_beneficiaries_table set status = 1 where claim_date = '$claim_date' and company_id = $company_id")or die(mysqlI_error($$module_connect));
		
		$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
		
		$claim_type_array = explode(',',$this_claim_results['claim_type_date']);
		
		for($ct=0;$ct<count($claim_type_array);$ct++){
			$this_claim_type_date = $claim_type_array[$ct];
			
			$claim_approvals = mysqli_query($$module_connect,"select * from $approvals_table where type_date = '$this_claim_type_date' and claim_date = '$claim_date' and company_id = $company_id and status = 0 and validity = 1")or die(mysqlI_error($$module_connect));
			
			for($ca=0;$ca<mysqli_num_rows($claim_approvals);$ca++){
				$claim_approval_results = mysqli_fetch_array($claim_approvals,MYSQLI_ASSOC);
				$this_agent_date = $claim_approval_results['beneficiary_date'];
				
				$update_claim_beneficiaries = mysqli_query($$module_connect,"update $claim_beneficiaries_table set status = 3 where claim_date = '$claim_date' and type_date = '$this_claim_type_date' and agent_date = '$this_agent_date' and company_id = $company_id")or die(mysqlI_error($$module_connect));
				
			}
			
			$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
			$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
			
			$this_rule_string_array = explode(']',$this_claim_type_results['rule_string']);			
			$this_claim_type_last_level_index = count($this_rule_string_array) - 1;			
			
			$update_claim_beneficiaries = mysqli_query($$module_connect,"update $claim_beneficiaries_table set status = 2 where claim_date = '$claim_date' and type_date = '$this_claim_type_date' and agent_date = '$this_agent_date' and level = $this_claim_type_last_level_index and company_id = $company_id")or die(mysqlI_error($$module_connect));
		}
	
		print('enable_claim~'.$claim_date);
	}
	
	
	if(isset($_POST['fetch_claim_type_code'])){
		$status = $_POST['status'];
		
		print('fetch_claim_type_code~');
		include 'scripts/page_codes/_codes/claim_type_list_code.php';
	}
	
	if(isset($_POST['fetch_claim_type_details'])){
		$claim_type_id = $_POST['claim_type_id'];
		
		$this_claim_type = mysqli_query($$module_connect,"select * from claim_types where id = $claim_type_id")or die(mysqli_error($$module_connect));
		
		
		print('fetch_claim_type_details~');
		include 'scripts/page_codes/_codes/claim_type_code.php';
	}
	
	if(isset($_POST['check_date_error'])){
		
		$conflict_found = 0;
		$output_string = '';
		$claim_type_date = $_POST['claim_type_date'];
		$beneficiary_date = $_POST['beneficiary_date'];
		$claim_date = $_POST['claim_date'];
		
		
		$from_date = explode('/',$_POST['from_date']);
		$to_date = explode('/',$_POST['to_date']);
		
		$from_time_stamp = mktime(0,0,0,$from_date[0],$from_date[1],$from_date[2]);
		$to_time_stamp = mktime(23,59,59,$to_date[0],$to_date[1],$to_date[2]);
		
		if($from_time_stamp > $to_time_stamp){
			$conflict_found = 2;
			$output_string = '<strong>Error:</strong> The "From" date is ahead of the "To" date. This entry will be excluded.';
			
		}else{
			$check_beneficiary = mysqli_query($$module_connect,"select * from claim_beneficiaries where claim_date != $claim_date and company_id = $company_id and type_date = '$claim_type_date' and agent_date = '$beneficiary_date' and ((_from <= '$from_time_stamp' and _to >= '$from_time_stamp') || (_from <= '$to_time_stamp' and _to >= '$to_time_stamp') || (_from >= '$from_time_stamp' and _to <= '$to_time_stamp'))")or die(mysqli_error($$module_connect));
		
		
			if(mysqli_num_rows($check_beneficiary)){
				$conflict_found = 1;
				
				$claim_number_string = '';
				for($c=0;$c<mysqli_num_rows($check_beneficiary);$c++){
					$check_beneficiary_results = mysqli_fetch_array($check_beneficiary,MYSQLI_ASSOC);
					
					$beneficiary_claim_date = $check_beneficiary_results['claim_date'];
					$beneficiary_claim = mysqli_query($$module_connect,"select * from payment_claims where _date = '$beneficiary_claim_date' and company_id = $company_id");
					$beneficiary_claim_results = mysqli_fetch_array($beneficiary_claim,MYSQLI_ASSOC);
					
					if($claim_number_string == ''){
						$claim_number_string = $beneficiary_claim_results['claim_id'];
						
					}else{
						$claim_number_string .= ','.$beneficiary_claim_results['claim_id'];
						
					}
					
				}
					
				$output_string = '<font color="brown">We found one or more claims for this agent within the date period provided. The following are claim numbers: '.$claim_number_string.'</font>';
				
				//print($claim_number_string.'-');
				
			}
		}
		
		
		
		print('check_date_error~'.$conflict_found.'~'.$claim_type_date.'~'.$beneficiary_date.'~'.$output_string);
		
	
	}
	

	
	if(isset($_POST['process_level_confirm_queue'])){
		$approval_code = explode('}',$_POST['approval_code']);
		
		//print($_POST['approval_code']);
		
		$claim_date = $approval_code[0];
		$claim_type_date = $approval_code[1];
		$beneficiary_date = $approval_code[2];
		$claim_type_index = $approval_code[3];
		$level_index = $approval_code[4];
		$img_src = $approval_code[5];
		$reload = 0;
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];

		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$this_default_approval_partition_name = $default_partition_names[8][1][0];
		
		$approval_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
		
		$approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[0];
		
		
		$check_jump_approve = mysqli_query($$module_connect,"select * from $approvals_table where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and level > $level_index and goto_level = $level_index and jump_disaproval = 1 and (beneficiary_date = '$beneficiary_date' or beneficiary_date = 0) and validity = 1")or die(mysqli_error($$module_connect));
		
		if($beneficiary_date == 0){
			$update_rejecting_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 0, validity_change_user = '$user_date', validity_change_date = '$today' where company_id = $company_id and claim_date = '$claim_date' and type_date = '$claim_type_date' and goto_level = $level_index and status = 0")or die(mysqli_error($$module_connect));
			
			$update_waiting_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 1, validity_change_user = '$user_date', validity_change_date = '$today' where company_id = $company_id and claim_date = '$claim_date' and type_date = '$claim_type_date' and level > $level_index and validity = 2")or die(mysqli_error($$module_connect));
			
			$reload = 1;
			
		}else{
			$update_rejecting_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 0, validity_change_user = '$user_date', validity_change_date = '$today' where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and (beneficiary_date = '$beneficiary_date' or beneficiary_date = 0) and goto_level = $level_index and status = 0")or die(mysqli_error($$module_connect));
			
			$update_waiting_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 1, validity_change_user = '$user_date', validity_change_date = '$today' where company_id = $company_id and claim_date = '$claim_date' and type_date = '$claim_type_date' and level > $level_index and validity = 2 and (beneficiary_date = '$beneficiary_date' or beneficiary_date = 0)")or die(mysqli_error($$module_connect));
			
		}
		
		if(mysqli_num_rows($check_jump_approve)){
			$check_jump_approve_results = mysqli_fetch_array($check_jump_approve,MYSQLI_ASSOC);			
			$rejump_level = $check_jump_approve_results['level'];
			
			$mid_levels = $check_jump_approve_results['level'] - $level_index;
			
			for($rj=0;$rj<$mid_levels;$rj++){
				$this_level = $level_index+$rj;
				
				if($rj == 0){
					$approval_type = 0;
					
				}else{
					$approval_type = 1;
					
				}
				
				$add_approval = mysqli_query($$module_connect,"insert into $approvals_table (company_id,claim_date,type_date,beneficiary_date,user_date,level,goto_level,jump_disaproval,approval_type,status,comment,file_src,_date) VALUES($company_id,'$claim_date','$claim_type_date','$beneficiary_date',$user_date,$this_level,0,0,$approval_type,1,'','$img_src','$today')")or die(mysqli_error($$module_connect));
				
			}
				
		}else{
			$add_approval = mysqli_query($$module_connect,"insert into $approvals_table (company_id,claim_date,type_date,beneficiary_date,user_date,level,goto_level,jump_disaproval,approval_type,status,comment,file_src,_date) VALUES($company_id,'$claim_date','$claim_type_date','$beneficiary_date',$user_date,$level_index,0,0,0,1,'','$img_src','$today')")or die(mysqli_error($$module_connect));
			
		}
		
		$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
				
		$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
		$this_rule_string_array = explode(']',$this_claim_type_results['rule_string']);
		$total_level_index = count($this_rule_string_array)-1;
		
		if($total_level_index == $level_index){
			$beneficiary_status = 2;
			
		}else{
			$beneficiary_status = 1;
			
		}
		
		if($beneficiary_date == 0){
			$update_claim_beneficiary = mysqli_query($$module_connect,"update $claim_beneficiaries_table set level = $level_index, status = $beneficiary_status where type_date = '$claim_type_date' and claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		}else{
			$update_claim_beneficiary = mysqli_query($$module_connect,"update $claim_beneficiaries_table set level = $level_index, status = $beneficiary_status where agent_date = '$beneficiary_date' and type_date = '$claim_type_date' and claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
			
		}
		
		$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
		
		$hide = 0;
		$check_higher_approvals = mysqli_query($$module_connect,"select * from $approvals_table where claim_date = '$claim_date' and level > $level_index and status = 1 and validity = 1 order by level desc")or die(mysqli_error($$module_connect));
		
		if(!mysqli_num_rows($check_higher_approvals)){
			$claim_types = explode(',',$this_claim_results['claim_type_date']);
			
			$all_complete = 1;
			for($ct=0;$ct<count($claim_types);$ct++){
				$this_claim_type_date = $claim_types[$ct];
				
				$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
				
				$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
				
				$this_claim_levels = explode(']',$this_claim_type_results['rule_string']);
				$claim_type_last_level_index = count($this_claim_levels)-1;
				
				$less_claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where level < $claim_type_last_level_index and type_date = '$this_claim_type_date' and claim_date = '$claim_date'")or die(mysqli_error($$module_connect));
				
				if(mysqli_num_rows($less_claim_beneficiaries)){
					$all_complete = 0;
					break;
				}
			}
			
			if(!$all_complete){
				
				$check_rejections_approvals = mysqli_query($$module_connect,"select * from $approvals_table where company_id = $company_id and claim_date = '$claim_date' and status = 0 and validity = 1 order by level desc")or die(mysqli_error($$module_connect));
				
				if(!mysqli_num_rows($check_rejections_approvals)){
					
					$claim_update_string = ' set status = 1, level = '.$level_index;
					
					if($this_claim_results['status'] != 1){
						$hide = 1;
						
					}
				
				}else{
					$claim_update_string = ' set level = '.$level_index;
					$hide = 0;
				}
				
			}else{
				$claim_update_string = 'set status = 2, level = '.$level_index;
				$hide = 1;
			}
			
		}else{
			$check_rejections_approvals = mysqli_query($$module_connect,"select * from $approvals_table where company_id = $company_id and claim_date = '$claim_date' and status = 0 and validity = 1 order by level desc")or die(mysqli_error($$module_connect));
				
			if(!mysqli_num_rows($check_rejections_approvals)){
				$claim_update_string = ' set status = 1';
				
				if($this_claim_results['status'] != 1){
					$hide = 1;
					
				}
			}else{
				$claim_update_string = ' set status = 3';
				$hide = 0;
			}
		}
		
		$update_claim = mysqli_query($$module_connect,"update $payment_claims_table $claim_update_string where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		if($_POST['total_in_queue'] == 1){
			$this_level_rule = explode(',',$this_rule_string_array[$level_index]);
			
			if($this_level_rule[9]){
				$claim_user_date = $this_claim_results['user_date'];
				
				$claim_creator = mysqli_query($connect,"select * from users where _date = '$claim_user_date' and company_id = $company_id")or die(mysqli_error($connect));
				$claim_creater_results = mysqli_fetch_array($claim_creator,MYSQLI_ASSOC);
				
				$creator_roles = $claim_creater_results['roles'];
				
				if($creator_roles[11] and $claim_creater_results['email'] != ''){
					$message = 'Hi '.$claim_creater_results['_name'].',<br><br>We wish to inform you that the claim you created of number '.$this_claim_results['claim_id'].' has been approved on level '.($level_index+1).', by '.$user_results['_name'].'. If necessary, please remind the next approver to approve the next level so that the payment can be processed quickly.<br><br><br>Systems Development Unit';
					
					$add_message_queue = mysqli_query($connect,"insert into mail_send_queue (company_id,from_email,from_name,to_email,message_subject,message_body,option_attributes,send_time,user_date,_date) VALUES($company_id,'support@blueraysit.org','PIPAT Claims Tracker 2.0','".$claim_creater_results['email']."','Level ".($level_index+1)." approved for claim number ".$this_claim_results['claim_id']."','$message','','0','$user_date','$today')")or die(mysqli_error($connect));
					
				}
				
			}		
		}
		
		print('process_level_confirm_queue~'.$claim_date.'~'.$claim_type_date.'~'.$beneficiary_date.'~'.$claim_type_index.'~'.$level_index.'~'.$img_src.'~'.$hide.'~'.$reload);
	}
	
	if(isset($_POST['fetch_rejection_options'])){
		$claim_date = $_POST['claim_date'];
		$claim_type_date = $_POST['claim_type_date'];
		$beneficiary_date = $_POST['beneficiary_date'];
		$level_index = $_POST['level_index'];
		
		$claim_type_index = $_POST['claim_type_index'];
		$request_type = $_POST['request_type'];
		$action_type = $_POST['action_type'];
		
		print('fetch_rejection_options~');
		include 'scripts/page_codes/_codes/level_rejection_options.php';
	}
	
	if(isset($_POST['change_claim_status'])){
		$claim_date = $_POST['claim_date'];
		
		print('change_claim_status~');
		include 'scripts/page_codes/_codes/claim_status_change_options.php';
	}
	
	if(isset($_POST['process_level_reject_queue'])){
		$approval_code = explode('}',$_POST['rejection_code']);
		
		//print($_POST['approval_code']);
		
		$claim_date = $approval_code[0];
		$claim_type_date = $approval_code[1];
		$beneficiary_date = $approval_code[2];
		$claim_type_index = $approval_code[3];
		$level_index = $approval_code[4];
		$img_src = $approval_code[5];
		$goto_level = $approval_code[6];
		$re_approval = $approval_code[7];
		$rejection_comment = str_replace("'","''",$approval_code[8]);
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];

		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$this_default_approval_partition_name = $default_partition_names[8][1][0];
		
		$approval_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
		
		$approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[0];
		
		$add_approval = mysqli_query($$module_connect,"insert into $approvals_table (company_id,claim_date,type_date,beneficiary_date,user_date,level,goto_level,jump_disaproval,approval_type,status,comment,file_src,_date) VALUES($company_id,'$claim_date','$claim_type_date','$beneficiary_date',$user_date,$level_index,$goto_level,$re_approval,0,0,'$rejection_comment','$img_src','$today')")or die(mysqli_error($$module_connect));
		
		$reload = 0;
		if($beneficiary_date == 0){
			$update_jump_level = mysqli_query($$module_connect,"update $approvals_table set validity = 0, validity_change_user = '$user_date', validity_change_date = '$today' where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and level = $goto_level")or die(mysqli_error($$module_connect));
			
			$reload = 1;
			
			$update_beneficiary_status = mysqli_query($$module_connect,"update $claim_beneficiaries_table set status = 3, level = $goto_level where company_id = $company_id and claim_date = '$claim_date' and type_date = '$claim_type_date'")or die(mysqli_error($$module_connect));
			
		}else{
			$update_jump_level = mysqli_query($$module_connect,"update $approvals_table set validity = 0, validity_change_user = '$user_date', validity_change_date = '$today' where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and level = $goto_level and (beneficiary_date = '$beneficiary_date' or beneficiary_date = 0)")or die(mysqli_error($$module_connect));
			
			$update_beneficiary_status = mysqli_query($$module_connect,"update $claim_beneficiaries_table set status = 3, level = $goto_level where company_id = $company_id and claim_date = '$claim_date' and type_date = '$claim_type_date' and agent_date = '$beneficiary_date'")or die(mysqli_error($$module_connect));
		}
		
		
		if($re_approval == 0){
			if($beneficiary_date == 0){
				$add_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 0, validity_change_user = '$user_date', validity_change_date = '$today' where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and level > $goto_level and level != $level_index and validity = 1")or die(mysqli_error($$module_connect));
				
			}else{
				$add_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 0, validity_change_user = '$user_date', validity_change_date = '$today' where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and level > $goto_level and level != $level_index and (beneficiary_date = '$beneficiary_date' or beneficiary_date = 0) and validity = 1")or die(mysqli_error($$module_connect));
				
			}
		}else{
			if($beneficiary_date == 0){
				$add_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 2, validity_change_user = '$user_date', validity_change_date = '$today' where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and level > $goto_level  and level != $level_index and validity = 1")or die(mysqli_error($$module_connect));
				
			}else{
				$add_approval = mysqli_query($$module_connect,"update $approvals_table set validity = 2, validity_change_user = '$user_date', validity_change_date = '$today' where claim_date = '$claim_date' and company_id = $company_id and type_date = '$claim_type_date' and level > $goto_level and level != $level_index and (beneficiary_date = '$beneficiary_date' or beneficiary_date = 0) and validity = 1 ")or die(mysqli_error($$module_connect));
				
			}			
		}
		
		$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
		
		$user_date = $this_claim_results['user_date'];
		$this_user = mysqli_query($connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($connect));
		
		if(mysqli_num_rows($this_user)){
			$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
			
			if($this_user_results['email'] != ''){
				$user_email = explode(',',$this_user_results['email']);
					
				$message = 'Hi, '.$this_user_results['_name'].',<br><br> '.$user_results['_name'].' has rejected claim '.$this_claim_results['claim_id'].' on level '.($level_index+1).' with the following comment:<br><strong>'.$rejection_comment.'</strong><br><br>Please work on this as soon as you can.<br>Have a good day<br><br>PIPAT 2.0';
				
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "replyTo:support@pipatzambia.org\r\n";
				$headers .= 'From: PIPAT 2.0'.'<support@pipatzambia.org>' . "\r\n";
				
				mail($user_email[0],'Claim rejected - '.$this_claim_results['claim_id'],$message,$headers);
			}
		}
		
		$check_higher_approvals = mysqli_query($$module_connect,"select * from $approvals_table where claim_date = '$claim_date' and level > $goto_level and status = 1 and validity = 1 order by level desc")or die(mysqli_error($$module_connect));
		
		if(mysqli_num_rows($check_higher_approvals)){
			$check_higher_approval_results = mysqli_fetch_array($check_higher_approvals,MYSQLI_ASSOC);			
			$new_claim_level = $check_higher_approval_results['level'];
			
		}else{
			$new_claim_level = $goto_level;
			
		}
		
		$hide = 0;
		if($this_claim_results['status'] != 3){
			$claim_update_string = 'set status = 3, level = '.$new_claim_level;
			$hide = 1;
			
		}else{
			$claim_update_string = 'set level = '.$new_claim_level;
			
		}
		
		$update_claim = mysqli_query($$module_connect,"update $payment_claims_table $claim_update_string where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		
		$complete=0;
		print('process_level_reject_queue~'.$claim_date.'~'.$claim_type_date.'~'.$beneficiary_date.'~'.$claim_type_index.'~'.$level_index.'~'.$img_src.'~'.$complete.'~'.$goto_level.'~'.$reload.'~'.$hide);
	}
	
	if(isset($_POST['generate_claim_csv'])){
		$claim_date = $_POST['claim_date'];
		$ascension_ind = $_POST['ascension_ind'];
		$claim_id = $_POST['claim_id'];
		
		$columns_array = array('Name','Last_Name','ID_Type','ID_Number','amount','Cell_Number','Reference');
		$formating_array = array(0,0,0,0,0,0,0,0);
		
		$this_default_agent_name = $default_partition_names[2][1][0];
		
		$agent_start = mktime(0,0,0,1,1,2015);
		$agent_end = time();
		
		/*
		$agent_partitions = fetch_database_partitions(2,$agent_start,$agent_start);
		
		$agents_array = array();
		for($ap=0;$ap<count($agent_partitions);$ap++){
			$this_agent_table = $this_default_agent_name.'_partition_'.$agent_partitions[$ap];
			
			$agents_array[$ap] = fetch_db_table('connect',$this_agent_table,$company_id,'id','');
		}
		
		$genders = mysqli_query($connect,"select * from genders")or die(mysqli_error($connect));
		
		$gender_id_array = array();
		$gender_title_array = array();
		for($g=0;$g<mysqli_num_rows($genders);$g++){
			$gender_results = mysqli_fetch_array($genders,MYSQLI_ASSOC);
			
			$gender_id_array[$g] = $gender_results['id'];
			$gender_title_array[$g] = $gender_results['title'];
			
		}*/
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$this_default_ascension_partition_name = $default_partition_names[7][1][2];

		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$claim_ascension_table = $this_default_ascension_partition_name.'_partition_'.$partitions[0];
		
		$this_default_approval_partition_name = $default_partition_names[8][1][0];
		
		$approval_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
		
		$approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[0];
			
		$these_ascension_beneficiaries = mysqli_query($$module_connect,"select * from $claim_ascension_table where claim_date = '$claim_date' and ascension_ind = $ascension_ind")or die(mysqli_error($$module_connect));
		
		$row_array = array();
		$this_beneficiary_gender = 1;
		for($tb=0;$tb<mysqli_num_rows($these_ascension_beneficiaries);$tb++){
			$these_ascension_beneficiary_results = mysqli_fetch_array($these_ascension_beneficiaries,MYSQLI_ASSOC);
			
			$this_agent_date = $these_ascension_beneficiary_results['agent_date'];
			$this_agent_type_date = $these_ascension_beneficiary_results['type_date'];
			
			$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where agent_date = '$this_agent_date' and claim_date = '$claim_date' and type_date = '$this_agent_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));

			$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
			
			/*
			for($ap=0;$ap<count($agent_partitions);$ap++){
				$this_agent_index = array_keys($agents_array[$ap]['_date'],$this_agent_date);
				
				if(isset($this_agent_index[0])){
					$this_beneficiary_gender = $agents_array[$ap]['gender'][$this_agent_index[0]];
					break;
				}
			}
			
			
			$gender_index = array_keys($gender_id_array,$this_beneficiary_gender);
			
			
			$this_gender_title = $gender_title_array[$gender_index[0]];
			*/
			
			$beneficiary_name = explode(' ',$claim_beneficiary_results['_name']);
			
			if(!isset($beneficiary_name[1])){
				$beneficiary_name[1] = '';
				
			}
			
			$row_array[count($row_array)] = array($beneficiary_name[0],$beneficiary_name[1],'NRC',$claim_beneficiary_results['nrc'],$claim_beneficiary_results['amount'],$claim_beneficiary_results['phone'],$claim_id);
		} 
		
		$file_name = new_excel_export($columns_array,$row_array,$formating_array);
		
		print('generate_claim_csv~'.$claim_date.'~'.$file_name);
	}
	
	
	if(isset($_POST['fetch_request_type_agent'])){
		$search_key = str_replace("'","''",$_POST['search_key']);
		
		print('fetch_request_type_agent~');
		include 'scripts/page_codes/_codes/request_type_agents.php';
	}
	
	if(isset($_POST['fetch_claim_schedule'])){
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		
		$claim_type_id = $_POST['claim_type_id'];
		
		$from_date = explode('/',$_POST['date_from']);
		$to_date = explode('/',$_POST['date_to']);
		
		$from_date = mktime(0,0,0,$from_date[0],$from_date[1],$from_date[2]);
		$to_date = mktime(23,59,59,$to_date[0],$to_date[1],$to_date[2]);
		
		$search_string = '';
		
		if($region_id != 0){
			$search_string .= ' and (region_id = 0 or region_id = '.$region_id.')';
			
		}
				
		if($province_id != 0){
			$search_string .= ' and (province_id = 0 or province_id = '.$province_id.')';
			
		}
		
		if($hub_id != 0){
			$search_string .= ' and (hub_id = 0 or hub_id = '.$hub_id.')';
			
		}
		
		if($claim_type_id != 0){
			$search_string .= " and claim_type_date LIKE '%".$claim_type_id."'";
			
		}
		
		
		
		$status_string = ' and (status = 1)';
			
		
		
		$search_string .= $status_string;
		
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
		
		$users = mysqli_query($connect,"select * from users where company_id = $company_id")or die(mysqli_error($connect));
		$users_id_array = array();
		$users_name_array = array();
		for($u=0;$u<mysqli_num_rows($users);$u++){
			$user_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
			
			$user_id_array[$u] = $user_results['id'];
			$user_name_array[$u] = $user_results['_name'];
			$user_date_array[$u] = $user_results['_date'];
			$user_phone_array[$u] = $user_results['phone'];
		}
		
		$claim_types = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id")or die(mysqli_error($$module_connect));
		
		for($c=0;$c<mysqli_num_rows($claim_types);$c++){
			$claim_type_results = mysqli_fetch_array($claim_types,MYSQLI_ASSOC);
			
			$claim_type_id_array[$c] = $claim_type_results['id'];
			$claim_type_title_array[$c] = $claim_type_results['title'];
			$claim_type_date_array[$c] = $claim_type_results['_date'];	
			
			$levels_array = explode(']',$claim_type_results['rule_string']);
			$claim_type_total_levels_array[$c] = count($levels_array);				
		}
		
		print('fetch_claim_schedule~');
		include 'scripts/page_codes/_codes/claim_schedule_code.php';	
		
	}
	
	if(isset($_POST['fetch_awaiting_beneficiaries'])){
		print('fetch_awaiting_beneficiaries[]');
		
		if($_POST['_type'] == 0){
			$meeting_id = $_POST['awaiting_date'];
			$this_meeting = mysqli_query($connect,"select * from meetings where id = '$meeting_id'")or die(mysqli_error($$module_connect));
			$this_meeting_results = mysqli_fetch_array($this_meeting,MYSQLI_ASSOC);
			$this_meeting_date = $this_meeting_results['_date'];
			
			include 'scripts/page_codes/_codes/meeting_awaiting_beneficiaries.php';
			
		}else{
			$claim_date = $_POST['awaiting_date'];
			$this_claim = mysqli_query($$module_connect,"select * from tmp_payment_claims where _date = '$claim_date'")or die(mysqli_error($$module_connect));
			$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
			$this_claim_date = $this_claim_results['_date'];
			
			include 'scripts/page_codes/_codes/awaiting_beneficiaries.php';
		}
	}
	
	if(isset($_POST['fetch_awaiting_creation_claims'])){
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		
		$from_date = explode('/',$_POST['date_from']);
		$to_date = explode('/',$_POST['date_to']);
		
		$from_date = mktime(0,0,0,$from_date[0],$from_date[1],$from_date[2]);
		$to_date = mktime(23,59,59,$to_date[0],$to_date[1],$to_date[2]);

		$search_string = '';
		if($region_id != 0){
			$search_string .= ' and region_id = '.$region_id;
			
		}
				
		if($province_id != 0){
			$search_string .= ' and province_id = '.$province_id;
			
		}
		
		if($hub_id != 0){
			$search_string .= ' and hub_id = '.$hub_id;
			
		}
		
		$meetings_search_string = $search_string;
		
		$search_string = ' and (claim_date >= '.$from_date.' and claim_date <= '.$to_date.')'.$search_string; 
		
		
		print('fetch_awaiting_creation_claims~');
		include 'scripts/page_codes/_codes/awaiting_creation_code.php';
	}
	
	if(isset($_POST['create_claim_from_awaiting'])){
		$claim_date = $_POST['claim_date'];
		
		$tmp_claim_beneficiaries = mysqli_query($$module_connect,"select * from tmp_claim_beneficiaries where claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		//$claim_beneficiaries = '';
		$beneficiary_query_string = '';
		for($b=0;$b<mysqli_num_rows($tmp_claim_beneficiaries);$b++){
			$tmp_claim_beneficiary_results = mysqli_fetch_array($tmp_claim_beneficiaries,MYSQLI_ASSOC);
			
			if($tmp_claim_beneficiary_results['amount'] != 0){
				if($beneficiary_query_string == ''){
					$beneficiary_query_string = "(".$tmp_claim_beneficiary_results['company_id'].",'|claim_date|',".$tmp_claim_beneficiary_results['region_id'].",".$tmp_claim_beneficiary_results['province_id'].",".$tmp_claim_beneficiary_results['hub_id'].",".$tmp_claim_beneficiary_results['mother_facility_id'].",".$tmp_claim_beneficiary_results['site_id'].",'".$tmp_claim_beneficiary_results['type_date']."','".$tmp_claim_beneficiary_results['agent_date']."','".str_replace("'","''",$tmp_claim_beneficiary_results['_name'])."','".$tmp_claim_beneficiary_results['phone']."','".$tmp_claim_beneficiary_results['nrc']."','','".$tmp_claim_beneficiary_results['days']."','".$tmp_claim_beneficiary_results['paid_days']."','".$tmp_claim_beneficiary_results['rate']."','".$tmp_claim_beneficiary_results['amount']."','".$tmp_claim_beneficiary_results['comment']."','".$tmp_claim_beneficiary_results['_from']."','".$tmp_claim_beneficiary_results['_to']."',0,0,'".$today."','".$today."',3)";
					
				}else{
					$beneficiary_query_string .= ','."(".$tmp_claim_beneficiary_results['company_id'].",'|claim_date|',".$tmp_claim_beneficiary_results['region_id'].",".$tmp_claim_beneficiary_results['province_id'].",".$tmp_claim_beneficiary_results['hub_id'].",".$tmp_claim_beneficiary_results['mother_facility_id'].",".$tmp_claim_beneficiary_results['site_id'].",'".$tmp_claim_beneficiary_results['type_date']."','".$tmp_claim_beneficiary_results['agent_date']."','".str_replace("'","''",$tmp_claim_beneficiary_results['_name'])."','".$tmp_claim_beneficiary_results['phone']."','".$tmp_claim_beneficiary_results['nrc']."','','".$tmp_claim_beneficiary_results['days']."','".$tmp_claim_beneficiary_results['paid_days']."','".$tmp_claim_beneficiary_results['rate']."','".$tmp_claim_beneficiary_results['amount']."','".$tmp_claim_beneficiary_results['comment']."','".$tmp_claim_beneficiary_results['_from']."','".$tmp_claim_beneficiary_results['_to']."',0,0,'".$today."','".$today."',3)";
					
				}
			}
		}

		if($beneficiary_query_string != ''){
			$tmp_payment_claim = mysqlI_query($$module_connect,"select * from tmp_payment_claims where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
					
			$tmp_payment_claim_results = mysqli_fetch_array($tmp_payment_claim,MYSQLI_ASSOC);
			
			$tmp_region_id = $tmp_payment_claim_results['region_id'];
			$tmp_province_id = $tmp_payment_claim_results['province_id'];
			$tmp_hub_id = $tmp_payment_claim_results['hub_id'];
			$tmp_mother_facility_id = $tmp_payment_claim_results['mother_facility_id'];
			$tmp_site_id = $tmp_payment_claim_results['site_id'];
			$tmp_claim_type_date = $tmp_payment_claim_results['claim_type_date'];
			$tmp_beneficiaries = $tmp_payment_claim_results['beneficiaries'];
			$tmp_amount = $tmp_payment_claim_results['amount'];
			
			$check_claim_id = mysqli_query($$module_connect,"select * from payment_claims where company_id = $company_id order by claim_id desc")or die(mysqli_error($$module_connect));
			$check_claim_id_results = mysqli_fetch_array($check_claim_id,MYSQLI_ASSOC);
			
			$new_claim_id = $check_claim_id_results['claim_id']+1;
			
			$add_payment_claim = mysqli_query($$module_connect,"insert into payment_claims (company_id,claim_date,region_id,province_id,hub_id,mother_facility_id,site_id,unit_id,claim_type_date,amount,paid,level,beneficiaries,user_date,file_src,_date,status,claim_id,ascensions,ascension_dates,ascension_user_dates,status_change_user,claim_old_status,status_change_date,status_change_comment) VALUES($company_id,'$today',$tmp_region_id,$tmp_province_id,$tmp_hub_id,$tmp_mother_facility_id,$tmp_site_id,0,'$tmp_claim_type_date','$tmp_amount','',0,'$tmp_beneficiaries','$user_date','','$today',3,$new_claim_id,0,'','','',0,'','')")or die(mysqli_error($$module_connect));
			
			$added_claim = mysqli_query($$module_connect,"select * from payment_claims where company_id = $company_id order by id desc")or die(mysqli_error($$module_connect));
			
			$added_claim_results = mysqlI_fetch_array($added_claim,MYSQLI_ASSOC);
			
			$added_claim_date = $added_claim_results['_date'];
			
			$beneficiary_query_string = str_replace('|claim_date|',$added_claim_date,$beneficiary_query_string);
			
			//print($beneficiary_query_string);
			
			$add_claim_beneficiaries = mysqli_query($$module_connect,"insert into claim_beneficiaries (company_id,claim_date,region_id,province_id,hub_id,mother_facility_id,site_id,type_date,agent_date,_name,phone,nrc,approval_rule_string,days,paid_days,rate,amount,comment,_from,_to,level,denied,_date,creation_date,status) VALUES $beneficiary_query_string")or die(mysqli_error($$module_connect));
		}
		
		$delete_awaiting_creation = mysqli_query($$module_connect,"delete from tmp_payment_claims where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$delete_tmp_beneficiaries = mysqli_query($$module_connect,"delete from tmp_claim_beneficiaries where claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		print('create_claim_from_awaiting[]'.$claim_date);
	}
	
	if(isset($_POST['delete_awaiting_claim'])){
		$claim_date = $_POST['claim_date'];
		
		$delete_awaiting_creation = mysqli_query($$module_connect,"delete from tmp_payment_claims where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$delete_tmp_beneficiaries = mysqli_query($$module_connect,"delete from tmp_claim_beneficiaries where claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		print('delete_awaiting_claim[]'.$claim_date);
	}
	
	if(isset($_POST['fetch_claim_schedule_details'])){
		$schedule_id = $_POST['schedule_id'];
		
		
		print('fetch_claim_schedule_details~');
		include 'scripts/page_codes/_codes/claim_schedule_details_code.php';
	}
	
	if(isset($_POST['create_or_update_schedule_type'])){
		$schedule_id = $_POST['schedule_id'];
		$scheduler_trigger = $_POST['scheduler_trigger'];
		$trigger_day = $_POST['trigger_day'];
		$trigger_month_day = $_POST['trigger_month_day'];
		$scheduler_payment_from_date_day = $_POST['scheduler_payment_from_date_day'];
		$scheduler_payment_from_date_month = $_POST['scheduler_payment_from_date_month'];
		$scheduler_payment_from_date_month_operator = $_POST['scheduler_payment_from_date_month_operator'];
		$scheduler_payment_from_date_month_addition = $_POST['scheduler_payment_from_date_month_addition'];
		
		$scheduler_payment_to_date_day = $_POST['scheduler_payment_to_date_day'];
		$scheduler_payment_to_date_month = $_POST['scheduler_payment_to_date_month'];
		$scheduler_payment_to_date_month_operator = $_POST['scheduler_payment_to_date_month_operator'];
		$scheduler_payment_to_date_month_addition = $_POST['scheduler_payment_to_date_month_addition'];
		
		$claim_payment_dates = $scheduler_payment_from_date_day.']'.$scheduler_payment_from_date_month.']'.$scheduler_payment_from_date_month_operator.']'.$scheduler_payment_from_date_month_addition.'|'.$scheduler_payment_to_date_day.']'.$scheduler_payment_to_date_month.']'.$scheduler_payment_to_date_month_operator.']'.$scheduler_payment_to_date_month_addition;
		
		$scheduler_recurrence = $_POST['scheduler_recurrence'];
		$scheduler_schedule_type = $_POST['scheduler_schedule_type'];
		$scheduler_location_depth = $_POST['scheduler_location_depth'];
		$scheduler_unknown_locations = $_POST['scheduler_unknown_locations'];
		$scheduler_days_worked_id = $_POST['scheduler_days_worked_id'];
		$scheduler_force_days = $_POST['scheduler_force_days'];
		$scheduler_force_days_justification = str_replace("'","''",$_POST['scheduler_force_days_justification']);
		$scheduler_schedule_rule = $_POST['scheduler_schedule_rule'];
		$scheduler_beneficiary_type = $_POST['scheduler_beneficiary_type'];
		$scheduler_agent_groups = $_POST['scheduler_agent_groups'];
		$scheduler_agent_units = $_POST['scheduler_agent_units'];
		$scheduler_custom_agent = $_POST['scheduler_custom_agents'];
		$scheduler_execution_notification = $_POST['scheduler_execution_notification']; 
		
		$this_request_type_date = $_POST['request_type_dates'];
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		$mother_facility_id = $_POST['mother_facility_id'];
		$site_id = $_POST['site_id'];
		
		if(!$schedule_id){
			$add_request_type_scheduler = mysqli_query($$module_connect,"insert into request_type_scheduler (company_id,_type,request_type_dates,claim_payment_dates,trigger_type_id,specific_day_trigger,trigger_month_day,recurrence,schedule_type,location_depth,unspecified_locations,force_days_worked,days_worked,justification_message,schedule_rule,beneficiary_type,beneficiary_group_id,beneficiary_unit_id,specific_agent_ids,email_on_exec,region_id,province_id,hub_id,mother_facility_id,site_id,user_date,_date) VALUES($company_id,1,'$this_request_type_date','$claim_payment_dates',$scheduler_trigger,'$trigger_day',$trigger_month_day,$scheduler_recurrence,$scheduler_schedule_type,$scheduler_location_depth,$scheduler_unknown_locations,$scheduler_days_worked_id,$scheduler_force_days,'$scheduler_force_days_justification',$scheduler_schedule_rule,$scheduler_beneficiary_type,'$scheduler_agent_groups',$scheduler_agent_units,'$scheduler_custom_agent',$scheduler_execution_notification,$region_id,$province_id,$hub_id,$mother_facility_id,$site_id,'$user_date','$today')")or die(mysqli_error($$module_connect));
			
		}else{
			$update_request_type_scheduler = mysqli_query($$module_connect,"update request_type_scheduler set request_type_dates = '$this_request_type_date', claim_payment_dates = '$claim_payment_dates',trigger_type_id = $scheduler_trigger,specific_day_trigger = '$trigger_day',trigger_month_day = $trigger_month_day,recurrence = $scheduler_recurrence,schedule_type = $scheduler_schedule_type,location_depth = $scheduler_location_depth,unspecified_locations = $scheduler_unknown_locations,force_days_worked = $scheduler_days_worked_id,days_worked = $scheduler_force_days,justification_message = '$scheduler_force_days_justification',schedule_rule = $scheduler_schedule_rule,beneficiary_type = $scheduler_beneficiary_type,beneficiary_group_id = '$scheduler_agent_groups',beneficiary_unit_id = $scheduler_agent_units,specific_agent_ids = '$scheduler_custom_agent',email_on_exec = $scheduler_execution_notification,region_id = $region_id,province_id = $province_id,hub_id = $hub_id,mother_facility_id=$mother_facility_id,site_id=$site_id where id =  $schedule_id")or die(mysqli_error($$module_connect));
		}
		
		print('create_or_update_schedule_type~');
	}
	
	if(isset($_POST['delete_schedule_type'])){
		$schedule_id = $_POST['schedule_id'];
		$delete_request_scheduler = mysqli_query($$module_connect,"delete from request_type_scheduler where id = $schedule_id")or die(mysqli_error($$module_connect));
		
		print('delete_schedule_type~');
	}
	
	if(isset($_POST['run_spreadsheet_beneficiary_queue'])){
		$ascension_ind = $_POST['ascension_ind'];
		$type_date = $_POST['claim_type_date'];
		$claim_date = $_POST['claim_date'];
		$new_status = $_POST['new_status'];
		$beneficiary_date = $_POST['beneficiary_date'];
		
		$error = '';
		if($new_status == 1){
			$check_other_ascension_beneficiaries = mysqli_query($$module_connect,"select * from ascension_beneficiaries where claim_date = '$claim_date' and agent_date = '$beneficiary_date' and type_date = '$type_date' and status = 1")or die(mysqlI_error($$module_connect));
			
			if(mysqli_num_rows($check_other_ascension_beneficiaries)){
				$check_other_ascension_beneficiary_results = mysqli_fetch_array($check_other_ascension_beneficiaries,MYSQLI_ASSOC);
				
				$error = 'Could not change this beneficiary status because they are appearing on another spreadsheet';
				
			}else{
				$update_ascension_beneficiaries = mysqli_query($$module_connect,"update ascension_beneficiaries set status = $new_status where claim_date = '$claim_date' and type_date = '$type_date' and agent_date = '$beneficiary_date' and ascension_ind = $ascension_ind")or die(mysqli_error($$module_connect));
			}
			
		}else{
			$update_ascension_beneficiaries = mysqli_query($$module_connect,"update ascension_beneficiaries set status = $new_status where claim_date = '$claim_date' and type_date = '$type_date' and agent_date = '$beneficiary_date' and ascension_ind = $ascension_ind")or die(mysqli_error($$module_connect));
			
		}
		
		print('run_spreadsheet_beneficiary_queue~'.$claim_date.'~'.$ascension_ind.'~'.$beneficiary_date.'~'.$type_date.'~'.$new_status.'~'.$error.'~'.$_POST['spreadsheet_identifier']);
	}
	
	if(isset($_POST['search_creator_users'])){
		include '../common_data_loop.php';
		$search_key = str_replace("'","''",$_POST['search_key']);
		
		$this_users = mysqli_query($connect,"select * from users where _name like '%$search_key%' and company_id = $company_id")or die(mysqli_error($connect));
		
		$output_string = '';
		if(mysqli_num_rows($this_users)){
			
			for($u=0;$u<mysqli_num_rows($this_users);$u++){
				$this_users_results = mysqli_fetch_array($this_users,MYSQLI_ASSOC);
				
				$output_string .= '<div style="cursor:pointer;width:100%;height:20px;float:left;line-height:20px;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor=\'#eee\'" onmouseout="this.style.backgroundColor=\'\'" onclick="$(\'#search_creator_selection_holder\').slideUp(\'fast\'); $(\'#creator_selection_holder\').slideDown(\'fast\');$(\'#active_creator\').html(\''.$this_users_results['_name'].'\');$(\'#selected_creator\').val('.$this_users_results['_date'].')">'.$this_users_results['_name'].'</div>';
					
			}		
			
		}else{
			$output_string = '<div style="width:100%;height:20px;float:left;line-height:20px;color:brown;font-weight:bold;text-align:center;">No results were found '.$search_key.'</div>';
			
			
		}
		
		
		print('search_creator_users~'.$output_string);
	}
	
	if(isset($_POST['search_allocation_users'])){
		include '../common_data_loop.php';
		$search_key = str_replace("'","''",$_POST['search_key']);
		$_type = $_POST['_type'];
		
		$this_users = mysqli_query($connect,"select * from users where _name like '%$search_key%' and company_id = $company_id")or die(mysqli_error($connect));
		
		$output_string = '';
		if(mysqli_num_rows($this_users)){
			
			for($u=0;$u<mysqli_num_rows($this_users);$u++){
				$this_users_results = mysqli_fetch_array($this_users,MYSQLI_ASSOC);
				
				if(!$_type){
					$output_string .= '<div style="cursor:pointer;width:100%;height:20px;float:left;line-height:20px;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor=\'#eee\'" onmouseout="this.style.backgroundColor=\'\'" onclick="$(\'#search_selection_holder\').slideUp(\'fast\'); $(\'#user_selection_holder\').slideDown(\'fast\');$(\'#active_allocation\').html(\''.$this_users_results['_name'].'\');$(\'#selected_allocation\').val('.$this_users_results['id'].')">'.$this_users_results['_name'].'</div>';
					
				}else{				
					$output_string .= '<div style="cursor:pointer;width:100%;height:20px;float:left;line-height:20px;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor=\'#eee\'" onmouseout="this.style.backgroundColor=\'\'" onclick="$(\'#search_selection_holder1\').slideUp(\'fast\'); $(\'#user_selection_holder1\').slideDown(\'fast\');$(\'#active_allocation1\').html(\''.$this_users_results['_name'].'\');$(\'#selected_allocation1\').val('.$this_users_results['id'].')">'.$this_users_results['_name'].'</div>';
				
				}
			}		
			
		}else{
			$output_string = '<div style="width:100%;height:20px;float:left;line-height:20px;color:brown;font-weight:bold;text-align:center;">No results were found '.$search_key.'</div>';
			
			
		}
		
		
		print('search_allocation_users~'.$_type.'~'.$output_string);
		
	}
	
	if(isset($_POST['allocate_claims'])){
		$selected_claims = explode(',',$_POST['select_claims']);
		
		print('allocate_claims~');		
		include 'scripts/page_codes/_codes/allocate_claims_code.php';		
	}
	
	if(isset($_POST['merge_claims'])){
		$selected_claims = explode(',',$_POST['select_claims']);
		$selected_claim_list = $_POST['select_claims'];
		
		print('merge_claims~');		
		include 'scripts/page_codes/_codes/merge_claims_code.php';		
	}
	
	if(isset($_POST['complete_allocate_user'])){
		$claims_array = explode(',',$_POST['select_claims']);
		$allocation_level = $_POST['_level'];
		
		$selected_claims = "(_date = '".str_replace(",","' or _date = '",$_POST['select_claims'])."')";
		$user_allocation = $_POST['user_allocation'];
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		
		if($user_allocation != 0){
			for($c=0;$c<count($claims_array);$c++){
				$this_claim_id = $claims_array[$c];
				
				$partitions = fetch_database_partitions(7,$this_claim_id,$this_claim_id);
				$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
				
				$update_claims = mysqli_query($claims_connect,"update $payment_claims_table set user_allocation = $user_allocation, allocation_update_user = '$user_date', allocation_date = '$today' where company_id = $company_id and _date = '$this_claim_id'")or die(mysqli_error($claims_connect));
				
				$add_allocation_table = mysqli_query($claims_connect,"insert into claim_user_allocations (company_id,claim_date,user_id,allocated_to_id,_date,_level,status) VALUES($company_id,$this_claim_id,$user_id,$user_allocation,'$today',$allocation_level,1)")or die(mysqli_error($claims_connect));
				
				
			}
			
			$user_array = fetch_db_table('connect','users',$company_id,'_name',' id = '.$user_allocation);
			
			if(count($user_array['id']) != 0){
				$claim_id_string = '';
				for($c=0;$c<count($claims_array);$c++){
					$this_claim_id = $claims_array[$c];
					$partitions = fetch_database_partitions(7,$this_claim_id,$this_claim_id);
					$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
				
					$these_claims = mysqli_query($claims_connect,"select * from $payment_claims_table where company_id = $company_id and _date = $this_claim_id")or die(mysqli_error($claims_connect));
					
					$these_claim_results = mysqli_fetch_array($these_claims,MYSQLI_ASSOC);
					
					if($claim_id_string == ''){
						$claim_id_string = $these_claim_results['claim_id'];
						
					}else{
						$claim_id_string .= ','.$these_claim_results['claim_id'];
						
					}
				}
				
				if($claim_id_string != ''){
					if($user_array['email'][0] != '' || $user_array['email'][0] != 0){
						$user_email = explode(',',$user_array['email'][0]);
						
						$message = 'Hi, '.$user_array['_name'][0].',<br><br> '.$user_results['_name'].' has allocated the following claims for you to work on level '.($allocation_level+1).':<br>'.$claim_id_string.'<br><br>Please work on these as soon as you can.<br>Have a good day<br><br>PIPAT 2.0';
						
					}else{
						$user_email = explode(',',$user_results['email']);
						$message = 'Hi, '.$user_results['_name'].'<br>'.$user_array['_name'][0].' has has no email configured on their account. Please share the followng claims with them:<br>'.$claim_id_string.'<br><br>Have a good day<br><br>PIPAT 2.0';
					}
					
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= "replyTo:support@pipatzambia.org\r\n";
					$headers .= 'From: PIPAT 2.0'.'<support@pipatzambia.org>' . "\r\n";
					
					
					mail($user_email[0],'New claims allocated to you',$message,$headers);
				}
			}
			
		}else{
			for($c=0;$c<count($claims_array);$c++){
				$this_claim_id = $claims_array[$c];
				
				$partitions = fetch_database_partitions(7,$this_claim_id,$this_claim_id);
				$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
				
				$update_claims = mysqli_query($claims_connect,"update $payment_claims_table set user_allocation = 0, allocation_update_user = '', allocation_date = '0' where company_id = $company_id and _date = '$this_claim_id'")or die(mysqli_error($claims_connect));
				
				$update_allocation_table = mysqli_query($claims_connect,"update claim_user_allocations set status = 0 where claim_date = '$this_claim_id' and _level = $allocation_level")or die(mysqli_error($claims_connect));
			}
		}
		
		print('complete_allocate_user~');
	}
	
	if(isset($_POST['complete_merge_claims'])){
		$claims_array = explode(',',$_POST['select_claims']);
		$target_claim_date = $_POST['target_claim'];
		
		$this_default_claims_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$this_default_ascension_partition_name = $default_partition_names[7][1][2];
		$this_default_approvals_partition_name = $default_partition_names[8][1][0];
		
		$target_claim_partitions = fetch_database_partitions(7,$target_claim_date,$target_claim_date);
					
		$target_payment_claims_table = $this_default_claims_partition_name.'_partition_'.$target_claim_partitions[0];
		
		$target_claim = fetch_db_table('claims_connect',$target_payment_claims_table,$company_id,'id',"_date = '".$target_claim_date."'");
		
		$claim_beneficiaries_array = explode(',',$target_claim['beneficiaries'][0]);
		$claim_types_array = explode(',',$target_claim['claim_type_date'][0]);
		$new_claim_amount = $target_claim['amount'][0];
		
		$file_attachments = $target_claim['file_src'][0];
		
		$target_level = $target_claim['level'][0];
		
		if($target_claim_date != 0){
			for($c=0;$c<count($claims_array);$c++){
				
				$this_claim_date = $claims_array[$c];
				if($this_claim_date != $target_claim_date){
					$partitions = fetch_database_partitions(7,$this_claim_date,$this_claim_date);
					
					$payment_claims_table = $this_default_claims_partition_name.'_partition_'.$partitions[0];
					$beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
					$ascensions_table = $this_default_ascension_partition_name.'_partition_'.$partitions[0];
					
					$approvals_partitions = fetch_database_partitions(8,$this_claim_date,$this_claim_date);
					$approvals_table = $this_default_approvals_partition_name.'_partition_'.$approvals_partitions[0];
					
					$this_claim = fetch_db_table('claims_connect',$payment_claims_table,$company_id,'id',"_date = '".$this_claim_date."'");
					
					if($file_attachments == ''){
						$file_attachments = $this_claim['file_src'][0];
						
					}else if($this_claim['file_src'][0] != ''){
						$file_attachments .= ','.$this_claim['file_src'][0];
						
					}
					
					if($this_claim['level'][0] < $target_level){
						$target_level = $this_claim['level'][0];
					}
					
					$this_claim_type_array = explode(',',$this_claim['claim_type_date'][0]);
					for($tc=0;$tc<count($this_claim_type_array);$tc++){
						$this_claim_type_date = $this_claim_type_array[$tc];
						
						$index_check = array_keys($claim_types_array,$this_claim_type_date);
						
						if(!isset($index_check[0])){
							$claim_types_array[count($claim_types_array)] = $this_claim_type_date;
						}
					}
					
					
					$this_beneficiaries_array = explode(',',$this_claim['beneficiaries'][0]);
					for($cb=0;$cb<count($this_beneficiaries_array);$cb++){
						
						$this_beneficiary_date = $this_beneficiaries_array[$cb];
						
						$ben_index_check = array_keys($claim_beneficiaries_array,$this_beneficiary_date);
						
						if(!isset($ben_index_check[0])){
							$claim_beneficiaries_array[count($claim_beneficiaries_array)] = $this_beneficiary_date;
							
						}
					}
					
					$new_claim_amount += $this_claim['amount'][0];
					
					$update_claims = mysqli_query($claims_connect,"update $payment_claims_table set status = 0 where company_id = $company_id and _date = '$this_claim_date'")or die(mysqli_error($claims_connect));
					
					$update_beneficiaries = mysqli_query($claims_connect,"update $beneficiaries_table set claim_date = '$target_claim_date' where claim_date = '$this_claim_date'")or die(mysqli_error($claims_connect));
					
					$update_ascensions = mysqli_query($claims_connect,"update $ascensions_table set claim_date = '$target_claim_date' where claim_date = '$this_claim_date'")or die(mysqli_error($claims_connect));
					
					$update_approvals_table = mysqli_query($claims_connect,"update $approvals_table set claim_date = '$target_claim_date' where claim_date = '$this_claim_date'")or die(mysqli_error($claims_connect));
				}
			}
			
			$claim_beneficiaries_string = implode(',',$claim_beneficiaries_array);
			$claim_types_string = implode(',',$claim_types_array);
			
			//print($claim_types_string.'<br><br>'.$claim_beneficiaries_string);
			
			$update_target_claim = mysqli_query($claims_connect,"update $target_payment_claims_table set beneficiaries = '$claim_beneficiaries_string', claim_type_date = '$claim_types_string', amount = '$new_claim_amount', file_src = '$file_attachments', level = $target_level where _date = '$target_claim_date'")or die(mysqli_error($claims_connect));
		}
		
		print('complete_allocate_user~');
	}
	
	if(isset($_POST['export_claims'])){
		include '../common_data_loop.php';
		
		$export_status = $_POST['export_status'];
		
		$region_id = $_POST['region_id'];
		$province_id = $_POST['province_id'];
		$hub_id = $_POST['hub_id'];
		$unit_id = $_POST['unit_id'];
		$level = $_POST['level'];
		$level_consideration = $_POST['level_consideration'];
		
		$claim_type_id = $_POST['claim_type_id'];
		
		$from_date = explode('/',$_POST['date_from']);
		$to_date = explode('/',$_POST['date_to']);
		
		$from_date = mktime(0,0,0,$from_date[0],$from_date[1],$from_date[2]);
		$to_date = mktime(23,59,59,$to_date[0],$to_date[1],$to_date[2]);
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$this_default_ascension_partition_name = $default_partition_names[7][1][2];
		$this_default_approval_partition_name = $default_partition_names[8][1][0];

		$claims_partitions = fetch_database_partitions(7,$from_date,$to_date);
		$approval_partitions = fetch_database_partitions(8,$from_date,$to_date);
		
	
		$search_key = str_replace("'","''",$_POST['search_key']);
		$strictness_id = $_POST['strictness_id'];
		
		$ordering = $_POST['ordering'];
		$user_allocation = $_POST['user_allocation'];
		$allocation_colors = $_POST['allocation_colors'];
		
		$claim_id_search_key_string = '';
		$search_key_string = '';
		if($_POST['search_key'] != 'Enter beneficiary name, phone number or Claim ID'){
			$search_key_array = explode(',',$search_key);
			
			if($strictness_id == 0 || $strictness_id == 1) {
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_id = str_replace(" ","",$search_key_array[$sk]);
					
					if(!is_numeric($this_id) and $strictness_id == 1){
						$claim_id_search_key_string = '0';
						
					}else{				
						if(is_numeric($this_id)){
							if($claim_id_search_key_string == ''){
								$claim_id_search_key_string = $this_id;
								
							}else{
								$claim_id_search_key_string .= " or claim_id = ".$this_id;
								
							}
						}
					}
				}
				
				if($claim_id_search_key_string != ''){
					$claim_id_search_key_string = ' and (company_id = '.$company_id.' and claim_id = '.$claim_id_search_key_string.')';
					
				}
			}
			
			$search_key_string = '';	
			
			if($strictness_id == 0 || $strictness_id == 2){
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_name = $search_key_array[$sk];

					for($pat=0;$pat<count($claims_partitions);$pat++){
					
						$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
					
						$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where _name LIKE '%$this_name%' and company_id = $company_id")or die(mysqli_error($$module_connect));
						
						if(!mysqli_num_rows($claim_beneficiaries) and $strictness_id == 2){
							$search_key_string .= '_date = 0';
							
						}else{
						
							for($cb=0;$cb<mysqli_num_rows($claim_beneficiaries);$cb++){
								$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
								
								if($search_key_string == ''){
									$search_key_string .= '_date = '.$claim_beneficiary_results['claim_date'];
									
								}else{
									$search_key_string .= ' or _date = '.$claim_beneficiary_results['claim_date'];
									
								}
							}
						}
					}
				}
		
				if($search_key_string != ''){
					$search_key_string = ' and ('.$search_key_string.')';
				}
			}
			
			if($strictness_id == 0 || $strictness_id == 3){
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_name = $search_key_array[$sk];					
					
					for($pat=0;$pat<count($claims_partitions);$pat++){
					
						$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
					
						$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where phone LIKE '%$this_name%' and company_id = $company_id")or die(mysqli_error($$module_connect));
					
						if(!mysqli_num_rows($claim_beneficiaries) and $strictness_id == 3){
							$search_key_string .= '_date = 0';
							
						}else{					
							for($cb=0;$cb<mysqli_num_rows($claim_beneficiaries);$cb++){
								$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
								
								if($search_key_string == ''){
									$search_key_string .= '_date = '.$claim_beneficiary_results['claim_date'];
									
								}else{
									$search_key_string .= ' or _date = '.$claim_beneficiary_results['claim_date'];
									
								}
							}
						}
					}
				}
		
				if($search_key_string != ''){
					$search_key_string = ' and ('.$search_key_string.')';
				}
			}
			
			if($strictness_id == 0 || $strictness_id == 4){
				for($sk=0;$sk<count($search_key_array);$sk++){
					$this_name = $search_key_array[$sk];					
					
					$claim_users = mysqli_query($connect,"select * from users where _name LIKE '%$this_name%' and company_id = $company_id")or die(mysqli_error($connect));
					
					if(!mysqli_num_rows($claim_users) and $strictness_id == 4){
						$search_key_string .= 'user_date = 0';
						
						
					}else{					
						for($cb=0;$cb<mysqli_num_rows($claim_users);$cb++){
							$claim_users_results = mysqli_fetch_array($claim_users,MYSQLI_ASSOC);
							
							if($search_key_string == ''){
								$search_key_string .= 'user_date = '.$claim_users_results['_date'];
								
							}else{
								$search_key_string .= ' or user_date = '.$claim_users_results['_date'];
								
							}
						}
					}
				}
		
				if($search_key_string != ''){
					$search_key_string = ' and ('.$search_key_string.')';
				}
			}
		}
		
		$search_string = ' and (claim_date >= '.$from_date.' and claim_date <= '.$to_date.')';
		
		if($region_id != 0){
			$search_string .= ' and region_id = '.$region_id;
			
		}
				
		if($province_id != 0){
			$search_string .= ' and province_id = '.$province_id;
			
		}
		
		if($hub_id != 0){
			$search_string .= ' and hub_id = '.$hub_id;
			
		}
		
		if($unit_id != -1){
			$search_string .= ' and unit_id = '.$unit_id;
			
		}
		
		if($claim_type_id != 0){
			$search_string .= " and claim_type_date LIKE '%".$claim_type_id."'";
			
		}
		
		if($level != -1){
			
			if($level_consideration == 1){
				$search_string .= " and level =".$_POST['level'];
				
			}else{
				$level_search_string = '';
				
				for($pat=0;$pat<count($claims_partitions);$pat++){
					
					$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
					
					$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where level = $level and company_id = $company_id")or die(mysqli_error($$module_connect));
				
					for($cb=0;$cb<mysqli_num_rows($claim_beneficiaries);$cb++){
						$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
						
						if($level_search_string == ''){
							$level_search_string = 'and (_date = '.$claim_beneficiary_results['claim_date'];
							
						}else{
							$level_search_string .= ' or _date = '.$claim_beneficiary_results['claim_date'];
						}
					}
					
				}
				if($level_search_string != ''){
					$level_search_string .= ')';
					
					$search_string .= $level_search_string;
					
				}else{
					$search_string .= ' and _date = 0';
				
				}
			}			
		}
	
		if($_POST['status'] == ''){
			$status_string = '';
			
		}else{
			$status_string = ' and (status = '.$_POST['status'].')';
			
		}
		
		$search_string = $search_string.$search_key_string;
		
		
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
		
		$users = mysqli_query($connect,"select * from users where company_id = $company_id")or die(mysqli_error($connect));
		$users_id_array = array();
		$users_name_array = array();
		for($u=0;$u<mysqli_num_rows($users);$u++){
			$user_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
			
			$user_id_array[$u] = $user_results['id'];
			$user_name_array[$u] = $user_results['_name'];
			$user_date_array[$u] = $user_results['_date'];
			$user_phone_array[$u] = $user_results['phone'];
		}
		
		$claim_types = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id")or die(mysqli_error($$module_connect));
		
		for($c=0;$c<mysqli_num_rows($claim_types);$c++){
			$claim_type_results = mysqli_fetch_array($claim_types,MYSQLI_ASSOC);
			
			$claim_type_id_array[$c] = $claim_type_results['id'];
			$claim_type_title_array[$c] = $claim_type_results['title'];
			$claim_type_date_array[$c] = $claim_type_results['_date'];	
			
			$levels_array = explode(']',$claim_type_results['rule_string']);
			$claim_type_total_levels_array[$c] = count($levels_array);				
		}
		
		
		if($claim_id_search_key_string != 'company_id = 1 and claim_id = 0' and $claim_id_search_key_string != ''){
			$claim_search = $claim_id_search_key_string.$status_string;
			
		}else{
			$claim_search = $search_string.$claim_id_search_key_string.$status_string;
			
		}

		if($user_allocation != '-1'){
			if($user_allocation == '-2'){
				$claim_search = $claim_search.' and user_allocation != 0';
				
			}else{
				$claim_search = $claim_search.' and user_allocation = '.$user_allocation;
				
			}
		}

		if($ordering == 0){
			$ordering = 'claim_id asc';
			
		}else if($ordering == 1){
			$ordering = 'claim_id desc';
			
		}else if($ordering == 2){
			$ordering = 'amount asc';
			
		}else if($ordering == 3){
			$ordering = 'amount desc';
		}

		$claim_number_list = '';
		$legend = '';
		
		$rows = array();
		
		if($export_status == 0){
			$column_names = array('Claim number','Date created','Creator','Period start','Period end','Level 3 approval date','Level 4 approval date','Last level approval date','Level 3 allocated to','Level 4 allocated to','Region','Province','Hub','Site','District','Claim type','Creation method','Batch number','Beneficiary count','Current level','Amount');
			
			$column_formating = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);			
		}else if($export_status == 1){
			$column_names = array('Claim Number','Allocated to','Allocated by','Date allocated','Spreadsheet date','Spreadsheet user','Beneficiaries','Level','Creator','Amount(K)','Date created');
			$column_formating = array(0,0,0,0,0,0,0,0,0,0,0);
		}
		
		$claim_user_allocations_array = fetch_db_table('claims_connect','claim_user_allocations',$company_id,'id',"status = 1 and (_level = 2 or _level = 3)");
		
		for($pat=0;$pat<count($claims_partitions);$pat++){
			
			$payment_claims_table = $this_default_partition_name.'_partition_'.$claims_partitions[$pat];
			$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
			
			$claim_ascension_table = $this_default_ascension_partition_name.'_partition_'.$approval_partitions[$pat];
			$approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[$pat];
			
			$payment_claims = mysqli_query($$module_connect,"select * from $payment_claims_table where company_id = $company_id  $claim_search order by $ordering")or die(mysqli_error($$module_connect));
			
			$beneficiary_array = fetch_db_table('claims_connect',$claim_beneficiaries_table,$company_id,'id','');
			
			$claim_approvals_array = fetch_db_table('claims_connect',$approvals_table,$company_id,'id',"status = 1 and validity = 1 and _date >= '".$from_date."' and _date <= '".$to_date."' and (level = 2 or level = 3 or level = 4)");
			
			for($c=0;$c<mysqli_num_rows($payment_claims);$c++){
				$claim_results = mysqli_fetch_array($payment_claims,MYSQLI_ASSOC);				
			
				if($export_status == 0){
					
					$user_allocation_index = array_keys($claim_user_allocations_array['claim_date'],$claim_results['_date']);
					
					$level_3_user_allocation = 'N/A';
					$level_4_user_allocation = 'N/A';
					if(isset($user_allocation_index[0])){
						for($le=0;$le<count($user_allocation_index);$le++){
							if($claim_user_allocations_array['_level'][$user_allocation_index[$le]] == 2){
								$this_user_index = array_keys($user_id_array,$claim_user_allocations_array['allocated_to_id'][$user_allocation_index[$le]]);
								
								if(isset($this_user_index[0])){
									$level_3_user_allocation = $user_name_array[$this_user_index[0]];
								}
								
							}else if($claim_user_allocations_array['_level'][$user_allocation_index[$le]] == 3){
								$this_user_index = array_keys($user_id_array,$claim_user_allocations_array['allocated_to_id'][$user_allocation_index[$le]]);
								
								if(isset($this_user_index[0])){
									$level_4_user_allocation = $user_name_array[$this_user_index[0]];
								}
							}
						}
						
					}
					
					$beneficiary_index = array_keys($beneficiary_array['claim_date'],$claim_results['_date']);
					$no_beneficiaries = 0;
					$claim_period_from = 'N/A';
					$claim_period_to = 'N/A';
					if(isset($beneficiary_index[0])){
						$no_beneficiaries = count($beneficiary_index);
						
						$claim_period_from = date('d/m/Y',$beneficiary_array['_from'][$beneficiary_index[0]]);
						$claim_period_to = date('d/m/Y',$beneficiary_array['_to'][$beneficiary_index[0]]);
					}
					
					$claim_approval_index = array_keys($claim_approvals_array['claim_date'],$claim_results['_date']);
					
					$level_3_approval_date = 'N/A';
					$level_4_approval_date = 'N/A';
					$last_level_approval_date = 'N/A';
					if(isset($claim_approval_index[0])){
						for($ca=0;$ca<count($claim_approval_index);$ca++){
							
							if($claim_approvals_array['level'][$claim_approval_index[$ca]] == 2){
								$level_3_approval_date = date('d/m/Y',$claim_approvals_array['_date'][$claim_approval_index[$ca]]);
								
							}else if($claim_approvals_array['level'][$claim_approval_index[$ca]] == 3){
								$level_4_approval_date = date('d/m/Y',$claim_approvals_array['_date'][$claim_approval_index[$ca]]);
								
							}else if($claim_approvals_array['level'][$claim_approval_index[$ca]] == 4){
								$last_level_approval_date = date('d/m/Y',$claim_approvals_array['_date'][$claim_approval_index[$ca]]);
							}
						}
					}
					
					$user_allocation_name = 'N/A';
					if($claim_results['user_allocation'] != 0){
						$user_allocation_index = array_keys($user_array['id'],$claim_results['user_allocation']);
						
						if(isset($user_allocation_index[0])){
							$user_allocation_name = $user_array['_name'][$user_allocation_index[0]];
						}
					}
					
					if($level_3_user_allocation === 'N/A' and $level_4_user_allocation === 'N/A'){
						$level_3_user_allocation = $user_allocation_name;
					}
					
					$user_index = array_keys($user_array['_date'],$claim_results['user_date']);				
					$claim_user = 'Unknown';
					if(isset($user_index[0])){
						$claim_user = $user_array['_name'][$user_index[0]];
					}
					
					$region_index = array_keys($region_array['id'],$claim_results['region_id']);
					$region_title = 'Unknonw';
					
					if(isset($region_index[0])){
						$region_title = $region_array['title'][$region_index[0]];
						
					}
					
					$province_index = array_keys($province_array['id'],$claim_results['province_id']);
					$province_title = 'Unspecified';
					
					if(isset($province_index[0])){
						$province_title = $province_array['title'][$province_index[0]];
					}
					
					$hub_index = array_keys($hub_array['id'],$claim_results['hub_id']);
					
					$hub_title = 'Unspecified';
					if(isset($hub_index[0])){
						$hub_title = $hub_array['title'][$hub_index[0]];
					
					}
					
					$site_index = array_keys($site_array['id'],$claim_results['site_id']);
					$site_title = 'Unspecified';
					
					if(isset($site_index[0])){
						$site_title = $site_array['title'][$site_index[0]];
					}
					
					$district_title = 'N/A';
					if($claim_results['title'] != ''){
						$district_title = $claim_results['title'];
					}
					
					$this_claim_type_date_array = explode(',',$claim_results['claim_type_date']);			$type_name = '';
					
					for($cl=0;$cl<count($this_claim_type_date_array);$cl++){
						$type_index = array_keys($claim_type_date_array,$this_claim_type_date_array[$cl]);
						
						if(isset($type_index[0])){						
							if($type_name == ''){
								$type_name = $claim_type_title_array[$type_index[0]];
								
							}else{
								$type_name .= ','.$claim_type_title_array[$type_index[0]];
							}
						}
					}
					
					$creation_method_title = 'Manual';
					$batch_number = 'NA';
					
					if($claim_results['creation_method']){
						$creation_method_title = 'Automatic';
						$batch_number = $claim_results['batch_number'];
						
					}
					
					$rows[count($rows)] = array($claim_results['claim_id'],date('d/m/Y',$claim_results['claim_date']),$claim_user,$claim_period_from,$claim_period_to,$level_3_approval_date,$level_4_approval_date,$last_level_approval_date,$level_3_user_allocation,$level_4_user_allocation,$region_title,$province_title,$hub_title,$site_title,$district_title,$type_name,$creation_method_title,$batch_number,$no_beneficiaries,($claim_results['level']+1),$claim_results['amount']);
					
					
				}else if($export_status == 1){
					$beneficiary_index = array_keys($beneficiary_array['claim_date'],$claim_results['_date']);
					$no_beneficiaries = 0;
					if(isset($beneficiary_index[0])){
						$no_beneficiaries = count($beneficiary_index);
					}
					
					$user_index = array_keys($user_array['_date'],$claim_results['user_date']);
					
					$claim_user = 'Unknown';
					if(isset($user_index[0])){
						$claim_user = $user_array['_name'][$user_index[0]];
					}
					
					$allocation_user = '[Unallocated]';
					$allocator_user = 'N/A';
					$allocation_date = 'N/A';
					if($claim_results['user_allocation'] != 0){
						$allocation_user_index = array_keys($user_array['id'],$claim_results['user_allocation']);
						
						if(isset($allocation_user_index[0])){
							$allocation_user = $user_array['_name'][$allocation_user_index[0]];
						}
						
						$allocator_user_index = array_keys($user_array['_date'],$claim_results['allocation_update_user']);					
						if(isset($allocator_user_index[0])){
							$allocator_user = $user_array['_name'][$allocator_user_index[0]];
						}
						
						$allocation_date = date('j-m-Y',$claim_results['allocation_date']);
					}
					
					$spreadsheet_date = 'N/A';
					$spreadsheet_user = 'N/A';
					
					if($claim_results['ascension_dates'] != ''){
						
						$ascension_array = explode(',',$claim_results['ascension_dates']);
						$ascension_user_date = explode(',',$claim_results['ascension_user_dates']);
						
						
						$spreadsheet_date = date('j-m-Y',$ascension_array[count($ascension_array)-1]);
						
						$spreadsheet_user_index = array_keys($user_array['_date'],$ascension_user_date[count($ascension_user_date)-1]);
						
						if(isset($spreadsheet_user_index[0])){
							$spreadsheet_user = $user_array['_name'][$spreadsheet_user_index[0]];
						}
					}
					
					$rows[count($rows)] = array($claim_results['claim_id'],$allocation_user,$allocator_user,$allocation_date,$spreadsheet_date,$spreadsheet_user,$no_beneficiaries,($claim_results['level']+1),$claim_user,$claim_results['amount'],date('j-m-Y',$claim_results['claim_date']));
				}
			}
		}
		
		$file_name = new_excel_export($column_names,$rows,$column_formating,'custom_report_'.time(),0);		
		print('export_claims~'.$file_name);
	}
	
	if(isset($_POST['export_tilt_file'])){
		$selected_claims_array = explode(',',$_POST['select_claims']);
		
		$claim_date_string = "(claim_date = '".str_replace(",","' or claim_date = '",$_POST['select_claims'])."')";
		
		$claim_string = "(_date = '".str_replace(",","' or _date = '",$_POST['select_claims'])."')";
		
		$start_date = time();
		$end_date = time();
		
		for($c=0;$c<count($selected_claims_array);$c++){
			$this_claim_date = $selected_claims_array[$c];
			
			if($start_date > $this_claim_date){
				$start_date = $this_claim_date;
			}

			if($end_date < $this_claim_date){
				$end_date = $this_claim_date;
				
			}
		}
		
		$genders = mysqli_query($connect,"select * from genders")or die(mysqli_error($connect));
		
		$gender_id_array = array();
		$gender_title_array = array();
		for($g=0;$g<mysqli_num_rows($genders);$g++){
			$gender_results = mysqli_fetch_array($genders,MYSQLI_ASSOC);
			
			$gender_id_array[$g] = $gender_results['id'];
			$gender_title_array[$g] = $gender_results['title'];
			
		}
		
		$columns_array = array('Name','Last_Name','ID_Type','ID_Number','amount','Cell_Number','Reference');
		$formating_array = array(0,0,0,0,0,0,0,0);
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$this_default_ascension_partition_name = $default_partition_names[7][1][2];
		
		$this_default_agent_partition_name = $default_partition_names[2][1][0];

		$partitions = fetch_database_partitions(7,$start_date,$end_date);
		//print($claim_string);
		$row_array = array();
		for($p=0;$p<count($partitions);$p++){
			$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[$p];
			$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[$p];
			$claim_ascension_table = $this_default_ascension_partition_name.'_partition_'.$partitions[$p];
		
			$payment_claims_array = fetch_db_table('claims_connect',$payment_claims_table,$company_id,'id',$claim_string);
			
			$claim_beneficiary_array = fetch_db_table('claims_connect',$claim_beneficiaries_table,$company_id,'id',$claim_date_string);
			
			$ascension_beneficiaries_array = fetch_db_table('claims_connect',$claim_ascension_table,$company_id,'id',$claim_date_string);
			
			
			
			for($tb=0;$tb<count($ascension_beneficiaries_array['id']);$tb++){
				$this_agent_type_date = $ascension_beneficiaries_array['type_date'][$tb];
				$this_agent_date = $ascension_beneficiaries_array['agent_date'][$tb];
				$this_claim_date =  $ascension_beneficiaries_array['claim_date'][$tb];
				
				$claim_index = array_keys($payment_claims_array['_date'],$this_claim_date);
				$claim_number = $payment_claims_array['claim_id'][$claim_index[0]];
				
				$beneficiary_index = array_keys($claim_beneficiary_array['agent_date'],$this_agent_date);
				
				if(count($beneficiary_index) > 1){
					for($bi=0;$bi<count($beneficiary_index);$bi++){
						if($this_agent_type_date == $claim_beneficiary_array['type_date'][$beneficiary_index[$bi]]){
							$beneficiary_name = $claim_beneficiary_array['_name'][$beneficiary_index[$bi]];
							$beneficiary_nrc = $claim_beneficiary_array['nrc'][$beneficiary_index[$bi]];
							$beneficiary_phone = $claim_beneficiary_array['phone'][$beneficiary_index[$bi]];
							$beneficiary_amount = $claim_beneficiary_array['amount'][$beneficiary_index[$bi]];
							break;
						}
					}
				}else{
					$beneficiary_name = $claim_beneficiary_array['_name'][$beneficiary_index[0]];
					$beneficiary_nrc = $claim_beneficiary_array['nrc'][$beneficiary_index[0]];
					$beneficiary_phone = $claim_beneficiary_array['phone'][$beneficiary_index[0]];
					$beneficiary_amount = $claim_beneficiary_array['amount'][$beneficiary_index[0]];
				}
				
				
				
				$agent_partition = fetch_database_partitions(2,$this_agent_date,$this_agent_date);
				$this_agents_table = $this_default_agent_partition_name.'_partition_'.$agent_partition[0];
				
				$this_agent_array = fetch_db_table('connect',$this_agents_table,$company_id,'id','_date = '.$this_agent_date);

				
				$gender_index = array_keys($gender_id_array,$this_agent_array['gender'][0]);
				$this_gender_title = $gender_title_array[$gender_index[0]];
				
				$beneficiary_name = explode(' ',$beneficiary_name);
				
				$firstname = $beneficiary_name[0];
				if(!isset($beneficiary_name[1])){
					$last_name = '';
					
				}else{
					$last_name = $beneficiary_name[count($beneficiary_name)-1];
					
				}
				
				$row_array[count($row_array)] = array($firstname,$last_name,'NRC',$beneficiary_nrc,$beneficiary_amount,$beneficiary_phone,$claim_number);
			}
		}
		
		$file_name = new_excel_export($columns_array,$row_array,$formating_array);
		
		print('generate_claim_csv~0~'.$file_name);
	}
	
	if(isset($_POST['open_spreadsheet'])){
		$claim_date = $_POST['claim_date'];
		$beneficiary_id_string = $_POST['beneficiary_string'];
		
		$ascension_index = $_POST['ascensions'];
		
		$this_default_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		$this_default_ascension_partition_name = $default_partition_names[7][1][2];

		$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
		
		$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
		
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
		
		$claim_ascension_table = $this_default_ascension_partition_name.'_partition_'.$partitions[0];
		
		$this_default_approval_partition_name = $default_partition_names[8][1][0];
		
		$approval_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
		
		$approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[0];
		
		$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
		
		$claim_id = $this_claim_results['id'];
		
		$this_claim_date = $claim_date;
		
		$claim_type_array = explode(',',$this_claim_results['claim_type_date']);
		$claim_type_beneficiaries_array = explode(']',$beneficiary_id_string);
		
		$grand_total = 0;
		$beneficiary_sql_string = '';
		for($c=0;$c<count($claim_type_array);$c++){
			$this_claim_type_date = $claim_type_array[$c];
			
			if(isset($claim_type_beneficiaries_array[$c])){
				$claim_type_beneficiaries = explode(',',$claim_type_beneficiaries_array[$c]);
				for($cb=0;$cb<count($claim_type_beneficiaries);$cb++){
					$this_beneficiary_id = $claim_type_beneficiaries[$cb];
					
				//	for($b=0;$b<count($beneficiary_id_array);$b++){					
						//if($beneficiary_type_date_array[$b] == $this_claim_type_date and $this_beneficiary_id == $beneficiary_agent_date_array[$b]){
							
							if($this_beneficiary_id){
								if($beneficiary_sql_string == ''){
									$beneficiary_sql_string = "(".$company_id.",'".$this_claim_date."','".$this_beneficiary_id."','".$claim_type_array[$c]."',".$ascension_index.",'".time()."')";
									
								}else{
									$beneficiary_sql_string .= ",(".$company_id.",'".$this_claim_date."','".$this_beneficiary_id."','".$claim_type_array[$c]."',".$ascension_index.",'".time()."')";
								}
							}
						//}
					//}
				}
			}
		}
		
		if($beneficiary_sql_string != ''){
			$add_ascension_beneficiaries = mysqli_query($$module_connect,"insert into $claim_ascension_table (company_id,claim_date,agent_date,type_date,ascension_ind,_date) VALUES $beneficiary_sql_string")or die(mysqli_error($$module_connect));
			
			if($this_claim_results['ascensions'] == 0){
				$ascension_dates = time();
				$ascension_user_dates = $user_date;
				
			}else{
				$ascension_dates = $this_claim_results['ascension_dates'].','.time();
				$ascension_user_dates = $this_claim_results['ascension_user_dates'].','.$user_date;
				
			}
			
			$new_ascensions = $this_claim_results['ascensions']+1;
			
			$update_payment_claim = mysqli_query($$module_connect,"update $payment_claims_table set ascensions = $new_ascensions,ascension_dates = '$ascension_dates', ascension_user_dates = '$ascension_user_dates' where _date = '$this_claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		}
		
		print('open_spreadsheet~'.$claim_date.'~'.$_POST['ascensions'].'~'.$_POST['spreadsheet_id'].'~'.$_POST['key'].'~'.$_POST['_type'].'~'.$user_date.'~'.$_POST['beneficiary_string']);
	}
}
?>