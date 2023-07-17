<?php
$location_search = '';
	
	if($user_results['region_id']){
		$location_search .= ' and region_id = '.$user_results['region_id'];
		
	}
	
	if($user_results['province_id']){
		$location_search .= ' and province_id = '.$user_results['province_id'];
		
	}
	
	if($user_results['hub_id']){
		$location_search .= ' and hub_id = '.$user_results['hub_id'];
		
	}
	
	if($user_results['mother_facility_id']){
		$location_search .= ' and mother_facility_id = '.$user_results['mother_facility_id'];
		
	}
	
	if($user_results['site_id']){
		$location_search .= ' and site_id = '.$user_results['site_id'];
		
	}
	
	$branch_search = '';
	if($branch_id){
		$branch_search = ' and (branch_id = '.$branch_id.' or branch_id = 0)';
		
	}
	?>
	
	<div style="width:100%;height:30px;line-height:30px;float:left;background-color:#f7faff;border-top:solid 1px #ddd;">
<div style="width:auto;height:auto;float:left;" id="dashboard_holder">
		<div style="width:auto;height:30px;line-height:30px;float:left;">Current dashboard:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;margin-left:5px;">

		<div class="option_item" title="Click to change option" onclick="$('#dashboard_menu').toggle('fast');" id="active_dashboard" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" style="min-width:110px;max-width:280px;width:auto;background-color:#fff;">Select dashboard</div>

		<div class="option_menu" id="dashboard_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
			<?php
			
			$branch_search = '';
	if($branch_id){
		$branch_search = ' and (branch_id = '.$branch_id.' or branch_id = 0)';
		
	}
			
			$dashboard_array = fetch_db_table('connect','dynamic_dashboards',1,'title','module_id = 4 '.$branch_search.' and (((accessibility_type = 0 || accessibility_type = 1 || accessibility_type = 2) '.$location_search.') or accessibility_type = 3)');
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

<div style="width:100%;min-height:700px;height:auto;float:left;" id="prep_dashboard">

<div style="width:100%;height:auto;float:left;" id="dashboard_area_holder"><div style="width:100%;height:700px;float:left;line-height:700px;text-align:center;color:#777;font-size:2em;">No dashboard selected</div></div>


</div>


<script>
if($('#selected_dashboard').val() != 0){
	fetch_dashboard($('#selected_dashboard').val());
	
}

</script>