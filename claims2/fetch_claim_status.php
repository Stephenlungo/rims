<?php
include 'scripts/connector.php';

include '../common_data_loop.php';


$formating = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$row_array = array();

$payment_claims_array = fetch_db_table('claims_connect','payment_claims',1,'_date',"status = 2 and _date >= '1538344800'");
$claims_beneficiary_array = fetch_db_table('claims_connect','claim_beneficiaries',1,'_name','');
$unit_array = fetch_db_table('connect','units',1,'title','');
$data_array = fetch_db_table('connect','_data',1,'id','');
$claim_type_array = fetch_db_table('claims_connect','request_types',1,'title','');



for($c=0;$c<count($payment_claims_array['id']);$c++){
	$region_index = array_keys($region_array['id'],$payment_claims_array['region_id'][$c]);
	
	$claim_region_title = 'Unspecified';
	if(isset($region_index[0])){
		$claim_region_title = $region_array['title'][$region_index[0]];
	}
	
	$province_index = array_keys($province_array['id'],$payment_claims_array['province_id'][$c]);
	$claim_province_title = 'Unspecified';
	if(isset($province_index[0])){
		$claim_province_title = $province_array['title'][$province_index[0]];
	}
	
	$hub_index = array_keys($hub_array['id'],$payment_claims_array['hub_id'][$c]);
	$claim_hub_title = 'Unspecified';
	if(isset($hub_index[0])){
		$claim_hub_title = $hub_array['title'][$hub_index[0]];
	}
	
	$site_index = array_keys($site_array['id'],$payment_claims_array['site_id'][$c]);
	$claim_site_title = 'Unspecified';
	if(isset($site_index[0])){
		$claim_site_title = $site_array['title'][$site_index[0]];
		
	}
	
	$user_index = array_keys($user_array['_date'],$payment_claims_array['user_date'][$c]);
	
	$claim_user = 'Not found';
	if(isset($user_index[0])){
		$claim_user = $user_array['_name'][$user_index[0]];
		
	}
	
	if(!$payment_claims_array['status'][$c]){
		$claim_status = 'Disabled';
		
	}else if($payment_claims_array['status'][$c] == 1){
		$claim_status = 'Pending';
		
	}else if($payment_claims_array['status'][$c] == 2){
		$claim_status = 'Complete';
		
	}else if($payment_claims_array['status'][$c] == 3){
		$claim_status = 'Awaiting amendment';
		
	}
	
	$unit_index = array_keys($unit_array['id'],$payment_claims_array['unit_id'][$c]);
	
	$unit_title = 'Unit not found';
	if(isset($unit_index[0])){
		$unit_title = $unit_array['title'][$unit_index[0]];
	}
	
	
	
	$beneficiary_index = array_keys($claims_beneficiary_array['claim_date'],$payment_claims_array['_date'][$c]);
	
	
	
	if(isset($beneficiary_index[0])){		
		for($b=0;$b<count($beneficiary_index);$b++){
			$agent_index = array_keys($agent_array['_date'],$claims_beneficiary_array['agent_date'][$beneficiary_index[$b]]);
			
			$agent_name = 'not found';
			$agent_position = 'not found';
			$agent_nrc = 'Not found';
			$agent_site_title = 'Not found';
			if(isset($agent_index[0])){
				$agent_name = $agent_array['_name'][$agent_index[0]];
				$agent_position = $agent_array['responsibility'][$agent_index[0]];
				$agent_nrc = $agent_array['id_number'][$agent_index[0]];
				
				$agent_site_index = array_keys($site_array['id'],$agent_array['site_id'][$agent_index[0]]);
				
				$agent_site_title = 'Unknown';
				if(isset($agent_site_index[0])){
					$agent_site_title = $site_array['title'][$agent_site_index[0]];
					
				}else{
					$data_index = array_keys($data_array['agent_id'],$agent_array['id'][$agent_index[0]]);
					
					if(isset($data_index[0])){
						$agent_data_site_index = array_keys($site_array['id'],$data_array['site_id'][$data_index[0]]);
						
						$agent_site_title = $site_array['title'][$agent_data_site_index[0]];
					}					
				}
			}
			
			$claim_type_index = array_keys($claim_type_array['_date'],$claims_beneficiary_array['type_date'][$beneficiary_index[$b]]);
			
			$claim_type_title = 'Claim type not found';
			if(isset($claim_type_index[0])){
				
				$claim_type_title = $claim_type_array['title'][$claim_type_index[0]];
			}
			
		
		$row_array[count($row_array)] = array($payment_claims_array['claim_id'][$c],$agent_name,$agent_nrc,$agent_position,$claim_region_title,$claim_province_title,$claim_hub_title,$claim_site_title,$agent_site_title,$claim_type_title,$unit_title,$claim_status,($payment_claims_array['level'][$c]+1),$claims_beneficiary_array['level'][$beneficiary_index[$b]],$claims_beneficiary_array['days'][$beneficiary_index[$b]],$claims_beneficiary_array['paid_days'][$beneficiary_index[$b]],$claims_beneficiary_array['amount'][$beneficiary_index[$b]],$payment_claims_array['amount'][$c],$claim_user,date('jS M, Y',$payment_claims_array['claim_date'][$c]));
		
		}
	}
}
$column_names = array('Claim number','Agent name','NRC','Agent Position','Claim Region','Claim Province','Claim Hub','Claim Site','Agent site','Claim Type','Claim Unit','Claim Status','Claim Level','Beneficiary level','Days worked','Payable days','Beneficiary Amount','Claim Amount','Creator','Date of creation');
$file_name = new_excel_export($column_names,$row_array,$formating);
header('location: '.$url.'/'.$file_name);
?>