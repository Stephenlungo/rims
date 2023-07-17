<?php

$current_month = date('m',time());
$current_year = date('y',time());
$last_month = $current_month -1;

if($last_month == 0){
	$last_month = 12;
	$current_year = $current_year-1;
}

$month_time = mktime(0,0,0,$last_month,1,$current_year);

$this_folder = fetch_db_table('connect','payment_folders',$company_id,'id','id = '.$folder_id);
$agent_types = fetch_db_table('connect','agent_types',$company_id,'id','');
$folder_months = fetch_db_table('connect','payment_folder_months',$company_id,'id','status = 1');

$folder_month_exceptions_array = array();

$claim_exists = 0;
$claim_id = 0;
if($batching_style == 0){
	$check_claim_data_sets = fetch_db_table('connect','payment_folder_data_sets',$company_id,'id desc','status != 0 and folder_id = '.$folder_id);

	if(count($check_claim_data_sets['id'])){
		$data_set_user = fetch_db_table('connect','users',$company_id,'id desc','id = '.$check_claim_data_sets['user_id'][0]);
		
		$this_folder_claim_data_set_id = $check_claim_data_sets['id'][0];
		
		$this_claim_data = fetch_db_table('connect','payment_folder_data',$company_id,'id desc','data_set_id = '.$this_folder_claim_data_set_id);
		
		
		for($fe=0;$fe<count($check_claim_data_sets['id']);$fe++){
			$folder_month_exceptions_array[count($folder_month_exceptions_array)] = $check_claim_data_sets['id'][$fe];
		}
		
		$check_with_claim = array_keys($check_claim_data_sets['status'],2);
		
		if(isset($check_with_claim[0])){
			$claim_id = $check_claim_data_sets['claim_id'][$check_with_claim[0]];
		
			$data_set_date = $check_claim_data_sets['_date'][$check_with_claim[0]];
			$claim_exists = 1;
		}
	}
}

$current_folder_month = fetch_db_table('connect','payment_folder_months',$company_id,'id',"month = '".$last_month.'-'.$current_year."'");

if(count($current_folder_month['id'])){
	$this_month_id = $current_folder_month['id'][0];
	$this_month_title = $current_folder_month['title'][0];
}

if($this_folder['budget_limit'][0] == 0){
	$budget_limit = 'Nnlimited';
	
}else{
	$budget_limit = $this_folder['budget_limit'][0];///12;
	
}


?>
<div style="width:100%;height:30px;line-height:30px;float:left;margin-bottom:20px;">

	<div style="width:auto;height:auto;float:left;margin-bottom:2px;">
	<div style="width:50px;height:30px;line-height:30px;float:left;">Month:</div>
	<div style="width:60px;min-height:30px;height:auto;float:left;line-height:30px;">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#folder_month_menu').slideToggle('fast');" id="active_folder_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:60px;max-width:60px;width:auto;"><?php print($this_month_title);?></div>

				<div class="option_menu" id="folder_month_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
					<?php
					for($m=0;$m<count($folder_months['id']);$m++){
						?>
					
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_month_menu').toggle('fast');$('#active_folder_month').html($(this).html());$('#selected_folder_month').val(<?php print($folder_months['id'][$m]);?>);"><?php print($folder_months['title'][$m]);?></div>
					
					<?php
						
						if($folder_months['month'][$m] == $current_month.'-'.date('y',time())){
							break;
						}
					}
					?>
				</div>
		</div>
		<input type="hidden" id="selected_folder_month" value="<?php print($this_month_id);?>">
	</div>
	</div>

	<div style="width:120px;float:left;margin-left:20px;">Month budget limit:</div>
	<div style="width:100px;float:left;">K<?php print(number_format($budget_limit,2));?></div>


	<div style="width:80px;float:left;margin-left:20px;">Claim value:</div>
	<div style="width:100px;float:left;" id="claim_value"></div>

	<div style="width:70px;float:left;margin-left:20px;">Balance:</div>
	<div style="width:100px;float:left;" id="claim_balance"></div>
</div>

<div style="width:100%;height:auto;line-height:15px;color:red;display:none;font-weight:bold;" id="claim_error_message"></div>

<?php
if($batching_style == 0 and count($check_claim_data_sets['id'])){
	?>
	<div style="width:100%;height:20px;float:left;line-height:20px;float:left;color:purple;">Days pre-populated based on data saved by <?php print($data_set_user['_name'][0].' on '.date('jS M, Y',$check_claim_data_sets['_date'][0]).' at '.date('H:i:s',$check_claim_data_sets['_date'][0]).' | <a onclick="var c = confirm(\'Are you sure you wish to reset days on this batch for all agents to default?\');if(c){batch_folder_agents(1);}" style="cursor:pointer;color:brown">Reset all</a> |');?></div>
<?php
}
?>


<input type="hidden" id="budget_limit" value="<?php print($budget_limit);?>">

<?php

$claim_value = 0;

if($this_folder['claim_type_string'][0] == '' and $this_folder['agent_entries'][0] != ''){
	
	
	
}else{
	$this_folder_agent_array = explode(',',$this_folder['agent_entries'][0]);
	sort($this_folder_agent_array);
	
	$agent_date_string = '(_date = '.str_replace(","," or _date = ",$this_folder['agent_entries'][0]).')';
	
	$phone_agent_date_string = '(agent_date = '.str_replace(","," or agent_date = ",$this_folder['agent_entries'][0]).')';
	

	$this_default_agents_partition_name = $default_partition_names[2][1][0];
	$this_default_phone_partition_name = $default_partition_names[2][1][1];

	$start_date = $this_folder_agent_array[0];
	$end_date = $this_folder_agent_array[count($this_folder_agent_array)-1];
	
	$days_from = mktime(0,0,0,date('m',time()),1,date('Y',time()));
	$days_to = mktime(23,59,59,date('m',time()),date('t',time()),date('Y',time()));
	
	$partitions = fetch_database_partitions(2,$start_date,$end_date);
	
	for($pat=0;$pat<count($partitions);$pat++){
		$agents_table = $this_default_agents_partition_name.'_partition_'.$partitions[$pat];
		$phone_number_table = $this_default_phone_partition_name.'_partition_'.$partitions[$pat];
		
		$agents_array[$pat] = fetch_db_table('connect',$agents_table,$company_id,'id',$agent_date_string);
		
		$phone_number_array[$pat] = fetch_db_table('connect',$phone_number_table,$company_id,'id',$phone_agent_date_string);
	}
	
	$this_pipat_claims_database_ip = getenv('PIPAT_CLAIMS_DATABASE_IP');
	$this_pipat_claims_database_name = getenv('PIPAT_CLAIMS_DATABASE_NAME');
	$this_pipat_claims_database_username = getenv('PIPAT_CLAIMS_DATABASE_USERNAME');
	$this_pipat_claims_database_password = getenv('PIPAT_CLAIMS_DATABASE_PASSWORD');

	$claims_connect = mysqli_connect($this_pipat_claims_database_ip,$this_pipat_claims_database_username,$this_pipat_claims_database_password);
	mysqli_query($claims_connect,'use '.$this_pipat_claims_database_name)or die(mysqli_error($claims_connect));
	
	
	
	if($claim_exists){
		$this_default_claims_partition_name = $default_partition_names[7][1][0];
		$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
		
		$claim_partitions = fetch_database_partitions(7,$data_set_date,$data_set_date);
		$payment_claims_table = $this_default_claims_partition_name.'_partition_'.$claim_partitions[0];
		$claims_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$claim_partitions[0];
		
		$this_claim = mysqli_query($claims_connect,"select * from $payment_claims_table where claim_id = $claim_id")or die(mysqli_error($claims_connect));
		
		$this_claim_results = mysqlI_fetch_array($this_claim,MYSQLI_ASSOC);
		$claim_date = $this_claim_results['_date'];
		
		$claim_beneficiaries = mysqli_query($claims_connect,"select * from $claims_beneficiaries_table where claim_date = '$claim_date'")or die(mysqli_error($claims_connect));
		
		$ben_array_date = array();
		$ben_claim_type_array = array();
		
		for($ben=0;$ben<mysqli_num_rows($claim_beneficiaries);$ben++){
			$claim_beneficiaries_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);
			
			$ben_array_date[count($ben_array_date)] = $claim_beneficiaries_results['agent_date'];
			$ben_claim_type_array[count($ben_claim_type_array)] = $claim_beneficiaries_results['type_date'];
		}
		
	}
	
	
	
	$claim_types = mysqli_query($claims_connect,"select * from request_types order by title")or die(mysqli_error($claims_connect));
	
	$claim_type_id_array = array();
	$claim_type_title_array = array();
	$claim_type_billing_type_array = array();
	$claim_type_daily_rate_array = array();
	$claim_type_fixed_amount_array = array();
	
	for($c=0;$c<mysqli_num_rows($claim_types);$c++){
		$claim_type_results = mysqli_fetch_array($claim_types,MYSQLI_ASSOC);
		
		$claim_type_id_array[$c] = $claim_type_results['id'];
		$claim_type_title_array[$c] = $claim_type_results['title'];
		$claim_type_billing_type_array[$c] = $claim_type_results['billing_type'];
		$claim_type_daily_rate_array[$c] = $claim_type_results['daily_rate'];
		$claim_type_fixed_amount_array[$c] = $claim_type_results['fixed_amount'];
		
	}
	
	$folder_claim_type_array = explode(',',$this_folder['claim_type_string'][0]);
	
	
	for($c=0;$c<count($folder_claim_type_array);$c++){
		
		$claim_agent_string = '';
		
		$total_claim_type_agents = 0;
		
		$this_claim_type_array = explode('-',$folder_claim_type_array[$c]);
		$this_agent_group = $this_claim_type_array[0];
		$this_claim_type_id = $this_claim_type_array[1];
		
		$this_claim_type_index = array_keys($claim_type_id_array,$this_claim_type_id);
		
		
		$this_claim_type_name = 'Not found';
		$this_claim_billing_type_name = 'N/A';
		$this_claim_daily_rate = 'N/A';
		$this_claim_fixed_amount = 'N/A';
		if(isset($this_claim_type_index[0])){
			$this_claim_type_name = $claim_type_title_array[$this_claim_type_index[0]];
			$this_claim_billing_type_name = $claim_type_billing_type_array[$this_claim_type_index[0]];
			$this_claim_daily_rate = $claim_type_daily_rate_array[$this_claim_type_index[0]];
			$this_claim_fixed_amount = $claim_type_fixed_amount_array[$this_claim_type_index[0]];
			
		}
		
		
		$agent_type_index = array_keys($agent_types['id'],$this_agent_group);
		
		?>
		<div style="width:100%;height:auto;float:left;margin-bottom:15px;">
		<div style="width:100%;height:25px;line-height:25px;background-color:#6c9dbe;color:#fff;float:left;cursor:pointer;" title="Click to colapse/expand" onclick="$('#claim_type_holder_<?php print($c);?>').slideToggle('fast');"><?php print($this_claim_type_name.' - <i>[System agent group: '.$agent_types['title'][$agent_type_index[0]].' - Total agents: <font id="total_agent_'.$c.'"></font>]</i>');?></div>
		
		<div style="width:100%;height:auto;float:left;display:none;" id="claim_type_holder_<?php print($c);?>">
			<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;background-color:#eef;">
				<div style="width:180px;height:auto;float:left;">Name</div>
				<div style="width:180px;height:auto;margin-left:2px;float:left;">Phone</div>
				<div style="width:180px;height:auto;margin-left:2px;float:left;">NRC</div>
				<div style="width:100px;height:auto;margin-left:2px;float:left;">Payable</div>
				<div style="width:100px;height:auto;margin-left:2px;float:left;">Amount</div>
			</div>
			
			<div style="width:100%;float:left;max-height:300px;height:auto;overflow:auto;">
			<div style="width:100%;height:20px;line-height:20px;float:left;margin-top:2px;margin-bottom:2px;">
				<?php
				if($active_user_roles[8]){
					?>
				
					<div style="width:190px;height:20px;float:right;background-color:purple;text-align:center;margin-bottom:5px;color:#fff;cursor:pointer" onclick="restore_folder_claim_beneficiaries(<?php print($folder_id.','.$this_claim_type_id.','.$c);?>)" id="restore_beneficiaries_button_<?php print($c);?>">Restore beneficiaries on claim</div>
				
					<?php
				}
				?>
			</div>
				<?php
				
				for($a=0;$a<count($this_folder_agent_array);$a++){
					$agent_include = 0;
					$phone_number = 'Unset';
					$days = 12;
					
					$color = '#000';
					if($claim_exists){
						$ben_index = array_keys($ben_array_date,$this_folder_agent_array[$a]);
						
						if(isset($ben_index[0])){
							$color = '#006bb3';
							
						}
						
					}
					
					if($batching_style == 0){
						if(count($check_claim_data_sets['id'])){
							$claim_data_agent_index = array_keys($this_claim_data['agent_date'],$this_folder_agent_array[$a]);
							
							if(isset($claim_data_agent_index[0])){
								
								for($ac=0;$ac<count($claim_data_agent_index);$ac++){
									
									if($this_claim_data['claim_type_id'][$claim_data_agent_index[$ac]] == $this_claim_type_id){
										
										$days = $this_claim_data['payable_days'][$claim_data_agent_index[$ac]];
										
										break;
									}
								}
							}
						}
					}
					
					for($pat=0;$pat<count($partitions);$pat++){
						$agent_index = array_keys($agents_array[$pat]['_date'],$this_folder_agent_array[$a]);
						
						$phone_number_index = array_keys($phone_number_array[$pat]['agent_date'],$this_folder_agent_array[$a]);
						
						if(isset($phone_number_index[0])){
							$phone_number = $phone_number_array[$pat]['phone_number'][$phone_number_index[0]];
							
						}
						
						if(isset($agent_index[0])){
							
							$this_agent_types_array = explode(',',$agents_array[$pat]['agent_type_id'][$agent_index[0]]);
							
							$this_agent_group_index = array_keys($this_agent_types_array,$this_agent_group);
							
							if(isset($this_agent_group_index[0])){
								
								$agent_include = 1;
								
								
								$this_agent_id = $agents_array[$pat]['id'][$agent_index[0]];
								
								$this_agent_date = $this_folder_agent_array[$a];
								$total_claim_type_agents++;
								//$days = calculate_days_worked($this_agent_id,$days_from,$days_to,0);
								
								if($claim_agent_string == ''){
									$claim_agent_string = $this_agent_date;
									
								}else{
									$claim_agent_string .= ','.$this_agent_date;
									
								}
							}
							
							break;
						}
					}
					
					$total_amount = $this_claim_fixed_amount;
					$days_input_disabled = ' disabled ';
					if($this_claim_billing_type_name == 0){
						$total_amount = $days * $this_claim_daily_rate;
						
						$days_input_disabled = '';
					}
					
					if($agent_include){
						?>
						<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;color:<?php print($color);?>">
							<div style="width:180px;height:auto;float:left;"><?php print($agents_array[$pat]['_name'][$agent_index[0]]);?></div>
							<div style="width:180px;height:auto;margin-left:2px;float:left;"><?php print($phone_number);?></div>
							<div style="width:180px;height:auto;margin-left:2px;float:left;"><?php print($agents_array[$pat]['id_number'][$agent_index[0]]);?></div>
							<div style="width:100px;height:auto;margin-left:2px;float:left;"><input type="text" style="width:100%;" value="<?php print($days);?>" onfocus="if(this.value=='<?php print($days);?>'){this.value=''};" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='<?php print($days);?>'};" onchange="calculate_ben_amount(<?php print($c.','.$this_agent_date);?>);" id="agent_days_<?php print($c.'_'.$this_agent_date);?>" <?php print($days_input_disabled);?>></div>
							<div style="width:100px;height:auto;margin-left:2px;float:left;text-align:right;" id="beneficiary_amount_<?php print($c.'_'.$this_agent_date);?>"><?php print(number_format($total_amount,2));?></div>
						</div>
						<input type="hidden" id="agent_date_<?php print($c.'_'.$a);?>" value="<?php print($this_agent_date);?>">
						<?php
					}
				}
				?>
			</div>
		<input type="hidden" id="claim_type_daily_rate_<?php print($c);?>" value="<?php print($this_claim_daily_rate);?>">
		
		<script>$('#total_agent_<?php print($c);?>').html('<?php print($total_claim_type_agents);?>');</script>	
		
		<input type="hidden" id="claim_agent_string_<?php print($c);?>" value="<?php print($claim_agent_string);?>">
		<input type="hidden" id="folder_claim_type_id_<?php print($c);?>" value="<?php print($this_claim_type_id);?>">
		
	</div>
	</div>
		<?php
		
		
	}
	?>
	<div style="width:100%;height:auto;float:left;margin-top:25px;" >
		<div style="width:auto;height:auto;float:left;" id="saving_options">
			<div style="width:90px;height:30px;background-color:#a64d79;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#c27ba0'" onmouseout="this.style.backgroundColor='#a64d79'" id="create_folder_claim_button" onclick="create_claim_from_folder(<?php print($folder_id);?>)" title="Click to proceed">Create claim</div>
		</div>

	<div style="width:90px;height:30px;background-color:purple;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;margin-left:5px;" onmouseover="this.style.backgroundColor='#b34444'" onmouseout="this.style.backgroundColor='purple'" onclick="save_folder_claim_data(<?php print($folder_id);?>)" title="Click to proceed" id="save_folder_claim_data_button">Save</div>

	</div>
	<?php
}

?>
<input id="total_claim_types" value="<?php print(count($folder_claim_type_array));?>" type="hidden">
<script>
function calculate_ben_amount(claim_type_index,agent_date){
	
	var new_amount = Number($('#agent_days_'+claim_type_index+'_'+agent_date).val()) * Number($('#claim_type_daily_rate_'+claim_type_index).val());
	
	$('#beneficiary_amount_'+claim_type_index+'_'+agent_date).html(new_amount.toFixed(2));
	
	calculate_claim_value();
	
}

function calculate_claim_value(){
	var total_value = 0;
	
	var total_claim_types = Number($('#total_claim_types').val());
	
	for(var c=0;c<total_claim_types;c++){
		var claim_agents = $('#claim_agent_string_'+c).val();
		
		if($('#claim_agent_string_'+c).val() != ''){
			var claim_agents_array = claim_agents.split(',');
			
			for(var a =0; a<claim_agents_array.length;a++){
				
				var this_value = $('#beneficiary_amount_'+c+'_'+claim_agents_array[a]).html();
				
				if(this_value == undefined){
					alert(claim_agents_array[a]);
				}
				
				this_value = this_value.replace(",","");
				
				this_value = Number(this_value);
				
				total_value = total_value+this_value;
			}
		}
	}
	
	//alert(total_value);
	
	$('#claim_value').html('K'+total_value.toFixed(2));
	
	var claim_balance = Number($('#budget_limit').val())-total_value;
	
	$('#claim_balance').html('K'+claim_balance.toFixed(2));
	
	$('#claim_balance').css('color','green');
	$('#claim_error_message').slideUp('fast');
	$('#saving_options').slideDown('fast');
	if(claim_balance < 0){
		$('#claim_balance').css('color','red');
		
		$('#claim_error_message').html('You cannot proceed with this claim creation because the budget limit has been exceeded. Please edit beneficiary amounts until claim value is less than or equal to the budget limit');
		
		$('#claim_error_message').slideDown('fast');
		
		$('#saving_options').slideUp('fast');
	}
}

calculate_claim_value();
</script>