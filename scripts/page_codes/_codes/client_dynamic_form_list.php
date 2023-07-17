<?php
include 'item_details_1.php';

$user_array = fetch_db_table('connect','users',1,'id','');

$today_start = mktime(0,0,0,date('m',time()),date('j',time()),date('Y',time()));
$now = time();

if($client_date){
	$today_start = $client_date;
	$now = $client_date;
}

$this_default_partition_name = $default_partition_names[6][1][0];
$this_default_data_set_partition_name = $default_partition_names[5][1][1];

$partitions = fetch_database_partitions(6,$today_start,$now);
$data_set_partitions = fetch_database_partitions(5,$today_start,$now);

$dynamic_form_values_table = $this_default_partition_name.'_partition_'.$partitions[0];
$dynamic_form_data_sets_table = $this_default_data_set_partition_name.'_partition_'.$data_set_partitions[0];

$form_values = fetch_db_table('connect',$dynamic_form_values_table,1,'id','dynamic_form_id  = '.$form_id.' and client_id = '.$client_id.' and (dynamic_form_category_option_id = 341 || dynamic_form_category_option_id = 347 || dynamic_form_category_option_id = 340 || dynamic_form_category_option_id = 348 or dynamic_form_category_option_id = 492 or dynamic_form_category_option_id = 508 or dynamic_form_category_option_id = 524 or dynamic_form_category_option_id = 540 or dynamic_form_category_option_id = 556 or dynamic_form_category_option_id = 572 or dynamic_form_category_option_id = 588 or dynamic_form_category_option_id = 604 or dynamic_form_category_option_id = 620 or dynamic_form_category_option_id = 636 or dynamic_form_category_option_id = 652 or dynamic_form_category_option_id = 668 or dynamic_form_category_option_id = 684 or dynamic_form_category_option_id = 700)');



$data_sets = fetch_db_table('connect',$dynamic_form_data_sets_table,1,'id','dynamic_form_id  = '.$form_id.' and client_id = '.$client_id);

$asset_array = array();
$form_dates = array();
$last_data_set_date = time();
for($d=0;$d<count($data_sets['id']);$d++){
	$form_dates[count($form_dates)] = $form_values['_value'][$d];
	$asset_array[$form_values['_value'][$d]] = array($data_sets['id'][$d],$data_sets['_date'][$d],$data_sets['user_id'][$d],$data_sets['entry_method'][$d]);
	
	$last_data_set_date = $data_sets['_date'][$d];
}

rsort($form_dates);

$original_data_sets = fetch_db_table('connect','dynamic_form_data_sets',1,'id','dynamic_form_id  = '.$form_id.' and client_id = '.$client_id.' and _date > '.$last_data_set_date);

/*
if(count($original_data_sets['id'])){
	
	?>
	<div style="width:100%;height:50px;line-height:50px;float:left;text-align:center;font-size:1.5em;margin-top:40px;color:brown;">Re-organizing data sets for this client for better performance. Please <strong>DO NOT</strong> close this window.<br>Please wait...</div>
	<script>
		reorganise_data_sets(<?php print($client_id.','.$client_date.','.$last_data_set_date.','.$form_id);?>);
	</script>
	<?php
	exit;
	
}



$form_dates_2 = array();
$asset_array_2 = array();
if(count($original_data_sets['id'])){
	$form_values_2 = fetch_db_table('connect','dynamic_form_values',1,'id','_date > '.$last_data_set_date.' and dynamic_form_id  = '.$form_id.' and client_id = '.$client_id.' and (dynamic_form_category_option_id = 341 || dynamic_form_category_option_id = 347 || dynamic_form_category_option_id = 340 || dynamic_form_category_option_id = 348 or dynamic_form_category_option_id = 492 or dynamic_form_category_option_id = 508 or dynamic_form_category_option_id = 524 or dynamic_form_category_option_id = 540 or dynamic_form_category_option_id = 556 or dynamic_form_category_option_id = 572 or dynamic_form_category_option_id = 588 or dynamic_form_category_option_id = 604 or dynamic_form_category_option_id = 620 or dynamic_form_category_option_id = 636 or dynamic_form_category_option_id = 652 or dynamic_form_category_option_id = 668 or dynamic_form_category_option_id = 684 or dynamic_form_category_option_id = 700)');
	
	for($d=0;$d<count($original_data_sets['id']);$d++){
		$form_dates_2[count($form_dates_2)] = $form_values_2['_value'][$d];
		$asset_array_2[$form_values_2['_value'][$d]] = array($original_data_sets['id'][$d],$original_data_sets['_date'][$d],$original_data_sets['user_id'][$d],$original_data_sets['entry_method'][$d]);

	}
}
rsort($form_dates_2);
*/
?>


<div style="width:100%;height:30px;line-height:30px;float:left;font-size:1.3em;margin-top:5px;"><div style="width:auto;heigth:auto;float:left;"><?php print($this_form_results['form_title']);?> forms for this client</div>

<?php
if(!count($data_sets['id']) || $this_form_results['data_processing_method'] == 1){
	?>

<div style="width:102px;height:25px;margin-top:2px;background-color:#006bb3;color:#fff;text-align:center;line-height:25px;float:right;margin-right:5px;cursor:pointer;font-size:0.7em;" onmouseover="this.style.backgroundColor='#2084c7';" onmouseout="this.style.backgroundColor='#006bb3';" title="Click to create new form" onclick="fetch_dynamic_form_details(<?php print($form_id.',0,'.$client_date);?>)">Fill in new form</div>
<?php
}
?>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:100px;height:20px;float:left;margin-right:3px;">Date entered</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Time entered</div>
<div style="width:190px;height:20px;float:left;margin-right:3px;">Date of investigation in form</div>

<div style="width:200px;height:20px;float:left;margin-right:3px;">Entered by</div>
<div style="width:180px;height:20px;float:left;margin-right:3px;">Phone number</div>
<div style="width:180px;height:20px;float:left;margin-right:3px;">Entry method</div>
</div>

<?php
if(!count($data_sets['id'])){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;font-weight:bold;text-align:center;">No records were found</div>
	<?php
}else{
	for($ds=0;$ds<count($form_dates);$ds++){
		$this_entry = $asset_array[$form_dates[$ds]];
		
		$set_user_id = $this_entry[2];
		
		if($this_entry[3] == 2){
			$user_table = 'agents';
			
		}else{
			$user_table = 'users';
			
		}
		
		$user_index = array_keys($user_array['id'],$set_user_id);
		
		$set_user_full_name = 'Unknown';
		$set_user_phone = 'Unknown';
		if(isset($user_index[0])){
			$set_user_full_name = $user_array['_name'][$user_index[0]];
			$set_user_phone = $user_array['phone'][$user_index[0]];
		}
		
		if($this_entry[3] == 1){
			$background_color = '#fee';
			
		}else{
			$background_color = '';
			
		}
		
		$entry_method_title = 'Unknown';
		if($this_entry[3] == 0){
			$entry_method_title = 'Live system';
			
		}else if($this_entry[3] == 1){
			$entry_method_title = 'Offline system';
			
		}else if($this_entry[3] == 2){
			$entry_method_title = 'USSD';
			
		}
		
		?>
			<div style="cursor:pointer;width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;background-color:<?php print($background_color);?>" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='<?php print($background_color);?>'" title="Click to view this form" onclick="fetch_dynamic_form_details(<?php print($form_id.','.$this_entry[0].','.$client_date);?>)">
				<div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$this_entry[1]));?></div>
				<div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('H:i:s',$this_entry[1]));?></div>
				<div style="width:190px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$form_dates[$ds]));?></div>
				<div style="width:200px;height:20px;float:left;margin-right:3px;"><?php print($set_user_full_name);?></div>
				<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print($set_user_phone);?></div>
				<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print($entry_method_title);?></div>
			</div>
		<?php
	}
	
	/*
	for($ds=0;$ds<count($form_dates_2);$ds++){
		$this_entry = $asset_array_2[$form_dates_2[$ds]];
		
		$set_user_id = $this_entry[2];
		
		if($this_entry[3] == 2){
			$user_table = 'agents';
			
		}else{
			$user_table = 'users';
			
		}
		
		$user_index = array_keys($user_array['id'],$set_user_id);
		
		$set_user_full_name = 'Unknown';
		$set_user_phone = 'Unknown';
		if(isset($user_index[0])){
			$set_user_full_name = $user_array['_name'][$user_index[0]];
			$set_user_phone = $user_array['phone'][$user_index[0]];
		}

		if($this_entry[3] == 1){
			$background_color = '#fee';
			
		}else{
			$background_color = '';
			
		}
		
		$entry_method_title = 'Unknown';
		if($this_entry[3] == 0){
			$entry_method_title = 'Live system';
			
		}else if($this_entry[3] == 1){
			$entry_method_title = 'Offline system';
			
		}else if($this_entry[3] == 2){
			$entry_method_title = 'USSD';
			
		}
		
		?>
			<div style="cursor:pointer;width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;background-color:<?php print($background_color);?>" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='<?php print($background_color);?>'" title="Click to view this form" onclick="fetch_dynamic_form_details(<?php print($form_id.','.$this_entry[0].','.$this_entry[1]);?>)">
				<div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$this_entry[1]));?></div>
				<div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('H:i:s',$this_entry[1]));?></div>
				<div style="width:190px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$form_dates_2[$ds]));?></div>
				<div style="width:200px;height:20px;float:left;margin-right:3px;"><?php print($set_user_full_name);?></div>
				<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print($set_user_phone);?></div>
				<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print($entry_method_title);?></div>
			</div>
		<?php
	}*/
}
?>
