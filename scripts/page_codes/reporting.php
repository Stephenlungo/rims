<?php
include 'scripts/page_codes/_codes/item_details.php';


?>

<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#c994c7;cursor:pointer;" onclick="$('#filter_options').slideToggle('fast');" title="Click to open filter options" onmouseover="this.style.backgroundColor='#c994a7';" onmouseout="this.style.backgroundColor='#c994c7';">Reporting</div>



<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none;" id="filter_options">

	<div style="width:550px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<div style="width:120px;height:30px;line-height:30px;float:left;">From (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_from" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		<div style="width:105px;height:30px;line-height:30px;float:left;margin-left:10px;">To (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_to" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
	
	</div>
	
	<div style="width:auto;height:auto;float:left;" id="cluster_0_holder">
		<?php
		$this_branch_id = $user_results['branch_id'];
		if(!$this_branch_id){
			$this_branch_title = 'All clusters';
			$this_branch_id = 0;
			
		}else{
			$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
			$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
			$this_branch_title = $this_branch_results['title'];
			
		}
		?>
			<div style="width:50px;height:30px;line-height:30px;float:left;">Cluster:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?> $('#branch_menu').toggle('fast'); <?php }else{?>  alert('You are not authorized to change this option'); <?php }?>" id="active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_branch_title);?></div>

			<div class="option_menu" id="branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_branch').val(0);">All clusters</div>
				<?php
				
					$branch_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($b=0;$b<mysqli_num_rows($branch_menu);$b++){
						$branch_menu_results = mysqli_fetch_array($branch_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_branch').val(<?php print($branch_menu_results['id']);?>);"><?php print($branch_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_branch" value="<?php print($user_results['branch_id']);?>">
		</div>


	<div style="width:auto;height:auto;float:left;" id="unit_0_holder">
	<?php
	$this_unit_id = $user_results['unit_id'];
	if(!$this_unit_id){
		$this_unit_title = 'Select unit';
		$this_unit_id = 0;
		
	}else{
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$this_unit_title = $this_unit_results['title'];
		
	}
	?>
		<div style="width:40px;height:30px;line-height:30px;float:left;">Unit:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?> $('#unit_menu').toggle('fast'); <?php }else{?>  alert('You are not authorized to change unit for this view'); <?php }?>" id="active_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>

		<div class="option_menu" id="unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
				$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id order by title")or die(mysqli_error($connect));

				for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
					$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
					
					if(!$unit_menu_results['status']){
						$status_title = ' (Disabled)';
					}else{
						$status_title = ' ';
						
					}
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(<?php print($unit_menu_results['id']);?>);fetch_menu_items('connect','activities','services',<?php print($unit_menu_results['id']);?>,'activity',1,1,'');"><?php print($unit_menu_results['title'].$status_title);?></div>
					<?php
				}
			?>
		</div>
		</div>
		<input type="hidden" id="selected_unit" value="0">
	</div>

	<div style="width:auto;height:auto;float:left;" id="activity_holder">
		<div style="width:70px;height:30px;line-height:30px;float:left;">Activity:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#activity_menu').toggle('fast');" id="active_activity" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All activities</div>

		<div class="option_menu" id="activity_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<?php
				if($user_results['unit_id']){
					$activity_menu = mysqli_query($connect,"select * from activities where services = $this_unit_id and company_id = $company_id order by title")or die(mysqli_error($connect));

					for($a=0;$a<mysqli_num_rows($activity_menu);$a++){
						$activity_menu_results = mysqli_fetch_array($activity_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#activity_menu').toggle('fast');$('#active_activity').html($(this).html());$('#selected_activity').val(<?php print($activity_menu_results['id']);?>);"><?php print($activity_menu_results['title']);?></div>
						<?php
					}
				}
			?>
			
		</div>
		</div>
		<input type="hidden" id="selected_activity" value="0">
	</div>

<div style="width:auto;height:auto;float:left;">
<div style="width:60px;height:30px;line-height:30px;float:left;">Region:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		
		<?php
		$this_region_id = $user_results['region_id'];
		if($this_region_id){
			$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
			$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			
			$this_region_title = $this_region_results['title'];
		
		}else{
			$this_region_title = 'All Regions';
		}
		?>

		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#region_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change region for this view');<?php }?>" id="active_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($this_region_title);?></div>

		<div class="option_menu" id="region_menu" style="display:none;width:auto;">
		<?php
			
			$location_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($location_menu_results['id']);?>,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-sites-hub_id-{id}-site-1-1|connect-agents-site_id-{id}-agent-1-1');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_region" value="<?php print($this_region_id);?>">
		</div>
	
		
		<div style="width:auto;height:auto;float:left;" id="province_holder">
			<div style="width:70px;height:30px;line-height:30px;float:left;">Provinces:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">

			
			<?php
				$this_province_id = $user_results['province_id'];
				
				if($this_province_id){
					$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
					$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
					
					$province_title = $this_province_results['title'];
					
				}else{
					$province_title = 'All Provinces';
					
				}
				
				if($this_region_id){
					$province_search = ' and region_id = '.$this_region_id;
					
				}else{
					$province_search = ' ';
					
				}
			?>
				
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#province_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change province for this view'); <?php }?>" id="active_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($province_title);?></div>

			<div class="option_menu" id="province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$location_menu = mysqli_query($connect,"select * from provinces where company_id = $company_id $province_search order by title")or die(mysqli_error($connect));

					for($l=0;$l<mysqli_num_rows($location_menu);$l++){
						$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#province_menu').toggle('fast');$('#active_province').html($(this).html());$('#selected_province').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($location_menu_results['id']);?>,'district',1,1,'connect-sites-hub_id-{id}-site-1-1|connect-agents-site_id-{id}-agent-1-1');"><?php print($location_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_province" value="<?php print($this_province_id);?>">
		</div>
		
	<div style="width:auto;height:auto;float:left;" id="hub_holder">
		<div style="width:40px;height:30px;line-height:30px;float:left;">Hub:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

			<?php
				$this_district_id = $user_results['hub_id'];
				
				if($this_district_id){
					$this_district = mysqli_query($connect,"select * from hubs where id = $this_district_id")or die(mysqli_error($connect));
					$this_district_results = mysqli_fetch_array($this_district,MYSQLI_ASSOC);
					
					$district_title = $this_district_results['title'];
	
				}else{
					$district_title = 'All Hubs';
					
				}
				
				if($this_province_id){
					$district_search = ' and province_id = '.$this_province_id;
					
				}else{
					$district_search = ' ';
					
				}
			?>
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to change hub for this view');<?php }?>" id="active_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($district_title);?></div>

		<div class="option_menu" id="hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<?php
			
			$location_menu = mysqli_query($connect,"select * from hubs where company_id = $company_id $district_search order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#hub_menu').toggle('fast');$('#active_hub').html($(this).html());$('#selected_hub').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($location_menu_results['id']);?>,'site',1,1,'connect-agents-site_id-{id}-agent-1-1');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		
		
		
		</div>
		</div>
		<input type="hidden" id="selected_hub" value="<?php print($this_district_id);?>">
	</div>
		
	<div style="width:auto;height:auto;float:left;" id="site_holder">
		<div style="width:40px;height:30px;line-height:30px;float:left;">Site:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

			<?php
				$this_site_id = $user_results['site_id'];
				
				if($this_site_id){
					$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
					$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
					$this_site_title = $this_site_results['title'];
					
				}else{
					$this_site_title = 'All Sites';
					
				}
				
				if($this_district_id){
					$site_search = ' and hub_id = '.$this_district_id;
					
				}else{
					$site_search = ' ';
					
				}
			?>
			
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#site_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change site for his view'); <?php }?>" id="active_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
			$location_menu = mysqli_query($connect,"select * from sites where company_id = $company_id $site_search order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_menu').toggle('fast');$('#active_site').html($(this).html());$('#selected_site').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','agents','site_id',<?php print($location_menu_results['id']);?>,'agent',1,1,'');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_site" value="<?php print($this_site_id);?>">
	</div>
	

	<div style="width:auto;height:auto;float:left;display:none;" id="agent_holder">
		<div style="width:40px;height:30px;line-height:30px;float:left;">Agent:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#agent_menu').toggle('fast');" id="active_agent" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All agents</div>

		<div class="option_menu" id="agent_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
			if($this_site_id){
				$agent_search = ' and site_id = '.$this_site_id;
				
			}else{
				$agent_search = ' ';
				
			}
			
			$location_menu = mysqli_query($connect,"select * from agents where company_id = $company_id $agent_search order by _name")or die(mysqli_error($connect));

			/*for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				
				if($location_menu_results['status'] == 1){
				   $this_agent_name = $location_menu_results['_name'];
				    
				}else{
				    $this_agent_name = $location_menu_results['_name'].'[Disabled]';
				    
				}
			
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_menu').toggle('fast');$('#active_agent').html($(this).html());$('#selected_agent').val(<?php print($location_menu_results['id']);?>);"><?php print($this_agent_name);?></div>
				<?php
			}*/
		?>
		</div>
		</div>
		<input type="hidden" id="selected_agent" value="0">
	</div>
	
	<div style="width:auto;height:auto;float:left;" id="validation_holder">
		<div style="width:70px;height:30px;line-height:30px;float:left;">Validation:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#validation_menu').toggle('fast');" id="active_validation" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All entries</div>

		<div class="option_menu" id="validation_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#validation_menu').toggle('fast');$('#active_validation').html($(this).html());$('#selected_validation').val(-1);">All entries</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#validation_menu').toggle('fast');$('#active_validation').html($(this).html());$('#selected_validation').val(1);">Validated</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#validation_menu').toggle('fast');$('#active_validation').html($(this).html());$('#selected_validation').val(0);">Not validated</div>
			
		</div>
		</div>
		<input type="hidden" id="selected_validation" value="-1">
	</div>
	
	<div style="width:auto;height:auto;float:left;" id="database_holder">
		<div style="width:70px;height:30px;line-height:30px;float:left;">database:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#database_menu').toggle('fast');" id="active_database" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">New database</div>

		<div class="option_menu" id="database_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#database_menu').toggle('fast');$('#active_database').html($(this).html());$('#selected_database').val(0);">New database</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#database_menu').toggle('fast');$('#active_database').html($(this).html());$('#selected_database').val(1);">Old database (slower)</div>
			
		</div>
		</div>
		<input type="hidden" id="selected_database" value="0">
	</div>
	
	
	<?php
if($active_user_roles[5]){?>
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_script('_codes/detailed_list.php?a=0','reporting');tab_item_change(0);" title="Click to fetch report with specified options">Fetch</div>
	
	<?php
}
?>
</div>
<?php
if($active_user_roles[5]){?>
<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="$('#reporting').slideDown('fast');$('#report_graph_holder').slideUp('fast');if($('#reporting').html() == ''){fetch_script('_codes/detailed_list.php?a=0','reporting');}tab_item_change(0);$('#report_fetch_button').slideDown('fast');">Data Pool</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="$('#reporting').slideUp('fast');$('#report_graph_holder').slideDown('fast');if($('#report_graph_holder').html() == ''){fetch_script('_codes/graphs.php?a=1','report_graph_holder');}tab_item_change(1);$('#report_fetch_button').slideUp('fast');">Graphs</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_script('_codes/data_export.php?a=2','reporting');tab_item_change(2);$('#report_fetch_button').slideUp('fast');">Export</div>
</div>



<?php
}
?>

<div class="general_holder" id="reporting"></div>

<div class="general_holder" style="display:none;" id="report_graph_holder"></div>

</div>
<input type="hidden" id="reporting_active" value="1">
<script>
<?php
if($active_user_roles[5]){?>
fetch_script('_codes/detailed_list.php?a=0','reporting');tab_item_change(0);

<?php
}else{
	?>
	$('#reporting').html('<div style="width:100%;height:20px;line-height:20px;color:#f00;text-align:center;margin-top:30px;font-weight:bold;">Oops!!! <br>It appears you are not authorized to view this section</div>');
	<?php
}
?>

general_variable_5 = '';
$( function() {
	$( "#date_from" ).datepicker();
	$( "#date_to" ).datepicker();
} );
</script>
