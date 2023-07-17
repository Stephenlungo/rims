<?php
include '../scripts/short_connector.php';
include '../../scripts/bluerays_software/default_functions.php';
$company_id = 1;
$request_types = fetch_db_table('claims_connect','request_types',$company_id,'id','');
$payment_claims = fetch_db_table('claims_connect','payment_claims',$company_id,'id','');

$users = fetch_db_table('connect','users',$company_id,'id','');

$beneficiary_count = mysqli_query($claims_connect,"select * from claim_beneficiaries where status != 0 and company_id = $company_id")or die(mysqli_error($claims_connect));

$max_records = 500;

$processing_blocks = ceil(mysqli_num_rows($beneficiary_count) / $max_records);

$level_data = array();
for($bb=0;$bb<$processing_blocks;$bb++){
	$starting_index = $bb * $max_records;
	$ending_index = $starting_index+$max_records;
	
	$claim_beneficiaries = fetch_db_table('claims_connect','claim_beneficiaries',$company_id,'id','status != 0 and id >= '.$starting_index.' and id < '.$ending_index);
	
	
	
	for($r=0;$r<count($request_types['id']);$r++){
		if($request_types['delay_monitor_rule_string'][$r] != ''){
			$delay_monitor_rule_string_array = explode('|',$request_types['delay_monitor_rule_string'][$r]);
			
			
			for($l=0;$l<count($delay_monitor_rule_string_array);$l++){
				$level_data[$l][0] = $l;
				if($delay_monitor_rule_string_array[$l] != ''){
					$level_delay_rule_array = explode(']',$delay_monitor_rule_string_array[$l]);
					
					if($level_delay_rule_array[0] != 0){
						$this_level = $l;
						$delay_days = $level_delay_rule_array[1];
						$flag_claim = $level_delay_rule_array[2];
						$notify_creator = $level_delay_rule_array[3];
						$notify_levels = $level_delay_rule_array[4];
						$notify_user = $level_delay_rule_array[5];
						$notify_user_groups = $level_delay_rule_array[6];
						
						$beneficiary_level_index = array_keys($claim_beneficiaries['level'],$this_level);
						
						if(isset($beneficiary_level_index[0])){
							$claim_approvals = fetch_db_table('claims_connect','claim_approvals',$company_id,'id','level = '.$l);
							
							for($b=0;$b<count($beneficiary_level_index);$b++){
								
								$beneficiary_status = $claim_beneficiaries['status'][$beneficiary_level_index[$b]];
								
								$claim_index = array_keys($payment_claims['_date'],$claim_beneficiaries['claim_date'][$beneficiary_level_index[$b]]);
								
								if(isset($claim_index[0])){
									$approval_index = array_keys($claim_approvals['claim_date'],$claim_beneficiaries['claim_date'][$beneficiary_level_index[$b]]);
									
									if(isset($approval_index[0])){
										for($a=0;$a<count($approval_index);$a++){
											if($claim_approvals['level'][$approval_index[$a]] == $this_level){
												if($claim_approvals['_date'][$approval_index[$a]] < (time() - (86400 * $delay_days))){
													
													$this_claim_id = $payment_claims['claim_id'][$claim_index[0]];
													
													$claim_add = 0;
													if(isset($level_data[$l][$beneficiary_status])){
														if(!check_item_in_list($this_claim_id,$level_data[$l][$beneficiary_status],0,',')){
															$level_data[$l][$beneficiary_status] = $level_data[$l][$beneficiary_status].','.$this_claim_id;
															
															$claim_add = 1;
														}
														
													}else{
														$level_data[$l][$beneficiary_status] = $this_claim_id;
														$claim_add = 1;
													}
													
													
													if($claim_add){
														if($flag_claim){
															if(isset($level_data[$l][100])){
																if(!check_item_in_list($this_claim_id,$level_data[$l][100],0,',')){
																	$level_data[$l][100] = $level_data[$l][100].','.$this_claim_id;
																}
																
															}else{
																$level_data[$l][100] = $this_claim_id;
															}
														}
														
														if($notify_creator){
															$creator_date = $payment_claims['user_date'][$claim_index[0]];
															
															if(isset($level_data[$l][101])){
																if(!check_item_in_list($creator_date,$level_data[$l][101],0,',')){
																	$level_data[$l][101] = $level_data[$l][101].','.$creator_date;
																}
																
															}else{
																$level_data[$l][101] = $creator_date;
															}
														}
														
														if($notify_levels){
															
														}
														
														if($notify_user){
															if(isset($level_data[$l][103])){
																if(!check_item_in_list($notify_user,$level_data[$l][103],0,',')){
																	$level_data[$l][103] = $level_data[$l][103].','.$notify_user;
																}
																
															}else{
																$level_data[$l][103] = $notify_user;
															}
														}
														
														if($notify_user_groups){
															if(isset($level_data[$l][104])){
																$level_notify_array = explode(',',$notify_user_groups);
																
																for($ng=0;$ng<count($level_notify_array);$ng++){
																	if(!check_item_in_list($level_notify_array[$ng],$level_data[$l][104],0,',')){
																		$level_data[$l][104] = $level_data[$l][104].','.$level_notify_array[$ng];
																	}
																}
															}else{
																$level_data[$l][104] = $notify_user_groups;
															}
														}
													}
													
													break;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	print('Start: = '.$starting_index.'<br>End: '.$ending_index.'<br>');
}

print('Pricessing_time: '.((time() - $today)));
?>