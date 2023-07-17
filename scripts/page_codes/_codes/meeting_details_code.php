<?php
$editing = 1;
if($meeting_id){
	$meeting_color = '#000';
	$this_meeting = fetch_db_table('connect','meetings',$company_id,'id',"id = ".$meeting_id);
	$meeting_title = $this_meeting['title'][0];
	
	$region_id = $this_meeting['region_id'][0];
	$province_id = $this_meeting['province_id'][0];
	$hub_id = $this_meeting['hub_id'][0];
	$site_id = $this_meeting['site_id'][0];
	$unit_id = $this_meeting['quick_report_unit_id'][0];
	$activity_id = $this_meeting['quick_report_activity_id'][0];
	
	$meeting_from = date('m/d/Y',$this_meeting['_from'][0]);
	$meeting_to = date('m/d/Y',$this_meeting['_to'][0]);
	
	$code_type_id = $this_meeting['meeting_code_type'][0];
	$meeting_code = $this_meeting['meeting_code'][0];
	$meeting_password = $this_meeting['password'][0];
	
	$button_text = 'Update';
	
}else{
	$default_color = '#aaa';
	$meeting_title = 'Enter title here';
	
	$meeting_from = date('m/d/Y',time());
	$meeting_to = date('m/d/Y',time()+(86400*7));
	
	$meeting_password = rand(1000,9999);
	
	$code_type_id = 0;
	$meeting_code = time();
	
	$unit_id = $user_results['unit_id'][0];
	$activity_id = 0;
	
	$button_text = 'Create';
}

if($code_type_id == 0){
	$this_code_type_title = 'Auto assign';
	$custom_code_holder_display  = 'display:none;';
	
}else if($code_type_id == 1){
	$this_code_type_title = 'Custom';
	$custom_code_holder_display  = '';
	
}else if($code_type_id == 2){
	$this_code_type_title = 'Use site code';
	$custom_code_holder_display  = 'display:none;';
	
}

$regions = fetch_db_table('connect','regions',$company_id,'id',"");

$province_search = '';
if($region_id){
	$province_search = ' region_id = '.$region_id;
}

$provinces = fetch_db_table('connect','provinces',$company_id,'id',$province_search);

$hub_search = '';
if($province_id){
	$hub_search = ' province_id = '.$province_id;
}

$hubs = fetch_db_table('connect','hubs',$company_id,'id',$hub_search);

$site_search = '';
if($hub_id){
	$site_search = ' hub_id = '.$hub_id;	
}


$sites = fetch_db_table('connect','sites',$company_id,'title',$site_search);

$units = fetch_db_table('connect','units',$company_id,'id'," status = 1");
$activities = fetch_db_table('connect','activities',$company_id,'id',"");

$this_region_title = 'Select item';
if($region_id){
	$region_index = array_keys($regions['id'],$region_id);
	
	if(isset($region_index[0])){
		$this_region_title = $regions['title'][$region_index[0]];
	}
}

$this_province_title = 'Select item';
if($province_id){
	$province_index = array_keys($provinces['id'],$province_id);
	
	if(isset($province_index[0])){
		$this_province_title = $provinces['title'][$province_index[0]];
	}
}

$this_hub_title = 'Select item';
if($hub_id){
	$hub_index = array_keys($hubs['id'],$hub_id);
	
	if(isset($hub_index[0])){
		$this_hub_title = $hubs['title'][$hub_index[0]];
	}
}

$this_site_title = 'Select item';
if($site_id){
	$site_index = array_keys($sites['id'],$site_id);
	
	if(isset($site_index[0])){
		$this_site_title = $sites['title'][$site_index[0]];
	}
}

$this_unit_title = 'Unlimited';
if($unit_id){
	$unit_index = array_keys($units['id'],$unit_id);
	
	if(isset($unit_index[0])){
		$this_unit_title = $units['title'][$unit_index[0]];
	}
}

$this_activity_title = 'Unlimited';
if($activity_id){
	$activity_index = array_keys($activities['id'],$activity_id);
	
	if(isset($activity_index[0])){
		$this_activity_title = $activities['title'][$activity_index[0]];
	}
}


?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Meeting title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($meeting_title);?>"  id="meeting_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($meeting_title);?>';this.style.color='<?php print($default_color);?>}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Meeting password:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($meeting_password);?>"  id="meeting_password" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='<?php print($meeting_password);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Valid from:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($meeting_from);?>"  id="meeting_from" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='<?php print($meeting_from);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Valid to:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($meeting_to);?>"  id="meeting_to" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='<?php print($meeting_to);?>';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Meeting code:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="alert('Option has been disabled for now');" id="active_meeting_code" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_code_type_title);?></div>

			<div class="option_menu" id="meeting_code_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_code_menu').toggle('fast');$('#active_meeting_code').html($(this).html());$('#selected_meeting_code').val(0);$('#custom_code_holder').slideUp('fast');">Auto assign</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_code_menu').toggle('fast');$('#active_meeting_code').html($(this).html());$('#selected_meeting_code').val(1);$('#custom_code_holder').slideDown('fast');">Custom</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_code_menu').toggle('fast');$('#active_meeting_code').html($(this).html());$('#selected_meeting_code').val(2);$('#custom_code_holder').slideUp('fast');">Use site code</div>
			</div>
	</div>
	<input type="hidden" id="selected_meeting_code" value="<?php print($code_type_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;<?php print($custom_code_holder_display);?>" id="custom_code_holder">
<div style="width:140px;height:30px;line-height:30px;float:left;">Meeting code:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($meeting_code);?>"  id="meeting_code" <?php if(!$editing){?> disabled<?php }?> onfocusout="if(this.value==''){this.value='<?php print($meeting_code);?>';'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Region:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#meeting_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings');<?php }?>" id="active_meeting_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="meeting_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
				<?php
				
					for($r=0;$r<count($regions['id']);$r++){
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_region_menu').toggle('fast');$('#active_meeting_region').html($(this).html());$('#selected_meeting_region').val(<?php print($regions['id'][$r]);?>);fetch_menu_items('connect','provinces','region_id',<?php print($regions['id'][$r]);?>,'meeting_province',1,1,'connect-hubs-province_id-{id}-meeting_hub-1-1|connect-sites-hub_id-{id}-meeting_site-1-1');"><?php print($regions['title'][$r]);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_meeting_region" value="<?php print($region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#meeting_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings');<?php }?>" id="active_meeting_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="meeting_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					for($p=0;$p<count($provinces['id']);$p++){
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_province_menu').toggle('fast');$('#active_meeting_province').html($(this).html());$('#selected_meeting_province').val(<?php print($provinces['id'][$p]);?>);fetch_menu_items('connect','hubs','province_id',<?php print($provinces['id'][$p]);?>,'meeting_hub',1,1,'connect-sites-hub_id-{id}-meeting_site-1-1');"><?php print($provinces['title'][$p]);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_meeting_province" value="<?php print($province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#meeting_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings');<?php }?>" id="active_meeting_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="meeting_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				for($h=0;$h<count($hubs['id']);$h++){
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_hub_menu').toggle('fast');$('#active_meeting_hub').html($(this).html());$('#selected_meeting_hub').val(<?php print($hubs['id'][$h]);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hubs['id'][$h]);?>,'meeting_site',1,1,'');"><?php print($hubs['title'][$h]);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_meeting_hub" value="<?php print($hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#meeting_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify site settings');<?php }?>" id="active_meeting_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="meeting_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				for($s=0;$s<count($sites['id']);$s++){
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_site_menu').toggle('fast');$('#active_meeting_site').html($(this).html());$('#selected_meeting_site').val(<?php print($sites['id'][$s]);?>);"><?php print($sites['title'][$s]);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_meeting_site" value="<?php print($site_id);?>">
</div>


<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Reporting unit:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?>$('#meeting_unit_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify unit settings');<?php }?>" id="active_meeting_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>

		<div class="option_menu" id="meeting_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				for($u=0;$u<count($units['id']);$u++){
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_unit_menu').toggle('fast');$('#active_meeting_unit').html($(this).html());$('#selected_meeting_unit').val(<?php print($units['id'][$u]);?>);fetch_menu_items('connect','activities','services',<?php print($units['id'][$u]);?>,'meeting_activity',1,1,'');"><?php print($units['title'][$u]);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_meeting_unit" value="<?php print($unit_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Reporting activity:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?>$('#meeting_activity_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify activity settings');<?php }?>" id="active_meeting_activity" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_activity_title);?></div>

		<div class="option_menu" id="meeting_activity_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				for($a=0;$a<count($activities['id']);$a++){
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_activity_menu').toggle('fast');$('#active_meeting_activity').html($(this).html());$('#selected_meeting_activity').val(<?php print($activities['id'][$a]);?>);"><?php print($activities['title'][$a]);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_meeting_activity" value="<?php print($activity_id);?>">
</div>
</div>
<input type="hidden" id="meeting_parent_id" value="<?php print($parent_id);?>">

<?php
if($meeting_id and !$parent_id){
	?>
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Meeting teams:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#meeting_team_menu').toggle('fast');" id="active_meeting_team" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Do not create</div>

		<div class="option_menu" id="meeting_team_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_team_menu').toggle('fast');$('#active_meeting_team').html($(this).html());$('#selected_meeting_team').val(0);$('#meeting_teams_holder').slideUp('fast');">Do not create</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#meeting_team_menu').toggle('fast');$('#active_meeting_team').html($(this).html());$('#selected_meeting_team').val(1);$('#meeting_teams_holder').slideDown('fast');">Create</div>
					
		</div>
	</div>
	
</div>
</div>
<?php
}
?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;" id="meeting_teams_holder">
<div style="width:140px;height:30px;line-height:30px;float:left;"># of teams:</div>
<div style="width:100px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="0"  id="number_of_meeting_teams" onfocus="if(this.value=='0'){this.value='';};" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='0';}"></div>
</div>

<input type="hidden" id="selected_meeting_team" value="0">

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>

<div style="width:100%;height:auto;float:left;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_update_meeting_button" onclick="create_or_update_meeting(<?php print($meeting_id);?>);" title="Click to update account details"><?php print($button_text);?></div>

</div>

<script>

$(function(){
		$( "#meeting_from" ).datepicker();
		$( "#meeting_to" ).datepicker();
	});
</script>