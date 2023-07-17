<?php
$dynamic_form_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_id = $form_id and status = 1")or die(mysqli_error($connect));

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
	
	$fetch_data_set_data = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_data_set_id = $data_set_id")or die(mysqli_error($connect));
	
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

$this_data_set = mysqli_query($connect,"select * from dynamic_form_data_sets where id = $data_set_id")or die(mysqli_error($connect));
$this_data_set_results = mysqli_fetch_array($this_data_set,MYSQLI_ASSOC);

$this_client = mysqli_query($connect,"select * from prep_clients where id = $client_id")or die(mysqli_error($connect));
if(mysqli_num_rows($this_client)){
	$this_client_results = mysqli_fetch_array($this_client,MYSQLI_ASSOC);
	$prep_id = $this_client_results['prep_id'];
	
}else{
	$prep_id = 'Unassigned';
}
?>
<input type="hidden" id="form_option_string_<?php print($form_id);?>" value="<?php print($form_option_string);?>">
<input type="hidden" id="form_option_type_string_<?php print($form_id);?>" value="<?php print($form_option_type_string);?>">
<input type="hidden" id="form_<?php print($form_id);?>_active" value="1">
<div style="width:921px;height:35px;margin:0 auto;margin-bottom:5px;" id="client_update_holder">
<div style="width:675px;height:35px;line-height:30px;float:left;color:red;font-weight:bold;" id="custom_form_error_message_<?php print($form_id);?>"></div>

<?php if($data_set_id and $active_user_roles[8]){
	?>

<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;margin-left:35px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="delete_prep_form_button_<?php print($data_set_id);?>" onclick="delete_prep_form(<?php print($form_id.','.$data_set_id);?>);" title="Click to save this form">Delete</div>

<?php
}
?>

<div style="width:70px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#777';" onmouseout="this.style.backgroundColor='#aaa';"  id="client_profile_button" onclick="fetch_dynamic_form_list(<?php print($form_id);?>,1);" title="Click to close this form">Close form</div>

<?php //if(!$data_set_id || $user_id == $this_data_set_results['user_id'] || $active_user_roles[8]){
	?>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="dynamic_form_save_button_<?php print($form_id);?>" onclick="create_or_update_custom_client_form(<?php print($form_id.','.$data_set_id);?>);" title="Click to save this form"><?php print($button_text);?></div>

<?php
//}
?>
</div>

<div style="width:100%;height:430px;float:left;overflow:auto;">



<div style="width:921px;height:auto;margin:0 auto;">

<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;font-weight:bold;font-size:1.1em;margin-bottom:10px;"><div style="width:300px;height:30px;margin:0 auto;border:solid 1px #999;border-radius:15px;">COVID-19 CASE INVESTIGATION FORM</div></div>


<div style="width:99.3%;height:auto;float:left;padding:2px;">


<div style="width:100%;min-height:30px;height:auto;float:right;" id="initiation_date_holder">
<div style="width:65px;height:30px;line-height:30px;float:left;font-weight:bold;">Date:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[390] == ''){
	$initiation_date = 0;
	
	$initiation_day = 0;
	$initiation_month = 0;
	$initiation_year = 0;
	
	$initiation_day_title = 'Select';
	$initiation_month_title = 'Select';
	$initiation_year_title = 'Select';
	
}else{
	$initiation_date = $form_option_value[390];
	
	$initiation_date_array = explode('/',$initiation_date);

	$initiation_day = $initiation_date_array[1];
	$initiation_month = $initiation_date_array[0];
	$initiation_year = $initiation_date_array[2];
	
	$initiation_day_title = $initiation_day;
	$initiation_month_title = $initiation_month;
	$initiation_year_title = $initiation_year;
}


?>

<div class="option_item" title="Click to change option" onclick="$('#initiation_day_menu').toggle('fast');$('#initiation_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($initiation_day_title);?></div>

<div class="option_menu" id="initiation_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_day_menu').toggle('fast');$('#active_initiation_day').html($(this).html());$('#selected_initiation_day').val(<?php print($d);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_day_menu').toggle('fast');$('#active_initiation_day').html($(this).html());$('#selected_initiation_day').val(<?php print($d);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_initiation_day" id="selected_initiation_day" value="<?php print(date('j',$initiation_day));?>">
</div>

<div style="margin-left:5px;line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_month_menu').toggle('fast');$('#initiation_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($initiation_month_title);?></div>


<div class="option_menu" id="initiation_month_menu" style="display:none;">
<?php


if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_month_menu').toggle('fast');$('#active_initiation_month').html($(this).html());$('#selected_initiation_month').val(<?php print($m);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_month_menu').toggle('fast');$('#active_initiation_month').html($(this).html());$('#selected_initiation_month').val(<?php print($m);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_initiation_month" id="selected_initiation_month" value="<?php print($initiation_month);?>">
</div>

<div style="margin-left:5px;line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_year_menu').toggle('fast');$('#initiation_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($initiation_year_title);?></div>


<div class="option_menu" id="initiation_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_year_menu').toggle('fast');$('#active_initiation_year').html($(this).html());$('#selected_initiation_year').val(<?php print($y);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_initiation_year" id="selected_initiation_year" value="<?php print($initiation_year);?>">
</div>
<input type="hidden" id="option_340" value="<?php print($initiation_date);?>">
<div style="width:100%;height:20px;float:left;lie-height:20px;text-align:center;display:none;" id="initiation_date_validation_status"></div>
<input type="hidden" id="initiation_date_validation" value="0">
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
	<div style="width:65px;height:30px;line-height:30px;float:left;font-weight:bold;">Facility:</div>
	<div style="width:350px;min-height:30px;height:auto;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_facility_<?php print($form_id);?>">Buzakile Main Hospital</div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
	<div style="width:65px;height:30px;line-height:30px;float:left;font-weight:bold;">District:</div>
	<div style="width:350px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_district_<?php print($form_id);?>">Kitwe</div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">		
	<div style="width:65px;height:30px;line-height:30px;float:left;font-weight:bold;">Province:</div>
	<div style="width:350px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_province_<?php print($form_id);?>">Copperbelt</div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:125px;height:30px;line-height:30px;float:left;font-weight:bold;">Case classification</div>
<div style="width:350px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="case_classification_<?php print($form_id);?>"><input type="radio" id="suspect_classification" name="case_classification"> <label for="suspect_classification">Suspect</label> <input type="radio" id="probable_classification" name="case_classification"> <label for="probable_classification">Probable</label><input type="radio" id="confirmed_classification" name="case_classification"> <label for="confirmed_classification">Confirmed</label></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:170px;height:30px;line-height:30px;float:left;font-weight:bold;">Detected at point of entry</div>
<div style="width:650px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="point_of_detection_<?php print($form_id);?>"><div style="width:auto;float:left;"><input type="radio" id="no_detection" name="point_of_detection"> <label for="no_detection">No</label> <input type="radio" id="yes_detection" name="point_of_detection"> <label for="yes_detection">Yes</label><input type="radio" id="unknown_detection" name="point_of_detection"> <label for="unknown_detection">Unknown</label></div> 


<div style="width:90px;height:30px;line-height:30px;float:left;margin-left:40px">If yes, date</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[390] == ''){
	$initiation_date = 0;
	
	$initiation_day = 0;
	$initiation_month = 0;
	$initiation_year = 0;
	
	$initiation_day_title = 'Select';
	$initiation_month_title = 'Select';
	$initiation_year_title = 'Select';
	
}else{
	$initiation_date = $form_option_value[390];
	
	$initiation_date_array = explode('/',$initiation_date);

	$initiation_day = $initiation_date_array[1];
	$initiation_month = $initiation_date_array[0];
	$initiation_year = $initiation_date_array[2];
	
	$initiation_day_title = $initiation_day;
	$initiation_month_title = $initiation_month;
	$initiation_year_title = $initiation_year;
}


?>

<div class="option_item" title="Click to change option" onclick="$('#initiation_day_menu').toggle('fast');$('#initiation_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($initiation_day_title);?></div>

<div class="option_menu" id="initiation_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_day_menu').toggle('fast');$('#active_initiation_day').html($(this).html());$('#selected_initiation_day').val(<?php print($d);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_day_menu').toggle('fast');$('#active_initiation_day').html($(this).html());$('#selected_initiation_day').val(<?php print($d);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_initiation_day" id="selected_initiation_day" value="<?php print(date('j',$initiation_day));?>">
</div>

<div style="margin-left:5px;line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_month_menu').toggle('fast');$('#initiation_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($initiation_month_title);?></div>


<div class="option_menu" id="initiation_month_menu" style="display:none;">
<?php


if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_month_menu').toggle('fast');$('#active_initiation_month').html($(this).html());$('#selected_initiation_month').val(<?php print($m);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_month_menu').toggle('fast');$('#active_initiation_month').html($(this).html());$('#selected_initiation_month').val(<?php print($m);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_initiation_month" id="selected_initiation_month" value="<?php print($initiation_month);?>">
</div>

<div style="margin-left:5px;line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_year_menu').toggle('fast');$('#initiation_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($initiation_year_title);?></div>


<div class="option_menu" id="initiation_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_year_menu').toggle('fast');$('#active_initiation_year').html($(this).html());$('#selected_initiation_year').val(<?php print($y);?>);$('#option_340').val($('#selected_initiation_month').val()+'/'+$('#selected_initiation_day').val()+'/'+$('#selected_initiation_year').val());check_if_initiation_future()" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_initiation_year" id="selected_initiation_year" value="<?php print($initiation_year);?>">
</div>


</div>
</div>

	</div>






<div style="width:99.3%;height:auto;float:left;padding:2px;">

<div style="width:100%;height:30px;line-height:30px;background-color:#777;float:left;color:#fff;margin-top:5px;font-weight:bold;">Section 1: Patient Information</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
	<div style="width:240px;height:30px;line-height:30px;float:left;font-weight:bold;">Unique case Identifier (if available):</div>
	<div style="width:350px;min-height:30px;height:auto;line-height:30px;float:left;border-bottom:solid 1px #000;" id="covid_client_id">Unset</div>
</div>


<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;margin-top:5px;">
<div style="width:100px;height:30px;line-height:30px;float:left;font-weight:bold;">Date of birth:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[398] == ''){
	$dob_date = date('m/j/Y',time());
	
}else{
	$dob_date = $form_option_value[398];
	
}

$dob_date_array = explode('/',$dob_date);

$dob_day = $dob_date_array[1];
$dob_month = $dob_date_array[0];
$dob_year = $dob_date_array[2];
?>


<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_day_menu').toggle('fast');" id="active_dob_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_day);?></div>

<div class="option_menu" id="initiation_dob_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_day" id="selected_dob_initiation_day" value="<?php print($dob_day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;margin-left:5px;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_month_menu').toggle('fast');" id="active_dob_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_month);?></div>


<div class="option_menu" id="initiation_dob_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_month" id="selected_dob_initiation_month" value="<?php print($dob_month);?>">


</div>

<div style="line-height:30px;width:32px;height:30px;float:left;margin-left:5px;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">


<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. To change the year of birth, change the age on the client profile')" id="active_dob_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_year);?></div>


<div class="option_menu" id="initiation_dob_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_year_menu').toggle('fast');$('#active_dob_initiation_year').html($(this).html());$('#selected_dob_initiation_year').val(<?php print($y);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_dob_initiation_year" id="selected_dob_initiation_year" value="<?php print($dob_year);?>">
</div>
<input type="hidden" id="option_346" value="<?php print($dob_date);?>">

<div style="width:auto;float:left;height:30px;margin-left:10px;">or estimated age: </div>
<div style="width:auto;float:left;height:30px;margin-left:10px;"><input type="text" id="" value="" style="width:90px;height:25px;"> in years</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:auto;float:left;height:30px;margin-left:10px;">if < 1 year old </div><div style="width:auto;float:left;height:30px;margin-left:10px;"><input type="text" id="" value="" style="width:90px;height:25px;"> in months or if < 1 month, <input type="text" id="" value="" style="width:90px;height:25px;"> in days</div>
</div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:125px;height:30px;line-height:30px;float:left;font-weight:bold;">Sex at birth:</div>
<div style="width:350px;height:30px;line-height:30px;float:left;" id="sex_at_birth_<?php print($form_id);?>"><input type="radio" id="male_sex_at_birth" name="sex_at_birth"> <label for="male_sex_at_birth">Male</label> <input type="radio" id="female_sex_at_birth" name="sex_at_birth"> <label for="female_sex_at_birth">Female</label></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:235px;height:30px;line-height:30px;float:left;font-weight:bold;">Place where case was diagnosed:</div>
<div style="width:350px;height:30px;line-height:30px;float:left;" id="sex_at_birth_<?php print($form_id);?>"><input type="text" id="" value="" style="width:100%;height:25px;"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:70px;height:30px;line-height:30px;float:left;font-weight:bold;">Province:</div>
<div style="width:200px;height:30px;line-height:30px;float:left;" id="sex_at_birth_<?php print($form_id);?>"><input type="text" id="" value="" style="width:100%;height:25px;"></div>

<div style="width:60px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:10px;">District:</div>
<div style="width:200px;height:30px;line-height:30px;float:left;" id="sex_at_birth_<?php print($form_id);?>"><input type="text" id="" value="" style="width:100%;height:25px;"></div>
</div>

<div style="width:100%;height:30px;float:left;margin-top:10px;">
<div style="width:235px;height:30px;line-height:30px;float:left;font-weight:bold;">Patient usual place of residence:</div>
<div style="width:350px;height:30px;line-height:30px;float:left;" id="sex_at_birth_<?php print($form_id);?>"><input type="text" id="" value="" style="width:100%;height:25px;"></div>
</div>

<div style="width:100%;height:30px;float:left;">
<div style="width:70px;height:30px;line-height:30px;float:left;font-weight:bold;">Province:</div>
<div style="width:200px;height:30px;line-height:30px;float:left;" id="sex_at_birth_<?php print($form_id);?>"><input type="text" id="" value="" style="width:100%;height:25px;"></div>

<div style="width:60px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:10px;">District:</div>
<div style="width:200px;height:30px;line-height:30px;float:left;" id="sex_at_birth_<?php print($form_id);?>"><input type="text" id="" value="" style="width:100%;height:25px;"></div>
</div>

<div style="width:100%;height:30px;line-height:30px;background-color:#777;float:left;color:#fff;margin-top:5px;font-weight:bold;">Section 2: Clinical Information</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;margin-top:5px;font-weight:bold;">Patient clinical course</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:200px;height:30px;line-height:30px;float:left;">Date of onset of symptoms:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[398] == ''){
	$dob_date = date('m/j/Y',time());
	
}else{
	$dob_date = $form_option_value[398];
	
}

$dob_date_array = explode('/',$dob_date);

$dob_day = $dob_date_array[1];
$dob_month = $dob_date_array[0];
$dob_year = $dob_date_array[2];
?>


<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_day_menu').toggle('fast');" id="active_dob_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_day);?></div>

<div class="option_menu" id="initiation_dob_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_day" id="selected_dob_initiation_day" value="<?php print($dob_day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;margin-left:5px;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_month_menu').toggle('fast');" id="active_dob_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_month);?></div>


<div class="option_menu" id="initiation_dob_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_month" id="selected_dob_initiation_month" value="<?php print($dob_month);?>">


</div>

<div style="line-height:30px;width:32px;height:30px;float:left;margin-left:5px;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">


<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. To change the year of birth, change the age on the client profile')" id="active_dob_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_year);?></div>


<div class="option_menu" id="initiation_dob_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_year_menu').toggle('fast');$('#active_dob_initiation_year').html($(this).html());$('#selected_dob_initiation_year').val(<?php print($y);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_dob_initiation_year" id="selected_dob_initiation_year" value="<?php print($dob_year);?>">
</div>
<input type="hidden" id="option_346" value="<?php print($dob_date);?>">

<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="date_of_onset_asymptomatic" name="date_of_onset_of_symptoms"><label for="date_of_onset_asymptomatic">Asymptomatic</label><input type="radio" id="date_of_onset_unknown" name="date_of_onset_of_symptoms"><label for="date_of_onset_unknown">Unknown</label></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:200px;height:30px;line-height:30px;float:left;">Admission to hospital:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="admission_to_hospital_no" name="admission_to_hospital"><label for="admission_to_hospital_no">No</label><input type="radio" id="date_of_onset_unknown" name="admission_to_hospital"><label for="admission_to_hospital_yes">Yes</label><input type="radio" id="admission_to_hospital_unknown" name="admission_to_hospital"><label for="admission_to_hospital_unknown">Unknown</label></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:230px;height:30px;line-height:30px;float:left;">First date of admission to hospital:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[398] == ''){
	$dob_date = date('m/j/Y',time());
	
}else{
	$dob_date = $form_option_value[398];
	
}

$dob_date_array = explode('/',$dob_date);

$dob_day = $dob_date_array[1];
$dob_month = $dob_date_array[0];
$dob_year = $dob_date_array[2];
?>


<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_day_menu').toggle('fast');" id="active_dob_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_day);?></div>

<div class="option_menu" id="initiation_dob_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_day" id="selected_dob_initiation_day" value="<?php print($dob_day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;margin-left:5px;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_month_menu').toggle('fast');" id="active_dob_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_month);?></div>


<div class="option_menu" id="initiation_dob_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_month" id="selected_dob_initiation_month" value="<?php print($dob_month);?>">


</div>

<div style="line-height:30px;width:32px;height:30px;float:left;margin-left:5px;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">


<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. To change the year of birth, change the age on the client profile')" id="active_dob_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_year);?></div>


<div class="option_menu" id="initiation_dob_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_year_menu').toggle('fast');$('#active_dob_initiation_year').html($(this).html());$('#selected_dob_initiation_year').val(<?php print($y);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_dob_initiation_year" id="selected_dob_initiation_year" value="<?php print($dob_year);?>">
</div>
<input type="hidden" id="option_346" value="<?php print($dob_date);?>">
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:230px;height:30px;line-height:30px;float:left;">Name of hospital:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="text" id="" style="width:220px;height:25px;"></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:200px;height:30px;line-height:30px;float:left;">Date of isolation:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[398] == ''){
	$dob_date = date('m/j/Y',time());
	
}else{
	$dob_date = $form_option_value[398];
	
}

$dob_date_array = explode('/',$dob_date);

$dob_day = $dob_date_array[1];
$dob_month = $dob_date_array[0];
$dob_year = $dob_date_array[2];
?>


<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_day_menu').toggle('fast');" id="active_dob_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_day);?></div>

<div class="option_menu" id="initiation_dob_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_day" id="selected_dob_initiation_day" value="<?php print($dob_day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;margin-left:5px;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_month_menu').toggle('fast');" id="active_dob_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_month);?></div>


<div class="option_menu" id="initiation_dob_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_month" id="selected_dob_initiation_month" value="<?php print($dob_month);?>">


</div>

<div style="line-height:30px;width:32px;height:30px;float:left;margin-left:5px;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">


<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. To change the year of birth, change the age on the client profile')" id="active_dob_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_year);?></div>


<div class="option_menu" id="initiation_dob_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_year_menu').toggle('fast');$('#active_dob_initiation_year').html($(this).html());$('#selected_dob_initiation_year').val(<?php print($y);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_dob_initiation_year" id="selected_dob_initiation_year" value="<?php print($dob_year);?>">
</div>
<input type="hidden" id="option_346" value="<?php print($dob_date);?>">
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:200px;height:30px;line-height:30px;float:left;">Was the patient ventilated:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="was_patient_ventilated_no" name="was_patient_ventilated"><label for="was_patient_ventilated_no">No</label><input type="radio" id="was_patient_ventilated_yes" name="was_patient_ventilated"><label for="was_patient_ventilated_yes">Yes</label><input type="radio" id="was_patient_ventilated_unknown" name="was_patient_ventilated"><label for="was_patient_ventilated_unknown">Unknown</label></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:230px;height:30px;line-height:30px;float:left;">Health status at time of reporting:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="health_status_at_time_of_reporting_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_recovered">Recovered</label><input type="radio" id="health_status_at_time_of_reporting_not_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_not_recovered">Not recovered</label><input type="radio" id="health_status_at_time_of_reporting_death" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_death">Death</label><input type="radio" id="health_status_at_time_of_reporting_unknown" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_unknown">Unknown</label></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:270px;height:30px;line-height:30px;float:left;">Date of death or discharge if applicable:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[398] == ''){
	$dob_date = date('m/j/Y',time());
	
}else{
	$dob_date = $form_option_value[398];
	
}

$dob_date_array = explode('/',$dob_date);

$dob_day = $dob_date_array[1];
$dob_month = $dob_date_array[0];
$dob_year = $dob_date_array[2];
?>


<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_day_menu').toggle('fast');" id="active_dob_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_day);?></div>

<div class="option_menu" id="initiation_dob_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_day_menu').toggle('fast');$('#active_dob_initiation_day').html($(this).html());$('#selected_dob_initiation_day').val(<?php print($d);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_day" id="selected_dob_initiation_day" value="<?php print($dob_day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;margin-left:5px;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#initiation_dob_month_menu').toggle('fast');" id="active_dob_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_month);?></div>


<div class="option_menu" id="initiation_dob_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_month_menu').toggle('fast');$('#active_dob_initiation_month').html($(this).html());$('#selected_dob_initiation_month').val(<?php print($m);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_dob_initiation_month" id="selected_dob_initiation_month" value="<?php print($dob_month);?>">


</div>

<div style="line-height:30px;width:32px;height:30px;float:left;margin-left:5px;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">


<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. To change the year of birth, change the age on the client profile')" id="active_dob_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($dob_year);?></div>


<div class="option_menu" id="initiation_dob_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_dob_year_menu').toggle('fast');$('#active_dob_initiation_year').html($(this).html());$('#selected_dob_initiation_year').val(<?php print($y);?>);$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_dob_initiation_year" id="selected_dob_initiation_year" value="<?php print($dob_year);?>">
</div>
<input type="hidden" id="option_346" value="<?php print($dob_date);?>">
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;">Patient symptoms (check all reported symptoms): <input type="checkbox" id="no_symptoms"><label for="no_symptoms">None/Asymptomatic</label></div>
<div style="width:100%;float:left;margin-left:10px;float:left;">
<div style="width:300px;height:120px;float:left;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="history_of_fever"><label for="history_of_fever">History of Fever</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="general_weakness"><label for="general_weakness">General Weakness</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="cough"><label for="cough">Cough</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="sore_throat"><label for="sore_throat">Sore throat</label>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="runny_nose"><label for="runny_nose">Runny nose</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<div style="width:auto;float:left;">
<input type="checkbox" id="other_symptom"><label for="other_symptom">Other, specify</label></div>
<div style="width:auto;float:left;"><input type="text" id="" style="margin-left:10px;width:120px;float:left;">
</div>
</div>
</div>

<div style="width:300px;height:120px;float:left;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="shortness_of_breath"><label for="shortness_of_breath">Shortness of breath</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="diarrhoea"><label for="diarrhoea">Diarrhoea</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="nausea"><label for="nausea">Nausea/Vomiting</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="headache"><label for="headache">Headache</label>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="irritability"><label for="irritability">Irritability</label>
</div>
</div>

<div style="width:300px;height:120px;float:left;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="pain_symptom"><label for="pain_symptom">Pain (check all applicable)</label>
</div>
<div style="width:35%;height:20px;line-height:20px;float:left;margin-left:10px;">
<input type="checkbox" id="muscular_pain"><label for="muscular_pain">Muscular</label>
</div>
<div style="width:35%;height:20px;line-height:20px;float:left;margin-left:10px;">
<input type="checkbox" id="chest_pains"><label for="chest_pains">Chest</label>
</div>
<div style="width:35%;height:20px;line-height:20px;float:left;margin-left:10px;">
<input type="checkbox" id="abdominal_pain"><label for="abdominal_pain">Abdominal</label>
</div>

<div style="width:35%;height:20px;line-height:20px;float:left;margin-left:10px;">
<input type="checkbox" id="joint_pain"><label for="joint_pain">Joint</label>
</div>
</div>

</div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;">Patient signs:</div>
<div style="width:100%;float:left;margin-left:10px;float:left;">
<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:90px;height:30px;line-height:30px;float:left;">Temperature:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="text" id="" style="width:120px;height:25px;"></div>
</div>
<div style="width:100%;height:30px;line-height:30px;float:left;">Check all observed signs:</div>
<div style="width:300px;height:120px;float:left;">

<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="pharyngeal_exudate"><label for="pharyngeal_exudate">Pharyngeal exudate</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="conjuctival_injection"><label for="conjuctival_injection">Conjuctival injection</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="seizure"><label for="seizure">Seizure</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<div style="width:auto;float:left;">
<input type="checkbox" id="other_symptom"><label for="other_symptom">Other, specify</label></div>
<div style="width:auto;float:left;"><input type="text" id="" style="margin-left:10px;width:120px;float:left;">
</div>
</div>
</div>

<div style="width:300px;height:120px;float:left;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="coma"><label for="coma">Coma</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="dyspea"><label for="dyspea">Dyspea / Tackypnea</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="abnormal_lung_auscultation"><label for="abnormal_lung_auscultation">Abnormal lung auscultation</label>
</div>

</div>

<div style="width:300px;height:120px;float:left;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="abnormal_lung_xray_findings"><label for="abnormal_lung_xray_findings">Abnormal lung X-Ray findings</label>
</div>

</div>

</div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;">Underlying conditions and comorbidity:</div>
<div style="width:100%;float:left;margin-left:10px;float:left;">

<div style="width:300px;height:120px;float:left;">
<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Pregnancy (Trimester):</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="text" id="" style="width:120px;height:25px;"></div>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="cardiovascular_disease"><label for="cardiovascular_disease">Cardiovascular disease, including hypertension</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="diabetes"><label for="diabetes">Diabetes</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="liver_disease"><label for="liver_disease">Liver Disease</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="chronic_neurological"><label for="chronic_neurological">Chronic neurological or neuromuscular disease</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<div style="width:auto;float:left;">
<input type="checkbox" id="other_underlying_condition"><label for="other_underlying_condition">Other, specify</label></div>
<div style="width:auto;float:left;"><input type="text" id="" style="margin-left:10px;width:120px;float:left;">
</div>
</div>
</div>

<div style="width:300px;height:120px;float:left;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="post_partum"><label for="post_partum">Post-partum (< 6 weeks)</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="immunodeficiency"><label for="immunodeficiency">Immunodeficiency, including HIV</label>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="renal_disease"><label for="renal_disease">Renal Disease</label>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="chronic_lung_disease"><label for="chronic_lung_disease">Chronic lung disease</label>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;">
<input type="checkbox" id="malignancy"><label for="malignancy">Malignancy</label>
</div>

</div>


</div>
</div>
</div>

<div style="width:100%;height:30px;line-height:30px;background-color:#777;float:left;color:#fff;margin-top:20px;font-weight:bold;">Section 3: Exposure and travel information in the 14 days prior to symptom onset (prior to reporting if asymptomatic)</div>
<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;margin-top:5px;font-weight:bold;">Occupation: (tick any that apply)</div>

<div style="width:300px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_student"><label for="occupation_student">Student</label></div>

<div style="width:300px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_healthcare_worker"><label for="occupation_healthcare_worker">Health care worker</label></div>

<div style="width:300px;height:20px;line-height:20px;float:left;"><div style="width:auto;float:left;"><input type="checkbox" id="other_occupation"><label for="other_occupation">Other, specify</label></div> <div style="width:auto;float:left;margin-left:5px;"><input type="text" style="width:120px;float:left;"></div></div>

<div style="width:300px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_working_with_animals"><label for="occupation_working_with_animals">Working with animals</label></div>

<div style="width:300px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_health_laborotary_worker"><label for="occupation_health_laborotary_worker">Health laborotory worker</label></div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:370px;height:30px;line-height:30px;float:left;">Has the patient traveled in the 14 days prior to symptom onset:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="health_status_at_time_of_reporting_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_recovered">No</label><input type="radio" id="health_status_at_time_of_reporting_not_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_not_recovered">Yes</label><input type="radio" id="health_status_at_time_of_reporting_death" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_death">Unknown</label></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:100%;height:30px;line-height:30px;float:left;">Has the patient had <strong>close contact</strong> with a person with acute respiratory infection in the 14 days prior to symptoms onset?:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="health_status_at_time_of_reporting_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_recovered">No</label><input type="radio" id="health_status_at_time_of_reporting_not_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_not_recovered">Yes</label><input type="radio" id="health_status_at_time_of_reporting_death" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_death">Unknown</label></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">If yes, contact setting (Check all that apply)</div>

<div style="width:150px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_healthcare_worker"><label for="occupation_healthcare_worker">Health care setting</label></div>

<div style="width:150px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_working_with_animals"><label for="occupation_working_with_animals">Family setting</label></div>

<div style="width:100px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_working_with_animals"><label for="occupation_working_with_animals">Workplace</label></div>

<div style="width:100px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_working_with_animals"><label for="occupation_working_with_animals">Unknown</label></div>

<div style="width:250px;height:20px;line-height:20px;float:left;"><div style="width:auto;float:left;"><input type="checkbox" id="other_occupation"><label for="other_occupation">Other, specify</label></div> <div style="width:auto;float:left;margin-left:5px;"><input type="text" style="width:120px;float:left;"></div></div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:100%;height:30px;line-height:30px;float:left;">Has the patient <strong>had contact with a probable or confirmed case of COVID-19 </strong>in the 14 days prior to symptoms onset?:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="health_status_at_time_of_reporting_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_recovered">No</label><input type="radio" id="health_status_at_time_of_reporting_not_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_not_recovered">Yes</label><input type="radio" id="health_status_at_time_of_reporting_death" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_death">Unknown</label></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">If yes, please list unique case identifiers of all probable or confirmed cases</div>

<div style="width:270px;height:20px;line-height:20px;float:left;"><div style="width:auto;float:left;">Case 1 identifier:</div> <input type="text" id="occupation_healthcare_worker" style="width:150px;float:left;"></div>

<div style="width:270px;height:20px;line-height:20px;float:left;"><div style="width:auto;float:left;">Case 2 identifier:</div> <input type="text" id="occupation_healthcare_worker" style="width:150px;float:left;"></div>

<div style="width:270px;height:20px;line-height:20px;float:left;"><div style="width:auto;float:left;">Case 3 identifier:</div> <input type="text" id="occupation_healthcare_worker" style="width:150px;float:left;"></div>


<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">If yes, contact setting (Check all that apply)</div>

<div style="width:150px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_healthcare_worker"><label for="occupation_healthcare_worker">Health care setting</label></div>

<div style="width:150px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_working_with_animals"><label for="occupation_working_with_animals">Family setting</label></div>

<div style="width:100px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_working_with_animals"><label for="occupation_working_with_animals">Workplace</label></div>

<div style="width:100px;height:20px;line-height:20px;float:left;"><input type="checkbox" id="occupation_working_with_animals"><label for="occupation_working_with_animals">Unknown</label></div>

<div style="width:100%;height:20px;line-height:20px;float:left;">
<div style="width:470px;height:20px;line-height:20px;float:left;"><div style="width:auto;float:left;">If yes, location/city/country for exposure:</div> <input type="text" id="occupation_healthcare_worker" style="width:150px;float:left;margin-left:5px;"></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:510px;height:30px;line-height:30px;float:left;">Has the patient visited any live animal markets in the 14 days prior to symptoms onset:</div>
<div style="width:auto;float:left;margin-left:10px;float:left;"><input type="radio" id="health_status_at_time_of_reporting_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_recovered">No</label><input type="radio" id="health_status_at_time_of_reporting_not_recovered" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_not_recovered">Yes</label><input type="radio" id="health_status_at_time_of_reporting_death" name="health_status_at_time_of_reporting"><label for="health_status_at_time_of_reporting_death">Unknown</label></div>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;">
<div style="width:470px;height:20px;line-height:20px;float:left;"><div style="width:auto;float:left;">If yes, location/city/country for exposure:</div> <input type="text" id="occupation_healthcare_worker" style="width:150px;float:left;margin-left:5px;"></div>
</div>

</div>
</div>
</div>
</div>