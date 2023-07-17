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

$this_client = mysqli_query($connect,"select * from covid_clients where id = $client_id")or die(mysqli_error($connect));
if(mysqli_num_rows($this_client)){
	$this_client_results = mysqli_fetch_array($this_client,MYSQLI_ASSOC);
	$prep_id = $this_client_results['client_id'];
	
	$investigation_day = $this_client_results['investigation_day'];
	
	$home_based_monitoring_date = $this_client_results['home_based_monitoring_start_date'];
	$date_of_birth = $this_client_results['date_of_birth'];
	$client_name = explode(' ',$this_client_results['_name']);
	$client_phone = explode(',',$this_client_results['phone']);
	$client_grz_identifier = $this_client_results['grz_identifier'];
	$sex = $this_client_results['sex'];
	
	if($sex == 1){
		$gender_title = "M";
		
	}else if($sex == 1){
		$gender_title = "F";
		
	}else{
		$gender_title = "Other";
		
	}
	
	$physical_address = $this_client_results['physical_address'];
	$house_number = $this_client_results['house_number'];
	$district = $this_client_results['non_disc_district'];
	$province = $this_client_results['non_disc_province'];
	$town = $this_client_results['non_disc_town'];
	$street = $this_client_results['non_disc_street'];
	$landmark = $this_client_results['other_landmark'];
	$next_of_kin = explode(' ',$this_client_results['next_of_kin_name']);
	$next_of_kin_contact = explode(',',$this_client_results['next_of_kin_contact_number']);
	
	
}else{
	$prep_id = 'Unassigned';
	$investigation_day = 0;
	$home_based_monitoring_date = 0;
	$date_of_birth = '';
	
	$client_name[0] = '';
	$client_phone[0] = '';
	$client_grz_identifier = '';
	$sex = 1;
	
	if($gender == 1){
		$gender_title = "M";
		
	}else if($gender == 1){
		$gender_title = "F";
		
	}else{
		$gender_title = "Other";
		
	}
	
	$physical_address = '';
	$house_number = '';
	$district = '';
	$province = '';
	$town = '';
	$street = '';
	$landmark = '';
	$next_of_kin[0] = '';
	$next_of_kin_contact[0] = '';
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

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="dynamic_form_save_button_<?php print($form_id);?>" onclick="update_covid_form_client_profile(<?php print($client_id.','.$form_id.','.$data_set_id);?>);" title="Click to save this form"><?php print($button_text);?></div>

<?php
//}
?>
</div>

<div style="width:100%;height:450px;float:left;overflow:auto;">



<div style="width:991px;height:auto;margin:0 auto;">

<div style="width:100%;height:50px;line-height:30px;float:left;text-align:center;margin-bottom:10px;"><div style="width:400px;height:30px;margin:0 auto;border:solid 1px #999;font-weight:bold;font-size:1.1em;">COVID-19 DAILY PATIENT MONITORING TOOL</div>
<div style="width:400px;height:20px;margin:0 auto;">Complete for each or confirmed case</div>
</div>

<div style="width:100%;height:15px;line-height:15px;float:left;font-style:italic;cursor:pointer;" onclick="$('#client_profile_summary').slideToggle('fast');" title="Click to show client profile summary" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='';">Hide/Show client profile summary</div>
<div style="width:99.3%;height:auto;float:left;padding:2px;" id="client_profile_summary">


<div style="width:43%;height:300px;float:left;">
<div style="width:100%;height:40px;float:left;text-align:center;background-color:#ccc;line-height:40px;font-weight:bold;">Details of confirmed case</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;font-weight:bold;">
<div style="width:60px;float:left;line-height:20px;">ZNPHI Identifier</div>

<div style="width:360px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;">
<input type="text" style="width:100%;height:35px;" id="client_grz_identifier" value="<?php print($client_grz_identifier);?>">
</div>
</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:60px;float:left;line-height:40px;font-weight:bold;">Surname</div>

<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_surname" value="<?php if(isset($client_name[1])){print($client_name[1]);}?>"></div>

<div style="width:60px;float:left;line-height:40px;margin-left:30px;font-weight:bold;">Name</div>
<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_firstname" value="<?php if(isset($client_name[0])){print($client_name[0]);}?>"></div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:60px;float:left;line-height:20px;font-weight:bold;">Date of birth</div>

<div style="width:195px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;font-style:normal;position:relative">
<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">D:</div>
<div style="width:auto;max-width:50px;min-height:30px;height:auto;float:left;">

<?php

if($date_of_birth == 0 || $date_of_birth == ''){
	$day = 0;
	$month = 0;
	$year = 0;
	
	$day_title = 'Pick';
	$month_title = 'Pick';
	$year_title = 'Pick';
	
	$date_title = 0;

}else{
	$date_array = explode('/',date('j/m/Y',$date_of_birth));
	$day = $date_array[1];
	$month = $date_array[0];
	$year = $date_array[2];
	
	$day_title = $day;
	$month_title = $month;
	$year_title = $year;
	
	$date_title = $month_title.'/'.$day_title.'/'.$year_title;
}

?>

<div class="option_item" title="Click to change option" onclick="$('#client_date_of_birth_day_menu').toggle('fast');$('#client_date_of_birth_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_client_date_of_birth_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($day_title);?></div>

<div class="option_menu" id="client_date_of_birth_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_date_of_birth_day_menu').toggle('fast');$('#active_client_date_of_birth_day').html($(this).html());$('#selected_client_date_of_birth_day').val(<?php print($d);?>);$('#client_date_of_birth').val($('#selected_client_date_of_birth_month').val()+'/'+$('#selected_client_date_of_birth_day').val()+'/'+$('#selected_client_date_of_birth_year').val());check_if_client_date_of_birth_future();" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_date_of_birth_day_menu').toggle('fast');$('#active_client_date_of_birth_day').html($(this).html());$('#selected_client_date_of_birth_day').val(<?php print($d);?>);$('#client_date_of_birth').val($('#selected_client_date_of_birth_month').val()+'/'+$('#selected_client_date_of_birth_day').val()+'/'+$('#selected_client_date_of_birth_year').val());check_if_client_date_of_birth_future();" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_client_date_of_birth_day" id="selected_client_date_of_birth_day" value="<?php print($day);?>">
</div>

<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">M:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;">

<div class="option_item" style="width:30px;" title="Click to change option" onclick="$('#client_date_of_birth_month_menu').toggle('fast');$('#client_date_of_birth_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_client_date_of_birth_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" ><?php print($month_title);?></div>


<div class="option_menu" id="client_date_of_birth_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_date_of_birth_month_menu').toggle('fast');$('#active_client_date_of_birth_month').html($(this).html());$('#selected_client_date_of_birth_month').val(<?php print($m);?>);$('#client_date_of_birth').val($('#selected_client_date_of_birth_month').val()+'/'+$('#selected_client_date_of_birth_day').val()+'/'+$('#selected_client_date_of_birth_year').val());check_if_client_date_of_birth_future();" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_date_of_birth_month_menu').toggle('fast');$('#active_client_date_of_birth_month').html($(this).html());$('#selected_client_date_of_birth_month').val(<?php print($m);?>);$('#client_date_of_birth').val($('#selected_client_date_of_birth_month').val()+'/'+$('#selected_client_date_of_birth_day').val()+'/'+$('#selected_client_date_of_birth_year').val());check_if_client_date_of_birth_future();" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_client_date_of_birth_month" id="selected_client_date_of_birth_month" value="<?php print($month);?>">
</div>


<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">Y:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#client_date_of_birth_year_menu').toggle('fast');$('#client_date_of_birth_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_client_date_of_birth_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($year_title);?></div>


<div class="option_menu" id="client_date_of_birth_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 100);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_date_of_birth_year_menu').toggle('fast');$('#active_client_date_of_birth_year').html($(this).html());$('#selected_client_date_of_birth_year').val(<?php print($y);?>);$('#client_date_of_birth').val($('#selected_client_date_of_birth_month').val()+'/'+$('#selected_client_date_of_birth_day').val()+'/'+$('#selected_client_date_of_birth_year').val());check_if_client_date_of_birth_future();" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_client_date_of_birth_year" id="selected_client_date_of_birth_year" value="<?php print($year);?>">
</div>
<input type="hidden" id="client_date_of_birth" value="<?php print($date_of_birth);?>">
</div>

<div style="width:60px;float:left;line-height:40px;margin-left:30px;font-weight:bold;">Gender</div>
<div style="width:75px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#monitor_sex_menu').toggle('fast');" id="active_monitor_sex" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:auto;"><?php print($gender_title);?></div>

			<div class="option_menu" id="monitor_sex_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			$gender = mysqli_query($connect,"select * from genders order by title")or die(mysqli_error($connect));
			
			for($g=0;$g<mysqli_num_rows($gender);$g++){
				$gender_results = mysqli_fetch_array($gender,MYSQLI_ASSOC);
				?>
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#monitor_sex_menu').toggle('fast');$('#active_monitor_sex').html($(this).html());$('#client_selected_monitor_sex').val(<?php print($gender_results['id']);?>);$('#new_client_error_message').slideUp('fast');"><?php print($gender_results['title']);?></div>
				
				<?php
			}
			?>
					
			</div>
	</div>
	<input type="hidden" id="client_selected_monitor_sex" value="<?php print($sex);?>">






</div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:60px;float:left;line-height:20px;font-weight:bold;">Physical Address</div>

<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_physical_address" value="<?php print($physical_address);?>"></div>

<div style="width:60px;float:left;line-height:40px;margin-left:30px;font-weight:bold;">District</div>
<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_district" value="<?php print($district);?>"></div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:60px;float:left;line-height:20px;font-weight:bold;">House number</div>

<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_house_number" value="<?php print($house_number);?>"></div>

<div style="width:60px;float:left;line-height:40px;margin-left:30px;font-weight:bold;">Street</div>
<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_street" value="<?php print($street);?>"></div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:60px;float:left;line-height:20px;font-weight:bold;">Contact number</div>

<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_phone" value="<?php print($client_phone[0]);?>"></div>

<div style="width:60px;float:left;line-height:20px;margin-left:30px;font-weight:bold;">Alternate number</div>
<div style="width:135px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_alternate_phone" value="<?php if(isset($client_phone[1])){print($client_phone[0]);}?>"></div>

</div>


</div>


<div style="width:56%;height:300px;float:right;font-size:0.9em;">
<div style="width:100%;height:180px;float:left;border:solid 1px #999;">
<div style="width:100%;height:40px;float:left;">
<div style="width:270px;float:left;height:40px;line-height:40px;float:left;background-color:#ccc;text-align:center;font-weight:bold;">Details of health official completing this form</div>

<div style="width:75px;float:left;margin-left:5px;font-weight:bold;margin-right:10px;">Start date for home based monitoring</div>
<div style="width:190px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;position:relative">
<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">D:</div>
<div style="width:auto;max-width:50px;min-height:30px;height:auto;float:left;">

<?php

if($home_based_monitoring_date == 0){
	$day = 0;
	$month = 0;
	$year = 0;
	
	$day_title = 'Pick';
	$month_title = 'Pick';
	$year_title = 'Pick';
	
	$date_title = 0;

}else{
	$date_array = explode('/',date('j/m/Y',$home_based_monitoring_date));
	$day = $date_array[1];
	$month = $date_array[0];
	$year = $date_array[2];
	
	$day_title = $day;
	$month_title = $month;
	$year_title = $year;
	
	$date_title = $month_title.'/'.$day_title.'/'.$year_title;
}
?>

<div class="option_item" title="Click to change option" onclick="$('#home_based_monitoring_day_menu').toggle('fast');$('#home_based_monitoring_home_based_monitoring').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_home_based_monitoring_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($day_title);?></div>

<div class="option_menu" id="home_based_monitoring_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#home_based_monitoring_day_menu').toggle('fast');$('#active_home_based_monitoring_day').html($(this).html());$('#selected_home_based_monitoring_day').val(<?php print($d);?>);$('#home_based_monitoring_date').val($('#selected_home_based_monitoring_month').val()+'/'+$('#selected_home_based_monitoring_day').val()+'/'+$('#selected_home_based_monitoring_year').val());check_if_home_based_monitoring_future();" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#home_based_monitoring_day_menu').toggle('fast');$('#active_home_based_monitoring_day').html($(this).html());$('#selected_home_based_monitoring_day').val(<?php print($d);?>);$('#home_based_monitoring_date').val($('#selected_home_based_monitoring_month').val()+'/'+$('#selected_home_based_monitoring_day').val()+'/'+$('#selected_home_based_monitoring_year').val());check_if_home_based_monitoring_future();" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_home_based_monitoring_day" id="selected_home_based_monitoring_day" value="<?php print($day);?>">
</div>

<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">M:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;">

<div class="option_item" style="width:30px;" title="Click to change option" onclick="$('#home_based_monitoring_month_menu').toggle('fast');$('#home_based_monitoring_home_based_monitoring').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_home_based_monitoring_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" ><?php print($month_title);?></div>


<div class="option_menu" id="home_based_monitoring_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#home_based_monitoring_month_menu').toggle('fast');$('#active_home_based_monitoring_month').html($(this).html());$('#selected_home_based_monitoring_month').val(<?php print($m);?>);$('#home_based_monitoring_date').val($('#selected_home_based_monitoring_month').val()+'/'+$('#selected_home_based_monitoring_day').val()+'/'+$('#selected_home_based_monitoring_year').val());check_if_home_based_monitoring_future();" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#home_based_monitoring_month_menu').toggle('fast');$('#active_home_based_monitoring_month').html($(this).html());$('#selected_home_based_monitoring_month').val(<?php print($m);?>);$('#home_based_monitoring_date').val($('#selected_home_based_monitoring_month').val()+'/'+$('#selected_home_based_monitoring_day').val()+'/'+$('#selected_home_based_monitoring_year').val());check_if_home_based_monitoring_future();" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_home_based_monitoring_month" id="selected_home_based_monitoring_month" value="<?php print($month);?>">
</div>


<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">Y:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#home_based_monitoring_year_menu').toggle('fast');$('#home_based_monitoring_home_based_monitoring').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_home_based_monitoring_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($year_title);?></div>


<div class="option_menu" id="home_based_monitoring_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#home_based_monitoring_year_menu').toggle('fast');$('#active_home_based_monitoring_year').html($(this).html());$('#selected_home_based_monitoring_year').val(<?php print($y);?>);$('#home_based_monitoring_date').val($('#selected_home_based_monitoring_month').val()+'/'+$('#selected_home_based_monitoring_day').val()+'/'+$('#selected_home_based_monitoring_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_home_based_monitoring_year" id="selected_home_based_monitoring_year" value="<?php print($year);?>">
</div>
<input type="hidden" id="home_based_monitoring_date" value="<?php print($date_title);?>">

</div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:75px;float:left;line-height:40px;margin-left:5px;font-weight:bold;">Surname</div>

<div style="width:190px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="official_last_name"></div>

<div style="width:75px;float:left;line-height:40px;margin-left:5px;font-weight:bold;">Name</div>
<div style="width:195px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="official_first_name"></div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:75px;float:left;line-height:40px;margin-left:5px;font-weight:bold;">Role</div>

<div style="width:190px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="official_role"></div>

<div style="width:75px;float:left;line-height:40px;margin-left:5px;font-weight:bold;">Facility name</div>
<div style="width:195px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="official_facility_name"></div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:75px;float:left;line-height:20px;margin-left:5px;font-weight:bold;">Email address</div>

<div style="width:190px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="official_address"></div>

<div style="width:75px;float:left;line-height:40px;margin-left:5px;font-weight:bold;">Telephone</div>
<div style="width:195px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="official_phone"></div>

</div>
</div>

<div style="width:100%;height:40px;float:left;">
<div style="width:75px;float:left;line-height:50px;margin-left:5px;font-weight:bold;">Province</div>

<div style="width:190px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_province"></div>

<div style="width:75px;float:left;line-height:50px;margin-left:5px;font-weight:bold;">Town</div>
<div style="width:195px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_town"></div>

</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
	<div style="width:75px;float:left;line-height:20px;margin-left:5px;font-weight:bold;">Other landmark</div>
	<div style="width:465px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_landmark" value="<?php print($landmark);?>"></div>
</div>

<div style="width:100%;height:40px;float:left;margin-top:5px;">
<div style="width:75px;float:left;margin-left:5px;font-weight:bold;">Next of kin name and surname</div>

<div style="width:190px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_next_of_kin_name" value="<?php if(isset($next_of_kin[1])){print($next_of_kin[1]);}?>"></div>

<div style="width:75px;float:left;margin-left:5px;font-weight:bold;">Next of kin contact number</div>
<div style="width:195px;float:left;height:40px;float:left;border-bottom:solid 1px #ccc;"><input type="text" style="width:100%;height:35px;" id="client_next_of_kin_phone" value="<?php print($next_of_kin[0]);?>"></div></div>

</div>
</div>
</div>

<div style="width:1067px;height:auto;margin:0 auto;">
<div style="width:99.3%;height:auto;float:left;padding:2px;">

<div style="width:100%;height:20px;line-height:20px;float:left;margin-top:30px;font-weight:bold;color:#006bb3"><i>Instructions for completion: Tick "Y" if symptoms present and "N" if not</i></div>

<div style="width:100%;height:auto;float:left;border:solid 1px #ccc;margin-top:10px;position:relative">

<div style="width:130px;float:left;font-weight:bold;height:auto;margin-left:5px;">
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Day</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Date (DD/MM/YYY)</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Temperature</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Fever</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Chills</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Cough</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Sore Throat</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Shortness of breath</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Body pains</div>
<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;">Diarrhea</div>
</div>

<?php

$dynamic_form_options = new_fetch_db_table('connect','dynamic_form_category_options',1,'id',' dynamic_form_id = '.$form_id.' and status = 1');
$dynamic_form_categories = new_fetch_db_table('connect','dynamic_form_categories',1,'id',' dynamic_form_id = '.$form_id." and status = 1 and title != 'General'");
$option_count = 0;


for($c=0;$c<count($dynamic_form_categories[1]['id']);$c++){
	
	$disabled = 'disabled';
	$bg_color = '';
	if($investigation_day == $c){
		$disabled = '';
		$bg_color = '#efe';
	}

	if($investigation_day < $c){
		$bg_color = '#fee';
		
	}
	?>
	
	<div style="width:60px;float:left;height:auto;border-left:solid 1px #ccc;margin-left:5px;text-align:center;font-size:0.9em;background-color:<?php print($bg_color);?>">
	<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;text-align:center;font-weight:bold">Day <?php print ($c+1);?></div>
	
	<?php

	$option_index = array_keys($dynamic_form_options[1]['dynamic_form_category_id'],$dynamic_form_categories[1]['id'][$c]);
	
	if(isset($option_index[0])){
		for($o=0;$o<count($option_index);$o++){
			$this_option_id = $dynamic_form_options[1]['id'][$option_index[$o]];
			
			if(strpos($dynamic_form_options[1]['category_title'][$option_index[$o]],'yes')){
				$option_title = 'Y';
				$option_count++;
				?>
				<input type="hidden" id="option_<?php print($option_count);?>_yes_id" value="<?php print($this_option_id);?>">
				<?php
				
			}else{
				$option_title = 'N';
				
				?>
				<input type="hidden" id="option_<?php print($option_count);?>_no_id" value="<?php print($this_option_id);?>">
				<?php
			}
			
			if($dynamic_form_options[1]['option_type'][$option_index[$o]] == 3 || $dynamic_form_options[1]['option_type'][$option_index[$o]] == 2){
				
				if($dynamic_form_options[1]['option_type'][$option_index[$o]] == 2){
					
					
					?>
					<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;"><input type="text" style="width:100%;height:20px;" onfocusout="if(this.value=='' || this.value==0 || isNaN(this.value) || Number(this.value) > 49){$('#option_<?php print($this_option_id);?>').val('');if(isNaN(this.value) || Number(this.value) > 49){this.value=0;alert('Value for day <?php print($c+1);?> must be a number less than 50');}}else{$('#option_<?php print($this_option_id);?>').val(1);}" <?php print($disabled);?> id="option_<?php print($this_option_id);?>_text" value="<?php print($form_option_text[$this_option_id]);?>"></div>
					<input id="option_<?php print($this_option_id);?>" type="hidden" value="">
					<?php
					
				}else{
					if($form_option_value[$this_option_id] == ''){
						$day = 0;
						$month = 0;
						$year = 0;
						
						$day_title = 'Pick';
						$month_title = 'Pick';
						$year_title = 'Pick';
						
						$date_title = '';
						$date_display_title = '';
						
					}else{
						$date_array = explode('/',$form_option_value[$this_option_id]);
						$day = $date_array[1];
						$month = $date_array[0];
						$year = $date_array[2];
						
						$day_title = $day;
						$month_title = $month;
						$year_title = $year;
						
						$date_title = $month_title.'/'.$day_title.'/'.$year_title;
						$date_display_title = $day_title.'/'.$month_title.'/'.$year_title;
					}
					
					
					if($c>10){
						$date_holder_left_position = 30+(60*$c);
						
					}else{
						$date_holder_left_position = 0;
						
					}
					?>
					<div style="width:100%;height:20px;float:left;border-bottom:solid 1px #eee;"><input type="text" style="width:100%;height:20px;" onfocus="change_date_field(<?php print($this_option_id.','.$date_holder_left_position);?>,)" id="option_<?php print($this_option_id);?>_display" <?php print($disabled);?> value="<?php print($date_display_title);?>"></div>
					<div style="width:250px;height:100px;position:absolute;background-color:#fff;display:none;border:solid 1px #006bb3;z-index:100" id="option_<?php print($this_option_id);?>_date_holder" ondblclick="$(this).slideUp('fast')">
					<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;text-align:center;font-weight:bold;"><div style="width:230px;float:left;"><?php print('Day '.($c+1).' date');?></div><div style="cursor:pointer;width:20px;height:20px;line-height:20px;float:left;background-color:brown;text-align:center;color:#fff;" onmouseover="this.style.backgroundColor='#c34848'" onmouseout="this.style.backgroundColor='brown';" onclick="$('#option_<?php print($this_option_id);?>_date_holder').slideUp('fast')">X</div></div>
					
					<input type="hidden" id="option_<?php print($this_option_id);?>" value="<?php print($date_title);?>">
				
						<div style="line-height:30px;width:auto;height:30px;float:left;margin-left:5px;">D:</div>
						<div style="width:auto;;min-height:30px;height:auto;float:left;margin-left:5px;">

						<div class="option_item" title="Click to change option" onclick="$('#date_holder_option_<?php print($this_option_id);?>day_menu').toggle('fast');$('#date_holder_option_<?php print($this_option_id);?>date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_date_holder_option_<?php print($this_option_id);?>day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($day_title);?></div>

						<div class="option_menu" id="date_holder_option_<?php print($this_option_id);?>day_menu" style="display:none;width:65px">
						<?php
						if(date('m',time()) < 15){
							for($d=1;$d<32;$d++){
								if($d<10){
									$do='0'.$d;
								}else{
									$do = $d;
								}
								?>

								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_holder_option_<?php print($this_option_id);?>day_menu').toggle('fast');$('#active_date_holder_option_<?php print($this_option_id);?>day').html($(this).html());$('#selected_date_holder_option_<?php print($this_option_id);?>day').val(<?php print($d);?>);" style="width:40px;"><?php print($do);?></div>
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

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_holder_option_<?php print($this_option_id);?>day_menu').toggle('fast');$('#active_date_holder_option_<?php print($this_option_id);?>day').html($(this).html());$('#selected_date_holder_option_<?php print($this_option_id);?>day').val(<?php print($d);?>);" style="width:40px;"><?php print($do);?></div>
							<?php
							}
						}
						?>
						</div>
						<input type="hidden" name="selected_date_holder_option_<?php print($this_option_id);?>day" id="selected_date_holder_option_<?php print($this_option_id);?>day" value="<?php print($day);?>">
						</div>

						<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">M:</div>
						<div style="width:auto;min-height:30px;height:auto;float:left;">

						<div class="option_item" style="width:30px;" title="Click to change option" onclick="$('#date_holder_option_<?php print($this_option_id);?>month_menu').toggle('fast');$('#date_holder_option_<?php print($this_option_id);?>date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_date_holder_option_<?php print($this_option_id);?>month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" ><?php print($month_title);?></div>


						<div class="option_menu" id="date_holder_option_<?php print($this_option_id);?>month_menu" style="display:none;width:65px">
						<?php
						if(date('m',time()) < 6){
							for($m=1;$m<13;$m++){
								
								if($m<10){
									$mo='0'.$m;
								}else{
									$mo = $m;
								}
								?>

								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_holder_option_<?php print($this_option_id);?>month_menu').toggle('fast');$('#active_date_holder_option_<?php print($this_option_id);?>month').html($(this).html());$('#selected_date_holder_option_<?php print($this_option_id);?>month').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
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

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_holder_option_<?php print($this_option_id);?>month_menu').toggle('fast');$('#active_date_holder_option_<?php print($this_option_id);?>month').html($(this).html());$('#selected_date_holder_option_<?php print($this_option_id);?>month').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
							<?php
							}
						}
						?>
						</div>
						<input type="hidden" name="selected_date_holder_option_<?php print($this_option_id);?>month" id="selected_date_holder_option_<?php print($this_option_id);?>month" value="<?php print($month);?>">
						</div>


						<div style="line-height:30px;width:auto;height:30px;float:left;margin-right:2px;">Y:</div>
						<div style="width:50px;min-height:30px;height:auto;float:left;">

						<div class="option_item" title="Click to change option" onclick="$('#date_holder_option_<?php print($this_option_id);?>year_menu').toggle('fast');$('#date_holder_option_<?php print($this_option_id);?>date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_date_holder_option_<?php print($this_option_id);?>year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($year_title);?></div>


						<div class="option_menu" id="date_holder_option_<?php print($this_option_id);?>year_menu" style="display:none;width:65px;">
						<?php
							for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
								?>

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_holder_option_<?php print($this_option_id);?>year_menu').toggle('fast');$('#active_date_holder_option_<?php print($this_option_id);?>year').html($(this).html());$('#selected_date_holder_option_<?php print($this_option_id);?>year').val(<?php print($y);?>);" style="width:50px;"><?php print($y);?></div>
							<?php
							}

						?>
						</div>
						<input type="hidden" name="selected_date_holder_option_<?php print($this_option_id);?>year" id="selected_date_holder_option_<?php print($this_option_id);?>year" value="<?php print($year);?>">
						</div>
						
						<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;margin:0 auto;cursor:pointer;margin-top:60px;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="add_option_date(<?php print($this_option_id);?>)">Done</div>
					
					</div>
					<?php
				}
			}else{
				if($form_option_value[$this_option_id] == '' || $form_option_value[$this_option_id] == 0){
					$checked = '';
					
				}else{
					$checked = ' checked ';
				}
				?>
				<div style="width:30px;height:20px;float:left;border-bottom:solid 1px #eee;"><input type="radio" name="field_<?php print($option_count);?>" id="field_<?php print($option_count.'_'.$this_option_id);?>" style="font-size:0.6em;" onchange="if(this.checked){change_option_selection(<?php print($this_option_id.','.$option_count.",'".$option_title."'");?>)}" <?php print($disabled);?> <?php print($checked);?>><label for="field_<?php print($option_count.'_'.$this_option_id);?>" ><?php print($option_title);?></label></div>
				<input id="option_<?php print($this_option_id);?>" type="hidden" value="<?php print($form_option_value[$this_option_id]);?>">
				<?php
			}
		}
	}
	?>
	</div>
	<?php
}
?>
<script>

function update_covid_form_client_profile(client_id,form_id,data_set_id){
	
	if($('#home_based_monitoring_date').val() == 0){
		alert('Start date for home based monitoring must be specified');
	
	}else{
		if($('#client_date_of_birth').val() == 0){
			var c = confirm('Date of birth has not been specified. If you proceed, you will need to update this field on the client profile tab. Proceed?');
			
		}else{
			var c = 1;
			
		}
		
		if(c){
			var data = new FormData();
			
			data.append('update_covid_form_client_profile',1);
			data.append('grz_identifier',$('#client_grz_identifier').val());
			data.append('client_surname',$('#client_surname').val());
			data.append('client_firstname',$('#client_firstname').val());
			data.append('client_dob',$('#client_date_of_birth').val());
			data.append('client_gender',$('#client_selected_monitor_sex').val());
			data.append('physical_address',$('#client_physical_address').val());
			data.append('district',$('#client_district').val());
			data.append('province',$('#client_province').val());
			data.append('town',$('#client_town').val());
			data.append('land_mark',$('#client_landmark').val());
			data.append('next_of_kin',$('#client_next_of_kin_name').val());
			data.append('next_of_kin_phone',$('#client_next_of_kin_phone').val());
			data.append('house_number',$('#client_house_number').val());
			data.append('street',$('#client_street').val());
			data.append('phone',$('#client_phone').val());
			data.append('alt_number',$('#client_alternate_phone').val());
			data.append('client_home_based_monitoring_start_date',$('#home_based_monitoring_date').val());
			data.append('official_last_name',$('#official_last_name').val());
			data.append('official_first_name',$('#official_firt_name').val());
			data.append('official_role',$('#official_role').val());
			data.append('official_facility_name',$('#official_facility_name').val());
			data.append('official_email',$('#official_email').val());
			data.append('official_phone',$('#official_phone').val());
			
			data.append('client_id',client_id);
			data.append('form_id',form_id);
			data.append('data_set_id',data_set_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#dynamic_form_save_button_'+form_id).html('Starting...');
		}
	}
}

var active_date_holder_id = 0;
function change_date_field(option_id,left_position){
	$('#option_'+active_date_holder_id+'_date_holder').slideUp('fast');
	active_date_holder_id = option_id;
	$('#option_'+option_id+'_date_holder').slideDown('fast');
	
	if(left_position != 0){
		$('#option_'+option_id+'_date_holder').css('left',left_position);
	}
}

function add_option_date(option_id){
	if($('#selected_date_holder_option_'+option_id+'month').val() == 0 || $('#selected_date_holder_option_'+option_id+'day').val() == 0 || $('#selected_date_holder_option_'+option_id+'year').val()==0){
		alert('You need to select the day, the month and the year');
		
	}else{
		$('#option_'+option_id).val($('#selected_date_holder_option_'+option_id+'month').val()+'/'+$('#selected_date_holder_option_'+option_id+'day').val()+'/'+$('#selected_date_holder_option_'+option_id+'year').val());
		
		$('#option_'+option_id+'_display').val($('#selected_date_holder_option_'+option_id+'day').val()+'/'+$('#selected_date_holder_option_'+option_id+'month').val()+'/'+$('#selected_date_holder_option_'+option_id+'year').val());
		
		$('#option_'+option_id+'_date_holder').slideUp('fast');
	}
}

function change_option_selection(option_id,count_ind,option_type){
	var no_id = $('#option_'+count_ind+'_no_id').val();
	var yes_id = $('#option_'+count_ind+'_yes_id').val();
	
	if(option_type == 'Y'){
		$('#option_'+no_id).val('');
		
	}else{
		$('#option_'+yes_id).val('');
		
	}
	
	$('#option_'+option_id).val(1);
}
</script>
<div style="margin-top:5px;font-weight:bold;color:#006bb3;width:100%;height:20px;line-height:20px;float:left;font-size:0.9em;text-align:center;border-bottom:solid 1px #ccc;">Add other symptoms in space below (include day symptoms are noted) e.g. loss of appetite, loss of taste and sense of smell, nausea, vomiting, muscle aches, headache, new chest pain etc.</div>

<div style="width:100%;height:40px;line-height:20px;float:left;font-size:0.9em;">
<div style="width:170px;float:left;height:100%;border-right:solid 1px #eee;"><div style="width:50px;float:left;height:20px;float:left;margin-left:5px;font-weight:bold;">Day</div><div style="width:100px;float:left;height:20px;"><input type="text" value="" style="width:100%;height:20px;" id="option_716_text" onfocusout="if(this.value=='' || this.value==0){$('#option_716').val('');if(isNaN(this.value)){this.value='';alert('Value for day of start of symptoms must be a number');}}else{$('#option_716').val(1);}"></div><div style="width:95%;height:20px;line-height:20px;float:left;font-size:0.9em;margin-left:5px;">(When other symptoms emerge)</div></div>

<input id="option_716" type="hidden" value="">

<div style="width:880px;float:left;height:40px;"><textarea style="color:#aaa;width:100%;height:100%;resize: none;font-family:arial" onfocus="if($(this).val()=='Enter symptoms here'){this.value='';this.style.color='#000'}" onfocusout="if($(this).val()==''){this.value='Enter symptoms here';this.style.color='#aaa'}else{$('#option_717').val(1);}" id="option_717_text">Enter symptoms here</textarea></div>

<input id="option_717" type="hidden" value="">
</div>
</div>
</div>


</div>
</div>