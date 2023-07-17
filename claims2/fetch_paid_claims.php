<?php
$company_id = 1;
$column_names = array('Beneficiary Name','Sex','NRC','Phone on agent account','Phone on claim','Job title','Claim number','Claim type','Province','Hub','Facility','Claim Status','Days worked','Days paid','Amount','Date of claim');
$formating = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);


include 'scripts/short_connector.php';
include 'scripts/bluerays_software/default_functions.php';

$start_date = mktime(0,0,0,03,01,2023);
$agents_start_date = mktime(0,0,0,1,1,2015);
$end_date = mktime(23,59,59,05,19,2023);



$this_default_partition_name = $default_partition_names[7][1][0];
$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
$this_default_approval_partition_name = $default_partition_names[8][1][0];
$this_default_agents_partition_name = $default_partition_names[2][1][0];
$this_default_phone_partition_name = $default_partition_names[2][1][1];



$claims_partitions = fetch_database_partitions(7,$start_date,$end_date);
//print(date('d M Y',$start_date));
$approval_partitions = fetch_database_partitions(8,$start_date,$end_date);
$agents_partitions = fetch_database_partitions(2,$agents_start_date,$end_date);

$province_array = fetch_db_table('connect','provinces',$company_id,'id','');
$hub_array = fetch_db_table('connect','hubs',$company_id,'id','');
$site_array = fetch_db_table('connect','sites',$company_id,'id','');
$request_type_array = fetch_db_table('claims_connect','request_types',$company_id,'id',"");

$row_array = array();

for($ap=0;$ap<count($agents_partitions);$ap++){
	$this_agents_table = $this_default_agents_partition_name.'_partition_'.$agents_partitions[$ap];
	$this_phone_number_table = $this_default_phone_partition_name.'_partition_'.$agents_partitions[$ap];
	
	$agents_array[$ap] = fetch_db_table('connect',$this_agents_table,$company_id,'id','');
	$phone_number_array = fetch_db_table('connect',$this_phone_number_table,$company_id,'id','');
}



for($pat=0;$pat<count($claims_partitions);$pat++){
	$this_claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claims_partitions[$pat];
	
	$this_claims_table = $this_default_partition_name.'_partition_'.$claims_partitions[$pat];
	$this_approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[$pat];
	
	
	$claim_type_list = " ";

	
	$payment_claims = mysqli_query($$module_connect,"select * from $this_claims_table where (_date >= '$start_date' and _date <= '$end_date')")or die(mysqlI_error($connect));
	
	//print("select * from $this_claims_table where _date >= '$start_date' and _date <= '$end_date'");

	$beneficiary_array = fetch_db_table('claims_connect',$this_claim_beneficiaries_table,$company_id,'id',"_date >= '".$start_date."' and _date <=  '".$end_date."'".$claim_type_list);
	


	$approval_array = fetch_db_table('claims_connect',$this_approvals_table,$company_id,'id'," _date >='$start_date' and _date <= '$end_date' and level >= 3 and status = 1");

$total_beneficiaries = 0;
	
	$total_value = 0;
	for($p=0;$p<mysqli_num_rows($payment_claims);$p++){
		$payment_claim_results = mysqli_fetch_array($payment_claims,MYSQLI_ASSOC);
		
		if(is_numeric($payment_claim_results['amount'])){
			$total_value += $payment_claim_results['amount'];
		}
		
		$beneficiary_index = array_keys($beneficiary_array['claim_date'],$payment_claim_results['_date']);
		
		if(isset($beneficiary_index[0])){
			$total_beneficiaries += count($beneficiary_index);
			for($b=0;$b<count($beneficiary_index);$b++){			
				$beneficiary_request_type_date = $beneficiary_array['type_date'][$beneficiary_index[$b]];
				
				$this_request_type_index = array_keys($request_type_array['_date'],$beneficiary_request_type_date);
				
				$ben_requets_type_title = 'Not found';
				if(isset($this_request_type_index[0])){
					$ben_requets_type_title = $request_type_array['title'][$this_request_type_index[0]];
				}
				
				$approval_index = array_keys($approval_array['beneficiary_date'],$beneficiary_array['agent_date'][$beneficiary_index[$b]]);
				
				//if((isset($approval_index[0]) and $approval_array['claim_date'][$approval_index[0]] == $payment_claim_results['_date'])){
					
					$phone_number_index = array_keys($phone_number_array['agent_date'],$beneficiary_array['agent_date'][$beneficiary_index[$b]]);
					$phone_number = 'Unset';
					if(isset($phone_number_index[0])){
						$phone_number = $phone_number_array['phone_number'][$phone_number_index[0]];
						
						if(isset($phone_number_index[1])){
							$phone_number .= ', '.$phone_number_array['phone_number'][$phone_number_index[1]];
						}
					}
					
					$phone_on_claim = $beneficiary_array['phone'][$beneficiary_index[$b]];
					
					$ap_index = 0;
					for($ap=0;$ap<count($agents_partitions);$ap++){
						$agent_index = array_keys($agents_array[$ap]['_date'],$beneficiary_array['agent_date'][$beneficiary_index[$b]]);
						
						if(isset($agent_index[0])){
							$ap_index = $ap;
							break;
						}
					}
					
					
					if(isset($agent_index[0])){					
						//print('hi');
						$claim_status = '';
						if($payment_claim_results['status'] == 0){
							$claim_status = 'Disabled';
							
						}else if($payment_claim_results['status'] == 1){
							$claim_status = 'Pending';
							
						}else if($payment_claim_results['status'] == 2){
							$claim_status = 'Completed';
							
						}else if($payment_claim_results['status'] == 3){
							$claim_status = 'Sent for amendment';
							
						}
						
						$nrc = $agents_array[$ap_index]['id_number'][$agent_index[0]];
						
						$province_name = 'Not specified';
						$province_index = array_keys($province_array['id'],$agents_array[$ap_index]['province_id'][$agent_index[0]]);
						if(isset($province_index[0])){						
							$province_name = $province_array['title'][$province_index[0]];
						}
						
						$hub_name = 'Not specified';
						$hub_index = array_keys($hub_array['id'],$agents_array[$ap_index]['hub_id'][$agent_index[0]]);
						if(isset($hub_index[0])){						
							$hub_name = $hub_array['title'][$hub_index[0]];
						}
						
						$site_name = 'Not specified';
						$site_index = array_keys($site_array['id'],$agents_array[$ap_index]['site_id'][$agent_index[0]]);
						
						if(isset($site_index[0])){
							if(isset($site_index[0])){
								$site_name = $site_array['title'][$site_index[0]];
							}
						}
						
						if($agents_array[$ap_index]['gender'][$agent_index[0]] == 1){
							$gender = 'Male';
							
						}else if($agents_array[$ap_index]['gender'][$agent_index[0]] == 2){
							$gender = 'Female';
							
						}else{
							$gender = 'Other';
							
						}
					
					
						$row_array[count($row_array)] = array($beneficiary_array['_name'][$beneficiary_index[$b]],$gender,$nrc,$phone_number,$phone_on_claim,$agents_array[$ap_index]['responsibility'][$agent_index[0]],$payment_claim_results['claim_id'],$ben_requets_type_title,$province_name,$hub_name,$site_name,$claim_status,$beneficiary_array['days'][$beneficiary_index[$b]],$beneficiary_array['paid_days'][$beneficiary_index[$b]],number_format($beneficiary_array['amount'][$beneficiary_index[$b]],2),date('m/d/Y',$payment_claim_results['_date']));
				//	}
									
				}
			}
		}
	}
}

//print($total_beneficiaries);
$file_name = new_excel_export($column_names,$row_array,$formating);
header('location: '.$url.'/'.$file_name);
?>