<?php
if($mother_facility_id){
	$this_mother_facility =  mysqli_query($connect,"select * from mother_facilities where id = $mother_facility_id")or die(mysqli_error($connect));
	$mother_facility_results = mysqli_fetch_array($this_mother_facility,MYSQLI_ASSOC);
	$mother_facility_title = $mother_facility_results['title'];
	
	
	$region_id = $mother_facility_results['region_id'];
	$region = mysqli_query($connect,"select * from regions where id = $region_id")or die(mysqli_error($connect));
	$region_results = mysqli_fetch_array($region,MYSQLI_ASSOC);
	$this_region_title = $region_results['title'];
	
	$province_id = $mother_facility_results['province_id'];
	$province = mysqli_query($connect,"select * from provinces where id = $province_id")or die(mysqli_error($connect));
	$province_results = mysqli_fetch_array($province,MYSQLI_ASSOC);
	$this_province_title = $province_results['title'];

	$hub_id = $mother_facility_results['hub_id'];
	$hub = mysqli_query($connect,"select * from hubs where id = $hub_id")or die(mysqli_error($connect));
	$hub_results = mysqli_fetch_array($hub,MYSQLI_ASSOC);
	
	$this_hub_title = $hub_results['title'];
	
	$default_color = '#000';
	
	$button_text = 'Update';
	
}else{
	$default_color = '#aaa';
	$mother_facility_title = 'Enter title here';
	
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
	
	$button_text = 'Create';
}
?>

<div class="general_holder" id="mother_facility_profile">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($mother_facility_title);?>"  id="mother_facility_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');$('#mother_facility_title_error').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($mother_facility_title);?>';this.style.color='<?php print($default_color);?>';}check_mother_facility_title(<?php print($facility_id);?>);"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;margin-bottom:10px;" id="mother_facility_gsm_error"></div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:180px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#mother_facility_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for mother_facilitys');<?php }?>" id="active_mother_facility_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="mother_facility_region_menu" style="display:none;width:auto;min-width:150px;max-width:280px;width:auto;">			
				<?php
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#mother_facility_region_menu').toggle('fast');$('#active_mother_facility_region').html($(this).html());$('#selected_mother_facility_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'mother_facility_province',1,1,'connect-hubs-province_id-{id}-mother_facility_hub-1-1');$('#error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_mother_facility_region" value="<?php print($region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:180px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#mother_facility_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify this option');<?php }?>" id="active_mother_facility_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="mother_facility_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#mother_facility_province_menu').toggle('fast');$('#active_mother_facility_province').html($(this).html());$('#selected_mother_facility_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'mother_facility_hub',1,1,'');$('#error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_mother_facility_province" value="<?php print($province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:200px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#mother_facility_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for mother_facilitys');<?php }?>" id="active_mother_facility_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="mother_facility_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#mother_facility_hub_menu').toggle('fast');$('#active_mother_facility_hub').html($(this).html());$('#selected_mother_facility_hub').val(<?php print($hub_menu_results['id']);?>);$('#error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_mother_facility_hub" value="<?php print($hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>

<?php
if($editing){
	?>
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="mother_facility_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_mother_facility_button" onclick="update_or_create_mother_facility(<?php print($mother_facility_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

<?php
if($mother_facility_id){
	if($mother_facility_results['active_status']){
	?>
<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';"  id="disable_mother_facility_button" onclick="disable_mother_facility(<?php print($mother_facility_id);?>);" title="Click to disable this item">Disable</div>
<?php
	}else{
		?>
	<div style="width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="enable_mother_facility_button" onclick="enable_mother_facility(<?php print($mother_facility_id);?>);" title="Click to activate this item">Enable</div>

<?php
	}
}
	?>
	</div>
	<?php
}
?>


</div>
