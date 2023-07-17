<?php
	$dynamic_graphs = mysqli_query($connect,"select * from dynamic_graphs where company_id = $company_id and report_id = $report_id")or die(mysqli_error($connect));
	

	if(!mysqli_num_rows($dynamic_graphs)){
		print('<font color="brown">No saved graphs found</font>');
		
		
	}else{
		
		for($g=0;$g<mysqli_num_rows($dynamic_graphs);$g++){
			$dynamic_graph_results = mysqli_fetch_array($dynamic_graphs,MYSQLI_ASSOC);
			?>
			
			<div style="padding-left:5px;cursor:pointer;width:98%;min-height:25px;height:auto;line-height:25px;float:left;border-bottom:solid 1px #ddd;color:#5c3b60" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" title="Click to view graph" onclick="$('#selected_graph_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(<?php print($dynamic_graph_results['id']);?>);fetch_saved_graph(<?php print($dynamic_graph_results['id'].','.$dynamic_graph_results['report_id'].','.$dynamic_graph_results['dynamic_graph_type'].','.$dashboard_id.','.$dashboard_area_id);?>);$('#graph_settings_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideUp('fast');"><?php print($dynamic_graph_results['title']);?></div>
			
			<?php
			if($dynamic_graph_results['is_default']){
				
				?>
				<script>
					if($('#selected_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val() == <?php print($dynamic_graph_results['report_id']);?>){
						$('#selected_graph_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(<?php print($dynamic_graph_results['id']);?>);
						fetch_saved_graph(<?php print($dynamic_graph_results['id'].','.$dynamic_graph_results['report_id'].','.$dynamic_graph_results['dynamic_graph_type'].','.$dashboard_id.','.$dashboard_area_id);?>);
						
					}
				</script>
				<?php
			}
		}
		
	}
?>