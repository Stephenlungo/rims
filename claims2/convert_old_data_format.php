<?php
$company_id = 1;
include 'scripts/short_connector.php';
include '../scripts/bluerays_software/default_functions.php';
//include '../common_data_loop.php';

	$start_date = mktime(0,0,0,01,01,2015);
	$end_date = time();
	
	$this_default_agents_partition_name = $default_partition_names[2][1][0];
	
	$agent_partitions = fetch_database_partitions(2,$start_date,$end_date);
	
	$agent_array = array();
	for($a=0;$a<count($agent_partitions);$a++){
		$this_agents_table = $this_default_agents_partition_name.'_partition_'.$agent_partitions[$a];
		
		$agent_array[$a] = fetch_db_table('connect',$this_agents_table,1,'id','');
		
		//print($this_agents_table.' - '.count($agent_array[$a]['id']).'<br>');
	}
	
	$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
	$partitions = fetch_database_partitions(7,$start_date,$end_date);
	
	
	
	for($p=0;$p<count($partitions);$p++){
		
		$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[$p];

		$beneficiary_array = fetch_db_table('claims_connect',$claim_beneficiaries_table,1,'_name'," nrc = ''");
		
		
		
		for($b=0;$b<count($beneficiary_array['id']);$b++){
			$entry_id  = $beneficiary_array['id'][$b];
			
			$agent_date = $beneficiary_array['agent_date'][$b];
			
			
			for($ap=0;$ap<count($agent_partitions);$ap++){
				$agent_index = array_keys($agent_array[$ap]['_date'],$agent_date);
				
				if(isset($agent_index[0])){
					$this_agent_nrc = $agent_array[$ap]['id_number'][$agent_index[0]];
					//print(count($beneficiary_array['id']).'<br>');
					$update_old_beneficiary = mysqli_query($$module_connect,"update $claim_beneficiaries_table set nrc = '$this_agent_nrc' where id = $entry_id")or die(mysqli_error($$module_connect));
					
					print('Updated '.$beneficiary_array['_name'][$b].' - '.$this_agent_nrc.'<br>');
					
					break;
				}
			}
		}
	}
?>