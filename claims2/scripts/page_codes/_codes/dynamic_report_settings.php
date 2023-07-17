<?php


if($report_id){
	$this_report = mysqli_query($$module_connect,"select * from dynamic_reports where id = $report_id")or die(mysqli_error($$module_connect));

	$this_report_results = mysqli_fetch_array($this_report,MYSQLI_ASSOC);
	
	$this_primary_column_type_id = $this_report_results['primary_column_type'];
	$this_primary_column_type = mysqli_query($$module_connect,"select * from dynamic_report_primary_column_types where id = $this_primary_column_type_id")or die(mysqli_error($$module_connect));
	
	$this_primary_column_type_results = mysqli_fetch_array($this_primary_column_type,MYSQLI_ASSOC);
	$primary_column_type_title = $this_primary_column_type_results['title'];
	
	$columns = mysqli_query($$module_connect,"select * from dynamic_report_primary_columns where primary_column_type_id  = $this_primary_column_type_id")or die(mysqli_error($$module_connect));
	
	$column_id_array = array();
	$column_title_array = array();	
	for($c=0;$c<mysqli_num_rows($columns);$c++){
		$colunm_results = mysqli_fetch_array($columns,MYSQLI_ASSOC);
										
		$column_id_array[$c] = $colunm_results['id'];
		$column_title_array[$c] = $colunm_results['title'];								
		$column_disagregation_array[$c] = $colunm_results['allow_disagregation'];								
										
	}
	
}else{
	$this_primary_column_type_id = '0';
	$primary_column_type_title = 'Select item';
	
	$rule_string = array(0);
}


?>


<div style="width:900px;min-height:30px;height:auto;margin:0 auto;margin-top:2px;margin-bottom:2px;">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
	<div style="width:300px;margin:0 auto;height:auto;">
			<div style="width:135px;height:30px;line-height:30px;float:left;">Primary Column Type:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
		
		<div class="option_item" title="Click to change option" onclick="if($('#selected_report').val() == 0){$('#report_primary_column_menu').toggle('fast');}else{alert('You cannot change this option for a saved report. To create a new report, select Create New from the Preset report menu');}" id="active_report_primary_column" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($primary_column_type_title);?></div>

		<div class="option_menu" id="report_primary_column_menu" style="display:none;width:auto;width:120px;z-index:10">
			
			<?php
			$dynamic_report_column_types = mysqli_query($$module_connect,"select * from dynamic_report_primary_column_types where company_id = $company_id")or die(Mysqli_error($$module_connect));
			
			for($r=0;$r<mysqli_num_rows($dynamic_report_column_types);$r++){
				$dynamic_report_column_type_results = mysqli_fetch_array($dynamic_report_column_types,MYSQLI_ASSOC);
				
				?>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_primary_column_menu').toggle('fast');$('#active_report_primary_column').html($(this).html());$('#selected_report_primary_column').val(<?php print($dynamic_report_column_type_results['id']);?>);fetch_report_column_set(<?php print($dynamic_report_column_type_results['id']);?>);" id="primary_column_type_0"><?php print($dynamic_report_column_type_results['title']);?></div>
				
				<?php
			}
			?>
		</div>
		</div>
		<input type="hidden" id="selected_report_primary_column" value="<?php print($this_primary_column_type_id);?>">
		</div>
	</div>
	
	<div style="width:100%;height:20px;line-height:20p;px;float:left;text-align:center;background-color:#eef;cursor:pointer;" title="Click to expand/collapse column view" onmouseover="this.style.backgroundColor='#ddf';" onmouseout="this.style.backgroundColor='#eef';" onclick="$('#report_column_holder').slideToggle('fast');">Columns</div>
	
	<div style="width:99.2%;min-height:200px;height:auto;border:solid 1px #eee;float:left;margin-bottom:10px;padding:3px;position:relative" >
	<div style="width:100%;height:auto;float:left;" id="report_column_holder">
		<?php
		if($report_id){
			?>
			<div style="width:100%;height:auto;float:left;"  id="column_holder">
			
			<?php
				$report_columns = explode('|',$this_report_results['rule_string']);
		
				for($c=0;$c<count($report_columns);$c++){
					$column_rules = explode(']',$report_columns[$c]);
					$this_column_id = $column_rules[0];
					
					for($tc=0;$tc<count($column_id_array);$tc++){
						if($this_column_id == $column_id_array[$tc]){
							$this_column_title = $column_title_array[$tc];
							
							break;
							
						}else if($tc == count($column_id_array)-1){
							$this_column_title = 'Column not found';

						}						
					}
					
					?>
					<div style="width:100%;float:left;height:auto;" id="column_<?php print($c);?>_holder">
						<div style="width:90px;height:30px;line-height:30px;float:left;">Column <?php print($c+1);?>:</div>
							<div style="width:auto;min-height:30px;height:auto;float:left;">
							
								<div class="option_item" title="Click to change option" onclick="$('#column_<?php print($c);?>_menu').toggle('fast');$('#report_error_message').slideUp('fast');" id="active_column_<?php print($c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($this_column_title);?></div>

								<div class="option_menu" id="column_<?php print($c);?>_menu" style="display:none;width:auto;width:120px;">
									<?php
									
									
									for($tc=0;$tc<count($column_id_array);$tc++){
										
										?>
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#column_<?php print($c);?>_menu').toggle('fast');$('#active_column_<?php print($c);?>').html($(this).html());$('#selected_column_<?php print($c);?>').val(<?php print($column_id_array[$tc]);?>);<?php if($column_disagregation_array[$tc]){?> $('#value_display_<?php print($c);?>').slideDown('fast');<?php }else{?> $('#value_display_<?php print($c);?>').slideUp('fast'); <?php }?>"><?php print($column_title_array[$tc]);?></div>
										
										<?php
									}
									?>
								</div>
							</div>
						<input type="hidden" id="selected_column_<?php print($c);?>" value="<?php print($this_column_id);?>">
						
						<?php
						if($column_rules[1]){
							$value_display = '';
							$value_display_title = 'Aggregated';
							
						}else{
							$value_display = 'display:none';
							$value_display_title = 'Dis-aggregated';
						}
						?>
						
						<div style="width:auto;float:left;height:30px;<?php print($value_display);?>" id="value_display_<?php print($c);?>">
						<div style="width:auto;float:left;margin-left:5px;height:30px;line-height:30px;">Display type:</div>
							<div style="width:auto;min-height:30px;height:auto;float:left;">
							
								<div class="option_item" title="Click to change option" onclick="$('#column_disaggregation_<?php print($c);?>_menu').toggle('fast');$('#report_error_message').slideUp('fast');" id="active_column_disaggregation_<?php print($c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($value_display_title);?></div>

								<div class="option_menu" id="column_disaggregation_0_menu" style="display:none;width:auto;width:120px;">
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#column_disaggregation_<?php print($c);?>_menu').toggle('fast');$('#active_column_disaggregation_<?php print($c);?>').html($(this).html());$('#selected_column_disaggregation_<?php print($c);?>').val(0);">Aggregated</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#column_disaggregation_<?php print($c);?>_menu').toggle('fast');$('#active_column_disaggregation_<?php print($c);?>').html($(this).html());$('#selected_column_disaggregation_<?php print($c);?>').val(1);">Dis-aggregated</div>
									
								</div>
							</div>
						<input type="hidden" id="selected_column_disaggregation_<?php print($c);?>" value="<?php print($column_rules[1]);?>">
						</div>
						
						<div style="width:auto;float:left;margin-left:5px;height:30px;line-height:30px;">Column width:</div>
						<div style="width:auto;float:left;height:30px;" id="column_width_<?php print($c);?>"><input type="text" id="column_width_input_<?php print($c);?>" style="width:120px;height:25px;margin-top:2px;" value="<?php print($column_rules[2]);?>" onfocusout="if(isNaN(this.value)){alert('Value must be number');this.value='<?php print($column_rules[2]);?>';}"></div>
						
						<div style="width:60px;height:20px;line-height:20px;background-color:#fee;text-align:center;float:left;margin-left:10px;margin-top:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee';" onclick="var c = confirm('Are you sure you wish to remove this column?');if(c){$('#column_<?php print($c);?>_holder').slideUp('fast');$('#column_<?php print($c);?>_active').val(0);}">Remove</div>
						<input type="hidden" id="column_<?php print($c);?>_active" value="1">
					</div>
	
	
				
				<?php
			}	
			
			?>
				
			</div>
			<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eee;text-align:center;cursor:pointer;"  title="Click to add column" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="add_dynamic_report_column();">Add column</div>
				<input type="hidden" id="total_report_columns" value="<?php print(count($report_columns));?>">
				<script>$('#add_column_button').slideDown('fast');</script>
			<?php
		}else{
			
			
		}
		?>
	
	
	</div>
	
	
	<div style="width:100%;height:auto;float:left;display:none;" id="add_column_button">
	
	
	<div style="width:100%;min-height:20px;line-height:20px;float:left;color:#f00;font-weight:bold;display:none;" id="report_error_message">Error comes here</div>
	<div style="width:100%;height:30px;float:left;margin-bottom:10px;margin-top:5px;">
	<div style="width:60px;height:30px;background-color:#aaf;color:#fff;text-align:center;line-height:30px;cursor:pointer;float:left;" onmouseout="this.style.backgroundColor='#aaf';" onmouseover="this.style.backgroundColor='#9595e5';"  id="report_fetch_button" onclick="fetch_report(0);" title="Click to fetch report with specified options">Process</div>
	
	<div style="width:60px;height:30px;background-color:orange;margin-left:5px;color:#fff;text-align:center;line-height:30px;float:left;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"   onclick="save_dynamic_report($('#selected_report').val())">Save</div>
	
	<div style="width:100px;height:30px;background-color:#b429b4;margin-left:5px;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#db5edb';" onmouseout="this.style.backgroundColor='#b429b4';"   onclick="set_report_as_default()" id="set_report_default_button" title="Click to set this report as default report">Set as default</div>
	
	<div style="width:60px;height:30px;background-color:brown;margin-left:5px;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#c13636';" onmouseout="this.style.backgroundColor='brown';"   onclick="delete_dynamic_report()" id="delete_report_button" title="Click to delete this report">Delete</div>
	</div>
	
	</div>
	</div>
</div>