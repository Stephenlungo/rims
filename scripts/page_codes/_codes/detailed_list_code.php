<?php
//print($search_string);
$last_id = $last_entry_id;
$current_date = $last_date;

if($database_id == 0){
	$database_table = '_data_new';
	
}else{
	$database_table = '_data';
	
}


$data = mysqli_query($connect,"select * from $database_table where _date > $last_entry_id and company_id = $company_id $search_string order by _date desc")or die(mysqli_error($connect));

$days_worked = 0;
$total_value = 0;
$results_unit_filter = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#filter_unit_holder\').fadeOut(\'fast\');$(\'#filter_unit_menu\').toggle(\'fast\');$(\'#results_filter_unit_icon\').fadeOut(\'fast\');$(\'#selected_results_filter_unit\').val(0);fetch_detailed_list();">All</div>';
if(!mysqli_num_rows($data)){
	if(!$last_entry_id){
?>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;text-align:center;color:red">No records were found</div>

<?php
	}
}else{
	$start_date = mktime(0,0,0,1,1,2015);
	$end_date = time();
	
	$this_default_agents_partition_name = $default_partition_names[2][1][0];
		
	$partitions = fetch_database_partitions(2,$start_date,$end_date);

	$agents_array = array();
	for($pat=0;$pat<count($partitions);$pat++){
		$this_agents_table = $this_default_agents_partition_name.'_partition_'.$partitions[$pat];
		$agents_array[$pat] = fetch_db_table('connect',$this_agents_table,1,'id','');
	}
	
	$end_count = mysqli_num_rows($data);
	
	if($end_count > 100){
		$end_count = 101;
	}
	
	for($d=0;$d<$end_count;$d++){
		$data_results = mysqli_fetch_array($data,MYSQLI_ASSOC);
		
		
		
		if(!$d){
			$last_id = $data_results['_date'];
		}
		
		
		if($current_date != date('j',$data_results['_date'])){
			$days_worked++;
			//print('<font color="red">('.$current_date.' - '.date('j',$data_results['_date']).')</font>');
		}
		
		$province_title = '<i>Unknown</i>';
		$province_index = array_keys($province_array['id'],$data_results['province_id']);
		if(isset($province_index[0])){
			$province_title = $province_array['title'][$province_index[0]];
		}
		
		$hub_title = '<i>Unknown</i>';
		$hub_index = array_keys($hub_array['id'],$data_results['hub_id']);
		
		if(isset($hub_index[0])){
			$hub_title = $hub_array['title'][$hub_index[0]];
		}
		
		$site_title = '<i>Unknown</i>';
		$site_index = array_keys($site_array['id'],$data_results['site_id']);
		if(isset($site_index[0])){
			$site_title = $site_array['title'][$site_index[0]];
		}
		
		$agent_title = '<i>Unknown</i>';
		
		for($pat=(count($partitions)-1);$pat > -1;$pat--){
			$agent_index = array_keys($agents_array[$pat]['id'],$data_results['agent_id']);
			if(isset($agent_index[0])){
				$agent_title = $agents_array[$pat]['_name'][$agent_index[0]];
				break;
			}
		}
		
		$unit_title = '<i>Unknown</i>';
		$unit_index = array_keys($unit_array['id'],$data_results['unit_id']);
		if(isset($unit_index[0])){
			$unit_title = $unit_array['title'][$unit_index[0]];
		}
		
		$activity_title = '<i>Unknown</i>';
		$activity_index = array_keys($activity_array['id'],$data_results['activity_id']);
		if(isset($activity_index[0])){
			$activity_title = $activity_array['title'][$activity_index[0]];
			
		}
	
		$user_title = '<i style="color:brown;">Not validated</i>';
		if($data_results['validation_status']){
			$user_index = array_keys($user_array['_date'],$data_results['validation_user_date']);
			
			if(isset($user_index[0])){
				$user_title = $user_array['_name'][$user_index[0]];
			}
		}
		
		if($data_results['validation_status'] == 1){
			$row_color = 'black';
			
		}else{
			$row_color = 'brown';
			
		}				if($data_results['entry_method'] == 1){			$entry_method_title = 'USSD';					}else if($data_results['entry_method'] == 0){			$entry_method_title = 'System';					}else{			$entry_method_title = 'Undetermined';		}
		
		?>
		<div style="color:<?php print($row_color);?>;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;" id="entry_<?php print($data_results['id']);?>"><div style="width:auto;float:left;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view more details"  ><div style="width:auto;height:20px;float:left;"><input type="checkbox"></div><div style="width:90px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print(date('jS M, Y',$data_results['_date']));?></div>
		
		<div style="width:55px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print(date('H:i:s',$data_results['_date']));?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($entry_method_title);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($hub_title);?></div><div style="width:130px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($site_title);?></div><div style="width:120px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($agent_title);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($unit_title);?></div><div style="width:125px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($activity_title);?></div><div style="width:50px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($data_results['_value']);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"><?php print($user_title);?></div><div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;" onclick="fetch_entry_item(<?php print($data_results['id']);?>);"></div></div>
		</div>
		
		<?php
		$total_value += $data_results['_value'];
		$current_date = date('j',$data_results['_date']);			
		
	}
}
//print($this_id.' - '.$current_date.',');
?>
<script>

$('#total_records').val(Number($('#total_records').val())+<?php print(mysqli_num_rows($data))?>);
$('#total_value').val(Number($('#total_value').val())+<?php print($total_value)?>);
$('#days_worked').val(Number($('#days_worked').val())+<?php print($days_worked)?>);
$('#last_date').val(<?php print($current_date)?>);

if($('#last_entry_id').val() == 0 || <?php print(mysqli_num_rows($data))?> != 0){
	display_infor('detailed_list_status_bar','<strong>Total records: </strong>'+$('#total_records').val()+', <strong>Showing:</strong> 100, <strong>Days Worked:</strong> '+$('#days_worked').val()+', <strong>Total value: </strong>'+$('#total_value').val());
}
<?php
if(mysqli_num_rows($data) > 100){
?>
$('#showing_less_holder').slideDown('fast');
<?php
}else{
	?>
	$('#showing_less_holder').slideUp('fast');
	<?php
}
?>

$('#last_entry_id').val(<?php print($last_id);?>);
//$('#filter_unit_menu').html('<?php print($results_unit_filter);?>');
//alert($('#last_date').val());
</script>

