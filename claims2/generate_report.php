<?php
include 'scripts/connector.php';
include '../common_data_loop.php';

$users = mysqli_query($connect,"select * from users where company_id = 1")or die(mysqli_error($connect));

$user_date_array = array();
$user_name_array = array();

for($u=0;$u<mysqli_num_rows($users);$u++){
	$user_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
	
	$user_date_array[$u] = $user_results['_date'];
	$user_name_array[$u] = $user_results['_name'];
	
}

$claim_approvals = mysqli_query($claims_connect,"select * from claim_approvals where status = 1 and validity = 1")or die(mysqli_error($claim_connect));

$approval_claim_date_array = array();
$approval_type_date_array = array();
$approval_agent_date_array = array();
$approval_user_date_array = array();
$approval_level_array = array();
$approval_date_array = array();

for($ca=0;$ca<mysqli_num_rows($claim_approvals);$ca++){
	$claim_approval_results = mysqli_fetch_array($claim_approvals,MYSQLI_ASSOC);
	
	$approval_claim_date_array[$ca] = $claim_approval_results['claim_date'];
	$approval_type_date_array[$ca] = $claim_approval_results['type_date'];
	$approval_agent_date_array[$ca] = $claim_approval_results['beneficiary_date'];
	$approval_user_date_array[$ca] = $claim_approval_results['user_date'];
	$approval_level_array[$ca] = $claim_approval_results['level'];
	$approval_date_array[$ca] = $claim_approval_results['_date'];
}


$payment_claims = mysqli_query($claims_connect,"select * from payment_claims where company_id = $company_id")or die(mysqli_error($claims_connect));

$claim_id_array = array();
$claim_date_array = array();
$claim_user_date_array = array();
$claim_region_array = array();
$claim_province_array = array();
$claim_hub_array = array();
$claim_site_array = array();

for($c=0;$c<mysqli_num_rows($payment_claims);$c++){
	$payment_claim_results = mysqli_fetch_array($payment_claims,MYSQLI_ASSOC);
	$claim_id_array[$c] = $payment_claim_results['claim_id'];
	$claim_date_array[$c] = $payment_claim_results['_date'];
	$claim_user_date_array[$c] = $payment_claim_results['user_date'];
	$claim_region_id_array[$c] = $payment_claim_results['region_id'];
	$claim_province_id_array[$c] = $payment_claim_results['province_id'];
	$claim_hub_id_array[$c] = $payment_claim_results['hub_id'];
	$claim_site_id_array[$c] = $payment_claim_results['site_id'];
}


$claim_beneficiaries = mysqli_query($claims_connect,"select * from claim_beneficiaries where company_id = 1 and status = 1 order by id desc")or die(mysqli_error($claims_connect));

$beneficiary_name_array = array();
$beneficiary_type_array = array();
$beneficiary_claim_date_array = array();
$beneficiary_level_array = array();
$beneficiary_creation_date_array = array();

$row_array = array();
for($b=0;$b<mysqli_num_rows($claim_beneficiaries);$b++){
	$entry_array = array();
	$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
	
	$claim_index =array_keys($claim_date_array,$claim_beneficiary_results['claim_date']);
	
	if(isset($claim_index[0])){
		$claim_id = $claim_id_array[$claim_index[0]];
		$claim_creation_date = date('jS M, Y',$claim_date_array[$claim_index[0]]);
		$claim_creation_time = date('H:i:s',$claim_date_array[$claim_index[0]]);
		$claim_creator_user_date = $claim_user_date_array[$claim_index[0]];
		
		$claim_hub_index = array_keys($hub_id_array,$claim_hub_id_array[$claim_index[0]]);
		
		if(isset($claim_hub_index[0])){
			$hub_name = $hub_name_array[$claim_hub_index[0]];
			
		}else{
			$hub_name = 'Unknown';
		}
		
	}else{
		$claim_id = 'Not found';
		$hub_name = 'Not found';
		$claim_creation_date = '';
		$claim_creator_user_date = '';
		
	}
	
	$approval_index = array_keys($approval_claim_date_array,$claim_beneficiary_results['claim_date']);
	
	
	$this_approval_index = array();
	for($ai=0;$ai<count($approval_index);$ai++){
		if(($approval_agent_date_array[$approval_index[$ai]] == $claim_beneficiary_results['agent_date'] || $approval_agent_date_array[$approval_index[$ai]] == 0) and $approval_type_date_array[$approval_index[$ai]] == $claim_beneficiary_results['type_date']){
			$this_approval_index[count($this_approval_index)] = $approval_index[$ai];
		}		
	}
	
	$level_approval_user_array = array();
	$level_approval_time_array = array();
	
	$level_approval_string = '';
	for($tai=0;$tai<count($this_approval_index);$tai++){
		$this_index = $this_approval_index[$tai];
		
		$this_approval_user_index = array_keys($user_date_array,$approval_user_date_array[$this_index]);
		
		
		
		if(isset($this_approval_user_index[0])){
			$this_user_name = $user_name_array[$this_approval_user_index[0]];
			
		}else{
			$this_user_name = 'User not found';
		}
		
		$level_approval_user_array[$approval_level_array[$this_index]] = $this_user_name;
		$level_approval_date_array[$approval_level_array[$this_index]] = date('jS M, Y',$approval_date_array[$this_index]);
		$level_approval_time_array[$approval_level_array[$this_index]] = date('H:i:s',$approval_date_array[$this_index]);
		
		/*if($level_approval_string == ''){
			$level_approval_string = 'Level '.($approval_level_array[$this_index]+1).' = '.$this_user_name.', Date: '.date('jS M, Y',$approval_date_array[$this_index]).', Time: '.date('H:i:s',$approval_date_array[$this_index]);
			
		}else{
			$level_approval_string .= ', Level '.($approval_level_array[$this_index]+1).' = '.$this_user_name.', Date: '.date('jS M, Y',$approval_date_array[$this_index]);			
		}*/
	}
	
	$this_creator_user_index = array_keys($user_date_array,$claim_creator_user_date);
	if(isset($this_creator_user_index[0])){
		$this_creator_name = $user_name_array[$this_creator_user_index[0]];
		
	}else{
		$this_creator_name = 'user not found';
		
	}
	
	
	$entry_array = array($hub_name,$claim_id,$this_creator_name,$claim_creation_date,$claim_creation_time,$claim_beneficiary_results['_name'],($claim_beneficiary_results['level']+1));
	
	
	for($ld=0;$ld<11;$ld++){
		if(isset($level_approval_user_array[$ld])){
			$this_level_approval_user =  $level_approval_user_array[$ld];
			$this_level_approval_date =  $level_approval_date_array[$ld];
			$this_level_approval_time =  $level_approval_time_array[$ld];
			
		}else{
			$this_level_approval_user = '';
			$this_level_approval_date =  '';
			$this_level_approval_time =  '';
		}	

		$entry_array[count($entry_array)] = $this_level_approval_user;
		$entry_array[count($entry_array)] = $this_level_approval_date;
		$entry_array[count($entry_array)] = $this_level_approval_time;
	}
	
	$row_array[count($row_array)] = $entry_array;
	
	//print('Hub: '.$hub_name.' - Claim Number: '.$claim_id.' - Name: '.$claim_beneficiary_results['_name'].' - Current Level: '.($claim_beneficiary_results['level']+1).'<br>'.$level_approval_string.'<br><br>');
	/*$beneficiary_name_array[$b] = $claim_beneficiary_results['_name'];
	$beneficiary_type_array[$b] = $claim_beneficiary_results['type_date'];
	$beneficiary_claim_date_array[$b] = $claim_beneficiary_results['claim_date'];
	$beneficiary_level_array[$b] = $claim_beneficiary_results['level'];
	$beneficiary_creation_date_array[$b] = $claim_beneficiary_results['creation_date'];*/
}

$column_names = array('Hub Name','Claim Number','Creator','Date Created','Time Created','Beneficiary Name','Current Level');
$formating = array(0,0,0,0,0,0,0,0);

for($ld=0;$ld<11;$ld++){
	$column_names[count($column_names)] = ' Level '.($ld+1);
	$column_names[count($column_names)] = ' Level '.($ld+1).' date';
	$column_names[count($column_names)] = ' Level '.($ld+1).' time';
	$formating[count($formating)] = 0;
	$formating[count($formating)] = 0;
	$formating[count($formating)] = 0;
}

//print(date('jS M, Y',1550147175).', Time: '.date('H:i:s',1550147175));
$file_name = new_excel_export($column_names,$row_array,$formating);

header('location: '.$url.'/'.$file_name);
?>