<?php
$default_color = '#aaa';
$editing = 1;
$folder_title = 'Enter folder title here';

$this_region_id = $user_results['region_id'];
$this_province_id = $user_results['province_id'];
$this_hub_id = $user_results['hub_id'];
$this_mother_facility_id = $user_results['mother_facility_id'];
$this_site_id = $user_results['site_id'];

$region_title =  'All region';
$province_title =  'All province';
$hub_title =  'All hub';
$site_title =  'All site';

$agent_limit = 0;
$budget_limit = 0;
$claim_type_string = '';
$current_budget_amount = 0;
$total_claim_types = 0;
$claim_type_array = array();

$access_restrictions = 0;
$allow_agents = 1;

	$regions = fetch_db_table('connect','regions',$company_id,'id',"");
	$provinces = fetch_db_table('connect','provinces',$company_id,'id',"");
	$hubs = fetch_db_table('connect','hubs',$company_id,'id',"");
	$sites = fetch_db_table('connect','sites',$company_id,'id',"");
	$users = fetch_db_table('connect','users',$company_id,'id',"");

if($folder_id){
	$this_folder = fetch_db_table('connect','payment_folders',$company_id,'id',' id = '.$folder_id);
	
	$this_region_id = $this_folder['region_id'][0];
	$this_province_id = $this_folder['province_id'][0];
	$this_hub_id = $this_folder['hub_id'][0];
	$this_site_id = $this_folder['site_id'][0];
	
	$agent_limit = $this_folder['agent_limit'][0];
	$budget_limit = $this_folder['budget_limit'][0];
	$current_budget_amount = $this_folder['current_budget_amount'][0];
	$claim_type_string = $this_folder['claim_type_string'][0];
	
	$access_restrictions = $this_folder['accessibility_id'][0];
	$allow_agents = $this_folder['allow_agents'][0];
	
	$claim_type_array = explode(',',$claim_type_string);
	
	$total_claim_types = 0;
	if($claim_type_string != ''){
		$total_claim_types = count($claim_type_array);
		
	}
	
	$folder_title = $this_folder['title'][0];
	$default_color = '#000';
	
}else{
	$this_region_id = $user_results['region_id'];
	$this_province_id = $user_results['province_id'];
	$this_hub_id = $user_results['hub_id'];
	$this_site_id = $user_results['site_id'];
	
}

$access_restriction_title = 'Everyone should access this folder';
if($access_restrictions == 1){
	$access_restriction_title = 'Only I should access this folder';
}

$allow_agents_title = 'Allow';
if($allow_agents == 0){
	$allow_agents_title = 'Do not allow';
}

if($this_region_id){
	$region_index = array_keys($regions['id'],$this_region_id);
	
	if(isset($region_index[0])){
		$region_title = $regions['title'][$region_index[0]];
	}
}

if($this_province_id){
	$province_index = array_keys($provinces['id'],$this_province_id);
	
	if(isset($province_index[0])){
		$province_title = $provinces['title'][$province_index[0]];
	}
}

if($this_hub_id){
	$hub_index = array_keys($hubs['id'],$this_hub_id);
	
	if(isset($hub_index[0])){
		$hub_title = $hubs['title'][$hub_index[0]];
	}
}

if($this_site_id){
	$site_index = array_keys($sites['id'],$this_site_id);
	
	if(isset($site_index[0])){
		$site_title = $sites['title'][$site_index[0]];
	}
}

if($access_restrictions){
	$access_restriction_title = 'Only I should access this folder';
}

?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
	<div class="general_menu_holder" style="height:25px;line-height:25px;width:100%;">
	<div class="tab" style="height:25px;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_100" onclick="$('#folder_basic_details').slideUp('fast');$('#folder_payment_batches').slideDown('fast');tab_item_change(100);">Payment batches</div>

	<div class="tab" style="height:25px;line-height:25px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_101" onclick="$('#folder_payment_batches').slideUp('fast');$('#folder_basic_details').slideDown('fast');tab_item_change(101);">Folder settings</div>

	</div>

	</div>

	<div style="width:100%;height:auto;float:left;display:none;" id="folder_basic_details">
	
	<div style="width:48%;float:left;height:auto;">
	<div style="width:100%;height:20px;float:left;background-color:#eef;text-align:center;font-weight:bold;">Basic Details</div>
	
	
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Folder title:</div>
	<div style="width:260px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($folder_title);?>"  id="folder_title" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter folder title here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($folder_title);?>';this.style.color='<?php print($default_color);?>'}" onkeyup="if (event.keyCode == 13) {save_or_update_payment_folder(<?php print($folder_id);?>);}"></div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Region:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#folder_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for folders');<?php }?>" id="active_folder_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($region_title);?></div>

				<div class="option_menu" id="folder_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_region_menu').toggle('fast');$('#active_folder_region').html($(this).html());$('#selected_folder_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'folder_province',1,1,'connect-hubs-province_id-{id}-folder_hub-1-1|connect-sites-hub_id-{id}-folder_site-1-1');$('#new_folder_error_message').slideUp('fast');">All regions</div>
				
					<?php
					
						$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

						for($r=0;$r<mysqli_num_rows($region_menu);$r++){
							$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
							?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_region_menu').toggle('fast');$('#active_folder_region').html($(this).html());$('#selected_folder_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'folder_province',1,1,'connect-hubs-province_id-{id}-folder_hub-1-1|connect-sites-hub_id-{id}-folder_site-1-1');$('#new_folder_error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
							<?php
						}
					?>
				</div>
		</div>
		<input type="hidden" id="selected_folder_region" value="<?php print($this_region_id);?>">
	</div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Province:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#folder_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for folders');<?php }?>" id="active_folder_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($province_title);?></div>

				<div class="option_menu" id="folder_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<?php
					
						$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

						for($p=0;$p<mysqli_num_rows($province_menu);$p++){
							$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
							?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_province_menu').toggle('fast');$('#active_folder_province').html($(this).html());$('#selected_folder_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'folder_hub',1,1,'connect-sites-hub_id-{id}-folder_site-1-1');$('#new_folder_error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
							<?php
						}
					?>
				</div>
		</div>
		<input type="hidden" id="selected_folder_province" value="<?php print($this_province_id);?>">
	</div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Hub:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#folder_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for folders');<?php }?>" id="active_folder_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($hub_title);?></div>

			<div class="option_menu" id="folder_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
						$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_hub_menu').toggle('fast');$('#active_folder_hub').html($(this).html());$('#selected_folder_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'folder_site',1,1,'');$('#new_folder_error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
		</div>
		<input type="hidden" id="selected_folder_hub" value="<?php print($this_hub_id);?>">
	</div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Site:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#folder_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify site settings for folders');<?php }?>" id="active_folder_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($site_title);?></div>

			<div class="option_menu" id="folder_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($s=0;$s<mysqli_num_rows($site_menu);$s++){
						$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_site_menu').toggle('fast');$('#active_folder_site').html($(this).html());$('#selected_folder_site').val(<?php print($site_menu_results['id']);?>);$('#new_folder_error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
		</div>
		<input type="hidden" id="selected_folder_site" value="<?php print($this_site_id);?>">
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Access restritions:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#folder_accessibility_menu').slideToggle('fast');" id="active_folder_accessibility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($access_restriction_title);?></div>

				<div class="option_menu" id="folder_accessibility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_accessibility_menu').toggle('fast');$('#active_folder_accessibility').html($(this).html());$('#selected_folder_accessibility').val(0);">Everyone should access this folder</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_accessibility_menu').toggle('fast');$('#active_folder_accessibility').html($(this).html());$('#selected_folder_accessibility').val(1);">Only I should access this folder</div>
				</div>
		</div>
		<input type="hidden" id="selected_folder_accessibility" value="<?php print($access_restrictions);?>">
	</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Allow agents</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#folder_allow_agents_menu').slideToggle('fast');" id="active_folder_allow_agents" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($allow_agents_title);?></div>

				<div class="option_menu" id="folder_allow_agents_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_allow_agents_menu').toggle('fast');$('#active_folder_allow_agents').html($(this).html());$('#selected_folder_allow_agents').val(1);">Allow</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#folder_allow_agents_menu').toggle('fast');$('#active_folder_allow_agents').html($(this).html());$('#selected_folder_allow_agents').val(0);">Do not allow</div>
				</div>
		</div>
		<input type="hidden" id="selected_folder_allow_agents" value="<?php print($allow_agents);?>">
	</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Agent limit:</div>
	<div style="width:260px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($agent_limit);?>"  id="agent_limit" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter limit here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';" onfocusout="if(this.value=='' || isNaN(this.value) || Number(this.value) < 0){alert('Value must be a number greater than -1');this.value='<?php print($agent_limit);?>';this.style.color='<?php print($default_color);?>'}"></div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Budget limit:</div>
	<div style="width:260px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($budget_limit);?>"  id="budget_limit" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter limit here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';" onfocusout="if(this.value=='' || isNaN(this.value) || Number(this.value) < 0){alert('Value must be a number greater than -1');this.value='<?php print($budget_limit);?>';this.style.color='<?php print($default_color);?>'}"></div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Current amount:</div>
	<div style="width:260px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($current_budget_amount);?>"  id="current_budget_amount" <?php if(!$editing){?> disabled<?php }?> onfocus="if(this.value=='Enter limit here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';" onfocusout="if(this.value=='' || isNaN(this.value) || Number(this.value) < 0){alert('Value must be a number greater than -1');this.value='<?php print($current_budget_amount);?>';this.style.color='<?php print($default_color);?>'}"></div>
	</div>
	
	
</div>
<div style="width:48%;float:right;height:auto;">
<div style="width:100%;height:20px;float:left;background-color:#fee;text-align:center;font-weight:bold;">Claim type settings</div>

<div style="width:100%;height:auto;float:left;" id="claim_type_holder">
<?php

$this_pipat_claims_database_ip = getenv('PIPAT_CLAIMS_DATABASE_IP');
$this_pipat_claims_database_name = getenv('PIPAT_CLAIMS_DATABASE_NAME');
$this_pipat_claims_database_username = getenv('PIPAT_CLAIMS_DATABASE_USERNAME');
$this_pipat_claims_database_password = getenv('PIPAT_CLAIMS_DATABASE_PASSWORD');

$claims_connect = mysqli_connect($this_pipat_claims_database_ip,$this_pipat_claims_database_username,$this_pipat_claims_database_password);
mysqli_query($claims_connect,'use '.$this_pipat_claims_database_name)or die(mysqli_error($claim_connect));


for($c=0;$c<$total_claim_types;$c++){
	
	$this_claim_data = explode('-',$claim_type_array[$c]);
	
	$this_agent_group_id = $this_claim_data[0];
	$this_agent_claim_type_id = $this_claim_data[1];
	
	$agent_groups = fetch_db_table('connect','agent_types',$company_id,'title','');
	
	$this_agent_group_index = array_keys($agent_groups['id'],$this_agent_group_id);
	$this_agent_group_title = $agent_groups['title'][$this_agent_group_index[0]];
	
	?>
		<div style="width:100%;height:auto;float:left;border-bottom:solid 1px #bbb; margin-bottom:5px;">

		<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
			<div style="width:110px;height:30px;line-height:30px;float:left;">Agent group:</div>
			<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
				<div style="width:auto;min-height:30px;height:auto;float:left;">
					<div class="option_item" title="Click to change option" onclick="$('#claim_type_agent_group_<?php print($c);?>_menu').slideToggle('fast');" id="active_claim_type_agent_group_<?php print($c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_agent_group_title);?></div>

						<div class="option_menu" id="claim_type_agent_group_<?php print($c);?>_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
							
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_agent_group_<?php print($c);?>_menu').toggle('fast');$('#active_claim_type_agent_group_<?php print($c);?>').html($(this).html());$('#selected_claim_type_agent_group_<?php print($c);?>').val(0);">Remove</div>
						
							<?php
							$this_agent_group_index = array_keys($agent_groups['status'],1);
							
							if(isset($this_agent_group_index[0])){
								for($g=0;$g<count($this_agent_group_index);$g++){
								?>
									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_agent_group_<?php print($c);?>_menu').toggle('fast');$('#active_claim_type_agent_group_<?php print($c);?>').html($(this).html());$('#selected_claim_type_agent_group_<?php print($c);?>').val(<?php print($agent_groups['id'][$this_agent_group_index[$g]]);?>);"><?php print($agent_groups['title'][$this_agent_group_index[$g]]);?></div>
								
								<?php
								}
							}
							?>
						</div>
				</div>
				<input type="hidden" id="selected_claim_type_agent_group_<?php print($c);?>" value="<?php print($this_agent_group_id);?>">
			</div>
			</div>
			
			<?php
				$this_claim_type = mysqli_query($claims_connect,"select * from request_types where id =  $this_agent_claim_type_id")or die(mysqli_error($connect));
				
				$claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
						
			?>
	
			<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
			<div style="width:110px;height:30px;line-height:30px;float:left;">Claim type:</div>
			<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
				<div style="width:auto;min-height:30px;height:auto;float:left;">
					<div class="option_item" title="Click to change option" onclick="$('#claim_type_<?php print($c);?>_menu').slideToggle('fast');" id="active_claim_type_<?php print($c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($claim_type_results['title'].' (K'.number_format($claim_type_results['daily_rate'],2).')');?></div>

						<div class="option_menu" id="claim_type_<?php print($c);?>_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
						
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_<?php print($c);?>_menu').toggle('fast');$('#active_claim_type_<?php print($c);?>').html($(this).html());$('#selected_claim_type_<?php print($c);?>').val(0);">Remove</div>
						
							<?php
							
							
							$claim_type = mysqli_query($claims_connect,"select * from request_types where status = 1 order by title")or die(mysqli_error($connect));
							
							for($c1=0;$c1<mysqli_num_rows($claim_type);$c1++){
								$claim_type_results = mysqli_fetch_array($claim_type,MYSQLI_ASSOC);
								
								?>
									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_<?php print($c);?>_menu').toggle('fast');$('#active_claim_type_<?php print($c);?>').html($(this).html());$('#selected_claim_type_<?php print($c);?>').val(<?php print($claim_type_results['id']);?>);"><?php print($claim_type_results['title'].' (K'.number_format($claim_type_results['daily_rate'],2).')');?></div>
								
								<?php
							}
							?>
						</div>
				</div>
				<input type="hidden" id="selected_claim_type_<?php print($c);?>" value="<?php print($this_agent_claim_type_id);?>">
			</div>
			</div>
	
</div>
	<?php
}
?>


</div>
<div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;background-color:#eee;margin-top:5px;cursor:pointer;" title="Click to add claim type configuration" onclick="add_folder_claim_types()">Add</div>


<div style="width:100%;height:auto;float:left;display:none;" id="default_claim_type_set">

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Agent group:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#claim_type_agent_group_z_menu').slideToggle('fast');" id="active_claim_type_agent_group_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select item</div>

				<div class="option_menu" id="claim_type_agent_group_z_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<?php
					$agent_groups = fetch_db_table('connect','agent_types',$company_id,'title',' status = 1 ');
					
					for($g=0;$g<count($agent_groups['id']);$g++){
					?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_agent_group_z_menu').toggle('fast');$('#active_claim_type_agent_group_z').html($(this).html());$('#selected_claim_type_agent_group_z').val(<?php print($agent_groups['id'][$g]);?>);"><?php print($agent_groups['title'][$g]);?></div>
					
					<?php
					}
					?>
				</div>
		</div>
		<input type="hidden" id="selected_claim_type_agent_group_z" value="0">
	</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:110px;height:30px;line-height:30px;float:left;">Claim type:</div>
	<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#claim_type_z_menu').slideToggle('fast');" id="active_claim_type_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select item</div>

				<div class="option_menu" id="claim_type_z_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<?php
		
					$claim_type = mysqli_query($claims_connect,"select * from request_types where status = 1 order by title")or die(mysqli_error($connect));
					
					for($c=0;$c<mysqli_num_rows($claim_type);$c++){
						$claim_type_results = mysqli_fetch_array($claim_type,MYSQLI_ASSOC);
						
						?>
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_z_menu').toggle('fast');$('#active_claim_type_z').html($(this).html());$('#selected_claim_type_z').val(<?php print($claim_type_results['id']);?>);"><?php print($claim_type_results['title'].' (K'.number_format($claim_type_results['daily_rate'],2).')');?></div>
						
						<?php
					}
					?>
				</div>
		</div>
		<input type="hidden" id="selected_claim_type_z" value="0">
	</div>
	</div>
	
</div>

</div>
<input type="hidden" id="claim_type_string" value="<?php print($claim_type_string);?>">
<input type="hidden" id="total_claim_types" value="<?php print($total_claim_types);?>">









<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:5px;color:red;display:none;font-weight:bold;" id="error_message"></div>

<?php if($active_user_roles[10]){?>
	<div style="width:100%;height:auto;float:left;margin-top:5px;">
	<div style="width:90px;height:30px;background-color:#a64d79;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#c27ba0'" onmouseout="this.style.backgroundColor='#a64d79'" id="save_payment_folder_button" onclick="save_or_update_payment_folder(<?php print($folder_id);?>);" title="Click to save details">Save folder</div>

	<div style="width:90px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;margin-left:5px;" onmouseover="this.style.backgroundColor='#b34444'" onmouseout="this.style.backgroundColor='brown'" id="delete_payment_folder_button" onclick="delete_payment_folder(<?php print($folder_id);?>);" title="Click to delete">Delete folder</div>

	</div>
	<?php
}
?>
</div>

<div style="width:100%;height:auto;float:left;display:none;" id="folder_payment_batches">

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><div style="width:90px;height:20px;float:left;margin-right:2px;">Date</div>
<div style="width:90px;height:20px;float:left;margin-right:2px;">Time</div>
<div style="width:90px;height:20px;float:left;margin-right:2px;">Month</div><div style="width:220px;height:20px;float:left;margin-right:2px;">Creator</div><div style="width:70px;height:20px;float:left;margin-right:2px;">Claim</div><div style="width:100px;height:20px;float:left;margin-right:2px;">Claim status</div><div style="width:70px;height:20px;float:left;margin-right:2px;">Level</div></div>

<?php
$this_folder_data_sets = fetch_db_table('connect','payment_folder_data_sets',$company_id,'id',' folder_id = '.$folder_id);
$folder_months = fetch_db_table('connect','payment_folder_months',$company_id,'id','');
?>

<div style="width:100%;height:auto;line-height:20px;float:left;"><?php
if(!count($this_folder_data_sets['id'])){
print('No claim batches found');

}else{
	$this_default_claims_partition_name = $default_partition_names[7][1][0];
	for($fd=0;$fd<count($this_folder_data_sets['id']);$fd++){
		
		$month_id = $this_folder_data_sets['month_id'][$fd];
		
		$month_index = array_keys($folder_months['id'],$month_id);
		$this_month = $folder_months['title'][$month_index[0]];
		
		$this_user_id = $this_folder_data_sets['user_id'][$fd];
		
		$user_index = array_keys($users['id'],$this_user_id);
		$this_user = $users['_name'][$user_index[0]];
		
		$folder_claim_id = 'N/A';
		$claim_status = 'N/A';
		$claim_level = 'N/A';
		$form_code = '';
		if($this_folder_data_sets['status'][$fd] != 1){
			$folder_claim_id = $this_folder_data_sets['claim_id'][$fd];
			
			$partitions = fetch_database_partitions(7,$this_folder_data_sets['_date'][$fd], $this_folder_data_sets['_date'][$fd]);
			$payment_claims_table = $this_default_claims_partition_name.'_partition_'.$partitions[0];
			
			$this_claim = mysqli_query($claims_connect,"select * from $payment_claims_table where claim_id =  $folder_claim_id")or die(mysqli_error($claims_connect));
				
			$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
			
			if($this_claim_results['status'] == 1){
				$claim_status = 'Pending';
				
			}else if($this_claim_results['status'] == 2){
				$claim_status = 'Completed';
				
			}else if($this_claim_results['status'] == 0){
				$claim_status = 'Disabled';
			
			}else if($this_claim_results['status'] == 3){
				$claim_status = 'Amendments';
			}
			
			$claim_level = $this_claim_results['level']+1;
			
			$form_code = '<div style="width:40px;height:15px;line-height:15px;float:right;margin-right:2px;backgroun-color:006bb3;color:#fff;">Form</div>';
		}
		
		
		?>
		<div style="width:100%;height:20px;line-height:20px;float:left;"><div style="width:90px;height:20px;float:left;margin-right:2px;"><?php print(date('d-m-Y',$this_folder_data_sets['_date'][$fd]));?></div><div style="width:90px;height:20px;float:left;margin-right:2px;"><?php print(date('H:i:s',$this_folder_data_sets['_date'][$fd]));?></div><div style="width:90px;height:20px;float:left;margin-right:2px;"><?php print($this_month);?></div><div style="width:220px;height:20px;float:left;margin-right:2px;"><?php print($this_user);?></div><div style="width:70px;height:20px;float:left;margin-right:2px;"><?php print($folder_claim_id);?></div><div style="width:100px;height:20px;float:left;margin-right:2px;"><?php print($claim_status);?></div><div style="width:70px;height:20px;float:left;margin-right:2px;"><?php print($claim_level);?></div><?php print($form_code);?></div>
		<?php
	}
	?>
	
	<?php
}
?>
</div></div>

<script>
<?php 
	if($landing_tab == 0){
		?>
		$('#tab_101').click();

<?php
	}else{
		?>
		$('#tab_100').click();
		<?php
	}
?>
	

function add_folder_claim_types(){
	var total_claim_types = Number($('#total_claim_types').val());

	
	var default_set = '<div style="width:100%;height:auto;float:left;border-bottom:solid 1px #bbb; margin-bottom:5px;">'+$('#default_claim_type_set').html()+'</div>';
	
	default_set = default_set.replace(/_z/g,'_'+total_claim_types);
	
	$('#claim_type_holder').append(default_set);
	
	total_claim_types++;
	
	$('#total_claim_types').val(total_claim_types);
}
</script>