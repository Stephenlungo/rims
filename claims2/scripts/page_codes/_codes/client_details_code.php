
<div style="width:100%;border-bottom:solid 1px #eee;margin-top:-3px;margin-bottom:5px;float:left;">
<div class="general_menu_holder" style="height:auto;line-height:25px;width:100%;">
<?php
$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id and status = 1 order by _order")or die(mysqli_error($connect));

?>

<div class="tab" style="min-height:25px;height:auto;line-height:25px;border-right:none;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_10" onclick="$('#dynamic_form_holder').slideUp('fast');$('#new_client_error_message').slideUp('fast');$('#client_profile').hide();$('#client_screening').fadeIn('fast');tab_item_change(10);<?php for($dd=0;$dd<mysqli_num_rows($dynamic_forms);$dd++){?> $('#dynamic_form_<?php print($dd);?>').hide();<?php }?>;change_window_size('item_details',736,500,1);$('#client_update_holder').hide();">Screening</div>

<div class="tab" style="min-height:25px;height:auto;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_11" onclick="if($('#client_screening_validated').val() == 0){alert('It appears you have not yet completed the eligibility screening. You need to complete the screening before proceeding');}else{$('#dynamic_form_holder').slideUp('fast');if($('#client_profile_updated').val() == 0){populate_profile_data();}$('#new_client_error_message').slideUp('fast');$('#client_update_holder').slideDown('fast');$('#client_profile').fadeIn('fast');$('#client_screening').hide();tab_item_change(11);<?php for($dd=0;$dd<mysqli_num_rows($dynamic_forms);$dd++){?> $('#dynamic_form_<?php print($dd);?>').hide();<?php }?>;change_window_size('item_details',820,500,1);}">Profile</div>

<?php 


for($d=0;$d<mysqli_num_rows($dynamic_forms);$d++){
	$dynamic_form_results = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
	?>

<div class="tab" style="min-height:25px;height:auto;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_<?php print(12 + $d);?>" onclick="if($('#client_profile_validated').val() == 0){alert('Oops!! You first need to complete the client profile form');}else{fetch_dynamic_form_list(<?php print($dynamic_form_results['id']);?>,0);tab_item_change(<?php print(12 + $d);?>);change_window_size('item_details',1000,500,1);}"><?php print($dynamic_form_results['form_title']);?></div>

<?php
}
?>
</div>



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
	
	$client_messaging_schedule_id = $this_client_results['message_schedule_id'];
	$this_messaging_schedule = mysqli_query($connect,"select * from prep_message_scheduler where id = $client_messaging_schedule_id")or die(mysqli_error($connect));
	$this_messaging_schedule_results = mysqli_fetch_array($this_messaging_schedule,MYSQLI_ASSOC);
	
	$message_schedule_title = $this_messaging_schedule_results['title'];
	
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

	$client_gender = mysqli_query($connect,"select * from genders where id = $client_sex_id")or die(mysqli_error($connect));
	$client_gender_results = mysqli_fetch_array($client_gender,MYSQLI_ASSOC);
	$client_gender_title = $client_gender_results['title'];
	
	$this_region_id = $this_client_results['region_id'];
	if(!$this_region_id){
		$this_region_title = 'Select region';
		$this_region_id = -1;
		
	}else{		
		$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
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
		$active_client_status_title = 'Mobilized';
		
	}else if($active_client_status_id == 1){
		$active_client_status_title = 'Screened';
		
	}else if($active_client_status_id == 2){
		$active_client_status_title = 'Initiated';
		
	}else if($active_client_status_id == 3){
		$active_client_status_title = 'Re-Started';
		
	}else if($active_client_status_id == 4){
		$active_client_status_title = 'defaulted';
		
	}else if($active_client_status_id == 5){
		$active_client_status_title = 'Stopped';
		
	}else if($active_client_status_id == 6){
		$active_client_status_title = 'No risk (Stopped)';
		
	}
	
	$population_category_id = $this_client_results['population_category_id'];
	
	if($population_category_id == 0){
		$population_category_title = 'General';
		
	}else if($population_category_id == 1){
		$population_category_title = 'MSM';
		
	}else if($population_category_id == 2){
		$population_category_title = 'DC';
		
	}else if($population_category_id == 3){
		$population_category_title = 'FSW';
		
	}else if($population_category_id == 4){
		$population_category_title = 'PLM';
		
		
	}else if($population_category_id == 5){
		$population_category_title = 'AG/YW';
		
		
	}else if($population_category_id == 6){
		$population_category_title = 'Police Officer';
		
		
	}else if($population_category_id == 7){
		$population_category_title = 'Inmates';
		
		
	}else if($population_category_id == 8){
		$population_category_title = 'Prison Officer';
		
	}
	
	$implementing_partner_id = $this_client_results['implementing_partner_id'];
	if($implementing_partner_id == 1){
		$implementing_partner_title = 'USAID DISCOVER-Health';
		
	}else if($implementing_partner_id == 2){
		$implementing_partner_title = 'DREAMS';
		
	}else if($implementing_partner_id == 3){
		$implementing_partner_title = 'Open Doors';
		
	}else if($implementing_partner_id == 4){
		$implementing_partner_title = 'Self-Referral';
		
		
	}else if($implementing_partner_id == 5){
		$implementing_partner_title = 'Other';
		
		
	}
	
	$knowledge_source_id = $this_client_results['knowledge_source_id'];
	if($knowledge_source_id == 1){
		$knowledge_source_title = 'USAID DISCOVER-Health Staff';
		
	}else if($knowledge_source_id == 2){
		$knowledge_source_title = 'DREAMS';
		
	}else if($knowledge_source_id == 3){
		$knowledge_source_title = 'Open Doors';
		
	}else if($knowledge_source_id == 4){
		$knowledge_source_title = 'TV';
		
	}else if($knowledge_source_id == 5){
		$knowledge_source_title = 'Radio';
		
	}else if($knowledge_source_id == 6){
		$knowledge_source_title = 'Print Media';
		
	}else if($knowledge_source_id == 7){
		$knowledge_source_title = 'Social Media';
		
	}else if($knowledge_source_id == 8){
		$knowledge_source_title = 'Other';
		
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
	
	
	$this_region_id = $user_results['region_id'];
	if(!$this_region_id){
		$this_region_title = 'Select region';
		$this_region_id = -1;
		
	}else{		
		$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
		$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);		
		$this_region_title = $this_region_results['title'];
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
	
	$population_category_id = 0;
	$population_category_title = 'General';
	
	$implementing_partner_id = 1;
	$implementing_partner_title = 'USAID DISCOVER-Health';
	
	$knowledge_source_id = 1;
	$knowledge_source_title = 'USAID DISCOVER-Health Staff';
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
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($client_age);?>"  id="client_age" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter age here'){this.value='';this.style.color='#000'}$('#new_client_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($client_age);?>';this.style.color='<?php print($default_color);?>'}else{if(isNaN(this.value)){alert('Age must be a number');this.value='<?php print($client_age);?>';this.style.color='<?php print($default_color);?>';}}"></div>
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
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sex_menu').toggle('fast');$('#active_sex').html($(this).html());$('#client_selected_sex').val(<?php print($gender_results['id']);?>);$('#new_client_error_message').slideUp('fast');"><?php print($gender_results['title']);?></div>
				
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
<div style="width:100%;height:20px;line-height:20px;color:#000;float:left;background-color:#ddf;text-align:center;margin-bottom:5px;">Client's facility and categorization</div>
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
	<input type="hidden" id="selected_client_region" value="<?php print($this_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Province*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#client_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for clients');<?php }?>" id="active_client_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="client_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

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
<div style="width:140px;height:30px;line-height:30px;float:left;">Population category:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#population_category_menu').toggle('fast');" id="active_population_category" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($population_category_title);?></div>

		<div class="option_menu" id="population_category_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(6);">Police Officer</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(7);">Inmates</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(8);">Prison Officer</div>
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(0);">General</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(1);">MSM</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(2);">DC</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(3);">FSW</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(4);">PLM</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#population_category_menu').toggle('fast');$('#active_population_category').html($(this).html());$('#selected_population_category').val(5);">AG/YW</div>
			
		
		</div>
	</div>
	<input type="hidden" id="selected_population_category" value="<?php print($population_category_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Implementing Partner:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#implementing_partner_menu').toggle('fast');" id="active_implementing_partner" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($implementing_partner_title);?></div>

		<div class="option_menu" id="implementing_partner_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#implementing_partner_menu').toggle('fast');$('#active_implementing_partner').html($(this).html());$('#selected_implementing_partner').val(1);">USAID DISCOVER-Health</div>

			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#implementing_partner_menu').toggle('fast');$('#active_implementing_partner').html($(this).html());$('#selected_implementing_partner').val(2);">DREAMS</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#implementing_partner_menu').toggle('fast');$('#active_implementing_partner').html($(this).html());$('#selected_implementing_partner').val(3);">Open Doors</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#implementing_partner_menu').toggle('fast');$('#active_implementing_partner').html($(this).html());$('#selected_implementing_partner').val(4);">Self-Referral</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#implementing_partner_menu').toggle('fast');$('#active_implementing_partner').html($(this).html());$('#selected_implementing_partner').val(5);">Other</div>
			
		
		</div>
	</div>
	<input type="hidden" id="selected_implementing_partner" value="<?php print($implementing_partner_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;min-height:30px;height:auto;line-height:15px;float:left;">Client source of knowledge of service:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#knowledge_source_menu').toggle('fast');" id="active_knowledge_source" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($knowledge_source_title);?></div>

		<div class="option_menu" id="knowledge_source_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(1);">USAID DISCOVER-Health Staff</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(2);">DREAMS</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(3);">Open Doors</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(4);">TV</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(5);">Radio</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(6);">Print Media</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(7);">Social Media</div>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#knowledge_source_menu').toggle('fast');$('#active_knowledge_source').html($(this).html());$('#selected_knowledge_source').val(8);">Other</div>

			
			
			
		
		</div>
	</div>
	<input type="hidden" id="selected_knowledge_source" value="<?php print($knowledge_source_id);?>">
</div>



<div style="width:100%;height:auto;float:left;margin-bottom:2px;<?php if(!$client_id){print('display:none;');}?>">
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

<div style="width:100%;height:auto;float:left;margin-bottom:2px;<?php if(!$client_id || $active_client_status_id < 2){print('display:none;');}?>">
<div style="width:140px;height:30px;line-height:30px;float:left;">Messaging schedule:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="$('#messaging_schedule_menu').toggle('fast');" id="active_messaging_schedule" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($message_schedule_title);?></div>

		<div class="option_menu" id="messaging_schedule_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#messaging_schedule_menu').toggle('fast');$('#active_messaging_schedule').html($(this).html());$('#selected_messaging_schedule_id').val(0);">Don't assign</div>
			
			<?php
			$schedulers = mysqli_query($connect,"select * from prep_message_scheduler where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($s=0;$s<mysqli_num_rows($schedulers);$s++){
				$schedulers_results = mysqli_fetch_array($schedulers,MYSQLI_ASSOC);	
					?>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#messaging_schedule_menu').toggle('fast');$('#active_messaging_schedule').html($(this).html());$('#selected_messaging_schedule_id').val(<?php print($schedulers_results['id']);?>);"><?php print($schedulers_results['title']);?></div>
					<?php
			}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_messaging_schedule_id" value="<?php print($client_messaging_schedule_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="client_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_profile_button" onclick="create_or_update_client();" title="Click to update account details">Update</div>

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




<?php
//print($this_form_ind);
if($client_id){	
	?>
<script>
<?php
if(!$this_form_ind){
	?>
$('#tab_11').click();
<?php
}else{
	//print($this_form_ind);
	?>
	$('#tab_<?php print($this_form_ind);?>').click();
	<?php
}
?>
</script>
<?php
}else{
	?>
	<script>
$('#tab_10').click();

</script>
	<?php
}
?>