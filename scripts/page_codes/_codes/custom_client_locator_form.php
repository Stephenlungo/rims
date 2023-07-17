<?php
$dynamic_form_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_id = $form_id")or die(mysqli_error($connect));

$form_option_string = '';
$form_option_type_string = '';
$form_option_array = array();
$form_option_type_array = array();
for($o=0;$o<mysqli_num_rows($dynamic_form_options);$o++){
	$dynamic_form_option_results = mysqli_fetch_array($dynamic_form_options,MYSQLI_ASSOC);
	
	if($form_option_string == ''){
		$form_option_string = $dynamic_form_option_results['id'];
		$form_option_type_string = $dynamic_form_option_results['option_type'];
		
	}else{
		$form_option_string .= ','.$dynamic_form_option_results['id'];
		$form_option_type_string .= ','.$dynamic_form_option_results['option_type'];
	}
	
	$form_option_array[$o] = $dynamic_form_option_results['id'];
	$form_option_type_array[$o] = $dynamic_form_option_results['option_type'];
}

if($data_set_id){
	$button_text = 'Update';
	
	//$today_start = mktime(0,0,0,date('m',time()),date('j',time()),date('Y',time()));
	//$now = time();
	
	$today_start = $client_date;
	$now = $client_date;
	
	$this_default_partition_name = $default_partition_names[6][1][0];
	$partitions = fetch_database_partitions(6,$today_start,$now);
	$this_partition_name = $this_default_partition_name.'_partition_'.$partitions[0];
	
	$fetch_data_set_data = mysqli_query($connect,"select * from $this_partition_name where dynamic_form_data_set_id = $data_set_id")or die(mysqli_error($connect));
	
	$option_id_array = array();
	$option_value_array = array();
	for($d=0;$d<mysqli_num_rows($fetch_data_set_data);$d++){
		$fetch_data_set_data_results = mysqli_fetch_array($fetch_data_set_data,MYSQLI_ASSOC);
		
		$option_id_array[$d] = $fetch_data_set_data_results['dynamic_form_category_option_id'];
		$option_value_array[$d] = $fetch_data_set_data_results['_value'];
	}
	
	$form_option_value = array();
	$form_option_text = array();
	$form_option_checked = array();
	for($oa=0;$oa<count($form_option_array);$oa++){
		$this_option_index = array_keys($option_id_array,$form_option_array[$oa]);
		
		if(isset($this_option_index[0])){
			if($form_option_type_array[$oa] == 3 || $form_option_type_array[$oa] == 4){
				$form_option_value[$form_option_array[$oa]] = date('m/j/Y',$option_value_array[$this_option_index[0]]);
				
			}else{
				$form_option_value[$form_option_array[$oa]] = 1;
				$form_option_checked[$form_option_array[$oa]] = 'checked';
			}
			
			$form_option_text[$form_option_array[$oa]] = $option_value_array[$this_option_index[0]];
			
		}else{
			$form_option_value[$form_option_array[$oa]] = '';
			$form_option_text[$form_option_array[$oa]] = '';
			$form_option_checked[$form_option_array[$oa]] = '';
		}
	}
	
	$field_color = '#000';
	
}else{
	$button_text = 'Save';
	$field_color = '#aaa';
	
	$form_option_value = array();
	$form_option_text = array();
	for($oa=0;$oa<count($form_option_array);$oa++){
		if($form_option_type_array[$oa] == 3 || $form_option_type_array[$oa] == 4){
			$form_option_value[$form_option_array[$oa]] = '';
			
		}else{
			$form_option_value[$form_option_array[$oa]] = '';
		}
		
		$form_option_text[$form_option_array[$oa]] = '';
		$form_option_checked[$form_option_array[$oa]] = '';
	}
}
?>

<div style="width:831px;height:35px;margin:0 auto;margin-bottom:5px;" id="client_update_holder">
<div style="width:575px;height:35px;line-height:30px;float:left;color:red;font-weight:bold;" id="custom_form_error_message_<?php print($form_id);?>"></div>

<?php if($data_set_id and $active_user_roles[8]){
	?>
	<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;margin-left:35px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="delete_prep_form_button_<?php print($data_set_id);?>" onclick="delete_prep_form(<?php print($form_id.','.$data_set_id.','.$client_date);?>);" title="Click to save this form">Delete</div>
<?php
}
?>

<div style="width:70px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#777';" onmouseout="this.style.backgroundColor='#aaa';"  id="client_profile_button" onclick="fetch_dynamic_form_list(<?php print($form_id.',1,'.$client_date);?>);" title="Click to close this form">Close form</div>

<?php // if(!$data_set_id || $user_id == $this_data_set_results['user_id'] || $active_user_roles[8]){
	?>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="dynamic_form_save_button_<?php print($form_id);?>" onclick="create_or_update_custom_client_form(<?php print($form_id.','.$data_set_id.',0,'.$client_date);?>);" title="Click to save this form"><?php print($button_text);?></div>

<?php
//}
?>
</div>

<input type="hidden" id="form_option_string_<?php print($form_id);?>" value="<?php print($form_option_string);?>">
<input type="hidden" id="form_option_type_string_<?php print($form_id);?>" value="<?php print($form_option_type_string);?>">
<input type="hidden" id="form_<?php print($form_id);?>_active" value="1">
<div style="width:100%;height:420px;float:left;overflow:auto;">
<div style="width:821px;height:auto;margin:0 auto;">
<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;font-weight:bold;font-size:1.1em;margin-bottom:10px;"><div style="width:200px;height:30px;margin:0 auto;border:solid 1px #999;border-radius:15px;">PrEP CLIENT LOCATOR</div></div>

<div style="width:100%;height:auto;float:left;">
<div style="width:410px;;height:30px;line-height:30px;float:left;">

<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">Name:</div>
<div style="width:200px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_name_<?php print($form_id);?>">Francis Kasonde</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">Gender:</div>
<div style="width:90px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_gender_<?php print($form_id);?>">Rather not say</div>

</div>


<div style="width:320px;min-height:30px;height:auto;float:right;" id="locator_date_holder">
<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">Date:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<?php
if($form_option_value[348] == ''){
	$day = 0;
	$month = 0;
	$year = 0;
	
	$day_title = 'Select';
	$month_title = 'Select';
	$year_title = 'Select';
	
}else{
	$date_array = explode('/',$form_option_value[348]);
	$day = $date_array[1];
	$month = $date_array[0];
	$year = $date_array[2];
	
	$day_title = $day;
	$month_title = $month;
	$year_title = $year;
	
}
?>

<div class="option_item" title="Click to change option" onclick="$('#locator_day_menu').toggle('fast');$('#locator_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_locator_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($day_title);?></div>

<div class="option_menu" id="locator_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#locator_day_menu').toggle('fast');$('#active_locator_day').html($(this).html());$('#selected_locator_day').val(<?php print($d);?>);$('#option_348').val($('#selected_locator_month').val()+'/'+$('#selected_locator_day').val()+'/'+$('#selected_locator_year').val());check_if_locator_future();" style="width:40px;"><?php print($do);?></div>
		<?php
	}
	
}else{
	for($d=31;$d>0;$d--){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#locator_day_menu').toggle('fast');$('#active_locator_day').html($(this).html());$('#selected_locator_day').val(<?php print($d);?>);$('#option_348').val($('#selected_locator_month').val()+'/'+$('#selected_locator_day').val()+'/'+$('#selected_locator_year').val());check_if_locator_future();" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_locator_day" id="selected_locator_day" value="<?php print($day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#locator_month_menu').toggle('fast');$('#locator_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_locator_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($month_title);?></div>


<div class="option_menu" id="locator_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#locator_month_menu').toggle('fast');$('#active_locator_month').html($(this).html());$('#selected_locator_month').val(<?php print($m);?>);$('#option_348').val($('#selected_locator_month').val()+'/'+$('#selected_locator_day').val()+'/'+$('#selected_locator_year').val());check_if_locator_future();" style="width:40px;"><?php print($mo);?></div>
		<?php
	}

}else{
	for($m=12;$m>0;$m--){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#locator_month_menu').toggle('fast');$('#active_locator_month').html($(this).html());$('#selected_locator_month').val(<?php print($m);?>);$('#option_348').val($('#selected_locator_month').val()+'/'+$('#selected_locator_day').val()+'/'+$('#selected_locator_year').val());check_if_locator_future();" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_locator_month" id="selected_locator_month" value="<?php print($month);?>">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#locator_year_menu').toggle('fast');$('#locator_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_locator_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($year_title);?></div>


<div class="option_menu" id="locator_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#locator_year_menu').toggle('fast');$('#active_locator_year').html($(this).html());$('#selected_locator_year').val(<?php print($y);?>);$('#option_348').val($('#selected_locator_month').val()+'/'+$('#selected_locator_day').val()+'/'+$('#selected_locator_year').val());check_if_locator_future();" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_locator_year" id="selected_locator_year" value="<?php print($year);?>">
</div>
<input type="hidden" id="option_348" value="<?php print($form_option_value[348]);?>">

<div style="width:100%;height:20px;float:left;lie-height:20px;text-align:center;display:none;" id="locator_date_validation_status"></div>
<input type="hidden" id="locator_date_validation" value="0">
</div>
</div>

<div style="width:97%;height:auto;border:solid 2px #aaa;float:left;margin-top:5px;padding:5px;" id="entry_type_holder">
<div style="width:115px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;" >TYPE OF ENTRY</div>

<div style="width:650px;float:right;height:25px;">
<div style="width:auto;height:20px;float:left;">
<input type="radio" style="margin-top:7px;" id="field_109" name="type_of_entry" onclick="check_type_of_entry(109);" <?php print($form_option_checked[109]);?>> <label for="field_109">New Client</label>

<input type="hidden" id="option_109" value="<?php print($form_option_value[109]);?>">

<input type="radio" style="margin-top:7px;" id="field_110" name="type_of_entry" onclick="check_type_of_entry(110);" <?php print($form_option_checked[110]);?>> <label for="field_110">Transfer In:- Specify Facility: </label>
</div>
<?php
if($form_option_text[110] == ''){
	$field_text = 'Enter facility here';
	$type_field_color = '#aaa';
	
}else{
	$field_text = $form_option_text[110];
	$type_field_color = '#000';
}
?>

<div style="width:130px;height:20px;float:left;margin-left:5px;margin-top:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:<?php print($type_field_color);?>;" value="<?php print($field_text);?>" onfocus="this.style.borderColor='#aaa';if($(this).val() =='Enter facility here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter facility here';this.style.color='#aaa'}" id="option_110_text" onclick="$('#field_110').click();"></div>

<input type="hidden" id="option_110" value="<?php print($form_option_value[110]);?>">

<input type="radio" style="margin-top:7px;" id="field_111" name="type_of_entry" onclick="check_type_of_entry(111);" <?php print($form_option_checked[111]);?>> <label for="field_111">Update information only</label>

<input type="hidden" id="option_111" value="<?php print($form_option_value[111]);?>">

<script>
check_if_locator_future();
function check_if_locator_future(){
	var option_value = $('#option_348').val();
	
	var option_value_array = option_value.split('/');
	
	var date_array = new Array();
	var date_array = is_date_future(option_value_array[2]+'/'+option_value_array[0]+'/'+option_value_array[1]+' 00:00:00',0);
	
	if(!isNaN(date_array[1])){
		if(date_array[0]){
			$('#locator_date_validation_status').html('Date cannot be in the future');
			$('#locator_date_validation_status').css('color','red');
			$('#locator_date_validation_status').slideDown('fast');
			$('#locator_date_holder').css('border','solid 1px red');
			$('#locator_date_validation').val(0);
			
		}else{
			$('#locator_date_validation_status').html('Date validation passed');
			$('#locator_date_validation_status').css('color','green');
			$('#locator_date_validation_status').slideDown('fast');
			$('#locator_date_holder').css('border','none');
			$('#locator_date_validation').val(1);
			
		}
	}
}


function check_type_of_entry(entry_id){
	$('#option_109').val('');
	$('#option_110').val('');
	$('#option_111').val('');
	
	$('#option_'+entry_id).val(1);

}
</script>
</div>

<div style="width:100%;height:auto;line-height:20px;float:left;font-size:0.9em;color:#555;"><i>Note: To transfer patient with records, complete only parts that have changed; If transfer patient does not have records, treat as a new patient</i></div>
</div>

<div style="width:97%;height:auto;border:solid 2px #aaa;float:left;margin-top:5px;padding:5px;">
<div style="width:335px;float:left;height:auto;">
<div style="width:115px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;">BACKGROUND</div>

<div style="width:100%;height:30px;float:left;margin-top:5px;">
<div style="width:130px;float:left;height:25px;line-height:25px;">Place of birth:</div>
<div style="width:190px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter place of birth here" id="location_place_of_birth" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter place of birth here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:130px;float:left;height:25px;line-height:25px;">Name client goes by:</div>
<div style="width:190px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter name here" id="location_client_name_2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:130px;float:left;height:25px;line-height:25px;">Maiden name:</div>
<div style="width:190px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter other names here" id="locator_client_other_names" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter other names here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter other names here';this.style.color='#aaa';}"></div>
</div>

</div>

<div style="width:250px;float:left;height:auto;border:solid 1px #aaa;padding:2px;">
<div style="width:100%;height:20px;float:left;">Estimated household income per month</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="household_income" id="household_income_0"><label for="household_income_0">Less than K500</label></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="household_income" id="household_income_1"><label for="household_income_1">K500 - K999</label></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="household_income" id="household_income_2"><label for="household_income_2">K1000 - K1499</label></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="household_income" id="household_income_3"><label for="household_income_3">K1500 - K1999</label></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="household_income" id="household_income_4"><label for="household_income_4">K2000 - K2999</label></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="household_income" id="household_income_5"><label for="household_income_5">Greater than K3000</label></div>

</div>

<div style="width:180px;float:right;height:auto;border:solid 1px #aaa;padding:2px;" id="marital_status_holder">
<div style="width:100%;height:20px;float:left;">Marital status:</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="marital_status" id="field_112" onclick="check_marital_status(112)" <?php print($form_option_checked[112]);?>><label for="field_112">Never married</label></div>
<input type="hidden" id="option_112" value="<?php print($form_option_value[112]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="marital_status" id="field_113" onclick="check_marital_status(113)" <?php print($form_option_checked[113]);?>><label for="field_113">Married</label></div>

<input type="hidden" id="option_113" value="<?php print($form_option_value[113]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="marital_status" id="field_114" onclick="check_marital_status(114)" <?php print($form_option_checked[114]);?>><label for="field_114">Divorced</label></div>

<input type="hidden" id="option_114" value="<?php print($form_option_value[114]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float;left;"><input type="radio" name="marital_status" id="field_115" onclick="check_marital_status(115)" <?php print($form_option_checked[115]);?>><label for="field_115">Widowed</label></div>

<input type="hidden" id="option_115" value="<?php print($form_option_value[115]);?>">

<script>
	function check_marital_status(entry_id){
		$('#option_112').val('');
		$('#option_113').val('');
		$('#option_114').val('');
		$('#option_115').val('');
		
		$('#option_'+entry_id).val(1);

	}
</script>

</div>

<div style="width:100%;height:auto;border-top:solid 1px #aaa;margin-top:5px;float:left;" >

<div style="width:180px;float:left;height:auto;padding:2px;margin-top:2px;">
<div style="width:100%;height:20px;float:left;" id="education_level_holder">Client's educational level:</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" name="educational_level" id="field_116" onclick="check_education_status(116)" <?php print($form_option_checked[116]);?>><label for="field_116">None</label></div>

<input type="hidden" id="option_116" value="<?php print($form_option_value[116]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" name="educational_level" id="field_117" onclick="check_education_status(117)" <?php print($form_option_checked[117]);?>><label for="field_117">Highest Grade (1-12):</label></div>

<input type="hidden" id="option_117" value="<?php print($form_option_value[117]);?>">

<?php
if($form_option_text[117] == ''){
	$field_text = 'Enter highest grade here';
	$grade_field_color = '#aaa';
	
}else{
	$field_text = $form_option_text[117];
	$grade_field_color = '#000';
}
?>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<input type="text" id="option_117_text" style="width:90%;height:25px;color:<?php print($grade_field_color);?>;float:right;border:solid 1px #aaa;" value="<?php print($field_text);?>" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter highest grade here'){this.value='';this.style.color='#000'}$('#field_117').click();" onfocusout="if(this.value==''){this.value='Enter highest grade here';this.style.color='#aaa'}else{if((isNaN(this.value))){alert('Highest grade must be a number');this.value='Enter highest grade here';this.style.color='#aaa'}}">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" name="educational_level" id="field_118" onclick="check_education_status(118)" <?php print($form_option_checked[118]);?>><label for="field_118">College / University</label></div>
<input type="hidden" id="option_118" value="<?php print($form_option_value[118]);?>">

<script>
	function check_education_status(entry_id){
		$('#option_116').val('');
		$('#option_117').val('');
		$('#option_118').val('');
		
		$('#option_'+entry_id).val(1);

	}
</script>
</div>

<div style="width:550px;float:right;height:auto;padding:2px;margin-top:2px;">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Patient's occupation</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;float:right;border-color:#aaa;" value="Enter occupation here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter occupation here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter occupation here';this.style.color='#aaa'}">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Patient's employer</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;float:right;" value="Enter employer here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter employer here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter employer here';this.style.color='#aaa'}">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Patient's workplace</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;float:right;" value="Enter workplace here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter workplace here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter workplace here';this.style.color='#aaa'}">
</div></div></div></div>


<div style="width:97%;height:auto;border:solid 2px #aaa;float:left;margin-top:5px;padding:5px;">
<div style="width:390px;float:left;height:auto;">
<div style="width:95px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;">ADDRESS</div>

<div style="width:100px;float:left;height:25px;line-height:25px;font-size:0.9em;">
<div style="width:100%;height:20px;line-height:20x;float:left;"><input name="primary_address1" type="radio" id="current_address1"> <label for="current_address1">Current</label></div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input  id="permanent_address1" name="primary_address1" type="radio"> <label for="permanent_address1">Permanent</label>
</div>
</div>

<div style="width:95px;float:left;height:auto;line-height:25px;font-size:0.9em;">
<div style="width:100%;height:20px;line-height:20x;float:left;"><input type="radio" name="primary_address_type" id="supporter_address1"> <label for="supporter_address1">Supporter</label></div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type" type="radio" id="neighbor_address1"> <label for="neighbor_address1">Neighbor</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type" type="radio" id="guardian_address1"> <label for="guardian_address1">Guardian</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type" type="radio" id="emergency_address1"> <label for="emergency_address1">Emergency</label>
</div>
</div>

<div style="width:95px;float:left;height:auto;line-height:25px;font-size:0.9em;">
<div style="width:100%;height:20px;line-height:20x;float:left;"><input  name="primary_address_type" type="radio" id="parrent_address1"> <label for="parrent_address1">Parent</label></div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type" type="radio" id="provider_address1"> <label for="provider_address1">Provider</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type" type="radio" id="workplace_address1"> <label for="workplace_address1">Workplace</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type" type="radio" id="patientsother_address1"> <label for="patientsother_address1">Patient-other</label>
</div>
</div>

<?php
if($form_option_text[119] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[119];
}
?>

<div style="width:100%;height:30px;float:left;margin-top:3px;">
<div style="width:160px;float:left;height:25px;line-height:25px;">House No/plot number:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" id="option_119_text" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}"></div>
</div>

<input type="hidden" id="option_119" value="1">

<?php
if($form_option_text[120] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[120];
}
?>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Street name:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" id="option_120_text" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}"></div>
</div>
<input type="hidden" id="option_120" value="1">

<?php
if($form_option_text[290] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[290];
}
?>
<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Township/compound:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" id="option_290_text" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}"></div>
</div>
<input type="hidden" id="option_290" value="1">

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Village:</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter village here" id="village1" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter village here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter village here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Chief:</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter chief here" id="chief1" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter chief here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter chief here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Telephone:</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter telephone here" id="telephone1" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter telephone here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter telephone here';this.style.color='#aaa'}"></div>
</div>
</div>


<div style="width:390px;float:right;height:auto;">
<div style="width:95px;text-align:center;height:20px;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;"></div>

<div style="width:100px;float:left;height:25px;line-height:25px;font-size:0.9em;">
<div style="width:100%;height:20px;line-height:20x;float:left;"><input name="primary_address2" type="radio" id="current_address2"> <label for="current_address2">Current</label></div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input id="permanent_address2" name="primary_address2" type="radio"> <label for="permanent_address2">Permanent</label>
</div>
</div>

<div style="width:95px;float:left;height:auto;line-height:25px;font-size:0.9em;">
<div style="width:100%;height:20px;line-height:20x;float:left;"><input type="radio" name="primary_address_type2" id="supporter_address2"> <label for="supporter_address2">Supporter</label></div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type2" type="radio" id="neighbor_address2"> <label for="neighbor_address2">Neighbor</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type2" type="radio" id="guardian_address2"> <label for="guardian_address2">Guardian</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type2" type="radio" id="emergency_address2"> <label for="emergency_address2">Emergency</label>
</div>
</div>

<div style="width:95px;float:left;height:auto;line-height:25px;font-size:0.9em;">
<div style="width:100%;height:20px;line-height:20x;float:left;"><input name="primary_address_type2" type="radio" id="parrent_address2" id="current_address"> <label for="parrent_address2">Parent</label></div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type2" type="radio" id="provider_address2"> <label for="provider_address2">Provider</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type2" type="radio" id="workplace_address2"> <label for="workplace_address2">Workplace</label>
</div>
<div style="width:100%;height:20px;line-height:20x;float:left;">
<input name="primary_address_type2" type="radio" id="patientsother_address2"> <label for="patientsother_address2">Patient-other</label>
</div>
</div>

<div style="width:100%;height:30px;float:left;margin-top:3px;">
<div style="width:160px;float:left;height:25px;line-height:25px;">House number/plot number:</div>
<div style="width:225px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter house number here" id="house_number2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter house number here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter house number here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Street name:</div>
<div style="width:225px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter street name here" id="street_name2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter street name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter street name here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Township/compound:</div>
<div style="width:225px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter township here" id="township2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter township here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter township here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Village:</div>
<div style="width:225px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter village here" id="village2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter village here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter village here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Chief:</div>
<div style="width:225px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter chief here" id="chief2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter chief here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter chief here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Telephone:</div>
<div style="width:225px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter telephone here" id="telephone1" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter telephone here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter telephone here';this.style.color='#aaa'}"></div>
</div>
</div>
</div>


<div style="width:97%;height:auto;border:solid 2px #aaa;float:left;margin-top:5px;padding:5px;">
<div style="width:390px;height:auto;float:left;border-right:solid 2px #000;">
<div style="width:315px;float:left;height:auto;border-right:solid 1px #aaa">
<div style="width:115px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;">HOUSEHOLD</div>

<div style="width:120px;float:left;height:20px;line-height:20px;margin-left:5px;text-align:center;">
Children
</div>

<div style="width:60px;float:left;height:20px;line-height:15px;margin-left:5px;text-align:center;">
Tested<br>Yes / No
</div>


<div style="width:100%;height:25px;float:left;margin-top:3px;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="child_name_1" ></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_0"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_0"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="child_name_2" ></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_1"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_1"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="child_name_3" ></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_2"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_2"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="child_name_4" ></div>

<div style="width:20px;height:25px;float:left;margin-left:5px;"><input type="radio" name="tested_1_3"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_3"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="child_name_5" ></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_4"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_4"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="child_name_6" ></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_5"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_1_5"></div>
</div>
</div>

<div style="width:60px;float:left;height:20px;line-height:15px;margin-left:5px;text-align:center;">
Results<br>+ve / -ve
<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_0"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_0"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_1"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_1"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_2"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_2"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_3"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_3"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_4"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_4"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_5"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="results_1_5"></div>
</div>


</div>
</div>

<div style="width:390px;height:auto;float:right;">
<div style="width:320px;float:left;height:auto;border-right:solid 1px #aaa">

<div style="width:237px;float:left;height:20px;line-height:20px;margin-left:5px;text-align:center;">
Others in household
</div>

<div style="width:60px;float:left;height:20px;line-height:15px;margin-left:5px;text-align:center;">
Tested<br>Yes / No
</div>


<div style="width:100%;height:25px;float:left;margin-top:10px;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="household_member_name_1" ></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_0"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_0"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="household_member_name_1"></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_1"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_1"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="household_member_name_1"></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_2"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_2"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="household_member_name_1"></div>

<div style="width:20px;height:25px;float:left;margin-left:5px;"><input type="radio" name="tested_2_3"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_3"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="household_member_name_1"></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_4"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_4"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:245px;height:20px;float:left;margin-left:5px;">
<input type="text" style="border:solid 1px #aaa;width:100%;height:20px;color:#aaa;" value="Enter name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}" id="household_member_name_1"></div>

<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_5"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="tested_2_5"></div>
</div>
</div>

<div style="width:60px;float:left;height:20px;line-height:15px;margin-left:5px;text-align:center;">
Results<br>+ve / -ve
<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_0"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_0"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_1"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_1"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_2"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_2"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_3"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_3"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_4"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_4"></div>
</div>

<div style="width:100%;height:25px;float:left;">
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_5"></div>
<div style="width:20px;height:20px;float:left;margin-left:5px;"><input type="radio" name="result_2_5"></div>
</div>


</div>
</div>











</div>


<div style="width:390px;float:left;height:auto;border: solid 2px #aaa;margin-top:5px;padding:5px;">
<div style="width:165px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;">EMERGENCY CONTACT</div>

<?php
if($form_option_text[123] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[123];
}
?>

<div style="width:100%;height:30px;float:left;margin-top:3px;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Name:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}" id="option_123_text"></div>
</div>
<input type="hidden" id="option_123" value="1">

<?php
if($form_option_text[124] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[124];
}
?>
<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Relation to patient:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}" id="option_124_text"></div>
</div>
<input type="hidden" id="option_124" value="1">

<?php
if($form_option_text[125] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[125];
}
?>
<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">House No/plot number:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}" id="option_125_text"></div>
</div>
<input type="hidden" id="option_125" value="1">

<?php
if($form_option_text[349] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[349];
}
?>
<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Street name:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}" id="option_349_text"></div>
</div>
<input type="hidden" id="option_349" value="1">

<?php
if($form_option_text[350] == ''){
	$field_color = '#aaa';
	$this_text = '0';
	
}else{
	$field_color = '#000';
	$this_text = $form_option_text[350];
}
?>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Township/compound:*</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:<?php print($field_color);?>;" value="<?php print($this_text);?>" onfocus="this.style.borderColor='#aaa';if(this.value=='0'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='0';this.style.color='#aaa'}" id="option_350_text"></div>
</div>
<input type="hidden" id="option_350" value="1">

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Village:</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter village name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter village name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter village name here';this.style.color='#aaa'}" id="option_351_text_0"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Chief:</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter chief name here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter chief name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter chief name here';this.style.color='#aaa'}" id="option_352_text_0"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:160px;float:left;height:25px;line-height:25px;">Telephone:</div>
<div style="width:220px;height:20px;float:left;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter phone number here" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter phone number here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter phone number here';this.style.color='#aaa'}" id="field_126_text_0"></div>
</div>
</div>

<div style="width:390px;float:left;height:auto;border: solid 2px #aaa;margin-top:5px;padding:5px;margin-left:3px;">
<div style="width:185px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;">TREATMENT SUPPORTERS</div>


<div style="width:100%;height:25px;float:left;line-height:25px;">
<div style="width:20px;float:left;height:25px;margin-top:2px;"><input type="checkbox" id="consent_follow_up"></div>
<div style="width:360px;height:25px;float:left;margin-left:5px;"><label for="consent_follow_up">Patient consents to be part of Home Follow Up Program</label></div>
</div>

<div style="width:100%;height:25px;float:left;line-height:25px;">
<div style="width:20px;float:left;height:25px;margin-top:2px;"><input type="checkbox" id="consent_sms"></div>
<div style="width:360px;height:25px;float:left;margin-left:5px;"><label for="consent_sms">Patient consents to be part of messaging program (SMS)</label></div>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;">
<div style="width:100px;float:left;height:20px;line-height:20px;">Name</div>
<div style="width:140px;float:left;height:20px;line-height:20px;margin-left:5px;">Relation to patient</div>
<div style="width:130px;float:left;height:20px;line-height:20px;margin-left:5px;">Phone/Contact info</div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;margin-top:3px;">
<div style="width:100px;float:left;height:25px;line-height:20px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter name here" id="supporter_1" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}"></div>
<div style="width:140px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter relationship here" id="supporter_relationship_1" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter relationship here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter relationship here';this.style.color='#aaa'}"></div>
<div style="width:130px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter phone here" id="supporter_phone_1" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter phone here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter phone here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;margin-top:3px;">
<div style="width:100px;float:left;height:25px;line-height:20px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter name here" id="supporter_2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}"></div>
<div style="width:140px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter relationship here" id="supporter_relationship_2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter relationship here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter relationship here';this.style.color='#aaa'}"></div>
<div style="width:130px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter phone here" id="supporter_phone_2" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter phone here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter phone here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;margin-top:3px;">
<div style="width:100px;float:left;height:25px;line-height:20px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter name here" id="supporter_3" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}"></div>
<div style="width:140px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter relationship here" id="supporter_relationship_3" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter relationship here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter relationship here';this.style.color='#aaa'}"></div>
<div style="width:130px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter phone here" id="supporter_phone_3" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter phone here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter phone here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;margin-top:3px;">
<div style="width:100px;float:left;height:25px;line-height:20px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter name here" id="supporter_4" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}"></div>
<div style="width:140px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter relationship here" id="supporter_relationship_4" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter relationship here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter relationship here';this.style.color='#aaa'}"></div>
<div style="width:130px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter phone here" id="supporter_phone_4" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter phone here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter phone here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;margin-top:3px;">
<div style="width:100px;float:left;height:25px;line-height:20px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter name here" id="supporter_5" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter name here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa'}"></div>
<div style="width:140px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter relationship here" id="supporter_relationship_5" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter relationship here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter relationship here';this.style.color='#aaa'}"></div>
<div style="width:130px;float:left;height:25px;line-height:20px;margin-left:5px;"><input type="text" style="border:solid 1px #aaa;width:100%;height:25px;color:#aaa;" value="Enter phone here" id="supporter_phone_5" onfocus="this.style.borderColor='#aaa';if(this.value=='Enter phone here'){this.value='';this.style.color='#000'}" onfocusout="if(this.value==''){this.value='Enter phone here';this.style.color='#aaa'}"></div>
</div>


</div>

</div>
</div>


<script>
fetch_basic_details(<?php print($form_id);?>);

</script>






