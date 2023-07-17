<?php
if($primary_column_type_id){	
	$button_title = 'Update';
	
	
	$this_primary_column = mysqli_query($$module_connect,"select * from dynamic_report_primary_column_types where id = $primary_column_type_id")or die(mysqli_error($$module_connect));
	
	$this_primary_report_results = mysqli_fetch_array($this_primary_column,MYSQLI_ASSOC);
	
	$primary_column_tile = $this_primary_report_results['title'];
	$reference_table = $this_primary_report_results['reference_table'];
	
	$primary_column_columns = mysqli_query($$module_connect,"select * from dynamic_report_primary_columns where primary_column_type_id = $primary_column_type_id")or die(mysqli_error($$module_connect));
	
	$column_count = mysqli_num_rows($primary_column_columns);
	
	$query_type = $this_primary_report_results['query_type'];
	
	
	$text_color = '#000;';
	
}else{
	$primary_column_tile = 'Enter text here';
	$reference_table = 'Enter table name here';
	$rule_string = '0]';
	$button_title = 'Create';
	
	$column_count = 1;
	$text_color = '#aaa;';
	
	$query_type = '1';
}

if($query_type == '1'){
	$query_type_title = 'Claims Tracker';
	
}else{
	$query_type_title = 'PIPAT Main';
	
}

?>


<div style="width:400px;height:auto;margin-bottom:10px;margin: 0 auto;">
<div style="width:100%;height:auto;float:left;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Primary Column Type:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" id="primary_column_type_title" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>" value="<?php print($primary_column_tile);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:2px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Reference Table:</div>
<div style="width:250px;height:30px;float:left;"><input type="text" id="reference_table" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($reference_table);?>" onfocus="if(this.value=='Enter table name here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter table name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:auto;height:30px;float:left;margin-bottom:5px;">
<div style="line-height:30px;width:130px;height:30px;float:left;">Query Type: </div>
<div style="width:250px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

	<div class="option_item" title="Click to change option" onclick="$('#advanced_report_query_type_menu').toggle('fast');" id="active_advanced_report_query_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($query_type_title);?></div>
	
	<div class="option_menu" id="advanced_report_query_type_menu" style="display:none;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_query_type_menu').toggle('fast');$('#active_advanced_report_query_type').html($(this).html());$('#advanced_report_query_type_id').val(1);" >Claim Tracker</div>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_query_type_menu').toggle('fast');$('#active_advanced_report_query_type').html($(this).html());$('#advanced_report_query_type_id').val(0);" >PIPAT Main</div>

	</div>
</div>
<input type="hidden" id="advanced_report_query_type_id" value="<?php print($query_type);?>">
</div>

</div>

<div style="margin-top:15px;width:100%;height:20px;line-height:20px;float:left;text-align:center;background-color:#eef;cursor:pointer;" title="Click to expand/collapse column view" onmouseover="this.style.backgroundColor='#ddf';" onmouseout="this.style.backgroundColor='#eef';" onclick="$('#report_item_holder').slideToggle('fast');">Available Columns</div>

<div style="width:100%;height:auto;float:left" id="advanced_report_columns">
	<?php
	for($c=0;$c<$column_count;$c++){
		if($primary_column_type_id){
			$primary_column_columns_results = mysqli_fetch_array($primary_column_columns,MYSQLI_ASSOC);
			
			$rule_string_code = $primary_column_columns_results['rule_string'];
			
			$rule_string = explode('|',$rule_string_code);
			
			$primary_column_tile = $primary_column_columns_results['title'];
			$column_disagregation_rules = $primary_column_columns_results['column_disaggregation_rules'];
			
			$disagregation_column = $primary_column_columns_results['disagregation_column'];
			if($disagregation_column == ''){
				$disagregation_column = 'Enter text here';
			}
			$allow_disagregation = $primary_column_columns_results['allow_disagregation'];
			
			$column_id = $primary_column_columns_results['id'];
			
			$text_color = '#000;';
			
		}else{
			$rule_string_code = "0]]1]]]]0]]0]+";
			$rule_string = explode('|',$rule_string_code);
			
			$primary_column_tile = 'Enter text here';
			$column_disagregation_rules = '';
			$column_id = 0;
			$disagregation_column = 'Enter text here';
			$text_color = '#aaa;';
			
			$allow_disagregation = 0;
		}
		
			?>
			<div style="width:100%;height:auto;float:left;margin-bottom:10px;" id="advanced_report_item_<?php print($c);?>">
				<?php if($c){?><div style="cursor:pointer;width:100%;height:20px;line-height:20px;margin-top:10px;" ><div style="width:120px;height:20px;float:right;text-align:center;background-color:#f6dede;color:#000;" onmouseover="this.style.backgroundColor='#f9ebeb';" onmouseout="this.style.backgroundColor='#f6dede';" onclick="var c = confirm('Are you sure you wish to remove this column');if(c){$('#advanced_report_item_<?php print($c);?>').slideUp('fast');$('#advanced_report_item_<?php print($c);?>_active').val(0);}" title="Click to remove this column">Remove Column</div></div><?php
				}
			
				
	?>			
				
				<div style="width:100%;height:auto;float:left;margin-top:2px;">
					<div style="width:70px;float:left;height:30px;line-height:30px;font-weight:bold;">Column <?php print($c+1);?></div>
					
					<div style="width:250px;height:30px;float:left;margin-bottom:5px;"><input type="text" id="column_title_<?php print($c);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>" value="<?php print($primary_column_tile);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
				</div>
				<div style="width:100%;height:auto;float:left;" id="column_data_holder_<?php print($c);?>">
				<?php
				for($o=0;$o<count($rule_string);$o++){
					$operator_rules = explode(']',$rule_string[$o]);	
					
					if($operator_rules[0] == 0){
						$this_value_type = 'Internal';
						$display_holder = 'display:none';

					}else{
						$this_value_type = 'External';
						$display_holder = '';
					}
				?>
				
					<div style="width:100%;height:auto;float:left;" id="column_data_<?php print($c.'_'.$o);?>">
						<div style="margin-left:70px;width:auto;height:30px;float:left;margin-bottom:5px;">
							<div style="line-height:30px;width:80px;height:30px;float:left;">Column type: </div>
							<div style="width:60px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

								<div class="option_item" title="Click to change option" onclick="$('#advanced_report_table_type_menu_<?php print($c.'_'.$o);?>').toggle('fast');" id="active_advanced_report_table_type_<?php print($c.'_'.$o);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($this_value_type);?></div>
								
								<div class="option_menu" id="advanced_report_table_type_menu_<?php print($c.'_'.$o);?>" style="display:none;">
									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_table_type_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_advanced_report_table_type_<?php print($c.'_'.$o);?>').html($(this).html());$('#advanced_report_table_type_id_<?php print($c.'_'.$o);?>').val(0);$('#external_value_options_<?php print($c.'_'.$o);?>').slideUp('fast');$('#query_type_holder_<?php print($c.'_'.$o);?>').slideUp('fast');" >Internal</div>

									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_table_type_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_advanced_report_table_type_<?php print($c.'_'.$o);?>').html($(this).html());$('#advanced_report_table_type_id_<?php print($c.'_'.$o);?>').val(1);$('#external_value_options_<?php print($c.'_'.$o);?>').slideDown('fast');$('#query_type_holder_<?php print($c.'_'.$o);?>').slideDown('fast');" >External</div>

								</div>
							</div>
							<input type="hidden" id="advanced_report_table_type_id_<?php print($c.'_'.$o);?>" value="<?php print($operator_rules[0]);?>">
						</div>
				
						<?php
						if($operator_rules[1] == ''){
							$internal_column_name = 'Enter text here';
							$text_color = '#aaa';
						
						}else{
							$internal_column_name = $operator_rules[1];
							$text_color = '#000';
							
						}
						
						if($operator_rules[2]){
							$this_query_type_title = 'Claims Tracker';
							
						}else{
							$this_query_type_title = 'PIPAT Main';
							
						}
						?>

						<div style="width:auto;height:30px;float:left;margin-bottom:5px;margin-left:5px;" id="internal_value_options_<?php print($c.'_'.$o);?>"><div style="width:100px;height:30px;line-height:30px;float:left;">Internal column:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="internal_table_item_<?php print($c.'_'.$o);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($internal_column_name);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div></div>
						
						<div style="width:auto;height:30px;float:left;margin-left:5px;<?php print($display_holder);?>" id="query_type_holder_<?php print($c.'_'.$o);?>">
							<div style="line-height:30px;width:auto;height:30px;float:left;">Query Type: </div>
							<div style="width:auto;min-height:30px;height:auto;float:left;margin-left:3px;" onclick="$('#error_message').slideUp('fast');">

								<div class="option_item" title="Click to change option" onclick="$('#advanced_report_query_type_menu_<?php print($c.'_'.$o);?>').toggle('fast');" id="active_advanced_report_query_type_<?php print($c.'_'.$o);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($this_query_type_title);?></div>
								
								<div class="option_menu" id="advanced_report_query_type_menu_<?php print($c.'_'.$o);?>" style="display:none;">
									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_query_type_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_advanced_report_query_type_<?php print($c.'_'.$o);?>').html($(this).html());$('#advanced_report_query_type_id_<?php print($c.'_'.$o);?>').val(1);" >Claims Tracker</div>

									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_query_type_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_advanced_report_query_type_<?php print($c.'_'.$o);?>').html($(this).html());$('#advanced_report_query_type_id_<?php print($c.'_'.$o);?>').val(0);" >PIPAT Main</div>

								</div>
							</div>
							<input type="hidden" id="advanced_report_query_type_id_<?php print($c.'_'.$o);?>" value="<?php print($operator_rules[2]);?>">
						</div>
						
						
						
						<div style="width:60px;height:20px;line-height:20px;background-color:#fee;text-align:center;float:right;cursor:pointer;" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee';" onclick="var c = confirm('Are you sure you wish to remove this entry?');if(c){$('#column_data_<?php print($c.'_'.$o);?>').slideUp('fast');$('#advanced_report_operator_<?php print($c.'_'.$o);?>_active').val(0);}">Remove</div>

						<div style="margin-left:70px;width:auto;height:auto;float:left;margin-bottom:5px;<?php print($display_holder);?>" id="external_value_options_<?php print($c.'_'.$o);?>">

						<?php
						if($operator_rules[3] == ''){
							$external_table_name = 'Enter text here';
							$text_color = '#aaa';
							
						}else{
							$external_table_name = $operator_rules[3];
							$text_color = '#000';
						}
						
						if($operator_rules[4] == ''){
							$external_column_name = 'Enter text here';
							$text_color = '#aaa';
							
						}else{
							$external_column_name = $operator_rules[4];
							$text_color = '#000';
						}
						
						if($operator_rules[5] == ''){
							$external_value_column_name = 'Enter text here';
							$text_color = '#aaa';
							
						}else{
							$external_value_column_name = $operator_rules[5];
							$text_color = '#000';
						}
						
						?>
						
						
				
						<div style="width:90px;height:30px;line-height:30px;float:left;">External table:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="external_table_<?php print($c.'_'.$o);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($external_table_name);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>

						<div style="width:100px;height:30px;line-height:30px;float:left;margin-left:5px;">External column:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="external_table_item_<?php print($c.'_'.$o);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($external_column_name);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>

						<div style="width:100px;height:30px;line-height:30px;float:left;margin-left:5px;">Value column:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="external_value_item_<?php print($c.'_'.$o);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($external_value_column_name);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						
						

						<div style="width:auto;height:30px;float:left;margin-bottom:5px;margin-top:5px;">
						<div style="line-height:30px;width:100px;height:30px;float:left;">Value filter type: </div>
						<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">
						
						<?php
						$display_holder = '';
						if($operator_rules[6] == 0){
							$value_filter_type_title = 'Non';
							$display_holder = 'display:none;';
							
						}else if($operator_rules[6] == 1){
							$value_filter_type_title = 'Equal to';
							
						}else if($operator_rules[6] == 2){
							$value_filter_type_title = 'Not equal to';
							
						}else if($operator_rules[6] == 3){
							$value_filter_type_title = 'Less than';
							
						}else if($operator_rules[6] == 4){
							$value_filter_type_title = 'Greater than';
							
						}
						?>

						<div class="option_item"  title="Click to change option" onclick="$('#value_filter_menu_<?php print($c.'_'.$o);?>').toggle('fast');" id="active_value_filter_<?php print($c.'_'.$o);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($value_filter_type_title);?></div>


						<div class="option_menu" id="value_filter_menu_<?php print($c.'_'.$o);?>" style="display:none;width:120px;">
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_value_filter_<?php print($c.'_'.$o);?>').html($(this).html());$('#value_filter_id_<?php print($c.'_'.$o);?>').val(0);$('#value_filter_holder_<?php print($c.'_'.$o);?>').slideUp('fast');" >Non</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_value_filter_<?php print($c.'_'.$o);?>').html($(this).html());$('#value_filter_id_<?php print($c.'_'.$o);?>').val(1);$('#value_filter_holder_<?php print($c.'_'.$o);?>').slideDown('fast');" >Equal to</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_value_filter_<?php print($c.'_'.$o);?>').html($(this).html());$('#value_filter_id_<?php print($c.'_'.$o);?>').val(2);$('#value_filter_holder_<?php print($c.'_'.$o);?>').slideDown('fast');" >Not Equal to</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_value_filter_<?php print($c.'_'.$o);?>').html($(this).html());$('#value_filter_id_<?php print($c.'_'.$o);?>').val(3);$('#value_filter_holder_<?php print($c.'_'.$o);?>').slideDown('fast');" >Less than</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_value_filter_<?php print($c.'_'.$o);?>').html($(this).html());$('#value_filter_id_<?php print($c.'_'.$o);?>').val(4);$('#value_filter_holder_<?php print($c.'_'.$o);?>').slideDown('fast');" >Greater than</div>

						</div>
						</div>
						<input type="hidden" id="value_filter_id_<?php print($c.'_'.$o);?>" value="<?php print($operator_rules[6]);?>">
						</div>
					
						<?php
						if($operator_rules[7] == ''){
							$value_filter_name = 'Enter text here';
							$text_color = '#aaa';
							
						}else{
							$value_filter_name = $operator_rules[7];
							$text_color = '#000';
						}
						
						if($operator_rules[8] == ''){
							$column_filter_name = 'Enter text here';
							$text_color = '#aaa';
							
						}else{
							$column_filter_name = $operator_rules[8];
							$text_color = '#000';
						}
						
						?>

						<div style="width:auto;height:30px;float:left;<?php print($display_holder);?>" id="value_filter_holder_<?php print($c.'_'.$o);?>">
						
						<div style="width:90px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;">Filter column:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="column_filter_<?php print($c.'_'.$o);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($column_filter_name);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						
						
						<div style="width:70px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;">Filter value:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_filter_<?php print($c.'_'.$o);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($value_filter_name);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						
					
						
						</div>
						
						<?php
						if($operator_rules[9] == 0){
							$output_processing_title = 'Count';
							
						}else if($operator_rules[9] == 1){
							$output_processing_title = 'Sum';
							
						}else if($operator_rules[9] == 2){
							$output_processing_title = 'Count average';
							
						}else if($operator_rules[9] == 3){
							$output_processing_title = 'Sum average';
							
						}else if($operator_rules[9] == 4){
							$output_processing_title = 'Difference average';
							
						}else if($operator_rules[9] == 5){							
							$output_processing_title = 'Values';							
						}
						?>

						<div style="width:100%;height:30px;float:left;margin-bottom:5px;margin-top:5px;">
						<div style="line-height:30px;width:115px;height:30px;float:left;">Output processing: </div>
						<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

						<div class="option_item" title="Click to change option" onclick="$('#output_processing_menu_<?php print($c.'_'.$o);?>').toggle('fast');" id="active_output_processing_<?php print($c.'_'.$o);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($output_processing_title);?></div>


						<div class="option_menu" id="output_processing_menu_<?php print($c.'_'.$o);?>" style="display:none;">

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_output_processing_<?php print($c.'_'.$o);?>').html($(this).html());$('#output_processing_id_<?php print($c.'_'.$o);?>').val(5);" >Values</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_output_processing_<?php print($c.'_'.$o);?>').html($(this).html());$('#output_processing_id_<?php print($c.'_'.$o);?>').val(0);" >Count</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_output_processing_<?php print($c.'_'.$o);?>').html($(this).html());$('#output_processing_id_<?php print($c.'_'.$o);?>').val(1);" >Sum</div>

						<div style="display:none;" class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_output_processing_<?php print($c.'_'.$o);?>').html($(this).html());$('#output_processing_id_<?php print($c.'_'.$o);?>').val(2);" >Count average</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_output_processing_<?php print($c.'_'.$o);?>').html($(this).html());$('#output_processing_id_<?php print($c.'_'.$o);?>').val(3);" >Sum average</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_output_processing_<?php print($c.'_'.$o);?>').html($(this).html());$('#output_processing_id_<?php print($c.'_'.$o);?>').val(4);" >Difference average</div>

						</div>
						</div>
						<input type="hidden" id="output_processing_id_<?php print($c.'_'.$o);?>" value="<?php print($operator_rules[9]);?>">
						
						</div>
						</div>
						
						<div style="width:100%;height:30px;float:left;margin-bottom:20px;<?php if($o==(count($rule_string)-1)){print('display:none');}?>" id="column_operator_<?php print($c.'_'.$o);?>">
							<div style="width:130px;height:30px;margin: 0 auto;margin-bottom:5px;">
								<div style="width:60px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

									<div class="option_item" title="Click to change option" onclick="$('#operator_menu_<?php print($c.'_'.$o);?>').toggle('fast');" id="active_operator_<?php print($c.'_'.$o);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;"><?php print($operator_rules[10]);?></div>


									<div class="option_menu" id="operator_menu_<?php print($c.'_'.$o);?>" style="display:none;width:30px;text-align:center;">

										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_operator_<?php print($c.'_'.$o);?>').html($(this).html());$('#operator_<?php print($c.'_'.$o);?>').val('+');" >+</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_operator_<?php print($c.'_'.$o);?>').html($(this).html());$('#operator_<?php print($c.'_'.$o);?>').val('-');" >-</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_operator_<?php print($c.'_'.$o);?>').html($(this).html());$('#operator_<?php print($c.'_'.$o);?>').val('*');" >X</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_<?php print($c.'_'.$o);?>').toggle('fast');$('#active_operator_<?php print($c.'_'.$o);?>').html($(this).html());$('#operator_<?php print($c.'_'.$o);?>').val('/');" >/</div>
									</div>
								</div>
								<input type="hidden" id="operator_<?php print($c.'_'.$o);?>" value="<?php print($operator_rules[10]);?>">
							</div>
						</div>
					
						<input type="hidden" id="advanced_report_operator_<?php print($c.'_'.$o);?>_active" value="1">
					</div>
						
						<?php
				}
				
				?>
				</div>
				<input type="hidden" id="total_operators_<?php print($c);?>" value="<?php print(count($rule_string));?>">
				<div style="width:100%;height:30px;float:left;"><div style="width:90px;height:20px;line-height:20px;float:right;text-align:center;background-color:#ddd;cursor:pointer;margin-top:10px;" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='#ddd';" onclick="add_advanced_report_operator('_<?php print($c);?>')">Add operator</div></div>
				
				
				
				
			
				
				
				
				
				<?php
				
				if(!$allow_disagregation){
					$disagregation_title = "Don't allow dis-aggregation";
					$total_disagregations = 0;
					$holder_diplay = 'display:none;';					
					$disagregation_rules = '';
					
					$text_color = '#aaa';
					
				}else{
					$disagregation_title = "Allow dis-aggregation";				
					$holder_diplay = '';					
					$disagregation_rules = explode('|',$column_disagregation_rules);
					
					
					if($disagregation_rules[0] != ''){
						$total_disagregations = count($disagregation_rules);
						
					}else{
						$total_disagregations = 0;
						
					}
					
					
					$text_color = '#000';
				}

				?>

				<div style="width:620px;height:30px;float:left;margin-bottom:10px;margin-top:30px;display:none;"><div style="width:auto;height:30px;float:left;margin-bottom:5px;margin-top:5px;">
				<div style="line-height:30px;width:100px;height:30px;float:left;">Dis-aggregation: </div>
				<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

				<div class="option_item" title="Click to change option" onclick="$('#value_disagregation_menu_<?php print($c);?>').toggle('fast');" id="active_value_disagregation_<?php print($c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($disagregation_title);?></div>


				<div class="option_menu" id="value_disagregation_menu_<?php print($c);?>" style="display:none;">

				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_disagregation_menu_<?php print($c);?>').toggle('fast');$('#active_value_disagregation_<?php print($c);?>').html($(this).html());$('#value_disagregation_id_<?php print($c);?>').val(0);$('#value_disagregation_item_<?php print($c);?>').slideUp('fast');$('#disagregation_item_definitions_<?php print($c);?>').slideUp('fast');" >Don't allow dis-aggregation</div>

				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_disagregation_menu_<?php print($c);?>').toggle('fast');$('#active_value_disagregation_<?php print($c);?>').html($(this).html());$('#value_disagregation_id_<?php print($c);?>').val(1);$('#value_disagregation_item_<?php print($c);?>').slideDown('fast');$('#disagregation_item_definitions_<?php print($c);?>').slideDown('fast');" >Allow dis-aggregation</div>

				</div>
				</div>
				<input type="hidden" id="value_disagregation_id_<?php print($c);?>" value="<?php print($allow_disagregation);?>">
				</div>

					<div style="width:auto;height:auto;float:left;<?php print($holder_diplay);?>" id="value_disagregation_item_<?php print($c);?>">
						<div style="width:150px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;" >Dis-aggregation column:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_disagregation_column_<?php print($c);?>" style="border:solid 1px #aaa;width:100%;height:30px;color:<?php print($text_color);?>;" value="<?php print($disagregation_column);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
					</div>

				</div>

		<div style="width:100%;height:auto;float:left;<?php print($holder_diplay);?>" id="disagregation_item_definitions_<?php print($c);?>">
		<div style="width:100%;height:20px;line-height:20px;background-color:#fff1ff;float:left;text-align:center;">Dis-aggregation column definitions</div>


		<div style="width:100%;height:auto;float:left;" id="disagregation_item_definitions_holder_<?php print($c);?>">
		<?php
			for($d=0;$d<$total_disagregations;$d++){					
				if($disagregation_rules[$d] != ''){
					$this_disagregation_rules = explode(']',$disagregation_rules[$d]);
					
					if($this_disagregation_rules[0] == 0){
						$definition_type_title = 'Equal to';
						
					}else if($this_disagregation_rules[0] == 1){
						$definition_type_title = 'Greater than';
						
					}else if($this_disagregation_rules[0] == 2){
						$definition_type_title = 'Less than';
						
					}
				?>
					<div style="width:100%;height:auto;float:left;" id="disagregation_item_definition_<?php print($c.'_'.$d);?>">
						<div style="width:auto;height:30px;float:left;margin-bottom:5px;margin-top:5px;">
						<div style="line-height:30px;width:100px;height:30px;float:left;">Definition type: </div>
						<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

						<div class="option_item" title="Click to change option" onclick="$('#disagregation_definition_type_menu_<?php print($c.'_'.$d);?>').toggle('fast');" id="active_disagregation_definition_type_<?php print($c.'_'.$d);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($definition_type_title);?></div>


						<div class="option_menu" id="disagregation_definition_type_menu_<?php print($c.'_'.$d);?>" style="display:none;">

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#disagregation_definition_type_menu_<?php print($c.'_'.$d);?>').toggle('fast');$('#active_disagregation_definition_type_<?php print($c.'_'.$d);?>').html($(this).html());$('#disagregation_definition_type_id_<?php print($c.'_'.$d);?>').val(0);" >Equal to</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#disagregation_definition_type_menu_<?php print($c.'_'.$d);?>').toggle('fast');$('#active_disagregation_definition_type_<?php print($c.'_'.$d);?>').html($(this).html());$('#disagregation_definition_type_id_<?php print($c.'_'.$d);?>').val(1);" >Greater than</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#disagregation_definition_type_menu_<?php print($c.'_'.$d);?>').toggle('fast');$('#active_disagregation_definition_type_<?php print($c.'_'.$d);?>').html($(this).html());$('#disagregation_definition_type_id_<?php print($c.'_'.$d);?>').val(2);" >Less than</div>

						</div>
						</div>
						<input type="hidden" id="disagregation_definition_type_id_<?php print($c.'_'.$d);?>" value="<?php print($this_disagregation_rules[0]);?>">
						</div>

						<div style="width:auto;height:auto;float:left;">
							<div style="width:40px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;" >Value:</div>
							<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_disagregation_<?php print($c.'_'.$d);?>" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($this_disagregation_rules[1]);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						</div>
						
						<div style="width:auto;height:auto;float:left;">
							<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;" >Definition:</div>
							<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_disagregation_definition_<?php print($c.'_'.$d);?>" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($this_disagregation_rules[2]);?>" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						</div>
						
						
						<div style="width:60px;text-align:center;color:#fff;line-height:25px;float:left;height:25px;margin-top:7px;margin-left:2px;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor='#ae3b3b';" onmouseout="this.style.backgroundColor='brown'" id="remove_disagregation_item_definition_<?php print($c.'_'.$d);?>" onclick="var c = confirm('Are you sure you wish to remove this definition?');if(c){$('#disagregation_item_definition_active_<?php print($c.'_'.$d);?>').val(0);$('#disagregation_item_definition_<?php print($c.'_'.$d);?>').slideUp('fast');}">Remove</div>
						<input type="hidden" id="disagregation_item_definition_active_<?php print($c.'_'.$d);?>" value="1">
					</div>
			<?php
				}
			}
			?>
		</div>
			<input type="hidden" id="total_disagregation_item_definitions_<?php print($c);?>" value="<?php print($total_disagregations);?>">
			<div style="width:40px;margin: 0 auto;height:auto;">
			<div style="width:40px;float:left;height:25px;border:solid 1px #ccc;text-align:center;margin-left:2px;margin-top:7px;line-height:25px;background-color:#ddd;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#ddd';" onclick="add_disagregation_item_definition('_<?php print($c);?>');">Add</div>
			</div>

		</div><input type="hidden" id="advanced_report_item_<?php print($c);?>_active" value="1">
		</div><input type="hidden" id="advanced_report_item_id_<?php print($c);?>" value="<?php print($column_id);?>">
			
			
			<?php
					
		}
	?>
	</div>


<div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;background-color:#ddd;cursor:pointer;margin-top:10px;" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='#ddd';" onclick="add_advanced_report_column()">Add Column</div>




<input type="hidden" id="total_columns" value="<?php print($column_count);?>">


<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="error_message"></div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_update_primary_column_button" onclick="create_or_update_advanced_report_column(<?php print($primary_column_type_id);?>)"><?php print($button_title);?></div>

<?php
if($primary_column_type_id){
	?>
	
	<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#bf6262';" onmouseout="this.style.backgroundColor='brown';"  id="delete_primary_column_button" onclick="delete_advanced_report_column(<?php print($primary_column_type_id);?>)">Delete</div>
	
	<?php
}
?>
</div>


















<div style="width:100%;height:auto;float:left;display:none;" id="default_advanced_report_columns">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;border-bottom:solid 1px #eee;" id="advanced_report_item_c">
				<div style="cursor:pointer;width:100%;height:20px;line-height:20px;margin-top:10px;" ><div style="width:120px;height:20px;float:right;text-align:center;background-color:#f6dede;color:#000;" onmouseover="this.style.backgroundColor='#f9ebeb';" onmouseout="this.style.backgroundColor='#f6dede';" onclick="var c = confirm('Are you sure you wish to remove this column');if(c){$('#advanced_report_item_c').slideUp('fast');$('#advanced_report_item_c_active').val(0);}" title="Click to remove this column">Remove Column</div></div>
				
				<div style="width:100%;height:auto;float:left;margin-top:2px;">
					<div style="width:70px;float:left;height:30px;line-height:30px;font-weight:bold;">Column 1</div>
					
					<div style="width:250px;height:30px;float:left;margin-bottom:5px;"><input type="text" id="column_title_c" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
				</div>
				
					<div style="width:100%;height:auto;float:left;" id="column_data_holder_c">
					<div style="width:100%;height:auto;float:left;" id="column_data_c_y">
						<div style="margin-left:70px;width:auto;height:30px;float:left;margin-bottom:5px;">
							<div style="line-height:30px;width:80px;height:30px;float:left;">Column type: </div>
							<div style="width:60px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

								<div class="option_item" title="Click to change option" onclick="$('#advanced_report_table_type_menu_c_y').toggle('fast');" id="active_advanced_report_table_type_c_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Internal</div>
								
								<div class="option_menu" id="advanced_report_table_type_menu_c_y" style="display:none;">
									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_table_type_menu_c_y').toggle('fast');$('#active_advanced_report_table_type_c_y').html($(this).html());$('#advanced_report_table_type_id_c_y').val(0);$('#external_value_options_c_y').slideUp('fast');$('#query_type_holder_c_y').slideUp('fast');" >Internal</div>

									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_table_type_menu_c_y').toggle('fast');$('#active_advanced_report_table_type_c_y').html($(this).html());$('#advanced_report_table_type_id_c_y').val(1);$('#external_value_options_c_y').slideDown('fast');$('#query_type_holder_c_y').slideDown('fast');" >External</div>

								</div>
							</div>
							<input type="hidden" id="advanced_report_table_type_id_c_y" value="0">
						</div>
				
						<div style="width:auto;height:30px;float:left;margin-bottom:5px;margin-left:5px;" id="internal_value_options_c_y"><div style="width:100px;height:30px;line-height:30px;float:left;">Internal column:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="internal_table_item_c_y" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div></div>
						
						<div style="width:auto;height:30px;float:left;margin-left:5px;display:none;" id="query_type_holder_c_y">
							<div style="line-height:30px;width:auto;height:30px;float:left;">Query Type: </div>
							<div style="width:auto;min-height:30px;height:auto;float:left;margin-left:3px;" onclick="$('#error_message').slideUp('fast');">

								<div class="option_item" title="Click to change option" onclick="$('#advanced_report_query_type_menu_c_y').toggle('fast');" id="active_advanced_report_query_type_c_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Claims Tracker</div>
								
								<div class="option_menu" id="advanced_report_query_type_menu_c_y" style="display:none;">
									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_query_type_menu_c_y').toggle('fast');$('#active_advanced_report_query_type_c_y').html($(this).html());$('#advanced_report_query_type_id_c_y').val(1);" >Claims Tracker</div>

									<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#advanced_report_query_type_menu_c_y').toggle('fast');$('#active_advanced_report_query_type_c_y').html($(this).html());$('#advanced_report_query_type_id_c_y').val(0);" >PIPAT Main</div>

								</div>
							</div>
							<input type="hidden" id="advanced_report_query_type_id_c_y" value="1">
						</div>
						
						
						
						<div style="width:60px;height:20px;line-height:20px;background-color:#fee;text-align:center;float:right;cursor:pointer;" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee';" onclick="var c = confirm('Are you sure you wish to remove this entry?');if(c){$('#column_data_c_y').slideUp('fast');$('#advanced_report_operator_c_y_active').val(0);}">Remove</div>

						<div style="margin-left:70px;width:auto;height:auto;float:left;margin-bottom:5px;display:none;" id="external_value_options_c_y">

						
						<div style="width:90px;height:30px;line-height:30px;float:left;">External table:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="external_table_c_y" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>

						<div style="width:100px;height:30px;line-height:30px;float:left;margin-left:5px;">External column:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="external_table_item_c_y" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>

						<div style="width:100px;height:30px;line-height:30px;float:left;margin-left:5px;">Value column:</div>
						<div style="width:100px;height:30px;float:left;"><input type="text" id="external_value_item_c_y" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						
						
						

						<div style="width:100%;min-height:30px;height:auto;float:left;margin-bottom:5px;margin-top:5px;">
						<div style="line-height:30px;width:100px;height:30px;float:left;">Value filter type: </div>
						<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">
					
						<div class="option_item"  title="Click to change option" onclick="$('#value_filter_menu_c_y').toggle('fast');" id="active_value_filter_c_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Non</div>


						<div class="option_menu" id="value_filter_menu_c_y" style="display:none;width:120px;">
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_c_y').toggle('fast');$('#active_value_filter_c_y').html($(this).html());$('#value_filter_id_c_y').val(0);$('#value_filter_holder_c_y').slideUp('fast');" >Non</div>

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_c_y').toggle('fast');$('#active_value_filter_c_y').html($(this).html());$('#value_filter_id_c_y').val(1);$('#value_filter_holder_c_y').slideDown('fast');" >Equal to</div>

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_c_y').toggle('fast');$('#active_value_filter_c_y').html($(this).html());$('#value_filter_id_c_y').val(2);$('#value_filter_holder_c_y').slideDown('fast');" >Not Equal to</div>

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_c_y').toggle('fast');$('#active_value_filter_c_y').html($(this).html());$('#value_filter_id_c_y').val(3);$('#value_filter_holder_c_y').slideDown('fast');" >Less than</div>

							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_filter_menu_c_y').toggle('fast');$('#active_value_filter_c_y').html($(this).html());$('#value_filter_id_c_y').val(4);$('#value_filter_holder_c_y').slideDown('fast');" >Greater than</div>

						</div>
						</div>
						<input type="hidden" id="value_filter_id_c_y" value="0">
						
				
						<div style="width:auto;height:30px;float:left;display:none;" id="value_filter_holder_c_y">
						<div style="width:90px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;">Filter column:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="column_filter_c_y" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						
						<div style="width:70px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;">Value filter:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_filter_c_y" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
						
						
						</div>
						
						<div style="width:100%;min-height:30px;height:auto;float:left;margin-bottom:5px;margin-top:5px;">
						<div style="line-height:30px;width:115px;height:30px;float:left;">Output processing: </div>
						<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

						<div class="option_item" title="Click to change option" onclick="$('#output_processing_menu_c_y').toggle('fast');" id="active_output_processing_c_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Count</div>


						<div class="option_menu" id="output_processing_menu_c_y" style="display:none;">
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_c_y').toggle('fast');$('#active_output_processing_c_y').html($(this).html());$('#output_processing_id_c_y').val(5);" >Values</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_c_y').toggle('fast');$('#active_output_processing_c_y').html($(this).html());$('#output_processing_id_c_y').val(0);" >Count</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_c_y').toggle('fast');$('#active_output_processing_c_y').html($(this).html());$('#output_processing_id_c_y').val(1);" >Sum</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_c_y').toggle('fast');$('#active_output_processing_c_y').html($(this).html());$('#output_processing_id_c_y').val(2);" >Count average</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_c_y').toggle('fast');$('#active_output_processing_c_y').html($(this).html());$('#output_processing_id_c_y').val(3);" >Sum average</div>

						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#output_processing_menu_c_y').toggle('fast');$('#active_output_processing_c_y').html($(this).html());$('#output_processing_id_c_y').val(4);" >Difference average</div>

						</div>
						</div>
						<input type="hidden" id="output_processing_id_c_y" value="0">
						</div>
						
						
						</div>
						</div>
						
						<div style="width:100%;height:30px;float:left;margin-bottom:20px;display:none" id="column_operator_c_y">
							<div style="width:130px;height:30px;margin: 0 auto;margin-bottom:5px;">
								<div style="width:60px;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

									<div class="option_item" title="Click to change option" onclick="$('#operator_menu_c_y').toggle('fast');" id="active_operator_c_y" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;">+</div>


									<div class="option_menu" id="operator_menu_c_y" style="display:none;width:30px;text-align:center;">

										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_c_y').toggle('fast');$('#active_operator_c_y').html($(this).html());$('#operator_c_y').val('+');" >+</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_c_y').toggle('fast');$('#active_operator_c_y').html($(this).html());$('#operator_c_y').val('-');" >-</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_c_y').toggle('fast');$('#active_operator_c_y').html($(this).html());$('#operator_c_y').val('*');" >X</div>
										
										<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick=	"$('#operator_menu_c_y').toggle('fast');$('#active_operator_c_y').html($(this).html());$('#operator_c_y').val('/');" >/</div>
									</div>
								</div>
								<input type="hidden" id="operator_c_y" value="+">
							</div>
						</div>
					
					<input type="hidden" id="advanced_report_operator_c_y_active" value="1">
					</div>
					</div>
			
				<input type="hidden" id="total_operators_c" value="1">
				<div style="width:100%;height:30px;float:left;"><div style="width:90px;height:20px;line-height:20px;float:right;text-align:center;background-color:#ddd;cursor:pointer;margin-top:10px;" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='#ddd';" onclick="add_advanced_report_operator('_c')">Add operator</div></div>
				
				<div style="width:620px;height:30px;float:left;margin-bottom:10px;margin-top:30px;display:none;"><div style="width:auto;height:30px;float:left;margin-bottom:5px;margin-top:5px;">
				<div style="line-height:30px;width:100px;height:30px;float:left;">Dis-aggregation: </div>
				<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

				<div class="option_item" title="Click to change option" onclick="$('#value_disagregation_menu_<?php print($c);?>').toggle('fast');" id="active_value_disagregation_c" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Don't allow dis-aggregation</div>


				<div class="option_menu" id="value_disagregation_menu_c" style="display:none;">

				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_disagregation_menu_c').toggle('fast');$('#active_value_disagregation_c').html($(this).html());$('#value_disagregation_id_c').val(0);$('#value_disagregation_item_c').slideUp('fast');$('#disagregation_item_definitions_c').slideUp('fast');" >Don't allow dis-aggregation</div>

				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#value_disagregation_menu_c').toggle('fast');$('#active_value_disagregation_c').html($(this).html());$('#value_disagregation_id_c').val(1);$('#value_disagregation_item_c').slideDown('fast');$('#disagregation_item_definitions_c').slideDown('fast');" >Allow dis-aggregation</div>

				</div>
				</div>
				<input type="hidden" id="value_disagregation_id_c" value="0">
				</div>

					<div style="width:auto;height:auto;float:left;display:none;" id="value_disagregation_item_c">
						<div style="width:150px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;" >Dis-aggregation column:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_disagregation_column_c" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
					</div>

				</div>

		<div style="width:100%;height:auto;float:left;display:none" id="disagregation_item_definitions_c">
		<div style="width:100%;height:20px;line-height:20px;background-color:#fff1ff;float:left;text-align:center;">Dis-aggregation column definitions</div>


			<div style="width:100%;height:auto;float:left;" id="disagregation_item_definitions_holder_c">
				<div style="width:100%;height:auto;float:left;" id="disagregation_item_definition_c_z">
					<div style="width:auto;height:30px;float:left;margin-bottom:5px;margin-top:5px;">
					<div style="line-height:30px;width:100px;height:30px;float:left;">Definition type: </div>
					<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#error_message').slideUp('fast');">

					<div class="option_item" title="Click to change option" onclick="$('#disagregation_definition_type_menu_c_z').toggle('fast');" id="active_disagregation_definition_type_c_z" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Equal to</div>


					<div class="option_menu" id="disagregation_definition_type_menu_c_z" style="display:none;">

					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#disagregation_definition_type_menu_c_z').toggle('fast');$('#active_disagregation_definition_type_c_z').html($(this).html());$('#disagregation_definition_type_id_c_z').val(0);" >Equal to</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#disagregation_definition_type_menu_c_z').toggle('fast');$('#active_disagregation_definition_type_c_z').html($(this).html());$('#disagregation_definition_type_id_c_z').val(1);" >Greater than</div>

					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#disagregation_definition_type_menu_c_z').toggle('fast');$('#active_disagregation_definition_type_c_z').html($(this).html());$('#disagregation_definition_type_id_c_z').val(2);" >Less than</div>

					</div>
					</div>
					<input type="hidden" id="disagregation_definition_type_id_c_z" value="0">
					</div>

					<div style="width:auto;height:auto;float:left;">
						<div style="width:40px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;" >Value:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_disagregation_c_z" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
					</div>
					
					<div style="width:auto;height:auto;float:left;">
						<div style="width:60px;height:30px;line-height:30px;float:left;margin-left:5px;margin-top:5px;" >Definition:</div>
						<div style="width:100px;height:30px;float:left;margin-top:5px;"><input type="text" id="value_disagregation_definition_c_z" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter text here" onfocus="if(this.value=='Enter text here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter text here';this.style.color='#aaa';}"></div>
					</div>

					<div style="width:60px;text-align:center;color:#fff;line-height:25px;float:left;height:25px;margin-top:7px;margin-left:2px;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor='#ae3b3b';" onmouseout="this.style.backgroundColor='brown'" id="remove_disagregation_item_definition_c_z" onclick="var c = confirm('Are you sure you wish to remove this definition?');if(c){$('#disagregation_item_definition_active_c_z').val(0);$('#disagregation_item_definition_c_z').slideUp('fast');}">Remove</div>
					<input type="hidden" id="disagregation_item_definition_active_c_z" value="1">
				</div>
			</div>
			<input type="hidden" id="total_disagregation_item_definitions_c" value="0">
			<div style="width:40px;margin: 0 auto;height:auto;">
				<div style="width:40px;float:left;height:25px;border:solid 1px #ccc;text-align:center;margin-left:2px;margin-top:7px;line-height:25px;background-color:#ddd;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#ddd';" onclick="add_disagregation_item_definition('_c');">Add</div>
			</div>
		</div>
		<input type="hidden" id="advanced_report_item_c_active" value="1">
		<input type="hidden" id="advanced_report_item_id_c" value="0">
	</div>
	
</div>