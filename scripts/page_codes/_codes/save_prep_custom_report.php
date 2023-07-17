<div style="width:100%;height:30px;line-height:30px;float:left;color:#006bb3;margin-bottom:10px;">Set accessibility options below:</div>
<?php
	if($report_id){
		$this_report = mysqli_query($connect,"select * from dynamic_reports where id = $report_id")or die(mysqli_error($connect));
		
		$this_report_results = mysqli_fetch_array($this_report,MYSQLI_ASSOC);
		
		$report_region = $this_report_results['region_id'];
		$report_province = $this_report_results['province_id'];
		$report_hub = $this_report_results['hub_id'];
		$report_site = $this_report_results['site_id'];
		$report_groups = $this_report_results['group_ids'];
		$report_unit_ids = $this_report_results['unit_ids'];
		$report_default = $this_report_results['default_report'];
		$report_cluster = $this_report_results['branch_id'];
		$default_color = '#000';
		$title = $this_report_results['title'];
		
		$accessibility_id = $this_report_results['accessibility_type'];
		
		if(!$accessibility_id){
			$accessibility_type_title = 'Visible to others';
			$visible_to_others_display = '';
			
		}else{
			$accessibility_type_title = 'Visible to me only';
			$visible_to_others_display = 'display:none;';
		}
		
	}else{
		$report_region = $user_results['region_id'];
		$report_province = $user_results['province_id'];
		$report_hub = $user_results['hub_id'];
		$report_site = $user_results['site_id'];
		$report_groups = $user_results['user_group_ids'];
		$report_unit_ids = $user_results['unit_id'];
		$report_default = 0;
		
		$report_cluster = $user_results['branch_id'];
		$default_color = '#aaa';
		$title = 'Enter title here';
		
		$accessibility_id = $user_results['id'];
		$accessibility_type_title = 'Visible to others';
		
		$visible_to_others_display = '';
	}
	
	
	$this_cluster_id = $report_cluster;
	if(!$this_cluster_id){
		$this_cluster_title = 'All clusters';
		$this_cluster_id = 0;
		
	}else{
		$this_cluster = mysqli_query($connect,"select * from branches where id = $this_cluster_id")or die(mysqli_error($connect));
		$this_cluster_results = mysqli_fetch_array($this_cluster,MYSQLI_ASSOC);
		$this_cluster_title = $this_cluster_results['title'];
		
	}
	
	$this_unit_id = $report_unit_ids;
	if(!$this_unit_id){
		$this_unit_title = 'All units';
		$this_unit_id = 0;
		
	}else{
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		
		if($this_unit_results['status'] == 0){
			$this_unit_title = $this_unit_results['title'].'[Disabled]';
			
		}else{
			$this_unit_title = $this_unit_results['title'];
		}
		
	}
	
	$this_region_id = $report_region;
	if(!$this_region_id){
		$this_region_title = 'All regions';
		$this_region_id = 0;
		
	}else{		
		$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
		$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
		
		$this_region_title = $this_region_results['title'];
	}
	
	$this_province_id = $report_province;
	if(!$this_province_id){
		$this_province_title = 'All Provinces';
		
	}else{
		$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
		$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
		
		$this_province_title = $this_province_results['title'];		
	}
	
	$this_hub_id = $report_hub;
	if(!$this_hub_id){
		$this_hub_title = 'All Hubs';
		
	}else{
		$this_hub = mysqli_query($connect,"select * from hubs where id = $this_hub_id")or die(mysqli_error($connect));
		$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
		
		$this_hub_title = $this_hub_results['title'];
	}
	
	$this_site_id = $report_site;
	if(!$this_site_id){
		$this_site_title = 'All Sites';
		
	}else{
		$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
		$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
		
		$this_site_title = $this_site_results['title'];
	}


?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Report title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($title);?>"  id="prep_report_title" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000'}$('#new_user_error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='<?php print($title);?>';this.style.color='<?php print($default_color);?>'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Accessibility type:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#user_accessibility_menu').toggle('fast');" id="active_user_accessibility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($accessibility_type_title);?></div>

			<div class="option_menu" id="user_accessibility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_accessibility_menu').toggle('fast');$('#active_user_accessibility').html($(this).html());$('#selected_user_accessibility').val(<?php print($user_results['id']);?>);$('#accessibility_to_others').slideUp('fast');">Visible to me only</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_accessibility_menu').toggle('fast');$('#active_user_accessibility').html($(this).html());$('#selected_user_accessibility').val(0);$('#accessibility_to_others').slideDown('fast');">Visible to others</div>
			
				
			</div>
	</div>
	<input type="hidden" id="selected_user_accessibility" value="<?php print($accessibility_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;<?php print($visible_to_others_display);?>" id="accessibility_to_others">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Region*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#user_region_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify region settings for users');<?php }?>" id="active_user_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_region_title);?></div>

			<div class="option_menu" id="user_region_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_region_menu').toggle('fast');$('#active_user_region').html($(this).html());$('#selected_user_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#new_user_error_message').slideUp('fast');">All Regions</div>
			
				<?php
				
					$region_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($r=0;$r<mysqli_num_rows($region_menu);$r++){
						$region_menu_results = mysqli_fetch_array($region_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_region_menu').toggle('fast');$('#active_user_region').html($(this).html());$('#selected_user_region').val(<?php print($region_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($region_menu_results['id']);?>,'user_province',1,1,'connect-hubs-province_id-{id}-user_hub-1-1|connect-sites-hub_id-{id}-user_site-1-1');$('#new_user_error_message').slideUp('fast');"><?php print($region_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_region" value="<?php print($this_region_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Province:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#user_province_menu').toggle('fast');<?php }else{?>  alert('You are not authorized to modify province settings for users');<?php }?>" id="active_user_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_province_title);?></div>

			<div class="option_menu" id="user_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$province_menu = mysqli_query($connect,"select * from provinces where region_id = $this_region_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($p=0;$p<mysqli_num_rows($province_menu);$p++){
						$province_menu_results = mysqli_fetch_array($province_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_province_menu').toggle('fast');$('#active_user_province').html($(this).html());$('#selected_user_province').val(<?php print($province_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($province_menu_results['id']);?>,'user_hub',1,1,'connect-sites-hub_id-{id}-user_site-1-1');$('#new_user_error_message').slideUp('fast');"><?php print($province_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_province" value="<?php print($this_province_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Hub:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#user_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to modify hub settings for users');<?php }?>" id="active_user_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_hub_title);?></div>

		<div class="option_menu" id="user_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$hub_menu = mysqli_query($connect,"select * from hubs where province_id = $this_province_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($h=0;$h<mysqli_num_rows($hub_menu);$h++){
					$hub_menu_results = mysqli_fetch_array($hub_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_hub_menu').toggle('fast');$('#active_user_hub').html($(this).html());$('#selected_user_hub').val(<?php print($hub_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($hub_menu_results['id']);?>,'user_site',1,1,'');$('#new_user_error_message').slideUp('fast');"><?php print($hub_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_user_hub" value="<?php print($this_hub_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#user_site_menu').toggle('fast'); <?php }else{?> alert('You are not authorised to modify site settings for users');<?php }?>" id="active_user_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="user_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$site_menu = mysqli_query($connect,"select * from sites where hub_id = $this_hub_id and company_id = $company_id order by title")or die(mysqli_error($connect));

				for($s=0;$s<mysqli_num_rows($site_menu);$s++){
					$site_menu_results = mysqli_fetch_array($site_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_site_menu').toggle('fast');$('#active_user_site').html($(this).html());$('#selected_user_site').val(<?php print($site_menu_results['id']);?>);$('#new_user_error_message').slideUp('fast');"><?php print($site_menu_results['title']);?></div>
					<?php
				}
			?>
		</div>
	</div>
	<input type="hidden" id="selected_user_site" value="<?php print($this_site_id);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Cluster*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#user_cluster_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify cluster settings for users');<?php }?>" id="active_user_cluster" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_cluster_title);?></div>

			<div class="option_menu" id="user_cluster_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(0);fetch_cluster_user_groups(<?php print('0,'.$user_id);?>);$('#new_user_error_message').slideUp('fast');">Non-clustered</div>
			
			
				<?php
				
					$cluster_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($cluster_menu);$u++){
						$cluster_menu_results = mysqli_fetch_array($cluster_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_cluster_menu').toggle('fast');$('#active_user_cluster').html($(this).html());$('#selected_user_cluster').val(<?php print($cluster_menu_results['id']);?>);fetch_cluster_user_groups(<?php print($cluster_menu_results['id'].','.$user_id);?>);$('#new_user_error_message').slideUp('fast');"><?php print($cluster_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_cluster" value="<?php print($this_cluster_id);?>">
	
	<script>
		fetch_cluster_user_groups(<?php print($this_cluster_id.','.$user_id);?>);
	
	</script>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:20px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">User groups*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:20px;border:solid 1px #aaa;">

	<div style="width:100%;min-height:30px;height:auto;float:left;max-height:100px;overflow:auto;" id="user_groups_holder">
	
	
	</div>
	<input type="hidden" id="selected_group_ids" value="<?php print($report_groups);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;margin-top:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Unit*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?>$('#user_unit_menu').toggle('fast');<?php }else{?>  alert('You are not allowed to modify unit settings for users'); <?php }?>" id="active_user_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>

			<div class="option_menu" id="user_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_unit_menu').toggle('fast');$('#active_user_unit').html($(this).html());$('#selected_user_unit').val(0);$('#new_user_error_message').slideUp('fast');">All Units</div>
			
			
				<?php
				
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_unit_menu').toggle('fast');$('#active_user_unit').html($(this).html());$('#selected_user_unit').val(<?php print($unit_menu_results['id']);?>);$('#new_user_error_message').slideUp('fast');"><?php print($unit_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_user_unit" value="<?php print($this_unit_id);?>">
</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;margin-top:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;"></div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
	<input type="checkbox" id="prep_report_default" <?php if($report_default){print('checked');}?> onchange="if(this.checked){$('#selected_default_report').val(1);}else{$('#selected_default_report').val(0);}"><label for="prep_report_default" >Default report</label>
	
	</div>
	<input type="hidden" id="selected_default_report" value="<?php print($report_default);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:90px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="save_prep_report" onclick="process_save_prep_report_2()" title="Click to save report">Save report</div>
</div>