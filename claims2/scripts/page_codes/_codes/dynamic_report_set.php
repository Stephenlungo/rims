	<?php
	$dynamic_report_column_type_id = $set_id;
	
	$this_dynamic_report_type = mysqli_query($$module_connect,"select * from dynamic_report_primary_column_types where id = $dynamic_report_column_type_id")or die(mysqli_error($$module_connect));
	
	?>
	<div style="width:100%;height:auto;float:left;"  id="column_holder">
	
	<div style="width:100%;float:left;height:auto;" id="column_0_holder">
		<div style="width:90px;height:30px;line-height:30px;float:left;">Column 1:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			
				<div class="option_item" title="Click to change option" onclick="$('#column_0_menu').toggle('fast');$('#report_error_message').slideUp('fast');" id="active_column_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Select item</div>

				<div class="option_menu" id="column_0_menu" style="display:none;width:auto;width:120px;">
					<?php
					$columns = mysqli_query($$module_connect,"select * from dynamic_report_primary_columns where primary_column_type_id  = $dynamic_report_column_type_id")or die(mysqli_error($$module_connect));
					
					for($c=0;$c<mysqli_num_rows($columns);$c++){
						$colunm_results = mysqli_fetch_array($columns,MYSQLI_ASSOC);
						?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#column_0_menu').toggle('fast');$('#active_column_0').html($(this).html());$('#selected_column_0').val(<?php print($colunm_results['id']);?>);<?php if($colunm_results['allow_disagregation']){?> $('#value_display_0').slideDown('fast');<?php }else{?> $('#value_display_0').slideUp('fast'); <?php }?>"><?php print($colunm_results['title']);?></div>
						
						<?php
					}
					?>
				</div>
			</div>
		<input type="hidden" id="selected_column_0" value="0">
		
		<div style="width:auto;float:left;height:30px;display:none;" id="value_display_0">
		<div style="width:auto;float:left;margin-left:5px;height:30px;line-height:30px;">Display type:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			
				<div class="option_item" title="Click to change option" onclick="$('#column_disaggregation_0_menu').toggle('fast');$('#report_error_message').slideUp('fast');" id="active_column_disaggregation_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Aggregated</div>

				<div class="option_menu" id="column_disaggregation_0_menu" style="display:none;width:auto;width:120px;">
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#column_disaggregation_0_menu').toggle('fast');$('#active_column_disaggregation_0').html($(this).html());$('#selected_column_disaggregation_0').val(0);">Aggregated</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#column_disaggregation_0_menu').toggle('fast');$('#active_column_disaggregation_0').html($(this).html());$('#selected_column_disaggregation_0').val(1);">Dis-aggregated</div>
					
				</div>
			</div>
		<input type="hidden" id="selected_column_disaggregation_0" value="0">
		</div>
		
		<div style="width:auto;float:left;margin-left:5px;height:30px;line-height:30px;">Column width:</div>
		<div style="width:auto;float:left;height:30px;" id="column_width_0"><input type="text" id="column_width_input_0" style="width:120px;height:25px;margin-top:2px;" value="120" onfocusout="if(isNaN(this.value)){alert('Value must be number');this.value='120';}"></div>
		
		<div style="width:60px;height:20px;line-height:20px;background-color:#fee;text-align:center;float:left;margin-left:10px;margin-top:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee';" onclick="var c = confirm('Are you sure you wish to remove this column?');if(c){$('#column_0_holder').slideUp('fast');$('#column_0_active').val(0);}">Remove</div>
		<input type="hidden" id="column_0_active" value="1">
	</div>
	
	</div>
	
	<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eee;text-align:center;cursor:pointer;"  title="Click to add column" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="add_dynamic_report_column();">Add column</div>
	
	<input type="hidden" id="total_report_columns" value="1">