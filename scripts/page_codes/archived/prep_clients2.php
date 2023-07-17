
<?php
	include '_codes/item_details.php';
	include '_codes/item_details_1.php';
	include '_codes/checklists.php';
	include '_codes/prep_category_updater.php';
	
	$location_search = '';
	
	if($user_results['region_id']){
		$location_search .= ' and (region_id = 0 or region_id = '.$user_results['region_id'].')';
		
	}
	
	if($user_results['province_id']){
		$location_search .= ' and (province_id = 0 or province_id = '.$user_results['province_id'].')';
		
	}
	
	if($user_results['hub_id']){
		$location_search .= ' and (hub_id = 0 or hub_id = '.$user_results['hub_id'].')';
		
	}
	
	if($user_results['mother_facility_id']){
		$location_search .= ' and (mother_facility_id = 0 or mother_facility_id = '.$user_results['mother_facility_id'].')';
		
	}
	
	if($user_results['site_id']){
		$location_search .= ' and (site_id = 0 or site_id = '.$user_results['site_id'].')';
		
	}
	
	$branch_search = '';
	if($branch_id){
		$branch_search = ' and (branch_id = '.$branch_id.' or branch_id = 0)';
		
	}
	?>
<input type="hidden" value="3" id ="module_id">
<div style="width:99.5%;height:auto;float:left;padding:2px;">

<div style="width:100%;height:40px;float:left;line-height:40px;border-bottom:solid 1px #fff;">
	<div class="tab" style="color:#fff;border-right:solid 1px #ccc;background-color:#aaf;width:145px;height:40px;border-radius:20px 0px 0px 0px;" onmouseover="this.style.backgroundColor='#99f';" onmouseout="this.style.backgroundColor='#aaf'" id="tab_100" onclick="$('#dashboard_option_bar').slideDown('fast');fetch_script('_codes/prep_dashboad.php?a=0','clients');$('#status_category_holder').slideUp('fast');$('#report_fetch_button').attr('onclick','fetch_dashboard($(\'#selected_dashboard\').val())');change_secondary_tabs(100);">Dashboards</div>

	<div class="tab" style="width:145px;border-right:solid 1px #ccc;background-color:#a15ec7;height:40px;" onmouseover="this.style.backgroundColor='#def';" onmouseout="this.style.backgroundColor='#aef'" id="tab_101" onclick="$('#dashboard_option_bar').slideUp('fast');fetch_script('_codes/client_list.php?a=0','clients');$('#filter_options').slideUp('fast');$('#status_category_holder').slideDown('fast');$('#report_fetch_button').attr('onclick','fetch_client_list()');change_secondary_tabs(101);">PrEP client list</div>

	<div class="tab" style="width:145px;background-color:#a15ec7;height:40px;border-radius:0px 20px 0px 0px;" onmouseover="this.style.backgroundColor='#def';" onmouseout="this.style.backgroundColor='#aef'" id="tab_102" onclick="$('#dashboard_option_bar').slideUp('fast');fetch_script('_codes/prep_reports.php?a=0','clients');$('#filter_options').slideUp('fast');$('#status_category_holder').slideUp('fast');$('#report_fetch_button').attr('onclick','fetch_report(0,0)');change_secondary_tabs(102);">Reports</div>
</div>

<div style="width:100%;height:30px;line-height:30px;float:left;background-color:#f7faff;border-top:solid 1px #ddd;" id="dashboard_option_bar">
<div style="width:auto;height:auto;float:left;" id="dashboard_holder">
		<div style="width:auto;height:30px;line-height:30px;float:left;">Current dashboard:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;margin-left:5px;">

		<div class="option_item" title="Click to change option" onclick="$('#dashboard_menu').toggle('fast');" id="active_dashboard" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" style="min-width:110px;max-width:280px;width:auto;background-color:#fff;">Select dashboard</div>

		<div class="option_menu" id="dashboard_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			$dashboard_array = fetch_db_table('connect','dynamic_dashboards',1,'accessibility_type, title','module_id = 3 '.$branch_search.' and (((accessibility_type = 0 || accessibility_type = 1 || accessibility_type = 2) '.$location_search.') or accessibility_type = 3)');
			$default_dashboard = 0;
			for($d=0;$d<count($dashboard_array['id']);$d++){
				
				$current_user_group_id_array = explode(',',$user_results['user_group_ids']);
				$user_group_found = 0;
				for($g=0;$g<count($current_user_group_id_array);$g++){
					if(check_item_in_list($current_user_group_id_array[$g],$dashboard_array['group_ids'][$d],0,',')){
						$user_group_found = 1;
					}
				}
				
				$current_unit_id_array = explode(',',$user_results['unit_id']);
				$unit_found = 0;
				for($u=0;$u<count($current_unit_id_array);$u++){
					if(check_item_in_list($current_unit_id_array[$u],$dashboard_array['unit_ids'][$d],0,',')){
						$user_group_found = 1;
					}
				}
				
				$user_found = 0;
				if(check_item_in_list($user_id,$dashboard_array['user_ids'][$d],0,',')){
					$user_found = 1;
				}
				
				
				
				if($dashboard_array['accessibility_type'][$d] == 0 || ($dashboard_array['accessibility_type'][$d] == 1 and $user_group_found and $unit_found) || ($dashboard_array['accessibility_type'][$d] == 3 and $user_found and $unit_found) || ($dashboard_array['accessibility_type'][$d] == 2 and $unit_found)){
				?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#dashboard_menu').toggle('fast');$('#active_dashboard').html($(this).html());fetch_dashboard(<?php print($dashboard_array['id'][$d]);?>);$('#selected_dashboard').val(<?php print($dashboard_array['id'][$d]);?>);<?php if($dashboard_array['user_date'][$d] == $user_date || $active_user_roles[8]){?> $('#edit_dashboard_button').slideDown('fast');$('#add_dashboard_space_button').slideDown('fast'); <?php }?>" id="dashboard_item_<?php print($dashboard_array['id'][$d]);?>" ><?php print($dashboard_array['title'][$d]);?></div>
					<?php
					
					if($dashboard_array['default_dashboard'][$d]){
						$default_dashboard = $dashboard_array['id'][$d];
						?>
						<script>
						$('#active_dashboard').html('<?php print($dashboard_array['title'][$d]);?>');
						
						<?php
							if($dashboard_array['user_date'][$d] == $user_date || $active_user_roles[8]){?>
								$('#edit_dashboard_button').slideDown('fast'); 
								$('#add_dashboard_space_button').slideDown('fast');
							<?php 
							}
							
							?>
						</script>
						<?php
						
					}
				}
			}
			?>			
		</div>
		</div>
		<input type="hidden" id="selected_dashboard" value="<?php print($default_dashboard);?>">
	</div>

<div style="cursor:pointer;display:none;width:auto;float:left;height:20px;line-height:20px;padding:3px;margin-top:2px;background-color:orange;color:#fff;" onmouseover="this.style.backgroundColor='#fbbc48';" onmouseout="this.style.backgroundColor='orange';" id="edit_dashboard_button" onclick="fetch_dashboard_details($('#selected_dashboard').val());">Edit dashboard</div>

<div style="cursor:pointer;display:none;width:auto;float:left;height:20px;line-height:20px;padding:3px;margin-left:5px;margin-top:2px;background-color:#c378b5;color:#fff;" onmouseover="this.style.backgroundColor='#d09cc6';" onmouseout="this.style.backgroundColor='#c378b5';" id="add_dashboard_space_button" onclick="fetch_area_details(0);">Add data space</div>

<div style="cursor:pointer;width:auto;float:right;height:20px;line-height:20px;padding:3px;margin-top:2px;background-color:#b1c6ea;color:#fff;" onmouseover="this.style.backgroundColor='#88a8df';" onmouseout="this.style.backgroundColor='#b1c6ea';" onclick="fetch_dashboard_details(0);">Create new dashboard</div>

</div>

<div style="width:100%;height:20px;line-height:20px;float:left;cursor:pointer;background-color:#ddd;text-align:center;color:#000;" onclick="$('#filter_options').slideToggle('fast');" title="Click to open filter options" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#ddd';">Filter options</div>
<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none;" id="filter_options">

	<div style="width:350px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<input type="text" id="client_search_key" value="Enter client name, PrEP ID or phone number" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter client name, PrEP ID or phone number'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter client name, PrEP ID or phone number';this.style.color='#aaa';}" title="Enter client name, PrEP ID or phone number. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13) {fetch_client_list();}">
	</div>

	<div style="width:900px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<div style="width:320px;float:left;margin-left:30px;">
<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">From:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_day_menu').toggle('fast');" id="active_from_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(1);?></div>

<?php
if(date('m',time()) == 1){
	$month = 12;
	$year = date('Y',time()) - 1;
	
}else{
	$month = date('m',time())-1;
	$year = date('Y',time());
	
}

$this_date = mktime(0,0,0,$month,1,$year);
?>

<input type="hidden" id="date_from" value="<?php print(date('m/j/Y',$this_date));?>">
<input type="hidden" id="date_to" value="<?php print(date('m/j/Y',time()));?>">
<div class="option_menu" id="from_day_menu" style="display:none;">
<?php
if(date('j',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_day_menu').toggle('fast');$('#active_from_day').html($(this).html());$('#selected_from_day').val(<?php print($d);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:40px;"><?php print($do);?></div>
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_day_menu').toggle('fast');$('#active_from_day').html($(this).html());$('#selected_from_day').val(<?php print($d);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_from_day" id="selected_from_day" value="<?php print(1);?>">
</div>



<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_month_menu').toggle('fast');" id="active_from_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($month);?></div>


<div class="option_menu" id="from_month_menu" style="display:none;">
<?php



	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_month_menu').toggle('fast');$('#active_from_month').html($(this).html());$('#selected_from_month').val(<?php print($m);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:40px;"><?php print($mo);?></div>
		<?php
	}

?>
</div>
<input type="hidden" name="selected_from_month" id="selected_from_month" value="<?php print($month);?>">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_year_menu').toggle('fast');" id="active_from_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($year);?></div>


<div class="option_menu" id="from_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_year_menu').toggle('fast');$('#active_from_year').html($(this).html());$('#selected_from_year').val(<?php print($y);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_from_year" id="selected_from_year" value="<?php print($year);?>">
</div>

</div>





<div style="width:320px;float:left;margin-left:30px;">
<div style="width:30px;height:30px;line-height:30px;float:left;font-weight:bold;">To:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#to_day_menu').toggle('fast');" id="active_to_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('j',time()));?></div>


<div class="option_menu" id="to_day_menu" style="display:none;">
<?php

if(date('j',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		
	
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_day_menu').toggle('fast');$('#active_to_day').html($(this).html());$('#selected_to_day').val(<?php print($d);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:40px;"><?php print($do);?></div>
		
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

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_day_menu').toggle('fast');$('#active_to_day').html($(this).html());$('#selected_to_day').val(<?php print($d);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_to_day" id="selected_to_day" value="<?php print(date('j',time()));?>">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#to_month_menu').toggle('fast');" id="active_to_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('m',time()));?></div>


<div class="option_menu" id="to_month_menu" style="display:none;">
<?php
	for($m=1;$m<13;$m++){
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_month_menu').toggle('fast');$('#active_to_month').html($(this).html());$('#selected_to_month').val(<?php print($m);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:40px;"><?php print($mo);?></div>
	
		<?php
	}

?>
</div>
<input type="hidden" name="selected_to_month" id="selected_to_month" value="<?php print(date('m',time()));?>">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#to_year_menu').toggle('fast');" id="active_to_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print(date('Y',time()));?></div>


<div class="option_menu" id="to_year_menu" style="display:none;width:65px;">
<?php
for($y=(date('Y',time()));$y>(date('Y',time()) - 10);$y--){
	?>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_year_menu').toggle('fast');$('#active_to_year').html($(this).html());$('#selected_to_year').val(<?php print($y);?>);$('#date_from').val($('#selected_from_month').val()+'/'+$('#selected_from_day').val()+'/'+$('#selected_from_year').val());$('#date_to').val($('#selected_to_month').val()+'/'+$('#selected_to_day').val()+'/'+$('#selected_to_year').val());" style="width:50px;"><?php print($y);?></div>
<?php
}
?>
</div>
<input type="hidden" name="selected_to_year" id="selected_to_year" value="<?php print(date('Y',time()));?>">
</div>



	
	</div>
	<div style="width:auto;height:auto;float:left;">
		<div style="width:70px;height:30px;line-height:30px;float:left;">Date basis:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		

		<div class="option_item" title="Click to change option" onclick="$('#date_basis_menu').toggle('fast');" id="active_date_basis" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Date of entry</div>

		<div class="option_menu" id="date_basis_menu" style="display:none;width:auto;width:150px;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_basis_menu').toggle('fast');$('#active_date_basis').html($(this).html());$('#selected_date_basis').val(0);">Date of entry</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_basis_menu').toggle('fast');$('#active_date_basis').html($(this).html());$('#selected_date_basis').val(1);">Initiation date</div>
		
		
		</div>
		</div>
		<input type="hidden" id="selected_date_basis" value="0">
	</div>
	</div>

	
	<div style="width:auto;height:auto;float:left;">
		<div style="width:60px;height:30px;line-height:30px;float:left;">Region:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		
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

		<div class="option_menu" id="region_menu" style="display:none;width:auto;width:150px;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-sites-hub_id-{id}-site-1-1|connect-agents-site_id-{id}-agent-1-1');">ALL REGIONS</div>
		
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
				
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#province_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change this option');<?php }?>" id="active_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($province_title);?></div>

			<div class="option_menu" id="province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$location_menu = mysqli_query($connect,"select * from provinces where company_id = $company_id $province_search order by title")or die(mysqli_error($connect));

					for($l=0;$l<mysqli_num_rows($location_menu);$l++){
						$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#province_menu').toggle('fast');$('#active_province').html($(this).html());$('#selected_province').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','districts','province_id',<?php print($location_menu_results['id']);?>,'district',1,1,'connect-sites-district_id-{id}-site-1-1|connect-agents-site_id-{id}-agent-1-1');"><?php print($location_menu_results['title']);?></div>
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
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#hub_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change this option');<?php }?>" id="active_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($district_title);?></div>

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
			
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#site_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change this option');<?php }?>" id="active_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

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
	
	<div style="width:auto;height:auto;float:left;" id="agent_holder">
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

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#agent_menu').toggle('fast');$('#active_agent').html($(this).html());$('#selected_agent').val(<?php print($location_menu_results['id']);?>);"><?php print($location_menu_results['_name']);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_agent" value="0">
	</div>
	
	<div style="width:100%;height:auto;float:left;" id="filter_categorisation">
	<div style="width:auto;height:auto;float:left;" id="status_category_holder">
		<div style="width:auto;height:30px;line-height:30px;float:left;">Categorization method:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;margin-left:5px;">

		<div class="option_item" title="Click to change option" onclick="$('#status_category_menu').toggle('fast');" id="active_status_category" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Successive</div>

		<div class="option_menu" id="status_category_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_category_menu').toggle('fast');$('#active_status_category').html($(this).html());$('#selected_status_category').val(0);">Successive</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_category_menu').toggle('fast');$('#active_status_category').html($(this).html());$('#selected_status_category').val(1);">Non-Successive</div>
			
		</div>
		</div>
		<input type="hidden" id="selected_status_category" value="0">
	</div>
	
	<div style="width:auto;height:auto;float:left;">
		<div style="width:100px;height:30px;line-height:30px;float:left;">Account status:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		<div class="option_item" title="Click to change option" onclick="$('#account_status_menu').toggle('fast');" id="active_account_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Activated Accounts</div>

		<div class="option_menu" id="account_status_menu" style="display:none;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#account_status_menu').toggle('fast');$('#active_account_status').html($(this).html());$('#account_status').val(-1);">All Accounts</div>
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#account_status_menu').toggle('fast');$('#active_account_status').html($(this).html());$('#account_status').val(1);">Activated Accounts</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#account_status_menu').toggle('fast');$('#active_account_status').html($(this).html());$('#account_status').val(0);">Deactivated Accounts</div>
		
		</div>
		</div>
		<input type="hidden" id="account_status" value="1">
	</div>
	
	<div style="width:auto;height:auto;float:left;">
		<div style="width:100px;height:30px;line-height:30px;float:left;">Client status:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		<div class="option_item" title="Click to change option" onclick="$('#client_status_menu').toggle('fast');" id="active_client_ative_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">All clients</div>

		<div class="option_menu" id="client_status_menu" style="display:none;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_status_menu').toggle('fast');$('#active_client_ative_status').html($(this).html());$('#client_active_status').val(0);">All clients</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_status_menu').toggle('fast');$('#active_client_ative_status').html($(this).html());$('#client_active_status').val(1);">Current clients</div>
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_status_menu').toggle('fast');$('#active_client_ative_status').html($(this).html());$('#client_active_status').val(2);">Missed appointments</div>
		
		</div>
		</div>
		<input type="hidden" id="client_active_status" value="0">
	</div>
		
		<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="$('#filter_options').slideUp('fast');fetch_client_list();" title="Click to fetch report with specified options">Fetch</div>
	</div>
</div>





<input type="hidden" id="selected_tab" value="0">
<div class="general_holder" id="clients">


</div>

</div>

<script>

//fetch_script('_codes/client_list.php?a=0','clients');tab_item_change(0);
//fetch_script('_codes/prep_reports.php?a=0','clients');tab_item_change(0);
change_secondary_tabs(101);

$('#tab_100').click();

$( function() {
	//$( "#date_from" ).datepicker();
	//$( "#date_to" ).datepicker();
} );
</script>