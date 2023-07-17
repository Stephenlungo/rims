<?php
$request_type_ids = explode(',',$this_meeting_results['request_type_ids']);

$meeting_participants_array = fetch_db_table('connect','meeting_participants',$company_id,'id',' meeting_id = '.$meeting_id.' and status = 2');

$meeting_from = $this_meeting_results['_from'];
$meeting_to = $this_meeting_results['_to'];

$agent_string = '';
$start_date = time();
$end_date = 0;
for($p=0;$p<count($meeting_participants_array['id']);$p++){
	
	if($meeting_participants_array['agent_date'][$p] < $start_date){
		$start_date = $meeting_participants_array['agent_date'][$p];
		
	}
	
	if($meeting_participants_array['agent_date'][$p] > $end_date){
		$end_date = $meeting_participants_array['agent_date'][$p];
		
	}
}

$this_default_agents_partition_name = $default_partition_names[2][1][0];
$this_default_phone_number_partition_name = $default_partition_names[2][1][1];
$partitions = fetch_database_partitions(2,$start_date,$end_date);

$agents_array = array();
$phone_array = array();
for($pat=0;$pat<count($partitions);$pat++){
	$agents_table = $this_default_agents_partition_name.'_partition_'.$partitions[$pat];
	$phone_number_table = $this_default_phone_number_partition_name.'_partition_'.$partitions[$pat];
	
	$agents_array[$pat] = fetch_db_table('connect',$agents_table,$company_id,'id','');
	//$phone_number_array[$pat] = fetch_db_table('connect',$phone_number_table,$company_id,'id','');
}


for($r=0;$r<count($request_type_ids);$r++){
	$this_request_type_id = $request_type_ids[$r];
	
	$this_request_type = mysqli_query($$module_connect,"select * from request_types where id = $this_request_type_id")or die(mysqli_error($connect));
	$this_request_type_results = mysqli_fetch_array($this_request_type,MYSQLI_ASSOC);
	
	$amount = $this_request_type_results['daily_rate'];
	if($this_request_type_results['billing_type']){
		$amount = $this_request_type_results['fixed_amount'];
	}
	
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><?php print($this_request_type_results['title'].' (K'.number_format($amount,2).')');?></div>
	
	<div style="width:100%;float:left;height:20px;background-color:#f3fced">						
		<div style="width:180px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Name</div>
		<div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">NRC</div>
		<div style="width:150px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Phone</div>
		<div style="width:120px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">From</div>
		<div style="width:120px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">To</div>
		<div style="width:100px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;">Days</div>
		<div style="width:100px;height:20px;line-height:20px;float:left;text-align:right;">P.days</div>
		<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;">Amount(K)</div>
	</div>
	
	<?php
	
	for($p=0;$p<count($meeting_participants_array['id']);$p++){
		$this_agent_date = $meeting_participants_array['agent_date'][$p];
		$form_options = explode(',',$meeting_participants_array['form_options'][$p]);
		
		$agent_name = 'Unknown agent';
		$agent_id_number = 'Not found';
		$agent_phone = 'Not found';
		
		for($pat=0;$pat<count($partitions);$pat++){
			$agent_index = array_keys($agents_array[$pat]['_date'],$this_agent_date);
			
			if(isset($agent_index[0])){
				$agent_name = $agents_array[$pat]['_name'][$agent_index[0]];
				$agent_id_number = $agents_array[$pat]['id_number'][$agent_index[0]];
				$agent_phone = '26'.$form_options[8];
				break;
			}
		}
		
		$days = 0;
		$total_amount = $days * $amount;
		?>
		<div style="width:100%;float:left;height:20px;border-bottom:solid 1px #eee;">						
			<div style="width:180px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print($agent_name);?></div>
			<div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print($agent_id_number);?></div>
			<div style="width:150px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print($agent_phone);?></div>
			<div style="width:120px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print(date('dS M, Y',$meeting_from));?></div>
			<div style="width:120px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;"><?php print(date('dS M, Y',$meeting_to));?></div>
			<div style="width:100px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;">0</div>
			<div style="width:100px;height:20px;line-height:20px;float:left;text-align:right;">0</div>
			<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;"><?php print(number_format($total_amount,0));?></div>
		</div>
		<?php
	}
}
?>