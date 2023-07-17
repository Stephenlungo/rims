		<div style="width:auto;height:auto;float:left;">
			<div style="width:50px;height:30px;line-height:30px;float:left;">Status:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#status_menu').toggle('fast');" id="active_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Active items</div>

			<div class="option_menu" id="status_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val('-1');">All items</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val(1);">Active items</div>
				
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val(0);">Inactive items</div>
				
				
			</div>
			</div>
			<input type="hidden" id="selected_status" value="1">
		</div>

<div style="width:auto;height:auto;float:left;" id="region_holder">
<div style="width:60px;height:30px;line-height:30px;float:left;">Unit:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		
		<?php
		$this_unit_id = $user_results['unit_id'];
		if($this_unit_id){
			$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
			$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
			
			$this_unit_title = $this_unit_results['title'];
		
		}else{
			$this_unit_title = 'All Units';
		}
		?>

		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#unit_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change this option');<?php }?>" id="active_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($this_unit_title);?></div>

		<div class="option_menu" id="unit_menu" style="display:none;width:auto;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(0);">All units</div>
		
		<?php
			
			$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
				$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
				
				if(!$unit_menu_results['status']){
					$unit_title = $unit_menu_results['title'].'[Disabled]';
					
				}else{
					$unit_title = $unit_menu_results['title'];
					
				}
				
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(<?php print($unit_menu_results['id']);?>);"><?php print($unit_title);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_unit" value="<?php print($this_unit_id);?>">
		</div>
		
		
		
	
	
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_activity_list();" title="Click to fetch report with specified options">Fetch</div>