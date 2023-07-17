
<div style="width:100%;border-bottom:solid 1px #eee;margin-top:-3px;margin-bottom:5px;float:left;">
<div class="general_menu_holder" style="height:auto;line-height:25px;width:100%;">
<?php
$dynamic_form_data_set_array = new_fetch_db_table('connect','dynamic_form_data_sets',1,'id',' client_id = '.$client_id);

$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id and module_id = 6 and status = 1 order by _order")or die(mysqli_error($connect));


?>

<div class="tab" style="min-height:25px;height:auto;line-height:25px;border-right:none;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_10" onclick="$('#dynamic_form_holder').slideUp('fast');$('#new_client_error_message').slideUp('fast');$('#client_profile').hide();$('#client_screening').fadeIn('fast');tab_item_change(10);<?php for($dd=0;$dd<mysqli_num_rows($dynamic_forms);$dd++){?> $('#dynamic_form_<?php print($dd);?>').hide();<?php }?>;change_window_size('item_details',736,500,1);$('#client_update_holder').hide();">Screening</div>

<div class="tab" style="min-height:25px;height:auto;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_11" onclick="if($('#client_screening_validated').val() == 0){alert('It appears you have not yet completed the eligibility screening. You need to complete the screening before proceeding');}else{$('#dynamic_form_holder').slideUp('fast');$('#new_client_error_message').slideUp('fast');$('#client_update_holder').slideDown('fast');$('#client_profile').fadeIn('fast');$('#client_screening').hide();tab_item_change(11);<?php for($dd=0;$dd<mysqli_num_rows($dynamic_forms);$dd++){?> $('#dynamic_form_<?php print($dd);?>').hide();<?php }?>;change_window_size('item_details',820,500,1);}">Profile</div>

<?php 


for($d=0;$d<mysqli_num_rows($dynamic_forms);$d++){
	$dynamic_form_results = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
	?>

<div class="tab" style="min-height:25px;height:auto;line-height:25px;min-width:160px;width:auto;padding-left:5px;padding-right:5px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_<?php print(12 + $d);?>" onclick="check_form_dependencies(<?php print($dynamic_form_results['id'].','.(12 + $d));?>)"><?php print($dynamic_form_results['form_title']);?></div>

<?php

$data_set_index = array_keys($dynamic_form_data_set_array[1]['dynamic_form_id'],$dynamic_form_results['id']);

$this_form_done = 0;
if(isset($data_set_index[0])){
	$this_form_done = 1;
	
}

?>

<input type="hidden" id="dynamic_form_<?php print($dynamic_form_results['id']);?>_done" value="<?php print($this_form_done);?>">
<input type="hidden" id="dynamic_form_<?php print($dynamic_form_results['id']);?>_name" value="<?php print($dynamic_form_results['form_title']);?>">
<input type="hidden" id="form_dependencies_<?php print($dynamic_form_results['id']);?>" value="<?php print($dynamic_form_results['dependencies']);?>">
<?php

}
?>
</div>
<script>
function check_form_dependencies(form_id,form_index){
	var form_width = 1000;
	form_height = 500;
	if(form_id == 8){
		form_width = 1100;
		form_height = 550;
	}
	var dependencies_string = $('#form_dependencies_'+form_id).val();
	var dependencies_array = dependencies_string.split(',');
	
	var dependencies_passed = 1;
	var missing_form_name = '';
	for(var d=0;d<dependencies_array.length;d++){
		if($('#dynamic_form_'+dependencies_array[d]+'_done').val() == 0){
			dependencies_passed = 0;
			
			if(missing_form_name == ''){
				missing_form_name = $('#dynamic_form_'+dependencies_array[d]+'_name').val();
				
			}else{
				missing_form_name = missing_form_name+','+$('#dynamic_form_'+dependencies_array[d]+'_name').val();
				
			}
		}		
	}
	
	if(dependencies_passed==1){
		if($('#client_profile_validated').val() == 0){
			alert('Oops!! You first need to complete the client profile form');
			
		}else{
			fetch_dynamic_form_list(form_id,0);tab_item_change(form_index);change_window_size('item_details',form_width,form_height,1);
		}
	}else{
		alert('You need to complete the following forms: '+missing_form_name)
		
	}
}
</script>


</div>
<div style="display:none;width:100%;min-height:30px;height:auto;line-height:20px;float:left;color:green;font-weight:bold;text-align:center;" id="client_update_status"></div>
<?php
if($client_id){
	$default_color = '#000';
	$button_text = 'Update';
	$client_name = $this_client_results['_name'];
	$client_nrc = $this_client_results['id_number'];
	$client_date = $this_client_results['_date'];
	$client_sex_id = $this_client_results['sex'];	
	$client_age = $this_client_results['age'];
	$client_phone_numbers = $this_client_results['phone'];
	
	
	if($this_client_results['email'] == ''){
		$client_email = 'Enter email address here';
		
	}else{
		$client_email = $this_client_results['email'];
		
	}
	
	$this_agent_id = $this_client_results['agent_id'];
	
	if($this_client_results['agent_id']){		
		$this_agent = mysqli_query($connect,"select * from agents where id = $this_agent_id")or die(mysqli_error($connecyy));
		$this_agent_results = mysqli_fetch_array($this_agent,MYSQLI_ASSOC);
		
		$this_agent_name = $this_agent_results['_name'];
		
		$this_agent_date = $this_agent_results['_date'];
		
		$this_agent_phone = mysqli_query($connect,"select * from phone_numbers where agent_date = '$this_agent_date' and company_id = $company_id")or die(mysqli_error($connect));
		
		$agent_phone_string = '';
		for($ap=0;$ap<mysqli_num_rows($this_agent_phone);$ap++){
			$this_agent_phone_results = mysqli_fetch_array($this_agent_phone,MYSQLI_ASSOC);
			
			if($agent_phone_string == ''){
				$agent_phone_string = $this_agent_phone_results['phone_number'];
				
			}else{
				$agent_phone_string .= ','.$this_agent_phone_results['phone_number'];
				
			}		
		}
	
	}else{
		$this_agent_name = '<i>Unspecified</i>';
		$agent_phone_string = '';
	}
	
	if(!$client_sex_id){
		$client_gender_title = 'Select gender';
		
	}else{
	
		$client_gender = mysqli_query($connect,"select * from genders where id = $client_sex_id")or die(mysqli_error($connect));
		$client_gender_results = mysqli_fetch_array($client_gender,MYSQLI_ASSOC);
		$client_gender_title = $client_gender_results['title'];
		
	}
	$client_region_id = $this_client_results['region_id'];
	
	if(!$client_region_id){
		$this_region_title = 'Select region';
		$client_region_id = -1;
		
	}else{
		
		$this_region = mysqli_query($connect,"select * from regions where id = $client_region_id")or die(mysqli_error($connect));
		$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);		
		$this_region_title = $this_region_results['title'];
	}
	
	$this_province_id = $this_client_results['province_id'];
	if(!$this_province_id){
		$this_province_title = 'All Provinces';
		
	}else{
		$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
		$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);		
		$this_province_title = $this_province_results['title'];		
	}
	
	$this_hub_id = $this_client_results['hub_id'];
	if(!$this_hub_id){
		$this_hub_title = 'All Hubs';
		
	}else{
		$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
		$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);		
		$this_hub_title = $this_hub_results['title'];
	}
	
	$this_site_id = $this_client_results['site_id'];
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);		
		$this_site_title = $this_site_results['title'];
	}
	
	$active_client_status_id = $this_client_results['status'];
	
	if($active_client_status_id == 0){
		$active_client_status_title = 'Inactive';
		
	}else if($active_client_status_id == 1){
		$active_client_status_title = 'Active';
		
	}
	
	$case_classification_id = $this_client_results['case_classification_id'];
	
	if($case_classification_id == -1){
		$case_classification_title = 'Select item';
		
	}else if($case_classification_id == 0){
		$case_classification_title = 'Suspect';
		
	}else if($case_classification_id == 1){
		$case_classification_title = 'Probable';
		
	}else if($case_classification_id == 2){
		$case_classification_title = 'Confirmed';
		
	}
	
	
	
}else{
	$default_color = '#aaa';
	$button_text = 'Create';
	$client_name = 'Enter client name here';
	$client_nrc = 'Enter NRC here';
	$client_sex_id = 0;
	$client_gender_title = 'Select gender';
	$client_date = 0;
	
	$this_agent_name = '<i>Unspecified</i>';
	$agent_phone_string = '';
	
	$client_messaging_schedule_id = 0;
	$message_schedule_title = 'Don\'t assign';
	
	$this_agent_id = 0;
	
	$client_age = 'Enter age here';
	$client_email = 'Enter email address here';
	$client_username = time();
	$client_password = 'pipat';
	
	$job_title = 'Enter job title here';
	$client_phone_numbers = 'Enter phone number here';
	
	
	$client_region_id = $user_results['region_id'];
	if(!$client_region_id){
		$client_region_title = 'Select region';
		$client_region_id = -1;
		
	}else{		
		$this_region = mysqli_query($connect,"select * from regions where id = $client_region_id")or die(mysqli_error($connect));
		$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);		
		$client_region_title = $this_region_results['title'];
	}
	
	$this_province_id = $user_results['province_id'];
	if(!$this_province_id){
		$this_province_title = 'All Provinces';
		
	}else{
		$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
		$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);		
		$this_province_title = $this_province_results['title'];		
	}
	
	$this_hub_id = $user_results['hub_id'];
	if(!$this_hub_id){
		$this_hub_title = 'All Hubs';
		
	}else{
		$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
		$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);		
		$this_hub_title = $this_hub_results['title'];
	}
	
	$this_site_id = $user_results['site_id'];
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);		
		$this_site_title = $this_site_results['title'];
	}
	
	$active_client_status_id = 0;
	$active_client_status_title = 'Mobilized';
	
	$case_classification_id = -1;
	$case_classification_title = 'Select item';
	
	
}
?>
<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="new_client_error_message"></div>
<div class="general_holder" id="client_profile">
<div style="width:400px;float:left;height:auto;">
<div style="width:100%;height:20px;line-height:20px;color:#000;float:left;background-color:#ddf;text-align:center;margin-bottom:5px;">Client's basic details</div>
<input type="hidden" id="client_profile_validated" value="0">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Names*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($client_name);?>"  id="client_name" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter client name here'){this.value='';this.style.color='#000'}$('#new_client_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($client_name);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Mobile Numbers*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($client_phone_numbers);?>"  id="client_phone" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter phone number here'){this.value='';this.style.color='#000'}$('#phone_number_error').slideUp('fast');this.style.borderColor='#aaa';$('#new_client_error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='<?php print($client_phone_numbers);?>';this.style.color='<?php print($default_color);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;margin-bottom:10px;" id="phone_number_error"></div>
<input type="hidden" id="phone_number_error_input" value="0">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">NRC Number*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($client_nrc);?>"  id="client_nrc" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter NRC here'){this.value='';this.style.color='#000'}$('#new_client_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($client_nrc);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Age*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($client_age);?>"  id="client_age" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter age here'){this.value='';this.style.color='#000'}$('#new_client_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($client_age);?>';this.style.color='<?php print($default_color);?>'}else{if(isNaN(this.value)){alert('Age must be a number');this.value='<?php print($client_age);?>';this.style.color='<?php print($default_color);?>';}}population_category_validation();"></div>
</div>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Email:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($client_email);?>"  id="client_email" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter email address here'){this.value='';this.style.color='#000'}$('#new_client_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($client_email);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Sex:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#sex_menu').toggle('fast');" id="active_sex" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($client_gender_title);?></div>

			<div class="option_menu" id="sex_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			$gender = mysqli_query($connect,"select * from genders order by title")or die(mysqli_error($connect));
			
			for($g=0;$g<mysqli_num_rows($gender);$g++){
				$gender_results = mysqli_fetch_array($gender,MYSQLI_ASSOC);
				?>
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sex_menu').toggle('fast');$('#active_sex').html($(this).html());$('#client_selected_sex').val(<?php print($gender_results['id']);?>);$('#new_client_error_message').slideUp('fast');population_category_validation()"><?php print($gender_results['title']);?></div>
				
				<?php
			}
			?>
					
			</div>
	</div>
	<input type="hidden" id="client_selected_sex" value="<?php print($client_sex_id);?>">
</div>
</div>

</div>
<div style="width:380px;float:right;height:auto;">
<div style="width:100%;height:20px;line-height:20px;color:#000;float:left;background-color:#ddf;text-align:center;margin-bottom:5px;">Client's facility and classification</div>
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#client_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for clients');<?php }?>" id="active_client_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="client_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_region_menu').toggle('fast');$('#active_client_region').html($(this).html());$('#selected_client_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'client_province',1,1,'connect-hubs-province_id-{id}-client_hub-1-1|connect-sites-hub_id-{id}-client_site-1-1|connect-agents-site_id-{id}-client_agent-1-1');$('#new_client_error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_client_region" value="<?php print($client_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Province*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#client_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for clients');<?php }?>" id="active_client_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="client_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $client_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_province_menu').toggle('fast');$('#active_client_province').html($(this).html());$('#selected_client_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'client_hub',1,1,'connect-sites-hub_id-{id}-client_site-1-1');$('#new_client_error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_client_province" value="<?php print($this_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Hub*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#client_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for clients');<?php }?>" id="active_client_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="client_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_hub_menu').toggle('fast');$('#active_client_hub').html($(this).html());$('#selected_client_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'client_site',1,1,'');$('#new_client_error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_client_hub" value="<?php print($this_hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Facility*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#client_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify site settings for clients');<?php }?>" id="active_client_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="client_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id and active_status = 1 order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_site_menu').toggle('fast');$('#active_client_site').html($(this).html());$('#selected_client_site').val(<?php print($site_menu_results['id']);?>);$('#new_client_error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_client_site" value="<?php print($this_site_id);?>">
</div>


<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Agent:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#client_agent_menu').toggle('fast');" id="active_client_agent" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;line-height:20px;"><?php print($this_agent_name.'<br>'.$agent_phone_string);?></div>

			<div class="option_menu" id="client_agent_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_agent_menu').toggle('fast');$('#active_client_agent').html($(this).html());$('#selected_client_agent').val(0);$('#new_client_error_message').slideUp('fast');">Unspecified</div>
			
				<?php
				
					$agent_menu = mysqli_query($connect,"select * from agents where company_id = $company_id and status = 1 order by _name")or die(mysqli_error($connect));

					for($a=0;$a<mysqli_num_rows($agent_menu);$a++){
						$agent_menu_results = mysqli_fetch_array($agent_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_agent_menu').toggle('fast');$('#active_client_agent').html($(this).html());$('#selected_client_agent').val(<?php print($agent_menu_results['id']);?>);$('#new_client_error_message').slideUp('fast');"><?php print($agent_menu_results['_name']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_client_agent" value="<?php print($this_agent_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Case classification:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#case_classification_menu').toggle('fast');" id="active_case_classification" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($case_classification_title);?></div>

		<div class="option_menu" id="case_classification_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#case_classification_menu').toggle('fast');$('#active_case_classification').html($(this).html());$('#selected_case_classification').val(0);">Suspect</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#case_classification_menu').toggle('fast');$('#active_case_classification').html($(this).html());$('#selected_case_classification').val(1);">Probable</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#case_classification_menu').toggle('fast');$('#active_case_classification').html($(this).html());$('#selected_case_classification').val(2);">Confirmed</div>
		</div>
	</div>
	<input type="hidden" id="selected_case_classification" value="<?php print($case_classification_id);?>">
</div>






<div style="width:100%;height:auto;float:left;margin-bottom:2px;display:none;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Client Category:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#profile_client_status_menu').toggle('fast');" id="active_profile_client_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($active_client_status_title);?></div>

		<div class="option_menu" id="profile_client_status_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#profile_client_status_menu').toggle('fast');$('#active_profile_client_status').html($(this).html());$('#selected_profile_client_status').val(3);$('#new_client_error_message').slideUp('fast');">Re-started</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#profile_client_status_menu').toggle('fast');$('#active_profile_client_status').html($(this).html());$('#selected_profile_client_status').val(6);$('#new_client_error_message').slideUp('fast');">No risk (Stopped)</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#profile_client_status_menu').toggle('fast');$('#active_profile_client_status').html($(this).html());$('#selected_profile_client_status').val(4);$('#new_client_error_message').slideUp('fast');">Defaulted</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#profile_client_status_menu').toggle('fast');$('#active_profile_client_status').html($(this).html());$('#selected_profile_client_status').val(5);$('#new_client_error_message').slideUp('fast');">Stopped</div>

		</div>
	</div>
	<input type="hidden" id="selected_profile_client_status" value="<?php print($active_client_status_id);?>">
</div>

</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="client_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_profile_button" onclick="create_or_update_covid_client();" title="Click to update account details">Update</div>

<?php
if($client_id){
	
	if($this_client_results['account_status']){
		$new_status = 0;
		$button_text = 'Disable';
		$bg_color = '#aaa';
		$hover_color = '#bbb';
		
	}else{
		$new_status = 1;
		$button_text = 'Enable';
		$bg_color = '#7a7';
		$hover_color = '#9b9';
		
		
	}
	
	?>
<div style="width:60px;height:30px;background-color:<?php print($bg_color);?>;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($bg_color);?>';"  id="client_status_button" onclick="change_client_status(<?php print($client_id.','.$new_status);?>);" title="Click to change account status"><?php print($button_text);?></div>


<?php

if($active_user_roles[7]){
		?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#e99';" onmouseout="this.style.backgroundColor='brown';"  id="client_delete_button" onclick="delete_client(<?php print($client_id);?>);" title="Click to delete account">Delete</div>


<?php

	
}

}
if($client_id){
	?>

<script>

$('#client_profile_validated').val(1);
</script>
<?php
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;display:none;" id="dynamic_form_holder">

<?php 
$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id and status = 1 order by _order")or die(mysqli_error($connect));
$dynamic_form_string = '';
for($d=0;$d<mysqli_num_rows($dynamic_forms);$d++){
	$dynamic_form_results = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
	$form_id = $dynamic_form_results['id'];
	$form_ind = $d+12;	
	if($dynamic_form_string == ''){
		$dynamic_form_string = $form_id;
		
	}else{
		$dynamic_form_string .= ','.$form_id;
		
	}
	
	?>


	<div class="general_holder" id="dynamic_form_<?php print($form_id);?>" style="display:none;">
	<?php 

	/*if($dynamic_form_results['custom_script'] != ''){
		//include $dynamic_form_results['custom_script'];
		
	}else{
		//include 'dynamic_form.php';
		
	}*/
	?>

	</div>
	<input type="hidden" id="dynamic_form_populated_<?php print($form_id);?>" value="0">
	<input type="hidden" id="dynamic_form_title_<?php print($form_id);?>" value="<?php print($dynamic_form_results['form_title']);?>">
	<input type="hidden" id="dynamic_form_validated_<?php print($form_id);?>" value="0">
	<?php
}
?>
<input type="hidden" id="dynamic_forms" value="<?php print($dynamic_form_string);?>">
</div>



<div class="general_holder" id="client_screening" style="display:none;">
<div style="width:100%;height:auto;float:left;" id="screen_details_holder">
<?php
include 'screening_start.php';
?>

</div>
</div>

<script>
<?php
if($client_id){
	?>
	$('#tab_11').click();
	<?php
}else{
	?>
	$('#tab_10').click();
	<?php
}
?>

</script>
