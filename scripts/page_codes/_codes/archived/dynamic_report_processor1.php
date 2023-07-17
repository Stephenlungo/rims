<?php
$claims_connect = mysqli_connect('131.153.100.68','pipatzam_pipatza','Francis2010!');
mysqli_query($claims_connect,'use pipatzam_pipat_claims2')or die(mysqli_error($claims_connect));

	

	$search_string = '';
	$primary_column_type = mysqli_query($connect,"select * from dynamic_report_primary_column_types where id = $primary_column_type_id")or die(mysqli_error($connect));
	
	$primary_column_type_results = mysqli_fetch_array($primary_column_type,MYSQLI_ASSOC);
	$reference_column = $primary_column_type_results['reference_table'];
	$data_reference_column = $primary_column_type_results['common_reference_column'];
	
	if($primary_column_type_results['query_type']){
		$query_type = 'claims_connect';
		
	}else{
		$query_type = 'connect';
		
	}
	
	$primary_report_columns = mysqli_query($connect,"select * from dynamic_report_primary_columns where primary_column_type_id = $primary_column_type_id")or die(mysqli_error($connect));
	
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
	
	$full_report_rule_array = explode(',',$report_rule_string);
	$report_rule_array = explode('|',$full_report_rule_array[0]);
	
	?>
		<div style="width:100%;height:20px;float:left;margin-bottom:2px;"><div class="general_button" style="float:left;width:95px;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="export_dynamic_report(<?php print($dashboard_id.','.$dashboard_area_id);?>)" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to export report to excel" id="dynamic_report_export_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">Export to excel</div><div class="general_button" style="margin-left:5px;float:left;width:60px;height:20px;line-height:20px;background-color:#c76dc7;color:#fff;" onclick="fetch_report(1,<?php print($dashboard_id.','.$dashboard_area_id);?>);" onmouseover="this.style.backgroundColor = '#ce81ce';" onmouseout="this.style.backgroundColor = '#c76dc7';" title="Click to export report to excel" id="dynamic_report_export_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">Refresh</div></div>
	<div style="width:975px;min-height:20px;height:auto;line-height:20px;float:left;background-color:#eef;" id="report_column_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">
		<?php
		
		$export_column_string = '';
		$export_row_string = '';
		$column_formating_string = '';
		$total_number = 0;
		
		
		$total_width = 0;
		$total_columns = count($report_rule_array);
		
		for($c=0;$c<count($report_rule_array);$c++){
			$this_rule = explode(']',$report_rule_array[$c]);
			
			$this_column_id = $this_rule[0];
			
			
			for($pc=0;$pc<count($primary_report_column_id_array);$pc++){
				if($this_column_id == $primary_report_column_id_array[$pc]){
					
					$column_titles[$c] = $primary_report_column_title_array[$pc];
					
					if($this_rule[3] == 'i'){
						$this_column_title = $primary_report_column_title_array[$pc];
						
					}else{
						$this_column_title = $primary_report_column_title_array[$pc].' (of '.$column_titles[$this_rule[3]].')';
						
					}
					
					$column_rule_array = explode('|',$primary_report_rule_string_array[$pc]);
					
					
					for($cr=0;$cr<count($column_rule_array);$cr++){
						$this_column_rule = explode(']',$column_rule_array[$cr]);
						$this_column_type = $this_column_rule[10];
						$this_column_value_type = $this_column_rule[9];
						if($this_column_rule[10] == 0 || $this_column_rule[10] == 3){
							$column_alignment = 'left';
								
						}else{
							$column_alignment = 'right';
							
						}
						
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
							
							
							$column_data = mysqli_query($$this_column_query,"select * from $this_column_table where company_id = $company_id $data_search_string $location_string")or die(mysqli_error($$this_column_query).' - '.$this_column_id);
							
							//print($location_string);
							
							$column_data_value_array[$c] = array();
							$column_data_search_column_array[$c] = array();
							$total_count_number[$c] = 0;
							$total_sum_number[$c] = 0;
							
							$table_columns = get_column_names($column_data,0);
							
							for($cd=0;$cd<mysqli_num_rows($column_data);$cd++){
								$column_data_results = mysqli_fetch_array($column_data,MYSQLI_ASSOC);
								
								for($i=0;$i<count($table_columns);$i++){
									$table_array[$c][$table_columns[$i]][$cd] = $column_data_results[$table_columns[$i]];
									
								}
								
								$column_data_value_array[$c][$cd] = $column_data_results[$this_column_rule[5]];
								$column_data_search_column_array[$c][$cd] = $column_data_results[$this_column_search_column];
								
								$total_count_number[$c]++;
								
								if(is_numeric($column_data_results[$this_column_search_column])){
									$total_sum_number[$c] += $column_data_results[$this_column_search_column];
									
								}
							}
							
							
						}
						
						
						
						if($this_column_rule[16] == 1){
							if($this_column_rule[17]){
								$this_comment_column_query = 'claims_connect';
								
							}else{
								$this_comment_column_query = 'connect';
								
							}
							
							$this_comment_column_table = $this_column_rule[18];
							$this_comment_column_search_column = $this_column_rule[19];
							$this_comment_column_search_column_key = $this_column_rule[15];
							$this_comment_column_value_column = $this_column_rule[20];
							
							if($this_column_rule[21]){
								if($this_column_rule[21] == 1){
									$this_comment_operator = ' = ';
									
								}else if($this_column_rule[21] == 2){
									$this_comment_operator = ' != ';
									
								}else if($this_column_rule[21] == 3){
									$this_comment_operator = ' < ';
									
								}else if($this_column_rule[21] == 4){
									$this_comment_operator = ' > ';
									
								}
								
								$data_comment_search_string = ' and '.$this_column_rule[22].' '.$this_comment_operator.' '.$this_column_rule[23];
								
							}else{
								
								$data_comment_search_string = '';
								
							}
							
							$column_comment_data = mysqli_query($$this_comment_column_query,"select * from $this_comment_column_table where company_id = $company_id $data_comment_search_string")or die(mysqli_error($$this_comment_column_query).' - '.$this_column_id);
							
							$column_comment_data_value_array[$this_column_id] = array();
							$column_comment_data_search_column_array[$this_column_id] = array();
							
							for($ccd=0;$ccd<mysqli_num_rows($column_comment_data);$ccd++){
								$column_comment_data_results = mysqli_fetch_array($column_comment_data,MYSQLI_ASSOC);
								
								$column_comment_data_value_array[$this_column_id][$ccd] = $column_comment_data_results[$this_comment_column_value_column];
								$column_comment_data_search_column_array[$this_column_id][$ccd] = $column_comment_data_results[$this_comment_column_search_column];
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
			<div style="width:<?php print($this_rule[2]);?>px;min-height:20px;height:auto;float:left;margin-right:3px;text-align:<?php print($column_alignment);?>"><?php print($this_column_title);?></div>
			<input type="hidden"  id="report_view_column_title_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_column_title);?>">
			<input type="hidden"  id="report_view_column_type_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_column_type);?>">
			<input type="hidden"  id="report_view_column_value_type_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_column_value_type);?>">
			<input type="hidden"  id="report_view_column_total_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="0">
			<input type="hidden"  id="report_view_column_max_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="0">
			<?php
		}
		
		$total_additional_columns = 0;
		if($module_id == 3){
			if(isset($full_report_rule_array[1])){
				$additional_columns = explode('|',$full_report_rule_array[1]);
				
				$clients = mysqli_query($connect,"select * from prep_clients where company_id = $company_id $location_string order by id desc")or die(mysqli_error($connect));
				
				$table_columns = get_column_names($clients,0);
				//print(count($table_columns));
				for($c=0;$c<mysqli_num_rows($clients);$c++){
					$client_results = mysqli_fetch_array($clients,MYSQLI_ASSOC);
				
					for($i=0;$i<count($table_columns);$i++){
						$prep_table_array[$table_columns[$i]][$c] = $client_results[$table_columns[$i]];
						
					}			
				}
				
				$data_sets = mysqli_query($connect,"select * from dynamic_form_data_sets where company_id = $company_id order by _date desc")or dir(mysqlI_error($connect));
				
				$data_set_columns = get_column_names($data_sets,0);
				
				for($ds=0;$ds<mysqli_num_rows($data_sets);$ds++){
					$data_set_results = mysqli_fetch_array($data_sets,MYSQLI_ASSOC);
					
					for($i=0;$i<count($data_set_columns);$i++){
						$data_set_array[$data_set_columns[$i]][$ds] = $data_set_results[$data_set_columns[$i]];
						
					}		
				}
				
				$form_values = mysqli_query($connect,"select * from dynamic_form_values where company_id = $company_id order by _date desc")or die(mysqlI_error($connect));
				
				$form_value_columns = get_column_names($form_values,0);
				for($fv=0;$fv<mysqli_num_rows($form_values);$fv++){
					$dynamic_form_value_results = mysqli_fetch_array($form_values,MYSQLI_ASSOC);
					
					for($i=0;$i<count($form_value_columns);$i++){
						$form_values_array[$form_value_columns[$i]][$fv] = $dynamic_form_value_results[$form_value_columns[$i]];
					}
				}
				
				
				
				$form_options = mysqli_query($connect,"select * from dynamic_form_category_options where company_id = $company_id")or die(mysqli_error($connect));
				$option_id_array = array();
				$option_name_array = array();
				$option_form_id_array = array();
				$option_category_id_array = array();
				for($o=0;$o<mysqli_num_rows($form_options);$o++){
					$option_results = mysqli_fetch_array($form_options,MYSQLI_ASSOC);
					
					$option_id_array[$o] = $option_results['id'];
					$option_name_array[$o] = $option_results['category_title'];
					$option_form_id_array[$o] = $option_results['dynamic_form_id'];
					$option_category_id_array[$o] = $option_results['dynamic_form_category_id'];
				}
				
				$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id")or die(mysqlI_error($connect));
				
				for($df=0;$df<mysqli_num_rows($dynamic_forms);$df++){
					$dynamic_form_results = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
					
					$form_id_array[$df] = $dynamic_form_results['id'];
					$form_name_array[$df] = $dynamic_form_results['form_title'];
				}
				
				$dynamic_form_categories = mysqli_query($connect,"select * from dynamic_form_categories where company_id = $company_id")or die(mysqli_error($connect));			
				for($dfc=0;$dfc<mysqli_num_rows($dynamic_form_categories);$dfc++){
					$dynamic_form_category_results = mysqli_fetch_array($dynamic_form_categories,MYSQLI_ASSOC);
					
					$category_id_array[$dfc] = $dynamic_form_category_results['id'];
					$category_form_id_array[$dfc] = $dynamic_form_category_results['dynamic_form_id'];
					$category_title_array[$dfc] = $dynamic_form_category_results['title'];
				}
				
				
				$total_additional_columns = count($additional_columns);
				for($ac=0;$ac<count($additional_columns);$ac++){
					$this_additional_column_rule = explode('-',$additional_columns[$ac]);
					
					$this_additional_column_value_type = $this_additional_column_rule[2];
					if($this_additional_column_rule[1] == 0){
						$this_alignment = 'right';
						
					}else{
						$this_alignment = 'left';
						$this_additional_column_value_type = 0;
					}
					
					$total_width += 83;
					
					$this_form_field_id = $this_additional_column_rule[0];
					
					$this_option_index = array_keys($option_id_array,$this_form_field_id);
					
					if(!isset($this_option_index[0])){
						
						$field_title = 'Option not found';
					}else{
						$field_category_id = $option_category_id_array[$this_option_index[0]];
						
						$category_index = array_keys($category_id_array,$field_category_id);
						if(!isset($category_index[0])){
							
							$field_category_title = 'Category not found';						
						}else{
							$field_category_title = $category_title_array[$category_index[0]];
							
						}
						
						$form_index = array_keys($form_id_array,$option_form_id_array[$this_option_index[0]]);
						if(!isset($form_index[0])){
							$field_form_title = 'Form not found';
							
						}else{
							$field_form_title = $form_name_array[$form_index[0]];
							$column_form_id_array[$ac] = $form_id_array[$form_index[0]];
						}
						
						
						$field_title = $option_name_array[$this_option_index[0]].' ['.$field_form_title.' - '.$field_category_title.']';
						
					}
					
					if($export_column_string == ''){
							$export_column_string = $field_title;
							
					}else{
						$export_column_string .= '|]'.$field_title;
						
					}
					
					if($column_formating_string == ''){
						$column_formating_string = '0';
						
					}else{
						$column_formating_string .= '|]0';
						
					}
					
					?>
					<div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;text-align:<?php print($this_alignment);?>"><?php print($field_title);?></div>
					
					<input type="hidden"  id="report_view_column_title_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.($total_columns+$ac));?>" value="<?php print($field_title);?>">
					<input type="hidden"  id="report_view_column_type_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.($total_columns+$ac));?>" value="<?php print(!$this_additional_column_rule[1]);?>">
					<input type="hidden"  id="report_view_column_value_type_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.($total_columns+$ac));?>" value="<?php print($this_additional_column_value_type);?>">
					<input type="hidden"  id="report_view_column_total_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.($total_columns+$ac));?>" value="0">
					<input type="hidden"  id="report_view_column_max_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.($total_columns+$ac));?>" value="0">
					
					<?php
				
				}
			}
		}
		?>
		<script>
		var header_width = $('#report_column_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').css('width');
		var header_width = header_width.replace('px','');
		
		if(Number(header_width) < <?php print($total_width+(3 * count($report_rule_array)));?>){
		
			$('#report_column_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').css('width','<?php print($total_width+(3 * count($report_rule_array)));?>px');
			$('#report_data_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').css('width','<?php print($total_width+(3 * count($report_rule_array)));?>px');
			
		}
		
		</script>
		
		<input type="hidden" id="total_columns_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($total_columns+$total_additional_columns);?>">
	
	</div>
	<?php
	
	
	
	
	$entries = mysqli_query($$query_type,"select * from $reference_column where company_id = $company_id ")or die(mysqli_error($$query_type));
	
	$table_columns = get_column_names($entries,0);
	
	$region_key_found = array_keys($table_columns,'region_id');
	$province_key_found = array_keys($table_columns,'province_id');
	$hub_key_found = array_keys($table_columns,'hub_id');
	$site_key_found = array_keys($table_columns,'site_id');
	
	
	$region_check = 0;
	$province_check = 0;
	$hub_check = 0;
	$site_check = 0;
	if(isset($region_key_found[0]) and $region_id){
		$search_string .= ' and (region_id = 0 or region_id = '.$region_id.')';
		
		$region_check = 1;
	}
	
	if(isset($province_key_found[0]) and $province_id){
		$search_string .= ' and (province_id = 0 or province_id = '.$province_id.')';
		
		$province_check = 1;
	}
	
	if(isset($hub_key_found[0]) and $hub_id){
		$search_string .= ' and (hub_id = '.$hub_id.')';
		
		$hub_check = 1;
	}
	
	if(isset($site_key_found[0]) and $site_id){
		$search_string .= ' and (site_id = 0 or site_id = '.$site_id.')';
		
		$site_check = 1;
	}
	$entries = mysqli_query($$query_type,"select * from $reference_column where company_id = $company_id $search_string")or die(mysqli_error($$query_type));
	
	if(!mysqli_num_rows($entries)){
	?>
	<div style="width:100%;height:20px;line-height:20px;text-align:center;color:red;font-weight:bold;">No results were  found</div>
	
	
	<?php
		$total_rows = 0;

	}else{
		?>
		<div style="width:100%;height:auto;float:left;" id="report_data_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">
		
		<?php
		$total_rows = mysqli_num_rows($entries);
		
		$column_data_index = array();
		for($e=0;$e<mysqli_num_rows($entries);$e++){
			$entries_results = mysqli_fetch_array($entries,MYSQLI_ASSOC);
			
			$entry_id = $entries_results['id'];
			
			?>
			
			<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;cursor:normal;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
			
			<?php
				$row_data_string = '';
				for($c=0;$c<count($report_rule_array);$c++){
					$column_data_index[$c] = array();
					$this_rule = explode(']',$report_rule_array[$c]);
					
					$this_column_id = $this_rule[0];
					$this_data_dependancy_ind = $this_rule[3];
					
					for($pc=0;$pc<count($primary_report_column_id_array);$pc++){
						if($this_column_id == $primary_report_column_id_array[$pc]){
							
							$this_primary_column_rules = explode('|',$primary_report_rule_string_array[$pc]);
							
							$this_output = '';
							$this_comment_output = '';
							
							
							for($cr=0;$cr<count($this_primary_column_rules);$cr++){
								$this_primary_rule_array = explode(']',$this_primary_column_rules[$cr]);
								
								if($this_primary_rule_array[10] == 0 || $this_primary_rule_array[10] == 3){
									$this_alignment = 'left';
									
								}else{
									$this_alignment = 'right';
									
								}
								
								
								
								if(!$this_primary_rule_array[0]){
									$this_output = $entries_results[$this_primary_rule_array[1]];
									
								}else{
									if($this_data_dependancy_ind == 'i'){									
										$column_values_array = array_keys($column_data_search_column_array[$c],$entries_results[$this_primary_rule_array[1]]);
										
										$column_index_reference = $c;
										
									}else{
										$column_values_array = $column_data_index[$this_data_dependancy_ind];
										
										for($rr=$this_data_dependancy_ind;$rr>-1;$rr--){
											$check_this_rule = explode(']',$report_rule_array[$rr]);
											if($check_this_rule[3]=='i'){
												$column_index_reference = $rr;
												break;
											}											
										}
									}
									
									
									if($c==1){
										//print($table_array[$c]['client_status'][].'<br>');
										//var_dump($column_values_array);
										//exit;
									}
									

									for($cv=0;$cv<count($column_values_array);$cv++){
										$proceed = 0;
										if(!$this_primary_rule_array[6]){
											$proceed = 1;
											
										}else if(($this_primary_rule_array[6] == 1 and $table_array[$column_index_reference][$this_primary_rule_array[8]][$column_values_array[$cv]] == $this_primary_rule_array[7]) || ($this_primary_rule_array[6] == 2 and $table_array[$column_index_reference][$this_primary_rule_array[8]][$column_values_array[$cv]] != $this_primary_rule_array[7]) || ($this_primary_rule_array[6] == 3 and $table_array[$column_index_reference][$this_primary_rule_array[8]][$column_values_array[$cv]] < $this_primary_rule_array[7]) || ($this_primary_rule_array[6] == 4 and $table_array[$column_index_reference][$this_primary_rule_array[8]][$column_values_array[$cv]] > $this_primary_rule_array[7])){
											//print($report_rule_array[0].'-'.$this_primary_rule_array[7].',');
											$proceed = 1;
											
										}
										
										
										
										
										//print($this_primary_rule_array[6].'-'.$column_values_array[$cv]);
										//print($this_primary_rule_array[7].',');
										if($proceed){
										
											$column_data_index[$c][count($column_data_index[$c])] = $column_values_array[$cv];
										
											if($this_primary_rule_array[9] == 0 || $this_primary_rule_array[9] == 2){
												$this_output++;
												
											}else if($this_primary_rule_array[9] == 1 || $this_primary_rule_array[9] == 3){
												if($this_output === ''){
													$this_output = 0;
												}
												
												$this_output += $column_data_value_array[$c][$column_values_array[$cv]];
														
											}else if($this_primary_rule_array[9] == 5){
												
												if($this_primary_rule_array[26] == 0){
													$this_value = $column_data_value_array[$c][$column_values_array[$cv]];
													
												}else{
													$translation_array = explode(',',$this_primary_rule_array[27]);
													
													for($ta=0;$ta<count($translation_array);$ta++){
														$this_translation_rule = explode('-',$translation_array[$ta]);
														
														if($this_translation_rule[0] == '[ELSE]'){
															$else_index = $ta;
														}
														
														if($column_data_value_array[$c][$column_values_array[$cv]] == $this_translation_rule[0]){
															$this_value = $this_translation_rule[1];
															
														}else if($ta == count($translation_array)-1){
															if(isset($else_index)){
																$else_translation_rule = explode('-',$translation_array[$else_index]);
																
																$this_value = $else_translation_rule[1];
															}
														}
													}
												}
												
												
												if($this_output === ''){
													$this_output = $this_value;
													
												}else{
													$this_output .= ', '.$this_value;
													
												}												
											}
										}										
									}
									
									//print($this_output);
									
									if($this_primary_rule_array[9] == 2){
										$this_output = $total_count_number[$this_column_id] / $this_output;										
										
									}else if($this_primary_rule_array[9] == 3){
										$this_output = $total_sum_number[$this_column_id] / $this_output;
										
									}
								}
								
								if($this_primary_rule_array[12] == 1 || $this_primary_rule_array[12] == 3){
									if($this_primary_rule_array[16] == 0){
										if($this_primary_rule_array[14] == 0){
											$this_comment_output = $entries_results[$this_primary_rule_array[15]];
											
										}else if($this_primary_rule_array[14] == 1){
											$column_comment_values_array = array_keys($column_data_search_column_array[$this_column_id],$entries_results[$this_primary_rule_array[1]]);	
											
											$this_comment_output = '';
											for($ccv=0;$ccv<count($column_comment_values_array);$ccv++){
												if($this_comment_output == ''){
													$this_comment_output = $table_array[$this_column_id][$this_primary_rule_array[15]][$column_comment_values_array[$ccv]];

												}else{
													$this_comment_output .= ', '.$table_array[$this_column_id][$this_primary_rule_array[15]][$column_comment_values_array[$ccv]];
												}
											}
										}
										
									}else{
										//$column_comment_values_array = array_keys($column_comment_data_search_column_array[$this_column_id],$entries_results[$this_primary_rule_array[15]]);
										
										//$column_comment_values_array = array_keys($table_array[$this_column_id][$this_primary_rule_array[15]],$this_primary_rule_array[19]);
										
										$this_comment_output = '';
										for($ta=0;$ta<count($table_array[$this_column_id][$this_primary_rule_array[15]]);$ta++){
											$this_field = $table_array[$this_column_id][$this_primary_rule_array[15]][$ta];
											$column_comment_values_array = array_keys($column_comment_data_search_column_array[$this_column_id],$this_field);
											
											//print(count($column_comment_values_array).'-'.$this_primary_rule_array[15].'-');
											
											for($ccv=0;$ccv<count($column_comment_values_array);$ccv++){
												///if(!isset($added_field[$this_column_id][$this_field])){
													if($this_primary_rule_array[24] == 0 || $this_primary_rule_array[24] == 2){
														$this_comment_output++;
														
													}else if($this_primary_rule_array[24] == 1 || $this_primary_rule_array[24] == 3){
														if($this_comment_output === ''){
															$this_comment_output = 0;
														}
														
														$this_comment_output += $column_comment_data_value_array[$this_column_id][$column_comment_values_array[$ccv]];
																
													}else if($this_primary_rule_array[24] == 5){
														if($this_comment_output === ''){
															$this_comment_output = $column_comment_data_value_array[$this_column_id][$column_comment_values_array[$ccv]];
															
														}else{
															$this_comment_output .= ', '.$column_comment_data_value_array[$this_column_id][$column_comment_values_array[$ccv]];
														}												
													}
													//$added_field[$this_column_id][$this_field] = 1;
												//}												
											}
											
											
										}
									
									}
								}
							}
							
							if($this_output === ''){
								if($this_primary_rule_array[10] == 0){
									$this_output = 'Not found';
								
								}else if($this_primary_rule_array[10] == 1){
									$this_output = 0;
									
								}else if($this_primary_rule_array[10] == 2){
									$this_output = 0;
									
								}else if($this_primary_rule_array[10] == 3){
									$this_output = 'No date provided';
									
								}
								
							}else{
								if($this_primary_rule_array[10] == 1 || $this_primary_rule_array[10] == 2){
									if(!isset($column_total[$c])){
										$column_total[$c] = $this_output;
										$column_max_value[$c] = $this_output;
										
									}else{
										$column_total[$c] += $this_output;
										
										if($this_output > $column_max_value[$c]){
											$column_max_value[$c] = $this_output;
											
										}										
									}									
								}else{
									$column_total[$c] = 0;
									$column_max_value[$c] = 0;
									
								}
							
								if($this_primary_rule_array[10] == 1){
									$this_output = number_format($this_output);
									
								}else if($this_primary_rule_array[10] == 2){
									$this_output = number_format($this_output,2);
									
								}else if($this_primary_rule_array[10] == 3 and $this_output != 'No date provided'){
									$this_output = date('jS M, Y',$this_output);
									
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
					<div style="width:<?php print($this_rule[2]);?>px;min-height:20px;height:auto;float:left;margin-right:3px;text-align:<?php print($this_alignment);?>" onclick="<?php if($this_comment_output == ''){?> alert('No details available'); <?php }else{?> if($('#comment_active_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>').val() == 0){$('#field_comment_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>').fadeIn('fast');$('#comment_active_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>').val(1);}<?php }?>"><?php print($this_output);?>
					
					<div style="text-align:left;width:200px;position:absolute;background-color:#fff;border:solid 1px #006bb3;display:none;" id="field_comment_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>" ondblclick="$('#field_comment_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>').fadeOut('fast');$('#comment_active_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c.'_'.$e);?>').val(0);" title="Double click to close">
					<div style="border-top:solid 1px #fff;width:100%;height:20px;line-height:20px;text-align:center;background-color:#006bb3;color:#fff;">Details<div style="display:none;width:20px;height:20px;line-height:20px;float:right;background-color:brown;text-align:center;cursor:pointer;" onmouseover="this.style.backgroundColor='#ce6767';" onmouseout="this.style.backgroundColor='brown';" onclick="$('#field_comment_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>').fadeOut('fast');">X</div><div style="width:100%;height:20px;line-height:25px;float:left;"><div style="width:80px;height:20px;line-height:20px;background-color:orange;color:#fff;margin:0 auto;margin-top:2px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="copyToClipboard('field_comment_text_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>')">Copy text</div></div></div>
					<div style="width:98.5%;height:auto;float:left;padding:2px;min-height:150px;max-height:300px;overflow:auto;"id="field_comment_text_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$e.'_'.$c);?>"><?php print($this_comment_output);?></div>
					</div></div>
					<input type="hidden" id="report_view_row_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c.'_'.$e);?>" value="<?php print($this_output);?>">
					<input type="hidden" id="comment_active_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c.'_'.$e);?>" value="0">
					<?php
				}
				
				if($module_id == 3){
					if(isset($full_report_rule_array[1])){
						$additional_columns = explode('|',$full_report_rule_array[1]);
						
						
						for($ac=0;$ac<count($additional_columns);$ac++){
							$this_additional_column_rule = explode('-',$additional_columns[$ac]);
							if($this_additional_column_rule[1] == 0){
								$this_alignment = 'right';
								
							}else{
								$this_alignment = 'left';
								
							}
							$this_total_values = 0;
							if(!mysqli_num_rows($clients)){
								$entry_clients = 0;
								
							}else{						
								
								$client_index = array_keys($prep_table_array[$data_reference_column],$entry_id);
								
								//print($data_reference_column);
								for($ci=0;$ci<count($client_index);$ci++){
									$data_set_index = array_keys($data_set_array['client_id'],$prep_table_array['id'][$client_index[$ci]]);
									
									if(isset($data_set_index[0])){
										for($ds=0;$ds<count($data_set_index);$ds++){
											if($data_set_array['dynamic_form_id'][$data_set_index[$ds]] == $column_form_id_array[$ac]){
												
												$data_set_id = $data_set_index[$ds];
												
												break;
											}										
										}
										
										if(isset($data_set_id)){
											$form_value_index = array_keys($form_values_array['client_id'],$prep_table_array['id'][$client_index[$ci]]);
											
											if(isset($form_value_index[0])){
												//$this_total_values = $this_additional_column_rule[0];
												for($vi=0;$vi<count($form_value_index);$vi++){
													if($form_values_array['dynamic_form_category_option_id'][$form_value_index[$vi]] == $this_additional_column_rule[0] and $data_set_id = $form_values_array['dynamic_form_data_set_id'][$form_value_index[$vi]]){
														
														if($this_additional_column_rule[1] == 0){
															$this_total_values++;
															
															if(!isset($column_total[$total_columns+$ac])){
																$column_total[$total_columns+$ac] = $this_total_values;
																$column_max_value[$total_columns+$ac] = $this_total_values;
																
															}else{
																$column_total[$total_columns+$ac] += $this_total_values;
																
																if($this_total_values > $column_max_value[$total_columns+$ac]){
																	$column_max_value[$total_columns+$ac] = $this_total_values;
																	
																}
															}

														}else{
															if($this_total_values === 0){
																$this_total_values = $form_values_array['_value'][$form_value_index[$vi]];
																
															}else{
																$this_total_values .= ', '.$form_values_array['_value'][$form_value_index[$vi]];
															}

															$column_max_value[$total_columns+$ac] = 0;
														}
														
														// = $data_set_id.' - '.$form_values_array['dynamic_form_data_set_id'][$form_value_index[$vi]].' ('.$entry_id.')';
														break;
													}											
												}										
											}
										}
									}
								}
								
								//$entry_clients = count($client_index);
								
							}
							
							if($row_data_string == ''){
								$row_data_string = $this_total_values;
								
							}else{
								$row_data_string .= '|]'.$this_total_values;
								
							}
							
							?>
						<div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;text-align:<?php print($this_alignment);?>" ><?php print($this_total_values);?></div>
						
						<input type="hidden" id="report_view_row_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.($total_columns+$ac).'_'.$e);?>" value="<?php print($this_total_values);?>">
						<input type="hidden" id="comment_active_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.($total_columns+$ac).'_'.$e);?>" value="0">
						
							<?php
							
						}
					}
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
		?>
			</div>
			
			<?php
			for($c1=0;$c1<count($report_rule_array);$c1++){
				
				if(isset($column_total[$c1])){
				
				?>	
				<script>
					$('#report_view_column_total_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c1);?>').val(<?php print($column_total[$c1]);?>);				
					$('#report_view_column_max_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c1);?>').val(<?php print($column_max_value[$c1]);?>);				
				</script>
				<?php
				}
			}
			?>
		
		<?php
		
		if(isset($additional_columns)){
			for($ac=0;$ac<count($additional_columns);$ac++){	
	/*		
				?>	
				<script>
					//$('#report_view_column_total_<?php print($total_columns+$ac);?>').val(<?php print($column_total[$total_columns+$ac]);?>);				
					//$('#report_view_column_max_value_<?php print($total_columns+$ac);?>').val(<?php print($column_max_value[$total_columns+$ac]);?>);				
				</script>
				<?php
				*/
			}
		}
	}
	
	
?>
<input type="hidden" id="total_rows_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($total_rows);?>">
<input type="hidden" id="column_string_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($export_column_string);?>">
<input type="hidden" id="row_string_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($export_row_string);?>">
<input type="hidden" id="column_formating_string_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($column_formating_string);?>">

<?php
if($report_default_display){
	?>
	<script>
		$('#data_editing_icon_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideUp('fast');
		$('#graph_options_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideDown('fast');
	
	</script>
	<?php

}else{
	?>
	<script>
		$('#data_editing_icon_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideDown('fast');
		$('#graph_options_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideUp('fast');
	
	</script>
	<?php
}
?>

<script>
	$('#date_space_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html('<i><?php print(date('jS M, Y',$from_date).' - '.date('jS M, Y',$to_date));?></i>');

	fetch_dashboard_graph(<?php print($dashboard_id.','.$dashboard_area_id);?>);
</script>