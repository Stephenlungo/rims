<?php
	//print('hi'.$dynamic_graph_id.'-');
	if($dynamic_graph_id){
		$this_dynamic_graph = mysqli_query($connect,"select * from dynamic_graphs where id = $dynamic_graph_id")or die(mysqlI_error($connect));
		
		$this_dynamic_graph_results = mysqli_fetch_array($this_dynamic_graph,MYSQLI_ASSOC);
		
		$rule_string = $this_dynamic_graph_results['rule_string'];
		
		
		$data_source_id = $this_dynamic_graph_results['source_type'];
		$graph_type = $this_dynamic_graph_results['graph_type_option'];
		$graph_size = $this_dynamic_graph_results['graph_size_option'];
		$show_grid = $this_dynamic_graph_results['show_grid'];;
		$show_legend = $this_dynamic_graph_results['show_legend'];;
		$show_title = $this_dynamic_graph_results['show_legend'];;
		
		if($data_source_id){
			$data_source_title = 'Central Database';
			
		}else{
			$data_source_title = 'Data Pool';
			
		}
		
		if($show_grid){
			$show_grid_title = 'Yes';
			
		}else{
			$show_grid_title = 'No';
			
		}
		
		if($show_legend){
			$show_legend_title = 'Yes';
			
		}else{
			$show_legend_title = 'No';
			
		}
		
		if($show_title){
			$show_title_title = 'Yes';
			
		}else{
			$show_title_title = 'No';
			
		}
		
		$graph_title = $this_dynamic_graph_results['title'];		
		if(!$graph_type){
			$graph_type_title = 'Vertical';
			
		}else{
			$graph_type_title = 'Horizontal';

		}
		
	}else{
		$rule_string = '0}1}1}0}#16b1a8';
		
		$data_source_id = 0;
		$data_source_title = 'Data Pool';
	
		$graph_title = 'Bar Graph';
		$graph_size = '200';
		
		$show_grid = 0;
		$show_legend = 0;
		$show_title = 0;
		
		$show_grid_title = 'No';
		$show_legend_title = 'No';
		$show_title_title = 'No';
		
		$graph_type = 0;
		$graph_type_title = 'Vertical';

	}

	$rule_array = explode(']',$rule_string);
	
	//print($dynamic_graph_id);
?>

<input type="hidden" id="this_graph_id_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($dynamic_graph_id);?>">
<input type="hidden" id="js_id_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($js_id);?>">

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Graph Data Source:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#data_source_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');" id="active_data_source_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($data_source_title);?></div>

			<div class="option_menu" id="data_source_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
		
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_source_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_data_source_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_data_source_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(0);">Data Pool</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_source_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_data_source_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_data_source_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(1);">Central Database</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_data_source_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($data_source_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Graph Title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;" value="<?php print($graph_title);?>"  id="graph_name_<?php print($dashboard_id.'_'.$dashboard_area_id);?>"></div>
</div>


<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Graph Type:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#graph_type_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');" id="active_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($graph_type_title);?></div>

			<div class="option_menu" id="graph_type_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
		
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#graph_type_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(0);$('#js_option_id_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val('bar');">Vertical Bar</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#graph_type_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(1);$('#js_option_id_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val('horizontalBar');">Horizontal Bar</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($graph_type);?>">
</div>
</div>

<?php
if(!$graph_type){
	$js_id_option = 'bar';
	
}else{
	$js_id_option = 'horizontalBar';
	
}
?>

<input type="hidden" id="js_option_id_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($js_id_option);?>">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Graph size:</div>
<input type="hidden" id="graph_size_value_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($graph_size);?>">
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;" value="<?php print($graph_size);?>"  id="graph_size_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onfocusout="$('#graph_size_value_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(this.value)"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Show title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#show_title_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');" id="active_show_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($show_title_title);?></div>

			<div class="option_menu" id="show_title_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
		
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#show_title_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_show_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_show_title').val(1);">Yes</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#show_title_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_show_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_show_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(0);">No</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_show_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($show_title);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Show grid:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#show_grid_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');" id="active_show_grid_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($show_grid_title);?></div>

			<div class="option_menu" id="show_grid_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
		
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#show_grid_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_show_grid_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_show_grid_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(1);">Yes</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#show_grid_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_show_grid_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_show_grid_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(0);">No</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_show_grid_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($show_grid);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Show legend:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#show_legend_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');" id="active_show_legend_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($show_legend_title);?></div>

			<div class="option_menu" id="show_legend_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
		
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#show_legend_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_show_legend_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_show_legend_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(1);">Yes</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#show_legend_menu_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_show_legend_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_show_legend_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(0);">No</div>
			
			</div>
	</div>
	<input type="hidden" id="selected_show_legend_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($show_legend);?>">
</div>
</div>

<div style="width:100%;height:20px;line-height:20px;background-color:#fee;text-align:center;float:left;margin-top:15px;margin-bottom:5px;">Filter columns</div>

<div style="width:100%;height:auto;float:left;" id="graph_filters_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">

<input type="hidden" id="selected_graph_filters_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="">
</div>



<div style="width:100%;height:20px;line-height:20px;background-color:#eef;text-align:center;float:left;margin-top:15px;margin-bottom:5px;">Data</div>
<div style="width:100%;height:auto;float:left;" id="data_columns_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">
<?php
	for($c=0;$c<count($rule_array);$c++){
		$this_rule_array = explode('}',$rule_array[$c]);
		?>
		<div style="width:100%;height:auto;float:left;margin-bottom:10px;" id="data_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>_holder">
		<div style="width:70px;height:20px;float:left;line-height:20px;background-color:#ddd;text-align:center;cursor:pointer;" onclick="$('#data_column_content_holder_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').slideToggle('fast');" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#ddd';">Column <?php print($c+1);?></div>
		
		<div style="width:100%;height:auto;border-bottom:solid 1px #eee;float:left;<?php if($c!= count($rule_array)-1){?> display:none;<?php }?>" id="data_column_content_holder_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" >
		<input type="hidden" id="graph_column_active_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="1">
		<div style="width:30px;height:20px;line-height:20px;float:right;background-color:#fee;text-align:center;cursor:pointer;<?php if($c == 0){?> display:none;<?php }?>" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee';" id="data_column_remove_button_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" onclick="$('#data_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>_holder').slideUp('fast');$('#graph_column_active_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').val(0);">X</div>	
			<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
				<div style="width:140px;height:30px;line-height:30px;float:left;">Data Column <?php print($c+1);?>:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

					<div style="width:auto;min-height:30px;height:auto;float:left;">
						<div class="option_item" title="Click to change option" onclick="$('#graph_data_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');" id="active_graph_data_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select option</div>

							<div class="option_menu" id="graph_data_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
							
							</div>
							
							<script>
								var total_columns = Number($('#total_columns_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val());
								
								for(var c=0;c<total_columns;c++){
									if($('#report_view_column_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val() == 0 && $('#report_view_column_value_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val() != 5){
										
										var data_item = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#graph_data_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').toggle(\'fast\');$(\'#active_graph_data_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').html($(this).html());$(\'#selected_graph_data_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').val('+c+');">'+$('#report_view_column_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val()+'</div>';
										
										$('#graph_data_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').append(data_item);
										
										if(c==<?php print($this_rule_array[0]);?>){
											$('#active_graph_data_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').html($('#report_view_column_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val());
											
										}
										
									}else if($('#report_view_column_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val() != 3 && $('#report_view_column_value_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val() != 5){
										var value_item = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#graph_value_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').toggle(\'fast\');$(\'#active_graph_value_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').html($(this).html());$(\'#selected_graph_value_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').val('+c+');">'+$('#report_view_column_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val()+'</div>';
										
										$('#graph_value_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').append(value_item);
										
										if(c==<?php print($this_rule_array[1]);?>){
											$('#active_graph_value_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').html($('#report_view_column_title_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val());
											
										}
										
									}else if($('#report_view_column_value_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c).val() == 5){
										var value_item = '<div style="width:100%;height:20px;float:left;"><input type="checkbox" id="filter_input_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c+'" onchange="if(this.checked){add_to_selection('+c+',\'selected_graph_filters_<?php print($dashboard_id.'_'.$dashboard_area_id);?>\');}else{remove_from_selection('+c+',\'selected_graph_filters_<?php print($dashboard_id.'_'.$dashboard_area_id);?>\');}"><label for="filter_input_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_'+c+'">'+$('#report_view_column_title_'+c).val()+'</label></div>';
										
										$('#graph_filters_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').append(value_item);
										
									}
								}			
							</script>
					</div>
					<input type="hidden" id="selected_graph_data_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_rule_array[0]);?>">
				</div>
			</div>


			<div style="width:100%;height:auto;float:left;margin-bottom:2px;">

				<div style="width:140px;height:30px;line-height:30px;float:left;">Value Column <?php print($c+1);?>:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

					<div style="width:auto;min-height:30px;height:auto;float:left;">
						<div class="option_item" title="Click to change option" onclick="$('#graph_value_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');" id="active_graph_value_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select option</div>

							<div class="option_menu" id="graph_value_column_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
								
							</div>
					</div>
					<input type="hidden" id="selected_graph_value_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_rule_array[1]);?>">
				</div>
			</div>
			
			<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
				<div style="width:140px;height:30px;line-height:30px;float:left;">Show bar value:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

					<div style="width:auto;min-height:30px;height:auto;float:left;">
						<div class="option_item" title="Click to change option" onclick="$('#graph_show_value_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');" id="active_show_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Show</div>

							<div class="option_menu" id="graph_show_value_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#graph_show_value_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');$('#active_show_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').html($(this).html());$('#selected_show_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').val(1);">Show</div>

								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#graph_show_value_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');$('#active_show_value_<?php print($c);?>').html($(this).html());$('#selected_show_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').val(0);">Don't show</div>								
							</div>
					</div>
					<input type="hidden" id="selected_show_value_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_rule_array[2]);?>">
				</div>
			</div>
			
			<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
				<div style="width:140px;height:30px;line-height:30px;float:left;">Bar Overlay:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

					<div style="width:auto;min-height:30px;height:auto;float:left;">
						<div class="option_item" title="Click to change option" onclick="$('#graph_overlay_menu_<?php print($c);?>').toggle('fast');" id="active_overlay_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Don't overlay</div>

							<div class="option_menu" id="graph_overlay_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#graph_overlay_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');$('#active_overlay_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').html($(this).html());$('#selected_overlay_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').val(0);">Don't overlay </div>

								<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#graph_overlay_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');$('#active_overlay_column_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').html($(this).html());$('#selected_overlay_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').val(1);">Overlay </div>								
							</div>
					</div>
					<input type="hidden" id="selected_overlay_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_rule_array[3]);?>">
				</div>
			</div>
			
			<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
				<div style="width:140px;height:30px;line-height:30px;float:left;">Bar color:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

					<div style="width:auto;min-height:30px;height:auto;float:left;">
						<div class="option_item" title="Click to change option" onclick="$('#graph_bar_color_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').toggle('fast');" id="active_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" style="min-width:110px;max-width:280px;width:auto;"></div>

								<script>
								var color_div = '';
									for(var c=0;c<colors.length;c++){
										
										if(c==0){
											$('#active_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').css('background-color',colors[c]);
											$('#selected_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').val(colors[c]);
										}
										
										color_div = color_div+'<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#graph_bar_color_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').toggle(\'fast\');$(\'#active_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').css(\'background-color\',\''+colors[c]+'\');$(\'#selected_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>\').val(\''+colors[c]+'\');" style="background-color:'+colors[c]+'"></div>';
										
										if(colors[c]=='<?php print($this_rule_array[4]);?>'){
											$('#active_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').css('background-color',colors[c]);
											$('#selected_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').val(colors[c]);
										}
									}

									$('#graph_bar_color_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>').html(color_div);								
								</script>
						
							<div class="option_menu" id="graph_bar_color_menu_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" style="display:none;min-width:112px;max-width:280px;width:auto;">
														
							</div>
					</div>
					<input type="hidden" id="selected_bar_color_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$c);?>" value="<?php print($this_rule_array[4]);?>">
				</div>
			</div>
			</div>
		</div>
	<?php
	}
	?>
</div>
<input type="hidden" id="total_data_columns_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print(count($rule_array));?>">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:60px;height:30px;background-color:#ddd;color:#000;text-align:center;line-height:30px;margin-right:5px;margin:0 auto;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#ddd';"  id="client_profile_button" onclick="add_graph_columns(<?php print($dashboard_id.','.$dashboard_area_id);?>);" title="Click to add columns">Add</div>


</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:70px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="graph_generate_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onclick="$('#graph_settings_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideUp('fast');$('#selected_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(1);generate_bar_graph(<?php print($graph_type_id.','.$dashboard_id.','.$dashboard_area_id);?>);" title="Click to generate graph">Generate</div>

<div style="cursor:pointer;width:80px;height:30px;line-height:30px;color:#fff;float:left;background-color:#3ea33e;text-align:center;" onmouseover="this.style.backgroundColor='#6cb46c';" onmouseout="this.style.backgroundColor='#3ea33e';" onclick="save_bar_graph(<?php print($dynamic_graph_id.','.$dashboard_id.','.$dashboard_area_id);?>);">Save</div>

<?php 
if($dynamic_graph_id){
	?>
	<div style="margin-left:5px;cursor:pointer;width:80px;height:30px;line-height:30px;color:#fff;float:left;background-color:#e789d5;text-align:center;" onmouseover="this.style.backgroundColor='#e3a3d7';" onmouseout="this.style.backgroundColor='#e789d5';" onclick="save_bar_graph(0,<?php print($dashboard_id.','.$dashboard_area_id);?>);">Save as new</div>
	
	<div style="margin-left:5px;cursor:pointer;width:80px;height:30px;line-height:30px;color:#fff;float:right;background-color:brown;text-align:center;" onmouseover="this.style.backgroundColor='#bf6666';" onmouseout="this.style.backgroundColor='brown';" onclick="delete_dynamic_graph(<?php print($dynamic_graph_id.','.$dashboard_id.','.$dashboard_area_id);?>);" id="bar_graph_delete_button">Delete</div>
	<?php
}
?>
</div>

<?php
if($loading_style){
	?>
	<script>

	$('#graph_generate_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').click();
	
	</script>
	<?php
}
?>