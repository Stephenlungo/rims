<div style="width:100%;height:auto;float:left;">

<?php
if(!isset($area_width) || !$dashboard_area_id){
	$area_width = 800;
}

if(!isset($area_height) || !$dashboard_area_id){
	$area_height = 700;
}
?>

<input type="hidden" id="selected_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="0">
<input type="hidden" id="saved_graph_id_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="0">
	<div style="width:<?php print($area_width-2);?>px;height:<?php print($area_height-90);?>px;overflow:auto;float:left;" id="graph_report_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>"><div style="width:100%;height:<?php print($area_height-90);?>px;float:left;line-height:<?php print($area_height-90);?>px;text-align:center;color:#777;font-size:2em;"><canvas style="width:100%;height:100%;z-index:0;" id="report_graph_canvas_<?php print($dashboard_id.'_'.$dashboard_area_id);?>"></canvas></div></div>


	<div style="display:none;margin-top:-50px;border-radius:15px 0px 30px 15px;width:153px;position:absolute;height:<?php print($area_height);?>px;background-color:#eee;border-left:solid 1px #ddd" id="graph_settings_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">
		<div style="width:100%;height:20px;float:left;line-height:20px;text-align:center;background-color:#ddd;border-radius:30px 0px 30px 30px;">Graph Type
		
		<div style="width:20px;height:20px;float:right;background-color:brown;text-align:center;line-height:20px;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#b65f5f'"  onmouseout="this.style.backgroundColor='brown'" title="Click to close graph options" onclick="$('#graph_settings_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideToggle('fast');">X</div>
		</div>
		<?php
		$graph_types = mysqli_query($connect,"select * from dynamic_graph_types where company_id = $company_id")or die(mysqli_error($connect));
		
		for($g=0;$g<mysqli_num_rows($graph_types);$g++){
			$graph_type_results = mysqli_fetch_array($graph_types,MYSQLI_ASSOC);
			
			if($module_connect != 'connect'){
				$img_src = $main_url.'/imgs/'.$graph_type_results['icon_src'];
				
			}else{
				$img_src = $url.'/imgs/'.$graph_type_results['icon_src'];
				
			}
			
			?>
			<div style="width:30px;height:30px;float:left;border:solid 1px #ddd;margin:1px;border-radius:5px;background-color:#fff;cursor:pointer;" onmouseover="this.style.borderColor='orange'" onmouseout="this.style.borderColor='#ddd'" title="<?php print($graph_type_results['title']);?>" ><img src="<?php print($img_src);?>" style="width:80%;height:80%;margin:3px;" onclick="fetch_graph_settings(<?php print($graph_type_results['id']);?>,0,0,<?php print($dashboard_id.','.$dashboard_area_id);?>)" id="graph_type_buttons_<?php print($dashboard_id.'_'.$dashboard_area_id.'_'.$graph_type_results['id']);?>"></div>
			<?php
		}
		?>
		

		<div style="width:100%;height:20px;float:left;line-height:20px;text-align:center;background-color:#ddd;margin-top:10px;">Advanced</div>
		<div style="width:100%;height:20px;line-height:20px;float:left;">
			<input type="checkbox" id="live_graph_data_feed_<?php print($dashboard_id.'_'.$dashboard_area_id);?>"><label for="live_graph_data_feed_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">Live Data Feed</label>
		</div>

		<div style="width:100%;height:20px;float:left;line-height:20px;text-align:center;background-color:#ddd;margin-top:15px;">Saved Graphs</div>
		

	<div style="margin-left:3px;width:auto;height:auto;float:left;">
	<div style="width:90%;margin-left:1px;height:20px;line-height:20px;float:left;margin-top:5px;">Graph Data Source:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_menu').toggle('fast');" id="active_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:140px;max-width:350px;width:auto;color:#4b254f">Central database</div>

		<div class="option_menu" id="graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_menu" style="display:none;min-width:142px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#4b254f';" onclick="$('#graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').toggle('fast');$('#active_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(0);fetch_saved_graph_list(0,<?php print($dashboard_id.','.$dashboard_area_id);?>);" style="color:#4b254f;">Central database</div>
			
			
			<?php
				$reports = mysqli_query($connect,"select * from dynamic_reports where company_id = $company_id and dashboard_id = $dashboard_id and dashboard_area_id = $dashboard_area_id")or die(mysqli_error($connect));
				
				for($r=0;$r<mysqli_num_rows($reports);$r++){
					$report_results = mysqli_fetch_array($reports,MYSQLI_ASSOC);
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#4b254f';" onclick="$('#graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>_menu').toggle('fast');$('#active_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($(this).html());$('#selected_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(<?php print($report_results['id']);?>);fetch_saved_graph_list(<?php print($report_results['id'].','.$dashboard_id.','.$dashboard_area_id);?>);" id="graph_report_<?php print($report_results['id']);?>" style="color:#4b254f;"><?php print($report_results['title']);?></div>
					<?php
				}			
			?>
		</div>
		<script>
			if($('#selected_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val() != 0 && $('#selected_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val() != -1){
				$('#selected_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val($('#selected_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val());
				
				$('#active_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html($('#active_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html());
				
				fetch_saved_graph_list($('#selected_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(),<?php print($dashboard_id.','.$dashboard_area_id);?>);
				
			}else{
				fetch_saved_graph_list(0,<?php print($dashboard_id.','.$dashboard_area_id);?>);
				
			}
		</script>
		</div>
		<input type="hidden" id="selected_graph_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="0">
	</div>
		
		<div style="width:88.5%;height:auto;padding:5px;margin-left:3px;float:left;border:solid 1px #fff;overflow:auto;" id="saved_graphs_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">No saved graphs found</div>
		
	
		
	</div>
		
		<input type="hidden" id="full_graph_view" value="0">
</div>