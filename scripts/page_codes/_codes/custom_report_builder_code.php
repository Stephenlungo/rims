<?php
if($report_id){
	$button_text = 'Update';
	
	$this_report = mysqli_query($connect,"select * from dynamic_reports where id = $report_id")or die(mysqli_error($connect));
	$this_report_results = mysqli_fetch_array($this_report,MYSQLI_ASSOC);
	
	$title = $this_report_results['title'];
	
	$default_display = $this_report_results['default_display'];
	
	if(!$default_display){
		$default_display_title = 'Report data';
		
	}else{
		$default_display_title = 'Graph';
		
	}
	
	
	$primary_column_id = $this_report_results['primary_column_type'];
	$this_primary_column = mysqli_query($connect,"select * from dynamic_report_primary_column_types where id = $primary_column_id")or die(mysqlI_error($connect));
	$this_primary_column_results = mysqli_fetch_array($this_primary_column,MYSQLI_ASSOC);
	
	$primary_column_type_title = $this_primary_column_results['title'];
	
	$rule_string = explode(',',$this_report_results['rule_string']);
	
	$column_rules = explode('|',$rule_string[0]);
	
	$report_columns = '<div style="width:100%;height:auto;float:left;"  id="column_holder">';
	$total_column_rules = count($column_rules);
	for($c=0;$c<count($column_rules);$c++){
		$this_column_rule = explode(']',$column_rules[$c]);
		
		$this_column_id = $this_column_rule[0];
		$this_dynamic_column = mysqli_query($connect,"select * from dynamic_report_primary_columns where id = $this_column_id")or die(mysqli_error($connect));
		$this_dynamic_column_results = mysqli_fetch_array($this_dynamic_column,MYSQLI_ASSOC);
		
		$initial_rule_string = explode(']',$this_dynamic_column_results['rule_string']);
		
		$report_columns .= '<div style="width:100%;float:left;height:auto;" id="column_'.$c.'_holder"><div style="width:90px;height:30px;line-height:30px;float:left;">Column '.($c+1).':</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#column_'.$c.'_menu\').toggle(\'fast\');$(\'#report_error_message\').slideUp(\'fast\');" id="active_column_'.$c.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:110px;max-width:270px;width:auto;">'.$this_dynamic_column_results['title'].'</div><div class="option_menu" id="column_'.$c.'_menu" style="display:none;width:auto;width:120px;">';
					
			$columns = mysqli_query($connect,"select * from dynamic_report_primary_columns where primary_column_type_id  = $primary_column_id")or die(mysqli_error($connect));
			
			//$data_dependancy_div = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_data_dependancy_'.$c.'_menu\').toggle(\'fast\');$(\'#active_column_data_dependancy_'.$c.'\').html($(this).html());$(\'#selected_column_data_dependancy_'.$c.'\').val(-1);"><i>Independent</i></div>';
			
			for($c1=0;$c1<mysqli_num_rows($columns);$c1++){
				$colunm_results = mysqli_fetch_array($columns,MYSQLI_ASSOC);
				
				$column_rule_string = explode(']',$colunm_results['rule_string']);
				
				$report_columns .= '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_'.$c.'_menu\').toggle(\'fast\');$(\'#active_column_'.$c.'\').html($(this).html());$(\'#selected_column_'.$c.'\').val('.$colunm_results['id'].');$(\'#selected_column_'.$c.'_value_type\').val('.$column_rule_string[10].');check_data_dependancy_columns('.$c.',0)">'.$colunm_results['title'].'</div>';
				
				/*if($c1 != mysqli_num_rows($columns) - 1){
					$data_dependancy_div .='<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_data_dependancy_'.$c.'_menu\').toggle(\'fast\');$(\'#active_column_data_dependancy_'.$c.'\').html($(this).html());$(\'#selected_column_data_dependancy_'.$c.'\').val(-1);">'.$colunm_results['title'].'</div>';
				}*/
			}

		$report_columns .= '</div></div><input type="hidden" id="selected_column_'.$c.'" value="'.$this_column_rule[0].'">	<input type="hidden" id="selected_column_'.$c.'_value_type" value="'.$initial_rule_string[10].'"><div style="width:auto;float:left;height:30px;"><div style="width:110px;float:left;margin-left:5px;height:30px;line-height:30px;">Data dependency:</div><div style="width:auto;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#column_data_dependancy_'.$c.'_menu\').toggle(\'fast\');$(\'#report_error_message\').slideUp(\'fast\');" id="active_column_data_dependancy_'.$c.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:110px;max-width:270px;width:auto;"></div><div class="option_menu" id="column_data_dependancy_'.$c.'_menu" style="display:none;width:auto;width:120px;"></div></div><input type="hidden" id="selected_column_data_dependancy_'.$c.'" value="'.$this_column_rule[3].'"><script>if($(\'#selected_column_data_dependancy_'.$c.'\').val() == \'i\'){$(\'#active_column_data_dependancy_'.$c.'\').html(\'<i>Independent</i>\');}else{$(\'#active_column_data_dependancy_'.$c.'\').html($(\'#active_column_'.$this_column_rule[3].'\').html())}</script>
		</div><div style="width:auto;float:left;height:30px;display:none;" id="value_display_'.$c.'"><div style="width:auto;float:left;margin-left:5px;height:30px;line-height:30px;">Display type:</div><div style="width:auto;min-height:30px;height:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#column_disaggregation_'.$c.'_menu\').toggle(\'fast\');$(\'#report_error_message\').slideUp(\'fast\');" id="active_column_disaggregation_'.$c.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="min-width:110px;max-width:270px;width:auto;">Aggregated</div><div class="option_menu" id="column_disaggregation_'.$c.'_menu" style="display:none;width:auto;width:120px;"><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_disaggregation_'.$c.'_menu\').toggle(\'fast\');$(\'#active_column_disaggregation_'.$c.'\').html($(this).html());$(\'#selected_column_disaggregation_'.$c.').val(0);">Aggregated</div><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_disaggregation_'.$c.'_menu\').toggle(\'fast\');$(\'#active_column_disaggregation_'.$c.'\').html($(this).html());$(\'#selected_column_disaggregation_'.$c.'\').val(1);">Dis-aggregated</div></div></div><input type="hidden" id="selected_column_disaggregation_'.$c.'" value="'.$this_column_rule[1].'"></div><div style="width:auto;float:left;margin-left:5px;height:30px;line-height:30px;">Column width:</div><div style="width:auto;float:left;height:30px;" id="column_width_'.$c.'"><input type="text" id="column_width_input_'.$c.'" style="width:120px;height:25px;margin-top:2px;" value="'.$this_column_rule[2].'" onfocusout="if(isNaN(this.value)){alert(\'Value must be number\');this.value=\''.$this_column_rule[2].'\';}"></div><div style="width:60px;height:20px;line-height:20px;background-color:#fee;text-align:center;float:left;margin-left:10px;margin-top:5px;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#fdd\';" onmouseout="this.style.backgroundColor=\'#fee\';" onclick="var c = confirm(\'Are you sure you wish to remove this column?\');if(c){$(\'#column_'.$c.'_holder\').slideUp(\'fast\');$(\'#column_'.$c.'_active\').val(0);}">Remove</div><input type="hidden" id="column_'.$c.'_active" value="1"></div>';
	}
	
	$report_columns .= '</div><div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eee;text-align:center;cursor:pointer;"  title="Click to add column" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" onclick="add_dynamic_report_column();">Add column</div>';
	
	if(isset($rule_string[1])){
		$additional_rules = explode('|',$rule_string[1]);
		
	}else{
		$additional_rules = array();
		
	}
	
	$default_color = '000';
}else{
	$button_text = 'Save';
	
	$primary_column_id = 0;
	$primary_column_type_title = 'Select option';
	$column_string = '';
	$total_column_rules = 1;
	
	$default_display = 0;
	
	$default_display_title = 'Report data';
	
	
	$additional_rules = array();
	
	$report_columns = '';
	
	$title = 'Enter report title here';
	
	$default_color = '#aaa';
}
?>
<input type="hidden" id="dashboard_id" value="<?php print($dashboard_id);?>">
<input type="hidden" id="dashboard_area_id" value="<?php print($area_id);?>">
<input type="hidden" id="custom_report_id" value="<?php print($report_id);?>">

	<div style="width:auto;height:auto;float:left;">
		<div style="width:40px;height:30px;line-height:30px;float:left;">Title:</div>
			<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($title);?>"  id="report_title" onfocus="if(this.value=='Enter report title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter report title here';this.style.color='#aaa'}"></div>
	
	
		<div style="width:130px;height:30px;line-height:30px;float:left;margin-left:10px;">Primary Column Type:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#primary_column_type_menu').toggle('fast');" id="active_primary_column" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($primary_column_type_title);?></div>

			<div class="option_menu" id="primary_column_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<?php
			$primary_columns = mysqli_query($connect,"select * from dynamic_report_primary_column_types where company_id = $company_id and (module_id = $module_id or module_id = 0) order by title")or die(mysqli_error($connect));
			
			for($p=0;$p<mysqli_num_rows($primary_columns);$p++){
				$primary_columns_results = mysqli_fetch_array($primary_columns,MYSQLI_ASSOC);
				?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#primary_column_type_menu').toggle('fast');$('#active_primary_column').html($(this).html());$('#selected_report_primary_column').val(<?php print($primary_columns_results['id']);?>);$('#columns_holder').slideDown('fast');fetch_report_column_set(<?php print($primary_columns_results['id']);?>);"><?php print($primary_columns_results['title']);?></div>
				<?php
			}
			?>
			</div>
		</div>
		<input type="hidden" id="selected_report_primary_column" value="<?php print($primary_column_id);?>">
		
		<div style="width:100px;height:30px;line-height:30px;float:left;margin-left:10px;">Default display:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#default_display_menu').toggle('fast');" id="active_default_display" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:100px;width:auto;"><?php print($default_display_title);?></div>

			<div class="option_menu" id="default_display_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#default_display_menu').toggle('fast');$('#active_default_display').html($(this).html());$('#selected_default_display').val(0);">Report data</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#default_display_menu').toggle('fast');$('#active_default_display').html($(this).html());$('#selected_default_display').val(1);">Graph</div>
			
			</div>
		</div>
		<input type="hidden" id="selected_default_display" value="<?php print($default_display);?>">
	</div>

	<div style="width:100%;min-height:150px;height:auto;float:left;margin-bottom:5px;" id="columns_holder">
		<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;">Please select columns to add on your report</div>

		<div style="width:100%;height:auto;float:left;" id="report_column_holder"><?php print($report_columns);?></div>
		
		<?php
		$additional_rule_string = '';
		
		if($module_id == 3){
			?>
			
			<div style="width:100%;min-height:30px;height:auto;line-height:15px;float:left;margin-top:20px;margin-bottom:5px;color:#006bb3">You can add additional columns to your report below. Note that values in these columns will be computed as sum numbers:</div>

			<?php
			$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id order by _order")or die(mysqli_error($connect));		
			
			for($d=0;$d<mysqli_num_rows($dynamic_forms);$d++){
				$dynamic_form_results = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
				$dynamic_form_id = $dynamic_form_results['id'];
				
				?>
				<div style="width:99%;height:25px;line-height:25px;border-bottom:solid 1px #fff;background-color:#eef;float:left;padding-left:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddf';" onmouseout="this.style.backgroundColor='#eef';" onclick="$('#report_categories_<?php print($dynamic_form_results['id']);?>').slideToggle('fast');"><?php print($dynamic_form_results['form_title']);?></div>
				
				<div style="width:100%;border-bottom:solid 1px #eee;height:auto;float:left;margin-bottom:20px;display:none;" id="report_categories_<?php print($dynamic_form_results['id']);?>">
					
					<?php
					$categories = mysqli_query($connect,"select * from dynamic_form_categories where dynamic_form_id = $dynamic_form_id and status = 1 order by _order")or die(mysqli_error($connecy));
					
					for($c=0;$c<mysqli_num_rows($categories);$c++){
						$category_results = mysqli_fetch_array($categories,MYSQLI_ASSOC);
						
						$category_id = $category_results['id'];
						
						?>
						<div style="padding-left:5px;width:98%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#fff';" onclick="$('#category_option_<?php print($category_id);?>').slideToggle('fast');"><?php print($category_results['title']);?></div>
						
						<div style="width:100%;height:auto;float:left;display:none;border-bottom:solid 2px #ddd;margin-bottom:20px;" id="category_option_<?php print($category_id);?>">
						
						<?php
						$category_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_category_id = $category_id and status = 1 order by _order")or die(mysqli_error($connect));
						
						for($co=0;$co<mysqli_num_rows($category_options);$co++){
							$dynamic_form_option_results = mysqli_fetch_array($category_options,MYSQLI_ASSOC);
							
							$item_checked = '';
							$output_processing_title = 'Count entries';
							$output_processing_id = 0;
							$data_dependancy_id = 'i';
							for($ar=0;$ar<count($additional_rules);$ar++){
								$this_rule_array = explode('-',$additional_rules[$ar]);
								
								if($this_rule_array[0] == $dynamic_form_option_results['id']){
									$item_checked = 'checked';
									
									if($this_rule_array[1] == 0){
										$output_processing_title = 'Count entries';
										
									}else{
										$output_processing_title = 'Show actual values';

									}
									$output_processing_id = $this_rule_array[1];
									
									$data_dependancy_id = $this_rule_array[2];
									
									if($additional_rule_string == ''){
										$additional_rule_string = $this_rule_array[0];
										
									}else{
										$additional_rule_string .= ','.$this_rule_array[0];
										
									}
								}
							}
							
							
							?>
							<div style="padding-left:5px;width:97%;height:30px;line-height:30px;height:auto;float:left;border-bottom:solid 1px #eee;"><div style="width:270px;float:left;min-height:30px;height:auto;"><input <?php print($item_checked);?> type="checkbox" id="dynamic_option_<?php print($dynamic_form_option_results['id']);?>" onchange="if(this.checked){add_to_selection(<?php print($dynamic_form_option_results['id']);?>,'selected_additional_columns');}else{remove_from_selection(<?php print($dynamic_form_option_results['id']);?>,'selected_additional_columns');}" onclick="check_data_dependancy_columns(<?php print($dynamic_form_option_results['id']);?>,1);"><label for="dynamic_option_<?php print($dynamic_form_option_results['id']);?>"><?php print($dynamic_form_option_results['category_title']);?></label> </div>
							
							<div style="width:auto;float:left;height:30px;margin-left:30px;">
								<div style="width:110px;float:left;margin-left:5px;height:30px;line-height:30px;">Data dependency:</div>
									<div style="width:auto;min-height:30px;height:auto;float:left;">
									
										<div class="option_item" title="Click to change option" onclick="$('#column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>_menu').toggle('fast');$('#report_error_message').slideUp('fast');" id="active_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"></div>

										<div class="option_menu" id="column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>_menu" style="display:none;width:auto;width:120px;">
												<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>_menu').toggle('fast');$('#active_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>').html($(this).html());$('#selected_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>').val('i');"><i>Independent</i></div>
										
											
										</div>
									</div>
									
								<input type="hidden" id="selected_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>" value="<?php print($data_dependancy_id);?>">
								
								<script>
								
									if($('#selected_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>').val() == 'i'){
										$('#active_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>').html('<i>Independent</i>');
									
									}else{
										//$('#active_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>').html($('#active_column_'+$('#selected_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>').val()).html());
										
									}
									
									//var data_div = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>_menu\').toggle(\'fast\');$(\'#active_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>\').html($(this).html());$(\'#selected_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>\').val(\'i\');"><i>Independent</i></div>';
		
									/*for(var c=0;c<Number($('#total_report_columns').val());c++){
										if($('#selected_column_'+c+'_value_type').val() != 0 && $('#selected_column_'+c+'_value_type').val() != 3 && $('#column_'+c+'_active').val() == 1){
											var temp_div = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>_menu\').toggle(\'fast\');$(\'#active_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>\').html($(this).html());$(\'#selected_column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>\').val('+c+');">'+$('#active_column_'+c).html()+'</div>';
											if(data_div == ''){
												data_div = temp_div;
											
											}else{
												data_div = data_div+temp_div;			
											}
										}
									}*/
									
									//$('#column_data_dependancy_<?php print($dynamic_form_option_results['id']);?>_menu').html(data_div);
								
								</script>
								</div>
							
							
							
							
							
							
							
							
							
							
							<div style="width:auto;height:30px;float:right;"><div style="width:130px;height:30px;line-height:30px;float:left;">Output processing:</div>
								<div style="width:auto;min-height:30px;height:auto;float:left;">
									<div class="option_item" title="Click to change option" onclick="$('#output_processing_<?php print($dynamic_form_option_results['id']);?>_menu').toggle('fast');" id="active_output_processing_<?php print($dynamic_form_option_results['id']);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;height:20px;width:auto;"><?php print($output_processing_title);?></div>

									<div class="option_menu" id="output_processing_<?php print($dynamic_form_option_results['id']);?>_menu" style="display:none;min-width:80px;max-width:280px;width:auto;">
										<div class="option_menu_item"  onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_<?php print($dynamic_form_option_results['id']);?>_menu').toggle('fast');$('#active_output_processing_<?php print($dynamic_form_option_results['id']);?>').html($(this).html());$('#selected_output_processing_<?php print($dynamic_form_option_results['id']);?>').val(0);">Count entries</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_<?php print($dynamic_form_option_results['id']);?>_menu').toggle('fast');$('#active_output_processing_<?php print($dynamic_form_option_results['id']);?>').html($(this).html());$('#selected_output_processing_<?php print($dynamic_form_option_results['id']);?>').val(1);">Show actual values</div>
									</div>
									<input type="hidden" id="selected_output_processing_<?php print($dynamic_form_option_results['id']);?>" value="<?php print($output_processing_id);?>">
								</div>
							</div>
						</div>
							
							<?php
							
						}
						?>
						</div>
						
						<?php
					}
					
					?>	
				</div>
				
				<?php
			}
		}
		?>
		<input type="hidden" id="selected_additional_columns" value="<?php print($additional_rule_string);?>">
		<input type="hidden" id="total_report_columns" value="<?php print($total_column_rules);?>">
		<div style="width:100%;height:30px;line-height:30px;float:left;color:red;" id="error_message"></div>
		<div style="margin-top:10px;display:none;width:110px;height:30px;background-color:#77b077;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#9ad09a';" onmouseout="this.style.backgroundColor='#77b077';"  id="client_profile_button" onclick="generate_prep_report();" title="Click to update account details">Generate Report</div>

		<div style="margin-top:10px;width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="save_report_button" onclick="save_dynamic_report(<?php print($report_id);?>);" title="Click to update account details"><?php print($button_text);?></div>
	</div>

