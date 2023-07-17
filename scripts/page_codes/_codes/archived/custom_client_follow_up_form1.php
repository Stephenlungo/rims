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
	
	$follow_up_validation_status = 1;
	
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
	
	$follow_up_validation_status = 0;
}
$this_client = mysqli_query($connect,"select * from prep_clients where id = $client_id")or die(mysqli_error($connect));
if(mysqli_num_rows($this_client)){
	$this_client_results = mysqli_fetch_array($this_client,MYSQLI_ASSOC);
	$prep_id = $this_client_results['prep_id'];
	
}else{
	$prep_id = 'Unassigned';
}

$last_appointment_values = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_category_option_id = 341 and client_id = $client_id order by _date desc")or die(mysqli_error($connect));

if(!mysqli_num_rows($last_appointment_values)){
	$last_initiation_values = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_category_option_id = 340 and client_id = $client_id order by _date desc")or die(mysqli_error($connect));
	
	if(mysqli_num_rows($last_initiation_values)){
		$last_initiation_value_reuslts = mysqli_fetch_array($last_initiation_values,MYSQLI_ASSOC);
		
		$last_visit_time_stamp = $last_initiation_value_reuslts['_value'];
		
	}else{
		$last_visit_time_stamp = time();
		
	}
	
	
}else{
	
	$last_appointment_value_reuslts = mysqli_fetch_array($last_appointment_values,MYSQLI_ASSOC);
	
	$last_visit_time_stamp = $last_appointment_value_reuslts['_value'];
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

<div style="width:100%;height:25px;line-height:25px;float:left;text-align:center;font-weight:bold;font-size:1.1em;margin-bottom:10px;"><div style="width:230px;height:25px;margin:0 auto;border:solid 1px #999;border-radius:15px;">PrEP CLIENT FOLLOW UP</div></div>


<div style="width:99.3%;height:auto;float:left;padding:2px;">
<div style="width:auto;min-height:30px;height:auto;line-height:30px;float:left;">

<div style="width:65px;height:30px;line-height:30px;float:left;font-weight:bold;">Province:</div>
<div style="width:1c0px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_province_<?php print($form_id);?>">Copperbelt</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">District:</div>
<div style="width:150px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_district_<?php print($form_id);?>">Kitwe</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">Facility:</div>
<div style="width:120px;min-height:30px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #000;" id="client_facility_<?php print($form_id);?>">Buzakile Main Hospital</div>

</div>

<div style="width:290px;height:30px;float:right;" id="follow_up_date_holder">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;">Date:</div>
<?php
if($form_option_value[341] == ''){
	$follow_up_date = 0;
	
	$follow_up_day = 0;
	$follow_up_month = 0;
	$follow_up_year = 0;
	
	$follow_up_day_title = 'Select';
	$follow_up_month_title = 'Select';
	$follow_up_year_title = 'Select';
	
}else{
	$follow_up_date = $form_option_value[341];
	
	$follow_up_date_array = explode('/',$follow_up_date);

	$follow_up_day = $follow_up_date_array[1];
	$follow_up_month = $follow_up_date_array[0];
	$follow_up_year = $follow_up_date_array[2];
	
	$follow_up_day_title = $follow_up_day;
	$follow_up_month_title = $follow_up_month;
	$follow_up_year_title = $follow_up_year;
}


?>


<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_day_menu').toggle('fast');$('#follow_up_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_follow_up_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_day_title);?></div>

<div class="option_menu" id="follow_up_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_day_menu').toggle('fast');$('#active_follow_up_day').html($(this).html());$('#selected_follow_up_day').val(<?php print($d);?>);$('#option_341').val($('#selected_follow_up_month').val()+'/'+$('#selected_follow_up_day').val()+'/'+$('#selected_follow_up_year').val());validate_follow_up_date(<?php print($data_set_id.','.$form_id);?>,341);" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_day_menu').toggle('fast');$('#active_follow_up_day').html($(this).html());$('#selected_follow_up_day').val(<?php print($d);?>);$('#option_341').val($('#selected_follow_up_month').val()+'/'+$('#selected_follow_up_day').val()+'/'+$('#selected_follow_up_year').val());validate_follow_up_date(<?php print($data_set_id.','.$form_id);?>,341);" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_day" id="selected_follow_up_day" value="<?php print($follow_up_day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;margin-left:5px;">Month:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_month_menu').toggle('fast');$('#follow_up_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_follow_up_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_month_title);?></div>


<div class="option_menu" id="follow_up_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_month_menu').toggle('fast');$('#active_follow_up_month').html($(this).html());$('#selected_follow_up_month').val(<?php print($m);?>);$('#option_341').val($('#selected_follow_up_month').val()+'/'+$('#selected_follow_up_day').val()+'/'+$('#selected_follow_up_year').val());validate_follow_up_date(<?php print($data_set_id.','.$form_id);?>,341);" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_month_menu').toggle('fast');$('#active_follow_up_month').html($(this).html());$('#selected_follow_up_month').val(<?php print($m);?>);$('#option_341').val($('#selected_follow_up_month').val()+'/'+$('#selected_follow_up_day').val()+'/'+$('#selected_follow_up_year').val());validate_follow_up_date(<?php print($data_set_id.','.$form_id);?>,341);" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_month" id="selected_follow_up_month" value="<?php print($follow_up_month);?>">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_year_menu').toggle('fast');$('#follow_up_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_follow_up_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_year_title);?></div>


<div class="option_menu" id="follow_up_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_year_menu').toggle('fast');$('#active_follow_up_year').html($(this).html());$('#selected_follow_up_year').val(<?php print($y);?>);$('#option_341').val($('#selected_follow_up_month').val()+'/'+$('#selected_follow_up_day').val()+'/'+$('#selected_follow_up_year').val());validate_follow_up_date(<?php print($data_set_id.','.$form_id);?>,341);" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_follow_up_year" id="selected_follow_up_year" value="<?php print($follow_up_year);?>">
</div>
<div style="width:100%;height:30px;line-height:30px;float:right;text-align:center;color:brown" id="date_validation_status"></div>
<input type="hidden" id="follow_up_date_validated" value="<?php print($follow_up_validation_status);?>">
</div>
<input type="hidden" id="option_341" value="<?php print($form_option_value[341]);?>">
</div>
















<div style="width:99.3%;height:auto;float:left;padding:2px;">
<div style="width:auto;height:auto;line-height:30px;float:left;">

<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">Name:</div>
<div style="width:190px;min-height:30px;height:auto;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_name_<?php print($form_id);?>">Francis Kasonde</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">Gender:</div>
<div style="width:90px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_gender_<?php print($form_id);?>">Rather not say</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">PrEP ID:</div>
<div style="width:60px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" ><?php print($prep_id);?></div>

</div>
</div>

<div style="width:99.5%;height:auto;float:left;border: solid 1px #000;margin-top:5px;font-size:0.9em;padding:2px;">
<div style="width:49%;height:344px;float:left;border-right:solid 1px #000;">
<div style="width:100%;height:80px;float:left;margin-bottom:10px;">

<div style="width:45%;float:left;">
<div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;">Date of Last Visit</div>

<?php
if($form_option_value[318] == ''){
	$last_visit_date = date('m/j/Y',$last_visit_time_stamp);

}else{
	$last_visit_date = $form_option_value[318];
	//print($form_option_value[318]);
}

$last_visit_date_array = explode('/',$last_visit_date);

$last_visit_day = $last_visit_date_array[1];
$last_visit_month = $last_visit_date_array[0];
$last_visit_year = $last_visit_date_array[2];
?>

<div style="width:270px;height:30px;float:left;">
<div style="line-height:30px;width:15px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. The date is picked from previous forms for this client');" id="active_follow_up_last_visit_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($last_visit_day);?></div>

<div class="option_menu" id="follow_up_last_visit_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_last_visit_day_menu').toggle('fast');$('#active_follow_up_last_visit_day').html($(this).html());$('#selected_follow_up_last_visit_day').val(<?php print($d);?>);$('#option_318').val($('#selected_follow_up_last_visit_month').val()+'/'+$('#selected_follow_up_last_visit_day').val()+'/'+$('#selected_follow_up_last_visit_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_last_visit_day_menu').toggle('fast');$('#active_follow_up_last_visit_day').html($(this).html());$('#selected_follow_up_last_visit_day').val(<?php print($d);?>);$('#option_318').val($('#selected_follow_up_last_visit_month').val()+'/'+$('#selected_follow_up_last_visit_day').val()+'/'+$('#selected_follow_up_last_visit_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_last_visit_day" id="selected_follow_up_last_visit_day" value="<?php print($last_visit_day);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. The date is picked from previous forms for this client');" id="active_follow_up_last_visit_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($last_visit_month);?></div>


<div class="option_menu" id="follow_up_last_visit_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_last_visit_month_menu').toggle('fast');$('#active_follow_up_last_visit_month').html($(this).html());$('#selected_follow_up_last_visit_month').val(<?php print($m);?>);$('#option_318').val($('#selected_follow_up_last_visit_month').val()+'/'+$('#selected_follow_up_last_visit_day').val()+'/'+$('#selected_follow_up_last_visit_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_last_visit_month_menu').toggle('fast');$('#active_follow_up_last_visit_month').html($(this).html());$('#selected_follow_up_last_visit_month').val(<?php print($m);?>);$('#option_318').val($('#selected_follow_up_last_visit_month').val()+'/'+$('#selected_follow_up_last_visit_day').val()+'/'+$('#selected_follow_up_last_visit_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_last_visit_month" id="selected_follow_up_last_visit_month" value="<?php print($last_visit_month);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="alert('You cannot change this option. The date is picked from previous forms for this client');" id="active_follow_up_last_visit_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($last_visit_year);?></div>


<div class="option_menu" id="follow_up_last_visit_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_last_visit_year_menu').toggle('fast');$('#active_follow_up_last_visit_year').html($(this).html());$('#selected_follow_up_last_visit_year').val(<?php print($y);?>);$('#option_318').val($('#selected_follow_up_last_visit_month').val()+'/'+$('#selected_follow_up_last_visit_day').val()+'/'+$('#selected_follow_up_last_visit_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_follow_up_last_visit_year" id="selected_follow_up_last_visit_year" value="<?php print($last_visit_year);?>">
</div>
<input type="hidden" id="option_318" value="<?php print($form_option_value[318]);?>">
</div>

</div>

<div style="width:55%;hight:auto;float:right;">
<div style="width:100%;height:20px;linee-height:20px;float:left;padding-bottom:5px;" id="option_2_title">Presenting Complaints <input <?php print($form_option_checked[1]);?> type="radio" name="presenting_complaints" onclick="$('#option_1').val(1);$('#option_2').val(1);document.getElementById('option_2_0').disabled=false;document.getElementById('option_2_1').disabled=false;document.getElementById('option_2_2').disabled=false;" id="client_presenting_complaints"> <label for="client_presenting_complaints">Yes</label> <input <?php if(!$form_option_value[1]){print(' checked ');}?> type="radio" name="presenting_complaints" onclick="$('#option_1').val('');$('#option_2').val('');document.getElementById('option_2_0').disabled=true;document.getElementById('option_2_1').disabled=true;document.getElementById('option_2_2').disabled=true;" id="client_not_presenting_complaints"> <label for="client_not_presenting_complaints">No</label></div>

<input type="hidden" id="option_1" value="<?php print($form_option_value[1]);?>">

<?php
$input_text = explode(']',$form_option_text[2]);?>

<div style="width:100%;height:22px;line-height:22px;float:left;"><input <?php if(!$form_option_value[1]){print(' disabled ');}?> type="text" style="width:99%;height:20px;" id="option_2_0" onchange="$('#option_2_text').val($('#option_2_0').val()+']'+$('#option_2_1').val()+']'+$('#option_2_2').val());" value="<?php if(isset($input_text[0])){print($input_text[0]);};?>"></div><div style="width:100%;height:22px;line-height:22px;float:left;"><input <?php if(!$form_option_value[1]){print(' disabled ');}?> type="text" style="width:99%;height:20px;" id="option_2_1" onchange="$('#option_2_text').val($('#option_2_0').val()+']'+$('#option_2_1').val()+']'+$('#option_2_2').val());" value="<?php if(isset($input_text[1])){print($input_text[1]);};?>"></div><div style="width:100%;height:22px;line-height:22px;float:left;"><input <?php if(!$form_option_value[1]){print(' disabled ');}?> type="text" style="width:99%;height:20px;" id="option_2_2" onchange="$('#option_2_text').val($('#option_2_0').val()+']'+$('#option_2_1').val()+']'+$('#option_2_2').val());" value="<?php if(isset($input_text[2])){print($input_text[2]);};?>"></div>
</div>
<input type="hidden" id="option_2" value="<?php print($form_option_value[2]);?>">
<input type="hidden" id="option_2_text" value="<?php print($form_option_text[2]);?>">
</div>

<div style="width:100%;height:auto;float:left;border-top:solid 1px #000">
<div style="width:210px;height:250px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:30px;line-height:30px;font-weight:bold;text-align:center;">SCREEN FOR ACUTE HIV INFECTION</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Swollen nodes</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="swallen_nodes_yes" <?php print($form_option_checked[4]);?> name="swollen_nodes" onclick="$('#option_4').val(1);"><label for="swallen_nodes_yes">Yes</label> <input type="radio" name="swollen_nodes" id="swallen_nodes_no" onclick="$('#option_4').val('');" <?php if(!$form_option_value[4]){print(' checked ');}?>><label for="swallen_nodes_no">No</label></div><input type="hidden" id="option_4" value="<?php print($form_option_value[4]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Fever</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="fever_yes" <?php print($form_option_checked[5]);?> name="fever" onclick="$('#option_5').val(1);"><label for="fever_yes">Yes</label> <input type="radio" name="fever" id="fever_no" onclick="$('#option_5').val('');" <?php if(!$form_option_value[5]){print(' checked ');}?>><label for="fever_no">No</label></div><input type="hidden" id="option_5" value="<?php print($form_option_value[5]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Sore throat</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="sore_throat_yes" <?php print($form_option_checked[6]);?> name="sore_throat" onclick="$('#option_6').val(1);"><label for="sore_throat_yes">Yes</label> <input type="radio" name="sore_throat" id="sore_throat_no" onclick="$('#option_6').val('');" <?php if(!$form_option_value[6]){print(' checked ');}?>><label for="sore_throat_no">No</label></div><input type="hidden" id="option_6" value="<?php print($form_option_value[6]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Muscle aches</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="muscle_aches_yes" <?php print($form_option_checked[7]);?> name="muscle_aches" onclick="$('#option_7').val(1);"><label for="muscle_aches_yes">Yes</label> <input type="radio" name="muscle_aches" id="muscle_aches_no" onclick="$('#option_7').val('');" <?php if(!$form_option_value[7]){print(' checked ');}?>><label for="muscle_aches_no">No</label></div><input type="hidden" id="option_7" value="<?php print($form_option_value[7]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Fatigue</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="fatigue_yes" <?php print($form_option_checked[8]);?> name="fatigue" onclick="$('#option_8').val(1);"><label for="fatigue_yes">Yes</label> <input type="radio" name="fatigue" id="fatigue_no" onclick="$('#option_8').val('');" <?php if(!$form_option_value[8]){print(' checked ');}?>><label for="fatigue_no">No</label></div><input type="hidden" id="option_8" value="<?php print($form_option_value[8]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Rash</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="rash_yes" <?php print($form_option_checked[9]);?> name="rash" onclick="$('#option_9').val(1);"><label for="rash_yes">Yes</label> <input type="radio" name="rash" id="rash_no" onclick="$('#option_9').val('');" <?php if(!$form_option_value[9]){print(' checked ');}?>><label for="rash_no">No</label></div><input type="hidden" id="option_9" value="<?php print($form_option_value[9]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Chills</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="chills_yes" <?php print($form_option_checked[10]);?> name="chills" onclick="$('#option_10').val(1);"><label for="chills_yes">Yes</label> <input type="radio" name="chills" id="chills_no" onclick="$('#option_10').val('');" <?php if(!$form_option_value[10]){print(' checked ');}?>><label for="chills_no">No</label></div><input type="hidden" id="option_10" value="<?php print($form_option_value[10]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Headache</div><div style="width:48%;height:20px;float:right;"><input type="radio" id="headache_yes" <?php print($form_option_checked[11]);?> name="headache" onclick="$('#option_11').val(1);"><label for="headache_yes">Yes</label> <input type="radio" name="headache" id="headache_no" onclick="$('#option_11').val('');" <?php if(!$form_option_value[11]){print(' checked ');}?>><label for="headache_no">No</label></div><input type="hidden" id="option_11" value="<?php print($form_option_value[11]);?>"></div>
</div>




<div style="width:190px;height:250px;float:left;padding:2px;">
<div style="width:100%;height:30px;line-height:30px;font-weight:bold;text-align:center;">STI SCREENING</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Virginal urethral discharge</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[12]);?> name="verginal_disacharge" id="verginal_discharge_yes" onclick="$('#option_12').val(1);"><label for="verginal_discharge_yes">Yes </label><input type="radio" name="verginal_disacharge" id="verginal_discharge_no" <?php if(!$form_option_value[12]){print(' checked ');}?> onclick="$('#option_12').val('');"><label for="verginal_discharge_no" >No</label></div>
<input type="hidden" id="option_12" value="<?php print($form_option_value[12]);?>">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Lower abdomen pain</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[13]);?> name="lower_abdomen" id="lower_abdomen_yes" onclick="$('#option_13').val(1);"><label for="lower_abdomen_yes">Yes </label><input type="radio" name="lower_abdomen" id="lower_abdomen_no" <?php if(!$form_option_value[13]){print(' checked ');}?> onclick="$('#option_13').val('');"><label for="lower_abdomen_no" >No</label></div>
<input type="hidden" id="option_13" value="<?php print($form_option_value[13]);?>">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Dysuria</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[14]);?> name="dysuria" id="dysuria_yes" onclick="$('#option_14').val(1);"><label for="dysuria_yes">Yes </label><input type="radio" name="dysuria" id="dysuria_no" <?php if(!$form_option_value[14]){print(' checked ');}?> onclick="$('#option_14').val('');"><label for="dysuria_no" >No</label></div>
<input type="hidden" id="option_14" value="<?php print($form_option_value[14]);?>">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Genital Ulcers</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[15]);?> name="genital_ulcers" id="genital_ulcers_yes" onclick="$('#option_15').val(1);"><label for="genital_ulcers_yes">Yes </label><input type="radio" name="genital_ulcers" id="genital_ulcers_no" <?php if(!$form_option_value[15]){print(' checked ');}?> onclick="$('#option_15').val('');"><label for="genital_ulcers_no" >No</label></div>
<input type="hidden" id="option_15" value="<?php print($form_option_value[15]);?>">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Dyspareunia</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[16]);?> name="dyspareunia" id="dyspareunia_yes" onclick="$('#option_16').val(1);"><label for="dyspareunia_yes">Yes </label><input type="radio" name="dyspareunia" id="dyspareunia_no" <?php if(!$form_option_value[16]){print(' checked ');}?> onclick="$('#option_16').val('');"><label for="dyspareunia_no" >No</label></div>
<input type="hidden" id="option_16" value="<?php print($form_option_value[16]);?>">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Chlamydia</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[17]);?> name="chlamydia" id="chlamydia_yes" onclick="$('#option_17').val(1);"><label for="chlamydia_yes">Yes </label><input type="radio" name="chlamydia" id="chlamydia_no" <?php if(!$form_option_value[17]){print(' checked ');}?> onclick="$('#option_17').val('');"><label for="chlamydia_no" >No</label></div>
<input type="hidden" id="option_17" value="<?php print($form_option_value[17]);?>">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Gonorrhea</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[18]);?> name="gonorrhea" id="gonorrhea_yes" onclick="$('#option_18').val(1);"><label for="gonorrhea_yes">Yes </label><input type="radio" name="gonorrhea" id="gonorrhea_no" <?php if(!$form_option_value[18]){print(' checked ');}?> onclick="$('#option_18').val('');"><label for="gonorrhea_no" >No</label></div>
<input type="hidden" id="option_18" value="<?php print($form_option_value[18]);?>">
</div>

<div style="width:100%;min-height:20px;height:auto;line-height:15px;float:left;font-size:0.9em;"><i>If yes, follows syndrome management for treatment</i></div>
</div>


</div>

</div>

<div style="width:50%;height:343px;float:right;">
<div style="width:100%;line-height:30px;height:30px;float:left;">

<?php
if($form_option_text[19] == ''){
	$hiv = '0';
	
}else{
	$hiv = $form_option_text[19];
	
}
?>

<div style="width:30%;height:30px;float:left;"><div style="width:65px;height:30px;line-height:30px;float:left;">HIV</div>
<div style="width:50px;float:left;height:30px;line-height:30px;"><input type="text" style="width:90%;height:25px;border:solid 1px #aaa;" id="option_19_text" value="<?php print($hiv);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_19" value="1">

</div>
<div style="width:70%;height:30px;float:right;">
<div style="width:270px;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:30px;">Date:</div>
<div style="line-height:30px;width:15px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<?php
if($form_option_value[21] == ''){
	$follow_up_hiv_date = date('m/j/Y',time());
	
}else{
	$follow_up_hiv_date = $form_option_value[21];
	
}

$follow_up_hiv_date_array = explode('/',$follow_up_hiv_date);

$follow_up_hiv_day = $follow_up_hiv_date_array[1];
$follow_up_hiv_month = $follow_up_hiv_date_array[0];
$follow_up_hiv_year = $follow_up_hiv_date_array[2];
?>

<div class="option_item" title="Click to change option" onclick="$('#follow_up_hiv_day_menu').toggle('fast');" id="active_follow_up_hiv_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_hiv_day);?></div>

<div class="option_menu" id="follow_up_hiv_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hiv_day_menu').toggle('fast');$('#active_follow_up_hiv_day').html($(this).html());$('#selected_follow_up_hiv_day').val(<?php print($d);?>);$('#option_21').val($('#selected_follow_up_hiv_month').val()+'/'+$('#selected_follow_up_hiv_day').val()+'/'+$('#selected_follow_up_hiv_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hiv_day_menu').toggle('fast');$('#active_follow_up_hiv_day').html($(this).html());$('#selected_follow_up_hiv_day').val(<?php print($d);?>);$('#option_21').val($('#selected_follow_up_hiv_month').val()+'/'+$('#selected_follow_up_hiv_day').val()+'/'+$('#selected_follow_up_hiv_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_hiv_day" id="selected_follow_up_hiv_day" value="<?php print($follow_up_hiv_day);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_hiv_month_menu').toggle('fast');" id="active_follow_up_hiv_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_hiv_month);?></div>


<div class="option_menu" id="follow_up_hiv_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hiv_month_menu').toggle('fast');$('#active_follow_up_hiv_month').html($(this).html());$('#selected_follow_up_hiv_month').val(<?php print($m);?>);$('#option_21').val($('#selected_follow_up_hiv_month').val()+'/'+$('#selected_follow_up_hiv_day').val()+'/'+$('#selected_follow_up_hiv_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hiv_month_menu').toggle('fast');$('#active_follow_up_hiv_month').html($(this).html());$('#selected_follow_up_hiv_month').val(<?php print($m);?>);$('#option_21').val($('#selected_follow_up_hiv_month').val()+'/'+$('#selected_follow_up_hiv_day').val()+'/'+$('#selected_follow_up_hiv_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_hiv_month" id="selected_follow_up_hiv_month" value="<?php print($follow_up_hiv_month);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_hiv_year_menu').toggle('fast');" id="active_follow_up_hiv_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_hiv_year);?></div>


<div class="option_menu" id="follow_up_hiv_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hiv_year_menu').toggle('fast');$('#active_follow_up_hiv_year').html($(this).html());$('#selected_follow_up_hiv_year').val(<?php print($y);?>);$('#option_21').val($('#selected_follow_up_hiv_month').val()+'/'+$('#selected_follow_up_hiv_day').val()+'/'+$('#selected_follow_up_hiv_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_follow_up_hiv_year" id="selected_follow_up_hiv_year" value="<?php print($follow_up_hiv_year);?>">
</div>

</div>
</div>
<input type="hidden" id="option_21" value="<?php print($follow_up_hiv_date);?>"> 
</div>

<?php
if($form_option_text[24] == ''){
	$crcl = '0';
	
}else{
	$crcl = $form_option_text[24];
	
}
?>

<div style="width:100%;line-height:30px;height:30px;float:left;">
<div style="width:30%;height:30px;float:left;"><div style="width:65px;height:30px;line-height:30px;float:left;">CrCl
.</div>
<div style="width:50px;float:left;height:30px;line-height:30px;"><input type="text" style="width:90%;height:25px;border:solid 1px #aaa;" id="option_24_text" value="<?php print($crcl);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_24" value="1">

</div>
<div style="width:70%;height:30px;float:right;">
<div style="width:270px;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:30px;">Date:</div>
<div style="line-height:30px;width:15px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<?php
if($form_option_value[25] == ''){
	$follow_up_CrCl_date = date('m/j/Y',time());
	
}else{
	$follow_up_CrCl_date = $form_option_value[25];
	
}

$follow_up_CrCl_date_array = explode('/',$follow_up_CrCl_date);

$follow_up_CrCl_day = $follow_up_CrCl_date_array[1];
$follow_up_CrCl_month = $follow_up_CrCl_date_array[0];
$follow_up_CrCl_year = $follow_up_CrCl_date_array[2];
?>

<div class="option_item" title="Click to change option" onclick="$('#follow_up_CrCl_day_menu').toggle('fast');" id="active_follow_up_CrCl_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_CrCl_day);?></div>

<div class="option_menu" id="follow_up_CrCl_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_CrCl_day_menu').toggle('fast');$('#active_follow_up_CrCl_day').html($(this).html());$('#selected_follow_up_CrCl_day').val(<?php print($d);?>);$('#option_25').val($('#selected_follow_up_CrCl_month').val()+'/'+$('#selected_follow_up_CrCl_day').val()+'/'+$('#selected_follow_up_CrCl_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_CrCl_day_menu').toggle('fast');$('#active_follow_up_CrCl_day').html($(this).html());$('#selected_follow_up_CrCl_day').val(<?php print($d);?>);$('#option_25').val($('#selected_follow_up_CrCl_month').val()+'/'+$('#selected_follow_up_CrCl_day').val()+'/'+$('#selected_follow_up_CrCl_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_CrCl_day" id="selected_follow_up_CrCl_day" value="<?php print($follow_up_CrCl_day);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_CrCl_month_menu').toggle('fast');" id="active_follow_up_CrCl_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_CrCl_month);?></div>


<div class="option_menu" id="follow_up_CrCl_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_CrCl_month_menu').toggle('fast');$('#active_follow_up_CrCl_month').html($(this).html());$('#selected_follow_up_CrCl_month').val(<?php print($m);?>);$('#option_25').val($('#selected_follow_up_CrCl_month').val()+'/'+$('#selected_follow_up_CrCl_day').val()+'/'+$('#selected_follow_up_CrCl_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_CrCl_month_menu').toggle('fast');$('#active_follow_up_CrCl_month').html($(this).html());$('#selected_follow_up_CrCl_month').val(<?php print($m);?>);$('#option_25').val($('#selected_follow_up_CrCl_month').val()+'/'+$('#selected_follow_up_CrCl_day').val()+'/'+$('#selected_follow_up_CrCl_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_CrCl_month" id="selected_follow_up_CrCl_month" value="<?php print($follow_up_CrCl_month);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_CrCl_year_menu').toggle('fast');" id="active_follow_up_CrCl_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_CrCl_year);?></div>


<div class="option_menu" id="follow_up_CrCl_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_CrCl_year_menu').toggle('fast');$('#active_follow_up_CrCl_year').html($(this).html());$('#selected_follow_up_CrCl_year').val(<?php print($y);?>);$('#option_25').val($('#selected_follow_up_CrCl_month').val()+'/'+$('#selected_follow_up_CrCl_day').val()+'/'+$('#selected_follow_up_CrCl_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_follow_up_CrCl_year" id="selected_follow_up_CrCl_year" value="<?php print($follow_up_CrCl_year);?>">
</div>

</div>
</div>
<input type="hidden" id="option_25" value="<?php print($follow_up_CrCl_date);?>"> 
</div>

<?php
if($form_option_text[26] == ''){
	$hepatitis_b = '0';
	
}else{
	$hepatitis_b = $form_option_text[26];
	
}
?>

<div style="width:100%;line-height:30px;height:30px;float:left;">
<div style="width:30%;height:30px;float:left;"><div style="width:65px;height:30px;line-height:30px;float:left;">Hepatitis B</div>
<div style="width:50px;float:left;height:30px;line-height:30px;"><input type="text" style="width:90%;height:25px;border:solid 1px #aaa;" id="option_26_text" value="<?php print($hepatitis_b);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_26" value="1">

</div>
<div style="width:70%;height:30px;float:right;">
<div style="width:270px;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:30px;">Date:</div>
<div style="line-height:30px;width:15px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<?php
if($form_option_value[27] == ''){
	$follow_up_hepatitis_b_date = date('m/j/Y',time());
	
}else{
	$follow_up_hepatitis_b_date = $form_option_value[27];
	
}

$follow_up_hepatitis_b_date_array = explode('/',$follow_up_hepatitis_b_date);

$follow_up_hepatitis_b_day = $follow_up_hepatitis_b_date_array[1];
$follow_up_hepatitis_b_month = $follow_up_hepatitis_b_date_array[0];
$follow_up_hepatitis_b_year = $follow_up_hepatitis_b_date_array[2];
?>

<div class="option_item" title="Click to change option" onclick="$('#follow_up_hepatitis_b_day_menu').toggle('fast');" id="active_follow_up_hepatitis_b_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_hepatitis_b_day);?></div>

<div class="option_menu" id="follow_up_hepatitis_b_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hepatitis_b_day_menu').toggle('fast');$('#active_follow_up_hepatitis_b_day').html($(this).html());$('#selected_follow_up_hepatitis_b_day').val(<?php print($d);?>);$('#option_27').val($('#selected_follow_up_hepatitis_b_month').val()+'/'+$('#selected_follow_up_hepatitis_b_day').val()+'/'+$('#selected_follow_up_hepatitis_b_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hepatitis_b_day_menu').toggle('fast');$('#active_follow_up_hepatitis_b_day').html($(this).html());$('#selected_follow_up_hepatitis_b_day').val(<?php print($d);?>);$('#option_27').val($('#selected_follow_up_hepatitis_b_month').val()+'/'+$('#selected_follow_up_hepatitis_b_day').val()+'/'+$('#selected_follow_up_hepatitis_b_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_hepatitis_b_day" id="selected_follow_up_hepatitis_b_day" value="<?php print($follow_up_hepatitis_b_day);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_hepatitis_b_month_menu').toggle('fast');" id="active_follow_up_hepatitis_b_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_hepatitis_b_month);?></div>


<div class="option_menu" id="follow_up_hepatitis_b_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hepatitis_b_month_menu').toggle('fast');$('#active_follow_up_hepatitis_b_month').html($(this).html());$('#selected_follow_up_hepatitis_b_month').val(<?php print($m);?>);$('#option_27').val($('#selected_follow_up_hepatitis_b_month').val()+'/'+$('#selected_follow_up_hepatitis_b_day').val()+'/'+$('#selected_follow_up_hepatitis_b_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hepatitis_b_month_menu').toggle('fast');$('#active_follow_up_hepatitis_b_month').html($(this).html());$('#selected_follow_up_hepatitis_b_month').val(<?php print($m);?>);$('#option_27').val($('#selected_follow_up_hepatitis_b_month').val()+'/'+$('#selected_follow_up_hepatitis_b_day').val()+'/'+$('#selected_follow_up_hepatitis_b_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_hepatitis_b_month" id="selected_follow_up_hepatitis_b_month" value="<?php print($follow_up_hepatitis_b_month);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_hepatitis_b_year_menu').toggle('fast');" id="active_follow_up_hepatitis_b_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_hepatitis_b_year);?></div>


<div class="option_menu" id="follow_up_hepatitis_b_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_hepatitis_b_year_menu').toggle('fast');$('#active_follow_up_hepatitis_b_year').html($(this).html());$('#selected_follow_up_hepatitis_b_year').val(<?php print($y);?>);$('#option_27').val($('#selected_follow_up_hepatitis_b_month').val()+'/'+$('#selected_follow_up_hepatitis_b_day').val()+'/'+$('#selected_follow_up_hepatitis_b_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_follow_up_hepatitis_b_year" id="selected_follow_up_hepatitis_b_year" value="<?php print($follow_up_hepatitis_b_year);?>">
</div>

</div>
</div>
<input type="hidden" id="option_27" value="<?php print($follow_up_hepatitis_b_date);?>"> 
</div>

<?php
if($form_option_text[30] == ''){
	$rst = '0';
	
}else{
	$rst = $form_option_text[30];
	
}
?>

<div style="width:100%;line-height:30px;height:30px;float:left;">
<div style="width:30%;height:30px;float:left;"><div style="width:65px;height:30px;line-height:30px;float:left;">RST</div>
<div style="width:50px;float:left;height:30px;line-height:30px;"><input type="text" style="width:90%;height:25px;border:solid 1px #aaa;" id="option_30_text" value="<?php print($rst);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_30" value="1">

</div>
<div style="width:70%;height:30px;float:right;">
<div style="width:270px;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:30px;">Date:</div>
<div style="line-height:30px;width:15px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<?php
if($form_option_value[27] == ''){
	$follow_up_rst_date = date('m/j/Y',time());
	
}else{
	$follow_up_rst_date = $form_option_value[27];
	
}

$follow_up_rst_date_array = explode('/',$follow_up_rst_date);

$follow_up_rst_day = $follow_up_rst_date_array[1];
$follow_up_rst_month = $follow_up_rst_date_array[0];
$follow_up_rst_year = $follow_up_rst_date_array[2];
?>

<div class="option_item" title="Click to change option" onclick="$('#follow_up_rst_day_menu').toggle('fast');" id="active_follow_up_rst_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_rst_day);?></div>

<div class="option_menu" id="follow_up_rst_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_rst_day_menu').toggle('fast');$('#active_follow_up_rst_day').html($(this).html());$('#selected_follow_up_rst_day').val(<?php print($d);?>);$('#option_31').val($('#selected_follow_up_rst_month').val()+'/'+$('#selected_follow_up_rst_day').val()+'/'+$('#selected_follow_up_rst_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_rst_day_menu').toggle('fast');$('#active_follow_up_rst_day').html($(this).html());$('#selected_follow_up_rst_day').val(<?php print($d);?>);$('#option_31').val($('#selected_follow_up_rst_month').val()+'/'+$('#selected_follow_up_rst_day').val()+'/'+$('#selected_follow_up_rst_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_rst_day" id="selected_follow_up_rst_day" value="<?php print($follow_up_rst_day);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_rst_month_menu').toggle('fast');" id="active_follow_up_rst_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_rst_month);?></div>


<div class="option_menu" id="follow_up_rst_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_rst_month_menu').toggle('fast');$('#active_follow_up_rst_month').html($(this).html());$('#selected_follow_up_rst_month').val(<?php print($m);?>);$('#option_31').val($('#selected_follow_up_rst_month').val()+'/'+$('#selected_follow_up_rst_day').val()+'/'+$('#selected_follow_up_rst_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_rst_month_menu').toggle('fast');$('#active_follow_up_rst_month').html($(this).html());$('#selected_follow_up_rst_month').val(<?php print($m);?>);$('#option_31').val($('#selected_follow_up_rst_month').val()+'/'+$('#selected_follow_up_rst_day').val()+'/'+$('#selected_follow_up_rst_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_rst_month" id="selected_follow_up_rst_month" value="<?php print($follow_up_rst_month);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_rst_year_menu').toggle('fast');" id="active_follow_up_rst_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_rst_year);?></div>


<div class="option_menu" id="follow_up_rst_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_rst_year_menu').toggle('fast');$('#active_follow_up_rst_year').html($(this).html());$('#selected_follow_up_rst_year').val(<?php print($y);?>);$('#option_31').val($('#selected_follow_up_rst_month').val()+'/'+$('#selected_follow_up_rst_day').val()+'/'+$('#selected_follow_up_rst_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_follow_up_rst_year" id="selected_follow_up_rst_year" value="<?php print($follow_up_rst_year);?>">
</div>

</div>
</div>
<input type="hidden" id="option_31" value="<?php print($follow_up_rst_date);?>"> 
</div>

<?php
if($form_option_text[28] == ''){
	$ua = '0';
	
}else{
	$ua = $form_option_text[28];
	
}
?>

<div style="width:100%;line-height:30px;height:30px;float:left;">
<div style="width:30%;height:30px;float:left;"><div style="width:65px;height:30px;line-height:30px;float:left;">UA</div>
<div style="width:50px;float:left;height:30px;line-height:30px;"><input type="text" style="width:90%;height:25px;border:solid 1px #aaa;" id="option_28_text" value="<?php print($ua);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_28" value="1">

</div>
<div style="width:70%;height:30px;float:right;">
<div style="width:270px;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:30px;">Date:</div>
<div style="line-height:30px;width:15px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<?php
if($form_option_value[27] == ''){
	$follow_up_ua_date = date('m/j/Y',time());
	
}else{
	$follow_up_ua_date = $form_option_value[27];
	
}

$follow_up_ua_date_array = explode('/',$follow_up_ua_date);

$follow_up_ua_day = $follow_up_ua_date_array[1];
$follow_up_ua_month = $follow_up_ua_date_array[0];
$follow_up_ua_year = $follow_up_ua_date_array[2];
?>

<div class="option_item" title="Click to change option" onclick="$('#follow_up_ua_day_menu').toggle('fast');" id="active_follow_up_ua_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_ua_day);?></div>

<div class="option_menu" id="follow_up_ua_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_ua_day_menu').toggle('fast');$('#active_follow_up_ua_day').html($(this).html());$('#selected_follow_up_ua_day').val(<?php print($d);?>);$('#option_29').val($('#selected_follow_up_ua_month').val()+'/'+$('#selected_follow_up_ua_day').val()+'/'+$('#selected_follow_up_ua_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_ua_day_menu').toggle('fast');$('#active_follow_up_ua_day').html($(this).html());$('#selected_follow_up_ua_day').val(<?php print($d);?>);$('#option_29').val($('#selected_follow_up_ua_month').val()+'/'+$('#selected_follow_up_ua_day').val()+'/'+$('#selected_follow_up_ua_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_ua_day" id="selected_follow_up_ua_day" value="<?php print($follow_up_ua_day);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_ua_month_menu').toggle('fast');" id="active_follow_up_ua_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_ua_month);?></div>


<div class="option_menu" id="follow_up_ua_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_ua_month_menu').toggle('fast');$('#active_follow_up_ua_month').html($(this).html());$('#selected_follow_up_ua_month').val(<?php print($m);?>);$('#option_29').val($('#selected_follow_up_ua_month').val()+'/'+$('#selected_follow_up_ua_day').val()+'/'+$('#selected_follow_up_ua_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_ua_month_menu').toggle('fast');$('#active_follow_up_ua_month').html($(this).html());$('#selected_follow_up_ua_month').val(<?php print($m);?>);$('#option_29').val($('#selected_follow_up_ua_month').val()+'/'+$('#selected_follow_up_ua_day').val()+'/'+$('#selected_follow_up_ua_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_follow_up_ua_month" id="selected_follow_up_ua_month" value="<?php print($follow_up_ua_month);?>">
</div>

<div style="line-height:30px;width:15px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_ua_year_menu').toggle('fast');" id="active_follow_up_ua_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($follow_up_ua_year);?></div>


<div class="option_menu" id="follow_up_ua_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_ua_year_menu').toggle('fast');$('#active_follow_up_ua_year').html($(this).html());$('#selected_follow_up_ua_year').val(<?php print($y);?>);$('#option_29').val($('#selected_follow_up_ua_month').val()+'/'+$('#selected_follow_up_ua_day').val()+'/'+$('#selected_follow_up_ua_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_follow_up_ua_year" id="selected_follow_up_ua_year" value="<?php print($follow_up_ua_year);?>">
</div>

</div>
</div>
<input type="hidden" id="option_29" value="<?php print($follow_up_ua_date);?>"> 
</div>

<div style="width:100%;height:190px;border-top:solid 1px #000;float:left;">
<div style="width:220px;height:190px;float:left;border-right:solid 1px #000;padding:2px;font-size:0.9em;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;text-align:center;">OBSTETRIC HISTORY</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<div style="width:auto;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;">LMP:</div>
<div style="line-height:30px;width:10px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<?php
if($form_option_value[32] == ''){
	$lmp_date = '';
	$lmp_day = date('j',time());;
	$lmp_month = date('m',time());
	$lmp_year = date('Y',time());
	
	$lmp_day_title = 'N/A';
	$lmp_month_title = 'N/A';
	$lmp_year_title = 'N/A';
	
}else{
	$lmp_date = $form_option_value[32];
	
	$lmp_date_array = explode('/',$lmp_date);
	$lmp_day = $lmp_date_array[1];
	$lmp_month = $lmp_date_array[0];
	$lmp_year = $lmp_date_array[2];
	
	$lmp_day_title = $lmp_day;
	$lmp_month_title = $lmp_month;
	$lmp_year_title = $lmp_year;
}
?>


<div class="option_item" title="Click to change option" onclick="$('#follow_up_lmp_day_menu').toggle('fast');" id="active_lmp_follow_up_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($lmp_day_title);?></div>

<div class="option_menu" id="follow_up_lmp_day_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_day_menu').toggle('fast');$('#active_lmp_follow_up_day').html($(this).html());$('#active_lmp_follow_up_month').html('N/A');$('#active_lmp_follow_up_year').html('N/A');$('#option_32').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_day_menu').toggle('fast');$('#active_lmp_follow_up_day').html($(this).html());$('#selected_lmp_follow_up_day').val(<?php print($d);?>);$('#active_lmp_follow_up_month').html($('#selected_lmp_follow_up_month').val());$('#active_lmp_follow_up_year').html($('#selected_lmp_follow_up_year').val());$('#option_32').val($('#selected_lmp_follow_up_month').val()+'/'+$('#selected_lmp_follow_up_day').val()+'/'+$('#selected_lmp_follow_up_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_day_menu').toggle('fast');$('#active_lmp_follow_up_day').html($(this).html());$('#selected_lmp_follow_up_day').val(<?php print($d);?>);$('#active_lmp_follow_up_month').html($('#selected_lmp_follow_up_month').val());$('#active_lmp_follow_up_year').html($('#selected_lmp_follow_up_year').val());$('#option_32').val($('#selected_lmp_follow_up_month').val()+'/'+$('#selected_lmp_follow_up_day').val()+'/'+$('#selected_lmp_follow_up_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_lmp_follow_up_day" id="selected_lmp_follow_up_day" value="<?php print($lmp_day);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_lmp_month_menu').toggle('fast');" id="active_lmp_follow_up_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($lmp_month_title);?></div>


<div class="option_menu" id="follow_up_lmp_month_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_month_menu').toggle('fast');$('#active_lmp_follow_up_day').html($(this).html());$('#active_lmp_follow_up_month').html('N/A');$('#active_lmp_follow_up_year').html('N/A');$('#option_32').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_month_menu').toggle('fast');$('#active_lmp_follow_up_month').html($(this).html());$('#selected_lmp_follow_up_month').val(<?php print($m);?>);$('#active_lmp_follow_up_day').html($('#selected_lmp_follow_up_day').val());$('#active_lmp_follow_up_year').html($('#selected_lmp_follow_up_year').val());$('#option_32').val($('#selected_lmp_follow_up_month').val()+'/'+$('#selected_lmp_follow_up_day').val()+'/'+$('#selected_lmp_follow_up_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_month_menu').toggle('fast');$('#active_lmp_follow_up_month').html($(this).html());$('#selected_lmp_follow_up_month').val(<?php print($m);?>);$('#active_lmp_follow_up_day').html($('#selected_lmp_follow_up_day').val());$('#active_lmp_follow_up_year').html($('#selected_lmp_follow_up_year').val());$('#option_32').val($('#selected_lmp_follow_up_month').val()+'/'+$('#selected_lmp_follow_up_day').val()+'/'+$('#selected_lmp_follow_up_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_lmp_follow_up_month" value="<?php print($lmp_month);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_lmp_year_menu').toggle('fast');" id="active_lmp_follow_up_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($lmp_year_title);?></div>


<div class="option_menu" id="follow_up_lmp_year_menu" style="display:none;width:65px;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_year_menu').toggle('fast');$('#active_lmp_follow_up_day').html($(this).html());$('#active_lmp_follow_up_month').html('N/A');$('#active_lmp_follow_up_year').html('N/A');$('#option_32').val('');" style="width:40px;">N/A</div>
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_lmp_year_menu').toggle('fast');$('#active_lmp_follow_up_year').html($(this).html());$('#selected_lmp_follow_up_year').val(<?php print($y);?>);$('#active_lmp_follow_up_day').html($('#selected_lmp_follow_up_day').val());$('#active_lmp_follow_up_month').html($('#selected_lmp_follow_up_month').val());$('#option_32').val($('#selected_lmp_follow_up_month').val()+'/'+$('#selected_lmp_follow_up_day').val()+'/'+$('#selected_lmp_follow_up_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_lmp_follow_up_year" id="selected_lmp_follow_up_year" value="<?php print($lmp_year);?>">
</div>
<input type="hidden" id="option_32" value="<?php print($lmp_date);?>">
</div>
</div>


<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:auto;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;">EDD:</div>
<div style="line-height:30px;width:10px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">
<?php
if($form_option_value[33] == ''){
	$edd_date = '';
	$edd_day = 'N/A';
	$edd_month = 'N/A';
	$edd_year = 'N/A';
	
	$select_edd_day = date('j',time());
	$select_edd_month = date('m',time());
	$select_edd_year = date('Y',time());
	
}else{
	$edd_date = $form_option_value[33];
	
	$edd_date_array = explode('/',$edd_date);
	$edd_day = $edd_date_array[1];
	$edd_month = $edd_date_array[0];
	$edd_year = $edd_date_array[2];
	
	$select_edd_day = $edd_day;
	$select_edd_month = $edd_month;
	$select_edd_year = $edd_year;
}
?>
<div class="option_item" title="Click to change option" onclick="$('#follow_up_edd_day_menu').toggle('fast');" id="active_edd_follow_up_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($edd_day);?></div>

<div class="option_menu" id="follow_up_edd_day_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_day_menu').toggle('fast');$('#active_edd_follow_up_day').html($(this).html());$('#active_edd_follow_up_month').html($(this).html());$('#active_edd_follow_up_year').html($(this).html());$('#option_33').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_day_menu').toggle('fast');$('#active_edd_follow_up_day').html($(this).html());$('#selected_edd_follow_up_day').val(<?php print($d);?>);$('#active_edd_follow_up_month').html($('#selected_edd_follow_up_month').val());$('#active_edd_follow_up_year').html($('#selected_edd_follow_up_year').val());$('#option_33').val($('#selected_edd_follow_up_month').val()+'/'+$('#selected_edd_follow_up_day').val()+'/'+$('#selected_edd_follow_up_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_day_menu').toggle('fast');$('#active_edd_follow_up_day').html($(this).html());$('#selected_edd_follow_up_day').val(<?php print($d);?>);$('#active_edd_follow_up_month').html($('#selected_edd_follow_up_month').val());$('#active_edd_follow_up_year').html($('#selected_edd_follow_up_year').val());$('#option_33').val($('#selected_edd_follow_up_month').val()+'/'+$('#selected_edd_follow_up_day').val()+'/'+$('#selected_edd_follow_up_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_edd_follow_up_day" id="selected_edd_follow_up_day" value="<?php print($select_edd_month);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_edd_month_menu').toggle('fast');" id="active_edd_follow_up_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($edd_month);?></div>


<div class="option_menu" id="follow_up_edd_month_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_month_menu').toggle('fast');$('#active_edd_follow_up_day').html($(this).html());$('#active_edd_follow_up_month').html($(this).html());$('#active_edd_follow_up_year').html($(this).html());$('#option_33').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_month_menu').toggle('fast');$('#active_edd_follow_up_month').html($(this).html());$('#selected_edd_follow_up_month').val(<?php print($m);?>);$('#active_edd_follow_up_day').html($('#selected_edd_follow_up_day').val());$('#active_edd_follow_up_year').html($('#selected_edd_follow_up_year').val());$('#option_33').val($('#selected_edd_follow_up_month').val()+'/'+$('#selected_edd_follow_up_day').val()+'/'+$('#selected_edd_follow_up_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_month_menu').toggle('fast');$('#active_edd_follow_up_month').html($(this).html());$('#selected_edd_follow_up_month').val(<?php print($m);?>);$('#active_edd_follow_up_day').html($('#selected_edd_follow_up_day').val());$('#active_edd_follow_up_year').html($('#selected_edd_follow_up_year').val());$('#option_33').val($('#selected_edd_follow_up_month').val()+'/'+$('#selected_edd_follow_up_day').val()+'/'+$('#selected_edd_follow_up_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_edd_follow_up_month" value="<?php print($select_edd_month);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_edd_year_menu').toggle('fast');" id="active_edd_follow_up_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($edd_year);?></div>


<div class="option_menu" id="follow_up_edd_year_menu" style="display:none;width:65px;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_year_menu').toggle('fast');$('#active_edd_follow_up_day').html($(this).html());$('#active_edd_follow_up_month').html($(this).html());$('#active_edd_follow_up_year').html($(this).html());$('#option_33').val('');" style="width:40px;">N/A</div>
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_edd_year_menu').toggle('fast');$('#active_edd_follow_up_year').html($(this).html());$('#selected_edd_follow_up_year').val(<?php print($y);?>);$('#active_edd_follow_up_day').html($('#selected_edd_follow_up_day').val());$('#active_edd_follow_up_month').html($('#selected_edd_follow_up_month').val());$('#option_33').val($('#selected_edd_follow_up_month').val()+'/'+$('#selected_edd_follow_up_day').val()+'/'+$('#selected_edd_follow_up_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_edd_follow_up_year" id="selected_edd_follow_up_year" value="<?php print($select_edd_year);?>">
</div>
<input type="hidden" id="option_33" value="<?php print($edd_date);?>">
</div></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Are you breastfeeding?</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[34]);?> type="radio" name="breastfeeding" id="breastfeeding_yes" onclick="$('#option_34').val(1);"><label for="breastfeeding_yes" >Yes</label> <input type="radio" name="breastfeeding" id="breastfeeding_no" <?php if(!$form_option_value[34]){print(' checked ');}?> onclick="$('#option_34').val('');"><label for="breastfeeding_no">No</label></div><input type="hidden" id="option_34" value="<?php print($form_option_value[34]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Is child HIV+?</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[36]);?> type="radio" name="child_positive" id="child_positive_yes" onclick="$('#option_36').val(1);"><label for="child_positive_yes" >Yes</label> <input type="radio" name="child_positive" id="child_positive_no" <?php if(!$form_option_value[36]){print(' checked ');}?> onclick="$('#option_36').val('');"><label for="child_positive_no">No</label></div><input type="hidden" id="option_36" value="<?php print($form_option_value[36]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Client screen for CACX?</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[38]);?> type="radio" name="cacx_screen" id="cacx_screen_yes" onclick="$('#option_38').val(1);"><label for="cacx_screen_yes" >Yes</label> <input type="radio" name="cacx_screen" id="cacx_screen_no" <?php if(!$form_option_value[38]){print(' checked ');}?> onclick="$('#option_38').val('');"><label for="cacx_screen_no">No</label></div><input type="hidden" id="option_38" value="<?php print($form_option_value[36]);?>"></div>

</div>


<div style="width:200px;height:190px;float:left;padding:2px;font-size:0.9em;">
	<div style="width:100%;height:20px;line-height:20px;font-weight:bold;text-align:center;">PREVENTION</div>

	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:55%;min-height:20px;height:auto;float:left;">Client counseled on condoms?</div><div style="width:45%;height:20px;float:right;"><input onclick="$('#option_40').val(1);" <?php print($form_option_checked[40]);?> type="radio" id="counselled_on_condoms_yes" name="counselled_on_condoms"><label for="counselled_on_condoms_yes">Yes </label><input onclick="$('#option_40').val('');" <?php if(!$form_option_value[40]){print(' checked ');}?>  type="radio" name="counselled_on_condoms" id="counselled_on_condoms_no"><label for="counselled_on_condoms_no">No</label></div><input type="hidden" id="option_40" value="<?php print($form_option_value[40]);?>"></div>

	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:55%;min-height:20px;height:auto;float:left;">Family planning</div><div style="width:45%;height:20px;float:right;"><input onclick="$('#option_41').val(1);" <?php print($form_option_checked[41]);?> type="radio" id="family_planning_yes" name="family_planning"><label for="family_planning_yes">Yes </label><input onclick="$('#option_41').val('');" <?php if(!$form_option_value[41]){print(' checked ');}?>  type="radio" name="family_planning" id="family_planning_no"><label for="family_planning_no">No</label></div><input type="hidden" id="option_41" value="<?php print($form_option_value[41]);?>"></div>

	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:55%;min-height:20px;height:auto;float:left;">Condoms given</div><div style="width:45%;height:20px;float:right;"><input onclick="$('#option_42').val(1);" <?php print($form_option_checked[42]);?> type="radio" id="condoms_given_yes" name="condoms_given"><label for="condoms_given_yes">Yes</label> <input onclick="$('#option_42').val('');" <?php if(!$form_option_value[42]){print(' checked ');}?>  type="radio" name="condoms_given" id="condoms_given_no"><label for="condoms_given_no">No</label></div><input type="hidden" id="option_42" value="<?php print($form_option_value[42]);?>"></div>
</div></div></div>

<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:100px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;">PHYSICAL EXAM</div>
<div style="width:auto;float:left;min-height:25px;height:auto;margin-left:5px;">
<div style="width:60px;height:30px;float:left;line-height:30px;" id="option_47_title">Weight(kg):</div>
<?php

if($form_option_text[47] == ''){
	$form_option_text[47] = '000.0';
}

$weight_array = str_split($form_option_text[47]);
?>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" onchange="$('#option_47_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" id="weight_0" value="<?php print($weight_array[0]);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="weight_1" onchange="$('#option_47_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" value="<?php if(isset($weight_array[1])){print($weight_array[1]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="weight_2" onchange="$('#option_47_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" value="<?php if(isset($weight_array[2])){print($weight_array[2]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<div style="width:5px;height:30px;float:left;margin-left:5px;line-height:30px;text-align:center;font-weight:bold;">.</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="weight_3" onchange="$('#option_47_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" value="<?php if(isset($weight_array[4])){print($weight_array[4]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_47" value="1"> 
<input type="hidden" id="option_47_text" value="<?php print($form_option_text[47]);?>"> 

<?php
if($form_option_text[45] == ''){
	$form_option_text[45] = '000/000';

}
$bp_array = str_split($form_option_text[45]);
?>
<div style="width:30px;height:30px;float:left;line-height:30px;text-align:right;" id="option_45_title">BP:</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:25px;border:solid 1px #aaa;" id="bp_1" onchange="$('#option_45_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[0])){print($bp_array[0]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:25px;border:solid 1px #aaa;" id="bp_2" onchange="$('#option_45_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[1])){print($bp_array[1]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_3" onchange="$('#option_45_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[2])){print($bp_array[2]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<div style="width:5px;height:25px;float:left;margin-left:5px;line-height:30px;text-align:center;font-weight:bold;">/</div>
<div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_4" onchange="$('#option_45_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[4])){print($bp_array[4]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div><div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_5" onchange="$('#option_45_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[5])){print($bp_array[5]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div><div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_6" onchange="$('#option_45_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[6])){print($bp_array[6]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_45" value="1"> 
<input type="hidden" id="option_45_text" value="<?php print($form_option_text[45]);?>"> 
<?php

if($form_option_text[43] == ''){
	$form_option_text[43] = '00.0';

}

$temp_array = str_split($form_option_text[43]);
?>
<div style="width:60px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;" id="option_43_title">Temp. &#176; C:</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="temp_1" onchange="$('#option_43_text').val($('#temp_1').val()+''+$('#temp_2').val()+'.'+$('#temp_3').val())" value="<?php if(isset($temp_array[0])){print($temp_array[0]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="temp_2" onchange="$('#option_43_text').val($('#temp_1').val()+''+$('#temp_2').val()+'.'+$('#temp_3').val())" value="<?php if(isset($temp_array[1])){print($temp_array[1]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<div style="width:5px;height:30px;float:left;margin-left:5px;line-height:30px;text-align:center;font-weight:bold;">.</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="temp_3" onchange="$('#option_43_text').val($('#temp_1').val()+''+$('#temp_2').val()+'.'+$('#temp_3').val())" value="<?php if(isset($temp_array[3])){print($temp_array[3]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<input type="hidden" id="option_43" value="1"> 
<input type="hidden" id="option_43_text" value="<?php print($form_option_text[43]);?>"> 

<?php
if($form_option_text[300] == ''){
	$bmi = 0;
	
}else{
	$bmi = $form_option_text[300];
}
?>
<div style="width:30px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;" id="option_300_title">BMI:</div>
<div style="width:90px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;"><input type="text" style="width:100%;height:25px;margin-top:2px;border:solid 1px #aaa;" id="option_300_text" value="<?php print($bmi);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_300" value="1">
</div>

<div style="width:100%;float:left;min-height:25px;height:auto;margin-left:5px;">
<div style="width:90px;height:30px;float:left;line-height:30px;" id="option_158_title">Heart rate/min:</div>

<?php
if($form_option_text[46] == ''){
	$form_option_text[46] = '000';

}
$heart_array = str_split($form_option_text[46]);
?>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($heart_array[0])){print($heart_array[0]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="heart_rate_1" onchange="$('#option_46_text').val($('#heart_rate_1').val()+''+$('#heart_rate_2').val()+''+$('#heart_rate_3').val())"onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($heart_array[1])){print($heart_array[1]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="heart_rate_2" onchange="$('#option_46_text').val($('#heart_rate_1').val()+''+$('#heart_rate_2').val()+''+$('#heart_rate_3').val())"onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($heart_array[2])){ print($heart_array[2]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="heart_rate_3" onchange="$('#option_46_text').val($('#heart_rate_1').val()+''+$('#heart_rate_2').val()+''+$('#heart_rate_3').val())"onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_46" value="1">
<input type="hidden" id="option_46_text" value="<?php print($form_option_text[46]);?>">


<div style="width:80px;height:30px;float:left;line-height:30px;text-align:right;" id="option_44_title">Resp. Rate:</div>
<?php
if($form_option_text[44] == ''){
	$form_option_text[44] = '00';

}
$resp_array = str_split($form_option_text[44]);
?>
<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($resp_array[0])){print($resp_array[0]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="resp_rate_1" onchange="$('#option_44_text').val($('#resp_rate_1').val()+''+$('#resp_rate_2').val())" onchange="$('#option_159_text').val($('#resp_rate_1').val()+''+$('#resp_rate_2').val())" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($resp_array[1])){print($resp_array [1]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="resp_rate_2" onchange="$('#option_44_text').val($('#resp_rate_1').val()+''+$('#resp_rate_2').val())" onchange="$('#option_159_text').val($('#resp_rate_1').val()+''+$('#resp_rate_2').val())" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_44" value="1">
<input type="hidden" id="option_44_text" value="<?php print($form_option_text[44]);?>">

<div style="width:60px;height:30px;float:left;line-height:30px;text-align:right;">General:</div>
<div style="width:auto;height:30px;float:left;margin-left:5px;line-height:30px;">
<input <?php print($form_option_checked[48]);?> type="checkbox" id="field_48" onclick="if(this.checked){$('#option_48').val(1);}else{$('#option_48').val('');}"><label for="field_48">Pallor</label>
<input type="hidden" id="option_48" value="<?php print($form_option_value[48]);?>">

<input <?php print($form_option_checked[49]);?> type="checkbox" id="field_49" onclick="if(this.checked){$('#option_49').val(1);}else{$('#option_49').val('');}"><label for="field_49">Jaundice</label>
<input type="hidden" id="option_49" value="<?php print($form_option_value[49]);?>">

<input <?php print($form_option_checked[50]);?> type="checkbox" id="field_50" onclick="if(this.checked){$('#option_50').val(1);}else{$('#option_162').val('');}"><label for="field_50">Edema</label>
<input type="hidden" id="option_50" value="<?php print($form_option_value[50]);?>">

</div>

<?php
if($form_option_text[301] == ''){
	$nortable_findings = 0;
	
}else{
	$nortable_findings = $form_option_text[301];
}
?>

<div style="width:140px;height:30px;float:right;line-height:30px;margin-left:5px;text-align:right;margin-right:9px;"><input  type="text" style="width:100%;height:25px;border:solid 1px #aaa;" id="option_301_text" value="<?php print($nortable_findings);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<input type="hidden" id="option_301" value="1">
<div style="width:100px;height:30px;float:right;line-height:30px;text-align:right;">Notable findings:</div>
</div>

<?php
if($form_option_text[302] == ''){
	$genital_exam = 0;
	
}else{
	$genital_exam = $form_option_text[302];
}
?>
<div style="width:280px;float:right;min-height:25px;height:auto;">
<div style="width:132px;height:30px;float:left;line-height:30px;text-align:right;">Genital Exam:</div>
<div style="width:140px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;"><input type="text" style="width:100%;height:25px;border:solid 1px #aaa;" id="option_302_text" value="<?php print($genital_exam);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}">
<input type="hidden" id="option_302" value="1">
</div>
</div>
</div>



<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:262px;height:140px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;text-align:left;">RISK STATUS</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Client wants to continue PrEP <input type="radio" name="wants_to_continue_prep" id="wants_to_continue_prep_yes" <?php print($form_option_checked[378]);?> onclick="$('#option_378').val(1);"><label for="wants_to_continue_prep_yes">Yes</label><input type="radio" name="wants_to_continue_prep" id="wants_to_continue_prep_no" <?php if(!$form_option_value[378]){print(' checked ');}?> onclick="$('#option_378').val('');"><label for="wants_to_continue_prep_no">No</label></div>

<input type="hidden" id="option_378" value="<?php print($form_option_value[378]);?>">


<div style="width:100%;height:20px;line-height:20px;font-weight:bold;float:left;margin-top:5px;">Reason for not starting</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox"  <?php print($form_option_checked[304]);?> onclick="if(this.checked){$('#option_304').val(1);}else{$('#option_304').val('');}" id="option_304_input"><label for="option_304_input">Partner on ART VL suppressed</label></div>

<input type="hidden" id="option_304" value="<?php print($form_option_value[304]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[379]);?> onclick="if(this.checked){$('#option_379').val(1);}else{$('#option_379').val('');}" id="option_379_input"><label for="option_379_input">No longer involved in unsafe practices</label></div>
<input type="hidden" id="option_379" value="<?php print($form_option_value[379]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[305]);?> onclick="if(this.checked){$('#option_305').val(1);}else{$('#option_305').val('');}" id="option_305_input"><label for="option_305_input">Client has one consistent partner</label></div>
<input type="hidden" id="option_305" value="<?php print($form_option_value[305]);?>">
</div>

<div style="width:430px;height:140px;float:left;padding:2px;">
<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;text-align:left;">SCREENING FOR SIDE EFFECTS OF TDF/FTC</div>
<div style="width:auto;height:auto;float:left;">

<div style="width:180px;float:left;height:auto;">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:40%;min-height:20px;height:auto;float:left;">Headache</div><div style="width:60%;height:20px;float:right;"><input <?php print($form_option_checked[51]);?> type="radio" id="field_51_yes" onclick="$('#option_51').val(1);" name="option_51_field"><label for="field_51_yes">Yes </label><input type="radio" onclick="$('#option_51').val('');" name="option_51_field" id="field_51_no" <?php if(!$form_option_value[51]){print(' checked ');};?>><label for="field_51_no">No</label></div>
<input type="hidden" id="option_51" value="<?php print($form_option_value[51]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:40%;min-height:20px;height:auto;float:left;">Oliguria</div><div style="width:60%;height:20px;float:right;"><input <?php print($form_option_checked[54]);?> type="radio" id="field_54_yes" onclick="$('#option_54').val(1);" name="option_54_field"><label for="field_54_yes">Yes </label><input type="radio" onclick="$('#option_54').val('');" name="option_54_field" id="field_54_no" <?php if(!$form_option_value[54]){print(' checked ');};?>><label for="field_54_no">No</label></div>
<input type="hidden" id="option_54" value="<?php print($form_option_value[54]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:40%;min-height:20px;height:auto;float:left;">Nausea</div><div style="width:60%;height:20px;float:right;"><input <?php print($form_option_checked[52]);?> type="radio" id="field_52_yes" onclick="$('#option_52').val(1);" name="option_52_field"><label for="field_52_yes">Yes </label><input type="radio" onclick="$('#option_52').val('');" name="option_52_field" id="field_52_no" <?php if(!$form_option_value[52]){print(' checked ');};?>><label for="field_52_no">No</label></div>
<input type="hidden" id="option_52" value="<?php print($form_option_value[52]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:40%;min-height:20px;height:auto;float:left;">Rash</div><div style="width:60%;height:20px;float:right;"><input <?php print($form_option_checked[53]);?> type="radio" id="field_53_yes" onclick="$('#option_53').val(1);" name="option_53_field"><label for="field_53_yes">Yes </label><input type="radio" onclick="$('#option_53').val('');" name="option_53_field" id="field_53_no" <?php if(!$form_option_value[53]){print(' checked ');};?>><label for="field_53_no">No</label></div>
<input type="hidden" id="option_53" value="<?php print($form_option_value[53]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:40%;min-height:20px;height:auto;float:left;">Vomiting</div><div style="width:60%;height:20px;float:right;"><input <?php print($form_option_checked[55]);?> type="radio" id="field_55_yes" onclick="$('#option_55').val(1);" name="option_55_field"><label for="field_55_yes">Yes </label><input type="radio" onclick="$('#option_55').val('');" name="option_55_field" id="field_55_no" <?php if(!$form_option_value[55]){print(' checked ');};?>><label for="field_55_no">No</label></div>
<input type="hidden" id="option_55" value="<?php print($form_option_value[55]);?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:40%;min-height:20px;height:auto;float:left;">Numbness</div><div style="width:60%;height:20px;float:right;"><input <?php print($form_option_checked[56]);?> type="radio" id="field_56_yes" onclick="$('#option_56').val(1);" name="option_56_field"><label for="field_56_yes">Yes </label><input type="radio" onclick="$('#option_56').val('');" name="option_56_field" id="field_56_no" <?php if(!$form_option_value[56]){print(' checked ');};?>><label for="field_56_no">No</label></div>
<input type="hidden" id="option_56" value="<?php print($form_option_value[56]);?>"></div>

</div>

<div style="width:200px;float:left;height:auto;"><div style="width:50px;height:25px;line-height:25px;float:left;">Other</div><div style="width:150px;height:25px;float:left;"><input value="<?php print($form_option_text[332]);?>" type="text" style="width:100%;height:25px;" id="option_332_text" onfocusout="if(this.value!=''){$('#option_332').val(1);$('#option_315').val(1);}else{$('#option_332').val('');$('#option_315').val('');}"></div></div>
<input type="hidden" id="option_332" value="<?php print($form_option_value[332]);?>">
<input type="hidden" id="option_315" value="<?php print($form_option_value[315]);?>">
</div>
</div>
</div>

<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:100%;height:140px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;text-align:left;">ADHEARANCE</div>

<div style="width:60%;height:auto;float:left;">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Problems taking medications</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Does client have trouble taking pills <input type="radio" name="missed_pills" id="field_57" onclick="$('#option_57').val(1);$('#option_58').val('');$('#option_59').val('');$('#option_60').val('');" <?php print($form_option_checked[57]);?>><label for="field_57">Never</label><input type="radio" name="missed_pills" id="field_58" onclick="$('#option_57').val('');$('#option_58').val(1);$('#option_59').val('');$('#option_60').val('');" <?php print($form_option_checked[58]);?>><label for="field_58">Rare</label><input type="radio" name="missed_pills" id="field_59" onclick="$('#option_57').val('');$('#option_58').val('');$('#option_59').val(1);$('#option_60').val('');" <?php print($form_option_checked[59]);?>><label for="field_59">Sometimes</label><input type="radio" name="missed_pills" id="field_60" onclick="$('#option_57').val('');$('#option_58').val('');$('#option_59').val('');$('#option_60').val(1);" <?php print($form_option_checked[60]);?>><label for="field_60">Often</label></div>

<input type="hidden" id="option_57" value="<?php print($form_option_value[57]);?>">
<input type="hidden" id="option_58" value="<?php print($form_option_value[58]);?>">
<input type="hidden" id="option_59" value="<?php print($form_option_value[59]);?>">
<input type="hidden" id="option_60" value="<?php print($form_option_value[60]);?>">

<div style="width:100%;height:20px;line-height:20px;float:left;margin-top:5px;">Reason for missing </div>

<div style="width:390px;min-height:20px;height:auto;line-height:20px;float:left;">
<div style="width:130px;height:20px;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[103]);?> onclick="if(this.checked){$('#option_103').val(1);}else{$('#option_103').val('');}" id="field_103"><label for="field_103">Forgot</label></div><div style="width:130px;height:20px;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[104]);?> onclick="if(this.checked){$('#option_104').val(1);}else{$('#option_104').val('');}" id="field_104"><label for="field_104">Side effects</label></div><div style="width:130px;height:20px;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[105]);?> onclick="if(this.checked){$('#option_105').val(1);}else{$('#option_105').val('');}" id="field_105"><label for="field_105">Away from home</label></div>
</div>

<input type="hidden" id="option_103" value="<?php print($form_option_value[103]);?>">
<input type="hidden" id="option_104" value="<?php print($form_option_value[104]);?>">
<input type="hidden" id="option_105" value="<?php print($form_option_value[105]);?>">


<div style="width:390px;min-height:20px;height:auto;line-height:20px;float:left;">
<div style="width:130px;height:20px;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[311]);?> onclick="if(this.checked){$('#option_311').val(1);}else{$('#option_311').val('');}" id="field_311"><label for="field_311">Illness</label></div><div style="width:130px;height:20px;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[312]);?> onclick="if(this.checked){$('#option_312').val(1);}else{$('#option_312').val('');}" id="field_312"><label for="field_312">Others</label></div><div style="width:130px;height:20px;line-height:20px;float:left;"><input type="checkbox" <?php print($form_option_checked[313]);?> onclick="if(this.checked){$('#option_313').val(1);}else{$('#option_313').val('');}" id="field_313"><label for="field_313">Meds finished</label></div>
</div>

<input type="hidden" id="option_311" value="<?php print($form_option_value[103]);?>">
<input type="hidden" id="option_312" value="<?php print($form_option_value[104]);?>">
<input type="hidden" id="option_313" value="<?php print($form_option_value[105]);?>">
</div>

<div style="width:40%;height:auto;float:right;">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">How many doses missed since last pick up?</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" id="field_106" name="doses_missed" <?php print($form_option_checked[106]);?> onclick="$('#option_106').val(1);$('#option_107').val('');$('#option_108').val('');"><label for="field_106">0 -> Follow regular pharmacy</label></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" id="field_107" name="doses_missed" <?php print($form_option_checked[107]);?> onclick="$('#option_106').val('');$('#option_107').val(1);$('#option_108').val('');"><label for="field_107">1 -> Monthly Pharmacy Schedule</label></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" id="field_108" name="doses_missed" <?php print($form_option_checked[108]);?> onclick="$('#option_106').val('');$('#option_107').val('');$('#option_108').val(1);"><label for="field_108">&#x2265; 2 -> Follow 4 wks weekly Appointment</label></div>
</div>

<input type="hidden" id="option_106" value="<?php print($form_option_value[106]);?>">
<input type="hidden" id="option_107" value="<?php print($form_option_value[107]);?>">
<input type="hidden" id="option_108" value="<?php print($form_option_value[108]);?>">

</div></div>



<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:100%;height:150px;float:left;border-right:solid 1px #000;padding:2px;">

<?php
$assessments = explode(']',$form_option_text[64]);
?>

<div style="width:20%;height:130px;float:left;border-right:solid 1px #000;">
<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;text-align:left;">ASSESSMENT</div>
<div style="width:100%;min-height:25px;height:auto;line-height:20px;float:left;"><input type="text" style="width:97%;height:20px;" id="assessment_0" onchange="add_assessment();" value="<?php if(isset($assessments[0])){print($assessments[0]);}?>"></div>

<div style="width:100%;min-height:25px;height:auto;line-height:20px;float:left;"><input type="text" style="width:97%;height:20px;" id="assessment_1" onchange="add_assessment();" value="<?php if(isset($assessments[1])){print($assessments[1]);}?>"></div>

<div style="width:100%;min-height:25px;height:auto;line-height:20px;float:left;"><input type="text" style="width:97%;height:20px;" id="assessment_2" onchange="add_assessment();" value="<?php if(isset($assessments[2])){print($assessments[2]);}?>"></div>

<div style="width:100%;min-height:25px;height:auto;line-height:20px;float:left;"><input type="text" style="width:97%;height:20px;" id="assessment_3" onchange="add_assessment();" value="<?php if(isset($assessments[3])){print($assessments[3]);}?>"></div>
<input type="hidden" id="option_64" value="<?php print($form_option_value[64]);?>">
<input type="hidden" id="option_64_text" value="<?php print($form_option_text[64]);?>">
<script>
function add_assessment(){
	$('#option_64_text').val($('#assessment_0').val()+']'+$('#assessment_1').val()+']'+$('#assessment_2').val()+']'+$('#assessment_3').val());
	
	if($('#assessment_0').val() == '' && $('#assessment_1').val() == '' && $('#assessment_2').val() == '' && $('#assessment_3').val() == ''){
		
		$('#option_64').val('');
	}else{
		$('#option_64').val(1);
	}
}

</script>

</div>

<div style="width:280px;height:150px;float:left;margin-left:5px;border-right:solid 1px #000;">
<div style="float:left;width:auto%;height:20px;line-height:20px;font-weight:bold;text-align:left;">PLAN</div>

<div style="width:auto;min-height:20px;height:auto;line-height:20px;float:left;margin-left:20px;"><input type="radio" id="field_66" onclick="$('#option_66').val(1);$('#option_67').val('');stopping_reason(0);" name="plan" <?php print($form_option_checked[66]);?>><label for="field_66">Continue PrEP</label><input type="radio" id="field_67" onclick="$('#option_67').val(1);$('#option_66').val('');" name="plan" <?php print($form_option_checked[67]);?>><label for="field_67">Stop PrEP</label></div>
<input type="hidden" id="option_66" value="<?php print($form_option_value[66]);?>">

<input type="hidden" id="option_67" value="<?php print($form_option_value[67]);?>">

<div style="float:left;width:100%;height:20px;line-height:20px;text-align:left;">Reasons for stopping</div>



<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" id="field_69" name="stopping_reason" onclick="stopping_reason(69)" <?php print($form_option_checked[69]);?>><label for="field_69">No longer at risk</label><input type="radio" id="field_70" name="stopping_reason" onclick="stopping_reason(70)" <?php print($form_option_checked[70]);?>><label for="field_70">Poor adherence</label></div>
<input type="hidden" id="option_69" value="<?php print($form_option_value[69]);?>">
<input type="hidden" id="option_70" value="<?php print($form_option_value[70]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" id="field_303" name="stopping_reason" onclick="stopping_reason(303)" <?php print($form_option_checked[303]);?>><label for="field_303">Contraindication to PrEP</label><input type="text" style="width:120px;height:20px;float:left;margin-left:5px;float:right;" id="option_303_text" <?php if(!$form_option_value[303]){print(' disabled ');}?> value="<?php print($form_option_text[303]);?>"></div>

<input type="hidden" id="option_303" value="<?php print($form_option_value[303]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" id="field_68" name="stopping_reason" onclick="var c = confirm('Are you sure this client has become HIV positive within the period they have been on PrEP?'); if(c){stopping_reason(68)}else{$('#field_66').click();}" <?php print($form_option_checked[68]);?>><label for="field_68">Sero conversion to +ve</label></div>
<input type="hidden" id="option_68" value="<?php print($form_option_value[68]);?>">


<script>

function stopping_reason(reason_id){
	$('#option_68').val('');
	$('#option_69').val('');
	$('#option_70').val('');
	$('#option_303').val('');
	
	
	
	if(reason_id == 0){
		document.getElementById('field_68').checked = false;
		document.getElementById('field_69').checked = false;
		document.getElementById('field_70').checked = false;
		document.getElementById('field_303').checked = false;
		
	}else{
		$('#field_67').click();
		$('#option_'+reason_id).val(1);
		document.getElementById('field_'+reason_id).checked = true;
	}
		
	
	
	if(reason_id == 303){
		document.getElementById('option_303_text').disabled = false;
		
	}else{
		document.getElementById('option_303_text').disabled = true;
		
	}
}
</script>
</div>

<div style="width:220px;height:150px;float:left;border-right:solid 1px #000;">
<div style="width:95%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;padding-left:5px;">INVESTIGATIONS</div>

<div style="width:95px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_72" onclick="if(this.checked){$('#option_72').val(1);}else{$('#option_72').val('');}" <?php print($form_option_checked[72]);?>><label for="field_72">HIV</label></div>
<div style="width:95px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_75" onclick="if(this.checked){$('#option_75').val(1);}else{$('#option_75').val('');}" <?php print($form_option_checked[75]);?>><label for="field_75">RPR</label></div>
<div style="width:95px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_73" onclick="if(this.checked){$('#option_73').val(1);}else{$('#option_73').val('');}" <?php print($form_option_checked[73]);?>><label for="field_73">CrCl</label></div>
<div style="width:95px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_76" onclick="if(this.checked){$('#option_76').val(1);}else{$('#option_76').val('');}" <?php print($form_option_checked[76]);?>><label for="field_76">Gravindex</label></div>

<div style="width:95px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_74" onclick="if(this.checked){$('#option_74').val(1);}else{$('#option_74').val('');}" <?php print($form_option_checked[74]);?>><label for="field_74">HBsAG</label></div>
<div style="width:95px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_77" onclick="if(this.checked){$('#option_77').val(1);}else{$('#option_77').val('');}" <?php print($form_option_checked[77]);?>><label for="field_77">HVS</label></div>
<div style="width:95px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_306" onclick="if(this.checked){$('#option_306').val(1);}else{$('#option_306').val('');}" <?php print($form_option_checked[306]);?>><label for="field_306">UA</label></div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_307" onclick="if(this.checked){$('#option_307').val(1);$('#option_334').val(1);document.getElementById('option_334_text').disabled = false}else{$('#option_307').val('');$('#option_334').val('');document.getElementById('option_334_text').disabled = true}" <?php print($form_option_checked[307]);?>><label for="field_307">Other:</label> <input type="text" style="width:100px;float:right;height:20px;margin-right:5px;" id="option_334_text" <?php if(!$form_option_value[307]){print(' disabled ');};?> value="<?php print($form_option_text[334]);?>"></div>
</div>

<input type="hidden" id="option_72" value="<?php print($form_option_value[72]);?>">
<input type="hidden" id="option_73" value="<?php print($form_option_value[73]);?>">
<input type="hidden" id="option_74" value="<?php print($form_option_value[74]);?>">
<input type="hidden" id="option_75" value="<?php print($form_option_value[75]);?>">
<input type="hidden" id="option_76" value="<?php print($form_option_value[76]);?>">
<input type="hidden" id="option_77" value="<?php print($form_option_value[77]);?>">
<input type="hidden" id="option_306" value="<?php print($form_option_value[306]);?>">
<input type="hidden" id="option_307" value="<?php print($form_option_value[307]);?>">
<input type="hidden" id="option_334" value="<?php print($form_option_value[334]);?>">


<div style="width:22.9%;height:150px;float:left;">
<div style="width:95%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;padding-left:5px;">PRESCRIPTIONS</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_78" onclick="if(this.checked){$('#option_78').val(1);}else{$('#option_78').val('');}" <?php print($form_option_checked[78]);?>><label for="field_78">TDF + FTC</label></div>
<input type="hidden" id="option_78" value="<?php print($form_option_value[78]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_79" <?php print($form_option_checked[79]);?> onclick="if(this.checked){$('#option_79').val(1);document.getElementById('option_79_text').disabled=false}else{$('#option_79').val('');document.getElementById('option_79_text').disabled=true}"><label for="field_79">Other:</label><input type="text" style="width:120px;float:right;height:20px;margin-right:5px;" id="option_79_text" <?php if(!$form_option_value[79]){print(' disabled ');}?> value="<?php print($form_option_text[79]);?>"></div>
<input type="hidden" id="option_79" value="<?php print($form_option_value[79]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_80" <?php print($form_option_checked[80]);?> onclick="if(this.checked){$('#option_80').val(1);document.getElementById('option_80_text').disabled=false}else{$('#option_80').val('');document.getElementById('option_80_text').disabled=true}"><label for="field_80">Other:</label><input type="text" style="width:120px;float:right;height:20px;margin-right:5px;" id="option_80_text" <?php if(!$form_option_value[80]){print(' disabled ');}?> value="<?php print($form_option_text[80]);?>"></div>
<input type="hidden" id="option_80" value="<?php print($form_option_value[80]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_81" <?php print($form_option_checked[81]);?> onclick="if(this.checked){$('#option_81').val(1);document.getElementById('option_81_text').disabled=false}else{$('#option_81').val('');document.getElementById('option_81_text').disabled=true}"><label for="field_81">Other:</label><input type="text" style="width:120px;float:right;height:20px;margin-right:5px;" id="option_81_text" <?php if(!$form_option_value[81]){print(' disabled ');}?> value="<?php print($form_option_text[81]);?>"></div>
<input type="hidden" id="option_81" value="<?php print($form_option_value[81]);?>">

</div>
</div>
</div>

<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:45%;height:150px;float:left;border-right:solid 1px #000;">
<div style="width:95%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;padding-left:5px;">REFERALS</div>

<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_82" onclick="if(this.checked){$('#option_82').val(1);}else{$('#option_82').val('');}" <?php print($form_option_checked[82]);?>><label for="field_82">Condom lubes</label></div>

<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_86" onclick="if(this.checked){$('#option_86').val(1);}else{$('#option_86').val('');}" <?php print($form_option_checked[86]);?>><label for="field_86">Psychological Support</label></div>

<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_83" onclick="if(this.checked){$('#option_83').val(1);}else{$('#option_83').val('');}" <?php print($form_option_checked[83]);?>><label for="field_83">Risk Reduction Counseling</label></div>


<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_87" onclick="if(this.checked){$('#option_87').val(1);}else{$('#option_87').val('');}" <?php print($form_option_checked[87]);?>><label for="field_87">CaCx Screening</label></div>

<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_84" onclick="if(this.checked){$('#option_84').val(1);}else{$('#option_84').val('');}" <?php print($form_option_checked[84]);?>><label for="field_84">Partner Referral</label></div>




<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_88" onclick="if(this.checked){$('#option_88').val(1);}else{$('#option_88').val('');}" <?php print($form_option_checked[88]);?>><label for="field_88">VMMC</label><input type="checkbox" id="field_308" onclick="if(this.checked){$('#option_308').val(1);}else{$('#option_308').val('');}" <?php print($form_option_checked[308]);?> style="margin-left:30px;"><label for="field_308">FP</label></div>


<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_85" onclick="if(this.checked){$('#option_85').val(1);}else{$('#option_85').val('');}" <?php print($form_option_checked[85]);?>><label for="field_85">Adherence counseling</label></div>

<div style="width:180px;min-height:20px;height:auto;line-height:20px;float:left;"><input type="checkbox" id="field_309" onclick="if(this.checked){$('#option_309').val(1);}else{$('#option_309').val('');}" <?php print($form_option_checked[309]);?>><label for="field_309">ART if Sero-Converted</label></div>

<input type="hidden" id="option_82" value="<?php print($form_option_value[82]);?>">
<input type="hidden" id="option_83" value="<?php print($form_option_value[83]);?>">
<input type="hidden" id="option_84" value="<?php print($form_option_value[84]);?>">
<input type="hidden" id="option_85" value="<?php print($form_option_value[85]);?>">
<input type="hidden" id="option_86" value="<?php print($form_option_value[86]);?>">
<input type="hidden" id="option_87" value="<?php print($form_option_value[87]);?>">
<input type="hidden" id="option_88" value="<?php print($form_option_value[88]);?>">

<input type="hidden" id="option_308" value="<?php print($form_option_value[308]);?>">
<input type="hidden" id="option_309" value="<?php print($form_option_value[309]);?>">

</div>

<div style="width:54%;min-height:290px;height:auto;float:left;margin-left:5px;">
	<div style="width:95%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;padding-left:5px;">PrEP DISPENSED</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="radio" name="prep_dispensed" id="field_314" <?php print($form_option_checked[314]);?> onclick="check_prep_dispensed(314)"><label for="field_314">1 Month</label><input type="radio" name="prep_dispensed" id="field_316" <?php print($form_option_checked[316]);?> onclick="check_prep_dispensed(316)"><label for="field_316">2 Months</label><input type="radio" name="prep_dispensed" id="field_317" <?php print($form_option_checked[317]);?> onclick="check_prep_dispensed(317)"><label for="field_317">3 Months</label></div>

<input type="hidden" id="option_314" value="<?php print($form_option_value[314]);?>">
<input type="hidden" id="option_316" value="<?php print($form_option_value[316]);?>">
<input type="hidden" id="option_317" value="<?php print($form_option_value[317]);?>">
<input type="hidden" id="option_336" value="<?php print($form_option_value[336]);?>">

<?php
if($form_option_value[320] == ''){
	$clinical_date = date('m/j/Y',time());
	
}else{
	$clinical_date = $form_option_value[320];
	
}

$clinical_date_array = explode('/',$clinical_date);

$clinical_day = $clinical_date_array[1];
$clinical_month = $clinical_date_array[0];
$clinical_year = $clinical_date_array[2];

if($form_option_value[320] == ''){
	$pharmacy_date = date('m/j/Y',time());
	
}else{
	$pharmacy_date = $form_option_value[320];
	
}

$pharmacy_date_array = explode('/',$pharmacy_date);

$pharmacy_day = $pharmacy_date_array[1];
$pharmacy_month = $pharmacy_date_array[0];
$pharmacy_year = $pharmacy_date_array[2];
?>

<script>
	function check_prep_dispensed(field_id){
		$('#option_314').val('');
		$('#option_316').val('');
		$('#option_317').val('');
		$('#option_336').val('');
		
		$('#option_'+field_id).val(1);
		
		<?php
			$day = date('j',time());
			$month = date('m',time());
			$year = date('Y',time());
		?>
		
		var clinical_day = <?php print($day);?>;
		var clinical_month = <?php print($month);?>;
		var clinical_year = <?php print($year);?>;
		
		if(field_id == 336){
			<?php
			$time_stamp = time()+(86400*14);
			if(date('D',$time_stamp) == 'Sat'){
				$time_stamp = time()+(86400*13);
				
			}else if(date('D',$time_stamp) == 'Sun'){
				$time_stamp = time()+(86400*12);
				
			}
			?>
			clinical_day = <?php print(date('j',$time_stamp));?>;
			clinical_month = <?php print(date('m',$time_stamp));?>;
			clinical_year = <?php print(date('Y',$time_stamp));?> ;

		}else if(field_id == 314 || field_id == 316 || field_id == 317){
			if(field_id == 314){
				<?php
				$time_stamp = time()+(86400 * 30);
			
				if(date('D',$time_stamp) == 'Sat'){
					$time_stamp = $time_stamp-86400;
					
				}else if(date('D',$time_stamp) == 'Sun'){
					$time_stamp = $time_stamp-172800;
					
				}
				
				?>
				
				clinical_day = <?php print(date('j',$time_stamp));?>;
				clinical_month = <?php print(date('m',$time_stamp));?>;
				clinical_year = <?php print(date('Y',$time_stamp));?> ;
				
			}else if(field_id == 316){
				<?php
				$time_stamp = time()+(86400 * 60);
				
				if(date('D',$time_stamp) == 'Sat'){
					$time_stamp = $time_stamp-86400;
					
				}else if(date('D',$time_stamp) == 'Sun'){
					$time_stamp = $time_stamp-172800;
					
				}
				
				?>
				
				clinical_day = <?php print(date('j',$time_stamp));?>;
				clinical_month = <?php print(date('m',$time_stamp));?>;
				clinical_year = <?php print(date('Y',$time_stamp));?> ;
				
			}else if(field_id == 317){
				<?php
				$time_stamp = time()+(86400 * 90);
			
				if(date('D',$time_stamp) == 'Sat'){
					$time_stamp = $time_stamp-86400;
					
				}else if(date('D',$time_stamp) == 'Sun'){
					$time_stamp = $time_stamp-172800;
					
				}
				
				?>
				
				clinical_day = <?php print(date('j',$time_stamp));?>;
				clinical_month = <?php print(date('m',$time_stamp));?>;
				clinical_year = <?php print(date('Y',$time_stamp));?> ;
				
			}
		}
		
		$('#active_clinical_follow_up_day').html(clinical_day);
		$('#active_clinical_follow_up_month').html(clinical_month);
		$('#active_clinical_follow_up_year').html(clinical_year);
		
		$('#selected_clinical_follow_up_day').val(clinical_day);
		$('#selected_clinical_follow_up_month').val(clinical_month);
		$('#selected_clinical_follow_up_year').val(clinical_year);
		
		$('#active_pharmacy_follow_up_day').html(clinical_day);
		$('#active_pharmacy_follow_up_month').html(clinical_month);
		$('#active_pharmacy_follow_up_year').html(clinical_year);
		
		$('#selected_pharmacy_follow_up_day').val(clinical_day);
		$('#selected_pharmacy_follow_up_month').val(clinical_month);
		$('#selected_pharmacy_follow_up_year').val(clinical_year);
		
		$('#option_319').val($('#selected_clinical_follow_up_month').val()+'/'+$('#selected_clinical_follow_up_day').val()+'/'+$('#selected_clinical_follow_up_year').val());
		
		$('#option_320').val($('#selected_pharmacy_follow_up_month').val()+'/'+$('#selected_pharmacy_follow_up_day').val()+'/'+$('#selected_pharmacy_follow_up_year').val());
	}
</script>














<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">Next Pharmacy Appointment </div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;" id="follow_up_pharmacy_date_holder"><div style="width:auto;min-height:30px;height:auto;float:left;">
<div style="line-height:30px;width:25px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_pharmacy_day_menu').toggle('fast');" id="active_pharmacy_follow_up_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($pharmacy_day);?></div>

<div class="option_menu" id="follow_up_pharmacy_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_pharmacy_day_menu').toggle('fast');$('#active_pharmacy_follow_up_day').html($(this).html());$('#selected_pharmacy_follow_up_day').val(<?php print($d);?>);$('#option_319').val($('#selected_pharmacy_follow_up_month').val()+'/'+$('#selected_pharmacy_follow_up_day').val()+'/'+$('#selected_pharmacy_follow_up_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_pharmacy_day_menu').toggle('fast');$('#active_pharmacy_follow_up_day').html($(this).html());$('#selected_pharmacy_follow_up_day').val(<?php print($d);?>);$('#option_319').val($('#selected_pharmacy_follow_up_month').val()+'/'+$('#selected_pharmacy_follow_up_day').val()+'/'+$('#selected_pharmacy_follow_up_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_pharmacy_follow_up_day" id="selected_pharmacy_follow_up_day" value="<?php print($pharmacy_day);?>">
</div>

<div style="line-height:30px;width:37px;height:30px;float:left;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_pharmacy_month_menu').toggle('fast');" id="active_pharmacy_follow_up_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($pharmacy_month);?></div>


<div class="option_menu" id="follow_up_pharmacy_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_pharmacy_month_menu').toggle('fast');$('#active_pharmacy_follow_up_month').html($(this).html());$('#selected_pharmacy_follow_up_month').val(<?php print($m);?>);$('#option_319').val($('#selected_pharmacy_follow_up_month').val()+'/'+$('#selected_pharmacy_follow_up_day').val()+'/'+$('#selected_pharmacy_follow_up_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_pharmacy_month_menu').toggle('fast');$('#active_pharmacy_follow_up_month').html($(this).html());$('#selected_pharmacy_follow_up_month').val(<?php print($m);?>);$('#option_319').val($('#selected_pharmacy_follow_up_month').val()+'/'+$('#selected_pharmacy_follow_up_day').val()+'/'+$('#selected_pharmacy_follow_up_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_pharmacy_follow_up_month" value="<?php print($pharmacy_month);?>">
</div>

<div style="line-height:30px;width:30px;height:30px;float:left;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_pharmacy_year_menu').toggle('fast');" id="active_pharmacy_follow_up_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($pharmacy_year);?></div>


<div class="option_menu" id="follow_up_pharmacy_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_pharmacy_year_menu').toggle('fast');$('#active_pharmacy_follow_up_year').html($(this).html());$('#selected_pharmacy_follow_up_year').val(<?php print($y);?>);$('#option_319').val($('#selected_pharmacy_follow_up_month').val()+'/'+$('#selected_pharmacy_follow_up_day').val()+'/'+$('#selected_pharmacy_follow_up_year').val());check_if_pharmacy_future()" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_pharmacy_follow_up_year" id="selected_pharmacy_follow_up_year" value="<?php print($pharmacy_year);?>">
</div>

</div>
<div style="width:90%;height:20px;float:left;lie-height:20px;text-align:left;padding-left:5px;display:none;" id="follow_up_pharmacy_date_validation_status"></div>
<input type="hidden" value="0" id="follow_up_pharmacy_date_validation">
</div>


<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;margin-top:5px;">Next Clinical Appointment</div>


<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;" id="follow_up_clinical_date_holder"><div style="width:auto;min-height:30px;height:auto;float:left;">
<div style="line-height:30px;width:25px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_clinical_day_menu').toggle('fast');" id="active_clinical_follow_up_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($clinical_day);?></div>

<div class="option_menu" id="follow_up_clinical_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_clinical_day_menu').toggle('fast');$('#active_clinical_follow_up_day').html($(this).html());$('#selected_clinical_follow_up_day').val(<?php print($d);?>);$('#option_320').val($('#selected_clinical_follow_up_month').val()+'/'+$('#selected_clinical_follow_up_day').val()+'/'+$('#selected_clinical_follow_up_year').val());check_if_clinical_future()" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_clinical_day_menu').toggle('fast');$('#active_clinical_follow_up_day').html($(this).html());$('#selected_clinical_follow_up_day').val(<?php print($d);?>);$('#option_320').val($('#selected_clinical_follow_up_month').val()+'/'+$('#selected_clinical_follow_up_day').val()+'/'+$('#selected_clinical_follow_up_year').val());check_if_clinical_future()" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_clinical_follow_up_day" id="selected_clinical_follow_up_day" value="<?php print($clinical_day);?>">
</div>

<div style="line-height:30px;width:37px;height:30px;float:left;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_clinical_month_menu').toggle('fast');" id="active_clinical_follow_up_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($clinical_month);?></div>


<div class="option_menu" id="follow_up_clinical_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_clinical_month_menu').toggle('fast');$('#active_clinical_follow_up_month').html($(this).html());$('#selected_clinical_follow_up_month').val(<?php print($m);?>);$('#option_320').val($('#selected_clinical_follow_up_month').val()+'/'+$('#selected_clinical_follow_up_day').val()+'/'+$('#selected_clinical_follow_up_year').val());check_if_clinical_future()" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_clinical_month_menu').toggle('fast');$('#active_clinical_follow_up_month').html($(this).html());$('#selected_clinical_follow_up_month').val(<?php print($m);?>);$('#option_320').val($('#selected_clinical_follow_up_month').val()+'/'+$('#selected_clinical_follow_up_day').val()+'/'+$('#selected_clinical_follow_up_year').val());check_if_clinical_future()" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_clinical_follow_up_month" value="<?php print($clinical_month);?>">
</div>

<div style="line-height:30px;width:30px;height:30px;float:left;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;">

<div class="option_item" title="Click to change option" onclick="$('#follow_up_clinical_year_menu').toggle('fast');" id="active_clinical_follow_up_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($clinical_year);?></div>


<div class="option_menu" id="follow_up_clinical_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#follow_up_clinical_year_menu').toggle('fast');$('#active_clinical_follow_up_year').html($(this).html());$('#selected_clinical_follow_up_year').val(<?php print($y);?>);$('#option_320').val($('#selected_clinical_follow_up_month').val()+'/'+$('#selected_clinical_follow_up_day').val()+'/'+$('#selected_clinical_follow_up_year').val());check_if_clinical_future()" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_clinical_follow_up_year" id="selected_clinical_follow_up_year" value="<?php print($clinical_year);?>">
</div>
<input type="hidden" id="option_319" value="<?php print($form_option_value[319]);?>">
<input type="hidden" id="option_320" value="<?php print($form_option_value[320]);?>">
</div>
<div style="width:95%;padding-left:5px;height:20px;float:left;lie-height:20px;text-align:left;display:none;" id="follow_up_clinical_date_validation_status"></div>
<input type="hidden" value="0" id="follow_up_clinical_date_validation">
</div>

</div>
</div>


</div>
</div>

</div>
</div>

<script>
check_if_pharmacy_future();
check_if_clinical_future();
function check_if_pharmacy_future(){
	var option_value = $('#option_319').val();
	var follow_up_value = $('#option_341').val();
	
	var option_value_array = option_value.split('/');
	var follow_up_value_array = follow_up_value.split('/');
	
	var date_array = new Array();
	var date_array = is_date_future(follow_up_value_array[2]+'/'+follow_up_value_array[0]+'/'+follow_up_value_array[1]+' 00:00:00',option_value_array[2]+'/'+option_value_array[0]+'/'+option_value_array[1]+' 00:00:00');
	
	if(!isNaN(date_array[1])){
		if(date_array[0]){
			$('#follow_up_pharmacy_date_validation_status').html('Pharmacy date is before follow-up date');
			$('#follow_up_pharmacy_date_validation_status').css('color','red');
			$('#follow_up_pharmacy_date_validation_status').slideDown('fast');
			$('#follow_up_pharmacy_date_holder').css('border','solid 1px red');
			$('#follow_up_pharmacy_date_validation').val(0);
			
		}else{
			$('#follow_up_pharmacy_date_validation_status').html('Pharmacy date okay');
			$('#follow_up_pharmacy_date_validation_status').css('color','green');
			$('#follow_up_pharmacy_date_validation_status').slideDown('fast');
			$('#follow_up_pharmacy_date_holder').css('border','none');
			$('#follow_up_pharmacy_date_validation').val(1);
			
		}
	}
}

function check_if_clinical_future(){
	var option_value = $('#option_320').val();
	var follow_up_value = $('#option_341').val();
	
	var option_value_array = option_value.split('/');
	var follow_up_value_array = follow_up_value.split('/');
	
	var date_array = new Array();
	var date_array = is_date_future(follow_up_value_array[2]+'/'+follow_up_value_array[0]+'/'+follow_up_value_array[1]+' 00:00:00',option_value_array[2]+'/'+option_value_array[0]+'/'+option_value_array[1]+' 00:00:00');
	
	if(!isNaN(date_array[1])){
		if(date_array[0]){
			$('#follow_up_clinical_date_validation_status').html('Clinical date is before follow-up date');
			$('#follow_up_clinical_date_validation_status').css('color','red');
			$('#follow_up_clinical_date_validation_status').slideDown('fast');
			$('#follow_up_clinical_date_holder').css('border','solid 1px red');
			$('#follow_up_clinical_date_validation').val(0);
			
		}else{
			$('#follow_up_clinical_date_validation_status').html('Clinical date okay');
			$('#follow_up_clinical_date_validation_status').css('color','green');
			$('#follow_up_clinical_date_validation_status').slideDown('fast');
			$('#follow_up_clinical_date_holder').css('border','none');
			$('#follow_up_clinical_date_validation').val(1);
			
		}
	}
}


fetch_basic_details(<?php print($form_id);?>);

$('#client_province_<?php print($form_id);?>').html($('#active_client_province').html());
$('#client_district_<?php print($form_id);?>').html($('#active_client_hub').html());
$('#client_facility_<?php print($form_id);?>').html($('#active_client_site').html());

</script>