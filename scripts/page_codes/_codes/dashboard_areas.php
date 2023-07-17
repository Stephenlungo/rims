<div style="width:100%;min-height:700px;height:auto;float:left;">
<?php

if($this_dashboard_results['show_description']){
	?>
	<div style="width:100%;min-height:15px;line-height:15px;margin-top:10px;text-align:center;font-weight:bold;color:#006bb3"><i><?php print($this_dashboard_results['description']);?></i></div>
	<?php
}

$dashboard_area_array = fetch_db_table('connect','dynamic_dashboard_areas',1,'_order','dashboard_id = '.$dashboard_id);
$dynamic_report_array = fetch_db_table('connect','dynamic_reports',1,'id','module_id = '.$module_id.' and dashboard_id = '.$dashboard_id);
$dynamic_graph_types  = fetch_db_table('connect','dynamic_graph_types',1,'id','');
//$dynamic_graphs  = fetch_db_table('connect','dynamic_graphs',1,'id','');

for($da=0;$da<count($dashboard_area_array['id']);$da++){
	
	$holder_id = $dashboard_id.'_'.$dashboard_area_array['id'][$da];
	
	include 'item_details_sub.php';
	
	
	
	$report_index = array_keys($dynamic_report_array['dashboard_area_id'],$dashboard_area_array['id'][$da]);
	
	$dashboard_area_id = $dashboard_area_array['id'][$da];
	?>
	<input type="hidden" id="real_row_index_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>" value="">
	<input type="hidden" id="area_width_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>" value="<?php print($dashboard_area_array['_width'][$da]);?>">
	
	<input type="hidden" id="area_height_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>" value="<?php print($dashboard_area_array['_height'][$da]);?>">
	
	<div style="width:<?php print($dashboard_area_array['_width'][$da]);?>px;height:<?php print($dashboard_area_array['_height'][$da]);?>px;background-color:#fff;float:left;border:solid 3px #eee;margin:15px;margin-right:0px;padding:5px;display:inline-block;border-radius:20px;">
	
	
	
	<div style="display:none;width:120px;height:<?php print($dashboard_area_array['_height'][$da]+10);?>px;float:left;position:absolute;background-color:#eef;margin-left:-5px;z-index:100;margin-top:-6px;border-radius:15px 0px 30px 15px;" id="area_option_holder_<?php print($dashboard_area_array['id'][$da]);?>"><div style="border-radius:15px 0px 0px 0px;width:100%;height:20px;line-height:20px;text-align:center;font-size:0.9em;background-color:#eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" onclick="$('#area_option_holder_<?php print($dashboard_area_array['id'][$da]);?>').slideToggle('fast');">Graph Options</div>
	
	</div>
	
	<?php
	if($dashboard_area_array['show_title'][$da]){
		?>
		<div style="width:100%;min-height:25px;height:auto;float:left;text-align:center;font-size:1.3em;"><div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;" id="dashboard_area_title_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>"><?php print($dashboard_area_array['title'][$da]);?></div></div>
		<?php
	}
	?>
	
	<?php
	if($dashboard_area_array['show_description'][$da]){
		?>
		<div style="width:100%;min-height:20px;height:auto;float:left;text-align:center;font-size:0.9em;"><i><?php print($dashboard_area_array['description'][$da]);?></i></div>
		
		<?php
	}
	?>
	
	
	<div style="width:100%;height:25px;float:left;">
	
	<?php
	if($dashboard_area_array['show_buttons'][$da]){
			?>
		<div style="display:none;width:auto;float:left;" id="graph_options_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>">
		
		
			<div style="width:25px;height:25px;line-height:14px;font-size:1.5em;position:absolute;cursor:pointer;border:solid 1px #eee;border-radius:10px;text-align:center;" onclick="$('#graph_settings_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideToggle('fast');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to display graph options">...</div>
			
			<div style="width:25px;margin-left:30px;height:25px;line-height:25px;font-size:1.5em;position:absolute;cursor:pointer;border:solid 1px #eee;border-radius:10px;text-align:center;" onclick="fetch_graph_settings($('#selected_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(),0,$('#selected_graph_type_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val(),<?php print($dashboard_id.','.$dashboard_area_id);?>);" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to display graph options">&#9998;</div>
		</div>
	<?php
	}
	?>
	<div style="width:<?php print($dashboard_area_array['_width'][$da] - 180);?>px;margin-left:85px;position:absolute;text-align:center;z-index:0" id="date_space_<?php print($dashboard_id.'_'.$dashboard_area_id);?>"></div>
	
	<?php
	
	if($user_date == $dashboard_area_array['user_date'][$da] || $active_user_roles[8]){
		?>
	
		<div style="width:25px;height:25px;float:right;line-height:20px;cursor:pointer;z-index:2" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='#eee';" title="Click to change graph options"   onclick="fetch_area_details(<?php print($dashboard_area_id);?>)"><img src="imgs/settings_icon.png" style="width:25px;height:25px;"></div>
		
		<div style="width:25px;height:25px;float:right;line-height:20px;cursor:pointer;z-index:2" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='#eee';" title="Click to change graph options"   onclick="fetch_report_details(<?php print($dashboard_id.','.$dashboard_area_id);?>)" id="data_editing_icon_<?php print($dashboard_id.'_'.$dashboard_area_id);?>"><img src="imgs/data_edit_icon.png" style="width:25px;height:25px;" ></div>
	
	<?php
	}
	
	if($dashboard_area_array['show_buttons'][$da]){
	?>
	
		<div style="margin-right:8px;width:25px;height:25px;float:right;line-height:20px;cursor:pointer;z-index:2" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='#eee';" title="Click to change graph options"   onclick="$('#dynamic_report_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>').hide();$('#report_graph_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>').slideDown('fast');$('#graph_options_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideDown('fast');$('#data_editing_icon_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideUp('fast');"><img src="imgs/graph_editing_icon.png" style="width:25px;height:25px;"></div>
		
		<div style="width:25px;margin-right:8px;height:25px;float:right;line-height:20px;cursor:pointer;z-index:2" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='#eee';" title="Click to change graph options"  onclick="$('#report_graph_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>').hide();$('#dynamic_report_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>').slideDown('fast');$('#graph_options_button_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideUp('fast');$('#data_editing_icon_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideDown('fast');"><img src="imgs/graph_data_editing_icon.png" style="width:25px;height:25px;"></div>
		
	<?php
	}
	?>
	
	</div>
	
	
	<div style="overflow:auto;width:<?php print($dashboard_area_array['_width'][$da]);?>px;height:<?php print($dashboard_area_array['_height'][$da]-70);?>px;float:left;text-align:center;"><div style="width:100%;hight:auto;float:left;" id="dynamic_report_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>"><div style="width:100%;height:<?php print($dashboard_area_array['_height'][$da]-70);?>px;font-size:1.3em">Preparing. Wait...</div></div>
<div style="width:100%;hight:auto;float:left;display:none;" id="report_formular_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>"></div>

<div class="general_holder" style="display:none;" id="report_graph_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>"></div>



</div>



	</div>
	
	
	
	<script>
	//var area_variable = new Array(0,0);
	////var area_variable[<?php print($dashboard_id);?>][<?php print($dashboard_area_id);?>] = '';
	if(window.XMLHttpRequest){
		var area_xmlhttp_<?php print($dashboard_id.'_'.$dashboard_area_id);?> = new XMLHttpRequest();
		
	}else{
		var area_xmlhttp_<?php print($dashboard_id.'_'.$dashboard_area_id);?> = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	area_xmlhttp_<?php print($dashboard_id.'_'.$dashboard_area_id);?>.onreadystatechange = function(){
		if(area_xmlhttp_<?php print($dashboard_id.'_'.$dashboard_area_id);?>.readyState == 4 && area_xmlhttp_<?php print($dashboard_id.'_'.$dashboard_area_id);?>.status == 200){
			var response_text = area_xmlhttp_<?php print($dashboard_id.'_'.$dashboard_area_id);?>.responseText;
			var response_array = response_text.split("[]");
			
			if(response_array[0] == 'fetch_report'){
				
				$('#dynamic_report_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').slideDown('fast');
				
			
				$('#dynamic_report_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').html(response_array[3]);
				
					
				/*if($('#report_default_display_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val() == 1){
					
					fetch_dashboard_graph(<?php print($dashboard_id.','.$dashboard_area_array['id'][$da]);?>);
					
				}else{
					alert($('#report_default_display_<?php print($dashboard_id.'_'.$dashboard_area_id);?>').val());
					
				}*/
			}else if(response_array[0] == 'fetch_dashboard_graph'){
				display_infor('report_graph_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>',response_array[5]);
				
				
			}else if(response_array[0] == 'fetch_saved_graph'){		
				fetch_graph_settings(response_array[1],1,response_array[3],response_array[4],response_array[5]);
				
			}else if(response_array[0] == 'fetch_saved_graph_list'){
				display_infor('saved_graphs_holder_'+response_array[1]+'_'+response_array[2],response_array[3]);
		
				
			}else if(response_array[0] == 'fetch_graph_settings'){
				display_infor('item_details_holder_<?php print($dashboard_id.'_'.$dashboard_area_id);?>',response_array[1]);
			}
		}
	}
	</script>
	
	<?php
	
	
	
	if(isset($report_index[0])){
		$this_report_id = $dynamic_report_array['id'][$report_index[0]];
		?>
		
		<script>
			fetch_report(1,<?php print($dashboard_id.','.$dashboard_area_array['id'][$da]);?>);
		</script>
		<?php
	}else{
		$this_report_id = 0;
		
		?>
		<script>
		
		$('#dynamic_report_holder_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>').html('<div style="width:<?php print($dashboard_area_array['_width'][$da]);?>px;height:<?php print($dashboard_area_array['_height'][$da]-80);?>px;line-height:50px;text-align:center;color:#777;font-size:1.1em;"><i>Data-set for this area has not been configured</i></div>');
		</script>
		
		<?php
		
	}
	?>
	<input type="hidden" id="selected_report_<?php print($dashboard_id.'_'.$dashboard_area_id);?>" value="<?php print($this_report_id);?>">
	<?php
	$report_default_display = 0;
	if(isset($report_index[0])){
		if($dynamic_report_array['default_display'][$report_index[0]]){
			$report_default_display = 1;
		}
	}
	?>
	<input type="hidden" id="report_default_display_<?php print($dashboard_id.'_'.$dashboard_area_array['id'][$da]);?>" value="<?php print($report_default_display);?>">
	<?php
}
?>
</div>
