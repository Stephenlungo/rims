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

<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;font-weight:bold;font-size:1.1em;margin-bottom:10px;"><div style="width:300px;height:30px;margin:0 auto;border:solid 1px #999;border-radius:15px;">PRE-EXPOSURE PROPHYLAXIS INITIAL</div></div>


<div style="width:99.3%;height:auto;float:left;padding:2px;">
	<div style="width:auto;min-height:30px;height:auto;line-height:30px;float:left;">

		<div style="width:65px;height:30px;line-height:30px;float:left;font-weight:bold;">Province:</div>
		<div style="width:130px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_province_<?php print($form_id);?>">Copperbelt</div>

		<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">District:</div>
		<div style="width:150px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="client_district_<?php print($form_id);?>">Kitwe</div>

		<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">Facility:</div>
		<div style="width:120px;min-height:30px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #000;" id="client_facility_<?php print($form_id);?>">Buzakile Main Hospital</div>

	</div>

<div style="width:290px;min-height:30px;height:auto;float:right;" id="initiation_date_holder">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;">Date:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:45px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[340] == ''){
	$initiation_date = 0;
	
	$initiation_day = 0;
	$initiation_month = 0;
	$initiation_year = 0;
	
	$initiation_day_title = 'Select';
	$initiation_month_title = 'Select';
	$initiation_year_title = 'Select';
	
}else{
	$initiation_date = $form_option_value[340];
	
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

</div>





<script>

function check_if_pharmacy_future(){
	var option_value = $('#option_222').val();
	var initiation_value = $('#option_340').val();
	
	var option_value_array = option_value.split('/');
	var initiation_value_array = initiation_value.split('/');
	
	var date_array = new Array();
	var date_array = is_date_future(initiation_value_array[2]+'/'+initiation_value_array[0]+'/'+initiation_value_array[1]+' 00:00:00',option_value_array[2]+'/'+option_value_array[0]+'/'+option_value_array[1]+' 00:00:00');
	
	if(!isNaN(date_array[1])){
		if(date_array[0]){
			$('#pharmacy_date_validation_status').html('Pharmacy date is before initiation date');
			$('#pharmacy_date_validation_status').css('color','red');
			$('#pharmacy_date_validation_status').slideDown('fast');
			$('#pharmacy_date_holder').css('border','solid 1px red');
			$('#pharmacy_date_validation').val(0);
			
		}else{
			$('#pharmacy_date_validation_status').html('Pharmacy date okay');
			$('#pharmacy_date_validation_status').css('color','green');
			$('#pharmacy_date_validation_status').slideDown('fast');
			$('#pharmacy_date_holder').css('border','none');
			$('#pharmacy_date_validation').val(1);
			
		}
	}
}

function check_if_clinical_future(){
	var option_value = $('#option_221').val();
	var initiation_value = $('#option_340').val();
	
	var option_value_array = option_value.split('/');
	var initiation_value_array = initiation_value.split('/');
	
	var date_array = new Array();
	var date_array = is_date_future(initiation_value_array[2]+'/'+initiation_value_array[0]+'/'+initiation_value_array[1]+' 00:00:00',option_value_array[2]+'/'+option_value_array[0]+'/'+option_value_array[1]+' 00:00:00');
	
	if(!isNaN(date_array[1])){
		if(date_array[0]){
			$('#clinical_date_validation_status').html('Clinical date is before initiation date');
			$('#clinical_date_validation_status').css('color','red');
			$('#clinical_date_validation_status').slideDown('fast');
			$('#clinical_date_holder').css('border','solid 1px red');
			$('#clinical_date_validation').val(0);
			
		}else{
			$('#clinical_date_validation_status').html('Clinical date okay');
			$('#clinical_date_validation_status').css('color','green');
			$('#clinical_date_validation_status').slideDown('fast');
			$('#clinical_date_holder').css('border','none');
			$('#clinical_date_validation').val(1);
		}
	}
}


check_if_initiation_future();
function check_if_initiation_future(){
	var option_value = $('#option_340').val();
	
	var option_value_array = option_value.split('/');
	var date_array = new Array();
	var date_array = is_date_future(option_value_array[2]+'/'+option_value_array[0]+'/'+option_value_array[1]+' 00:00:00',0);
	
	if(!isNaN(date_array[1])){
		if(date_array[0]){
			$('#initiation_date_validation_status').html('Initiation date is in the future');
			$('#initiation_date_validation_status').css('color','red');
			$('#initiation_date_validation_status').slideDown('fast');
			$('#initiation_date_holder').css('border','solid 1px red');
			$('#initiation_date_validation').val(0);
			
		}else{
			$('#initiation_date_validation_status').html('Initiation date okay');
			$('#initiation_date_validation_status').css('color','green');
			$('#initiation_date_validation_status').slideDown('fast');
			$('#initiation_date_holder').css('border','none');
			$('#initiation_date_validation').val(1);
			
		}
	}
	
	check_if_pharmacy_future();
	check_if_clinical_future();
}

</script>











<div style="width:99.3%;height:auto;float:left;padding:2px;">
<div style="width:auto;height:auto;line-height:30px;float:left;">

<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">Name:</div>
<div style="width:190px;min-height:30px;height:auto;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_name_<?php print($form_id);?>">Francis Kasonde</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">Gender:</div>
<div style="width:90px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;" id="form_client_gender_<?php print($form_id);?>">Rather not say</div>

<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;font-weight:bold;">PrEP ID:</div>
<div style="width:60px;height:30px;line-height:30px;float:left;border-bottom:solid 1px #000;"><?php print($prep_id);?></div>

</div>

<div style="width:270px;height:30px;float:right;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;">DOB:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">
<?php
if($form_option_value[346] == ''){
	$dob_date = date('m/j/Y',time());
	
}else{
	$dob_date = $form_option_value[346];
	
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

<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
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

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;">

<script>
$('#active_dob_initiation_year').html(<?php print(date('Y',time()));?> - $('#client_age').val());
$('#selected_dob_initiation_year').val(<?php print(date('Y',time()));?> - $('#client_age').val());

$('#option_346').val($('#selected_dob_initiation_month').val()+'/'+$('#selected_dob_initiation_day').val()+'/'+$('#selected_dob_initiation_year').val());

</script>

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
</div>

<div style="width:99.5%;height:auto;float:left;border: solid 1px #000;margin-top:5px;font-size:0.9em;">
<div style="width:100%;height:auto;float:left;font-size:0.98em;">
<div style="width:99%;float:left;height:auto;">
<div style="width:100%;height:25px;line-height:25px;float:left;padding-left:10px;font-weight:bold;">Screening for Substantial Risk for HIV Infection</div>
</div>

<div style="width:98.85%;height:30px;line-height:30px;float:left;padding-left:10px;font-weight:bold;background-color:#ddd;border-top:solid 1px #000;">Category / Question</div>


<div style="width:99.9%;float:left;height:auto;border-top:solid 1px #000;padding-bottom:7px;">
<div style="width:53%;height:25px;line-height:25px;float:left;font-weight:bold;padding-left:2px;">1) Currently sexually active AND report any of the below in the last six months</div>

<div style="width:45%;height:25px;line-height:25px;float:right;">Have you been sexually active in the last six months? <input type="radio" name="sexualy_active" id="field_357" <?php print($form_option_checked[357]);?> onclick="$('#option_357').val(1);"><label for="field_357">Yes</label> <input type="radio" name="sexualy_active" id="not_sexualy_active" onclick="$('#option_357').val('');document.getElementById('field_358').checked = false;$('#option_358').val('');document.getElementById('field_359').checked = false;$('#option_359').val('');document.getElementById('field_360').checked = false;$('#option_360').val('');document.getElementById('field_361').checked = false;$('#option_361').val('');document.getElementById('no_condom').checked = false;"><label for="not_sexualy_active">No</label></div>

<input type="hidden" id="option_357" value="<?php print($form_option_value[357]);?>">

<div style="width:100%;height:20px;line-height:20px;float:left;">
<input <?php print($form_option_checked[358]);?> type="checkbox" id="field_358" onchange="if(this.checked){$('#option_358').val(1);$('#field_357').click();$('#field_360').click();}else{$('#option_358').val('');$('#field_359').click();}"><label for="field_358">Has had vaginal or anal intercourse without condoms with more than one partner</label>
<input type="hidden" id="option_358" value="<?php print($form_option_value[358]);?>">
</div>

<div style="width:80%;height:20px;line-height:20px;float:left;margin-left:30px;" id="number_client_has_sex_with">
With how may people did you have vaginal or anal sex in the last six months <input <?php print($form_option_checked[359]);?> type="radio" id="field_359" name="number_of_people_had_sex_with" onclick="$('#option_359').val(1);$('#option_360').val('');$('#field_357').click();document.getElementById('field_358').checked = false;$('#option_358').val('');"><label for="field_359">1</label> <input <?php print($form_option_checked[360]);?> type="radio" id="field_360" name="number_of_people_had_sex_with" onclick="$('#option_359').val('');$('#option_360').val(1);$('#field_357').click();document.getElementById('field_358').checked = true;$('#option_358').val(1);"><label for="field_360">2 or more</label>

<input type="hidden" id="option_359" value="<?php print($form_option_value[359]);?>">
<input type="hidden" id="option_360" value="<?php print($form_option_value[360]);?>">
</div>

<div style="width:80%;height:20px;line-height:20px;float:left;margin-left:30px;" id="number_client_use_condoms">
Did you use condoms constantly in the last six months <input <?php print($form_option_checked[361]);?> type="radio" id="field_361" name="used_condoms" onclick="$('#option_361').val(1);$('#field_357').click();"><label for="field_361">Yes </label><input type="radio" id="no_condom" name="used_condoms" onclick="$('#option_361').val('');"><label for="no_condom">No</label>

<input type="hidden" value="<?php print($form_option_value[361]);?>" id="option_361">
</div>
</div>

<div style="width:99.9%;float:left;height:auto;border-top:solid 1px #000;padding-bottom:5px;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input <?php print($form_option_checked[362]);?> type="checkbox" id="field_362" onchange="if(this.checked){$('#option_362').val(1);}else{$('#option_362').val('');disable_risky_field_options();}"><label for="field_362" id="sex_with_risky_partner">Has a current sex partner with one or more HIV risk</label>
<input type="hidden" id="option_362" value="<?php print($form_option_value[362]);?>">
</div>

<div style="width:98%;min-height:20px;height:auto;line-height:20px;float:left;margin-left:20px;">
Have you had a sex partner in the last six months who: 
- Is living with HIV?<input <?php print($form_option_checked[363]);?> type="radio" id="field_363" name="living_with_hiv" onclick="$('#option_363').val(1);document.getElementById('field_362').checked = true;$('#option_362').val(1);"><label for="field_363">Yes </label><input type="radio" name="living_with_hiv" id="not_living_with_hiv" onclick="$('#option_363').val('');"> <label for="not_living_with_hiv">No </label>
<input type="hidden" id="option_363" value="<?php print($form_option_value[363]);?>">

- Injects drags?<input <?php print($form_option_checked[364]);?> type="radio" id="field_364" name="injects_drags" onclick="$('#option_364').val(1);document.getElementById('field_362').checked = true;$('#option_362').val(1);"><label for="field_364">Yes</label> <input type="radio" name="injects_drags" id="does_not_inject_drags" onclick="$('#option_364').val('');"><label for="does_not_inject_drags">No</label>
<input type="hidden" id="option_364" value="<?php print($form_option_checked[364]);?>">

- Is a sex worker?<input <?php print($form_option_checked[365]);?> type="radio" id="field_365" name="is_asex_work" onclick="$('#option_365').val(1);document.getElementById('field_362').checked = true;$('#option_362').val(1);"><label for="field_365">Yes </label><input type="radio" id="not_a_sex_worker" name="is_asex_work" onclick="$('#option_365').val('');"><label for="not_a_sex_worker">No</label><br>
<input type="hidden" value="<?php print($form_option_value[365]);?>" id="option_365">

- Is a man who has sex with men?<input <?php print($form_option_checked[366]);?> type="radio" name="msm" id="field_366" onclick="$('#option_366').val(1);document.getElementById('field_362').checked = true;$('#option_362').val(1);"><label for="field_366" >Yes </label><input type="radio" name="msm" id="not_msm" onclick="$('#option_366').val('');"><label for="not_msm">No</label>
<input type="hidden" id="option_366" value="<?php print($form_option_value[366]);?>">

- Is a transgender?<input <?php print($form_option_checked[367]);?> type="radio" name="transgender" id="field_367" onclick="$('#option_367').val(1);document.getElementById('field_362').checked = true;$('#option_362').val(1);"><label for="field_367">Yes </label><input type="radio" name="transgender" id="not_transgender" onclick="$('#option_367').val('');"><label for="not_transgender">No</label>
<input type="hidden" id="option_367" value="<?php print($form_option_value[367]);?>">

- Has sex with multiple partners without using condom?<input <?php print($form_option_checked[368]);?> type="radio" id="field_368" name="multiple_partners" onclick="$('#option_368').val(1);document.getElementById('field_362').checked = true;$('#option_362').val(1);"><label for="field_368">Yes </label><input type="radio" name="multiple_partners" id="not_multiple_partners" onclick="$('#option_368').val('');"><label for="not_multiple_partners">No</label>
<input type="hidden" id="option_368" value="<?php print($form_option_value[368]);?>">
</div>

<script>
function disable_risky_field_options(){
	document.getElementById('field_363').checked = false;
	document.getElementById('not_living_with_hiv').checked = false;
	$('#option_363').val('');
	
	document.getElementById('field_364').checked = false;
	document.getElementById('does_not_inject_drags').checked = false;
	$('#option_364').val('');
	
	document.getElementById('field_365').checked = false;
	document.getElementById('not_a_sex_worker').checked = false;
	$('#option_365').val('');
	
	document.getElementById('field_366').checked = false;
	document.getElementById('not_msm').checked = false;
	$('#option_366').val('');
	
	document.getElementById('field_367').checked = false;
	document.getElementById('not_transgender').checked = false;
	$('#option_367').val('');
	
	document.getElementById('field_368').checked = false;
	document.getElementById('not_multiple_partners').checked = false;
	$('#option_368').val('');
}
</script>

</div>

<div style="width:99.9%;float:left;height:auto;border-top:solid 1px #000;padding-bottom:5px;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input <?php print($form_option_checked[369]);?> type="checkbox" id="field_369" onclick="if(this.checked){document.getElementById('field_369_mirror_true').checked = true;document.getElementById('field_369_mirror_false').checked = false;}else{document.getElementById('field_369_mirror_true').checked = false;document.getElementById('field_369_mirror_false').checked = true;}" onchange="if(this.checked){$('#option_369').val(1);}else{$('#option_369').val('');}"><label for="field_369">Has a sexually transmitted infection (STI) (based on self-report, lab test, syndromic STI treatment) in the last six months</label> <input type="radio" onclick="if(document.getElementById('field_369').checked == false){document.getElementById('field_369').checked = true;$('#option_369').val(1);}" id="field_369_mirror_true" name="has_sexualy_transmitted_infectin"><label for="field_369_mirror_true" >Yes </label><input type="radio" onclick="if(document.getElementById('field_369').checked == true){document.getElementById('field_369').checked = false;$('#option_369').val('');}" id="field_369_mirror_false" name="has_sexualy_transmitted_infectin"><label for="field_369_mirror_false" >No</label>
</div>
</div>
<input type="hidden" id="option_369" value="<?php print($form_option_value[369]);?>">

<div style="width:99.9%;float:left;height:auto;border-top:solid 1px #000;padding-bottom:5px;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<input <?php print($form_option_checked[370]);?> type="checkbox" id="field_370" onclick="if(this.checked){document.getElementById('field_370_mirror_true').checked = true;document.getElementById('field_370_mirror_false').checked = false;}else{document.getElementById('field_370_mirror_true').checked = false;document.getElementById('field_370_mirror_false').checked = true;}" onchange="if(this.checked){$('#option_370').val(1);}else{$('#option_370').val('');}"><label for="field_370">Has used post-exposure prophylaxis (PEP) following a potential exposure to HIV in the last six months</label> <input type="radio" onclick="if(document.getElementById('field_370').checked == false){document.getElementById('field_370').checked = true;$('#option_370').val(1);}" id="field_370_mirror_true" name="has_used_pep"><label for="field_370_mirror_true" >Yes </label><input type="radio" onclick="if(document.getElementById('field_370').checked == true){document.getElementById('field_370').checked = false;$('#option_370').val('');}" id="field_370_mirror_false" name="has_used_pep"><label for="field_370_mirror_false" >No</label>
</div>
</div>
<input type="hidden" id="option_370" value="<?php print($form_option_value[370]);?>">

<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;padding-bottom:5px;">
<div style="width:100%;height:20px;line-height:20px;float:left;">
<strong>2) Has shared injection material / equipment with other people in the last six months</strong> <input <?php print($form_option_checked[371]);?> type="radio" id="field_371" name="shared_injection_materials" onclick="$('#option_371').val(1);"><label for="field_371">Yes</label> <input type="radio" name="shared_injection_materials" id="no_injection_material" onclick="$('#option_371').val('');"><label for="no_injection_material">No</label>
<input type="hidden" id="option_371" value="<?php print($form_option_value[371]);?>">
</div>
</div>


<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;padding-bottom:5px;">
	<div style="width:100%;height:20px;line-height:20px;float:left;">
	<strong id="partner_hiv_treatment">3) Has had a sexual partner in the last six months who is HIV positive and who has not been on effective* HIV treatment</strong>
	</div>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;margin-left:30px;"><i>*If partner has been on ART for less than six months, or has inconsistent or unknown adherence</i></div>
	<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;margin-left:60px;">
	Is your partner HIV infected<input <?php print($form_option_checked[372]);?> type="radio" name="partner_hiv_status" id="field_372" onclick="check_infected_status(372)"><label for="field_372">Yes </label><input name="partner_hiv_status" type="radio" id="partner_not_infected" onclick="check_infected_status(0)"><label for="partner_not_infected">No</label>
	<input <?php print($form_option_value[373]);?> name="partner_hiv_status" type="radio" id="field_373" onclick="check_infected_status(373)"><label for="field_373">Don't know </label><br>
	<input type="hidden" id="option_372" value="<?php print($form_option_value[372]);?>">
	<input type="hidden" id="option_373" value="<?php print($form_option_value[373]);?>">
	
	Is she/he on ART<input <?php print($form_option_checked[374]);?> type="radio" name="partner_on_art" id="field_374" onclick="check_art_status(374)"><label for="field_374">Yes </label><input name="partner_on_art" type="radio" id="partner_not_on_art" onclick="check_art_status(0)"><label for="partner_not_on_art">No</label>
	<input <?php print($form_option_value[375]);?> name="partner_on_art" type="radio" id="field_375" onclick="check_art_status(376)"><label for="field_375">Don't know </label><br>
	<input type="hidden" id="option_374" value="<?php print($form_option_value[374]);?>">
	<input type="hidden" id="option_375" value="<?php print($form_option_value[375]);?>">
	
	What was the last viral load result?<input <?php print($form_option_checked[376]);?> type="radio" name="partner_on_viral_sup" id="field_376" onclick="check_vl_result_status(376)"><label for="field_376">Yes </label><input name="partner_on_viral_sup" type="radio" id="partner_not_on_viral_sup" onclick="check_vl_result_status(0)"><label for="partner_not_on_viral_sup">No</label>
	<input <?php print($form_option_value[377]);?> name="partner_on_viral_sup" type="radio" id="field_377" onclick="check_vl_result_status(377)"><label for="field_377">Don't know </label><br>
	<input type="hidden" id="option_376" value="<?php print($form_option_value[376]);?>">
	<input type="hidden" id="option_377" value="<?php print($form_option_value[377]);?>">
	
	<script>
	function check_infected_status(entry_id){			
		$('#option_372').val('');
		$('#option_373').val('');
			
		if(entry_id){
			$('#option_'+entry_id).val(1);
		}
	}
	
	
	function check_art_status(entry_id){			
		$('#option_374').val('');
		$('#option_375').val('');
			
		if(entry_id){
			$('#option_'+entry_id).val(1);
		}
	}
	
	function check_vl_result_status(entry_id){			
		$('#option_376').val('');
		$('#option_377').val('');
			
		if(entry_id){
			$('#option_'+entry_id).val(1);
		}
	}
	</script>
	
	</div>
</div>
</div>
<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:250px;height:200px;float:left;border-right:solid 1px #000;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">STI SCREENING</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Urethral / Vaginal discharge</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[131]);?> type="radio" id="field_131" onclick="$('#option_131').val(1);" name="urethral_discharge"><label for="field_131">Yes </label><input type="radio" onclick="$('#option_131').val('');" name="urethral_discharge" id="urethral_discharge"><label for="urethral_discharge">No</label></div></div>
<input type="hidden" value="<?php print($form_option_value[131]);?>" id="option_131">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Lower abdomen pain</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[132]);?> type="radio" id="field_132" onclick="$('#option_132').val(1);" name="abdominal_pains"><label for="field_132">Yes </label><input type="radio" onclick="$('#option_132').val('');" name="abdominal_pains" id="abdominal_pains"><label for="abdominal_pains">No</label></div></div>
<input type="hidden" value="<?php print($form_option_value[132]);?>" id="option_132">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Genital Sores</div><div style="width:40%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[133]);?> id="field_133" onclick="$('#option_133').val(1);" name="genital_sores"><label for="field_133">Yes </label><input type="radio" onclick="$('#option_133').val('');" name="genital_sores" id="genital_sores"><label for="genital_sores">No</label></div></div>
<input type="hidden" value="<?php print($form_option_value[133]);?>" id="option_133">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">LN Swelling</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[134]);?> type="radio" id="field_134" onclick="$('#option_134').val(1);" name="ln_swelling"><label for="field_134">Yes </label><input type="radio" onclick="$('#option_134').val('');" name="ln_swelling" id="ln_swelling"><label for="ln_swelling">No</label></div></div>
<input type="hidden" value="<?php print($form_option_value[134]);?>" id="option_134">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Genital Pain/Itching</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[135]);?> type="radio" id="field_135" onclick="$('#option_135').val(1);" name="genital_pain"><label for="field_135">Yes </label><input type="radio" onclick="$('#option_135').val('');" name="genital_pain" id="genital_pain"><label for="genital_pain">No</label></div></div>
<input type="hidden" value="<?php print($form_option_value[135]);?>" id="option_135">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><i>If yes, follow syndromic management for treatment</i></div>
</div>



<div style="width:235px;height:200px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">OBSTETRIC HISTORY</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Are you currently pregnant?</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[136]);?> type="radio" id="field_136" name="pregnant" onclick="$('#option_136').val(1);calculate_edd();"><label for="field_136">Yes </label><input type="radio" id="pregnant" name="pregnant" onclick="$('#option_136').val('');$('#active_edd_initiation_day').html('N/A');$('#active_edd_initiation_month').html('N/A');$('#active_edd_initiation_year').html('N/A');$('#option_138').val('');"><label for="pregnant">No</div></div>

<input type="hidden" id="option_136" value="<?php print($form_option_value[136]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<div style="width:auto;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:30px;">LMP:</div>
<div style="line-height:30px;width:10px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<?php
if($form_option_value[137] == ''){
	$lmp_date = '';
	$lmp_day = date('j',time());;
	$lmp_month = date('m',time());
	$lmp_year = date('Y',time());
	
	$lmp_day_title = 'N/A';
	$lmp_month_title = 'N/A';
	$lmp_year_title = 'N/A';
	
}else{
	$lmp_date = $form_option_value[137];
	
	$lmp_date_array = explode('/',$lmp_date);
	$lmp_day = $lmp_date_array[1];
	$lmp_month = $lmp_date_array[0];
	$lmp_year = $lmp_date_array[2];
	
	$lmp_day_title = $lmp_day;
	$lmp_month_title = $lmp_month;
	$lmp_year_title = $lmp_year;
}
?>


<div class="option_item" title="Click to change option" onclick="$('#initiation_lmp_day_menu').toggle('fast');" id="active_lmp_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($lmp_day_title);?></div>

<div class="option_menu" id="initiation_lmp_day_menu" style="display:none;">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_day_menu').toggle('fast');$('#active_lmp_initiation_day').html($(this).html());$('#active_lmp_initiation_month').html('N/A');$('#active_lmp_initiation_year').html('N/A');$('#option_137').val('');" style="width:40px;">N/A</div>

<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_day_menu').toggle('fast');$('#active_lmp_initiation_day').html($(this).html());$('#selected_lmp_initiation_day').val(<?php print($d);?>);$('#active_lmp_initiation_month').html($('#selected_lmp_initiation_month').val());$('#active_lmp_initiation_year').html($('#selected_lmp_initiation_year').val());$('#option_137').val($('#selected_lmp_initiation_month').val()+'/'+$('#selected_lmp_initiation_day').val()+'/'+$('#selected_lmp_initiation_year').val());if($('#option_136').val() == 1){calculate_edd()}" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_day_menu').toggle('fast');$('#active_lmp_initiation_day').html($(this).html());$('#selected_lmp_initiation_day').val(<?php print($d);?>);$('#active_lmp_initiation_month').html($('#selected_lmp_initiation_month').val());$('#active_lmp_initiation_year').html($('#selected_lmp_initiation_year').val());$('#option_137').val($('#selected_lmp_initiation_month').val()+'/'+$('#selected_lmp_initiation_day').val()+'/'+$('#selected_lmp_initiation_year').val());if($('#option_136').val() == 1){calculate_edd()}" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_lmp_initiation_day" id="selected_lmp_initiation_day" value="<?php print($lmp_day);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#initiation_lmp_month_menu').toggle('fast');" id="active_lmp_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($lmp_month_title);?></div>


<div class="option_menu" id="initiation_lmp_month_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_month_menu').toggle('fast');$('#active_lmp_initiation_day').html($(this).html());$('#active_lmp_initiation_month').html('N/A');$('#active_lmp_initiation_year').html('N/A');$('#option_137').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_month_menu').toggle('fast');$('#active_lmp_initiation_month').html($(this).html());$('#selected_lmp_initiation_month').val(<?php print($m);?>);$('#active_lmp_initiation_day').html($('#selected_lmp_initiation_day').val());$('#active_lmp_initiation_year').html($('#selected_lmp_initiation_year').val());$('#option_137').val($('#selected_lmp_initiation_month').val()+'/'+$('#selected_lmp_initiation_day').val()+'/'+$('#selected_lmp_initiation_year').val());if($('#option_136').val() == 1){calculate_edd()}" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_month_menu').toggle('fast');$('#active_lmp_initiation_month').html($(this).html());$('#selected_lmp_initiation_month').val(<?php print($m);?>);$('#active_lmp_initiation_day').html($('#selected_lmp_initiation_day').val());$('#active_lmp_initiation_year').html($('#selected_lmp_initiation_year').val());$('#option_137').val($('#selected_lmp_initiation_month').val()+'/'+$('#selected_lmp_initiation_day').val()+'/'+$('#selected_lmp_initiation_year').val());if($('#option_136').val() == 1){calculate_edd()}" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_lmp_initiation_month" value="<?php print($lmp_month);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#initiation_lmp_year_menu').toggle('fast');" id="active_lmp_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($lmp_year_title);?></div>


<div class="option_menu" id="initiation_lmp_year_menu" style="display:none;width:65px;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_year_menu').toggle('fast');$('#active_lmp_initiation_year').html($(this).html());$('#active_lmp_initiation_month').html('N/A');$('#active_lmp_initiation_day').html('N/A');$('#option_137').val('');" style="width:40px;">N/A</div>
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_lmp_year_menu').toggle('fast');$('#active_lmp_initiation_year').html($(this).html());$('#selected_lmp_initiation_year').val(<?php print($y);?>);$('#active_lmp_initiation_day').html($('#selected_lmp_initiation_day').val());$('#active_lmp_initiation_month').html($('#selected_lmp_initiation_month').val());$('#option_137').val($('#selected_lmp_initiation_month').val()+'/'+$('#selected_lmp_initiation_day').val()+'/'+$('#selected_lmp_initiation_year').val());if($('#option_136').val() == 1){calculate_edd()}" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_lmp_initiation_year" id="selected_lmp_initiation_year" value="<?php print($lmp_year);?>">
</div>
<input type="hidden" id="option_137" value="<?php print($lmp_date);?>">
</div>
</div>

<script>

function calculate_edd(){
	var lmp_day = $('#selected_lmp_initiation_day').val();
	var lmp_month = Number($('#selected_lmp_initiation_month').val());
	var lmp_year = Number($('#selected_lmp_initiation_year').val());
	
	var edd_day = lmp_day;
	var edd_month = lmp_month+9;
	
	if(edd_month > 12){
		edd_month = edd_month - 12;
		var edd_year = lmp_year+1;
		
	}else{
		var edd_year = lmp_year;
	}
	
	$('#active_edd_initiation_day').html(edd_day);
	$('#selected_edd_initiation_day').val(edd_day);
	
	$('#active_edd_initiation_month').html(edd_month);
	$('#selected_edd_initiation_month').val(edd_month);
	
	$('#active_edd_initiation_year').html(edd_year);
	$('#selected_edd_initiation_year').val(edd_year);
	
	$('#option_138').val(edd_month+'/'+edd_day+'/'+edd_year);
}

</script>


<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:auto;height:30px;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;font-weight:bold;margin-left:30px;">EDD:</div>
<div style="line-height:30px;width:10px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">

<?php
if($form_option_value[138] == ''){
	$edd_date = '';
	$edd_day = 'N/A';
	$edd_month = 'N/A';
	$edd_year = 'N/A';
	
}else{
	$edd_date = $form_option_value[138];
	
	$edd_date_array = explode('/',$edd_date);
	$edd_day = $edd_date_array[1];
	$edd_month = $edd_date_array[0];
	$edd_year = $edd_date_array[2];
}
?>

<div class="option_item" title="Click to change option" onclick="if($('#option_136').val() == ''){alert('You only change the EDD if the client is pregnant');}else{$('#initiation_edd_day_menu').toggle('fast');}" id="active_edd_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($edd_day);?></div>

<div class="option_menu" id="initiation_edd_day_menu" style="display:none;">	
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_edd_day_menu').toggle('fast');$('#active_edd_initiation_day').html($(this).html());$('#selected_edd_initiation_day').val(<?php print($d);?>);$('#option_138').val($('#selected_edd_initiation_month').val()+'/'+$('#selected_edd_initiation_day').val()+'/'+$('#selected_edd_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_edd_day_menu').toggle('fast');$('#active_edd_initiation_day').html($(this).html());$('#selected_edd_initiation_day').val(<?php print($d);?>);$('#option_138').val($('#selected_edd_initiation_month').val()+'/'+$('#selected_edd_initiation_day').val()+'/'+$('#selected_edd_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_edd_initiation_day" id="selected_edd_initiation_day" value="<?php print($edd_day);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">

<div class="option_item" title="Click to change option" onclick="if($('#option_136').val() == ''){alert('You only change the EDD if the client is pregnant');}else{$('#initiation_edd_month_menu').toggle('fast');}" id="active_edd_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($edd_month);?></div>


<div class="option_menu" id="initiation_edd_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_edd_month_menu').toggle('fast');$('#active_edd_initiation_month').html($(this).html());$('#selected_edd_initiation_month').val(<?php print($m);?>);$('#option_138').val($('#selected_edd_initiation_month').val()+'/'+$('#selected_edd_initiation_day').val()+'/'+$('#selected_edd_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_edd_month_menu').toggle('fast');$('#active_edd_initiation_month').html($(this).html());$('#selected_edd_initiation_month').val(<?php print($m);?>);$('#option_138').val($('#selected_edd_initiation_month').val()+'/'+$('#selected_edd_initiation_day').val()+'/'+$('#selected_edd_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_edd_initiation_month" value="<?php print($edd_month);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">

<div class="option_item" title="Click to change option" onclick="if($('#option_136').val() == ''){alert('You only change the EDD if the client is pregnant');}else{$('#initiation_edd_year_menu').toggle('fast');}" id="active_edd_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($edd_year);?></div>


<div class="option_menu" id="initiation_edd_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_edd_year_menu').toggle('fast');$('#active_edd_initiation_year').html($(this).html());$('#selected_edd_initiation_year').val(<?php print($y);?>);$('#option_138').val($('#selected_edd_initiation_month').val()+'/'+$('#selected_edd_initiation_day').val()+'/'+$('#selected_edd_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_edd_initiation_year" id="selected_edd_initiation_year" value="<?php print($edd_year);?>">
</div>
<input type="hidden" id="option_138" value="<?php print($edd_date);?>">
</div></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Are you currently breastfeeding?</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[139]);?> type="radio" id="field_139" name="breastfeeding" onclick="$('#option_139').val(1);"><label for="field_139">Yes </label><input type="radio" id="breastfeeding" name="breastfeeding" onclick="$('#option_139').val('');"><label for="breastfeeding">No</label></div></div>

<input type="hidden" id="option_139" value="<?php print($form_option_value[139]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:60%;min-height:20px;height:auto;float:left;">Client screen for CACX?</div><div style="width:40%;height:20px;float:right;"><input <?php print($form_option_checked[140]);?> type="radio" name="cacx" id="field_140" onclick="$('#option_140').val(1);"><label for="field_140">Yes </label><input type="radio" id="cacx" name="cacx" onclick="$('#option_140').val('');"><label for="cacx">No</label></div></div>

<input type="hidden" id="option_140" value="<?php print($form_option_value[140]);?>">
</div>

<div style="width:200px;height:200px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">Screen for Acute HIV</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Sore throat</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[141]);?> id="field_141" name="sore_throat" onclick="$('#option_141').val(1);"><label for="field_141">Yes </label><input type="radio" id="no_sore_throat" name="sore_throat" onclick="$('#option_141').val('');"><label for="no_sore_throat">No</label></div></div>
<input type="hidden" id="option_141" value="<?php print($form_option_value[141]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Fatigue</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[142]);?> id="field_142" name="fatigue" onclick="$('#option_142').val(1);"><label for="field_142">Yes </label><input type="radio" id="no_fatigue" name="fatigue" onclick="$('#option_142').val('');"><label for="no_fatigue">No</label></div></div>
<input type="hidden" id="option_142" value="<?php print($form_option_value[142]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Fever</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[143]);?> id="field_143" name="fever" onclick="$('#option_143').val(1);"><label for="field_143">Yes </label><input type="radio" id="no_fever" name="fever" onclick="$('#option_143').val('');"><label for="no_fever">No</label></div></div>
<input type="hidden" id="option_143" value="<?php print($form_option_value[143]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Rash</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[144]);?> id="field_144" name="rash" onclick="$('#option_144').val(1);"><label for="field_144">Yes </label><input type="radio" id="no_rash" name="rash" onclick="$('#option_144').val('');"><label for="no_rash">No</label></div></div>
<input type="hidden" id="option_144" value="<?php print($form_option_value[144]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Chills</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[145]);?> id="field_145" name="chills" onclick="$('#option_145').val(1);"><label for="field_145">Yes </label><input type="radio" id="no_chills" name="chills" onclick="$('#option_145').val('');"><label for="no_chills">No</label></div></div>
<input type="hidden" id="option_145" value="<?php print($form_option_value[145]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Headache</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[146]);?> id="field_146" name="headache" onclick="$('#option_146').val(1);"><label for="field_146">Yes </label><input type="radio" id="no_headache" name="headache" onclick="$('#option_146').val('');"><label for="no_headache">No</label></div></div>
<input type="hidden" id="option_146" value="<?php print($form_option_value[146]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:52%;min-height:20px;height:auto;float:left;">Muscle aches</div><div style="width:48%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[147]);?> id="field_147" name="muscle_aches" onclick="$('#option_147').val(1);"><label for="field_147">Yes </label><input type="radio" id="no_muscle_aches" name="muscle_aches" onclick="$('#option_147').val('');"><label for="no_muscle_aches">No</label></div></div>
<input type="hidden" id="option_147" value="<?php print($form_option_value[147]);?>">
</div>

<div style="width:200px;height:200px;float:right;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">PAST MEDICAL HISTORY</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Have you ever been diagnosed with the following diseases?</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:56%;min-height:20px;height:auto;float:left;">Hepatitis B</div><div style="width:44%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[148]);?> id="field_148" name="hepatitis_b" onclick="$('#option_148').val(1);"><label for="field_148">Yes</label> <input type="radio" id="no_hepatitis_b" name="hepatitis_b" onclick="$('#option_148').val('');"><label for="no_hepatitis_b">No</label></div></div>
<input type="hidden" id="option_148" value="<?php print($form_option_value[148]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:56%;min-height:20px;height:auto;float:left;">Tuberculosis</div><div style="width:44%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[149]);?> id="field_149" name="tuberculosis" onclick="$('#option_149').val(1);"><label for="field_149">Yes</label> <input type="radio" id="no_tuberculosis" name="tuberculosis" onclick="$('#option_149').val('');"><label for="no_tuberculosis">No</label></div></div>
<input type="hidden" id="option_149" value="<?php print($form_option_value[149]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:56%;min-height:20px;height:auto;float:left;">Diabetes</div><div style="width:44%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[150]);?> id="field_150" name="diabetes" onclick="$('#option_150').val(1);"><label for="field_150">Yes</label> <input type="radio" id="no_diabetes" name="diabetes" onclick="$('#option_150').val('');"><label for="no_diabetes">No</label></div></div>
<input type="hidden" id="option_150" value="<?php print($form_option_value[150]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:56%;min-height:20px;height:auto;float:left;">Kidney disease</div><div style="width:44%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[151]);?> id="field_151" name="kidney_disease" onclick="$('#option_151').val(1);"><label for="field_151">Yes</label> <input type="radio" id="no_kidney_disease" name="kidney_disease" onclick="$('#option_151').val('');"><label for="no_kidney_disease">No</label></div></div>
<input type="hidden" id="option_151" value="<?php print($form_option_value[151]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:56%;min-height:20px;height:auto;float:left;">Hypertension</div><div style="width:44%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[152]);?> id="field_152" name="hypertension" onclick="$('#option_152').val(1);"><label for="field_152">Yes</label> <input type="radio" id="no_hypertension" name="hypertension" onclick="$('#option_152').val('');"><label for="no_hypertension">No</label></div></div>
<input type="hidden" id="option_152" value="<?php print($form_option_value[152]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:56%;min-height:20px;height:auto;float:left;">Psychiatric Illness</div><div style="width:44%;height:20px;float:right;"><input type="radio" <?php print($form_option_checked[153]);?> id="field_153" name="psychiatric_illness" onclick="$('#option_153').val(1);"><label for="field_153">Yes</label> <input type="radio" id="no_psychiatric_illness" name="psychiatric_illness" onclick="$('#option_153').val('');"><label for="no_psychiatric_illness">No</label></div></div>
<input type="hidden" id="option_153" value="<?php print($form_option_value[153]);?>">

</div>
</div>

<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:100px;text-align:center;height:20px;border:solid 1px #888;line-height:20px;float:left;margin-top:5px;border-radius:5px;font-weight:bold;">PHYSICAL EXAM</div>
<div style="width:auto;float:left;min-height:25px;height:auto;margin-left:5px;">
<div style="width:60px;height:30px;float:left;line-height:30px;" id="option_154_title">Weight(kg):</div>

<?php
if($form_option_text[154] == ''){
	$form_option_text[154] = '000.0';
}

$weight_array = str_split($form_option_text[154]);

?>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" onchange="$('#option_154_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" id="weight_0" value="<?php print($weight_array[0]);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="weight_1" onchange="$('#option_154_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" value="<?php if(isset($weight_array[1])){print($weight_array[1]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="weight_2" onchange="$('#option_154_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" value="<?php if(isset($weight_array[2])){print($weight_array[2]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<div style="width:5px;height:30px;float:left;margin-left:5px;line-height:30px;text-align:center;font-weight:bold;">.</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="weight_3" onchange="$('#option_154_text').val($('#weight_0').val()+''+$('#weight_1').val()+''+$('#weight_2').val()+'.'+$('#weight_3').val());" value="<?php if(isset($weight_array[4])){print($weight_array[4]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_154" value="1"> 
<input type="hidden" id="option_154_text" value="<?php print($form_option_text[154]);?>"> 

<?php
if($form_option_text[155] == ''){
	$form_option_text[155] = '000/000';

}

$bp_array = str_split($form_option_text[155]);
?>
<div style="width:30px;height:30px;float:left;line-height:30px;text-align:right;" id="option_155_title">BP:</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:25px;border:solid 1px #aaa;" id="bp_1" onchange="$('#option_155_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[0])){print($bp_array[0]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:25px;border:solid 1px #aaa;" id="bp_2" onchange="$('#option_155_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[1])){print($bp_array[1]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_3" onchange="$('#option_155_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[2])){print($bp_array[2]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<div style="width:5px;height:25px;float:left;margin-left:5px;line-height:30px;text-align:center;font-weight:bold;">/</div>
<div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_4" onchange="$('#option_155_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[4])){print($bp_array[4]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div><div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_5" onchange="$('#option_155_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[5])){print($bp_array[5]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div><div style="width:25px;height:25px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="bp_6" onchange="$('#option_155_text').val($('#bp_1').val()+''+$('#bp_2').val()+''+$('#bp_3').val()+'/'+$('#bp_4').val()+''+$('#bp_5').val()+''+$('#bp_6').val());" value="<?php if(isset($bp_array[6])){print($bp_array[6]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_155" value="1"> 
<input type="hidden" id="option_155_text" value="<?php print($form_option_text[155]);?>"> 
<?php
if($form_option_text[156] == ''){
	$form_option_text[156] = '00.0';

}
$temp_array = str_split($form_option_text[156]);
?>
<div style="width:60px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;" id="option_156_title">Temp. &#176; C:</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="temp_1" onchange="$('#option_156_text').val($('#temp_1').val()+''+$('#temp_2').val()+'.'+$('#temp_3').val())" value="<?php if(isset($temp_array[0])){print($temp_array[0]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="temp_2" onchange="$('#option_156_text').val($('#temp_1').val()+''+$('#temp_2').val()+'.'+$('#temp_3').val())" value="<?php if(isset($temp_array[1])){print($temp_array[1]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<div style="width:5px;height:30px;float:left;margin-left:5px;line-height:30px;text-align:center;font-weight:bold;">.</div>
<div style="width:25px;height:30px;float:left;margin-left:5px;"><input type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="temp_3" onchange="$('#option_156_text').val($('#temp_1').val()+''+$('#temp_2').val()+'.'+$('#temp_3').val())" value="<?php if(isset($temp_array[3])){print($temp_array[3]);}?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<input type="hidden" id="option_156" value="1"> 
<input type="hidden" id="option_156_text" value="<?php print($form_option_text[156]);?>"> 

<?php
if($form_option_text[157] == ''){
	$bmi = 0;
	
}else{
	$bmi = $form_option_text[157];
}
?>

<div style="width:30px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;" id="option_157_title">BMI:</div>
<div style="width:90px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;"><input type="text" style="width:100%;height:25px;margin-top:2px;border:solid 1px #aaa;" id="option_157_text" value="<?php print($bmi);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_157" value="1">
</div>

<div style="width:100%;float:left;min-height:25px;height:auto;margin-left:5px;">
<div style="width:90px;height:30px;float:left;line-height:30px;" id="option_158_title">Heart rate/min:</div>

<?php
if($form_option_text[158] == ''){
	$form_option_text[158] = '000';

}
$heart_array = str_split($form_option_text[158]);
?>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($heart_array[0])){print($heart_array[0]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="heart_rate_1" onchange="$('#option_158_text').val($('#heart_rate_1').val()+''+$('#heart_rate_2').val()+''+$('#heart_rate_3').val())" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($heart_array[1])){print($heart_array[1]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="heart_rate_2" onchange="$('#option_158_text').val($('#heart_rate_1').val()+''+$('#heart_rate_2').val()+''+$('#heart_rate_3').val())"onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($heart_array[2])){ print($heart_array[2]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="heart_rate_3" onchange="$('#option_158_text').val($('#heart_rate_1').val()+''+$('#heart_rate_2').val()+''+$('#heart_rate_3').val())" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_158" value="1">
<input type="hidden" id="option_158_text" value="<?php print($form_option_text[158]);?>">


<div style="width:80px;height:30px;float:left;line-height:30px;text-align:right;" id="option_159_title">Resp. Rate:</div>
<?php
if($form_option_text[159] == ''){
	$form_option_text[159] = '00';

}

$resp_array = str_split($form_option_text[159]);
?>
<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($resp_array[0])){print($resp_array[0]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="resp_rate_1" onchange="$('#option_159_text').val($('#resp_rate_1').val()+''+$('#resp_rate_2').val())" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<div style="width:25px;height:30px;float:left;margin-left:2px;"><input value="<?php if(isset($resp_array[1])){print($resp_array [1]);}?>" type="text" style="margin-top:3px;height:23px;width:100%;border:solid 1px #aaa;" id="resp_rate_2" onchange="$('#option_159_text').val($('#resp_rate_1').val()+''+$('#resp_rate_2').val())" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>

<input type="hidden" id="option_159" value="1">
<input type="hidden" id="option_159_text" value="<?php print($form_option_text[159]);?>">

<div style="width:60px;height:30px;float:left;line-height:30px;text-align:right;">General:</div>
<div style="width:auto;height:30px;float:left;margin-left:5px;line-height:30px;">
<input <?php print($form_option_checked[160]);?> type="checkbox" id="field_160" onclick="if(this.checked){$('#option_160').val(1);}else{$('#option_160').val('');}"><label for="field_160">Pallor</label>
<input type="hidden" id="option_160" value="<?php print($form_option_value[160]);?>">

<input <?php print($form_option_checked[161]);?> type="checkbox" id="field_161" onclick="if(this.checked){$('#option_161').val(1);}else{$('#option_161').val('');}"><label for="field_161">Jaundice</label>
<input type="hidden" id="option_161" value="<?php print($form_option_value[161]);?>">

<input <?php print($form_option_checked[162]);?> type="checkbox" id="field_162" onclick="if(this.checked){$('#option_162').val(1);}else{$('#option_162').val('');}"><label for="field_162">Edema</label>
<input type="hidden" id="option_162" value="<?php print($form_option_value[162]);?>">

</div>

<?php
if($form_option_text[163] == ''){
	$nortable_findings = 0;
	
}else{
	$nortable_findings = $form_option_text[163];
}
?>

<div style="width:140px;height:30px;float:right;line-height:30px;margin-left:5px;text-align:right;margin-right:9px;"><input  type="text" style="width:100%;height:25px;border:solid 1px #aaa;" id="option_163_text" value="<?php print($nortable_findings);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}"></div>
<input type="hidden" id="option_163" value="1">
<div style="width:100px;height:30px;float:right;line-height:30px;text-align:right;">Notable findings:</div>
</div>

<?php
if($form_option_text[164] == ''){
	$genital_exam = 0;
	
}else{
	$genital_exam = $form_option_text[164];
}
?>
<div style="width:280px;float:right;min-height:25px;height:auto;">
<div style="width:132px;height:30px;float:left;line-height:30px;text-align:right;">Genital Exam:</div>
<div style="width:140px;height:30px;float:left;line-height:30px;margin-left:5px;text-align:right;"><input type="text" style="width:100%;height:25px;border:solid 1px #aaa;" id="option_164_text" value="<?php print($genital_exam);?>" onfocus="if(this.value=='0'){this.value='';}" onfocusout="if(this.value==''){this.value='0';}">
<input type="hidden" id="option_164" value="1">
</div>
</div>
</div>




<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:335px;height:160px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">HIV STATUS</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">
<div style="width:auto;height:30px;float:left;">
<div style="width:120px;height:30px;line-height:15px;float:left;">Date of last potential exposure:</div>
<div style="line-height:30px;width:10px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">
<?php
if($form_option_value[165] == ''){
	$exposure_date = '';
	$exposure_day = 'N/A';
	$exposure_month = 'N/A';
	$exposure_year = 'N/A';
	
}else{
	$exposure_date = $form_option_value[165];
	
	$exposure_date_array = explode('/',$exposure_date);
	$exposure_day = $exposure_date_array[1];
	$exposure_month = $exposure_date_array[0];
	$exposure_year = $exposure_date_array[2];
}
?>

<div class="option_item" title="Click to change option" onclick="$('#initiation_exposure_day_menu').toggle('fast');" id="active_exposure_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($exposure_day);?></div>

<div class="option_menu" id="initiation_exposure_day_menu" style="display:none;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_day_menu').toggle('fast');$('#active_exposure_initiation_day').html($(this).html());$('#active_exposure_initiation_month').html($(this).html());$('#active_exposure_initiation_year').html($(this).html());$('#option_165').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_day_menu').toggle('fast');$('#active_exposure_initiation_day').html($(this).html());$('#selected_exposure_initiation_day').val(<?php print($d);?>);$('#active_exposure_initiation_month').html($('#selected_exposure_initiation_month').val());$('#active_exposure_initiation_year').html($('#selected_exposure_initiation_year').val());$('#option_165').val($('#selected_exposure_initiation_month').val()+'/'+$('#selected_exposure_initiation_day').val()+'/'+$('#selected_exposure_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_day_menu').toggle('fast');$('#active_exposure_initiation_day').html($(this).html());$('#selected_exposure_initiation_day').val(<?php print($d);?>);$('#active_exposure_initiation_month').html($('#selected_exposure_initiation_month').val());$('#active_exposure_initiation_year').html($('#selected_exposure_initiation_year').val());$('#option_165').val($('#selected_exposure_initiation_month').val()+'/'+$('#selected_exposure_initiation_day').val()+'/'+$('#selected_exposure_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_exposure_initiation_day" id="selected_exposure_initiation_day" value="<?php print($exposure_day);?>">
</div>


<div style="line-height:30px;width:10px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#initiation_exposure_month_menu').toggle('fast');" id="active_exposure_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($exposure_month);?></div>


<div class="option_menu" id="initiation_exposure_month_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_month_menu').toggle('fast');$('#active_exposure_initiation_month').html($(this).html());$('#active_exposure_initiation_day').html($(this).html());$('#active_exposure_initiation_year').html($(this).html());$('#option_165').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_month_menu').toggle('fast');$('#active_exposure_initiation_month').html($(this).html());$('#selected_exposure_initiation_month').val(<?php print($m);?>);$('#active_exposure_initiation_day').html($('#selected_exposure_initiation_day').val());$('#active_exposure_initiation_year').html($('#selected_exposure_initiation_year').val());$('#option_165').val($('#selected_exposure_initiation_month').val()+'/'+$('#selected_exposure_initiation_day').val()+'/'+$('#selected_exposure_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_month_menu').toggle('fast');$('#active_exposure_initiation_month').html($(this).html());$('#selected_exposure_initiation_month').val(<?php print($m);?>);$('#active_exposure_initiation_day').html($('#selected_exposure_initiation_day').val());$('#active_exposure_initiation_year').html($('#selected_exposure_initiation_year').val());$('#option_165').val($('#selected_exposure_initiation_month').val()+'/'+$('#selected_exposure_initiation_day').val()+'/'+$('#selected_exposure_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_exposure_initiation_month" value="<?php print($exposure_month);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#initiation_exposure_year_menu').toggle('fast');" id="active_exposure_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($exposure_year);?></div>


<div class="option_menu" id="initiation_exposure_year_menu" style="display:none;width:65px;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_year_menu').toggle('fast');$('#active_exposure_initiation_year').html($(this).html());$('#active_exposure_initiation_day').html($(this).html());$('#active_exposure_initiation_month').html($(this).html());$('#option_165').val('');" style="width:40px;">N/A</div>
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_exposure_year_menu').toggle('fast');$('#active_exposure_initiation_year').html($(this).html());$('#selected_exposure_initiation_year').val(<?php print($y);?>);$('#active_exposure_initiation_month').html($('#selected_exposure_initiation_month').val());$('#active_exposure_initiation_day').html($('#selected_exposure_initiation_day').val());$('#option_165').val($('#selected_exposure_initiation_month').val()+'/'+$('#selected_exposure_initiation_day').val()+'/'+$('#selected_exposure_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_exposure_initiation_year" id="selected_exposure_initiation_year" value="<?php print($exposure_year);?>">
</div>
<input type="hidden" value="<?php print($exposure_date);?>" id="option_165">
</div>
</div>


<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:auto;height:30px;float:left;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Last date of HIV test:</div>
<div style="line-height:30px;width:10px;height:30px;float:left;">D:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">
<?php
if($form_option_value[166] == ''){
	$test_date = '';
	$test_day = 'N/A';
	$test_month = 'N/A';
	$test_year = 'N/A';
	
}else{
	$test_date = $form_option_value[166];
	
	$test_date_array = explode('/',$test_date);
	$test_day = $test_date_array[1];
	$test_month = $test_date_array[0];
	$test_year = $test_date_array[2];
}
?>
<div class="option_item" title="Click to change option" onclick="$('#initiation_test_day_menu').toggle('fast');" id="active_test_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($test_day);?></div>

<div class="option_menu" id="initiation_test_day_menu" style="display:none;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_day_menu').toggle('fast');$('#active_test_initiation_day').html($(this).html());$('#active_test_initiation_month').html($(this).html());$('#active_test_initiation_year').html($(this).html());$('#option_166').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_day_menu').toggle('fast');$('#active_test_initiation_day').html($(this).html());$('#selected_test_initiation_day').val(<?php print($d);?>);$('#active_test_initiation_month').html($('#selected_test_initiation_month').val());$('#active_test_initiation_year').html($('#selected_test_initiation_year').val());$('#option_166').val($('#selected_test_initiation_month').val()+'/'+$('#selected_test_initiation_day').val()+'/'+$('#selected_test_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_day_menu').toggle('fast');$('#active_test_initiation_day').html($(this).html());$('#selected_test_initiation_day').val(<?php print($d);?>);$('#active_test_initiation_month').html($('#selected_test_initiation_month').val());$('#active_test_initiation_year').html($('#selected_test_initiation_year').val());$('#option_166').val($('#selected_test_initiation_month').val()+'/'+$('#selected_test_initiation_day').val()+'/'+$('#selected_test_initiation_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_test_initiation_day" id="selected_test_initiation_day" value="<?php print($test_day);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">M:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">

<div class="option_item" title="Click to change option" onclick="$('#initiation_test_month_menu').toggle('fast');" id="active_test_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($test_month);?></div>


<div class="option_menu" id="initiation_test_month_menu" style="display:none;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_month_menu').toggle('fast');$('#active_test_initiation_month').html($(this).html());$('#active_test_initiation_day').html($(this).html());$('#active_test_initiation_year').html($(this).html());$('#option_166').val('');" style="width:40px;">N/A</div>
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_month_menu').toggle('fast');$('#active_test_initiation_month').html($(this).html());$('#selected_test_initiation_month').val(<?php print($m);?>);$('#active_test_initiation_day').html($('#selected_test_initiation_day').val());$('#active_test_initiation_year').html($('#selected_test_initiation_year').val());$('#option_166').val($('#selected_test_initiation_month').val()+'/'+$('#selected_test_initiation_day').val()+'/'+$('#selected_test_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_month_menu').toggle('fast');$('#active_test_initiation_month').html($(this).html());$('#selected_test_initiation_month').val(<?php print($m);?>);$('#active_test_initiation_day').html($('#selected_test_initiation_day').val());$('#active_test_initiation_year').html($('#selected_test_initiation_year').val());$('#option_166').val($('#selected_test_initiation_month').val()+'/'+$('#selected_test_initiation_day').val()+'/'+$('#selected_test_initiation_year').val());" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_test_initiation_month" value="<?php print($test_month);?>">
</div>

<div style="line-height:30px;width:10px;height:30px;float:left;">Yr:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;margin-left:5px;position:relative">

<div class="option_item" title="Click to change option" onclick="$('#initiation_test_year_menu').toggle('fast');" id="active_test_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($test_year);?></div>


<div class="option_menu" id="initiation_test_year_menu" style="display:none;width:65px;">
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_year_menu').toggle('fast');$('#active_test_initiation_year').html($(this).html());$('#active_test_initiation_day').html($(this).html());$('#active_test_initiation_month').html($(this).html());$('#option_166').val('');" style="width:40px;">N/A</div>
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_test_year_menu').toggle('fast');$('#active_test_initiation_year').html($(this).html());$('#selected_test_initiation_year').val(<?php print($y);?>);$('#active_test_initiation_month').html($('#selected_test_initiation_month').val());$('#active_test_initiation_day').html($('#selected_test_initiation_day').val());$('#option_166').val($('#selected_test_initiation_month').val()+'/'+$('#selected_test_initiation_day').val()+'/'+$('#selected_test_initiation_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_test_initiation_year" id="selected_test_initiation_year" value="<?php print($test_year);?>">
</div>
<input type="hidden" value="<?php print($test_date);?>" id="option_166">
</div></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:35%;min-height:20px;height:auto;float:left;">HIV Test Results</div><div style="width:65%;height:20px;float:left;"><input <?php print($form_option_checked[168]);?> type="radio" id="field_168" onclick="check_hiv_status_entry(168)" name="hiv_test_results"><label for="field_168">-ve</label> <input <?php print($form_option_checked[167]);?> type="radio" id="field_167" onclick="check_hiv_status_entry(167)" name="hiv_test_results"><label for="field_167">+ve</label> <input <?php print($form_option_checked[169]);?> type="radio" id="field_169" onclick="check_hiv_status_entry(169)" name="hiv_test_results"><label for="field_169">Undetermined</label></div></div>

<input type="hidden" id="option_167" value="<?php print($form_option_value[167]);?>">
<input type="hidden" id="option_168" value="<?php print($form_option_value[168]);?>">
<input type="hidden" id="option_169" value="<?php print($form_option_value[169]);?>">

<script>
function check_hiv_status_entry(entry_id){
	$('#option_167').val('');
	$('#option_168').val('');
	$('#option_169').val('');
	
	$('#option_'+entry_id).val(1);
}
</script>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:35%;min-height:20px;height:auto;float:left;">Testing location</div><div style="width:65%;height:20px;float:left;"><input <?php print($form_option_checked[321]);?> type="radio" name="testing_location" id="field_321" onclick="check_testing_location_entry(321);"><label for="field_321">Facility</label><input <?php print($form_option_checked[322]);?> type="radio" name="testing_location" id="field_322" onclick="check_testing_location_entry(322);"><label for="field_322">Community</label><br> <input <?php print($form_option_checked[323]);?> type="radio" name="testing_location" id="field_323" onclick="check_testing_location_entry(323);"><label for="field_323">HIV Self-test</label></div></div>

<input type="hidden" value="<?php print($form_option_value[321]);?>" id="option_321">
<input type="hidden" value="<?php print($form_option_value[322]);?>" id="option_322">
<input type="hidden" value="<?php print($form_option_value[323]);?>" id="option_323">

<script>
function check_testing_location_entry(entry_id){
	$('#option_321').val('');
	$('#option_322').val('');
	$('#option_323').val('');
	
	$('#option_'+entry_id).val(1);
}
</script>
</div>



<div style="width:230px;height:160px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">CURRENT MEDICINES</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:35%;min-height:20px;line-height:20px;height:auto;float:left;"><input <?php print($form_option_checked[173]);?> type="checkbox" id="field_173" onclick="if(this.checked){document.getElementById('option_174_text').disabled = false;$('#option_173').val(1);$('#option_174').val(1);}else{document.getElementById('option_174_text').disabled = true;$('#option_173').val('');$('#option_174').val('');}"><label for="field_173">ATT</label></div><div style="width:65%;height:20px;float:right;"><input type="text" style="width:97%;height:20px;border:solid 1px #aaa;" id="option_174_text" <?php if(!$form_option_value[173]){?> disabled <?php }?> value="<?php print($form_option_text[173]);?>"></div></div>

<input type="hidden" id="option_173" value="<?php print($form_option_value[173]);?>">
<input type="hidden" id="option_174" value="<?php print($form_option_value[174]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:35%;min-height:20px;line-height:20px;height:auto;float:left;"><input <?php print($form_option_checked[175]);?> type="checkbox" id="field_175" onclick="if(this.checked){document.getElementById('option_176_text').disabled = false;$('#option_175').val(1);$('#option_176').val(1);}else{document.getElementById('option_176_text').disabled = true;$('#option_175').val('');$('#option_176').val('');}"><label for="field_175">Anti-HBV</label></div><div style="width:65%;height:20px;float:right;"><input type="text" style="width:97%;height:20px;border:solid 1px #aaa;" id="option_176_text" <?php if(!$form_option_value[175]){?> disabled <?php }?> value="<?php print($form_option_text[176]);?>"></div></div>

<input type="hidden" id="option_175" value="<?php print($form_option_value[175]);?>">
<input type="hidden" id="option_176" value="<?php print($form_option_value[176]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:35%;min-height:20px;line-height:20px;height:auto;float:left;"><input <?php print($form_option_checked[177]);?> type="checkbox" id="field_177" onclick="if(this.checked){document.getElementById('option_178_text').disabled = false;$('#option_177').val(1);$('#option_178').val(1);}else{document.getElementById('option_178_text').disabled = true;$('#option_177').val('');$('#option_178').val('');}"><label for="field_177">Anti-Hypertension</label></div><div style="width:65%;height:20px;float:right;"><input type="text" style="width:97%;height:20px;border:solid 1px #aaa;" id="option_178_text" <?php if(!$form_option_value[177]){?> disabled <?php }?> value="<?php print($form_option_text[178]);?>"></div></div>

<input type="hidden" id="option_177" value="<?php print($form_option_value[177]);?>">
<input type="hidden" id="option_178" value="<?php print($form_option_value[178]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><div style="width:35%;min-height:20px;line-height:20px;height:auto;float:left;"><input <?php print($form_option_checked[180]);?> type="checkbox" id="field_179" onclick="if(this.checked){document.getElementById('option_180_text').disabled = false;$('#option_179').val(1);$('#option_180').val(1);}else{document.getElementById('option_180_text').disabled = true;$('#option_179').val('');$('#option_180').val('');}"><label for="field_179">Anti-Psychotics</label></div><div style="width:65%;height:20px;float:right;"><input type="text" style="width:97%;height:20px;border:solid 1px #aaa;" id="option_180_text" <?php if(!$form_option_value[179]){?> disabled <?php }?> value="<?php print($form_option_text[180]);?>"></div></div>

<input type="hidden" id="option_179" value="<?php print($form_option_value[179]);?>">
<input type="hidden" id="option_180" value="<?php print($form_option_value[180]);?>">

</div>

<div style="width:140px;height:160px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">PREVENTION</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[181]);?> type="checkbox" id="field_181" onclick="if(this.checked){$('#option_181').val(1);}else{$('#option_181').val('');}"><label for="field_181">H/O PEP use</label></div>
<input type="hidden" id="option_181" value="<?php print($form_option_value[181]);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[182]);?> type="checkbox" id="field_182" onclick="if(this.checked){$('#option_182').val(1);}else{$('#option_182').val('');}"><label for="field_182">Condom / Lube Use</label></div>
<input type="hidden" id="option_182" value="<?php print($form_option_value[182]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[183]);?> type="checkbox" id="field_183" onclick="if(this.checked){$('#option_183').val(1);}else{$('#option_183').val('');}"><label for="field_183">VMMC</label></div>
<input type="hidden" id="option_183" value="<?php print($form_option_value[183]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[184]);?> type="checkbox" id="field_184" onclick="if(this.checked){$('#option_184').val(1);}else{$('#option_184').val('');}"><label for="field_184">Used PrEP before</label></div>
<input type="hidden" id="option_184" value="<?php print($form_option_value[184]);?>">
</div>

<div style="width:158px;height:160px;float:left;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">ASSESSMENT</div>

<?php
$assessments = explode(']',$form_option_text[186]);
?>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="text" style="width:100%;height:20px;" id="assessment_0" onchange="add_assessment();" value="<?php if(isset($assessments[0])){print($assessments[0]);}?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="text" style="width:100%;height:20px;" id="assessment_1" onchange="add_assessment();" value="<?php if(isset($assessments[1])){print($assessments[1]);}?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="text" style="width:100%;height:20px;" id="assessment_2" onchange="add_assessment();" value="<?php if(isset($assessments[2])){print($assessments[2]);}?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="text" style="width:100%;height:20px;" id="assessment_3" onchange="add_assessment();" value="<?php if(isset($assessments[3])){print($assessments[3]);}?>"></div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input type="text" style="width:100%;height:20px;" id="assessment_4" onchange="add_assessment();" value="<?php if(isset($assessments[4])){print($assessments[4]);}?>"></div>
</div>
<input type="hidden" id="option_186" value="<?php print($form_option_value[186]);?>">
<input type="hidden" id="option_186_text" value="<?php print($form_option_text[186]);?>">
</div>

<script>
function add_assessment(){
	$('#option_186_text').val($('#assessment_0').val()+']'+$('#assessment_1').val()+']'+$('#assessment_2').val()+']'+$('#assessment_3').val()+']'+$('#assessment_4').val());
	
	if($('#assessment_0').val() == '' && $('#assessment_1').val() == '' && $('#assessment_2').val() == '' && $('#assessment_3').val() == '' && $('#assessment_4').val() == ''){
		
		$('#option_186').val('');
	}else{
		$('#option_186').val(1);
		
	}
}

</script>
<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:376px;height:180px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">PrEP ELIGIBILITY</div>

<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[187]);?> type="checkbox" id="field_187" onclick="if(this.checked){$('#option_187').val(1);}else{$('#option_187').val('');}"><label for="field_187">HIV Negative</label></div>
<input type="hidden" value="<?php print($form_option_value[187]);?>" id="option_187">

<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[191]);?> type="checkbox" onclick="if(this.checked){$('#option_191').val(1);}else{$('#option_191').val('');}" id="field_191"><label for="field_191">Able and Willing to Adhere to Daily PrEP</label></div>
<input type="hidden" value="<?php print($form_option_value[191]);?>" id="option_191">

<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[188]);?> type="checkbox" onclick="if(this.checked){$('#option_188').val(1);}else{$('#option_188').val('');}" id="field_188"><label for="field_188">No Acute HIV Infection symptoms</label></div>
<input type="hidden" value="<?php print($form_option_value[188]);?>" id="option_188">

<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[192]);?> type="checkbox" onclick="if(this.checked){$('#option_192').val(1);}else{$('#option_192').val('');}" id="field_192"><label for="field_192">Last potential HIV Exposure more than 6 weeks ago</label></div>
<input type="hidden" value="<?php print($form_option_value[192]);?>" id="option_192">

<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[189]);?> type="checkbox" onclick="if(this.checked){$('#option_189').val(1);}else{$('#option_189').val('');}" id="field_189"><label for="field_189">Creatinine Clearance >50</label></div>
<input type="hidden" value="<?php print($form_option_value[189]);?>" id="option_189">

<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[193]);?> type="checkbox" onclick="if(this.checked){$('#option_193').val(1);}else{$('#option_193').val('');}" id="field_193"><label for="field_193">HIV negative test within 2 weeks</label></div>
<input type="hidden" value="<?php print($form_option_value[193]);?>" id="option_193">

<div style="width:50%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[190]);?> type="checkbox" onclick="if(this.checked){$('#option_190').val(1);}else{$('#option_190').val('');}" id="field_190"><label for="field_190">Urinalysis normal</label></div>
<input type="hidden" value="<?php print($form_option_value[190]);?>" id="option_190">

</div>



<div style="width:220px;height:220px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">PLAN</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;">Client Eligibility for PrEP <input <?php print($form_option_checked[292]);?> type="radio" id="field_292" onclick="$('#option_292').val(1);document.getElementById('field_195').disabled=false;document.getElementById('field_194').disabled=false;" name="prep_eligibility"><label for="field_292">Yes</label><input type="radio" id="no_eligibility" onclick="$('#option_292').val('');$('#option_195').val('');document.getElementById('field_195').disabled=true;document.getElementById('field_195').checked=false;$('#option_194').val('');document.getElementById('field_194').disabled=true;document.getElementById('field_194').checked=false;" name="prep_eligibility"><label for="no_eligibility">No<label></div>
<input type="hidden" id="option_292" value="<?php print($form_option_value[292]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[195]);?> type="radio" id="field_195" onclick="$('#option_195').val(1);$('#option_194').val('');" name="plan"><label for="field_195">Start PrEP</label></div>
<input type="hidden" id="option_195" value="<?php print($form_option_value[195]);?>">

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[194]);?> type="radio" id="field_194" onclick="$('#option_194').val(1);$('#option_195').val('');" name="plan"><label for="field_194">Client eligible but not starting PrEP</label></div>
<input type="hidden" id="option_194" value="<?php print($form_option_value[194]);?>">

<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">PRESCRIPTION</div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[223]);?> type="radio" id="field_223" onclick="if($('#option_223').val() == 1){$('#option_223').val('');this.checked=false}else{$('#option_223').val(1);}"><label for="field_223">TDF + FTC</label></div>
<input type="hidden" id="option_223" value="<?php print($form_option_value[223]);?>">
</div>

<div style="width:260px;height:210px;float:left;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:center;">Reason for not starting</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[197]);?> type="checkbox" id="field_197" onclick="custom_form_checkbox_activation(197);"><label for="field_197">Acute HIV infection</label></div>
<input type="hidden" id="option_197" value="<?php print($form_option_value[197]);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[198]);?> type="checkbox" id="field_198" onclick="custom_form_checkbox_activation(198);"><label for="field_198">Adherence counseling</label></div>
<input type="hidden" id="option_198" value="<?php print($form_option_value[198]);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[199]);?> type="checkbox" id="field_199" onclick="custom_form_checkbox_activation(199);"><label for="field_199">Suspected Acute HIV infection</label></div>
<input type="hidden" id="option_199" value="<?php print($form_option_value[199]);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[200]);?> type="checkbox" id="field_200" onclick="custom_form_checkbox_activation(200);"><label for="field_200">Creatinine clearance <50mL / min</label></div>
<input type="hidden" id="option_200" value="<?php print($form_option_value[200]);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[201]);?> type="checkbox" id="field_201" onclick="custom_form_checkbox_activation(201);"><label for="field_201">Abnormal Urinalysis</label></div>
<input type="hidden" id="option_201" value="<?php print($form_option_value[201]);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[293]);?> type="checkbox" id="field_293" onchange="custom_form_checkbox_activation(293);"><label for="field_293">Not Willing</label></div>
<input type="hidden" id="option_293" value="<?php print($form_option_value[293]);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[294]);?> type="checkbox" id="field_294" onchange="custom_form_checkbox_activation(294);if(this.checked){document.getElementById('option_326_text').disabled=false;$('#option_326').val(1);}else{document.getElementById('option_326_text').disabled=true;$('#option_326').val('');}"><label for="field_294">Other</label> <input type="text" id="option_326_text" style="width:65%;height:25px;border:solid 1px #aaa;" <?php if(!$form_option_value[294]){?> disabled <?php }?> value="<?php print($form_option_text[326]);?>"></div>
<input type="hidden" id="option_294" value="<?php print($form_option_value[294]);?>">

<input type="hidden" id="option_326" value="<?php print($form_option_value[326]);?>">
</div>
</div>


<div style="width:99.5%;float:left;height:auto;border-top:solid 1px #000;padding-left:2px;">
<div style="width:220px;height:120px;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">INVESTIGATIONS</div>

<div style="width:70px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[202]);?> type="checkbox" id="field_202" onclick="custom_form_checkbox_activation(202);"><label for="field_202">HIV</label></div>
<input type="hidden" value="<?php print($form_option_value[202]);?>" id="option_202">

<div style="width:70px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[205]);?> type="checkbox" id="field_205" onclick="custom_form_checkbox_activation(205);"><label for="field_205">RPR</label></div>
<input type="hidden" value="<?php print($form_option_value[205]);?>" id="option_205">

<div style="width:70px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[208]);?> type="checkbox" id="field_208" onclick="custom_form_checkbox_activation(208);"><label for="field_208">UA</label></div>
<input type="hidden" value="<?php print($form_option_value[208]);?>" id="option_208">

<div style="width:70px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[203]);?> type="checkbox" id="field_203" onclick="custom_form_checkbox_activation(203);"><label for="field_203">CrCl</label></div>
<input type="hidden" value="<?php print($form_option_value[203]);?>" id="option_203">

<div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[206]);?> type="checkbox" id="field_206" onclick="custom_form_checkbox_activation(206);"><label for="field_206">Gravindex</label></div>
<input type="hidden" value="<?php print($form_option_value[206]);?>" id="option_206">

<div style="width:70px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[204]);?> type="checkbox" id="field_204" onclick="custom_form_checkbox_activation(204);"><label for="field_204">HBsAG</label></div>
<input type="hidden" value="<?php print($form_option_value[204]);?>" id="option_204">

<div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[207]);?> type="checkbox" id="field_207" onclick="custom_form_checkbox_activation(207);"><label for="field_207">HVS</label></div>
<input type="hidden" value="<?php print($form_option_value[207]);?>" id="option_207">
</div>

<div style="width:220px;min-height:120px;height:auto;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">REFERALS</div>

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[209]);?> type="checkbox" id="field_209" onclick="custom_form_checkbox_activation(209);"><label for="field_209">Family planning</label></div>
<input type="hidden" value="<?php print($form_option_value[209]);?>" id="option_209">

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[212]);?> type="checkbox" id="field_212" onclick="custom_form_checkbox_activation(212);"><label for="field_212">STI Screening</label></div>
<input type="hidden" value="<?php print($form_option_value[212]);?>" id="option_212">

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[210]);?> type="checkbox" id="field_210" onclick="custom_form_checkbox_activation(210);"><label for="field_210">VMMC</label></div>
<input type="hidden" value="<?php print($form_option_value[210]);?>" id="option_210">

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[213]);?> type="checkbox" id="field_213" onclick="custom_form_checkbox_activation(213);"><label for="field_213">Nutrition</label></div>
<input type="hidden" value="<?php print($form_option_value[213]);?>" id="option_213">

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[211]);?> type="checkbox" id="field_211" onclick="custom_form_checkbox_activation(211);"><label for="field_211">Adherence</label></div>
<input type="hidden" value="<?php print($form_option_value[210]);?>" id="option_211">

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[214]);?> type="checkbox" id="field_214" onclick="custom_form_checkbox_activation(214);"><label for="field_214">CaCx screening</label></div>
<input type="hidden" value="<?php print($form_option_value[214]);?>" id="option_214">

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[215]);?> type="checkbox" id="field_215" onclick="custom_form_checkbox_activation(215);"><label for="field_215">ART Initiation</label></div>
<input type="hidden" value="<?php print($form_option_value[215]);?>" id="option_215">

<div style="width:110px;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[216]);?> type="checkbox" id="field_216" onclick="custom_form_checkbox_activation(216);if(this.checked){document.getElementById('option_327_text').disabled=false;$('#option_327').val(1);}else{document.getElementById('option_327_text').disabled=true;$('#option_327').val('');}"><label for="field_216">Other</label> <input  type="text" id="option_327_text" style="width:50px;height:20px;border:solid 1px #aaa;" <?php if(!$form_option_value[216]){?> disabled <?php }?> value="<?php print($form_option_text[327]);?>"></div>
<input type="hidden" value="<?php print($form_option_value[216]);?>" id="option_216">
<input type="hidden" value="<?php print($form_option_value[327]);?>" id="option_327">
</div>

<div style="width:180px;min-height:120px;height:auto;float:left;border-right:solid 1px #000;padding:2px;">
<div style="width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">PrEP Dispensed</div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[328]);?> type="radio" name="prep_dispensed" id="field_328" onclick="check_prep_dispensed(328);"><label for="field_328">2 Weeks</label></div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[217]);?> type="radio" name="prep_dispensed" id="field_217" onclick="check_prep_dispensed(217);"><label for="field_217">1 Month</label></div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[218]);?> type="radio" name="prep_dispensed" id="field_218" onclick="check_prep_dispensed(218);"><label for="field_218">2 Months</label></div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[219]);?> type="radio" name="prep_dispensed" id="field_219" onclick="check_prep_dispensed(219);"><label for="field_219">3 Months</label></div>
<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;"><input <?php print($form_option_checked[220]);?> type="radio" name="prep_dispensed" id="field_220" onclick="check_prep_dispensed(220);"><label for="field_220">Other </label><input type="text" id="option_329_text" style="width:85px;height:20px;border:solid 1px #aaa;" <?php if(!$form_option_value[220]){?> disabled <?php }?> value="<?php print($form_option_text[329]);?>"></div>
</div>

<input type="hidden" value="<?php print($form_option_value[217]);?>" id="option_217">
<input type="hidden" value="<?php print($form_option_value[218]);?>" id="option_218">
<input type="hidden" value="<?php print($form_option_value[219]);?>" id="option_219">
<input type="hidden" value="<?php print($form_option_value[328]);?>" id="option_328">
<input type="hidden" value="<?php print($form_option_value[220]);?>" id="option_220">
<input type="hidden" value="<?php print($form_option_value[329]);?>" id="option_329">

<script>
	function check_prep_dispensed(field_id){
		$('#option_217').val('');
		$('#option_218').val('');
		$('#option_219').val('');
		$('#option_328').val('');
		$('#option_220').val('');
		
		document.getElementById('option_329_text').disabled = true;
		$('#option_329').val('');
		
		$('#option_'+field_id).val(1);
		if(field_id == 220){			
			document.getElementById('option_329_text').disabled = false;
			$('#option_329').val(1);			
		}
		
		<?php
			$day = date('j',time());
			$month = date('m',time());
			$year = date('Y',time());
		?>
		
		var clinical_day = <?php print($day);?>;
		var clinical_month = <?php print($month);?>;
		var clinical_year = <?php print($year);?>;
		
		if(field_id == 328){
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

		}else if(field_id == 217 || field_id == 218 || field_id == 219){
			if(field_id == 217){
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
				
			}else if(field_id == 218){
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
				
			}else if(field_id == 219){
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
		
		$('#active_clinical_initiation_day').html(clinical_day);
		$('#active_clinical_initiation_month').html(clinical_month);
		$('#active_clinical_initiation_year').html(clinical_year);
		
		$('#selected_clinical_initiation_day').val(clinical_day);
		$('#selected_clinical_initiation_month').val(clinical_month);
		$('#selected_clinical_initiation_year').val(clinical_year);
		
		$('#active_pharmacy_initiation_day').html(clinical_day);
		$('#active_pharmacy_initiation_month').html(clinical_month);
		$('#active_pharmacy_initiation_year').html(clinical_year);
		
		$('#selected_pharmacy_initiation_day').val(clinical_day);
		$('#selected_pharmacy_initiation_month').val(clinical_month);
		$('#selected_pharmacy_initiation_year').val(clinical_year);
		
		$('#option_221').val($('#selected_clinical_initiation_month').val()+'/'+$('#selected_clinical_initiation_day').val()+'/'+$('#selected_clinical_initiation_year').val());
		
		$('#option_222').val($('#selected_pharmacy_initiation_month').val()+'/'+$('#selected_pharmacy_initiation_day').val()+'/'+$('#selected_pharmacy_initiation_year').val());
	}
</script>

<div style="width:213px;height:min-120px;height:auto;float:left;padding:2px;">
<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">Next Clinical Appointment</div>


<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;" id="clinical_date_holder"><div style="width:auto;min-height:30px;height:auto;float:left;">
<div style="line-height:30px;width:25px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;z-index:50">

<?php
if($form_option_value[221] == ''){
	$clinical_date = date('m/j/Y',time());
	
}else{
	$clinical_date = $form_option_value[221];
	
}

$clinical_date_array = explode('/',$clinical_date);

$clinical_day = $clinical_date_array[1];
$clinical_month = $clinical_date_array[0];
$clinical_year = $clinical_date_array[2];
?>

<div class="option_item" title="Click to change option" onclick="$('#initiation_clinical_day_menu').toggle('fast');" id="active_clinical_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($clinical_day);?></div>

<div class="option_menu" id="initiation_clinical_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_clinical_day_menu').toggle('fast');$('#active_clinical_initiation_day').html($(this).html());$('#selected_clinical_initiation_day').val(<?php print($d);?>);$('#option_221').val($('#selected_clinical_initiation_month').val()+'/'+$('#selected_clinical_initiation_day').val()+'/'+$('#selected_clinical_initiation_year').val());check_if_clinical_future()" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_clinical_day_menu').toggle('fast');$('#active_clinical_initiation_day').html($(this).html());$('#selected_clinical_initiation_day').val(<?php print($d);?>);$('#option_221').val($('#selected_clinical_initiation_month').val()+'/'+$('#selected_clinical_initiation_day').val()+'/'+$('#selected_clinical_initiation_year').val());check_if_clinical_future()" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_clinical_initiation_day" id="selected_clinical_initiation_day" value="<?php print($clinical_day);?>">
</div>

<div style="line-height:30px;width:37px;height:30px;float:left;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#initiation_clinical_month_menu').toggle('fast');" id="active_clinical_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($clinical_month);?></div>


<div class="option_menu" id="initiation_clinical_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_clinical_month_menu').toggle('fast');$('#active_clinical_initiation_month').html($(this).html());$('#selected_clinical_initiation_month').val(<?php print($m);?>);$('#option_221').val($('#selected_clinical_initiation_month').val()+'/'+$('#selected_clinical_initiation_day').val()+'/'+$('#selected_clinical_initiation_year').val());check_if_clinical_future()" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_clinical_month_menu').toggle('fast');$('#active_clinical_initiation_month').html($(this).html());$('#selected_clinical_initiation_month').val(<?php print($m);?>);$('#option_221').val($('#selected_clinical_initiation_month').val()+'/'+$('#selected_clinical_initiation_day').val()+'/'+$('#selected_clinical_initiation_year').val());check_if_clinical_future()" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_clinical_initiation_month" value="<?php print($clinical_month);?>">
</div>

<div style="line-height:30px;width:30px;height:30px;float:left;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative;z-index:50">

<div class="option_item" title="Click to change option" onclick="$('#initiation_clinical_year_menu').toggle('fast');" id="active_clinical_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($clinical_year);?></div>


<div class="option_menu" id="initiation_clinical_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_clinical_year_menu').toggle('fast');$('#active_clinical_initiation_year').html($(this).html());$('#selected_clinical_initiation_year').val(<?php print($y);?>);$('#option_221').val($('#selected_clinical_initiation_month').val()+'/'+$('#selected_clinical_initiation_day').val()+'/'+$('#selected_clinical_initiation_year').val());check_if_clinical_future()" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_clinical_initiation_year" id="selected_clinical_initiation_year" value="<?php print($clinical_year);?>">
</div>
<input type="hidden" value="<?php print($clinical_date);?>" id="option_221">
</div><div style="width:100%;height:20px;float:left;lie-height:20px;text-align:center;display:none;" id="clinical_date_validation_status"></div>
<input type="hidden" value="0" id="clinical_date_validation"></div>














<div style="float:left;width:100%;height:20px;line-height:20px;font-weight:bold;font-size:1.1em;text-align:left;">Next Pharmacy Appointment </div>

<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;" id="pharmacy_date_holder"><div style="width:auto;min-height:30px;height:auto;float:left;">
<div style="line-height:30px;width:25px;height:30px;float:left;">Day:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative">

<?php
if($form_option_value[222] == ''){
	$pharmacy_date = date('m/j/Y',time());
	
}else{
	$pharmacy_date = $form_option_value[222];
	
}

$pharmacy_date_array = explode('/',$pharmacy_date);

$pharmacy_day = $pharmacy_date_array[1];
$pharmacy_month = $pharmacy_date_array[0];
$pharmacy_year = $pharmacy_date_array[2];
?>

<div class="option_item" title="Click to change option" onclick="$('#initiation_pharmacy_day_menu').toggle('fast');" id="active_pharmacy_initiation_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($pharmacy_day);?></div>

<div class="option_menu" id="initiation_pharmacy_day_menu" style="display:none;">
<?php
if(date('m',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_pharmacy_day_menu').toggle('fast');$('#active_pharmacy_initiation_day').html($(this).html());$('#selected_pharmacy_initiation_day').val(<?php print($d);?>);$('#option_222').val($('#selected_pharmacy_initiation_month').val()+'/'+$('#selected_pharmacy_initiation_day').val()+'/'+$('#selected_pharmacy_initiation_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_pharmacy_day_menu').toggle('fast');$('#active_pharmacy_initiation_day').html($(this).html());$('#selected_pharmacy_initiation_day').val(<?php print($d);?>);$('#option_222').val($('#selected_pharmacy_initiation_month').val()+'/'+$('#selected_pharmacy_initiation_day').val()+'/'+$('#selected_pharmacy_initiation_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_pharmacy_initiation_day" id="selected_pharmacy_initiation_day" value="<?php print($pharmacy_day);?>">
</div>

<div style="line-height:30px;width:37px;height:30px;float:left;">Month:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative">

<div class="option_item" title="Click to change option" onclick="$('#initiation_pharmacy_month_menu').toggle('fast');" id="active_pharmacy_initiation_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($pharmacy_month);?></div>


<div class="option_menu" id="initiation_pharmacy_month_menu" style="display:none;">
<?php
if(date('m',time()) < 6){
	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_pharmacy_month_menu').toggle('fast');$('#active_pharmacy_initiation_month').html($(this).html());$('#selected_pharmacy_initiation_month').val(<?php print($m);?>);$('#option_222').val($('#selected_pharmacy_initiation_month').val()+'/'+$('#selected_pharmacy_initiation_day').val()+'/'+$('#selected_pharmacy_initiation_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($mo);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_pharmacy_month_menu').toggle('fast');$('#active_pharmacy_initiation_month').html($(this).html());$('#selected_pharmacy_initiation_month').val(<?php print($m);?>);$('#option_222').val($('#selected_pharmacy_initiation_month').val()+'/'+$('#selected_pharmacy_initiation_day').val()+'/'+$('#selected_pharmacy_initiation_year').val());check_if_pharmacy_future()" style="width:40px;"><?php print($mo);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" id="selected_pharmacy_initiation_month" value="<?php print($pharmacy_month);?>">
</div>

<div style="line-height:30px;width:30px;height:30px;float:left;">Year:</div>
<div style="width:40px;min-height:30px;height:auto;float:left;position:relative">

<div class="option_item" title="Click to change option" onclick="$('#initiation_pharmacy_year_menu').toggle('fast');" id="active_pharmacy_initiation_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($pharmacy_year);?></div>


<div class="option_menu" id="initiation_pharmacy_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 60);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#initiation_pharmacy_year_menu').toggle('fast');$('#active_pharmacy_initiation_year').html($(this).html());$('#selected_pharmacy_initiation_year').val(<?php print($y);?>);$('#option_222').val($('#selected_pharmacy_initiation_month').val()+'/'+$('#selected_pharmacy_initiation_day').val()+'/'+$('#selected_pharmacy_initiation_year').val());check_if_pharmacy_future()" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_pharmacy_initiation_year" id="selected_pharmacy_initiation_year" value="<?php print($pharmacy_year);?>">
<input type="hidden" value="<?php print($pharmacy_date);?>" id="option_222">

</div>

</div>
<div style="width:100%;height:20px;float:left;lie-height:20px;text-align:center;display:none;" id="pharmacy_date_validation_status"></div>
<input type="hidden" value="0" id="pharmacy_date_validation">
</div>
</div>
</div>
</div>
</div>
</div>


<script>
fetch_basic_details(<?php print($form_id);?>);

$('#client_province_<?php print($form_id);?>').html($('#active_client_province').html());
$('#client_district_<?php print($form_id);?>').html($('#active_client_hub').html());
$('#client_facility_<?php print($form_id);?>').html($('#active_client_site').html());

</script>