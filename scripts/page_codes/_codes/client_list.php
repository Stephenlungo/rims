

	<div class="general_menu_holder">
<div class="tab" style="width:145px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_client_list();tab_item_change(0);$('#selected_tab').val(0);$('#filter_options').slideUp('fast');">Mobilized</div>

<div class="tab" style="width:145px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_client_list();tab_item_change(1);$('#selected_tab').val(1);$('#filter_options').slideUp('fast');">Screened</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_client_list();tab_item_change(2);$('#selected_tab').val(2);$('#filter_options').slideUp('fast');">Initiated</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_client_list();tab_item_change(3);$('#selected_tab').val(3);$('#filter_options').slideUp('fast');">Re-started</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_5" onclick="fetch_client_list();tab_item_change(5);$('#selected_tab').val(5);$('#filter_options').slideUp('fast');" style="float:right;">Stopped</div>



<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="fetch_client_list();tab_item_change(4);$('#selected_tab').val(4);$('#filter_options').slideUp('fast');" style="float:right;border-left:solid 1px #ddd;">Defaulted</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_6" onclick="fetch_client_list();tab_item_change(6);$('#selected_tab').val(5);$('#filter_options').slideUp('fast');" style="float:right;">No risk (stopped)</div>
</div>
	
	

<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="detailed_list_status_bar"></div>

	<div style="width:auto;height:auto;float:left;">
		<div style="width:90px;height:30px;line-height:30px;float:left;">Quick report:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		<div class="option_item" title="Click to change option" onclick="$('#quick_report_menu').toggle('fast');" id="client_export_button" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';"  style="min-width:110px;max-width:270px;width:auto;background-color:#bbf;color:#fff;">Select report</div>

		<div class="option_menu" id="quick_report_menu" style="display:none;width:auto;width:290px;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');create_new_prep_report(0);">Create new</div>
		<?php
		$user_exeption_string = '285,109,548,542,69,345,344,598,201,202,111,218,632,92';
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="<?php if($user_results['region_id'] != 0 and !check_item_in_list($user_id,$user_exeption_string,0,',')){?> alert('You are not authorised to access this report'); <?php }else{ ?>$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');window.open($('#url').val()+'/files/original_prep_report.xlsx','report')<?php }?>">Full Report [New]</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="<?php if($user_results['region_id'] != 0 and !check_item_in_list($user_id,$user_exeption_string,0,',')){?> alert('You are not authorised to access this report'); <?php }else{ ?>$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');window.open($('#url').val()+'/files/original_prep_report_no_unset.xlsx','report')<?php }?>">Full Report [New - No unset]</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');export_prep_clients(-1,0);">Original PrEP Format</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');fetch_error_reports();">Error Report</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');alert('Upload in progress. Try again later');">Missed appointments</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');fetch_sms_ussd()">SMS Report</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');fetch_prep_ussd()">PrEP USSD Log</div>
			<?php
			
			if(!$user_results['region_id']){
				$report_filter = '';
				
			}else if(!$user_results['province_id']){
				$report_filter = ' and (region_id = '.$user_results['region_id'].' or region_id = 0)';
				
			}else if(!$user_results['hub_id']){
				$report_filter = ' and (region_id = '.$user_results['region_id'].' and province_id = '.$user_results['province_id'].' or region_id = 0 or province_id = 0)';
				
			}else if(!$user_results['site_id']){
				$report_filter = ' and (region_id = '.$user_results['region_id'].' and province_id = '.$user_results['province_id'].' and hub_id = '.$user_results['hub_id'].' or (region_id = 0) or (province_id = 0) or (hub_id = 0))';
				
			}else{
				$report_filter = ' and (region_id = '.$user_results['region_id'].' and province_id = '.$user_results['province_id'].' and hub_id = '.$user_results['hub_id'].' or site_id = 0)';
				
			}
			
			$prep_reports = mysqli_query($connect,"select * from dynamic_reports where company_id = $company_id and module_id = 3 and primary_column_type = 0 and dashboard_id = 0 and (accessibility_type = 0 or accessibility_type = $user_id) $report_filter");
			
			for($r=0;$r<mysqli_num_rows($prep_reports);$r++){
				$prep_report_results = mysqli_fetch_array($prep_reports,MYSQLI_ASSOC);
				$rule_string_array = explode(',',$prep_report_results['rule_string']);								if($prep_report_results['column_rule_string'] == ''){					$column_rule_array = array('','');									}else{					$column_rule_array = explode(']',$prep_report_results['column_rule_string']);
				}
				?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(<?php print($prep_report_results['id']);?>);$('#screening_question_level_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[0]));?>');$('#form_category_level_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[1]));?>');$('#screening_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[2]));?>');$('#profile_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[3]));?>');$('#form_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[4]));?>');$('#column_string').val('<?php print($column_rule_array[0]);?>');$('#column_value_string').val('<?php print($column_rule_array[1]);?>');create_new_prep_report(<?php print($prep_report_results['id']);?>);" id="quick_report_item_<?php print($prep_report_results['id']);?>"><?php print($prep_report_results['title']);?></div>
				<?php
			}
			?>
		</div>
		</div>
		<input type="hidden" id="selected_quick_report" value="0">
		
		<input type="hidden" id="form_rule_string" value="">
		<input type="hidden" id="form_category_level_rule_string" value="">				<input type="hidden" id="column_string" value="">		<input type="hidden" id="column_value_string" value="">
		
		<input type="hidden" id="screening_rule_string" value="">
		<input type="hidden" id="screening_question_level_rule_string" value="">
		
		<input type="hidden" id="profile_rule_string" value="">				
	</div>

<div class="general_button" style="float:left;width:80px;height:20px;line-height:20px;background-color:#bbf;color:#fff;display:none;" onclick="export_prep_clients(-1,0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry" id="client_export_button">Create quick report</div>

<div style="margin-left:60px;width:auto;height:20px;line-height:20px;float:left;border:solid 1px #ddd;padding:2px;background-color:#fee;"><div style="width:auto;height:20px;float:left;">Decryption key:</div>

<div style="width:auto;float:left;margin-left:5px;" id="decryption_key_holder">
<?php



if($user_results['prep_decryption_key_id']){
	
	$key_id = $user_results['prep_decryption_key_id'];
		
	$this_key = mysqli_query($connect,"select * from prep_decryption_keys where id = $key_id")or die(mysqli_error($connect));
	$this_key_results = mysqli_fetch_array($this_key,MYSQLI_ASSOC);
	$key_expiry = $this_key_results['expiry_date'];
	
	if($user_results['code_session_expiry'] > time()){
		$dencryption_key = $this_key_results['key_code'];
		$key_color = '#000';
		
	}else{
		$dencryption_key = 'Enter key';
		$key_color = '#aaa';
	}
	 
}else{
	$dencryption_key = 'Enter key';
	$key_color = '#aaa';
	$key_expiry = 0;
}

if($active_user_roles[19] and $key_expiry < time()){
	?>
	<div style="width:120px;margin-left:5px;height:20px;line-height:20px;text-align:center;float:left;background-color:#83b30f;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#8abc10';" onmouseout="this.style.backgroundColor='#83b30f';" onclick="generate_decryption_key()" id="generate_key" >Generate key</div>
	<?php
	
}else{
	?>
	<input type="text" id="dencryption_key" style="height:20px;width:200px;float:left;color:<?php print($key_color);?>" onfocus="if(this.value=='Enter key'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='<?php print($dencryption_key);?>';this.style.color='<?php print($key_color);?>';}" value="<?php print($dencryption_key);?>">
	
	<?php
	
	if($user_results['code_session_expiry'] < time()){
		?>
		
		<div style="width:50px;height:20px;float:left;margin-left:5px;background-color:#83b30f;text-align:center;line-height:20px;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#8abc10';" onmouseout="this.style.backgroundColor='#83b30f';" onclick="validate_key();" id="code_validate_button">Check</div>
		
		<?php
		
	}
}
?>

</div>
</div> 
<div class="general_button" style="float:right;width:80px;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="$('#filter_options').slideUp('fast');fetch_client_details(0,0,0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New Client</div> <div class="general_button" style="float:right;width:220px;height:20px;line-height:20px;background-color:purple;color:#fff;" onclick="$('#filter_options').slideUp('fast');window.open($('#url').val()+'/rimsoffline.zip','new_download');" onmouseover="this.style.backgroundColor = '#b663b6';" onmouseout="this.style.backgroundColor = 'purple';" title="Click to Download offline version of the system" id="send_offline_pipat_button">Download Offline System Version</div><div class="general_button" style="float:right;width:120px;height:20px;line-height:20px;background-color:#25d4d8;color:#fff;display:none;" onclick="$('#checklists').slideToggle('fast');" onmouseover="this.style.backgroundColor = '#25bfc3';" onmouseout="this.style.backgroundColor = '#25d4d8';" title="Click to show or hide checklist docker">Check-List Dock</div>
<div class="general_button" style="display:none;float:right;width:120px;height:20px;line-height:20px;background-color:#fe269e;color:#fff;" onclick="window.open($('#url').val()+'/prepassess.php?uid=0','self_assess');" onmouseover="this.style.backgroundColor = '#9e269e';" onmouseout="this.style.backgroundColor = '#fe269e';" title="Click to open self-assessment window">Self Assessment</div>


</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eee;" id="client_result_status"></div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><div style="width:100px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:80px;height:20px;float:left;margin-right:3px;">PrEP ID</div>
<div style="width:160px;height:20px;float:left;margin-right:3px;">Names</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Phone</div>
<div style="width:50px;height:20px;float:left;margin-right:3px;">Gender</div>
<div style="width:40px;height:20px;float:left;margin-right:3px;">Age</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:110px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Facility</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Pop. Category</div></div>

<div style="width:100%;hight:auto;float:left;" id="client_list_holder"></div>
<input type="hidden" id="active_client_status" value="<?php print($a);?>">
<script>
fetch_client_list();

</script>