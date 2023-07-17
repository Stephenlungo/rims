<?php	
	$search_string = '';
	$primary_column_type = mysqli_query($$module_connect,"select * from dynamic_report_primary_column_types where id = $primary_column_type_id")or die(mysqli_error($$module_connect));
	
	$primary_column_type_results = mysqli_fetch_array($primary_column_type,MYSQLI_ASSOC);
	$reference_column = $primary_column_type_results['reference_table'];
	
	if($primary_column_type_results['query_type']){
		$query_type = 'claims_connect';
		
	}else{
		$query_type = 'connect';
		
	}
	
	$primary_report_columns = mysqli_query($$module_connect,"select * from dynamic_report_primary_columns where primary_column_type_id = $primary_column_type_id")or die(mysqli_error($$module_connect));
	
	$primary_report_column_title_array = array();
	$primary_report_column_id_array = array();
	$primary_report_column_allow_disaggrartion_array = array();
	$primary_column_disaggregation_rule_array = array();
	$primary_report_disaggregation_column_array = array();
	$primary_report_rule_string_array = array();
	
	for($c=0;$c<mysqli_num_rows($primary_report_columns);$c++){
		$primary_report_column_results = mysqli_fetch_array($primary_report_columns,MYSQLI_ASSOC);
		
		$primary_report_column_id_array[$c] = $primary_report_column_results['id'];
		$primary_report_column_title_array[$c] = $primary_report_column_results['title'];
		
		$primary_report_column_allow_disaggrartion_array[$c] = $primary_report_column_results['allow_disagregation'];
		$primary_column_disaggregation_rule_array[$c] = $primary_report_column_results['column_disaggregation_rules'];
		$primary_report_disaggregation_column_array[$c] = $primary_report_column_results['disagregation_column'];
		$primary_report_rule_string_array[$c] = $primary_report_column_results['rule_string'];
	}
	
	
	$report_rule_array = explode('|',$report_rule_string);
	
	?>
		<div style="width:100%;height:20px;float:left;"><div class="general_button" style="float:left;width:95px;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="export_dynamic_report()" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry" id="dynamic_report_export_button">Export to excel</div></div>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;background-color:#eef;">
		<?php
		
		$export_column_string = '';
		$export_row_string = '';
		$column_formating_string = '';
		$total_number = 0;
		
		
		$total_width = 0;
		for($c=0;$c<count($report_rule_array);$c++){
			$this_rule = explode(']',$report_rule_array[$c]);
			
			$this_column_id = $this_rule[0];
			
			for($pc=0;$pc<count($primary_report_column_id_array);$pc++){
				if($this_column_id == $primary_report_column_id_array[$pc]){
					
					$this_column_title = $primary_report_column_title_array[$pc];
					
					$column_rule_array = explode('|',$primary_report_rule_string_array[$pc]);
					
					for($cr=0;$cr<count($column_rule_array);$cr++){
						$this_column_rule = explode(']',$column_rule_array[$cr]);
						
						if($this_column_rule[0]){
							if($this_column_rule[2]){
								$this_column_query = 'claims_connect';
								
							}else{
								$this_column_query = 'connect';
								
							}
							
							$this_column_table = $this_column_rule[3];
							$this_column_search_column = $this_column_rule[4];
							$this_column_search_column_key = $this_column_rule[1];
							$this_column_value_column = $this_column_rule[5];
							
							if($this_column_rule[6]){
								if($this_column_rule[6] == 1){
									$this_operator = ' = ';
									
								}else if($this_column_rule[6] == 2){
									$this_operator = ' != ';
									
								}else if($this_column_rule[6] == 3){
									$this_operator = ' < ';
									
								}else if($this_column_rule[6] == 4){
									$this_operator = ' > ';
									
								}
								
								$data_search_string = ' and '.$this_column_rule[8].' '.$this_operator.' '.$this_column_rule[7];
								
							}else{
								
								$data_search_string = '';
								
							}
							
							$column_data = mysqli_query($$this_column_query,"select * from $this_column_table where company_id = $company_id $data_search_string")or die(mysqli_error($$this_column_query).' - '.$this_column_id);
							
							$column_data_value_array[$this_column_id] = array();
							$column_data_search_column_array[$this_column_id] = array();
							$total_count_number[$this_column_id] = 0;
							$total_sum_number[$this_column_id] = 0;
							
							for($cd=0;$cd<mysqli_num_rows($column_data);$cd++){
								$column_data_results = mysqli_fetch_array($column_data,MYSQLI_ASSOC);
								
								$column_data_value_array[$this_column_id][$cd] = $column_data_results[$this_column_rule[5]];
								$column_data_search_column_array[$this_column_id][$cd] = $column_data_results[$this_column_search_column];
								
								$total_count_number[$this_column_id]++;
								
								if(is_numeric($column_data_results[$this_column_search_column])){
									$total_sum_number[$this_column_id] += $column_data_results[$this_column_search_column];
									
								}
							}
						}
					}

					break;
				}else if($pc < count($primary_report_column_id_array)-1){
					$this_column_title = 'Column not found';
					
				}			
			}
			
			if($export_column_string == ''){
					$export_column_string = $this_column_title;
					
			}else{
				$export_column_string .= '|]'.$this_column_title;
				
			}
			
			if($column_formating_string == ''){
				$column_formating_string = '0';
				
			}else{
				$column_formating_string .= '|]0';
				
			}
			$total_width += $this_rule[2];
			?>
			<div style="width:<?php print($this_rule[2]);?>px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($this_column_title);?></div>
			
			<?php
		}
		?>
	<script>$('#dynamic_report_holder').css('width','<?php print($total_width+(3 * count($report_rule_array)));?>px');</script>
	</div>
	<?php
	
	
	$entries = mysqli_query($$query_type,"select * from $reference_column where company_id = $company_id $search_string")or die(mysqli_error($$query_type));
	
	if(!mysqli_num_rows($entries)){
	?>
	<div style="width:100%;height:20px;line-height:20px;text-align:center;color:red;font-weight:bold;">No results were  found</div>
	
	
	<?php		
	}else{
		
		
		for($e=0;$e<mysqli_num_rows($entries);$e++){
			$entries_results = mysqli_fetch_array($entries,MYSQLI_ASSOC);
			
			?>
			
			<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;cursor:pointer;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
			
			<?php
				$row_data_string = '';
				for($c=0;$c<count($report_rule_array);$c++){
					$this_rule = explode(']',$report_rule_array[$c]);
					
					$this_column_id = $this_rule[0];
					
					for($pc=0;$pc<count($primary_report_column_id_array);$pc++){
						if($this_column_id == $primary_report_column_id_array[$pc]){
							
							$this_primary_column_rules = explode('|',$primary_report_rule_string_array[$pc]);
							
							$this_output = '';
							
							for($cr=0;$cr<count($this_primary_column_rules);$cr++){
								$this_primary_rule_array = explode(']',$this_primary_column_rules[$cr]);
								
								if(!$this_primary_rule_array[0]){
									$this_output = $entries_results[$this_primary_rule_array[1]];
									
								}else{
									
									$column_values_array = array_keys($column_data_search_column_array[$this_column_id],$entries_results[$this_primary_rule_array[1]]);
									
									
									for($cv=0;$cv<count($column_values_array);$cv++){									
										if($this_primary_rule_array[9] == 0 || $this_primary_rule_array[9] == 2){
											$this_output++;
											
										}else if($this_primary_rule_array[9] == 1 || $this_primary_rule_array[9] == 3){
											if($this_output === ''){
												$this_output = 0;
											}
											
											$this_output += $column_data_value_array[$this_column_id][$column_values_array[$cv]];
													
										}else if($this_primary_rule_array[9] == 5){
											if($this_output === ''){
												$this_output = $column_data_value_array[$this_column_id][$column_values_array[$cv]];
												
											}else{
												$this_output .= ', '.$column_data_value_array[$this_column_id][$column_values_array[$cv]];
												
											}												
										}								
									}
									
									if($this_primary_rule_array[9] == 2){
										$this_output = $total_count_number[$this_column_id] / $this_output;										
										
									}else if($this_primary_rule_array[9] == 3){
										$this_output = $total_sum_number[$this_column_id] / $this_output;
										
									}
									
									/*
									for($tc=0;$tc<count($column_data_value_array[$this_column_id]);$tc++){
										
										if($column_data_search_column_array[$this_column_id][$tc] == $entries_results[$this_primary_rule_array[1]]){
											if($this_primary_rule_array[8] == 0){
												$this_output++;
												
											}else if($this_primary_rule_array[8] == 1){
												$this_output += $column_data_value_array[$this_column_id][$tc];
												
											}else if($this_primary_rule_array[8] == 5){
												if($this_output == 0){
													$this_output = $column_data_value_array[$this_column_id][$tc];
													
												}else{
													$this_output .= ', '.$column_data_value_array[$this_column_id][$tc];
													
												}												
											}
											break;
										}										
									}*/
								}
							}
							break;
						}else if($pc < count($primary_report_column_id_array)-1){
							$this_output = 'Column not found';
							
						}			
					}
					
					if($row_data_string == ''){
						$row_data_string = $this_output;
						
					}else{
						$row_data_string .= '|]'.$this_output;
						
					}
					
					?>
					<div style="width:<?php print($this_rule[2]);?>px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($this_output);?></div>
					
					<?php
				}
				?>
			
			</div>
			
			
			<?php	

			if($row_data_string != ''){
				if($export_row_string == ''){
					$export_row_string = $row_data_string;
					
				}else{
					$export_row_string .= '|}'.$row_data_string;
					
				}					
			}			
		}
	}
	
	
?>

<input type="hidden" id="column_string" value="<?php print($export_column_string);?>">
<input type="hidden" id="row_string" value="<?php print($export_row_string);?>">
<input type="hidden" id="column_formating_string" value="<?php print($column_formating_string);?>">