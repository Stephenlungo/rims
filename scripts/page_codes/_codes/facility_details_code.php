<?php
if($facility_id){
	$this_facility =  mysqli_query($connect,"select * from sites where id = $facility_id")or die(mysqli_error($connect));
	$facility_results = mysqli_fetch_array($this_facility,MYSQLI_ASSOC);
	$site_title = $facility_results['title'];
	$site_type = $facility_results['status'];
	$gsm_code = $facility_results['gsm_code'];	$gsm_code_2 = $facility_results['gsm_code_2'];
	$gps_code = $facility_results['gps_code'];
		
	$site_identified_date = $facility_results['identified'];
	$site_assessed_date = $facility_results['assessment'];
	$site_started_date = $facility_results['started'];
	
	if($site_identified_date == ''){
		$identified_title = 'Not set';
		
	}else{
		$identified_title = date('m/d/Y',$site_identified_date);
		
	}
	
	if($site_assessed_date == ''){
		$assessed_title = 'Not set';
		
	}else{
		$assessed_title = date('m/d/Y',$site_assessed_date);
		
	}
	
	if($site_started_date == ''){
		$started_title = 'Not set';
		
	}else{
		$started_title = date('m/d/Y',$site_started_date);
		
	}
	
	$grading_id = $facility_results['grading'];
	if(!$facility_results['grading']){
		$grading_title = 'Not set';
		
	}else if($facility_results['grading'] == 1){
		$grading_title = 'Low';
		
	}else if($facility_results['grading'] == 2){
		$grading_title = 'Medium';
		
	}else if($facility_results['grading'] == 3){
		$grading_title = 'High';
		
	}
	
	$region_id = $facility_results['region_id'];
	$region = mysqli_query($connect,"select * from regions where id = $region_id")or die(mysqli_error($connect));
	$region_results = mysqli_fetch_array($region,MYSQLI_ASSOC);
	$this_region_title = $region_results['title'];
	
	$province_id = $facility_results['province_id'];
	$province = mysqli_query($connect,"select * from provinces where id = $province_id")or die(mysqli_error($connect));
	$province_results = mysqli_fetch_array($province,MYSQLI_ASSOC);
	$this_province_title = $province_results['title'];

	$hub_id = $facility_results['hub_id'];
	$hub = mysqli_query($connect,"select * from hubs where id = $hub_id")or die(mysqli_error($connect));
	$hub_results = mysqli_fetch_array($hub,MYSQLI_ASSOC);
	
	$this_hub_title = $hub_results['title'];
	$mother_facility_id = $facility_results['mother_facility_id'];
	
	if(!$mother_facility_id){
		$this_mother_facility_title = 'Select option';
		
	}else{
		
		$mother_facility = mysqli_query($connect,"select * from mother_facilities where id = $mother_facility_id")or die(mysqli_error($connect));
		$mother_facility_results = mysqli_fetch_array($mother_facility,MYSQLI_ASSOC);
		
		$this_mother_facility_title = $mother_facility_results['title'];
	}
	
	$default_color = '#000';
	
	$button_text = 'Update';
	
}else{
	$default_color = '#aaa';
	$site_title = 'Enter title for this site here';
	$site_type = 'Enter this site type here';
	$gsm_code = 'Enter code here';	$gsm_code_2 = 'Enter code here';
	$gps_code = 'Enter code here';
	
	$site_identified_date = time();
	$site_assessed_date = time();
	$site_started_date = time();
	$identified_title = date('m/d/Y',$site_identified_date);
	$assessed_title = date('m/d/Y',$site_assessed_date);
	$started_title = date('m/d/Y',$site_started_date);
	
	$grading_id = 0;
	$grading_title = 'Not set';
		
	
	$region_id = $user_results['region_id'];
	if(!$region_id){
		$this_region_title = 'Select option';
		
	}else{
		$region = mysqli_query($connect,"select * from regions where id = $region_id")or die(mysqli_error($connect));
		$region_results = mysqli_fetch_array($region,MYSQLI_ASSOC);
		$this_region_title = $region_results['title'];
	}
	
	$province_id = $user_results['province_id'];
	if(!$province_id){
		$this_province_title = 'Select option';
		
	}else{
		$province = mysqli_query($connect,"select * from provinces where id = $province_id")or die(mysqli_error($connect));
		$province_results = mysqli_fetch_array($province,MYSQLI_ASSOC);
		$this_province_title = $province_results['title'];
		
	}
	
	$hub_id = $user_results['hub_id'];
	if(!$hub_id){
		$this_hub_title = 'Select option';
		
	}else{		
		$hub = mysqli_query($connect,"select * from hubs where id = $hub_id")or die(mysqli_error($connect));
		$hub_results = mysqli_fetch_array($hub,MYSQLI_ASSOC);
		
		$this_hub_title = $hub_results['title'];
		
	}
	
	$mother_facility_id = $user_results['mother_facility_id'];
	if(!$mother_facility_id){
		$this_mother_facility_title = 'Select option';
		
	}else{		
		$mother_facility = mysqli_query($connect,"select * from mother_facilities where id = $mother_facility_id")or die(mysqli_error($connect));
		$mother_facility_results = mysqli_fetch_array($mother_facility,MYSQLI_ASSOC);
		
		$this_mother_facility_title = $mother_facility_results['title'];
		
	}
	
	$button_text = 'Create';
}
?>

<div class="general_holder" id="site_profile">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($site_title);?>"  id="site_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter title for this site here'){this.value='';this.style.color='#000'}$('#new_site_error_message').slideUp('fast');$('#site_title_error').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($site_title);?>';this.style.color='<?php print($default_color);?>';}check_site_title(<?php print($facility_id);?>);"></div>
</div>

<input type="hidden" id="site_title_error_input" value="0">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;margin-bottom:10px;" id="site_title_error"></div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Type*:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($site_type);?>"  id="site_type" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter this site type here'){this.value='';this.style.color='#000'}$('#new_site_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($site_type);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">USSD/SMS code*:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($gsm_code);?>"  id="gsm_code" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter code here'){this.value='';this.style.color='#000'}$('#site_gsm_error').slideUp('fast');$('#new_site_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($gsm_code);?>';this.style.color='<?php print($default_color);?>'}check_site_gsm_code(<?php print($facility_id);?>);"></div>
</div><div style="width:100%;height:auto;float:left;margin-bottom:5px;">	<div style="width:150px;height:30px;line-height:30px;float:left;">District code:</div>	<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($gsm_code_2);?>"  id="gsm_code_2" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter code here'){this.value='';this.style.color='#000'}$('#site_gsm_error').slideUp('fast');$('#new_site_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($gsm_code);?>';this.style.color='<?php print($default_color);?>'}check_site_gsm_code(<?php print($facility_id);?>);">	</div></div>

<input type="hidden" id="site_gsm_error_input" value="0">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;margin-bottom:10px;" id="site_gsm_error"></div>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">GPS coordinates*:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($gps_code);?>"  id="gps_code" onfocus="if(this.value=='Enter code here'){this.value='';this.style.color='#000'}$('#new_site_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($gps_code);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Identified <i>(mm/dd/yyyy)</i>:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" id="site_identified" style="width:100%;height:30px;" value="<?php print($identified_title);?>" onfocusout="if(this.value==''){this.value='<?php print($identified_title);?>';}" <?php if(!$editing){print(' disabled ');}?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Assessed <i>(mm/dd/yyyy)</i>:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" id="site_assessed" style="width:100%;height:30px;" value="<?php print($assessed_title);?>" onfocusout="if(this.value==''){this.value='<?php print($assessed_title);?>';}" <?php if(!$editing){print(' disabled ');}?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Started <i>(mm/dd/yyyy)</i>:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" id="site_started" style="width:100%;height:30px;" value="<?php print($started_title);?>" onfocusout="if(this.value==''){this.value='<?php print($started_title);?>';}" <?php if(!$editing){print(' disabled ');}?>></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Grading*:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#grading_menu').toggle('fast');" id="active_grading" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($grading_title);?></div>

			<div class="option_menu" id="grading_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#grading_menu').toggle('fast');$('#active_grading').html($(this).html());$('#site_selected_grading').val(0);$('#new_site_error_message').slideUp('fast');">Not set</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#grading_menu').toggle('fast');$('#active_grading').html($(this).html());$('#site_selected_grading').val(1);$('#new_site_error_message').slideUp('fast');">Low</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#grading_menu').toggle('fast');$('#active_grading').html($(this).html());$('#site_selected_grading').val(2);$('#new_site_error_message').slideUp('fast');">Medium</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#grading_menu').toggle('fast');$('#active_grading').html($(this).html());$('#site_selected_grading').val(3);$('#new_site_error_message').slideUp('fast');">High</div>
		
			</div>
	</div>
	<input type="hidden" id="site_selected_grading" value="<?php print($grading_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:180px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#site_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for sites');<?php }?>" id="active_site_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="site_region_menu" style="display:none;width:auto;min-width:150px;max-width:280px;width:auto;">			
				<?php
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_region_menu').toggle('fast');$('#active_site_region').html($(this).html());$('#selected_site_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'site_province',1,1,'connect-hubs-province_id-{id}-site_hub-1-1');$('#new_site_error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_site_region" value="<?php print($region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:180px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#site_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for sites');<?php }?>" id="active_site_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="site_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_province_menu').toggle('fast');$('#active_site_province').html($(this).html());$('#selected_site_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'site_hub',1,1,'');$('#new_site_error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_site_province" value="<?php print($province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#site_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for sites');<?php }?>" id="active_site_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="site_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_hub_menu').toggle('fast');$('#active_site_hub').html($(this).html());$('#selected_site_hub').val(<?php print($hub_menu_results['id']);?>);$('#new_site_error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_site_hub" value="<?php print($hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Mother facility:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['mother_facility_id']){?>$('#site_mother_facility_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for sites');<?php }?>" id="active_site_mother_facility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_mother_facility_title);?></div>

		<div class="option_menu" id="site_mother_facility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$mother_facility_menu = mysqli_query($connect,"select * from mother_facilities where hub_id = $hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($m=0;$m<mysqli_num_rows($mother_facility_menu);$m++){
					$mother_facility_menu_results = mysqli_fetch_array($mother_facility_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_mother_facility_menu').toggle('fast');$('#active_site_mother_facility').html($(this).html());$('#selected_site_mother_facility').val(<?php print($mother_facility_menu_results['id']);?>);$('#new_site_error_message').slideUp('fast');"><?php print($mother_facility_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_site_mother_facility" value="<?php print($mother_facility_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="new_site_error_message"></div>

<?php
if($editing){
	?>
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="site_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_site_button" onclick="update_or_create_site(<?php print($facility_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($facility_id){
	if($facility_results['active_status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_site_button" onclick="disable_site(<?php print($facility_id);?>);" title="Click to disable the account">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="enable_site_button" onclick="enable_site(<?php print($facility_id);?>);" title="Click to activate the account">Enable</div>

<?php
	}
}
	?>
	</div>
	
	<script>
	
	check_site_title(<?php print($facility_id);?>);
	
	var checker = setTimeout('load_checked_gsm_code()',1000);
	
	
	function load_checked_gsm_code(){
		if($('#site_title_error').html != ''){
			check_site_gsm_code(<?php print($facility_id);?>);
	
		}else{
			var checker = setTimeout('load_checked_gsm_code()',1000);
		}
	}
	</script>
	<?php
}
?>


</div>

<script>
$( function() {
	$( "#site_identified").datepicker();
	$( "#site_assessed").datepicker();
	$( "#site_started").datepicker();
} );
</script>