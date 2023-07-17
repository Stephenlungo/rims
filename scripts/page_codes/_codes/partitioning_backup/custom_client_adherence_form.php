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
<div style="width:900px;height:35px;margin:0 auto;margin-bottom:5px;" id="client_update_holder">
<div style="width:875px;height:35px;line-height:30px;float:left;color:red;font-weight:bold;" id="custom_form_error_message_<?php print($form_id);?>"></div>

<?php if($data_set_id and $active_user_roles[8]){
	?>

<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;margin-left:35px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="delete_prep_form_button_<?php print($data_set_id);?>" onclick="delete_prep_form(<?php print($form_id.','.$data_set_id);?>);" title="Click to save this form">Delete</div>

<?php
}
?>

<div style="width:70px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#777';" onmouseout="this.style.backgroundColor='#aaa';"  id="client_profile_button" onclick="fetch_dynamic_form_list(<?php print($form_id);?>,1);" title="Click to close this form">Close form</div>

<?php // if(!$data_set_id || $user_id == $this_data_set_results['user_id'] || $active_user_roles[8]){
	?>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="dynamic_form_save_button_<?php print($form_id);?>" onclick="create_or_update_custom_client_form(<?php print($form_id.','.$data_set_id);?>);" title="Click to save this form"><?php print($button_text);?></div>

<?php
//}
?>
</div>

<div style="width:100%;height:430px;float:left;overflow:auto;">

<div style="width:821px;height:auto;margin:0 auto;">

<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;font-weight:bold;font-size:1.1em;margin-bottom:10px;"><div style="width:300px;height:30px;margin:0 auto;border:solid 1px #999;border-radius:15px;">PrEP ADHERENCE AND RETENTION TOOL</div></div>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;">A. BASIC INFORMATION</div>

<?php
if($form_option_value[347] == ''){
	$adherence_date = 0;

	$adherence_day = 0;
	$adherence_month = 0;
	$adherence_year = 0;
	
	$adherence_day_title = 'Select';
	$adherence_month_title = 'Select';
	$adherence_year_title = 'Select';
	
}else{
	$adherence_date = $form_option_value[347];
	
	$adherence_date_array = explode('/',$adherence_date);
	$adherence_day = $adherence_date_array[1];
	$adherence_month = $adherence_date_array[0];
	$adherence_year = $adherence_date_array[2];
	
	$adherence_day_title = $adherence_day;
	$adherence_month_title = $adherence_month;
	$adherence_year_title = $adherence_year;
}


?>


<div style="width:100%;min-height:30px;height:auto;line-height:30px;float:left;">
<div style="width:370px;min-height:30px;height:auto;float:left;" id="adherence_date_holder">
<div style="width:85px;height:30px;line-height:30px;float:left;font-weight:bold;">Date of visit:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#adherence_day_menu').toggle('fast');$('#adherence_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_adherence_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($adherence_day_title);?></div>

<div class="option_menu" id="adherence_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#adherence_day_menu').toggle('fast');$('#active_adherence_day').html($(this).html());$('#selected_adherence_day').val(<?php print($d);?>);$('#option_347').val($('#selected_adherence_month').val()+'/'+$('#selected_adherence_day').val()+'/'+$('#selected_adherence_year').val());check_if_adherence_future()" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#adherence_day_menu').toggle('fast');$('#active_adherence_day').html($(this).html());$('#selected_adherence_day').val(<?php print($d);?>);$('#option_347').val($('#selected_adherence_month').val()+'/'+$('#selected_adherence_day').val()+'/'+$('#selected_adherence_year').val());check_if_adherence_future()" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_adherence_day" id="selected_adherence_day" value="<?php print($adherence_day);?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;margin-left:5px;">Month:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#adherence_month_menu').toggle('fast');$('#adherence_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_adherence_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($adherence_month_title);?></div>


<div class="option_menu" id="adherence_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#adherence_month_menu').toggle('fast');$('#active_adherence_month').html($(this).html());$('#selected_adherence_month').val(<?php print($m);?>);$('#option_347').val($('#selected_adherence_month').val()+'/'+$('#selected_adherence_day').val()+'/'+$('#selected_adherence_year').val());check_if_adherence_future()" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#adherence_month_menu').toggle('fast');$('#active_adherence_month').html($(this).html());$('#selected_adherence_month').val(<?php print($m);?>);$('#option_347').val($('#selected_adherence_month').val()+'/'+$('#selected_adherence_day').val()+'/'+$('#selected_adherence_year').val());check_if_adherence_future()" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_adherence_month" id="selected_adherence_month" value="<?php print($adherence_month);?>">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#adherence_year_menu').toggle('fast');$('#adherence_date_holder').css('border','none');$('#custom_form_error_message_<?php print($form_id);?>').slideUp('fast');" id="active_adherence_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($adherence_year_title);?></div>


<div class="option_menu" id="adherence_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#adherence_year_menu').toggle('fast');$('#active_adherence_year').html($(this).html());$('#selected_adherence_year').val(<?php print($y);?>);$('#option_347').val($('#selected_adherence_month').val()+'/'+$('#selected_adherence_day').val()+'/'+$('#selected_adherence_year').val());check_if_adherence_future()" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_adherence_year" id="selected_adherence_year" value="<?php print($adherence_year);?>">
</div>
<input type="hidden" id="option_347" value="<?php print($form_option_value[347]);?>">

<div style="width:100%;min-height:20px;float:left;line-height:20px;text-align:center;display:none;" id="adherence_date_validation_status"></div>
<input type="hidden" id="adherence_date_validation" value="0">
</div>

<script>
check_if_adherence_future();
function check_if_adherence_future(){
	var option_value = $('#option_347').val();
	
	var option_value_array = option_value.split('/');
	
	var date_array = new Array();
	var date_array = is_date_future(option_value_array[2]+'/'+option_value_array[0]+'/'+option_value_array[1]+' 00:00:00',0);
	
	if(!isNaN(date_array[1])){
		if(date_array[0]){
			$('#adherence_date_validation_status').html('Date cannot be in the future');
			$('#adherence_date_validation_status').css('color','red');
			$('#adherence_date_validation_status').slideDown('fast');
			$('#adherence_date_holder').css('border','solid 1px red');
			$('#adherence_date_validation').val(0);
			
		}else{
			$('#adherence_date_validation_status').html('Date validation passed');
			$('#adherence_date_validation_status').css('color','green');
			$('#adherence_date_validation_status').slideDown('fast');
			$('#adherence_date_holder').css('border','none');
			$('#adherence_date_validation').val(1);
			
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

<div style="width:120px;height:30px;float:left;font-weight:bold;">Agent / Mobilizer:</div>


<div style="width:250px;height:30px;float:left;<?php if($form_option_value[380]){print('display:none');}?>" id="agent_search_options"><input type="text" style="height:30px;width:65%;color:#aaa;" value="Search for mobilizer here" id="adherence_agent_search_input" onfocusout="if(this.value==''){this.value='Search for mobilizer here';this.style.color='#aaa'}" onfocus="if(this.value=='Search for mobilizer here'){this.value='';}this.style.color='#000'" onkeyup="if (event.keyCode == 13) {fetch_adherence_agent();}"><div style="width:20px;height:30px;line-height:30px;float:right;text-align:center;background-color:#ddd;margin-left:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#ddd';" onclick="$('#selected_search_agent_holder').slideDown('fast');$('#agent_search_options').slideUp('fast');">X</div><div style="width:60px;height:30px;line-height:30px;float:right;background-color:purple;text-align:center;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#ab2cab';" onmouseout="this.style.backgroundColor='purple';" onclick="fetch_adherence_agent()">Search</div>

<div style="display:none;width:250px;min-height:50px;height:auto;border:solid 1px #ccc;background-color:#fff;position:absolute;margin-top:3px;" id="adherence_agent_seach">
<div style="width:100%;height:20px;line-height:20px;text-align:center;background-color:#f0d5f0;">Agent Search Results <div style="width:20px;float:right;height:20px;line-height:20px;background-color:#eaafea;cursor:pointer;" onmouseover="this.style.backgroundColor='#e78be7';" onmouseout="this.style.backgroundColor='#eaafea';" onclick="$('#adherence_agent_seach').slideUp('fast');">X</div></div>
<div style="width:99%;max-height:200px;height:auto;float:left;padding:3px;overflow:auto;" id="adherence_agent_search_results">Searching. Wait...</div>
</div>

</div>

<?php 
if($form_option_value[380]){
	$mobilizer_id = $form_option_value[380];
	$this_mobilizer = mysqli_query($connect,"select * from users where id = $mobilizer_id")or die(mysqli_error($connect));
	$this_mobilizer_results = mysqli_fetch_array($this_mobilizer,MYSQLI_ASSOC);
	
	$mobilizer_name = $this_mobilizer_results['_name'];
}else{
	$mobilizer_name = '';
	
}
?>

<div style="width:250px;height:30px;float:left;<?php if(!$form_option_value[380]){print('display:none');}?>" id="selected_search_agent_holder"><div style="width:auto;height:30px;float:left;" id="selected_search_agent_content_holder"><?php print($mobilizer_name);?></div><div style="width:50px;height:30px;line-height:30px;float:left;text-align:center;background-color:#f9e0f9;margin-left:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#f6caf6';" onmouseout="this.style.backgroundColor='#f9e0f9';" onclick="$('#selected_search_agent_holder').slideUp('fast');$('#agent_search_options').slideDown('fast');">Change</div></div>
<input type="hidden" id="option_380" value="<?php print($form_option_value[380]);?>">

</div>



<div style="width:99.3%;height:auto;float:left;padding:2px;">
<div style="width:auto;min-height:30px;height:auto;line-height:30px;float:left;">

<div style="width:65px;height:30px;line-height:30px;float:left;font-weight:bold;">Province:</div>
<div style="width:150px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_province_<?php print($form_id);?>"></div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">District:</div>
<div style="width:170px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_district_<?php print($form_id);?>"></div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">Facility:</div>
<div style="width:120px;min-height:30px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #000;" id="client_facility_<?php print($form_id);?>"></div>

</div>


</div>

<div style="width:99.3%;height:auto;float:left;padding:2px;">
<div style="width:auto;height:auto;line-height:30px;float:left;">

<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">Name:</div>
<div style="width:190px;min-height:30px;height:auto;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_name_<?php print($form_id);?>">Francis Kasonde</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">Gender:</div>
<div style="width:90px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_gender_<?php print($form_id);?>">Rather not say</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">PrEP ID:</div>
<div style="width:60px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;"><?php print($prep_id);?></div>

</div>
</div>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;margin-top:10px;">B. STRATEGIES TO SUPPORT ADHERENCE</div>

<div style="width:100%;height:auto;line-height:30px;float:left;border:solid 1px #aaa;padding-left:2px;">
<div style="width:100%;height:40px;line-height:40px;float:left;font-weight:bold">
<div style="width:250px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;">Strategies to support adherence</div><div style="width:200px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;"><div style="width:100%;height:20px;line-height:20px;text-align:center;">Tick as appropriate</div>

<div style="width:49%;height:20px;line-height:20px;float:left;text-align:center;border-right:solid 1px #aaa;">Yes</div>
<div style="width:50%;height:20px;line-height:20px;float:right;text-align:center;">No</div>

</div>

<div style="width:365px;height:40px;line-height:40px;float:left;text-align:center;">Comment</div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">1. Reminders</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_270" <?php print($form_option_checked[270]);?> onclick="if(this.checked){$('#option_270').val(1);document.getElementById('field_270_no').checked = false;}else{$('#option_270').val('');document.getElementById('field_270_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[270]){print(' checked ');}?> id="field_270_no" onclick="if(this.checked){document.getElementById('field_270').checked = false;$('#option_270').val('');}else{document.getElementById('field_270_no').checked = true;$('#option_270').val(1);}"></div>
<input type="hidden" id="option_270" value="<?php print($form_option_value[270]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_381_text" value="<?php print($form_option_text[381]);?>" onfocusout="if(this.value==''){$('#option_381').val('');}else{$('#option_381').val(1);}"></div>
<input type="hidden" id="option_381" value="<?php print($form_option_value[381]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">2. Support Buddy</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_271" <?php print($form_option_checked[271]);?> onclick="if(this.checked){$('#option_271').val(1);document.getElementById('field_271_no').checked = false;}else{$('#option_271').val('');document.getElementById('field_271_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[271]){print(' checked ');}?> id="field_271_no" onclick="if(this.checked){document.getElementById('field_271').checked = false;$('#option_271').val('');}else{document.getElementById('field_271_no').checked = true;$('#option_271').val(1);}"></div>
<input type="hidden" id="option_271" value="<?php print($form_option_value[271]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_382_text" value="<?php print($form_option_text[382]);?>" onfocusout="if(this.value==''){$('#option_382').val('');}else{$('#option_382').val(1);}"></div>
<input type="hidden" id="option_382" value="<?php print($form_option_value[382]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">3. Taking medication with food</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_272" <?php print($form_option_checked[272]);?> onclick="if(this.checked){$('#option_272').val(1);document.getElementById('field_272_no').checked = false;}else{$('#option_272').val('');document.getElementById('field_272_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[272]){print(' checked ');}?> id="field_272_no" onclick="if(this.checked){document.getElementById('field_272').checked = false;$('#option_272').val('');}else{document.getElementById('field_272_no').checked = true;$('#option_272').val(1);}"></div>
<input type="hidden" id="option_272" value="<?php print($form_option_value[272]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_383_text" value="<?php print($form_option_text[383]);?>" onfocusout="if(this.value==''){$('#option_383').val('');}else{$('#option_383').val(1);}"></div>
<input type="hidden" id="option_383" value="<?php print($form_option_value[383]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">4. Support Group</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_274" <?php print($form_option_checked[274]);?> onclick="if(this.checked){$('#option_274').val(1);document.getElementById('field_274_no').checked = false;}else{$('#option_274').val('');document.getElementById('field_274_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[274]){print(' checked ');}?> id="field_274_no" onclick="if(this.checked){document.getElementById('field_274').checked = false;$('#option_274').val('');}else{document.getElementById('field_274_no').checked = true;$('#option_274').val(1);}"></div>
<input type="hidden" id="option_274" value="<?php print($form_option_value[274]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_385_text" value="<?php print($form_option_text[385]);?>" onfocusout="if(this.value==''){$('#option_385').val('');}else{$('#option_385').val(1);}"></div>
<input type="hidden" id="option_385" value="<?php print($form_option_value[385]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">5. Adherence Support counseling</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_275" <?php print($form_option_checked[275]);?> onclick="if(this.checked){$('#option_275').val(1);document.getElementById('field_275_no').checked = false;}else{$('#option_275').val('');document.getElementById('field_275_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[275]){print(' checked ');}?> id="field_275_no" onclick="if(this.checked){document.getElementById('field_275').checked = false;$('#option_275').val('');}else{document.getElementById('field_275_no').checked = true;$('#option_275').val(1);}"></div>
<input type="hidden" id="option_275" value="<?php print($form_option_value[275]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_386_text" value="<?php print($form_option_text[386]);?>" onfocusout="if(this.value==''){$('#option_386').val('');}else{$('#option_386').val(1);}"></div>
<input type="hidden" id="option_386" value="<?php print($form_option_value[386]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">6. Other (specify)</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_276" <?php print($form_option_checked[276]);?> onclick="if(this.checked){$('#option_276').val(1);document.getElementById('field_276_no').checked = false;}else{$('#option_276').val('');document.getElementById('field_276_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[276]){print(' checked ');}?> id="field_276_no" onclick="if(this.checked){document.getElementById('field_276').checked = false;$('#option_276').val('');}else{document.getElementById('field_276_no').checked = true;$('#option_276').val(1);}"></div>
<input type="hidden" id="option_276" value="<?php print($form_option_value[276]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_337_text" value="<?php print($form_option_text[337]);?>" onfocusout="if(this.value==''){$('#option_337').val('');}else{$('#option_337').val(1);}"></div>
<input type="hidden" id="option_337" value="<?php print($form_option_value[337]);?>">
</div>
</div>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;margin-top:10px;">C. CLIENT TRACKING STATUS</div>
<div style="width:100%;height:auto;line-height:30px;float:left;border:solid 1px #aaa;padding-left:2px;">
<div style="width:100%;height:40px;line-height:40px;float:left;font-weight:bold">
<div style="width:250px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;">Focus area</div><div style="width:200px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;"><div style="width:100%;height:20px;line-height:20px;text-align:center;">Tick as appropriate</div>

<div style="width:49%;height:20px;line-height:20px;float:left;text-align:center;border-right:solid 1px #aaa;">Yes</div>
<div style="width:50%;height:20px;line-height:20px;float:right;text-align:center;">No</div>

</div>

<div style="width:365px;height:40px;line-height:40px;float:left;text-align:center;">Reasons why did not successfully track client</div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">1. Successfully Tracked client?</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_342" <?php print($form_option_checked[342]);?> onclick="if(this.checked){$('#option_342').val(1);document.getElementById('field_342_no').checked = false;}else{$('#option_342').val('');document.getElementById('field_342_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[342]){print(' checked ');}?> id="field_342_no" onclick="if(this.checked){document.getElementById('field_342').checked = false;$('#option_342').val('');}else{document.getElementById('field_342_no').checked = true;$('#option_342').val(1);}"></div>
<input type="hidden" id="option_342" value="<?php print($form_option_value[342]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_387_text" value="<?php print($form_option_text[387]);?>" onfocusout="if(this.value==''){$('#option_387').val('');}else{$('#option_387').val(1);}"></div>
<input type="hidden" id="option_387" value="<?php print($form_option_value[387]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">2. Did not successfully track client?</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_343" <?php print($form_option_checked[343]);?> onclick="if(this.checked){$('#option_343').val(1);$('#option_344').val(1);document.getElementById('field_343_no').checked = false;}else{$('#option_343').val('');$('#option_344').val('');document.getElementById('field_343_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[343]){print(' checked ');}?> id="field_343_no" onclick="if(this.checked){document.getElementById('field_343').checked = false;$('#option_343').val('');$('#option_344').val('');}else{document.getElementById('field_343_no').checked = true;$('#option_343').val(1);$('#option_344').val(1);}"></div>
<input type="hidden" id="option_343" value="<?php print($form_option_value[343]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_344_text" value="<?php print($form_option_text[344]);?>"></div>
<input type="hidden" id="option_344" value="<?php print($form_option_value[344]);?>">
</div>

</div>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;margin-top:10px;">D. PREP ADHERENCE ASSESSMENT</div>
<div style="width:455px;height:auto;line-height:30px;float:left;border:solid 1px #aaa;padding-left:2px;">
<div style="width:100%;height:40px;line-height:40px;float:left;font-weight:bold">
<div style="width:250px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;">Focus area</div><div style="width:200px;height:40px;line-height:40px;float:left;"><div style="width:100%;height:20px;line-height:20px;text-align:center;">Tick as appropriate</div>

<div style="width:49%;height:20px;line-height:20px;float:left;text-align:center;">Yes</div>
<div style="width:50%;height:20px;line-height:20px;float:right;text-align:center;">No (Skip to E)</div>

</div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">3. Are you still taking PrEP? client?</div><div style="width:200px;height:25px;line-height:25px;float:left;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_256" <?php print($form_option_checked[256]);?> onclick="if(this.checked){$('#option_256').val(1);$('#option_258').val('');$('#option_257').val(1);document.getElementById('field_256_no').checked = false;}else{$('#option_256').val('');$('#option_258').val(1);$('#option_257').val('');document.getElementById('field_256_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[256]){print(' checked ');}?> id="field_256_no" onclick="if(this.checked){document.getElementById('field_256').checked = false;$('#option_256').val('');$('#option_258').val(1);$('#option_257').val('');}else{document.getElementById('field_256_no').checked = true;$('#option_256').val(1);$('#option_258').val('');$('#option_257').val(1);}"></div>
<input type="hidden" id="option_256" value="<?php print($form_option_value[256]);?>">
<input type="hidden" id="option_258" value="<?php print($form_option_value[258]);?>">
</div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">4. Reason still taking PrEP medication </div>

<div style="width:204px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;" id="option_257_text" value="<?php print($form_option_text[257]);?>"></div>
<input type="hidden" id="option_257" value="<?php print($form_option_value[257]);?>">
</div>

</div>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;margin-top:10px;">E. REASONS WHY CLIENT STOPPED TAKING PREP</div>
<div style="width:365px;;height:auto;line-height:30px;float:left;border:solid 1px #aaa;padding-left:2px;">
<div style="width:100%;height:40px;line-height:40px;float:left;font-weight:bold">
<div style="width:250px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;">Reason</div><div style="width:110px;height:40px;line-height:40px;float:left;"><div style="width:100%;height:20px;line-height:20px;text-align:center;">Tick applicable</div></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">1. No longer at risk</div><div
 style="width:100px;height:25px;line-height:25px;float:left;text-align:center;"><input type="checkbox" onclick="if(this.checked){$('#option_277').val(1);}else{$('#option_277').val('');}" <?php print($form_option_checked[277]);?>></div><input type="hidden" id="option_277" value="<?php print($form_option_value[277]);?>"></div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">2. Sero-converted (HIV positive)</div><div
 style="width:100px;height:25px;line-height:25px;float:left;text-align:center;"><input type="checkbox" onclick="if(this.checked){$('#option_278').val(1);}else{$('#option_278').val('');}" <?php print($form_option_checked[278]);?>></div><input type="hidden" id="option_278" value="<?php print($form_option_value[278]);?>"></div>
 
 <div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">3. Side effects (*Complete F)</div><div
 style="width:100px;height:25px;line-height:25px;float:left;text-align:center;"><input type="checkbox" onclick="if(this.checked){$('#option_280').val(1);}else{$('#option_280').val('');}" <?php print($form_option_checked[280]);?>></div><input type="hidden" id="option_280" value="<?php print($form_option_value[280]);?>"></div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">4. Pill burden</div><div
 style="width:100px;height:25px;line-height:25px;float:left;text-align:center;"><input type="checkbox" onclick="if(this.checked){$('#option_281').val(1);}else{$('#option_281').val('');}" <?php print($form_option_checked[281]);?>></div><input type="hidden" id="option_281" value="<?php print($form_option_value[281]);?>"></div>
 
 <div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">5. Lack of support (family; partner)</div><div
 style="width:100px;height:25px;line-height:25px;float:left;text-align:center;"><input type="checkbox" onclick="if(this.checked){$('#option_282').val(1);}else{$('#option_282').val('');}" <?php print($form_option_checked[282]);?>></div><input type="hidden" id="option_282" value="<?php print($form_option_value[282]);?>"></div>
 
 <div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">6. Forgetfulness</div><div
 style="width:100px;height:25px;line-height:25px;float:left;text-align:center;"><input type="checkbox" onclick="if(this.checked){$('#option_388').val(1);}else{$('#option_388').val('');}" <?php print($form_option_checked[388]);?>></div><input type="hidden" id="option_388" value="<?php print($form_option_value[388]);?>"></div>
 
  <div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">7. Travel</div><div
 style="width:100px;height:25px;line-height:25px;float:left;text-align:center;"><input type="checkbox" onclick="if(this.checked){$('#option_283').val(1);}else{$('#option_283').val('');}" <?php print($form_option_checked[283]);?>></div><input type="hidden" id="option_283" value="<?php print($form_option_value[283]);?>"></div>
 
 

 
    <div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:100px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">8. Other</div>

<div
 style="width:264px;height:25px;line-height:25px;float:left;text-align:center;"><input type="text" style="width:100%;height:24px;" id="option_338_text" value="<?php print($form_option_text[338]);?>" onfocusout="if(this.value==''){$('#option_284').val('');$('#option_338').val('');}else{$('#option_284').val(1);$('#option_338').val(1);}"></div>
 
 <input type="hidden" id="option_284" value="<?php print($form_option_value[284]);?>">
 <input type="hidden" id="option_338" value="<?php print($form_option_value[338]);?>">
</div>


</div>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;margin-top:10px;">F. EXPERIENCE WITH SIDE EFFECTS</div>
<div style="width:100%;height:auto;line-height:30px;float:left;border:solid 1px #aaa;padding-left:2px;">
<div style="width:100%;height:40px;line-height:40px;float:left;font-weight:bold">
<div style="width:250px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;">Experience with side effects</div><div style="width:200px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;"><div style="width:100%;height:20px;line-height:20px;text-align:center;">Tick as appropriate</div>

<div style="width:49%;height:20px;line-height:20px;float:left;text-align:center;border-right:solid 1px #aaa;">Yes</div>
<div style="width:50%;height:20px;line-height:20px;float:right;text-align:center;">No</div>

</div>

<div style="width:365px;height:40px;line-height:40px;float:left;text-align:center;">Duration / Comment as appropriate</div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">1. No Side Effects</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_259" <?php print($form_option_checked[259]);?> onclick="if(this.checked){$('#option_259').val(1);document.getElementById('field_259_no').checked = false;}else{$('#option_259').val('');document.getElementById('field_259_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[259]){print(' checked ');}?> id="field_259_no" onclick="if(this.checked){document.getElementById('field_259').checked = false;$('#option_259').val('');}else{document.getElementById('field_259_no').checked = true;$('#option_259').val(1);}"></div>
<input type="hidden" id="option_259" value="<?php print($form_option_value[259]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_389_text" value="<?php print($form_option_text[389]);?>" onfocusout="if(this.value==''){$('#option_389').val('');}else{$('#option_389').val(1);}"></div>
<input type="hidden" id="option_389" value="<?php print($form_option_value[389]);?>">
</div>


<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">2. Nausea</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_260" <?php print($form_option_checked[260]);?> onclick="if(this.checked){$('#option_260').val(1);document.getElementById('field_260_no').checked = false;}else{$('#option_260').val('');document.getElementById('field_260_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[260]){print(' checked ');}?> id="field_260_no" onclick="if(this.checked){document.getElementById('field_260').checked = false;$('#option_260').val('');}else{document.getElementById('field_260_no').checked = true;$('#option_260').val(1);}"></div>
<input type="hidden" id="option_260" value="<?php print($form_option_value[260]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_261_text" value="<?php print($form_option_text[261]);?>" onfocusout="if(this.value==''){$('#option_261').val('');}else{$('#option_261').val(1);}"></div>
<input type="hidden" id="option_261" value="<?php print($form_option_value[261]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">3. Diarrhea</div><div style="width:200px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">
<div style="width:49%;height:25px;line-height:25px;float:left;text-align:center;border-right:solid 1px #aaa;"><input type="checkbox" id="field_264" <?php print($form_option_checked[264]);?> onclick="if(this.checked){$('#option_264').val(1);document.getElementById('field_264_no').checked = false;}else{$('#option_264').val('');document.getElementById('field_264_no').checked = true;}"></div>
<div style="width:50%;height:25px;line-height:25px;float:right;text-align:center;"><input type="checkbox" <?php if(!$form_option_value[264]){print(' checked ');}?> id="field_264_no" onclick="if(this.checked){document.getElementById('field_264').checked = false;$('#option_264').val('');}else{document.getElementById('field_264_no').checked = true;$('#option_264').val(1);}"></div>
<input type="hidden" id="option_264" value="<?php print($form_option_value[264]);?>">
</div>

<div style="width:369px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;border:solid 1px #a" id="option_265_text" value="<?php print($form_option_text[265]);?>" onfocusout="if(this.value==''){$('#option_265').val('');}else{$('#option_265').val(1);}"></div>
<input type="hidden" id="option_265" value="<?php print($form_option_value[265]);?>">
</div>

 

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaa;">4. Other (specify)</div>

<div style="width:569px;height:25px;line-height:25px;float:left;"><input type="text" style="width:100%;height:24px;" id="option_266_text" value="<?php print($form_option_text[266]);?>" onfocusout="if(this.value==''){$('#option_267').val('');$('#option_266').val('');}else{$('#option_267').val(1);$('#option_266').val(1);}"></div>

<input type="hidden" id="option_267" value="<?php print($form_option_value[267]);?>">
 <input type="hidden" id="option_266" value="<?php print($form_option_value[266]);?>">
</div>

</div>

<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;margin-top:10px;">G. ADDITIONAL SAFER SEX OPTIONS (ALL CLIENTS)</div>
<div style="width:100px;height:222px;float:left;border:solid 1px #aaa;border-right:none;text-align:center;line-height:20px;">Discuss additional safer sex options with clients, regardless of whether they have stopped PrEP or not</div>
<div style="width:410px;height:auto;line-height:30px;float:left;border:solid 1px #aaa;padding-left:2px;">




<div style="width:100%;height:40px;line-height:40px;float:left;font-weight:bold">
<div style="width:250px;height:40px;line-height:40px;float:left;border-right:solid 1px #aaa;">Options</div><div style="width:150px;height:40px;line-height:40px;float:left;"><div style="width:100%;height:20px;line-height:20px;text-align:center;">Tick what is discussed</div>

</div>
</div> 
 
<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">1. Condom negotiation and use</div><div style="width:150px;height:25px;line-height:25px;float:left;text-align:center;">
<input type="checkbox" onclick="if(this.checked){$('#option_285').val(1);}else{$('#option_285').val('');}" <?php print($form_option_checked[285]);?>><input type="hidden" id="option_285" value="<?php print($form_option_value[285]);?>"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">2. VMMC</div><div style="width:150px;height:25px;line-height:25px;float:left;text-align:center;">
<input type="checkbox" onclick="if(this.checked){$('#option_286').val(1);}else{$('#option_286').val('');}" <?php print($form_option_checked[286]);?>><input type="hidden" id="option_286" value="<?php print($form_option_value[286]);?>"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">3. Regular HIV/ STI Testing</div><div style="width:150px;height:25px;line-height:25px;float:left;text-align:center;">
<input type="checkbox" onclick="if(this.checked){$('#option_287').val(1);}else{$('#option_287').val('');}" <?php print($form_option_checked[287]);?>><input type="hidden" id="option_287" value="<?php print($form_option_value[287]);?>"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">4. Abstinence</div><div style="width:150px;height:25px;line-height:25px;float:left;text-align:center;">
<input type="checkbox" onclick="if(this.checked){$('#option_288').val(1);}else{$('#option_288').val('');}" <?php print($form_option_checked[288]);?>><input type="hidden" id="option_288" value="<?php print($form_option_value[288]);?>"></div>
</div>


<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:130px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">5. Other (Specify)</div><div style="width:278px;height:25px;line-height:25px;float:left;text-align:center;"><input type="text" style="width:100%;height:24px;"  id="option_339_text" value="<?php print($form_option_text[339]);?>" onfocusout="if(this.value==''){$('#option_289').val('');$('#option_339').val('');}else{$('#option_289').val(1);$('#option_339').val(1);}"></div>


<input type="hidden" id="option_289" value="<?php print($form_option_value[289]);?>">
 <input type="hidden" id="option_339" value="<?php print($form_option_value[339]);?>">
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<div style="width:250px;height:25px;line-height:25px;float:left;border-right:solid 1px #aaaa;">6. None</div><div style="width:150px;height:25px;line-height:25px;float:left;text-align:center;">
<input type="checkbox"></div>
</div>

<div style="width:100%;height:25px;line-height:25px;float:left;border-top:solid 1px #aaa;">
<i>* If none, discuss HIV prevention methods including restarting PrEP</i>
</div>

</div>
<div style="width:510px;height:25px;line-height:25px;float:left;">
<i>*Motivate client to have an action plan for adherence or sustaining HIV prevention
*Supportive environment; encourage client to identify a support system including joining USAID DISCOVER-Health support
</i>
</div>
</div>
</div>

<script>
fetch_basic_details(<?php print($form_id);?>);

$('#client_province_<?php print($form_id);?>').html($('#active_client_province').html());
$('#client_district_<?php print($form_id);?>').html($('#active_client_hub').html());
$('#client_facility_<?php print($form_id);?>').html($('#active_client_site').html());

</script>