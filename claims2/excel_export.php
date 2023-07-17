<?php
include 'scripts/connector.php';
//include 'scripts/functions.php';

$claim_date = $_GET['cd'];
$company_id = $_GET['c'];
$format = $_GET['f'];

$this_claim = mysqli_query($$module_connect,"select * from payment_claims where company_id = $company_id and _date = '$claim_date'")or die(mysqli_error($$module_connect));
$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);

if($format == 1){
	$table_columns = array('First_Name','Last_Name','ID_Type','ID_Number','Gender','Amount','Cell_Number','Reference');

	$columns_types = array(1,1,1,1,1,1,1,1);
	
	$claim_beneficiaries = mysqli_query($$module_connect,"select * from claim_beneficiaries where claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));

for($b=0;$b<mysqli_num_rows($claim_beneficiaries);$b++){
	$beneficiaries_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
	//$this_beneficiary_date = $beneficiaries_results['_date'];
	
	$agent_date = $beneficiaries_results['agent_date'];
	$this_agent = mysqli_query($connect,"select * from agents where _date = '$agent_date' and company_id = $company_id")or die(mysqli_error($pipat));
	$this_agent_results = mysqli_fetch_array($this_agent,MYSQLI_ASSOC);
	
	$id_type = $this_agent_results['id_type'];
	$this_id = mysqli_query($connect,"select * from id_types where id = $id_type")or die(mysqli_error($connect));
	$this_id_results = mysqli_fetch_array($this_id,MYSQLI_ASSOC);
	
	$gender_id = $this_agent_results['gender'];
	$gender = mysqli_query($connect,"select * from genders where id = $gender_id")or die(mysqli_error($connect));
	$gender_results = mysqli_fetch_array($gender,MYSQLI_ASSOC);
	
	$ben_name_array = explode(" ",$beneficiaries_results['_name']);
	$first_name = $ben_name_array[0];
	$last_name = $ben_name_array[count($ben_name_array) - 1];
	
	if($first_name == $last_name || $last_name == ''){
		$last_name = 'Unknown';
		
	}
	
	
	$info_array[$b] = array($first_name,$last_name,$this_id_results['title'],$this_agent_results['id_number'],$gender_results['title'],number_format($beneficiaries_results['amount'],2),$beneficiaries_results['phone'],$this_claim_results['claim_id']);

}

	
	
}else{
$table_columns = array('Beneficiary','Site','Hub','Province','Region','Claim_type','Days_worked','_From','_To','Daily_rate','Total_Amount_K','Comment','Current_level','Total_levels','Approvers','Creator');

$columns_types = array(1,1,1,1,1,1,1,1,1,1,1,2,1,1,2,1);



$creator_date = $this_claim_results['user_date'];
$this_creator = mysqli_query($connect,"select * from users where _date = '$creator_date' and company_id = $company_id")or die(mysqli_error($connect));
$this_creator_results = mysqli_fetch_array($this_creator,MYSQLI_ASSOC);

$region_id = $this_claim_results['region_id'];
$this_region = mysqli_query($connect,"select * from regions where id = $region_id")or die(mysqli_error($connect));
$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);

$province_id = $this_claim_results['province_id'];
$this_province = mysqli_query($connect,"select * from provinces where id = $province_id")or die(mysqli_error($connect));
$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);

$hub_id = $this_claim_results['hub_id'];
$this_hub = mysqli_query($connect,"select * from hubs where id = $hub_id")or die(mysqli_error($connect));
$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);

$site_id = $this_claim_results['site_id'];
$this_site = mysqli_query($connect,"select * from sites where id = $site_id")or die(mysqli_error($connect));
$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);

$claim_beneficiaries = mysqli_query($$module_connect,"select * from claim_beneficiaries where claim_date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));

for($b=0;$b<mysqli_num_rows($claim_beneficiaries);$b++){
	$beneficiaries_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
	$this_beneficiary_date = $beneficiaries_results['_date'];
	
	$claim_type_date = $beneficiaries_results['type_date'];
	$this_claim_type = mysqli_query($$module_connect,"select * from claim_types where _date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
	$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
	
	$approvers = 'No level approved';
	for($l=0;$l<$this_claim_type_results['approval_stages'];$l++){
		$level = $l+1;
		$check_approval = mysqli_query($$module_connect,"select * from claim_approvals where claim_date = '$claim_date' and beneficiary_date = '$this_beneficiary_date' and company_id = $company_id and level = $level")or die(mysqli_error($$module_connect));
		
		if(mysqli_num_rows($check_approval)){
			$check_approval_results = mysqli_fetch_array($check_approval,MYSQLI_ASSOC);
			
			$approval_user_date = $check_approval_results['user_date'];
			$approval_user = mysqli_query($connect,"select * from users where _date = '$approval_user_date' and company_id = $company_id")or die(mysqli_error($connect));
			$approval_user_results = mysqli_fetch_array($approval_user,MYSQLI_ASSOC);
			
			if($approvers == 'No level approved'){
				$approvers = 'Level '.$level.': '.$approval_user_results['_name'];
				
			}else{
				$approvers .= ', Level '.$level.': '.$approval_user_results['_name'];
			}
		}		
	}
	
	$check_last_approval = mysqli_query($$module_connect,"select * from claim_approvals where claim_date = '$claim_date' and beneficiary_date = '$this_beneficiary_date' and company_id = $company_id order by level desc")or die(mysqli_error($$module_connect));
	
	if(!mysqli_num_rows($check_last_approval)){
		$current_level = 1;
		
	}else{
		$check_last_approval_results = mysqli_fetch_array($check_last_approval,MYSQLI_ASSOC);
		$current_level = $check_last_approval_results['level']+1;
	}
	
	if($current_level == ($this_claim_type_results['approval_stages']+1)){
		$current_level = 'Completed';
		
	}
	
	
	$info_array[$b] = array($beneficiaries_results['_name'],$this_site_results['title'],$this_hub_results['title'],$this_province_results['title'],$this_region_results['title'],$this_claim_type_results['title'],$beneficiaries_results['days'],date('jS M - Y',$beneficiaries_results['_from']),date('jS M - Y',$beneficiaries_results['_to']),$this_claim_type_results['daily_rate'],number_format($beneficiaries_results['amount'],2),$beneficiaries_results['comment'],$current_level,$this_claim_type_results['approval_stages'],$approvers,$this_creator_results['_name']);

}
}
export_to_excel($table_columns,$columns_types,$info_array,0);
?>