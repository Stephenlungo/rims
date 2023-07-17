

<div class="general_menu_holder" style="background-color:#fff;border-bottom:solid 1px #eee;">

<div style="width:auto;height:auto;float:left;" id="report_menu_holder">
		<div style="width:90px;height:30px;line-height:30px;float:left;">Select Report:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#report_menu').toggle('fast');" id="active_report" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Standard Data Pool</div>

		<div class="option_menu" id="report_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_menu').toggle('fast');$('#active_report').html($(this).html());$('#selected_report').val(0);fetch_report_formular();">Define New Report</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_menu').toggle('fast');$('#active_report').html($(this).html());$('#selected_report').val('-1');$('#report_settings_button').slideUp('fast');fetch_detailed_list();">Standard Data Pool</div>
			
			
			<?php /*
				$reports = mysqli_query($connect,"select * from dynamic_reports where company_id = $company_id and accessibility = 0 or accessibility = $user_id")or die(mysqli_error($connect));
				
				for($r=0;$r<mysqli_num_rows($reports);$r++){
					$report_results = mysqli_fetch_array($reports,MYSQLI_ASSOC);
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_menu').toggle('fast');$('#active_report').html($(this).html());$('#selected_report').val(<?php print($report_results['id']);?>);$('#report_settings_button').slideDown('fast');$('#dynamic_report_holder').slideDown('fast');$('#report_formular_holder').slideUp('fast');$('#report_settings_holder').slideUp('fast');$('#detailed_list_holder').slideUp('fast');$('#report_live_view').val(0);fetch_report(1);" id="report_<?php print($report_results['id']);?>"><?php print($report_results['title']);?></div>
					<?php
					
					if($report_results['default_report']){
						?>
						<script>
						$('#detailed_list_holder').slideUp('fast');
						$('#report_live_view').val(0);
						
						$('#selected_report').val(<?php print($report_results['id']);?>);
						
						$('#active_report').html('<?php print($report_results['title']);?>');
						fetch_report(1);
						</script>
						<?php
					}
				}	*/		
			?>
			
			
		</div>
		</div>
		<input type="hidden" id="selected_report" value="-1">
	</div>

<div class="tab" style="background-color:#fee;width:120px;float:right;border:solid 1px #ddd;height:25px;line-height:25px;;" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee'" id="advanced_settings_button" onclick="fetch_report_settings()">Advanced Settings</div>

<div class="tab" style="display:none;background-color:#eee;width:100px;float:right;border:solid 1px #ddd;height:25px;line-height:25px;margin-right:3px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee'" id="report_settings_button" onclick="fetch_report_formular();">Report Settings</div>



</div>





<div style="width:100%;hight:auto;float:left;" id="detailed_list_holder">
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="detailed_list_status_bar"></div>

<?php
if($active_user_roles[1]){
	?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="create_new_entry();" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>

<?php
}
?>

</div>

<div style="display:none;cursor:pointer;line-height:20px;width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;background-color:orange;color:#fff;text-align:center;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" id="specific_agent_entries" ondblclick="show_all_agent_entries('Double click to restore report view for all agents')" title="">Showing entries for specific agent. Double click to restore report view for all agents</div>
<div style="display:none;cursor:pointer;line-height:20px;width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;background-color:#bf8080;color:#fff;text-align:center;" onmouseover="this.style.backgroundColor='#d08f8f';" onmouseout="this.style.backgroundColor='#bf8080';" id="showing_less_holder" ondblclick="$(this).slideUp('fast');">We found too many results for your search. To ensure faster processing, we are only showing 100 records. Please narrow down your filters to view the other records</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="detailed_list_header"><div style="width:20px;height:20px;float:left;"><input type="checkbox"></div><div style="width:90px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:55px;height:20px;float:left;margin-right:3px;">Time</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Entry type</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:130px;height:20px;float:left;margin-right:3px;">Site</div><div style="width:120px;height:20px;float:left;margin-right:3px;">Agent</div><div style="width:80px;height:20px;float:left;margin-right:3px;"  onmouseover="this.style.backgroundColor
='#ddf';" onmouseout="this.style.backgroundColor
='#eef';"><div style="width:auto;float:left;" id="results_filter_unit" onclick="$('#filter_unit_holder').toggle('fast');$('#filter_unit_menu').toggle('fast');">Unit</div> <div style="width:15px;height:15px;float:left;display:none;" id="results_filter_unit_icon"><img src="imgs/filter_icon.png" style="width:15px;height:15px;margin-top:2px;margin-left:2px;"></div>

<div style="width:auto;height:auto;float:left;display:none;" id="filter_unit_holder">
	<div class="option_menu" id="filter_unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;margin-left:-23px;margin-top:21px;">
	
	</div>
			<input type="hidden" id="selected_results_filter_unit" value="0">
	</div>



</div><div style="width:125px;height:20px;float:left;margin-right:3px;">Activity</div><div style="width:50px;height:20px;float:left;margin-right:3px;">Number</div><div style="width:90px;height:20px;float:left;margin-right:3px;">Validated by</div><div style="width:80px;height:20px;float:left;margin-right:3px;"></div></div>
<div style="width:100%;hight:auto;float:left;" id="detailed_list_data_holder"></div>
</div>

<div style="width:100%;hight:auto;float:left;display:none;" id="dynamic_report_holder"></div>
<div style="width:100%;hight:auto;float:left;display:none;" id="report_formular_holder"></div>
<div style="width:100%;hight:auto;float:left;display:none;" id="report_settings_holder">advanced settings</div>
<input type="hidden" id="last_entry_id" value="0">
<input type="hidden" id="editing_active" value="0">
<input type="hidden" id="days_worked" value="0">
<input id="last_date" type="hidden" value="0">
<input id="total_records" type="hidden" value="0">
<input id="total_value" type="hidden" value="0">
<input id="report_live_view" type="hidden" value="1">
<input id="active_report" type="hidden" value="0">
<script>
fetch_detailed_list();
freeze_header('detailed_list_header');
if(general_variable_5 != ''){
	$('#specific_agent_entries').slideDown('fast');
}
</script>